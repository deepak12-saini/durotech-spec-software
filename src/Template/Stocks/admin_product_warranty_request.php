<?php
$csrfToken = $this->getRequest()->getCookie('csrfToken');
$filterQ = (string)($filterQ ?? $this->request->getQuery('q', ''));
$filterStatus = (string)($filterStatus ?? 'Pending');
$pagerQuery = array_filter(
    $this->request->getQueryParams(),
    static function ($v) {
        return $v !== '' && $v !== null;
    }
);
unset($pagerQuery['page']);
$pill = static function ($status) {
    $map = ['Pending' => 'wp-pending', 'Approved' => 'wp-approved', 'Rejected' => 'wp-rejected'];
    return $map[$status] ?? 'wp-pending';
};
$statusIcon = static function ($status) {
    $map = ['Pending' => 'fa-clock-o', 'Approved' => 'fa-check-circle', 'Rejected' => 'fa-times-circle'];
    return $map[$status] ?? 'fa-clock-o';
};
?>
<?php if (!empty($csrfToken)) { echo $this->Form->hidden('_csrfToken', ['id' => 'csrf-token-field', 'value' => $csrfToken]); } ?>
<div class="wp-top">
    <div>
        <h1>Approve list</h1>
        <p>Pending warranties to preview, edit, then approve. Same data as before — now in the warranty portal.</p>
    </div>
    <a class="wp-btn wp-btn-green" href="<?= $this->Url->build(['action' => 'admin_add_product_warranty']) ?>"><i class="fa fa-plus"></i> New Warranty</a>
</div>
<div class="wp-card">
    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'admin_product_warranty_request'], 'class' => 'wp-tools']); ?>
        <input type="text" name="q" placeholder="Search serial, product, building, applicator…" value="<?= h($filterQ) ?>">
        <select name="status">
            <option value="" <?= $filterStatus === '' ? 'selected' : '' ?>>All statuses</option>
            <option value="Pending" <?= $filterStatus === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Approved" <?= $filterStatus === 'Approved' ? 'selected' : '' ?>>Approved</option>
            <option value="Rejected" <?= $filterStatus === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
        <button class="wp-btn wp-btn-blue" type="submit"><i class="fa fa-search"></i> Search</button>
        <a class="wp-btn wp-btn-outline" href="<?= $this->Url->build(['action' => 'admin_product_warranty_request']) ?>">Reset</a>
    <?= $this->Form->end(); ?>
    <table class="wp-table">
        <thead>
            <tr>
                <th>Serial</th>
                <th>Contractor / site</th>
                <th>Product</th>
                <th>Email</th>
                <th>Status</th>
                <th>Submitted</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($productWarrantyRequests)) : ?>
                <tr><td colspan="7">No matching warranties.</td></tr>
            <?php else : ?>
                <?php foreach ($productWarrantyRequests as $request) :
                    $row = $request['ProductWarrantyRequest'] ?? $request;
                    $rowId = (int)($row['id'] ?? 0);
                    $statusVal = trim((string)($row['status'] ?? ''));
                    if ($statusVal === '') {
                        $statusVal = 'Pending';
                    }
                    $isPending = ($statusVal === 'Pending');
                    $preview = $this->Url->build('/admin/stocks/preview_product_warranty_certificate/' . $rowId);
                    ?>
                <tr>
                    <td><?= h($row['serialnumber'] ?? '') ?></td>
                    <td>
                        <?= h(trim((string)($row['contract_company_name'] ?? '') . ' / ' . (string)($row['contract_name'] ?? ''), ' /')) ?>
                        <?php if (!empty($row['building_name'])) : ?><br><small><?= h($row['building_name']) ?></small><?php endif; ?>
                    </td>
                    <td><?= h($row['product'] ?? '') ?></td>
                    <td><?= h($row['email'] ?? '') ?></td>
                    <td><span class="wp-pill <?= $pill($statusVal) ?>"><i class="fa <?= $statusIcon($statusVal) ?>"></i> <?= h($statusVal) ?></span></td>
                    <td><?= !empty($row['created_at']) ? h(format_db_date('d/m/Y', $row['created_at'])) : '' ?></td>
                    <td>
                        <a href="<?= $this->Url->build(['action' => 'admin_warranty_dashboard', '?' => ['id' => $rowId]]) ?>">View</a>
                        <a href="<?= h($preview) ?>" target="_blank">Preview</a>
                        <?php if ($isPending) : ?>
                            <a href="<?= $this->Url->build(['action' => 'admin_edit_product_warranty', $rowId]) ?>">Edit</a>
                            <button type="button" class="wp-btn wp-btn-blue approveBtn" data-id="<?= $rowId ?>" style="padding:4px 10px;font-size:12px;">Approve</button>
                            <button type="button" class="wp-btn wp-btn-red rejectBtn" data-id="<?= $rowId ?>" style="padding:4px 10px;font-size:12px;">Reject</button>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if (!empty($productWarrantyRequests)) : ?>
        <?php $this->Paginator->options(['url' => ['action' => 'admin_product_warranty_request', '?' => $pagerQuery]]); ?>
        <div style="margin-top:12px;">
            <?= $this->Paginator->prev('< previous') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('next >') ?>
        </div>
    <?php endif; ?>
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
