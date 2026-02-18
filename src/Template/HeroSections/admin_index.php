<div class="page-content">
    <div class="page-header">
        <h1>Hero Sections</h1>
        <a href="<?= $this->Url->build(['controller' => 'HeroSections', 'action' => 'admin_manage']); ?>" class="btn btn-primary pull-right">
            <i class="fa fa-plus"></i> Add New
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Video</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($heroSections->count() > 0): ?>
                    <?php foreach ($heroSections as $hero): ?>
                        <tr>
                            <td><?= h($hero->id) ?></td>
                            <td><?= h($hero->title) ?></td>
                            <td>
                                <?php if (!empty($hero->video)): ?>
                                    <a href="<?= $this->Url->build('/uploads/videos/' . h($hero->video), ['fullBase' => true]); ?>" target="_blank"><?= h($hero->video) ?></a>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= !empty($hero->status) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-secondary">Inactive</span>'; ?>
                            </td>
                            <td>
                                <?= $this->Html->link('Edit', ['controller' => 'HeroSections', 'action' => 'admin_manage', $hero->id], ['class' => 'btn btn-primary btn-sm']) ?>
                                <?= $this->Form->postLink('Delete', ['controller' => 'HeroSections', 'action' => 'admin_delete', $hero->id], ['confirm' => 'Delete this hero section?', 'class' => 'btn btn-danger btn-sm']) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">No hero sections yet. <?= $this->Html->link('Add one', ['controller' => 'HeroSections', 'action' => 'admin_manage']) ?>.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
