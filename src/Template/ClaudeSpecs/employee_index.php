<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\ResultSet|\App\Model\Entity\ClaudeSpecDraft[] $claudeSpecDrafts
 */
?>
<div class="page-content">
    <div class="page-header clearfix">
        <div class="pull-right">
            <?= $this->Html->link(
                '<i class="ace-icon fa fa-plus"></i> New Claude draft',
                ['action' => 'employee_send'],
                ['class' => 'btn btn-success', 'escape' => false]
            ); ?>
        </div>
        <h1>
            Claude Spec Assistant
            <small><i class="ace-icon fa fa-angle-double-right"></i> AI-assisted specification drafts</small>
        </h1>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Track #</th>
                            <th>Client / Company</th>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($claudeSpecDrafts->count() === 0): ?>
                            <tr>
                                <td colspan="6" class="text-center text-muted" style="padding:24px;">
                                    No Claude drafts yet.
                                    <?= $this->Html->link('Create your first draft', ['action' => 'employee_send']); ?>.
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($claudeSpecDrafts as $draft): ?>
                                <?php
                                $status = (string)($draft->status ?? 'draft');
                                $statusClass = 'label-default';
                                if ($status === 'generated') {
                                    $statusClass = 'label-info';
                                } elseif ($status === 'applied') {
                                    $statusClass = 'label-success';
                                }
                                $label = trim((string)$draft->client_name);
                                if ($label === '') {
                                    $label = trim((string)$draft->company);
                                }
                                if ($label === '') {
                                    $label = mb_substr(trim((string)$draft->project_brief), 0, 60);
                                }
                                ?>
                                <tr>
                                    <td><?= (int)$draft->id; ?></td>
                                    <td><?= h($draft->tracknumber); ?></td>
                                    <td><?= h($label); ?></td>
                                    <td><span class="label <?= $statusClass; ?>"><?= h($status); ?></span></td>
                                    <td><?= $draft->created ? $draft->created->format('d/m/Y H:i') : ''; ?></td>
                                    <td>
                                        <?= $this->Html->link('View', ['action' => 'employee_view', $draft->id], ['class' => 'btn btn-xs btn-info']); ?>
                                        <?= $this->Html->link('Edit', ['action' => 'employee_edit', $draft->id], ['class' => 'btn btn-xs btn-primary']); ?>
                                        <?php if ($status !== 'applied'): ?>
                                            <?= $this->Form->postLink(
                                                'Apply to DuroEzy',
                                                ['action' => 'employee_apply', $draft->id],
                                                [
                                                    'class' => 'btn btn-xs btn-success',
                                                    'confirm' => 'Load this draft into the DuroEzy specification form for review?',
                                                ]
                                            ); ?>
                                        <?php endif; ?>
                                        <?= $this->Form->postLink(
                                            'Delete',
                                            ['action' => 'employee_delete', $draft->id],
                                            [
                                                'class' => 'btn btn-xs btn-danger',
                                                'confirm' => 'Delete this Claude draft?',
                                            ]
                                        ); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="clearfix">
                <ul class="pagination pagination-sm pull-left">
                    <?= $this->Paginator->prev('< ' . __('previous')); ?>
                    <?= $this->Paginator->numbers(['modulus' => 4]); ?>
                    <?= $this->Paginator->next(__('next') . ' >'); ?>
                </ul>
                <p class="text-muted pull-right" style="margin:8px 0 0;">
                    <?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')); ?>
                </p>
            </div>
        </div>
    </div>
</div>
