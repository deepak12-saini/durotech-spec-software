<?php
declare(strict_types=1);

namespace App\Service;

/**
 * Anthropic Claude API for DuroEzy-style specification drafts.
 */
class ClaudeSpecService
{
    /**
     * @param array<string, mixed> $context Optional header hints: client_name, company, email, address
     * @return array{success: bool, payload?: array<string, mixed>, error?: string}
     */
    public function generateFromBrief(string $brief, array $context = []): array
    {
        $apiKey = trim((string)(getenv('ANTHROPIC_API_KEY') ?: env('ANTHROPIC_API_KEY')));
        if (strlen($apiKey) >= 2) {
            $first = substr($apiKey, 0, 1);
            $last = substr($apiKey, -1);
            if (($first === '"' && $last === '"') || ($first === "'" && $last === "'")) {
                $apiKey = substr($apiKey, 1, -1);
            }
        }
        if ($apiKey === '') {
            return ['success' => false, 'error' => 'ANTHROPIC_API_KEY is missing in environment.'];
        }

        $model = trim((string)(getenv('CLAUDE_MODEL') ?: env('CLAUDE_MODEL', 'claude-3-5-sonnet-latest')));
        $maxTokens = (int)(getenv('CLAUDE_MAX_TOKENS') ?: env('CLAUDE_MAX_TOKENS', 4096));
        if ($maxTokens < 1024) {
            $maxTokens = 4096;
        }

        $contextBlock = '';
        foreach (['client_name', 'company', 'email', 'address'] as $key) {
            if (!empty($context[$key])) {
                $contextBlock .= ucfirst(str_replace('_', ' ', $key)) . ': ' . trim((string)$context[$key]) . "\n";
            }
        }

        $prompt = "You are a Durotech waterproofing specification assistant for Australian construction projects.\n"
            . "Generate a DuroEzy-style specification draft from the project brief below.\n"
            . "Use professional specification language. Reference Australian Standards (e.g. AS 4654) where appropriate.\n"
            . "Product names should be plausible Durotech-style liquid waterproofing products; the human reviewer will verify all details.\n"
            . "Return STRICT JSON only with this schema (no markdown, no explanation):\n"
            . "{\n"
            . "  \"header\": {\n"
            . "    \"name\": \"\",\n"
            . "    \"email\": \"\",\n"
            . "    \"company\": \"\",\n"
            . "    \"address\": \"\",\n"
            . "    \"subject\": \"\",\n"
            . "    \"specification\": \"\",\n"
            . "    \"date\": \"YYYY-MM-DD\"\n"
            . "  },\n"
            . "  \"comments\": [\"\", \"\"],\n"
            . "  \"products\": [\n"
            . "    {\n"
            . "      \"title\": \"Section title e.g. Podium Deck\",\n"
            . "      \"product\": \"\",\n"
            . "      \"serial\": \"1\",\n"
            . "      \"coverage\": \"\",\n"
            . "      \"coverage_by_pack\": \"\",\n"
            . "      \"Warranty\": \"\",\n"
            . "      \"types\": \"1\"\n"
            . "    }\n"
            . "  ]\n"
            . "}\n"
            . "Rules:\n"
            . "- comments: 1 to 4 short specification notes\n"
            . "- products: 2 to 12 rows; group by section using types (numeric section id as string)\n"
            . "- serial: section.row format e.g. 1, 1.1, 2\n"
            . "- date: today's date if not specified in brief\n"
            . "- subject: typically \"Durotech: External Liquid WPM\"\n\n";
        if ($contextBlock !== '') {
            $prompt .= "Known client/project hints:\n" . $contextBlock . "\n";
        }
        $prompt .= "Project brief:\n" . trim($brief);

        $body = json_encode([
            'model' => $model,
            'max_tokens' => $maxTokens,
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $ch = curl_init('https://api.anthropic.com/v1/messages');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 90);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'x-api-key: ' . $apiKey,
            'anthropic-version: 2023-06-01',
        ]);
        $raw = curl_exec($ch);
        $curlErr = curl_error($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($raw === false || $curlErr) {
            return ['success' => false, 'error' => 'Network error: ' . $curlErr];
        }
        if ($status < 200 || $status >= 300) {
            $apiErr = '';
            $errJson = json_decode((string)$raw, true);
            if (is_array($errJson)) {
                if (!empty($errJson['error']['message']) && is_string($errJson['error']['message'])) {
                    $apiErr = trim($errJson['error']['message']);
                } elseif (!empty($errJson['message']) && is_string($errJson['message'])) {
                    $apiErr = trim($errJson['message']);
                }
            }
            $msg = 'Claude API failed (HTTP ' . $status . ').';
            if ($apiErr !== '') {
                $msg .= ' ' . $apiErr;
            }

            return ['success' => false, 'error' => $msg];
        }

        $json = json_decode((string)$raw, true);
        $text = '';
        if (!empty($json['content'][0]['text']) && is_string($json['content'][0]['text'])) {
            $text = $json['content'][0]['text'];
        }
        if ($text === '') {
            return ['success' => false, 'error' => 'No AI text output received.'];
        }

        $parsed = json_decode($text, true);
        if (!is_array($parsed) && preg_match('/\{.*\}/s', $text, $m)) {
            $parsed = json_decode($m[0], true);
        }
        if (!is_array($parsed)) {
            return ['success' => false, 'error' => 'AI output is not valid JSON.'];
        }

        $validated = $this->normalizePayload($parsed);
        if ($validated === null) {
            return ['success' => false, 'error' => 'AI output missing required header or products.'];
        }

        return ['success' => true, 'payload' => $validated];
    }

