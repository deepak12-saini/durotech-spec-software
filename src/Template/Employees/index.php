<style>
	/* Adds some margin below all buttons */
	.btn { margin-bottom: 5px; }
</style>

<div class="page-content">
	<!-- Page header with title and "Create New Spec" button -->
	<div class="page-header">
		<h1>DuroEzy Specification
			<!-- Link to create a new spec (calls send action in MailersController) -->
			<?php echo $this->Html->link('Create New Spec', array('controller' => 'employees','action' => 'employee_send_v3'), array('class'=>'btn btn-info btn-xs top-button')); ?>
		</h1>
	</div>

	<!-- Main content row -->
	<div class="row">
		<div class="col-xs-12">
			<!-- Makes the table scrollable if necessary -->
			<div class="table-responsive">
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
										echo date('d-M-Y h:i a', strtotime(trim($created)));
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
										echo $this->Html->link('Edit', array('controller' => 'employees', 'action' => 'editsend_v3', $mailerId), array('class' => 'btn btn-mini btn-primary')) . '&nbsp;';
									} else {
										echo $this->Html->link('Edit', array('controller' => 'employees', 'action' => 'editsend_v3', $mailerId), array('class' => 'btn btn-mini btn-primary')) . '&nbsp;';

										// Only allow download once submitted
										//echo $this->Html->link('Download', SITEURL . 'dompdf/' . $pdffilename, array('class' => 'btn btn-mini btn-info', 'target' => '_blank'));
									}
									echo $this->Html->link('Send Mail', array('controller' => 'employees', 'action' => 'emp_sendemail', $mailerId), array('class' => 'btn btn-mini btn-danger', 'onclick' => 'return confirm("Are you sure send email?")'));


									echo $this->Html->link('Download', SITEURL . 'dompdf/' . $pdffilename, array('class' => 'btn btn-mini btn-info', 'target' => '_blank')) . '&nbsp;';

								?>
							</td>

						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="text-center" style="margin-top: 10px;">
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
