<?php
declare(strict_types=1);

namespace App\Utility;

use Cake\Log\Log;
use setasign\Fpdi\Fpdi;

/**
 * Merge Dompdf pages 1–2 with vector terms pages 3–4 from the legacy warranty PDF template.
 * Avoids low-resolution PNG upscaling (blurry terms text in Dompdf).
 */
final class WarrantyCertificateV2PdfMerger
{
    private const TERMS_TEMPLATE = '10_year_pdf.pdf';

    /**
     * @return string|null Merged PDF binary
     */
    public static function merge(string $dompdfBinary, int $frontPageCount = 2, ?string $termsTemplatePath = null): ?string
    {
        if ($dompdfBinary === '') {
            return null;
        }

        if (!class_exists(Fpdi::class, true)) {
            Log::error('WarrantyCertificateV2PdfMerger: setasign\\Fpdi\\Fpdi not available');

            return null;
        }

        $termsPath = $termsTemplatePath ?? self::resolveTermsTemplatePath();
        if ($termsPath === null) {
            Log::error('WarrantyCertificateV2PdfMerger: no usable terms PDF template (need 4+ pages)');

            return null;
        }

        $tmpFront = tempnam(sys_get_temp_dir(), 'wc2f_');
        if ($tmpFront === false) {
            return null;
        }

        if (@file_put_contents($tmpFront, $dompdfBinary) === false) {
            @unlink($tmpFront);

            return null;
        }

        try {
            $pdf = new Fpdi('P');

            $frontPages = (int)$pdf->setSourceFile($tmpFront);
            $take = min(max(1, $frontPageCount), $frontPages);
            for ($i = 1; $i <= $take; $i++) {
                self::importTemplatePage($pdf, $i);
            }

            $termsPages = (int)$pdf->setSourceFile($termsPath);
            for ($i = 3; $i <= min(4, $termsPages); $i++) {
                self::importTemplatePage($pdf, $i);
            }

            return $pdf->Output('S');
        } catch (\Throwable $e) {
            Log::error('WarrantyCertificateV2PdfMerger: ' . $e->getMessage());

            return null;
        } finally {
            @unlink($tmpFront);
        }
    }

    public static function resolveTermsTemplatePath(): ?string
    {
        $dir = WWW_ROOT . 'pdf' . DS . 'FPDI' . DS;
        $candidates = [
            $dir . self::TERMS_TEMPLATE,
            $dir . 'warranty form - 10 years.pdf',
            $dir . '10_Years_Warranty_Form.pdf',
        ];

        foreach ($candidates as $path) {
            if (!is_file($path)) {
                continue;
            }
            try {
                $probe = new Fpdi('P');
                $pages = (int)$probe->setSourceFile($path);
                if ($pages >= 4) {
                    return $path;
                }
            } catch (\Throwable $e) {
                continue;
            }
        }

        return null;
    }

    private static function importTemplatePage(Fpdi $pdf, int $pageNumber): void
    {
        $tpl = $pdf->importPage($pageNumber);
        $size = $pdf->getTemplateSize($tpl);
        $orientation = ($size['orientation'] ?? 'P') === 'L' ? 'L' : 'P';
        $pdf->AddPage($orientation, [$size['width'], $size['height']]);
        $pdf->useTemplate($tpl);
    }
}
