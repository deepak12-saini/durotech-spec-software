<div class="page-content">
    <div class="page-header">
        <h1>Create AI Lesson</h1>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-10">
            <?php echo $this->Form->create(null, ['class' => 'form-horizontal']); ?>
            <div class="form-group">
                <label class="col-sm-2 control-label">Lesson Title</label>
                <div class="col-sm-10">
                    <input type="text" name="title" class="form-control" required placeholder="e.g. Waterproofing Basics">
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Source Content</label>
                <div class="col-sm-10">
                    <textarea name="source_content" class="form-control" rows="14" required placeholder="Paste your presentation notes/content here..."></textarea>
                    <p class="help-block">Tip: keep to 300-1200 words for demo.</p>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-success">Generate & Save</button>
                    <?php echo $this->Html->link('Back', ['action' => 'admin_index'], ['class' => 'btn btn-default']); ?>
                </div>
            </div>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
</div>

