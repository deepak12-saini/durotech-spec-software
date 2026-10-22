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
        <h1>Projects</h1>
        <p>Keep every project, system and technical decision together.</p>
    </div>
    <a class="sh-btn sh-btn-blue js-new-spec" href="#">+ New project</a>
</div>
<div class="sh-banner">Staff workspace — records save to the company database. Product selections require technical verification.</div>
<div class="sh-card">
    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'admin_projects'], 'class' => 'sh-tools']); ?>
        <input type="text" name="q" placeholder="Search projects or architects" value="<?= h($q ?? '') ?>">
        <select name="stage">
            <option value="">All</option>
            <?php foreach (SpecProjectsTable::STAGES as $key => $label) : ?>
                <option value="<?= h($key) ?>" <?= ($stage ?? '') === $key ? 'selected' : '' ?>><?= h($label) ?></option>
            <?php endforeach; ?>
        </select>
        <?php if (!empty($due)) : ?><input type="hidden" name="due" value="1"><?php endif; ?>
        <?php if (!empty($activeOnly)) : ?><input type="hidden" name="active" value="1"><?php endif; ?>
        <button class="sh-btn sh-btn-outline" type="submit">Search</button>
    <?= $this->Form->end(); ?>
    <table class="sh-table">
        <thead>
            <tr>
                <th>Project</th>
                <th>Application</th>
                <th>Owner</th>
                <th>Follow-up</th>
                <th>Stage</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($rows)) : ?>
                <tr><td colspan="6">No projects yet.</td></tr>
            <?php else : ?>
                <?php foreach ($rows as $row) :
                    $st = (string)($row['stage'] ?? 'brief_received');
                    ?>
                <tr>
                    <td>
                        <strong><?= h($row['name'] ?? '') ?></strong><br>
                        <small><?= h($row['architect'] ?? '') ?> · <?= h($row['code'] ?? '') ?></small>
                    </td>
                    <td><?= h(SpecProjectsTable::applicationLabel((string)($row['application'] ?? ''))) ?></td>
                    <td><?= h($row['owner'] ?? '') ?></td>
                    <td><?= h($fmt($row['follow_up_on'] ?? '')) ?></td>
                    <td><span class="sh-pill <?= $stageClass[$st] ?? '' ?>"><?= h(SpecProjectsTable::stageLabel($st)) ?></span></td>
                    <td><a class="sh-btn sh-btn-outline js-open-spec" href="#" data-id="<?= (int)$row['id'] ?>" data-project="<?= h($json($row)) ?>">Open</a></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?= $this->element('spec_hub_backup') ?>
