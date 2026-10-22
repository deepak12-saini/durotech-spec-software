<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, int> $stats
 * @var array<int, array<string, mixed>> $register
 * @var array<string, mixed>|null $selected
 * @var int $selectedId
 * @var array<int, array<string, mixed>> $activity
 */
$csrfToken = $this->getRequest()->getCookie('csrfToken');
$statusOf = static function (array $row) {
    $s = trim((string)($row['status'] ?? ''));
    return $s !== '' ? $s : 'Pending';
};
$pill = static function ($status) {
    $map = ['Pending' => 'wp-pending', 'Approved' => 'wp-approved', 'Rejected' => 'wp-rejected'];
    return $map[$status] ?? 'wp-pending';
};
$statusIcon = static function ($status) {
    $map = ['Pending' => 'fa-clock-o', 'Approved' => 'fa-check-circle', 'Rejected' => 'fa-times-circle'];
    return $map[$status] ?? 'fa-clock-o';
};
$activityDot = static function ($action) {
    $a = strtolower((string)$action);
    if (strpos($a, 'approv') !== false) {
        return 'wp-dot-ok';
    }
    if (strpos($a, 'reject') !== false) {
        return 'wp-dot-no';
    }
    if (strpos($a, 'edit') !== false) {
        return 'wp-dot-edit';
    }
    return 'wp-dot-new';
};
$contractor = static function (array $row) {
    $c = trim((string)($row['contract_company_name'] ?? ''));
    $p = trim((string)($row['contract_name'] ?? ($row['applicator'] ?? '')));
    if ($c !== '' && $p !== '' && $c !== $p) {
        return $c . ', ' . $p;
    }
    return $c !== '' ? $c : $p;
};
?>
<?php if (!empty($csrfToken)) { echo $this->Form->hidden('_csrfToken', ['id' => 'csrf-token-field', 'value' => $csrfToken]); } ?>
<div class="wp-top">
    <div>
        <h1>Warranty Dashboard <span class="wp-badge">Live</span></h1>
        <p>Track every warranty. Search by serial like a spec code. Manage every approval.</p>
    </div>
    <a class="wp-btn wp-btn-green" href="<?= $this->Url->build(['action' => 'admin_add_product_warranty']) ?>"><i class="fa fa-plus"></i> New Warranty</a>
</div>

<div class="wp-stats">
    <div class="wp-stat">
        <span class="wp-ico wp-ico-total"><i class="fa fa-clipboard"></i></span>
        <div><div class="l">Total Warranties</div><div class="n"><?= (int)($stats['total'] ?? 0) ?></div></div>
    </div>
    <div class="wp-stat">
        <span class="wp-ico wp-ico-pending"><i class="fa fa-clock-o"></i></span>
        <div><div class="l">Pending Approval</div><div class="n"><?= (int)($stats['pending'] ?? 0) ?></div></div>
    </div>
    <div class="wp-stat">
        <span class="wp-ico wp-ico-approved"><i class="fa fa-check"></i></span>
        <div><div class="l">Approved</div><div class="n"><?= (int)($stats['approved'] ?? 0) ?></div></div>
    </div>
    <div class="wp-stat">
        <span class="wp-ico wp-ico-rejected"><i class="fa fa-times"></i></span>
        <div><div class="l">Rejected</div><div class="n"><?= (int)($stats['rejected'] ?? 0) ?></div></div>
    </div>
</div>

