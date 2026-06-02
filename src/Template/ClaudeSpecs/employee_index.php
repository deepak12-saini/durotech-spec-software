<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\ORM\ResultSet|\App\Model\Entity\ClaudeSpecDraft[] $claudeSpecDrafts
 */
?>
<?= $this->element('claude_specs_styles'); ?>
<div class="page-content claude-wrap">
    <div class="page-header clearfix">
        <div class="pull-right claude-toolbar">
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

    <div class="claude-card">
        <?php
        $searchVal = isset($search) ? (string)$search : '';
        $statusVal = isset($statusFilter) ? (string)$statusFilter : '';
        $pagerQuery = array_filter(
            $this->request->getQueryParams(),
            static function ($v) {
                return $v !== '' && $v !== null;
            }
        );
        unset($pagerQuery['page']);
        ?>
        <div style="margin-bottom: 12px;">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']); ?>
            <div class="form-group" style="margin-right:8px;">
                <?= $this->Form->text('q', [
                    'class' => 'form-control',
                    'value' => $searchVal,
                    'placeholder' => 'Search track, client, company, email',
                    'style' => 'min-width:280px;',
                ]); ?>
            </div>
            <div class="form-group" style="margin-right:8px;">
                <?= $this->Form->select('status', [
                    '' => 'All statuses',
                    'draft' => 'Draft',
                    'generated' => 'Generated',
                    'applied' => 'Applied',
                ], [
                    'class' => 'form-control',
                    'value' => $statusVal,
                ]); ?>
            </div>
            <?= $this->Form->button('Search', ['class' => 'btn btn-primary', 'type' => 'submit']); ?>
            <?= $this->Html->link('Reset', ['action' => 'employee_index'], ['class' => 'btn btn-default']); ?>
            <?= $this->Form->end(); ?>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover claude-table">
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
                            <tr><td colspan="6" class="claude-empty">No Claude drafts yet. <?= $this->Html->link('Create your first draft', ['action' => 'employee_send']); ?>.</td></tr>
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
                                    <td><span class="label <?= $statusClass; ?> claude-status"><?= h($status); ?></span></td>
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
            <?php $this->Paginator->options(['url' => ['?' => $pagerQuery]]); ?>
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
