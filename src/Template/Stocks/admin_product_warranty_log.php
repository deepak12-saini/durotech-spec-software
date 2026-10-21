<?php
/**
 * @var \App\View\AppView $this
 * @var array<int, array<string, mixed>> $logs
 * @var array<string, string> $filters
 */
$filters = $filters ?? ['serial' => '', 'contractor' => '', 'address' => '', 'status' => '', 'q' => ''];
$pagerQuery = array_filter(
    $this->request->getQueryParams(),
    static function ($v) {
        return $v !== '' && $v !== null;
    }
);
unset($pagerQuery['page'], $pagerQuery['export']);
$csvQuery = $pagerQuery;
$csvQuery['export'] = 'csv';
?>
<div class="page-content">
    <div class="page-header">
        <h1>Product Warranty Log</h1>
    </div>
    <p class="text-muted">
        Track serial numbers, contractor / applicator, and addresses for every website warranty request.
        New submissions, admin edits, approvals and rejections are recorded in each record’s history.
    </p>

    <div class="row" style="margin-bottom: 15px;">
        <div class="col-xs-12">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'url' => ['action' => 'admin_product_warranty_log']]); ?>
            <div class="form-group" style="margin-right: 8px; margin-bottom: 8px;">
                <?= $this->Form->text('serial', [
                    'class' => 'form-control',
                    'placeholder' => 'Serial number',
                    'value' => $filters['serial'],
                    'style' => 'min-width: 160px;',
                ]); ?>
            </div>
            <div class="form-group" style="margin-right: 8px; margin-bottom: 8px;">
                <?= $this->Form->text('contractor', [
                    'class' => 'form-control',
                    'placeholder' => 'Contractor / applicator',
                    'value' => $filters['contractor'],
                    'style' => 'min-width: 180px;',
                ]); ?>
            </div>
            <div class="form-group" style="margin-right: 8px; margin-bottom: 8px;">
                <?= $this->Form->text('address', [
                    'class' => 'form-control',
                    'placeholder' => 'Address / building',
                    'value' => $filters['address'],
                    'style' => 'min-width: 180px;',
                ]); ?>
            </div>
            <div class="form-group" style="margin-right: 8px; margin-bottom: 8px;">
                <?= $this->Form->select('status', [
                    '' => 'All statuses',
                    'Pending' => 'Pending',
                    'Approved' => 'Approved',
                    'Rejected' => 'Rejected',
                ], [
                    'class' => 'form-control',
                    'value' => $filters['status'],
                ]); ?>
            </div>
            <?= $this->Form->button('Search', ['class' => 'btn btn-primary', 'type' => 'submit']); ?>
            <?= $this->Html->link('Reset', ['action' => 'admin_product_warranty_log'], ['class' => 'btn btn-default']); ?>
            <?= $this->Html->link('Export CSV', ['action' => 'admin_product_warranty_log', '?' => $csvQuery], ['class' => 'btn btn-info']); ?>
            <?= $this->Form->end(); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Serial number</th>
                            <th>Product</th>
                            <th>Contractor / applicator</th>
                            <th>Applicator address</th>
                            <th>Building / project</th>
                            <th>Building address</th>
                            <th>Status</th>
                            <th>Submitted</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($logs)) : ?>
                            <tr><td colspan="10" class="text-center text-muted">No warranty records found.</td></tr>
                        <?php else : ?>
                            <?php foreach ($logs as $row) :
                                $statusVal = trim((string)($row['status'] ?? ''));
                                if ($statusVal === '') {
                                    $statusVal = 'Pending';
                                }
                                $statusClass = 'label-default';
                                if ($statusVal === 'Pending') {
                                    $statusClass = 'label-warning';
                                } elseif ($statusVal === 'Approved') {
                                    $statusClass = 'label-success';
                                } elseif ($statusVal === 'Rejected') {
                                    $statusClass = 'label-danger';
                                }
                                $contractor = trim((string)($row['contract_company_name'] ?? ''));
                                $person = trim((string)($row['contract_name'] ?? ($row['applicator'] ?? '')));
                                $contractorLabel = $contractor !== '' ? $contractor : $person;
                                if ($contractor !== '' && $person !== '' && $contractor !== $person) {
                                    $contractorLabel = $contractor . ' / ' . $person;
                                }
                                $building = trim((string)($row['building_name'] ?? ''));
                                ?>
                            <tr>
                                <td><?= (int)($row['id'] ?? 0) ?></td>
                                <td><?= h($row['serialnumber'] ?? '') ?></td>
                                <td><?= h($row['product'] ?? '') ?></td>
                                <td><?= h($contractorLabel) ?></td>
                                <td><?= h($row['applicator_address'] ?? '') ?></td>
                                <td><?= h($building) ?></td>
                                <td><?= h($row['building_address'] ?? '') ?></td>
                                <td><span class="label <?= $statusClass ?>"><?= h($statusVal) ?></span></td>
                                <td><?= !empty($row['created_at']) ? h(format_db_date('d/m/Y', $row['created_at'])) : '' ?></td>
                                <td>
                                    <a class="btn btn-xs btn-info" href="<?= $this->Url->build(['action' => 'admin_product_warranty_log_view', $row['id'] ?? 0]) ?>">View log</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if (!empty($logs)) : ?>
                <?php $this->Paginator->options(['url' => ['?' => $pagerQuery]]); ?>
                <div class="clearfix" style="margin-top: 12px;">
                    <ul class="pagination pagination-sm pull-left" style="margin: 0;">
                        <?= $this->Paginator->first('&laquo;', ['escape' => false]); ?>
                        <?= $this->Paginator->prev('< ' . __('previous')); ?>
                        <?= $this->Paginator->numbers(['modulus' => 4]); ?>
                        <?= $this->Paginator->next(__('next') . ' >'); ?>
                        <?= $this->Paginator->last('&raquo;', ['escape' => false]); ?>
                    </ul>
                    <p class="text-muted pull-right" style="margin: 8px 0 0;">
                        <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')); ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
