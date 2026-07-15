<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Datasource\ConnectionManager;
use Cake\Log\Log;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Warrant Request v2 — HTML (Dompdf) certificate generator.
 * Parallel to FPDI warrantyCertificate.php; does not modify the old path.
 */
final class WarrantyCertificateHtmlV2Generator
{
    /**
     * @return string|null PDF binary
     */
    public static function generatePdfBinary(int $requestId): ?string
    {
        $html = self::buildHtml($requestId);
        if ($html === null || $html === '') {
            return null;
        }

        try {
            $options = new Options();
            $options->set('isRemoteEnabled', false);
            $options->set('isHtml5ParserEnabled', true);
            $options->set('chroot', WWW_ROOT);
            $options->set('defaultFont', 'DejaVu Sans');

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();

            $dompdfBinary = $dompdf->output();
            $merged = WarrantyCertificateV2PdfMerger::merge($dompdfBinary);
            if ($merged !== null && $merged !== '') {
                return $merged;
            }

            return $dompdfBinary;
        } catch (\Throwable $e) {
            Log::error('WarrantyCertificateHtmlV2Generator: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Generate, save under webroot/pdf/FPDI/, update warranty_requests.certificate.
     * Optional for phase 2 Approve; Preview uses generatePdfBinary only.
     */
    public static function generateAndSave(int $requestId): bool
    {
        $pdfBinary = self::generatePdfBinary($requestId);
        if ($pdfBinary === null || $pdfBinary === '') {
            return false;
        }

        $dir = WWW_ROOT . 'pdf' . DS . 'FPDI' . DS;
        if (!is_dir($dir) && !@mkdir($dir, 0755, true) && !is_dir($dir)) {
            Log::error('WarrantyCertificateHtmlV2Generator: cannot create ' . $dir);

            return false;
        }

        $meta = self::loadRequestMeta($requestId);
        if ($meta === null) {
            return false;
        }

        $safeUid = preg_replace('/[^a-zA-Z0-9_\-\. ]/', '_', (string)$meta['unique_id']);
        if ($safeUid === '' || $safeUid === null) {
            $safeUid = 'WR-' . $requestId;
        }
        $filename = $safeUid . '-v2.pdf';
        $fullPath = $dir . $filename;

        if (@file_put_contents($fullPath, $pdfBinary) === false) {
            Log::error('WarrantyCertificateHtmlV2Generator: failed to write ' . $fullPath);

            return false;
        }

        try {
            $conn = ConnectionManager::get('default');
            $conn->execute(
                'UPDATE warranty_requests SET certificate = :cert WHERE id = :id',
                ['cert' => $filename, 'id' => $requestId]
            );
        } catch (\Throwable $e) {
            Log::error('WarrantyCertificateHtmlV2Generator DB update: ' . $e->getMessage());

            return false;
        }

        return true;
    }

    public static function buildHtml(int $requestId): ?string
    {
        $vars = self::prepareViewVars($requestId);
        if ($vars === null) {
            return null;
        }

        ob_start();
        extract($vars, EXTR_SKIP);
        include APP . 'Template' . DS . 'Element' . DS . 'warranty_certificate_v2_html.php';
        $html = ob_get_clean();

        return is_string($html) ? $html : null;
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function prepareViewVars(int $requestId): ?array
    {
        $meta = self::loadRequestMeta($requestId);
        if ($meta === null) {
            return null;
        }

        $log = $meta['log'];
        $wr = $meta['request'];
        $uniqueId = (string)$meta['unique_id'];

        $product = self::normalizeText((string)($log['product'] ?? ''));
        $years = self::extractYears((string)($wr['year'] ?? '10 Year'));

        $serial = self::normalizeText((string)($log['serialnumber'] ?? ''));
        if ($serial === '') {
            $serial = self::normalizeText($uniqueId);
        }

        return [
            'logoDataUri' => self::fileToDataUri(WWW_ROOT . 'customdurotech' . DS . 'images' . DS . 'durotech_logo_new.png'),
            'sealDataUri' => self::resolveSealDataUri(),
            'detailHeaderDataUri' => self::detailHeaderDataUri(),
            'mapDataUri' => self::fileToDataUri(WWW_ROOT . 'front_theme' . DS . 'images' . DS . 'home' . DS . 'map.png'),
            'coverBgDataUri' => self::fileToDataUri(
                WWW_ROOT . 'pdf' . DS . 'FPDI' . DS . 'warranty_v2_assets' . DS . 'cover_page.png'
            ),
            'warrantyYears' => $years,
            'product' => $product,
            'productLines' => self::wrapLines($product, 76, 3),
            'projectName' => self::normalizeText((string)($wr['project_name'] ?? '')),
            'applicator' => self::normalizeText((string)($log['applicator'] ?? $log['contract_name'] ?? '')),
            'warrantyDate' => self::formatDate($log['dateofpurchase'] ?? $log['sign_date'] ?? null),
            'serialNumber' => $serial,
            'usedAs' => self::normalizeText((string)($log['used_as'] ?? '')),
            'buildingName' => self::normalizeText((string)($log['building_name'] ?? '')),
            'buildingAddress' => self::normalizeText((string)($log['building_address'] ?? '')),
            'buildingAreaName' => trim((string)($log['building_area_name'] ?? '')),
            'areaWarranted' => trim((string)($log['area_warranted'] ?? '')),
            'applicatorAbn' => self::normalizeText((string)($log['applicator_active_abn'] ?? '')),
            'applicatorAddress' => trim((string)($log['applicator_address'] ?? '')),
            'applicatorContact' => self::normalizeText((string)($log['applicator_contact'] ?? '')),
            'startDate' => self::formatDate($log['start_requested_warranty'] ?? null),
            'endDate' => self::formatDate($log['end_requested_warranty'] ?? null),
            'website' => 'www.durotechindustries.com.au',
            'companyName' => defined('SITENAME') ? (string)SITENAME : 'Durotech Industries',
            'includeTermsPages' => false,
        ];
    }

    /**
     * Word-wrap text into lines for dotted underline rows on the cover card.
     *
     * @return array<int, string>
     */
    private static function wrapLines(string $text, int $width, int $maxLines): array
    {
        $text = trim($text);
        if ($text === '') {
            return [''];
        }
        $words = preg_split('/\s+/u', $text) ?: [];
        $lines = [];
        $current = '';
        foreach ($words as $word) {
            $trial = $current === '' ? $word : $current . ' ' . $word;
            if (mb_strlen($trial) > $width && $current !== '') {
                $lines[] = $current;
                $current = $word;
                if (count($lines) >= $maxLines) {
                    break;
                }
            } else {
                $current = $trial;
            }
        }
        if ($current !== '' && count($lines) < $maxLines) {
            $lines[] = $current;
        } elseif ($current !== '' && count($lines) === $maxLines) {
            $lines[$maxLines - 1] = rtrim($lines[$maxLines - 1] . ' ' . $current);
        }
        while (count($lines) < 2) {
            $lines[] = '';
        }

        return array_slice($lines, 0, $maxLines);
    }

    /**
     * @return array{request: array<string, mixed>, log: array<string, mixed>, unique_id: string}|null
     */
    private static function loadRequestMeta(int $requestId): ?array
    {
        try {
            $conn = ConnectionManager::get('default');
            $wrStmt = $conn->execute(
                'SELECT * FROM warranty_requests WHERE id = :id LIMIT 1',
                ['id' => $requestId]
            );
            $wr = $wrStmt->fetch('assoc');
            if (!$wr) {
                Log::error('WarrantyCertificateHtmlV2Generator: warranty_requests id ' . $requestId . ' not found');

                return null;
            }

            $logStmt = $conn->execute(
                'SELECT * FROM warranty_request_logs WHERE warranty_request_id = :id ORDER BY id DESC LIMIT 1',
                ['id' => $requestId]
            );
            $log = $logStmt->fetch('assoc') ?: [];

            return [
                'request' => $wr,
                'log' => $log,
                'unique_id' => (string)($wr['unique_id'] ?? ('WR-' . $requestId)),
            ];
        } catch (\Throwable $e) {
            Log::error('WarrantyCertificateHtmlV2Generator load: ' . $e->getMessage());

            return null;
        }
    }

    private static function normalizeText(string $text): string
    {
        $text = str_replace(["\r\n", "\r", "\n"], ' ', $text);
        $text = preg_replace('/\s*,\s*/u', ', ', $text) ?? $text;
        $text = preg_replace('/\s+/u', ' ', $text) ?? $text;

        return trim($text);
    }

    /**
     * @param mixed $value
     */
    private static function formatDate($value): string
    {
        $formatted = SafeDate::format('d/m/Y', $value);
        if ($formatted !== '') {
            return $formatted;
        }

        if ($value === null || $value === '') {
            return '';
        }

        return trim((string)$value);
    }

    private static function extractYears(string $yearLabel): string
    {
        if (preg_match('/(\d+)\s*year/i', $yearLabel, $m)) {
            return $m[1];
        }
        if (preg_match('/\d+/', $yearLabel, $m)) {
            return $m[0];
        }

        return '10';
    }

    private static function fileToDataUri(string $path): string
    {
        if (!is_file($path)) {
            return '';
        }
        $mime = mime_content_type($path) ?: 'image/png';
        $data = base64_encode((string)file_get_contents($path));

        return 'data:' . $mime . ';base64,' . $data;
    }

    private static function resolveSealDataUri(): string
    {
        $candidates = [
            WWW_ROOT . 'pdf' . DS . 'FPDI' . DS . 'warranty_v2_assets' . DS . 'australian_made_seal.png',
            WWW_ROOT . 'customdurotech' . DS . 'images' . DS . 'australian_made.png',
            WWW_ROOT . 'customdurotech' . DS . 'images' . DS . 'australian-made.png',
            WWW_ROOT . 'img' . DS . 'australian_made.png',
        ];
        foreach ($candidates as $path) {
            $uri = self::fileToDataUri($path);
            if ($uri !== '') {
                return $uri;
            }
        }

        return '';
    }

    public static function termsPageDataUri(int $page): string
    {
        $path = WWW_ROOT . 'pdf' . DS . 'FPDI' . DS . 'warranty_v2_assets' . DS . 'terms_page_' . $page . '.png';

        return self::fileToDataUri($path);
    }

    public static function detailHeaderDataUri(): string
    {
        $path = WWW_ROOT . 'pdf' . DS . 'FPDI' . DS . 'warranty_v2_assets' . DS . 'detail_page_header.png';

        return self::fileToDataUri($path);
    }
}
