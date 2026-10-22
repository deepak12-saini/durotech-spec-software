<?php
use App\Model\Table\SpecProjectsTable;
$stageClass = [
    'brief_received' => 'sh-pill-brief',
    'drafting' => 'sh-pill-draft',
    'technical_review' => 'sh-pill-review',
    'issued' => 'sh-pill-issued',
];
$fmt = static function ($d) {
    if ($d instanceof \DateTimeInterface) {
        return $d->format('Y-m-d');
    }
    $s = trim((string)$d);
    return $s === '' || strpos($s, '0000') === 0 ? '' : substr($s, 0, 10);
};
$json = static function (array $row) use ($fmt) {
    $row['follow_up_on'] = $fmt($row['follow_up_on'] ?? '');
    $row['review_date'] = $fmt($row['review_date'] ?? '');
    return json_encode($row);
};
?>
<p class="sh-kicker">Technical services / Specification hub</p>
<div class="sh-top">
    <div>
        <h1>From brief to specification.</h1>
        <p>Keep every project, system and technical decision together.</p>
    </div>
    <a class="sh-btn sh-btn-blue js-new-spec" href="#"><i class="fa fa-plus"></i> New project</a>
</div>
<div class="sh-banner">Staff workspace — records save to the company database. Product selections require technical verification.</div>
<div class="sh-hero">
    <div>
        <div style="font-size:11px;letter-spacing:.08em;opacity:.7;">SPECIFY WITH CLARITY</div>
        <h2>The right detail starts with a complete brief.</h2>
        <p>Track the substrate, application, system and review — in one place.</p>
    </div>
    <a class="sh-btn js-new-spec" href="#">Start a specification</a>
</div>
<div class="sh-stats">
    <div class="sh-stat"><div class="l">Active projects</div><div class="n"><?= (int)($stats['active'] ?? 0) ?></div><div class="l">In the specification pipeline</div></div>
    <div class="sh-stat"><div class="l">Technical review</div><div class="n"><?= (int)($stats['review'] ?? 0) ?></div><div class="l">Awaiting technical decision</div></div>
    <div class="sh-stat"><div class="l">Issued specs</div><div class="n"><?= (int)($stats['issued'] ?? 0) ?></div><div class="l">Recorded as issued</div></div>
    <div class="sh-stat"><div class="l">Follow-ups due</div><div class="n"><?= (int)($stats['due'] ?? 0) ?></div><div class="l">Today or overdue</div></div>
</div>
<div class="sh-grid">
    <div class="sh-card">
        <div class="sh-top" style="margin:0 0 8px;">
            <h2>Next project moves</h2>
            <a href="<?= $this->Url->build(['action' => 'admin_projects']) ?>">All projects</a>
        </div>
        <?php if (empty($moves)) : ?>
            <p class="sh-muted">No open projects yet. Add a project to start the pipeline.</p>
        <?php else : ?>
            <?php foreach ($moves as $row) :
                $st = (string)($row['stage'] ?? 'brief_received');
                ?>
            <div class="sh-move">
                <div>
                    <strong><?= h($row['name'] ?? '') ?></strong><br>
                    <small><?= h(SpecProjectsTable::applicationLabel((string)($row['application'] ?? ''))) ?>
                        <?= $fmt($row['follow_up_on'] ?? '') !== '' ? ' · Follow up ' . h($fmt($row['follow_up_on'])) : '' ?></small>
                </div>
                <a class="sh-btn sh-btn-outline js-open-spec" href="#" data-id="<?= (int)$row['id'] ?>" data-project="<?= h($json($row)) ?>"><?= h(SpecProjectsTable::stageLabel($st)) ?></a>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="sh-card">
        <h2>Before issuing a specification</h2>
        <ol class="sh-check">
            <li>Confirm substrate &amp; site conditions</li>
            <li>Select a verified product system</li>
            <li>Link current technical documents</li>
            <li>Record technical review &amp; revision</li>
        </ol>
    </div>
</div>
<?php foreach (($rows ?? []) as $row) : ?>
    <span class="js-open-spec" data-id="<?= (int)$row['id'] ?>" data-project="<?= h($json($row)) ?>" style="display:none;"></span>
<?php endforeach; ?>
