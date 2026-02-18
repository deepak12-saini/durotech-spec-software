<style>
    .add-btn-right {
    float: right;
}
</style>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Testimonials List</h3>
        <a href="<?php echo $this->Url->build(['controller' => 'Testimonials', 'action' => 'admin_add']); ?>" class="btn btn-primary add-btn-right">
            <i class="fa fa-plus"></i> Add New
        </a>
    </div>
    <table class="table table-bordered table-striped">
        <tr>
            <th>Photo</th>
            <th>Client Name</th>
            <th>Company</th>
            <th>Role</th>
            <th>Quote</th>
            <th>Created By</th>
            <th>Published</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($testimonials as $t): ?>
        <?php
            $photo = is_object($t) ? $t->photo : ($t['photo'] ?? $t['Testimonial']['photo'] ?? null);
            $name = is_object($t) ? $t->name : ($t['name'] ?? $t['Testimonial']['name'] ?? '');
            $company_name = is_object($t) ? $t->company_name : ($t['company_name'] ?? $t['Testimonial']['company_name'] ?? '');
            $role = is_object($t) ? $t->role : ($t['role'] ?? $t['Testimonial']['role'] ?? '');
            $quote = is_object($t) ? $t->quote : ($t['quote'] ?? $t['Testimonial']['quote'] ?? '');
            $status = is_object($t) ? $t->status : ($t['status'] ?? $t['Testimonial']['status'] ?? 0);
            $id = is_object($t) ? $t->id : ($t['id'] ?? $t['Testimonial']['id'] ?? null);
            $employeeName = null;
            if (is_object($t) && isset($t->employee)) {
                $employeeName = is_object($t->employee) ? ($t->employee->name ?? null) : ($t->employee['name'] ?? null);
            } elseif (isset($t['employee']['name'])) {
                $employeeName = $t['employee']['name'];
            }
        ?>
        <tr>
            <td>
                <?php if (!empty($photo)): ?>
                    <img src="<?php echo $this->Url->build('/img/' . $photo, ['fullBase' => true]); ?>" width="60" alt="">
                <?php endif; ?>
            </td>
            <td><?php echo h($name); ?></td>
            <td><?php echo h($company_name); ?></td>
            <td><?php echo h($role); ?></td>
            <td><?php echo h(mb_strlen($quote) > 60 ? mb_substr($quote, 0, 60) . '...' : $quote); ?></td>
            <td>
                <?php echo $employeeName ? h($employeeName) : '<em>Admin</em>'; ?>
            </td>
            <td>
                <?php if ($status): ?>
                    <span class="badge badge-success">Approved</span>
                    <?php echo $this->Html->link('Unapprove',
                        ['controller' => 'Testimonials', 'action' => 'admin_toggleStatus', $id],
                        ['class' => 'btn btn-warning btn-sm', 'confirm' => 'Unapprove this testimonial?']
                    ); ?>
                <?php else: ?>
                    <span class="badge badge-secondary">Pending</span>
                    <?php echo $this->Html->link('Approve',
                        ['controller' => 'Testimonials', 'action' => 'admin_toggleStatus', $id],
                        ['class' => 'btn btn-success btn-sm', 'confirm' => 'Approve this testimonial?']
                    ); ?>
                <?php endif; ?>
            </td>
            <td>
                <?php echo $this->Html->link('Edit', ['controller' => 'Testimonials', 'action' => 'admin_edit', $id], ['class' => 'btn btn-primary btn-sm']); ?>
                <?php echo $this->Form->postLink('Delete', ['controller' => 'Testimonials', 'action' => 'admin_delete', $id], ['confirm' => 'Delete this testimonial?', 'class' => 'btn btn-danger btn-sm']); ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