<div class="wp-grid">
    <div class="wp-card">
        <h2>Warranty Register</h2>
        <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'admin_warranty_register'], 'class' => 'wp-tools']); ?>
            <input type="text" name="q" placeholder="Search serial, contractor or address" value="<?= h((string)$this->request->getQuery('q', '')) ?>">
            <select name="status">
                <option value="">All statuses</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>
            <button class="wp-btn wp-btn-outline" type="submit"><i class="fa fa-search"></i> Search</button>
            <a class="wp-btn wp-btn-outline" href="<?= $this->Url->build(['action' => 'admin_warranty_register', '?' => ['export' => 'csv']]) ?>"><i class="fa fa-download"></i> Export</a>
        <?= $this->Form->end(); ?>
        <table class="wp-table">
            <thead>
                <tr>
                    <th>Warranty ID</th>
                    <th>Contractor / Site</th>
                    <th>Product</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($register)) : ?>
                    <tr><td colspan="5">No warranties yet.</td></tr>
                <?php else : ?>
                    <?php foreach ($register as $row) :
                        $st = $statusOf($row);
                        $rid = (int)($row['id'] ?? 0);
                        ?>
                    <tr class="<?= $rid === (int)$selectedId ? 'active' : '' ?>">
                        <td><?= h($row['serialnumber'] ?? ('#' . $rid)) ?></td>
                        <td><?= h($contractor($row)) ?><?php if (!empty($row['building_name'])) : ?><br><small><?= h($row['building_name']) ?></small><?php endif; ?></td>
                        <td><?= h($row['product'] ?? '') ?></td>
                        <td><span class="wp-pill <?= $pill($st) ?>"><i class="fa <?= $statusIcon($st) ?>"></i> <?= h($st) ?></span></td>
                        <td><a href="<?= $this->Url->build(['action' => 'admin_warranty_view', $rid]) ?>">View</a></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <p style="margin:12px 0 0;"><a href="<?= $this->Url->build(['action' => 'admin_warranty_register']) ?>">Open full register</a></p>
    </div>

    <div>
        <div class="wp-card wp-detail">
            <h2>Warranty details</h2>
            <?php if (empty($selected)) : ?>
                <p>Select a row to see contractor, address and documents.</p>
            <?php else :
                $st = $statusOf($selected);
                $sid = (int)($selected['id'] ?? 0);
                $preview = $this->Url->build('/admin/stocks/preview_product_warranty_certificate/' . $sid);
                $cert = $selected['certificate'] ?? '';
                $viewUrl = $this->Url->build(['action' => 'admin_warranty_view', $sid]);
                ?>
                <h3 style="margin:0;"><?= h($selected['serialnumber'] ?? '') ?> <span class="wp-pill <?= $pill($st) ?>"><i class="fa <?= $statusIcon($st) ?>"></i> <?= h($st) ?></span></h3>
                <dt>Contractor</dt><dd><?= h($contractor($selected)) ?></dd>
                <dt>Email</dt><dd><?= h($selected['email'] ?? '') ?></dd>
                <dt>Phone</dt><dd><?= h($selected['phone'] ?? '') ?></dd>
                <dt>Site address</dt><dd><?= h($selected['building_address'] ?? '') ?></dd>
                <dt>Product</dt><dd><?= h($selected['product'] ?? '') ?></dd>
                <dt>Area warranted</dt><dd><?= h($selected['area_warranted'] ?? '') ?></dd>
                <dt>Submitted</dt><dd><?= !empty($selected['created_at']) ? h(format_db_date('d M Y', $selected['created_at'])) : '' ?></dd>
                <dt>Documents</dt>
                <dd>
                    <a href="<?= h($preview) ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Preview PDF</a>
                    <?php if (!empty($cert)) : ?>
                        <br><a href="<?= h(rtrim((string)$this->getRequest()->getAttribute('webroot'), '/') . '/' . ltrim((string)$cert, '/')) ?>" target="_blank"><i class="fa fa-file-pdf-o"></i> Issued certificate</a>
                    <?php else : ?>
                        <br><i class="fa fa-file-o"></i> Issued PDF not generated yet.
                    <?php endif; ?>
                </dd>
                <div class="wp-actions">
                    <a class="wp-btn wp-btn-blue" href="<?= h($viewUrl) ?>"><i class="fa fa-eye"></i> Open full record</a>
                    <?php if ($st === 'Pending') : ?>
                        <a class="wp-btn wp-btn-outline" href="<?= $this->Url->build(['action' => 'admin_edit_product_warranty', $sid]) ?>"><i class="fa fa-pencil"></i> Edit request</a>
                    <?php endif; ?>
                    <?php if ($st === 'Pending') : ?>
                        <button type="button" class="wp-btn wp-btn-blue approveBtn" data-id="<?= $sid ?>"><i class="fa fa-check"></i> Approve</button>
                        <button type="button" class="wp-btn wp-btn-red rejectBtn" data-id="<?= $sid ?>"><i class="fa fa-times"></i> Reject</button>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="wp-card" style="margin-top:14px;">
            <h2>Recent activity</h2>
            <ul class="wp-activity">
                <?php if (empty($activity)) : ?>
                    <li>No activity rows yet. New submits, edits and approvals will appear here.</li>
                <?php else : ?>
                    <?php foreach ($activity as $ev) : ?>
                        <li class="<?= $activityDot($ev['action'] ?? '') ?>">
                            <strong><?= h($ev['action'] ?? '') ?></strong>
                            <?= h($ev['serialnumber'] ?? '') ?>
                            <br><small><?= h($ev['message'] ?? '') ?> — <?= h($ev['created'] ?? '') ?></small>
                        </li>
                    <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
<?php $this->start('script'); ?>
<script>
$(function() {
    var approveUrl = <?= json_encode($this->Url->build(['controller' => 'Stocks', 'action' => 'admin_approve_warranty'])) ?>;
    var rejectUrl = <?= json_encode($this->Url->build(['controller' => 'Stocks', 'action' => 'admin_reject_warranty'])) ?>;
    var csrf = $('input[name="_csrfToken"]').val() || '';
    function post(url, id, msg) {
        if (!confirm(msg)) return;
        $.ajax({
            url: url, type: 'POST',
            data: { id: id, _csrfToken: csrf },
            headers: csrf ? { 'X-CSRF-Token': csrf } : {},
            success: function(response) {
                var data = response;
                try { if (typeof response === 'string') data = JSON.parse(response); } catch (e) { data = response; }
                if ((data && data.status === 'success') || String(response).trim() === 'success') {
                    location.reload();
                } else {
                    alert('Unable to update this request.');
                }
            },
            error: function() { alert('Request failed.'); }
        });
    }
    $('.approveBtn').on('click', function() {
        post(approveUrl, $(this).data('id'), 'Approve and email the certificate to the customer?');
    });
    $('.rejectBtn').on('click', function() {
        post(rejectUrl, $(this).data('id'), 'Reject this warranty request?');
    });
});
</script>
<?php $this->end(); ?>
