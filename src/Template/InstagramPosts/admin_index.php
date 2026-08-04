<?php
$filters = isset($filters) && is_array($filters) ? $filters : [
    'keyword' => '',
    'status' => '',
    'date_from' => '',
    'date_to' => '',
];
$this->Paginator->options(['url' => ['?' => array_filter($filters, 'strlen')]]);
?>
<div class="page-content">
    <div class="page-header">
        <h1>Instagram Posts</h1>
        <a href="<?= $this->Url->build(['controller' => 'InstagramPosts', 'action' => 'admin_manage']); ?>" class="btn btn-primary pull-right">
            <i class="fa fa-plus"></i> Add Post
        </a>
    </div>

    <div class="well well-sm" style="margin-bottom: 16px;">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'url' => ['controller' => 'InstagramPosts', 'action' => 'admin_index']]); ?>
            <div class="form-group" style="margin-right: 10px; margin-bottom: 8px;">
                <label for="ig-keyword" class="control-label" style="margin-right: 6px;">Search</label>
                <input type="text"
                       name="keyword"
                       id="ig-keyword"
                       class="form-control input-sm"
                       style="min-width: 220px;"
                       value="<?= h($filters['keyword']); ?>"
                       placeholder="URL, note, or type…">
            </div>
            <div class="form-group" style="margin-right: 10px; margin-bottom: 8px;">
                <label for="ig-status" class="control-label" style="margin-right: 6px;">Status</label>
                <select name="status" id="ig-status" class="form-control input-sm">
                    <option value="">All</option>
                    <option value="1"<?= $filters['status'] === '1' ? ' selected' : ''; ?>>Active</option>
                    <option value="0"<?= $filters['status'] === '0' ? ' selected' : ''; ?>>Hidden</option>
                </select>
            </div>
            <div class="form-group" style="margin-right: 10px; margin-bottom: 8px;">
                <label for="ig-date-from" class="control-label" style="margin-right: 6px;">From</label>
                <input type="date" name="date_from" id="ig-date-from" class="form-control input-sm" value="<?= h($filters['date_from']); ?>">
            </div>
            <div class="form-group" style="margin-right: 10px; margin-bottom: 8px;">
                <label for="ig-date-to" class="control-label" style="margin-right: 6px;">To</label>
                <input type="date" name="date_to" id="ig-date-to" class="form-control input-sm" value="<?= h($filters['date_to']); ?>">
            </div>
            <div class="form-group" style="margin-bottom: 8px;">
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Filter</button>
                <a href="<?= $this->Url->build(['controller' => 'InstagramPosts', 'action' => 'admin_index']); ?>" class="btn btn-default btn-sm">Reset</a>
            </div>
        <?= $this->Form->end(); ?>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Order</th>
                    <th>Permalink</th>
                    <th>Type</th>
                    <th>Note</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!$instagramPosts->isEmpty()): ?>
                    <?php foreach ($instagramPosts as $post): ?>
                        <tr>
                            <td><?= h($post->display_order) ?></td>
                            <td>
                                <a href="<?= h($post->permalink) ?>" target="_blank" rel="noopener noreferrer">
                                    <?= h($post->permalink) ?>
                                </a>
                            </td>
                            <td><?= h(ucfirst($post->media_type ?? 'post')) ?></td>
                            <td><?= !empty($post->admin_note) ? h($post->admin_note) : '<span class="text-muted">—</span>' ?></td>
                            <td>
                                <?php if (!empty($post->status)): ?>
                                    <span class="badge badge-success">Active</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Hidden</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= $this->Html->link('Edit', ['controller' => 'InstagramPosts', 'action' => 'admin_manage', $post->id], ['class' => 'btn btn-primary btn-sm']) ?>
                                <?= $this->Html->link(
                                    !empty($post->status) ? 'Hide' : 'Show',
                                    ['controller' => 'InstagramPosts', 'action' => 'admin_toggleStatus', $post->id],
                                    ['class' => 'btn btn-warning btn-sm']
                                ) ?>
                                <?= $this->Form->postLink(
                                    'Delete',
                                    ['controller' => 'InstagramPosts', 'action' => 'admin_delete', $post->id],
                                    ['confirm' => 'Delete this Instagram post?', 'class' => 'btn btn-danger btn-sm']
                                ) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center text-muted">
                            <?php
                            $hasFilter = $filters['keyword'] !== ''
                                || $filters['status'] !== ''
                                || $filters['date_from'] !== ''
                                || $filters['date_to'] !== '';
                            ?>
                            <?php if ($hasFilter): ?>
                                No Instagram posts match your filters.
                                <?= $this->Html->link('Reset filters', ['controller' => 'InstagramPosts', 'action' => 'admin_index']) ?>.
                            <?php else: ?>
                                No Instagram posts yet.
                                <?= $this->Html->link('Add one', ['controller' => 'InstagramPosts', 'action' => 'admin_manage']) ?>.
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (!$instagramPosts->isEmpty()) : ?>
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
