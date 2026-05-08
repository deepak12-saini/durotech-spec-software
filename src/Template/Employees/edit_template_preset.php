<div class="page-content">
	<div class="page-header">
		<h1>Edit Template Preset</h1>
	</div>

	<div class="row">
		<div class="col-xs-12 col-sm-8">
			<?php echo $this->Form->create(null, ['class' => 'form-horizontal']); ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Template Name:</label>
					<div class="col-sm-9">
						<input type="text" name="template_name" class="col-xs-12 col-sm-9" value="<?php echo h((string)($template->template_name ?? '')); ?>" required>
					</div>
				</div>

				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-success btn-sm">Save</button>
						<?php
						echo $this->Html->link(
							'Cancel',
							['controller' => 'employees', 'action' => 'template_presets'],
							['class' => 'btn btn-default btn-sm']
						);
						?>
					</div>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
