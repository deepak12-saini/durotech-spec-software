<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Datasource\EntityInterface $entity
 */
$row = $entity->toArray();
$dateVal = static function ($value) {
    if ($value === null || $value === '') {
        return '';
    }

    return format_db_date('Y-m-d', $value);
};
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            Edit Product Warranty Request
            <small>#<?= (int)$entity->id ?> — Pending</small>
        </h1>
    </div>
    <p class="text-muted">
        Change the details, then save. This does <strong>not</strong> email the customer.
        After saving, use <strong>Preview PDF</strong> and then <strong>Approve</strong> on the list.
    </p>

    <?= $this->Form->create(null, [
        'class' => 'form-horizontal',
        'url' => ['controller' => 'Stocks', 'action' => 'admin_edit_product_warranty', $entity->id],
    ]); ?>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Registration &amp; product</strong></div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-3 control-label">Serial Number</label>
                <div class="col-sm-7">
                    <input type="text" class="form-control" value="<?= h($row['serialnumber'] ?? '') ?>" readonly>
                    <p class="help-block">Serial is issued by the system and cannot be changed.</p>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Date of Purchase</label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="dateofpurchase" id="dateofpurchase" value="<?= h($dateVal($row['dateofpurchase'] ?? null)); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Product</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('product', ['label' => false, 'class' => 'form-control', 'value' => $row['product'] ?? '', 'required' => true]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Used As</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('used_as', ['label' => false, 'type' => 'textarea', 'rows' => 3, 'class' => 'form-control', 'value' => $row['used_as'] ?? '']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Application</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('application', ['label' => false, 'type' => 'textarea', 'rows' => 3, 'class' => 'form-control', 'value' => $row['application'] ?? '']); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Location &amp; warranty period</strong></div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-3 control-label">Area Warranted</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('area_warranted', ['label' => false, 'class' => 'form-control', 'value' => $row['area_warranted'] ?? '']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Building Name (Project)</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('building_name', ['label' => false, 'class' => 'form-control', 'value' => $row['building_name'] ?? '']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Building Address</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('building_address', ['label' => false, 'class' => 'form-control', 'value' => $row['building_address'] ?? '', 'required' => true]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Building / area name</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('building_area_name', ['label' => false, 'class' => 'form-control', 'value' => $row['building_area_name'] ?? '']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Warranty start</label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="start_requested_warranty" id="start_requested_warranty" value="<?= h($dateVal($row['start_requested_warranty'] ?? null)); ?>">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Warranty end</label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="end_requested_warranty" id="end_requested_warranty" value="<?= h($dateVal($row['end_requested_warranty'] ?? null)); ?>">
                </div>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Contractor &amp; contact</strong></div>
        <div class="panel-body">
            <div class="form-group">
                <label class="col-sm-3 control-label">Contractor company</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('contract_company_name', ['label' => false, 'class' => 'form-control', 'value' => $row['contract_company_name'] ?? '', 'required' => true]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">ABN</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('applicator_active_abn', ['label' => false, 'class' => 'form-control', 'value' => $row['applicator_active_abn'] ?? '']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Company address</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('applicator_address', ['label' => false, 'type' => 'textarea', 'rows' => 3, 'class' => 'form-control', 'value' => $row['applicator_address'] ?? '']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Contractor full name</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('contract_name', ['label' => false, 'class' => 'form-control', 'value' => $row['contract_name'] ?? '', 'required' => true]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('email', ['label' => false, 'type' => 'email', 'class' => 'form-control', 'value' => $row['email'] ?? '', 'required' => true]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Mobile</label>
                <div class="col-sm-7">
                    <?= $this->Form->control('phone', ['label' => false, 'class' => 'form-control', 'value' => $row['phone'] ?? '', 'required' => true, 'maxlength' => 32]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Sign date</label>
                <div class="col-sm-7">
                    <input type="date" class="form-control" name="sign_date" id="sign_date" value="<?= h($dateVal($row['sign_date'] ?? null)); ?>" required>
                </div>
            </div>
            <?php if (!empty($row['contractor_signature'])) : ?>
            <div class="form-group">
                <label class="col-sm-3 control-label">Existing signature</label>
                <div class="col-sm-7">
                    <img src="<?= h((defined('SITEURL') ? rtrim((string)SITEURL, '/') : '') . '/signature/' . $row['contractor_signature']) ?>" alt="Signature" style="max-width:220px;max-height:80px;border:1px solid #ddd;">
                    <p class="help-block">Signature is kept. It is not edited here.</p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <?= $this->Form->button('Save changes', ['class' => 'btn btn-success', 'type' => 'submit']); ?>
            <a class="btn btn-warning" href="<?= h($this->Url->build('/admin/stocks/preview_product_warranty_certificate/' . (int)$entity->id)); ?>" target="_blank">Preview PDF</a>
            <?= $this->Html->link('Back to list', ['action' => 'admin_product_warranty_request'], ['class' => 'btn btn-default']); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>
</div>
