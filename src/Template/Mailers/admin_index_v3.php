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
							<th>Send Name</th>
							<th>Name/Attn</th>
							<th>Email</th>
							<th>Company</th>
							<th>Address</th>
							<th>Specification</th>
							<th>Date</th>
							<th>PDF Attachment</th>
							<th>Created</th>
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
							<td><?php echo $mailer['User']['name'].'('.$mailer['User']['username'].')'; ?>&nbsp;</td>
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

							<!-- Created: entity toArray() keeps FrozenTime as object; strtotime(object) fails → epoch -->
							<td><?php
								$created = $mailer['Mailer']['created'] ?? null;
								if ($created instanceof \DateTimeInterface) {
									echo h($created->format('d-M-Y h:i a'));
								} elseif (!empty($created)) {
									$ts = strtotime((string) $created);
									echo $ts ? h(date('d-M-Y h:i a', $ts)) : '—';
								} else {
									echo '—';
								}
							?></td>

							<!-- Action buttons -->
							<td>
								<!-- Edit spec -->
								<a class="btn btn-mini btn-primary" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_editsend_v3', $mailer['Mailer']['id']]); ?>">Edit</a>
								
								<!-- Download PDF -->
								<a class="btn btn-mini btn-info" href="<?php echo h($this->Url->build('/', true) . 'dompdf/' . $pdffilename); ?>" target="_blank">Download</a>
								
								<!-- Send Email -->
								<a onclick="return confirm('Are you sure send email?')" class="btn btn-mini btn-danger" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_sendemail', $mailer['Mailer']['id']]); ?>">Send Mail</a>
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
		"order": [[ 1, "desc" ]] // Sort by second column (Send Name) descending
	});
});
</script>
