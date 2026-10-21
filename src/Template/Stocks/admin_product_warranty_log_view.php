<?php
/**
 * @var \App\View\AppView $this
 * @var array<string, mixed> $record
 * @var array<int, array<string, mixed>> $events
 */
$statusVal = trim((string)($record['status'] ?? ''));
if ($statusVal === '') {
    $statusVal = 'Pending';
}
$previewUrl = $this->Url->build('/admin/stocks/preview_product_warranty_certificate/' . (int)($record['id'] ?? 0));
?>
<div class="page-content">
    <div class="page-header">
        <h1>
            Warranty Log
            <small>#<?= (int)($record['id'] ?? 0) ?></small>
        </h1>
    </div>

    <p>
        <?= $this->Html->link('Back to warranty log', ['action' => 'admin_product_warranty_log'], ['class' => 'btn btn-default btn-sm']); ?>
        <?php if ($statusVal === 'Pending') : ?>
            <?= $this->Html->link('Edit', ['action' => 'admin_edit_product_warranty', $record['id'] ?? 0], ['class' => 'btn btn-primary btn-sm']); ?>
        <?php endif; ?>
        <a class="btn btn-warning btn-sm" href="<?= h($previewUrl) ?>" target="_blank">Preview PDF</a>
        <?= $this->Html->link('Open request list', ['action' => 'admin_product_warranty_request', '?' => ['q' => (string)($record['id'] ?? '')]], ['class' => 'btn btn-info btn-sm']); ?>
    </p>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Serial, contractor &amp; address</strong></div>
        <div class="panel-body">
            <table class="table table-bordered">
                <tr><th style="width:240px;">Serial number</th><td><?= h($record['serialnumber'] ?? '') ?></td></tr>
                <tr><th>Product</th><td><?= h($record['product'] ?? '') ?></td></tr>
                <tr><th>Contractor company</th><td><?= h($record['contract_company_name'] ?? '') ?></td></tr>
                <tr><th>Contractor / applicator name</th><td><?= h($record['contract_name'] ?? ($record['applicator'] ?? '')) ?></td></tr>
                <tr><th>ABN</th><td><?= h($record['applicator_active_abn'] ?? '') ?></td></tr>
                <tr><th>Applicator / company address</th><td><?= nl2br(h($record['applicator_address'] ?? '')) ?></td></tr>
                <tr><th>Building / project</th><td><?= h($record['building_name'] ?? '') ?></td></tr>
                <tr><th>Building address</th><td><?= h($record['building_address'] ?? '') ?></td></tr>
                <tr><th>Area warranted</th><td><?= h($record['area_warranted'] ?? '') ?></td></tr>
                <tr><th>Email</th><td><?= h($record['email'] ?? '') ?></td></tr>
                <tr><th>Phone</th><td><?= h($record['phone'] ?? '') ?></td></tr>
                <tr><th>Warranty period</th><td><?= h(trim((string)($record['start_requested_warranty'] ?? '') . ' – ' . (string)($record['end_requested_warranty'] ?? ''))) ?></td></tr>
                <tr><th>Status</th><td><?= h($statusVal) ?></td></tr>
                <tr><th>Submitted</th><td><?= !empty($record['created_at']) ? h(format_db_date('d/m/Y H:i', $record['created_at'])) : '' ?></td></tr>
            </table>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading"><strong>Activity history</strong></div>
        <div class="panel-body">
            <?php if (empty($events)) : ?>
                <p class="text-muted">No history rows yet for this record (older submissions before this log was added). Current details above are still stored on the server.</p>
            <?php else : ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>When</th>
                            <th>Action</th>
                            <th>By</th>
                            <th>Serial</th>
                            <th>Contractor</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $ev) :
                            $changed = [];
                            $before = json_decode((string)($ev['before_json'] ?? ''), true);
                            $after = json_decode((string)($ev['after_json'] ?? ''), true);
                            if (is_array($before) && is_array($after)) {
                                foreach ($after as $k => $to) {
                                    $from = (string)($before[$k] ?? '');
                                    if ($from !== (string)$to) {
                                        $changed[] = $k . ': "' . $from . '" → "' . $to . '"';
                                    }
                                }
                            }
                            ?>
                        <tr>
                            <td><?= h($ev['created'] ?? '') ?></td>
                            <td><?= h($ev['action'] ?? '') ?></td>
                            <td><?= h(trim((string)($ev['actor_name'] ?? '') . ' (' . (string)($ev['actor_role'] ?? '') . ')')) ?></td>
                            <td><?= h($ev['serialnumber'] ?? '') ?></td>
                            <td><?= h(trim((string)($ev['contractor_company'] ?? '') . ' / ' . (string)($ev['contractor_name'] ?? ''), ' /')) ?></td>
                            <td>
                                <?= h($ev['message'] ?? '') ?>
                                <?php if ($changed !== []) : ?>
                                    <ul style="margin: 6px 0 0; padding-left: 18px;">
                                        <?php foreach ($changed as $line) : ?>
                                            <li><?= h($line) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</div>
