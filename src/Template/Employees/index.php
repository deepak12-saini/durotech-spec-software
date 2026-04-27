<style>
	/* Adds some margin below all buttons */
	.btn { margin-bottom: 5px; }
</style>

<div class="page-content">
	<!-- Page header with title and spec actions -->
	<div class="page-header">
		<h1>DuroEzy Specification
			<?php
			// Create New Spec: always opens an empty form (no draft loaded)
			echo $this->Html->link('Create New Spec', ['controller' => 'employees', 'action' => 'employee_send_v3'], ['class' => 'btn btn-info btn-xs top-button']);
			// Resume Draft: only when a draft exists; loads the saved draft
			if (!empty($hasDraft)) {
				echo ' ';
				echo $this->Html->link('Resume Draft', ['controller' => 'employees', 'action' => 'employee_send_v3', '?' => ['resume' => '1']], ['class' => 'btn btn-warning btn-xs top-button']);
			}
			?>
		</h1>
	</div>

	<!-- Main content row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="well well-sm" style="margin-bottom:12px;">
				<?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']); ?>
					<input type="text" name="tracknumber" class="form-control input-sm" placeholder="Track Number" value="<?php echo h($filters['tracknumber'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="text" name="name" class="form-control input-sm" placeholder="Name/Attn" value="<?php echo h($filters['name'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="text" name="email" class="form-control input-sm" placeholder="Email" value="<?php echo h($filters['email'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="text" name="company" class="form-control input-sm" placeholder="Company" value="<?php echo h($filters['company'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="text" name="specification" class="form-control input-sm" placeholder="Specification" value="<?php echo h($filters['specification'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="date" name="date_from" class="form-control input-sm" value="<?php echo h($filters['date_from'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="date" name="date_to" class="form-control input-sm" value="<?php echo h($filters['date_to'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<button type="submit" class="btn btn-primary btn-xs" style="margin-right:6px;margin-bottom:6px;">Filter</button>
					<?php echo $this->Html->link('Reset', ['controller' => 'employees', 'action' => 'index'], ['class' => 'btn btn-default btn-xs', 'style' => 'margin-bottom:6px;']); ?>
				<?php echo $this->Form->end(); ?>
			</div>

			<!-- Makes the table scrollable if necessary -->
			<div class="table-responsive">
				<div class="clearfix" style="margin-bottom:8px;">
					<div class="pull-right" style="max-width:280px;">
						<input type="text" id="employeeTableSearch" class="form-control input-sm" placeholder="Search in current table...">
					</div>
				</div>
				<!-- Main data table -->
				<table class="table table-striped table-bordered table-hover" id="example">
					<!-- Table header -->
					<thead>
						<tr>
							<th>TrackNumber</th>
							<th>Employee Name</th>
							<th>Name/Attn</th>
							<th>Email</th>
							<th>Company</th>
							<th>Address</th>
							<th>Specification</th>
							<th>Date</th>
							<th>PDF Attachment</th>
							<th>Approve Status</th>
							<th>Revision</th>
							<th>Created</th>
							<th>Action</th>
						</tr>
					</thead>

					<!-- Table body -->
					<tbody>
						<?php 
						// Loop through each mailer record from the controller
						foreach ($mailers as $mailer):
							// Support both CakePHP 2 arrays and CakePHP 3 entities.
							if (is_array($mailer) && isset($mailer['Mailer'])) {
								$mailerData = (array)$mailer['Mailer'];
							} elseif (is_object($mailer) && method_exists($mailer, 'toArray')) {
								$mailerData = (array)$mailer->toArray();
							} else {
								$mailerData = (array)$mailer;
							}

							if (is_array($mailer) && isset($mailer['Employee'])) {
								$employeeData = (array)$mailer['Employee'];
							} elseif (is_object($mailer) && isset($mailer->employee) && $mailer->employee) {
								$employeeData = method_exists($mailer->employee, 'toArray') ? (array)$mailer->employee->toArray() : (array)$mailer->employee;
							} else {
								$employeeData = [];
							}

							$mailerId = $mailerData['id'] ?? null;
							$tracknumber = $mailerData['tracknumber'] ?? '';
							$pdfBaseName = $mailerId . '-' . $tracknumber;
							$pdfBaseName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', (string)$pdfBaseName);
							$pdfBaseName = preg_replace('/_+/', '_', (string)$pdfBaseName);
							$pdfBaseName = trim((string)$pdfBaseName, '_');
							if ($pdfBaseName === '') {
								$pdfBaseName = 'spec_' . (string)$mailerId;
							}
							$pdffilename = $pdfBaseName . '.pdf';
						?>
						<tr>
							<!-- Output data for each column -->
							<td>#<?php echo h($tracknumber); ?>&nbsp;</td>
							<td><?php echo h($employeeData['name'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['name'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['email'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['company'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['address'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['specification'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['date'] ?? ''); ?>&nbsp;</td>

							<!-- PDF View Link -->
							<td>
								<?php if (!empty($mailerData['pdf_attachment'])): ?>
									<a href="<?php echo SITEURL . ltrim((string)$mailerData['pdf_attachment'], '/'); ?>" target="_blank">View PDF</a>
								<?php else: ?>
									No Attachment
								<?php endif; ?>
							</td>

							<td>
								<?php
									$status = (int)($mailerData['status'] ?? 0);
									$is_review = (int)($mailerData['is_review'] ?? 0);

									if ($is_review === 0) {
										echo '<span class="label label-warning">Pending Review</span>';
									} elseif ($is_review === 1 && $status === 0) {
										echo '<span class="label label-info">Reviewed - Awaiting Approval</span>';
									} elseif ($is_review === 1 && $status === 1) {
										echo '<span class="label label-success">Approved</span>';
									} else {
										echo '<span class="label label-default">Unknown</span>';
									}
								?>
							</td>


							<td><?php echo h($mailerData['revision'] ?? 0); ?></td>


							<!-- Created Date -->
							<td>
								<?php
								$created = $mailerData['created'] ?? null;

								if (!empty($created)) {
									if ($created instanceof \DateTimeInterface) {
										echo $created->format('d-M-Y h:i a');
									} else {
										echo format_db_date('d-M-Y h:i a', trim($created));
									}
								}
								?>
								</td>


							<!-- Action buttons -->
							<td>
								<?php
									$is_review = (int)($mailerData['is_review'] ?? 0);

									// Allow edit, send, download if not submitted yet
									if ($is_review === 0) {
										echo $this->Html->link('Edit', ['controller' => 'employees', 'action' => 'editsend_v3', $mailerId, '?' => ['page' => (int)$this->request->getQuery('page')]], ['class' => 'btn btn-mini btn-primary']) . '&nbsp;';
									} else {
										echo $this->Html->link('Edit', ['controller' => 'employees', 'action' => 'editsend_v3', $mailerId, '?' => ['page' => (int)$this->request->getQuery('page')]], ['class' => 'btn btn-mini btn-primary']) . '&nbsp;';

										// Only allow download once submitted
										//echo $this->Html->link('Download', SITEURL . 'dompdf/' . $pdffilename, array('class' => 'btn btn-mini btn-info', 'target' => '_blank'));
									}
									echo $this->Html->link('Send Mail', array('controller' => 'employees', 'action' => 'emp_sendemail', $mailerId), array('class' => 'btn btn-mini btn-danger', 'onclick' => 'return confirm("Are you sure send email?")'));

									echo $this->Html->link('History', array('controller' => 'employees', 'action' => 'audit_log', $mailerId), array('class' => 'btn btn-mini btn-default')) . '&nbsp;';

									echo $this->Html->link('Download', SITEURL . 'dompdf/' . $pdffilename, array('class' => 'btn btn-mini btn-info', 'target' => '_blank')) . '&nbsp;';

									echo $this->Form->postLink('Delete', array('controller' => 'employees', 'action' => 'deleteSpec', $mailerId), array('class' => 'btn btn-mini btn-xs btn-default', 'confirm' => 'Delete this spec? This cannot be undone.', 'escape' => false));

								?>
							</td>

						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="text-center" style="margin-top: 10px;">
				<?php $this->Paginator->options(['url' => array_filter((array)($filters ?? []), function ($v) { return $v !== null && $v !== ''; })]); ?>
				<ul class="pagination" style="margin:0;">
					<?php echo $this->Paginator->first('<< First'); ?>
					<?php echo $this->Paginator->prev('< Prev'); ?>
					<?php echo $this->Paginator->numbers(); ?>
					<?php echo $this->Paginator->next('Next >'); ?>
					<?php echo $this->Paginator->last('Last >>'); ?>
				</ul>
				<div style="margin-top:6px;">
					<?php echo $this->Paginator->counter('{{start}}-{{end}} of {{count}} records'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
(function () {
	var input = document.getElementById('employeeTableSearch');
	var table = document.getElementById('example');
	if (!input || !table) return;
	var tbody = table.getElementsByTagName('tbody')[0];
	if (!tbody) return;

	input.addEventListener('input', function () {
		var q = (input.value || '').toLowerCase().trim();
		var rows = tbody.getElementsByTagName('tr');
		for (var i = 0; i < rows.length; i++) {
			var text = (rows[i].innerText || rows[i].textContent || '').toLowerCase();
			rows[i].style.display = (q === '' || text.indexOf(q) !== -1) ? '' : 'none';
		}
	});
})();
</script>
