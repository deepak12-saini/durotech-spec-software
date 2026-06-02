<?php
/**
 * @var \App\View\AppView $this
 * @var string $tracknumber
 */
?>
<?= $this->element('claude_specs_styles'); ?>
<div class="page-content claude-wrap">
    <div class="page-header">
        <h1>
            New Claude Spec draft
            <small><i class="ace-icon fa fa-angle-double-right"></i> <?= h($tracknumber); ?></small>
        </h1>
    </div>

    <div class="alert alert-warning claude-card" style="padding:12px 14px;">
        <strong>Human review required.</strong> Claude suggests content only. Review and edit before applying to DuroEzy or submitting to a client.
    </div>

    <div class="row">
        <div class="col-xs-12 col-md-10">
            <div class="claude-card">
            <?= $this->Form->create(null, ['class' => 'form-horizontal']); ?>
            <div class="form-group">
                <label class="col-sm-3 control-label">Client name</label>
                <div class="col-sm-9">
                    <?= $this->Form->text('client_name', ['class' => 'form-control', 'placeholder' => 'Attn / contact name']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Project / company</label>
                <div class="col-sm-9">
                    <?= $this->Form->text('company', ['class' => 'form-control', 'placeholder' => 'Project name']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Email</label>
                <div class="col-sm-9">
                    <?= $this->Form->email('email', ['class' => 'form-control']); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Address</label>
                <div class="col-sm-9">
                    <?= $this->Form->textarea('address', ['class' => 'form-control', 'rows' => 2]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label">Project brief <span class="text-danger">*</span></label>
                <div class="col-sm-9">
                    <?= $this->Form->textarea('project_brief', [
                        'class' => 'form-control',
                        'rows' => 8,
                        'required' => true,
                        'placeholder' => "Describe the project: areas to waterproof, substrate, building type, standards, warranty expectations, products if known…",
                    ]); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    <button type="submit" class="btn btn-primary"><i class="ace-icon fa fa-magic"></i> Generate with Claude</button>
                    <?= $this->Html->link('Cancel', ['action' => 'employee_index'], ['class' => 'btn btn-default']); ?>
                </div>
            </div>
            <?= $this->Form->end(); ?>
            </div>
        </div>
    </div>
</div>
