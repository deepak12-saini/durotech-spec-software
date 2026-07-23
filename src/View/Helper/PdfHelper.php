<?php
declare(strict_types=1);

namespace App\View\Helper;

use Cake\View\Helper;

/**
 * Build PDF URLs with a filemtime version query so browsers don't keep stale PDFs.
 */
class PdfHelper extends Helper
{
    /**
     * @param string $relativePath Path under webroot, e.g. "dompdf/123-SPEC.pdf" or "uploads/datasheets/x.pdf"
     * @param string|null $baseUrl Absolute site base (defaults to SITEURL)
     * @return string Absolute URL with ?v=mtime
     */
    public function url(string $relativePath, ?string $baseUrl = null): string
    {
        $relativePath = ltrim(str_replace('\\', '/', $relativePath), '/');
        $base = $baseUrl;
        if ($base === null || $base === '') {
            $base = defined('SITEURL') ? (string)SITEURL : '/';
        }
        $base = rtrim($base, '/') . '/';

        $version = time();
        if ($relativePath !== '') {
            $abs = WWW_ROOT . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
            if (is_file($abs)) {
                $version = (int)filemtime($abs);
            }
        }

        $sep = (strpos($relativePath, '?') === false) ? '?' : '&';
        return $base . $relativePath . $sep . 'v=' . $version;
    }
}