    /**
     * @param array<string, mixed> $parsed
     * @return array<string, mixed>|null
     */
    public function normalizePayload(array $parsed): ?array
    {
        $header = isset($parsed['header']) && is_array($parsed['header']) ? $parsed['header'] : [];
        $products = isset($parsed['products']) && is_array($parsed['products']) ? $parsed['products'] : [];
        $comments = isset($parsed['comments']) && is_array($parsed['comments']) ? $parsed['comments'] : [];

        if (empty($products)) {
            return null;
        }

        $normalizedProducts = [];
        foreach ($products as $row) {
            if (!is_array($row)) {
                continue;
            }
            $normalizedProducts[] = [
                'title' => trim((string)($row['title'] ?? 'Section')),
                'product' => trim((string)($row['product'] ?? '')),
                'serial' => trim((string)($row['serial'] ?? '1')),
                'coverage' => trim((string)($row['coverage'] ?? '')),
                'coverage_by_pack' => trim((string)($row['coverage_by_pack'] ?? '')),
                'Warranty' => trim((string)($row['Warranty'] ?? '')),
                'types' => trim((string)($row['types'] ?? '1')),
            ];
        }
        if (empty($normalizedProducts)) {
            return null;
        }

        $normalizedComments = [];
        foreach ($comments as $c) {
            $t = trim((string)$c);
            if ($t !== '') {
                $normalizedComments[] = $t;
            }
        }

        $date = trim((string)($header['date'] ?? ''));
        if ($date === '' || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            $date = date('Y-m-d');
        }

        return [
            'header' => [
                'name' => trim((string)($header['name'] ?? '')),
                'email' => trim((string)($header['email'] ?? '')),
                'company' => trim((string)($header['company'] ?? '')),
                'address' => trim((string)($header['address'] ?? '')),
                'subject' => trim((string)($header['subject'] ?? '')) ?: 'Durotech: External Liquid WPM',
                'specification' => trim((string)($header['specification'] ?? '')),
                'date' => $date,
            ],
            'comments' => $normalizedComments,
            'products' => $normalizedProducts,
        ];
    }

    /**
     * Convert flat products list to DuroEzy section structure for employee_send_v3.
     *
     * @param array<int, array<string, string>> $products
     * @return array<int, array{title: string, rows: array<int, array<string, string>>}>
     */
    public function productsToSections(array $products): array
    {
        $grouped = [];
        $order = [];
        foreach ($products as $row) {
            $typeKey = trim((string)($row['types'] ?? ''));
            if ($typeKey === '') {
                $typeKey = '1';
            }
            if (!isset($grouped[$typeKey])) {
                $grouped[$typeKey] = [
                    'title' => trim((string)($row['title'] ?? 'Section ' . $typeKey)),
                    'rows' => [],
                ];
                $order[] = $typeKey;
            }
            $grouped[$typeKey]['rows'][] = [
                'serial' => (string)($row['serial'] ?? $typeKey),
                'coverage' => (string)($row['coverage'] ?? ''),
                'product' => (string)($row['product'] ?? ''),
                'coverage_by_pack' => (string)($row['coverage_by_pack'] ?? ''),
                'Warranty' => (string)($row['Warranty'] ?? ''),
            ];
        }
        $sections = [];
        foreach ($order as $key) {
            $sections[] = $grouped[$key];
        }

        return $sections;
    }
}
