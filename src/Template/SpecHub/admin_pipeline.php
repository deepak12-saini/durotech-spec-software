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
$columns = $columns ?? [];
?>
<p class="sh-kicker">Technical services / Specification hub</p>
<div class="sh-top">
    <div>
        <h1>Specification pipeline</h1>
        <p>Move a project by opening it and changing Stage.</p>
    </div>
    <a class="sh-btn sh-btn-blue js-new-spec" href="#">+ New project</a>
</div>
<div class="sh-banner">Staff workspace — records save to the company database. Product selections require technical verification.</div>
<div class="sh-kanban">
    <?php foreach (SpecProjectsTable::STAGES as $key => $label) :
        $list = $columns[$key] ?? [];
        ?>
        <div class="sh-col">
            <h3><?= h($label) ?></h3>
            <div class="c"><?= count($list) ?> project<?= count($list) === 1 ? '' : 's' ?></div>
            <?php if ($list === []) : ?>
                <div class="sh-muted">No projects yet</div>
            <?php else : ?>
                <?php foreach ($list as $row) : ?>
                    <div class="sh-ticket">
                        <div class="code"><?= h($row['code'] ?? '') ?> · REV <?= h($row['revision'] ?? 'A') ?></div>
                        <h4><?= h($row['name'] ?? '') ?></h4>
                        <p>
                            <?= h($row['architect'] ?? '') ?><br>
                            <?= h(SpecProjectsTable::applicationLabel((string)($row['application'] ?? ''))) ?><br>
                            <?= h($row['owner'] ?? '') ?>
                            <?= $fmt($row['follow_up_on'] ?? '') !== '' ? ' · ' . h($fmt($row['follow_up_on'])) : '' ?>
                        </p>
                        <a class="sh-btn sh-btn-outline js-open-spec" href="#" data-id="<?= (int)$row['id'] ?>" data-project="<?= h($json($row)) ?>">Open specification</a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
<?= $this->element('spec_hub_backup') ?>
