<div class="page-content">
	<div class="page-header">
		<h1>Template Presets
			<?php
			echo $this->Html->link(
				'Use Template in New Spec',
				['controller' => 'employees', 'action' => 'employee_send_v3', '?' => ['mode' => 'template']],
				['class' => 'btn btn-success btn-xs top-button']
			);
			?>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover">
					<thead>
						<tr>
							<th>ID</th>
							<th>Template Name</th>
							<th>Type</th>
							<th>Subject</th>
							<th>Specification</th>
							<th>Created</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($templates)): ?>
							<?php foreach ($templates as $tpl): ?>
								<tr>
									<td><?php echo (int)$tpl->id; ?></td>
									<td><?php echo h((string)($tpl->template_name ?? '')); ?></td>
									<td><?php echo h((string)($tpl->type ?? '')); ?></td>
									<td><?php echo h((string)($tpl->subject ?? '')); ?></td>
									<td><?php echo h((string)($tpl->specification ?? '')); ?></td>
									<td><?php echo !empty($tpl->created) ? h(format_db_date('d-M-Y h:i a', (string)$tpl->created)) : '—'; ?></td>
									<td>
										<?php
										echo $this->Html->link(
											'Use',
											['controller' => 'employees', 'action' => 'employee_send_v3', '?' => ['mode' => 'template', 'preset_id' => (int)$tpl->id]],
											['class' => 'btn btn-mini btn-success']
										) . '&nbsp;';
										echo $this->Html->link(
											'Edit Name',
											['controller' => 'employees', 'action' => 'editTemplatePreset', (int)$tpl->id],
											['class' => 'btn btn-mini btn-primary']
										) . '&nbsp;';
										echo $this->Form->postLink(
											'Delete',
											['controller' => 'employees', 'action' => 'deleteTemplatePreset', (int)$tpl->id],
											['class' => 'btn btn-mini btn-default', 'confirm' => 'Delete this template preset?']
										);
										?>
									</td>
								</tr>
							<?php endforeach; ?>
						<?php else: ?>
							<tr>
								<td colspan="7" class="text-center">No template presets found. Save any submitted spec as template from the spec list page.</td>
							</tr>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
