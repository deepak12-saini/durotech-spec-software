<div class="page-content">
    <div class="page-header">
        <h1>Instagram Posts</h1>
        <a href="<?= $this->Url->build(['controller' => 'InstagramPosts', 'action' => 'admin_manage']); ?>" class="btn btn-primary pull-right">
            <i class="fa fa-plus"></i> Add Post
        </a>
    </div>

    <p class="text-muted">Manage posts shown in the home page Instagram slider. Paste embed code from Instagram (⋯ → Embed) or a post/reel URL.</p>

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
                            No Instagram posts yet.
                            <?= $this->Html->link('Add one', ['controller' => 'InstagramPosts', 'action' => 'admin_manage']) ?>.
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
