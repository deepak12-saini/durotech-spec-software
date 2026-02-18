<div class="page-content">
    <div class="page-header">
        <h1><?= $heroSection->isNew() ? 'Add' : 'Edit' ?> Hero Section</h1>
        <a href="<?= $this->Url->build(['controller' => 'HeroSections', 'action' => 'admin_index']); ?>" class="btn btn-default pull-right">Back to List</a>
    </div>

    <div class="container-fluid">
        <?= $this->Form->create($heroSection, [
            'type' => 'file',
            'url' => array_merge(
                ['controller' => 'HeroSections', 'action' => 'admin_manage'],
                $heroSection->isNew() ? [] : [$heroSection->id]
            ),
        ]) ?>

        <div class="form-group">
            <?= $this->Form->control('title', [
                'label' => 'Title',
                'class' => 'form-control',
                'required' => true,
            ]) ?>
        </div>

        <div class="form-group">
            <label>Video (file)</label>
            <?= $this->Form->file('video', ['class' => 'form-control', 'accept' => 'video/*']) ?>
            <?php if (!$heroSection->isNew() && !empty($heroSection->video)): ?>
                <p class="help-block mt-2">
                    Current: <a href="<?= $this->Url->build('/uploads/videos/' . h($heroSection->video), ['fullBase' => true]); ?>" target="_blank"><?= h($heroSection->video) ?></a>
                    — Leave empty to keep.
                </p>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <?= $this->Form->control('status', [
                'type' => 'checkbox',
                'label' => 'Active',
                'checked' => !empty($heroSection->status),
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->button($heroSection->isNew() ? 'Add Hero Section' : 'Update Hero Section', ['class' => 'btn btn-success']) ?>
            <?= $this->Html->link('Cancel', ['controller' => 'HeroSections', 'action' => 'admin_index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
