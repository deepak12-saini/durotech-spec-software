<?php
use App\Model\Table\SpecProjectsTable;
$p = $project ?? [];
$fmt = static function ($d) {
    if ($d instanceof \DateTimeInterface) {
        return $d->format('d M Y');
    }
    $s = trim((string)$d);
    return $s === '' || strpos($s, '0000') === 0 ? '' : substr($s, 0, 10);
};
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= h(($p['code'] ?? '') . ' ' . ($p['name'] ?? 'Specification')) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 32px; color: #12233a; }
        h1 { margin-bottom: 4px; }
        .meta { color: #64748b; margin-bottom: 24px; }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; width: 220px; padding: 8px; border-bottom: 1px solid #e2e8f0; color: #64748b; }
        td { padding: 8px; border-bottom: 1px solid #e2e8f0; }
        .note { margin-top: 24px; font-size: 12px; color: #64748b; }
        @media print { button { display: none; } }
    </style>
</head>
<body>
<button onclick="window.print()">Print</button>
<h1><?= h($p['name'] ?? '') ?></h1>
<p class="meta"><?= h($p['code'] ?? '') ?> · Revision <?= h($p['revision'] ?? 'A') ?> · <?= h(SpecProjectsTable::stageLabel((string)($p['stage'] ?? ''))) ?></p>
<table>
    <tr><th>Architect / specifier</th><td><?= h($p['architect'] ?? '') ?></td></tr>
    <tr><th>Location</th><td><?= h($p['location'] ?? '') ?></td></tr>
    <tr><th>Application</th><td><?= h(SpecProjectsTable::applicationLabel((string)($p['application'] ?? ''))) ?></td></tr>
    <tr><th>Area (m²)</th><td><?= h($p['area_m2'] ?? '') ?></td></tr>
    <tr><th>Project owner</th><td><?= h($p['owner'] ?? '') ?></td></tr>
    <tr><th>Follow-up</th><td><?= h($fmt($p['follow_up_on'] ?? '')) ?></td></tr>
    <tr><th>Substrate &amp; site conditions</th><td><?= nl2br(h($p['substrate'] ?? '')) ?></td></tr>
    <tr><th>Proposed product / system</th><td><?= h($p['proposed_system'] ?? '') ?></td></tr>
    <tr><th>Technical document</th><td><?= h($p['document_url'] ?? '') ?></td></tr>
    <tr><th>Scope &amp; notes</th><td><?= nl2br(h($p['scope_notes'] ?? '')) ?></td></tr>
    <tr><th>Technical reviewer</th><td><?= h($p['reviewer'] ?? '') ?></td></tr>
    <tr><th>Review date</th><td><?= h($fmt($p['review_date'] ?? '')) ?></td></tr>
    <tr><th>Review outcome</th><td><?= nl2br(h($p['review_outcome'] ?? '')) ?></td></tr>
</table>
<p class="note">This printout is a project record. It is not an automated technical approval. Systems must be verified against current manufacturer TDS before issue.</p>
</body>
</html>
