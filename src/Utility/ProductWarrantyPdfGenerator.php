<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * Generates Product Warranty Request Form PDF from HTML (matches website form design).
 */
final class ProductWarrantyPdfGenerator
{
    /**
     * Build certificate filename for a request id.
     */
    public static function certificateFilename(int $id): string
    {
        return 'DTWNTRQ ' . date('y-m') . '-' . str_pad((string)$id, 3, '0', STR_PAD_LEFT) . '.pdf';
    }

    /**
     * Absolute path where certificate PDFs are stored.
     */
    public static function certificateDirectory(): string
    {
        return WWW_ROOT . 'pdf' . DS . 'FPDI' . DS;
    }

    /**
     * Relative web path stored in DB.
     */
    public static function certificateRelativePath(int $id): string
    {
        return 'pdf/FPDI/' . self::certificateFilename($id);
    }

    /**
     * Generate PDF bytes for a product warranty request.
     *
     * @return string|null PDF binary or null on failure
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

            return $dompdf->output();
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyPdfGenerator: ' . $e->getMessage());

            return null;
        }
    }

    /**
     * Generate PDF, save to disk, and update certificate path on the request record.
     */
    public static function generateAndSave(int $requestId): bool
    {
        $pdfBinary = self::generatePdfBinary($requestId);
        if ($pdfBinary === null || $pdfBinary === '') {
            return false;
        }

        $dir = self::certificateDirectory();
        if (!is_dir($dir) && !@mkdir($dir, 0755, true) && !is_dir($dir)) {
            Log::error('ProductWarrantyPdfGenerator: cannot create directory ' . $dir);

            return false;
        }

        $filename = self::certificateFilename($requestId);
        $fullPath = $dir . $filename;
        if (@file_put_contents($fullPath, $pdfBinary) === false) {
            Log::error('ProductWarrantyPdfGenerator: failed to write ' . $fullPath);

            return false;
        }

        try {
            $table = TableRegistry::getTableLocator()->get('ProductWarrantyRequests');
            $entity = $table->get($requestId);
            $relative = self::certificateRelativePath($requestId);
            $entity->certificate = $relative;
            if (!$table->save($entity)) {
                Log::error('ProductWarrantyPdfGenerator: failed to save certificate path for id ' . $requestId);

                return false;
            }
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyPdfGenerator ORM save: ' . $e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * Render HTML for the certificate using request data from DB.
     */
    public static function buildHtml(int $requestId): ?string
    {
        try {
            $table = TableRegistry::getTableLocator()->get('ProductWarrantyRequests');
            $entity = $table->get($requestId);
        } catch (\Throwable $e) {
            Log::error('ProductWarrantyPdfGenerator: request not found id ' . $requestId);

            return null;
        }

        $log = $entity->toArray();
        $vars = self::prepareViewVars($log);

        ob_start();
        extract($vars, EXTR_SKIP);
        include APP . 'Template' . DS . 'Element' . DS . 'product_warranty_certificate_pdf.php';
        $html = ob_get_clean();

        return is_string($html) ? $html : null;
    }

    /**
     * @param array<string, mixed> $log
     * @return array<string, mixed>
     */
    public static function prepareViewVars(array $log): array
    {
        $applicationLines = ['', ''];
        if (!empty($log['application'])) {
            $applicationLines = array_pad(preg_split('/,\s*/', (string)$log['application'], 2), 2, '');
        }

        $addressLines = ['', '', ''];
        if (!empty($log['applicator_address'])) {
            $addressLines = array_pad(preg_split('/\r\n|\r|\n/', (string)$log['applicator_address'], 3), 3, '');
        }

        $headerPath = WWW_ROOT . 'customdurotech' . DS . 'images' . DS . 'Warranty_Header.png';
        $footerPath = self::resolveFooterImagePath();
        $signatureImageDataUri = '';
        if (!empty($log['contractor_signature'])) {
            $signaturePath = WWW_ROOT . 'signature' . DS . (string)$log['contractor_signature'];
            $signatureImageDataUri = self::fileToDataUri($signaturePath);
        }

        return [
            'log' => $log,
            'applicationLines' => $applicationLines,
            'addressLines' => $addressLines,
            'headerImageDataUri' => self::fileToDataUri($headerPath),
            'footerImageDataUri' => self::fileToDataUri($footerPath),
            'signatureImageDataUri' => $signatureImageDataUri,
            'dateOfPurchase' => self::formatDisplayDate($log['dateofpurchase'] ?? null),
            'startWarranty' => self::formatDisplayDate($log['start_requested_warranty'] ?? null),
            'endWarranty' => self::formatDisplayDate($log['end_requested_warranty'] ?? null),
            'signDate' => self::formatDisplayDate($log['sign_date'] ?? null),
            'siteName' => defined('SITENAME') ? (string)SITENAME : 'Durotech Industries',
            'siteUrl' => defined('SITEURL') ? rtrim((string)SITEURL, '/') : '',
        ];
    }

    /**
     * @param mixed $value
     */
    private static function formatDisplayDate($value): string
    {
        $formatted = SafeDate::format('d/m/Y', $value);
        if ($formatted !== '') {
            return $formatted;
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

    private static function resolveFooterImagePath(): string
    {
        // Use white footer image only — never Warranty_Footer.png (black background).
        $whiteFooter = WWW_ROOT . 'customdurotech' . DS . 'images' . DS . 'Warranty_Footer_White.png';
        if (is_file($whiteFooter)) {
            return $whiteFooter;
        }

        return '';
    }
}
