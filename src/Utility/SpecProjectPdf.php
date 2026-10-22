<?php
declare(strict_types=1);

namespace App\Utility;

use App\Model\Table\SpecProjectsTable;
use Cake\Log\Log;
use Dompdf\Dompdf;
use Dompdf\Options;

final class SpecProjectPdf
{
    /**
     * @param array<string, mixed> $project
     */
    public static function binary(array $project): ?string
    {
        $sheet = self::html($project, true);
        $html = '<!DOCTYPE html><html><head><meta charset="utf-8"><style>
body{margin:0;font-family:DejaVu Sans,Arial,sans-serif;color:#12233a;}
.sheet{padding:8mm 10mm;}
.top{display:table;width:100%;margin-bottom:16px;}
.brand{display:inline-block;text-decoration:none;}
.brand-logo{height:48px;}
.brand-aus{height:40px;margin-left:8px;}
.hub{float:right;font-size:10px;color:#64748b;text-transform:uppercase;padding-top:12px;}
h1{margin:0 0 6px;font-size:24px;color:#0b2d4a;}
.draft{font-size:11px;font-weight:bold;color:#b45309;margin-bottom:6px;}
.issued{color:#166534;}
.meta{margin:0 0 14px;color:#475569;font-size:12px;}
table{width:100%;border-collapse:collapse;}
th,td{padding:8px 0;border-bottom:1px solid #e8eef3;font-size:12px;vertical-align:top;}
th{text-align:left;width:38%;color:#334155;}
.empty{color:#94a3b8;}
.foot{margin-top:22px;font-size:9px;color:#94a3b8;}
a{color:#1d4ed8;}
</style></head><body>' . $sheet . '</body></html>';
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
            Log::error('SpecProjectPdf: ' . $e->getMessage());

            return null;
        }
    }

    public static function logoDataUri(): string
    {
        $path = WWW_ROOT . 'customdurotech' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'durotech_logo_new.png';
        if (!is_file($path)) {
            return '';
        }
        $mime = function_exists('mime_content_type') ? (mime_content_type($path) ?: 'image/png') : 'image/png';

        return 'data:' . $mime . ';base64,' . base64_encode((string)file_get_contents($path));
    }

    public static function ausDataUri(): string
    {
        $path = WWW_ROOT . 'customdurotech' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'australian-owned-logo.png';
        if (!is_file($path)) {
            return '';
        }
        $mime = function_exists('mime_content_type') ? (mime_content_type($path) ?: 'image/png') : 'image/png';

        return 'data:' . $mime . ';base64,' . base64_encode((string)file_get_contents($path));
    }

    /**
     * @param array<string, mixed> $p
     */
    public static function html(array $p, bool $forPdf): string
    {
        $fmt = static function ($d) {
            if ($d instanceof \DateTimeInterface) {
                return $d->format('d M Y');
            }
            $s = trim((string)$d);
            if ($s === '' || strpos($s, '0000') === 0) {
                return '';
            }
            $ts = strtotime(substr($s, 0, 10));

            return $ts ? date('d M Y', $ts) : substr($s, 0, 10);
        };
        $h = static function ($v) {
            return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
        };
        $stage = (string)($p['stage'] ?? '');
        $issued = $stage === 'issued';
        $logo = $forPdf ? self::logoDataUri() : (defined('SITEURL') ? rtrim(SITEURL, '/') . '/customdurotech/images/durotech_logo_new.png' : '/customdurotech/images/durotech_logo_new.png');
        $aus = $forPdf ? self::ausDataUri() : (defined('SITEURL') ? rtrim(SITEURL, '/') . '/customdurotech/images/australian-owned-logo.png' : '/customdurotech/images/australian-owned-logo.png');
        $site = defined('SITEURL') ? rtrim((string)SITEURL, '/') . '/' : 'https://www.durotechindustries.com.au/';
        $rows = [
            ['Architect / specifier', (string)($p['architect'] ?? '')],
            ['Location', (string)($p['location'] ?? '')],
            ['Application', SpecProjectsTable::applicationLabel((string)($p['application'] ?? ''))],
            ['Area (m²)', (string)($p['area_m2'] ?? '')],
            ['Substrate & conditions', (string)($p['substrate'] ?? '')],
            ['Proposed system', (string)($p['proposed_system'] ?? '')],
            ['Technical document', (string)($p['document_url'] ?? '')],
            ['Specification scope', (string)($p['scope_notes'] ?? '')],
            ['Technical reviewer', (string)($p['reviewer'] ?? '')],
            ['Review date', $fmt($p['review_date'] ?? '')],
            ['Review outcome', (string)($p['review_outcome'] ?? '')],
        ];
        $badge = $issued ? 'ISSUED — SUBJECT TO CURRENT TDS' : 'DRAFT — NOT FOR CONSTRUCTION';
        $badgeClass = $issued ? 'draft issued' : 'draft';
        $tr = '';
        foreach ($rows as $row) {
            $text = trim($row[1]);
            $empty = $text === '';
            $cell = $empty ? 'Not recorded' : nl2br($h($text));
            if (!$empty && $row[0] === 'Technical document' && preg_match('#^https?://#i', $text)) {
                $cell = '<a href="' . $h($text) . '">' . $h($text) . '</a>';
            }
            $tr .= '<tr><th>' . $h($row[0]) . '</th><td class="' . ($empty ? 'empty' : '') . '">' . $cell . '</td></tr>';
        }
        $logoImg = $logo !== '' ? '<img class="brand-logo" src="' . $h($logo) . '" alt="Durotech">' : '';
        $ausImg = $aus !== '' ? '<img class="brand-aus" src="' . $h($aus) . '" alt="Australian Owned">' : '';

        return '<div class="sheet">
    <div class="top">
        <a class="brand" href="' . $h($site) . '">' . $logoImg . $ausImg . '</a>
        <div class="hub">Durotech | Specification Hub</div>
    </div>
    <h1>' . $h($p['name'] ?? 'Specification') . '</h1>
    <div class="' . $badgeClass . '">' . $h($badge) . '</div>
    <p class="meta">' . $h($p['code'] ?? '') . ' · Revision ' . $h($p['revision'] ?? 'A') . ' · ' . $h(SpecProjectsTable::stageLabel($stage)) . '</p>
    <table>' . $tr . '</table>
    <p class="foot">This printout is a project record. It is not an automated technical approval. Systems must be verified against current manufacturer TDS before issue.</p>
</div>';
    }
}
