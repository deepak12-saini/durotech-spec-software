<?php
$next = $nextWarrantySerial ?? '';
$row = !empty($entity) && method_exists($entity, 'toArray') ? $entity->toArray() : [];
$errors = (!empty($entity) && method_exists($entity, 'getErrors')) ? $entity->getErrors() : [];
$dateVal = static function ($value) {
    if ($value === null || $value === '') {
        return '';
    }
    return format_db_date('Y-m-d', $value);
};
?>
<div class="wp-top">
    <div>
        <h1>New Warranty</h1>
        <p>Staff log (Kal confirmed). Serial is issued automatically. Customer is emailed only after Approve.</p>
    </div>
</div>
<div class="wp-card wp-form">
    <?= $this->Form->create(null, ['url' => ['action' => 'admin_add_product_warranty']]); ?>
    <?php if ($errors !== []) : ?>
        <div class="wp-flash error">Please correct the highlighted fields.</div>
    <?php endif; ?>
    <div class="form-group">
        <label>Warranty serial</label>
        <input type="text" class="form-control" value="<?= h($next) ?>" readonly>
        <small>Format DT-month-year-number. Saved on submit.</small>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>Date of purchase</label>
            <input type="date" class="form-control" name="dateofpurchase" value="<?= h($dateVal($row['dateofpurchase'] ?? null)) ?>" required>
        </div>
        <div class="col-sm-6 form-group">
            <label>Product</label>
            <input type="text" class="form-control" name="product" value="<?= h($row['product'] ?? '') ?>" required>
        </div>
    </div>
    <div class="form-group">
        <label>Used as</label>
        <textarea class="form-control" name="used_as" rows="2"><?= h($row['used_as'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
        <label>Application</label>
        <textarea class="form-control" name="application" rows="2"><?= h($row['application'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
        <label>Area warranted</label>
        <input type="text" class="form-control" name="area_warranted" value="<?= h($row['area_warranted'] ?? '') ?>">
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>Building / project name</label>
            <input type="text" class="form-control" name="building_name" value="<?= h($row['building_name'] ?? '') ?>">
        </div>
        <div class="col-sm-6 form-group">
            <label>Building address</label>
            <input type="text" class="form-control" name="building_address" value="<?= h($row['building_address'] ?? '') ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>Warranty start</label>
            <input type="date" class="form-control" name="start_requested_warranty" value="<?= h($dateVal($row['start_requested_warranty'] ?? null)) ?>">
        </div>
        <div class="col-sm-6 form-group">
            <label>Warranty end</label>
            <input type="date" class="form-control" name="end_requested_warranty" value="<?= h($dateVal($row['end_requested_warranty'] ?? null)) ?>">
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>Contractor company</label>
            <input type="text" class="form-control" name="contract_company_name" value="<?= h($row['contract_company_name'] ?? '') ?>" required>
        </div>
        <div class="col-sm-6 form-group">
            <label>ABN</label>
            <input type="text" class="form-control" name="applicator_active_abn" value="<?= h($row['applicator_active_abn'] ?? '') ?>">
        </div>
    </div>
    <div class="form-group">
        <label>Company / applicator address</label>
        <textarea class="form-control" name="applicator_address" rows="2"><?= h($row['applicator_address'] ?? '') ?></textarea>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>Contractor full name</label>
            <input type="text" class="form-control" name="contract_name" value="<?= h($row['contract_name'] ?? '') ?>" required>
        </div>
        <div class="col-sm-6 form-group">
            <label>Email</label>
            <input type="email" class="form-control" name="email" value="<?= h($row['email'] ?? '') ?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6 form-group">
            <label>Mobile</label>
            <input type="text" class="form-control" name="phone" value="<?= h($row['phone'] ?? '') ?>" required>
        </div>
        <div class="col-sm-6 form-group">
            <label>Sign date</label>
            <input type="date" class="form-control" name="sign_date" value="<?= h($dateVal($row['sign_date'] ?? date('Y-m-d'))) ?>" required>
        </div>
    </div>
    <button type="submit" class="wp-btn wp-btn-green">Save warranty</button>
    <a class="wp-btn wp-btn-outline" href="<?= $this->Url->build(['action' => 'admin_warranty_dashboard']) ?>">Cancel</a>
    <?= $this->Form->end(); ?>
</div>
