<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClaudeSpecDraft $draft
 * @var array<string, mixed> $payload
 */
$header = $payload['header'] ?? [];
$comments = $payload['comments'] ?? [];
$products = $payload['products'] ?? [];
if (empty($comments)) {
    $comments = [''];
}
if (empty($products)) {
    $products = [['title' => '', 'product' => '', 'serial' => '1', 'coverage' => '', 'coverage_by_pack' => '', 'Warranty' => '', 'types' => '1']];
}
?>
<?= $this->element('claude_specs_styles'); ?>
<div class="page-content claude-wrap">
    <div class="page-header">
        <h1>Edit Claude draft <?= h($draft->tracknumber); ?></h1>
    </div>

    <div class="claude-card">
    <?= $this->Form->create(null, ['class' => 'form-horizontal']); ?>
    <h4>Project</h4>
    <div class="form-group">
        <label class="col-sm-2 control-label">Brief</label>
        <div class="col-sm-10">
            <?= $this->Form->textarea('project_brief', ['class' => 'form-control', 'rows' => 4, 'value' => $draft->project_brief]); ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Client</label>
        <div class="col-sm-4"><?= $this->Form->text('client_name', ['class' => 'form-control', 'value' => $draft->client_name]); ?></div>
        <label class="col-sm-2 control-label">Company</label>
        <div class="col-sm-4"><?= $this->Form->text('company', ['class' => 'form-control', 'value' => $draft->company]); ?></div>
    </div>

    <h4>Header</h4>
    <div class="form-group">
        <label class="col-sm-2 control-label">Name</label>
        <div class="col-sm-4"><?= $this->Form->text('header_name', ['class' => 'form-control', 'value' => $header['name'] ?? '']); ?></div>
        <label class="col-sm-2 control-label">Email</label>
        <div class="col-sm-4"><?= $this->Form->text('header_email', ['class' => 'form-control', 'value' => $header['email'] ?? $draft->email]); ?></div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Project</label>
        <div class="col-sm-4"><?= $this->Form->text('header_company', ['class' => 'form-control', 'value' => $header['company'] ?? $draft->company]); ?></div>
        <label class="col-sm-2 control-label">Date</label>
        <div class="col-sm-4"><?= $this->Form->text('header_date', ['class' => 'form-control', 'value' => $header['date'] ?? date('Y-m-d'), 'placeholder' => 'YYYY-MM-DD']); ?></div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Address</label>
        <div class="col-sm-10"><?= $this->Form->textarea('header_address', ['class' => 'form-control', 'rows' => 2, 'value' => $header['address'] ?? $draft->address]); ?></div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Specification</label>
        <div class="col-sm-10"><?= $this->Form->text('header_specification', ['class' => 'form-control', 'value' => $header['specification'] ?? '']); ?></div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Subject</label>
        <div class="col-sm-10"><?= $this->Form->text('header_subject', ['class' => 'form-control', 'value' => $header['subject'] ?? 'Durotech: External Liquid WPM']); ?></div>
    </div>

    <h4>Comments</h4>
    <div id="claude-comments">
        <?php foreach ($comments as $i => $c): ?>
            <div class="form-group comment-row">
                <label class="col-sm-2 control-label">Comment <?= $i + 1; ?></label>
                <div class="col-sm-10">
                    <input type="text" name="comments[]" class="form-control" value="<?= h((string)$c); ?>">
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <p><button type="button" class="btn btn-xs btn-default" id="add-comment">+ Add comment</button></p>

    <h4>Products</h4>
    <div class="table-responsive">
        <table class="table table-bordered claude-table" id="claude-products">
            <thead>
                <tr>
                    <th>Section title</th>
                    <th>Serial</th>
                    <th>Product</th>
                    <th>Coverage</th>
                    <th>M²/pack</th>
                    <th>Warranty</th>
                    <th>Section #</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $row): ?>
                    <tr class="product-row">
                        <td><input type="text" name="product_title[]" class="form-control input-sm" value="<?= h($row['title'] ?? ''); ?>"></td>
                        <td><input type="text" name="product_serial[]" class="form-control input-sm" value="<?= h($row['serial'] ?? ''); ?>"></td>
                        <td><input type="text" name="product_name[]" class="form-control input-sm" value="<?= h($row['product'] ?? ''); ?>"></td>
                        <td><input type="text" name="product_coverage[]" class="form-control input-sm" value="<?= h($row['coverage'] ?? ''); ?>"></td>
                        <td><input type="text" name="product_coverage_by_pack[]" class="form-control input-sm" value="<?= h($row['coverage_by_pack'] ?? ''); ?>"></td>
                        <td><input type="text" name="product_warranty[]" class="form-control input-sm" value="<?= h($row['Warranty'] ?? ''); ?>"></td>
                        <td><input type="text" name="product_types[]" class="form-control input-sm" value="<?= h($row['types'] ?? '1'); ?>" style="width:50px;"></td>
                        <td><button type="button" class="btn btn-xs btn-danger remove-product">&times;</button></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <p><button type="button" class="btn btn-xs btn-default" id="add-product">+ Add product row</button></p>

    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <?= $this->Form->button('Save changes', ['class' => 'btn btn-success']); ?>
            <?= $this->Html->link('Cancel', ['action' => 'employee_view', $draft->id], ['class' => 'btn btn-default']); ?>
        </div>
    </div>
    <?= $this->Form->end(); ?>
    </div>
</div>

<script>
jQuery(function($) {
    $('#add-comment').on('click', function() {
        var n = $('#claude-comments .comment-row').length + 1;
        $('#claude-comments').append(
            '<div class="form-group comment-row"><label class="col-sm-2 control-label">Comment ' + n + '</label>' +
            '<div class="col-sm-10"><input type="text" name="comments[]" class="form-control"></div></div>'
        );
    });
    $('#add-product').on('click', function() {
        var row = '<tr class="product-row">' +
            '<td><input type="text" name="product_title[]" class="form-control input-sm"></td>' +
            '<td><input type="text" name="product_serial[]" class="form-control input-sm" value="1"></td>' +
            '<td><input type="text" name="product_name[]" class="form-control input-sm"></td>' +
            '<td><input type="text" name="product_coverage[]" class="form-control input-sm"></td>' +
            '<td><input type="text" name="product_coverage_by_pack[]" class="form-control input-sm"></td>' +
            '<td><input type="text" name="product_warranty[]" class="form-control input-sm"></td>' +
            '<td><input type="text" name="product_types[]" class="form-control input-sm" value="1" style="width:50px;"></td>' +
            '<td><button type="button" class="btn btn-xs btn-danger remove-product">&times;</button></td></tr>';
        $('#claude-products tbody').append(row);
    });
    $(document).on('click', '.remove-product', function() {
        if ($('#claude-products tbody tr').length > 1) {
            $(this).closest('tr').remove();
        }
    });
});
</script>
