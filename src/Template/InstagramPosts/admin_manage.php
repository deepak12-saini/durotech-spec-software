<div class="page-content">
    <div class="page-header">
        <h1><?= $instagramPost->isNew() ? 'Add' : 'Edit' ?> Instagram Post</h1>
        <a href="<?= $this->Url->build(['controller' => 'InstagramPosts', 'action' => 'admin_index']); ?>" class="btn btn-default pull-right">Back to List</a>
    </div>

    <div class="container-fluid">
        <?= $this->Form->create($instagramPost, [
            'url' => array_merge(
                ['controller' => 'InstagramPosts', 'action' => 'admin_manage'],
                $instagramPost->isNew() ? [] : [$instagramPost->id]
            ),
        ]) ?>

        <div class="form-group">
            <label>Paste Instagram embed code or post URL <?= $instagramPost->isNew() ? '<span class="text-danger">*</span>' : '' ?></label>
            <?= $this->Form->textarea('embed_input', [
                'value' => $embedInput ?? '',
                'class' => 'form-control',
                'rows' => 8,
                'placeholder' => 'Paste embed code from Instagram (⋯ → Embed) or a URL like https://www.instagram.com/p/ABC123/',
            ]) ?>
            <p class="help-block">
                On Instagram: open a post → <strong>⋯</strong> → <strong>Embed</strong> → copy code.
                Works for photos, reels, and videos. Leave blank on edit to keep the current permalink.
            </p>
            <?php if (!$instagramPost->isNew() && !empty($instagramPost->permalink)): ?>
                <p class="help-block">
                    Current: <a href="<?= h($instagramPost->permalink) ?>" target="_blank" rel="noopener noreferrer"><?= h($instagramPost->permalink) ?></a>
                </p>
            <?php endif; ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('display_order', [
                        'label' => 'Display order (lower = first)',
                        'type' => 'number',
                        'class' => 'form-control',
                        'min' => 0,
                        'value' => $instagramPost->display_order ?? 0,
                    ]) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <?= $this->Form->control('admin_note', [
                        'label' => 'Admin note (optional)',
                        'class' => 'form-control',
                        'placeholder' => 'e.g. March product launch reel',
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="form-group">
            <?= $this->Form->control('status', [
                'type' => 'checkbox',
                'label' => 'Active (show on home page)',
                'checked' => $instagramPost->isNew() ? true : !empty($instagramPost->status),
            ]) ?>
        </div>

        <div class="form-group">
            <?= $this->Form->button($instagramPost->isNew() ? 'Add Instagram Post' : 'Update Instagram Post', ['class' => 'btn btn-success']) ?>
            <?= $this->Html->link('Cancel', ['controller' => 'InstagramPosts', 'action' => 'admin_index'], ['class' => 'btn btn-secondary']) ?>
        </div>

        <?= $this->Form->end() ?>
    </div>
</div>
