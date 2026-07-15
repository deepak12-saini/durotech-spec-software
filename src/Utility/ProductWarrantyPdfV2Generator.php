<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Product Warranty v2 certificate PDF — same layout as warrant request v2
 * (cover + detail + terms pages 3–4). Data from product_warranty_request.
 */
final class ProductWarrantyPdfV2Generator
{
    public static function certificateFilename(int $id, ?array $log = null): string
    {
        return ProductWarrantyPdfGenerator::certificateFilename($id, $log);
    }

    public static function certificateRelativePath(int $id, ?array $log = null): string
    {
        return ProductWarrantyPdfGenerator::certificateRelativePath($id, $log);
    }

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
            Log::error('ProductWarrantyPdfV2Generator: ' . $e->getMessage());

            return null;
        }
    }

    public static function generateAndSave(int $requestId): bool
    {
        $pdfBinary = self::generatePdfBinary($requestId);
        if ($pdfBinary === null || $pdfBinary === '') {
            return false;
        }

        $dir = ProductWarrantyPdfGenerator::certificateDirectory();
        if (!is_dir($dir) && !@mkdir($dir, 0755, true) && !is_dir($dir)) {
            Log::error('ProductWarrantyPdfV2Generator: cannot create directory ' . $dir);

            return false;
        }

        try {
            $table = TableRegistry::getTableLocator()->get('ProductWarrantyRequests');
            $entity = $table->get($requestId);
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyPdfV2Generator: request not found id ' . $requestId);

            return false;
        }

        $log = $entity->toArray();
        $oldCertificate = trim((string)($entity->certificate ?? ''));

        $filename = ProductWarrantyPdfGenerator::resolveCertificateFilename($requestId, $log, $oldCertificate !== '' ? $oldCertificate : null);
        $fullPath = $dir . $filename;
        if (@file_put_contents($fullPath, $pdfBinary) === false) {
            Log::error('ProductWarrantyPdfV2Generator: failed to write ' . $fullPath);

            return false;
        }

        try {
            $relative = 'pdf/FPDI/' . $filename;
            $entity->certificate = $relative;
            if (!$table->save($entity)) {
                Log::error('ProductWarrantyPdfV2Generator: failed to save certificate path for id ' . $requestId);

                return false;
            }

            if ($oldCertificate !== '' && $oldCertificate !== $relative) {
                $oldPath = WWW_ROOT . str_replace('/', DS, ltrim($oldCertificate, '/'));
                if (is_file($oldPath) && $oldPath !== $fullPath) {
                    @unlink($oldPath);
                }
            }
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyPdfV2Generator ORM save: ' . $e->getMessage());

            return false;
        }

        return true;
    }

    public static function buildHtml(int $requestId): ?string
    {
        try {
            $table = TableRegistry::getTableLocator()->get('ProductWarrantyRequests');
            $entity = $table->get($requestId);
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyPdfV2Generator: request not found id ' . $requestId);

            return null;
        }

        $vars = self::prepareViewVars($entity->toArray());
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
     * Map product_warranty_request row to warrant certificate v2 template variables.
     *
     * @param array<string, mixed> $log
     * @return array<string, mixed>|null
     */
    public static function prepareViewVars(array $log): ?array
    {
        $product = self::normalizeText((string)($log['product'] ?? ''));
        $buildingName = self::normalizeText((string)($log['building_name'] ?? ''));
        $buildingAddress = trim((string)($log['building_address'] ?? ''));
        $areaWarranted = trim((string)($log['area_warranted'] ?? ''));
        $contractCompany = self::normalizeText((string)($log['contract_company_name'] ?? ''));
        $contractName = self::normalizeText((string)($log['contract_name'] ?? ''));

        $projectName = $buildingName;
        if ($projectName === '' && $buildingAddress !== '') {
            $projectName = $buildingAddress;
        }

        $applicator = $contractCompany !== '' ? $contractCompany : $contractName;
        if ($applicator === '') {
            $applicator = self::normalizeText((string)($log['applicator'] ?? ''));
        }

        $serial = self::normalizeText((string)($log['serialnumber'] ?? ''));
        if ($serial === '') {
            $serial = 'PWR-' . str_pad((string)($log['id'] ?? '0'), 4, '0', STR_PAD_LEFT);
        }

        $startDate = self::formatDate($log['start_requested_warranty'] ?? null);
        $endDate = self::formatDate($log['end_requested_warranty'] ?? null);
        $years = self::deriveWarrantyYears($startDate, $endDate);

        $buildingAreaName = trim((string)($log['building_area_name'] ?? ''));
        if ($buildingAreaName === '' && $areaWarranted !== '') {
            $buildingAreaName = $areaWarranted;
        }

        return [
            'logoDataUri' => self::fileToDataUri(WWW_ROOT . 'customdurotech' . DS . 'images' . DS . 'durotech_logo_new.png'),
            'sealDataUri' => self::resolveSealDataUri(),
            'detailHeaderDataUri' => WarrantyCertificateHtmlV2Generator::detailHeaderDataUri(),
            'mapDataUri' => self::fileToDataUri(WWW_ROOT . 'front_theme' . DS . 'images' . DS . 'home' . DS . 'map.png'),
            'coverBgDataUri' => self::fileToDataUri(
                WWW_ROOT . 'pdf' . DS . 'FPDI' . DS . 'warranty_v2_assets' . DS . 'cover_page.png'
            ),
            'warrantyYears' => $years,
            'product' => $product,
            'productLines' => self::wrapLines($product, 76, 3),
            'projectName' => $projectName,
            'applicator' => $applicator,
            'warrantyDate' => self::formatDate($log['sign_date'] ?? $log['dateofpurchase'] ?? null),
            'serialNumber' => $serial,
            'usedAs' => self::normalizeText((string)($log['used_as'] ?? '')),
            'buildingName' => $buildingName,
            'buildingAddress' => $buildingAddress,
            'buildingAreaName' => $buildingAreaName,
            'areaWarranted' => $areaWarranted,
            'applicatorAbn' => self::normalizeText((string)($log['applicator_active_abn'] ?? '')),
            'applicatorAddress' => trim((string)($log['applicator_address'] ?? '')),
            'applicatorContact' => $contractName !== ''
                ? $contractName
                : self::normalizeText((string)($log['applicator_contact'] ?? '')),
            'startDate' => $startDate,
            'endDate' => $endDate,
            'website' => 'www.durotechindustries.com.au',
            'companyName' => defined('SITENAME') ? (string)SITENAME : 'Durotech Industries',
            'includeTermsPages' => false,
        ];
    }

    private static function deriveWarrantyYears(string $startDate, string $endDate): string
    {
        if ($startDate !== '' && $endDate !== '') {
            $startTs = self::parseDateToTimestamp($startDate);
            $endTs = self::parseDateToTimestamp($endDate);
            if ($startTs !== null && $endTs !== null && $endTs > $startTs) {
                $years = (int)round(($endTs - $startTs) / (365.25 * 86400));
                if ($years >= 1 && $years <= 30) {
                    return (string)$years;
                }
            }
        }

        return '10';
    }

    private static function parseDateToTimestamp(string $date): ?int
    {
        $ts = strtotime(str_replace('/', '-', $date));

        return ($ts !== false && $ts > 0) ? $ts : null;
    }

    /**
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
}
