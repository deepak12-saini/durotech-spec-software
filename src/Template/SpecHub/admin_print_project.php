<?php
use App\Utility\SpecProjectPdf;
$p = $project ?? [];
$pdfUrl = $this->Url->build(['_name' => 'specHubPrint', 'id' => (int)($p['id'] ?? 0)]) . '?pdf=1';
$hubUrl = $this->Url->build(['controller' => 'SpecHub', 'action' => 'admin_projects']);
$sheet = SpecProjectPdf::html($p, false);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= h(($p['code'] ?? '') . ' ' . ($p['name'] ?? 'Specification')) ?></title>
    <style>
        * { box-sizing: border-box; }
        html, body { margin: 0; padding: 0; background: #e8eef4; color: #12233a; font-family: "Segoe UI", Arial, sans-serif; }
        .bar {
            position: sticky; top: 0; z-index: 5;
            display: flex; justify-content: space-between; align-items: center; gap: 12px; flex-wrap: wrap;
            padding: 10px 18px; background: #0b2d4a; color: #fff;
        }
        .bar span { font-size: 13px; opacity: .9; }
        .bar a, .bar button {
            display: inline-block; border: 0; border-radius: 8px; padding: 8px 14px; font-weight: 700;
            cursor: pointer; text-decoration: none; font-size: 13px; background: #fff; color: #0b2d4a;
        }
        .bar .pdf { background: #1d4ed8; color: #fff; }
        .bar .ghost { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,.35); }
        .sheet {
            width: 210mm; min-height: 297mm; margin: 16px auto 40px; background: #fff;
            padding: 16mm 16mm 14mm; box-shadow: 0 8px 28px rgba(15, 23, 42, .12);
        }
        .top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; gap: 12px; }
        .brand { display: inline-flex; align-items: center; gap: 10px; text-decoration: none; }
        .brand-logo { height: 52px; width: auto; display: block; }
        .brand-aus { height: 44px; width: auto; display: block; }
        .hub { font-size: 11px; letter-spacing: .06em; color: #64748b; text-transform: uppercase; }
        h1 { margin: 0 0 8px; font-size: 28px; font-weight: 800; color: #0b2d4a; }
        .draft { display: inline-block; font-size: 11px; font-weight: 800; letter-spacing: .04em; color: #b45309; margin: 0 0 6px; }
        .issued { color: #166534; }
        .meta { margin: 0 0 18px; color: #475569; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 9px 0; border-bottom: 1px solid #e8eef3; vertical-align: top; font-size: 13px; }
        th { text-align: left; width: 38%; font-weight: 700; color: #334155; padding-right: 16px; }
        td a { color: #1d4ed8; word-break: break-all; }
        .empty { color: #94a3b8; }
        .foot { margin-top: 28px; font-size: 10px; color: #94a3b8; }
        @media print {
            html, body { background: #fff; }
            .bar { display: none !important; }
            .sheet { margin: 0; width: auto; min-height: 0; box-shadow: none; padding: 8mm 10mm; }
        }
        @page { margin: 12mm; }
    </style>
</head>
<body>
<div class="bar">
    <span><?= h(($p['code'] ?? '') . ' · ' . ($p['name'] ?? 'Specification')) ?></span>
    <div>
        <button type="button" onclick="window.print()">Print</button>
        <a class="pdf" href="<?= h($pdfUrl) ?>">Download PDF</a>
        <a class="ghost" href="<?= h($hubUrl) ?>">Back to Spec Hub</a>
    </div>
</div>
<?= $sheet ?>
</body>
</html>
