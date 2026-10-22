<?php
use App\Model\Table\SpecProjectsTable;
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
        <h1>Technical documents</h1>
        <p>Keep every project, system and technical decision together.</p>
    </div>
    <a class="sh-btn sh-btn-blue js-new-spec" href="#">+ New project</a>
</div>
<div class="sh-banner">Staff workspace — records save to the company database. Product selections require technical verification.</div>
<div class="sh-card">
    <div class="sh-top" style="margin:0 0 10px;">
        <h2>Project technical documents</h2>
        <small>Linked through each project</small>
    </div>
    <p class="sh-hint">Attach the current manufacturer document to each project. No product performance data has been assumed or pre-approved.</p>
    <?php if (empty($rows)) : ?>
        <p class="sh-muted">No projects yet.</p>
    <?php else : ?>
        <table class="sh-table">
            <tbody>
                <?php foreach ($rows as $row) :
                    $sys = trim((string)($row['proposed_system'] ?? ''));
                    $doc = trim((string)($row['document_url'] ?? ''));
                    ?>
                <tr>
                    <td>
                        <strong><?= h($row['name'] ?? '') ?></strong><br>
                        <small><?= $sys !== '' ? h($sys) : 'System not selected' ?> · Rev <?= h($row['revision'] ?? 'A') ?></small>
                    </td>
                    <td>
                        <?php if ($doc === '') : ?>
                            <span class="sh-warn">Document required</span>
                        <?php else : ?>
                            <a href="<?= h($doc) ?>" target="_blank">Open document</a>
                        <?php endif; ?>
                    </td>
                    <td><a class="sh-btn sh-btn-outline js-open-spec" href="#" data-id="<?= (int)$row['id'] ?>" data-project="<?= h($json($row)) ?>">Edit</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?= $this->element('spec_hub_backup') ?>
<p class="sh-note">Proposed systems must be reviewed against current manufacturer TDS, project conditions and applicable requirements before issue. Reviewer names are recorded entries, not automated approvals.</p>
