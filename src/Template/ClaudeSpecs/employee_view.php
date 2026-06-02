<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClaudeSpecDraft $draft
 * @var array<string, mixed> $payload
 */
$header = $payload['header'] ?? [];
$comments = $payload['comments'] ?? [];
$products = $payload['products'] ?? [];
$status = (string)($draft->status ?? 'draft');
?>
<?= $this->element('claude_specs_styles'); ?>
<div class="page-content claude-wrap">
    <div class="page-header clearfix">
        <div class="pull-right claude-toolbar">
            <?= $this->Html->link('Edit', ['action' => 'employee_edit', $draft->id], ['class' => 'btn btn-primary']); ?>
            <?php if ($status !== 'applied'): ?>
                <?= $this->Form->postLink(
                    'Apply to DuroEzy',
                    ['action' => 'employee_apply', $draft->id],
                    ['class' => 'btn btn-success', 'confirm' => 'Load into DuroEzy form for review?']
                ); ?>
                <?= $this->Form->postLink(
                    'Regenerate with Claude',
                    ['action' => 'employee_regenerate', $draft->id],
                    ['class' => 'btn btn-warning', 'confirm' => 'Replace current content with a new Claude generation?']
                ); ?>
            <?php endif; ?>
            <?= $this->Html->link('Back to list', ['action' => 'employee_index'], ['class' => 'btn btn-default']); ?>
        </div>
        <h1>Claude draft <?= h($draft->tracknumber); ?></h1>
    </div>

    <div class="claude-card">
    <p><strong>Status:</strong> <span class="label label-info claude-status"><?= h($status); ?></span>
        <?php if (!empty($draft->applied_mailer_id)): ?>
            — applied to mailer #<?= (int)$draft->applied_mailer_id; ?>
        <?php endif; ?>
    </p>

    <h4>Project brief</h4>
    <p class="well well-sm"><?= nl2br(h((string)$draft->project_brief)); ?></p>

    <h4>Header (DuroEzy)</h4>
    <table class="table table-bordered table-condensed claude-table">
        <tr><th>Name</th><td><?= h($header['name'] ?? $draft->client_name); ?></td></tr>
        <tr><th>Email</th><td><?= h($header['email'] ?? $draft->email); ?></td></tr>
        <tr><th>Project</th><td><?= h($header['company'] ?? $draft->company); ?></td></tr>
        <tr><th>Address</th><td><?= h($header['address'] ?? $draft->address); ?></td></tr>
        <tr><th>Specification</th><td><?= h($header['specification'] ?? ''); ?></td></tr>
        <tr><th>Subject</th><td><?= h($header['subject'] ?? ''); ?></td></tr>
        <tr><th>Date</th><td><?= h($header['date'] ?? ''); ?></td></tr>
    </table>

    <h4>Comments</h4>
    <?php if (empty($comments)): ?>
        <p class="text-muted">None</p>
    <?php else: ?>
        <ol>
            <?php foreach ($comments as $c): ?>
                <li><?= h((string)$c); ?></li>
            <?php endforeach; ?>
        </ol>
    <?php endif; ?>

    <h4>Products / sections</h4>
    <div class="table-responsive">
        <table class="table table-striped table-bordered claude-table">
            <thead>
                <tr>
                    <th>Section</th>
                    <th>Serial</th>
                    <th>Product</th>
                    <th>Coverage</th>
                    <th>M²/pack</th>
                    <th>Warranty</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $row): ?>
                    <tr>
                        <td><?= h($row['title'] ?? ''); ?></td>
                        <td><?= h($row['serial'] ?? ''); ?></td>
                        <td><?= h($row['product'] ?? ''); ?></td>
                        <td><?= h($row['coverage'] ?? ''); ?></td>
                        <td><?= h($row['coverage_by_pack'] ?? ''); ?></td>
                        <td><?= h($row['Warranty'] ?? ''); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
</div>
