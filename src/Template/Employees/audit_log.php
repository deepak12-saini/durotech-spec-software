<div class="page-content">
    <div class="page-header">
        <h1>Spec Audit Trail
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <?php echo h($mailer->tracknumber ?? ('Spec #' . ($mailer->id ?? ''))); ?>
            </small>
            <?php echo $this->Html->link('Back to Spec List', ['controller' => 'Employees', 'action' => 'index'], ['class' => 'btn btn-default btn-xs pull-right']); ?>
        </h1>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="well well-sm">
                <strong>Name:</strong> <?php echo h($mailer->name ?? ''); ?> |
                <strong>Company:</strong> <?php echo h($mailer->company ?? ''); ?> |
                <strong>Specification:</strong> <?php echo h($mailer->specification ?? ''); ?>
            </div>

            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>When</th>
                            <th>Action</th>
                            <th>Role</th>
                            <th>User ID</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($rows)): ?>
                            <?php foreach ($rows as $idx => $row): ?>
                                <tr>
                                    <td><?php echo (int)$idx + 1; ?></td>
                                    <td><?php echo h(!empty($row->created) ? format_db_date('d-M-Y h:i a', $row->created) : '—'); ?></td>
                                    <td><?php echo h($row->action ?? ''); ?></td>
                                    <td><?php echo h($row->actor_role ?? ''); ?></td>
                                    <td><?php echo h($row->actor_id ?? ''); ?></td>
                                    <td><?php echo h($row->message ?? ''); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">No audit entries found for this spec yet.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
