<style>
    .testimonials-admin .page-header h1 {
        margin: 0;
        font-size: 24px;
    }
    .testimonials-admin .top-button {
        margin-top: 4px;
    }
    .testimonials-admin #testimonials-table {
        margin-bottom: 0;
    }
    .testimonials-admin #testimonials-table thead th {
        white-space: nowrap;
        vertical-align: middle;
        background: #f8f9fa;
    }
    .testimonials-admin #testimonials-table tbody td {
        vertical-align: middle;
    }
    .testimonials-admin .testi-photo {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e3e3e3;
        display: block;
    }
    .testimonials-admin .testi-photo-placeholder {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background: #eef2f7;
        color: #8a9aad;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        border: 2px dashed #d5dce5;
    }
    .testimonials-admin .testi-client strong {
        display: block;
        color: #2c3e50;
    }
    .testimonials-admin .testi-client small {
        color: #7a8a99;
    }
    .testimonials-admin .testi-quote {
        max-width: 280px;
        color: #555;
        line-height: 1.45;
        margin: 0;
    }
    .testimonials-admin .testi-created {
        white-space: nowrap;
        font-size: 13px;
        color: #666;
    }
    .testimonials-admin .testi-status .label {
        display: inline-block;
        margin-bottom: 0;
        font-size: 11px;
        padding: 4px 8px;
    }
    .testimonials-admin .testi-actions .btn-group .btn {
        margin-bottom: 0;
    }
    .testimonials-admin .testi-actions .btn-group {
        display: inline-flex;
        flex-wrap: nowrap;
    }
    .testimonials-admin .col-photo {
        width: 70px;
        text-align: center;
    }
    .testimonials-admin .col-status {
        width: 110px;
        text-align: center;
    }
    .testimonials-admin .col-actions {
        width: 200px;
        text-align: center;
    }
    .testimonials-admin .empty-state {
        padding: 40px 20px;
        text-align: center;
        color: #888;
    }
    .testimonials-admin .empty-state i {
        font-size: 42px;
        color: #c5cdd6;
        margin-bottom: 12px;
    }
</style>

<div class="page-content testimonials-admin">
    <div class="page-header clearfix">
        <h1 class="pull-left">Testimonials</h1>
        <a href="<?= $this->Url->build(['controller' => 'Testimonials', 'action' => 'admin_add']); ?>"
           class="btn btn-primary btn-sm pull-right top-button">
            <i class="fa fa-plus"></i> Add New
        </a>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover" id="testimonials-table">
                    <thead>
                        <tr>
                            <th class="col-photo">Photo</th>
                            <th>Client</th>
                            <th>Quote</th>
                            <th>Created By</th>
                            <th class="col-status">Status</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($testimonials) || (is_countable($testimonials) && count($testimonials) === 0)): ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fa fa-comments-o"></i>
                                    <p>No testimonials yet. Click <strong>Add New</strong> to create one.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($testimonials as $t): ?>
                                <?php
                                    $photo = is_object($t) ? $t->photo : ($t['photo'] ?? $t['Testimonial']['photo'] ?? null);
                                    $name = is_object($t) ? $t->name : ($t['name'] ?? $t['Testimonial']['name'] ?? '');
                                    $company_name = is_object($t) ? $t->company_name : ($t['company_name'] ?? $t['Testimonial']['company_name'] ?? '');
                                    $role = is_object($t) ? $t->role : ($t['role'] ?? $t['Testimonial']['role'] ?? '');
                                    $quote = is_object($t) ? $t->quote : ($t['quote'] ?? $t['Testimonial']['quote'] ?? '');
                                    $status = (int)(is_object($t) ? $t->status : ($t['status'] ?? $t['Testimonial']['status'] ?? 0));
                                    $id = is_object($t) ? $t->id : ($t['id'] ?? $t['Testimonial']['id'] ?? null);
                                    $employeeName = null;
                                    if (is_object($t) && isset($t->employee)) {
                                        $employeeName = is_object($t->employee) ? ($t->employee->name ?? null) : ($t->employee['name'] ?? null);
                                    } elseif (isset($t['employee']['name'])) {
                                        $employeeName = $t['employee']['name'];
                                    }
                                    $quoteShort = mb_strlen($quote) > 100 ? mb_substr($quote, 0, 100) . '…' : $quote;
                                    $initial = $name !== '' ? mb_strtoupper(mb_substr($name, 0, 1)) : '?';
                                ?>
                                <tr>
                                    <td class="col-photo">
                                        <?php if (!empty($photo)): ?>
                                            <img src="<?= $this->Url->build('/img/' . $photo, ['fullBase' => true]); ?>"
                                                 class="testi-photo" alt="<?= h($name); ?>">
                                        <?php else: ?>
                                            <span class="testi-photo-placeholder" title="No photo"><?= h($initial); ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="testi-client">
                                        <strong><?= h($name); ?></strong>
                                        <?php if ($company_name !== '' || $role !== ''): ?>
                                            <small>
                                                <?php if ($company_name !== ''): ?>
                                                    <?= h($company_name); ?>
                                                <?php endif; ?>
                                                <?php if ($company_name !== '' && $role !== ''): ?> · <?php endif; ?>
                                                <?php if ($role !== ''): ?>
                                                    <?= h($role); ?>
                                                <?php endif; ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <p class="testi-quote" title="<?= h($quote); ?>"><?= h($quoteShort); ?></p>
                                    </td>
                                    <td class="testi-created">
                                        <?= $employeeName ? h($employeeName) : 'Admin'; ?>
                                    </td>
                                    <td class="testi-status">
                                        <?php if ($status): ?>
                                            <span class="label label-success">Approved</span>
                                        <?php else: ?>
                                            <span class="label label-warning">Pending</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="testi-actions">
                                        <div class="btn-group btn-group-sm" role="group">
                                            <?php if ($status): ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-times"></i>',
                                                    ['controller' => 'Testimonials', 'action' => 'admin_toggleStatus', $id],
                                                    [
                                                        'class' => 'btn btn-warning',
                                                        'escape' => false,
                                                        'title' => 'Unapprove',
                                                        'confirm' => 'Unapprove this testimonial?',
                                                    ]
                                                ); ?>
                                            <?php else: ?>
                                                <?= $this->Html->link(
                                                    '<i class="fa fa-check"></i>',
                                                    ['controller' => 'Testimonials', 'action' => 'admin_toggleStatus', $id],
                                                    [
                                                        'class' => 'btn btn-success',
                                                        'escape' => false,
                                                        'title' => 'Approve',
                                                        'confirm' => 'Approve this testimonial?',
                                                    ]
                                                ); ?>
                                            <?php endif; ?>
                                            <?= $this->Html->link(
                                                '<i class="fa fa-pencil"></i>',
                                                ['controller' => 'Testimonials', 'action' => 'admin_edit', $id],
                                                ['class' => 'btn btn-info', 'escape' => false, 'title' => 'Edit']
                                            ); ?>
                                            <?= $this->Form->postLink(
                                                '<i class="fa fa-trash"></i>',
                                                ['controller' => 'Testimonials', 'action' => 'admin_delete', $id],
                                                [
                                                    'class' => 'btn btn-danger',
                                                    'escape' => false,
                                                    'title' => 'Delete',
                                                    'confirm' => 'Delete this testimonial?',
                                                ]
                                            ); ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
