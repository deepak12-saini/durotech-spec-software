<style>
	/* Adds some margin below all buttons */
	.btn { margin-bottom: 5px; }
</style>

<div class="page-content">
	<!-- Page header with title and "Create New Spec" button -->
	<div class="page-header">
		<h1>DuroEzy Specification v3
			<!-- Link to create a new spec (calls send action in MailersController) -->
			<?php echo $this->Html->link('Create New Spec', '/admin/mailers/send_v3', ['class' => 'btn btn-info btn-xs top-button']); ?>
			<?php if (!empty($hasDraft)): ?>
				<?php echo $this->Html->link('Resume Draft', ['controller' => 'Mailers', 'action' => 'admin_send_v3', '?' => ['resume' => '1']], ['class' => 'btn btn-warning btn-xs top-button']); ?>
			<?php endif; ?>
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
					<?php echo $this->Html->link('Reset', ['controller' => 'mailers', 'action' => 'admin_index_v3'], ['class' => 'btn btn-default btn-xs', 'style' => 'margin-bottom:6px;']); ?>
				<?php echo $this->Form->end(); ?>
			</div>
			<!-- Makes the table scrollable if necessary -->
			<div class="table-responsive">
				<!-- Main data table -->
				<table class="table table-striped table-bordered table-hover" id="example">
					<!-- Table header -->
					<thead>
						<tr>
							<th>TrackNumber</th>
							<th>Send Name</th>
							<th>Name/Attn</th>
							<th>Email</th>
							<th>Company</th>
							<th>Address</th>
							<th>Specification</th>
							<th>Date</th>
							<th>PDF Attachment</th>
							<th>Created</th>
							<th>Customer email</th>
							<th>Action</th>
						</tr>
					</thead>

					<!-- Table body -->
					<tbody>
						<?php 
						// Loop through each mailer record from the controller
						foreach ($mailers as $mailer):
							// Use pdf_attachment if available, otherwise construct filename (sanitized)
							if (!empty($mailer['Mailer']['pdf_attachment'])) {
								$pdffilename = basename($mailer['Mailer']['pdf_attachment']); // Get just filename from path
							} else {
								// Sanitize filename to match generatepdf.php logic
								$rawPdfname = $mailer['Mailer']['id'].'-'.$mailer['Mailer']['tracknumber'];
								$pdffilename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $rawPdfname);
								$pdffilename = preg_replace('/_+/', '_', $pdffilename);
								$pdffilename = trim($pdffilename, '_');
								if (empty($pdffilename)) {
									$pdffilename = 'spec_' . $mailer['Mailer']['id'];
								}
								$pdffilename .= '.pdf';
							}
						?>
						<tr>
							<!-- Output data for each column -->
							<td>#<?php echo h($mailer['Mailer']['tracknumber']); ?>&nbsp;</td>
							<td><?php
								$user = $mailer['User'] ?? [];
								$userName = $user['name'] ?? $user['display_name'] ?? $user['username'] ?? '';
								$userUsername = $user['username'] ?? '';
								echo h($userName) . (!empty($userUsername) ? ('(' . h($userUsername) . ')') : '');
							?>&nbsp;</td>
							<td><?php echo h($mailer['Mailer']['name']); ?>&nbsp;</td>
							<td><?php echo h($mailer['Mailer']['email']); ?>&nbsp;</td>
							<td><?php echo h($mailer['Mailer']['company']); ?>&nbsp;</td>
							<td><?php echo h($mailer['Mailer']['address']); ?>&nbsp;</td>
							<td><?php echo h($mailer['Mailer']['specification']); ?>&nbsp;</td>
							<td><?php echo $mailer['Mailer']['date']; ?>&nbsp;</td>

							<!-- PDF View Link -->
							<td>
								<?php if (!empty($mailer['Mailer']['pdf_attachment'])): ?>
									<a href="<?php echo h($this->Url->build('/', true) . $mailer['Mailer']['pdf_attachment']); ?>" target="_blank">View PDF</a>
								<?php else: ?>
									No Attachment
								<?php endif; ?>
							</td>

							<td><?php
								$created = $mailer['Mailer']['created'] ?? null;
								if ($created instanceof \DateTimeInterface) {
									echo h($created->format('d-M-Y h:i a'));
								} elseif (!empty($created)) {
									echo h(format_db_date('d-M-Y h:i a', $created));
								} else {
									echo '—';
								}
							?></td>

							<td>
								<?php
								$specSentAt = $mailer['Mailer']['spec_email_sent_at'] ?? null;
								$specSentTo = $mailer['Mailer']['spec_email_sent_to'] ?? '';
								if (!empty($specSentAt)) {
									$at = $specSentAt instanceof \DateTimeInterface
										? $specSentAt->format('d-M-Y h:i a')
										: format_db_date('d-M-Y h:i a', (string)$specSentAt);
									echo '<span class="label label-success">Sent</span><br><small>' . h($at) . '</small>';
									if ($specSentTo !== '') {
										echo '<br><small class="text-muted">to ' . h($specSentTo) . '</small>';
									}
								} else {
									echo '<span class="label label-default">Not sent</span>';
								}
								?>
							</td>

							<!-- Action buttons -->
							<td>
								<?php
								$specSentAtBtn = $mailer['Mailer']['spec_email_sent_at'] ?? null;
								$sendBtnClass = !empty($specSentAtBtn) ? 'btn btn-mini btn-warning' : 'btn btn-mini btn-danger';
								?>
								<!-- Edit spec -->
								<a class="btn btn-mini btn-primary js-edit-spec" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_editsend_v3', $mailer['Mailer']['id']]); ?>">Edit</a>
								
								<!-- Download PDF -->
								<a class="btn btn-mini btn-info" href="<?php echo h($this->Url->build('/', true) . 'dompdf/' . $pdffilename); ?>" target="_blank">Download</a>
								
								<!-- Send Email -->
								<a onclick="return confirm('Are you sure send email?')" class="<?php echo h($sendBtnClass); ?>" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_sendemail', $mailer['Mailer']['id']]); ?>">Send Mail</a>
								<a class="btn btn-mini btn-default" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_audit_log', $mailer['Mailer']['id']]); ?>">Audit</a>
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
	var dt = $('#example').DataTable({
		"order": [[ 1, "desc" ]] // Sort by second column (Send Name) descending
	});

	// Restore DataTables page from URL query (?page=N).
	var params = new URLSearchParams(window.location.search || '');
	var pageParam = parseInt(params.get('page') || '1', 10);
	if (!isNaN(pageParam) && pageParam > 1) {
		var targetIndex = pageParam - 1; // DataTables is 0-based
		if (targetIndex < dt.page.info().pages) {
			dt.page(targetIndex).draw('page');
		}
	}

	// Preserve current DataTables page while opening edit.
	$(document).on('click', 'a.js-edit-spec', function() {
		var currentPage = (dt.page.info().page || 0) + 1; // 1-based for URL
		var href = ($(this).attr('href') || '').split('?')[0];
		if (!href) return;
		$(this).attr('href', href + '?page=' + currentPage);
	});
});
</script>
