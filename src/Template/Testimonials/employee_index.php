<?php
$employeeId = isset($employee_id) ? (int)$employee_id : 0;
?>
<style>
    .testi-page-header {
        align-items: center;
        display: flex;
        gap: 15px;
        justify-content: space-between;
        margin-bottom: 16px;
    }
    .testi-page-header h1 {
        margin: 0;
    }
    .testi-muted {
        color: #7a8794;
        font-size: 12px;
        margin-top: 3px;
    }
    .testi-list-card {
        background: #fff;
        border: 1px solid #dbe5f1;
        border-radius: 14px;
        box-shadow: 0 8px 22px rgba(36, 92, 154, 0.08);
        padding: 16px;
    }
    .testi-table {
        margin-bottom: 0;
    }
    .testi-table thead th {
        background: #f5f8fc;
        border-bottom: 1px solid #dbe5f1 !important;
        color: #41566d;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        vertical-align: middle;
    }
    .testi-table tbody td {
        vertical-align: middle;
    }
    .testi-table tbody tr:hover {
        background: #f9fcff;
    }
    .testi-photo {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e3e8ef;
    }
    .testi-photo-ph {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #eef2f7;
        border: 2px dashed #d5dce5;
        color: #8a9aad;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        font-weight: 700;
    }
    .testi-client strong {
        color: #2f4d6b;
        display: block;
    }
    .testi-client small {
        color: #7a8794;
    }
    .testi-quote {
        color: #555;
        line-height: 1.45;
        margin: 0;
        max-width: 260px;
    }
    .testi-source {
        border-radius: 999px;
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
    }
    .testi-source-admin {
        background: #e8f0fa;
        color: #2b6cb0;
    }
    .testi-source-mine {
        background: #e8f7ee;
        color: #23834b;
    }
    .testi-status {
        border-radius: 999px;
        display: inline-block;
        font-size: 11px;
        font-weight: 700;
        padding: 5px 10px;
    }
    .testi-status-yes {
        background: #e8f7ee;
        color: #23834b;
    }
    .testi-status-no {
        background: #fff4e5;
        color: #b7791f;
    }
    .testi-row-actions {
        display: flex;
        gap: 6px;
        justify-content: center;
        white-space: nowrap;
    }
    .testi-action-btn {
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        padding: 4px 8px;
    }
    .testi-empty {
        color: #7a8794;
        padding: 36px 10px;
        text-align: center;
    }
    .testi-empty i {
        color: #c5cdd6;
        display: block;
        font-size: 40px;
        margin-bottom: 10px;
    }
    .testi-readonly {
        color: #9aa8b5;
        font-size: 12px;
        font-style: italic;
    }
</style>

<div class="page-header testi-page-header">
    <div>
        <h1>Testimonials</h1>
        <div class="testi-muted">All published testimonials on the website. You can edit or delete only your own submissions.</div>
    </div>
    <a href="<?= $this->Url->build(['controller' => 'Testimonials', 'action' => 'employee_add']); ?>"
       class="btn btn-primary testi-action-btn">
        <i class="fa fa-plus"></i> Add New
    </a>
</div>

<div class="testi-list-card">
    <div class="table-responsive">
        <table class="table table-hover testi-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Photo</th>
                    <th>Client</th>
                    <th>Quote</th>
                    <th>Source</th>
                    <th>Published</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $hasRows = false;
                if (!empty($testimonials)) {
                    if (is_object($testimonials) && method_exists($testimonials, 'count')) {
                        $hasRows = $testimonials->count() > 0;
                    } elseif (is_countable($testimonials)) {
                        $hasRows = count($testimonials) > 0;
                    }
                }
                ?>
                <?php if (!$hasRows): ?>
                    <tr>
                        <td colspan="7" class="testi-empty">
                            <i class="fa fa-comments-o"></i>
                            No testimonials yet. Click <strong>Add New</strong> to submit one for admin approval.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $i = 1; foreach ($testimonials as $t): ?>
                        <?php
                            $photo = is_object($t) ? $t->photo : ($t['photo'] ?? $t['Testimonial']['photo'] ?? null);
                            $name = is_object($t) ? $t->name : ($t['name'] ?? $t['Testimonial']['name'] ?? '');
                            $company_name = is_object($t) ? $t->company_name : ($t['company_name'] ?? $t['Testimonial']['company_name'] ?? '');
                            $role = is_object($t) ? $t->role : ($t['role'] ?? $t['Testimonial']['role'] ?? '');
                            $quote = is_object($t) ? $t->quote : ($t['quote'] ?? $t['Testimonial']['quote'] ?? '');
                            $status = (int)(is_object($t) ? $t->status : ($t['status'] ?? $t['Testimonial']['status'] ?? 0));
                            $id = is_object($t) ? $t->id : ($t['id'] ?? $t['Testimonial']['id'] ?? null);
                            $createdBy = is_object($t) ? ($t->created_by ?? null) : ($t['created_by'] ?? $t['Testimonial']['created_by'] ?? null);
                            $isOwn = $createdBy !== null && (int)$createdBy === $employeeId;
                            $quoteShort = mb_strlen($quote) > 90 ? mb_substr($quote, 0, 90) . '…' : $quote;
                            $initial = $name !== '' ? mb_strtoupper(mb_substr($name, 0, 1)) : '?';
                        ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td>
                                <?php if (!empty($photo)): ?>
                                    <img src="<?= $this->Url->build('/img/' . $photo, ['fullBase' => true]); ?>"
                                         class="testi-photo" alt="<?= h($name); ?>">
                                <?php else: ?>
                                    <span class="testi-photo-ph"><?= h($initial); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="testi-client">
                                <strong><?= h($name); ?></strong>
                                <?php if ($company_name !== '' || $role !== ''): ?>
                                    <small>
                                        <?php if ($company_name !== ''): ?><?= h($company_name); ?><?php endif; ?>
                                        <?php if ($company_name !== '' && $role !== ''): ?> · <?php endif; ?>
                                        <?php if ($role !== ''): ?><?= h($role); ?><?php endif; ?>
                                    </small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <p class="testi-quote" title="<?= h($quote); ?>"><?= h($quoteShort); ?></p>
                            </td>
                            <td>
                                <?php if ($isOwn): ?>
                                    <span class="testi-source testi-source-mine">Yours</span>
                                <?php else: ?>
                                    <span class="testi-source testi-source-admin">Admin</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($status): ?>
                                    <span class="testi-status testi-status-yes">Yes</span>
                                <?php else: ?>
                                    <span class="testi-status testi-status-no">Pending</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if ($isOwn): ?>
                                    <div class="testi-row-actions">
                                        <?= $this->Html->link(
                                            '<i class="fa fa-pencil"></i> Edit',
                                            ['controller' => 'Testimonials', 'action' => 'employee_edit', $id],
                                            ['class' => 'btn btn-info testi-action-btn', 'escape' => false]
                                        ); ?>
                                        <?= $this->Form->postLink(
                                            '<i class="fa fa-trash"></i> Delete',
                                            ['controller' => 'Testimonials', 'action' => 'employee_delete', $id],
                                            [
                                                'class' => 'btn btn-danger testi-action-btn',
                                                'escape' => false,
                                                'confirm' => 'Delete this testimonial?',
                                            ]
                                        ); ?>
                                    </div>
                                <?php else: ?>
                                    <span class="testi-readonly">View only</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
