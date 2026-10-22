<?php
use App\Utility\SpecRequestDraft;
use App\Utility\SpecRequestOptions;
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
    unset($row['request_json'], $row['request_decoded'], $row['spec_project_areas']);
    return json_encode($row);
};
$selected = $selected ?? null;
$decoded = is_array($selected['request_decoded'] ?? null) ? $selected['request_decoded'] : [];
$base = defined('SITEURL') ? rtrim(SITEURL, '/') . '/' : '/';
?>
<p class="sh-kicker">Technical services / Specification hub</p>
<div class="sh-top">
    <div>
        <h1>Josh &amp; management</h1>
        <p>Customer specification requests land here at Brief received.</p>
    </div>
    <a class="sh-btn sh-btn-blue js-new-spec" href="#">Open Spec Hub project</a>
</div>
<div class="sh-grid">
    <div class="sh-card">
        <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'admin_requests'], 'class' => 'sh-tools']); ?>
            <input type="text" name="q" placeholder="Search project name, DSP code or email" value="<?= h($q ?? '') ?>">
            <select name="status">
                <option value="">All statuses</option>
                <?php foreach ($requestStatuses as $key => $label) : ?>
                    <option value="<?= h($key) ?>" <?= ($status ?? '') === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                <?php endforeach; ?>
            </select>
            <button class="sh-btn sh-btn-outline" type="submit">Search</button>
        <?= $this->Form->end(); ?>
        <?php if (empty($rows)) : ?>
            <p class="sh-muted">No customer requests yet.</p>
        <?php else : ?>
            <table class="sh-table">
                <thead>
                    <tr><th>Code</th><th>Project</th><th>Contact</th><th>Status</th></tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $row) : ?>
                    <tr class="<?= (int)$row['id'] === (int)$selectedId ? 'active' : '' ?>">
                        <td><a href="<?= $this->Url->build(['action' => 'admin_requests', '?' => ['id' => $row['id']]]) ?>"><?= h($row['code']) ?></a></td>
                        <td><?= h($row['name']) ?></td>
                        <td><?= h($row['contact_name']) ?></td>
                        <td><span class="sh-pill"><?= h(SpecRequestOptions::label(SpecRequestOptions::REQUEST_STATUSES, (string)($row['request_status'] ?? ''))) ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <div class="sh-card">
        <?php if (!$selected) : ?>
            <p class="sh-muted">Select a request.</p>
        <?php else : ?>
            <div class="sh-top" style="margin:0 0 10px;">
                <h2><?= h($selected['code']) ?> · <?= h($selected['name']) ?></h2>
                <button type="button" class="sh-btn sh-btn-outline js-open-spec" data-id="<?= (int)$selected['id'] ?>" data-project="<?= h($json($selected)) ?>">Open existing Spec Hub</button>
            </div>
            <p><?= h($selected['location']) ?></p>
            <p><strong><?= h($selected['contact_name']) ?></strong> · <?= h($selected['contact_email']) ?> · <?= h($selected['contact_phone']) ?></p>
            <p>Role: <?= h(SpecRequestOptions::label(SpecRequestOptions::ROLES, (string)($selected['contact_role'] ?? ''))) ?> · <?= h($selected['contact_company']) ?></p>
            <?php if (!empty($decoded['project'])) : ?>
                <p>
                    <?= h(SpecRequestOptions::label(SpecRequestOptions::BUILDING_TYPES, $decoded['project']['building_type'] ?? '')) ?>
                    · <?= h(SpecRequestOptions::label(SpecRequestOptions::PROJECT_STAGES, $decoded['project']['project_stage'] ?? '')) ?>
                    · <?= h(SpecRequestOptions::label(SpecRequestOptions::REQUEST_TYPES, $decoded['project']['request_type'] ?? '')) ?>
                </p>
            <?php endif; ?>
            <h3>Areas</h3>
            <?php
            $areaRows = $selected['spec_project_areas'] ?? [];
            if ($areaRows === []) {
                echo '<p class="sh-muted">No area rows.</p>';
            } else {
                foreach ($areaRows as $area) {
                    $a = is_object($area) ? $area->toArray() : (array)$area;
                    echo '<div class="sh-ticket">';
                    echo '<strong>' . h(SpecRequestDraft::areaTitle($a)) . '</strong>';
                    echo '<p>' . h($a['location'] ?? '') . ' · ' . h($a['quantity'] ?? '') . '</p>';
                    echo '<p>Substrate: ' . h(SpecRequestOptions::label(SpecRequestOptions::SUBSTRATES, (string)($a['substrate'] ?? ''))) . ' / ' . h(SpecRequestOptions::label(SpecRequestOptions::CONDITIONS, (string)($a['substrate_condition'] ?? ''))) . '</p>';
                    echo '<p>Preferred: ' . h($a['preferred_products'] ?? '') . '</p>';
                    if (!empty($a['file_path'])) {
                        echo '<p><a href="' . h($base . $a['file_path']) . '" target="_blank">Area file</a></p>';
                    }
                    echo '</div>';
                }
            }
            ?>
            <h3>Attachments</h3>
            <?php
            $files = $decoded['docs']['files'] ?? [];
            if (empty($files)) {
                echo '<p>' . (!empty($selected['docs_not_available']) ? 'Not available: ' . h((string)$selected['docs_missing_reason']) : 'None') . '</p>';
            } else {
                echo '<ul>';
                foreach ($files as $f) {
                    $href = !empty($f['path']) ? $base . $f['path'] : '#';
                    echo '<li><a href="' . h($href) . '" target="_blank">' . h(($f['kind'] ?? 'file') . ' — ' . ($f['name'] ?? 'download')) . '</a></li>';
                }
                echo '</ul>';
            }
            ?>
            <?= $this->Form->create(null, ['url' => ['action' => 'admin_update_request'], 'class' => 'sh-form']); ?>
            <input type="hidden" name="id" value="<?= (int)$selected['id'] ?>">
            <div class="form-group">
                <label>Status</label>
                <select class="form-control" name="request_status">
                    <?php foreach ($requestStatuses as $key => $label) : ?>
                        <option value="<?= h($key) ?>" <?= ($selected['request_status'] ?? '') === $key ? 'selected' : '' ?>><?= h($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Confirmed issue date</label>
                <input class="form-control" type="date" name="confirmed_issue_date" title="Date the specification was actually issued" placeholder="YYYY-MM-DD" value="<?= h($fmt($selected['confirmed_issue_date'] ?? '')) ?>">
            </div>
            <div class="form-group">
                <label>Clarification for customer</label>
                <textarea class="form-control" name="clarification" rows="3" placeholder="e.g. Please send balcony falls drawing and substrate moisture readings"><?= h((string)($selected['clarification'] ?? '')) ?></textarea>
            </div>
            <div class="form-group">
                <label>Internal notes</label>
                <textarea class="form-control" name="internal_notes" rows="3" placeholder="Internal only — review comments, warranty caveats, next action"><?= h((string)($selected['internal_notes'] ?? '')) ?></textarea>
            </div>
            <button class="sh-btn sh-btn-blue" type="submit">Save request</button>
            <?= $this->Form->end(); ?>
        <?php endif; ?>
    </div>
</div>
