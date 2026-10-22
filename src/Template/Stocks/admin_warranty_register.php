<?php
$filters = $filters ?? ['serial' => '', 'contractor' => '', 'address' => '', 'status' => '', 'q' => ''];
$pagerQuery = array_filter($this->request->getQueryParams(), static function ($v) {
    return $v !== '' && $v !== null;
});
unset($pagerQuery['page'], $pagerQuery['export']);
$csvQuery = $pagerQuery + ['export' => 'csv'];
$statusOf = static function (array $row) {
    $s = trim((string)($row['status'] ?? ''));
    return $s !== '' ? $s : 'Pending';
};
?>
<div class="wp-top">
    <div>
        <h1>Warranty Register</h1>
        <p>Look up by serial the same way as a spec code. Chronological, newest first.</p>
    </div>
    <a class="wp-btn wp-btn-green" href="<?= $this->Url->build(['action' => 'admin_add_product_warranty']) ?>">+ New Warranty</a>
</div>
<div class="wp-card">
    <?= $this->Form->create(null, ['type' => 'get', 'url' => ['action' => 'admin_warranty_register'], 'class' => 'wp-tools']); ?>
        <input type="text" name="serial" placeholder="Serial number" value="<?= h($filters['serial']) ?>">
        <input type="text" name="contractor" placeholder="Contractor / applicator" value="<?= h($filters['contractor']) ?>">
        <input type="text" name="address" placeholder="Address / building" value="<?= h($filters['address']) ?>">
        <select name="status">
            <option value="">All statuses</option>
            <option value="Pending" <?= $filters['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
            <option value="Approved" <?= $filters['status'] === 'Approved' ? 'selected' : '' ?>>Approved</option>
            <option value="Rejected" <?= $filters['status'] === 'Rejected' ? 'selected' : '' ?>>Rejected</option>
        </select>
        <button class="wp-btn wp-btn-blue" type="submit">Search</button>
        <a class="wp-btn wp-btn-outline" href="<?= $this->Url->build(['action' => 'admin_warranty_register']) ?>">Reset</a>
        <a class="wp-btn wp-btn-outline" href="<?= $this->Url->build(['action' => 'admin_warranty_register', '?' => $csvQuery]) ?>">Export</a>
    <?= $this->Form->end(); ?>
    <table class="wp-table">
        <thead>
            <tr>
                <th>Serial</th>
                <th>Contractor</th>
                <th>Address</th>
                <th>Product</th>
                <th>Status</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($logs)) : ?>
                <tr><td colspan="6">No matching warranties.</td></tr>
            <?php else : ?>
                <?php foreach ($logs as $row) :
                    $st = $statusOf($row);
                    $rid = (int)($row['id'] ?? 0);
                    ?>
                <tr>
                    <td><?= h($row['serialnumber'] ?? '') ?></td>
                    <td><?= h(trim((string)($row['contract_company_name'] ?? '') . ' / ' . (string)($row['contract_name'] ?? ''), ' /')) ?></td>
                    <td><?= h($row['building_address'] ?? '') ?></td>
                    <td><?= h($row['product'] ?? '') ?></td>
                    <td><?= h($st) ?></td>
                    <td><a href="<?= $this->Url->build(['action' => 'admin_warranty_view', $rid]) ?>">View</a></td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <?php if (!empty($logs)) : ?>
        <?php $this->Paginator->options(['url' => ['action' => 'admin_warranty_register', '?' => $pagerQuery]]); ?>
        <div style="margin-top:12px;">
            <?= $this->Paginator->prev('< previous') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('next >') ?>
        </div>
    <?php endif; ?>
</div>
