<style>
	/* Adds some margin below all buttons */
	.btn { margin-bottom: 5px; }
</style>

<div class="page-content">
	<!-- Page header with title and "Create New Spec" button -->
	<div class="page-header">
		<h1>DuroEzy Specification Approved Request
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
							<!-- <th>Send Name</th> -->
							<th>Name/Attn</th>
							<th>Email</th>
							<th>Project</th>
							<th>Address</th>
							<th>Specification</th>
							<th>Date</th>
							<th>PDF Attachment</th>
							<th>Created</th>
							<th>Is Approved</th>
							<th>Action</th>
						</tr>
					</thead>

					<!-- Table body -->
					<tbody>
						<?php
						// CakePHP 3: $mailer is an Entity; use property access
						foreach ($mailers as $mailer):
							$pdfUrl = !empty($mailer->pdf_attachment)
								? ($this->Url->build('/', true) . ltrim((string)$mailer->pdf_attachment, '/'))
								: null;
							if (!$pdfUrl) {
								$pdfBaseName = (string)($mailer->id ?? '') . '-' . (string)($mailer->tracknumber ?? '');
								$pdfBaseName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $pdfBaseName);
								$pdfBaseName = preg_replace('/_+/', '_', (string)$pdfBaseName);
								$pdfBaseName = trim((string)$pdfBaseName, '_');
								if ($pdfBaseName !== '') {
									$pdfUrl = $this->Url->build('/', true) . 'dompdf/' . $pdfBaseName . '.pdf';
								}
							}
						?>
						<tr>
							<td>#<?php echo h($mailer->tracknumber ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailer->name ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailer->email ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailer->company ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailer->address ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailer->specification ?? ''); ?>&nbsp;</td>
							<td><?php
								$specDate = (string)($mailer->date ?? '');
								if ($specDate === '1970-01-01' || $specDate === '0000-00-00' || $specDate === '') {
									echo h(!empty($mailer->created) ? format_db_date('Y-m-d', $mailer->created) : '—');
								} else {
									echo h(format_db_date('Y-m-d', $specDate));
								}
							?>&nbsp;</td>

							<td>
								<?php if ($pdfUrl): ?>
									<a href="<?php echo h($pdfUrl); ?>" target="_blank">View PDF</a>
								<?php else: ?>
									No Attachment
								<?php endif; ?>
							</td>

							<td><?php echo $mailer->created ? format_db_date('d-M-Y h:i a', $mailer->created) : ''; ?></td>

							<td>
								<?php if (!empty($mailer->is_approved) && (int)$mailer->is_approved === 1): ?>
									<span class="label label-success">Approved</span>
								<?php else: ?>
									<a href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_toggle_approval', $mailer->id], true); ?>"
										class="label label-danger"
										onclick="return confirm('Are you sure you want to approve this spec?')">
										Pending
									</a>
								<?php endif; ?>
							</td>

							<td>
								<a class="btn btn-mini btn-primary" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_editsend_v3', $mailer->id], true); ?>">Edit</a>
								<?php if ($pdfUrl): ?>
									<a class="btn btn-mini btn-info" href="<?php echo h($pdfUrl); ?>" target="_blank" download>Download</a>
								<?php else: ?>
									<span class="btn btn-mini btn-default" title="Generate PDF from Edit page">No PDF</span>
								<?php endif; ?>
								<a onclick="return confirm('Are you sure send email?')" class="btn btn-mini btn-danger" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_sendemail', $mailer->id], true); ?>">Send Mail</a>
								<?php echo $this->Form->postLink('Delete', ['controller' => 'Mailers', 'action' => 'admin_delete_spec_request', $mailer->id], ['class' => 'btn btn-mini btn-default', 'confirm' => 'Delete this spec request? This cannot be undone.']); ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<!-- Initialize DataTable (jQuery plugin for searchable/sortable tables) -->
<script>
$(document).ready(function() {
	$('#example').DataTable({
		"order": [] // Keep backend order (Mailer.id DESC)
	});
});
</script>
