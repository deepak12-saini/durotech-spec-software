		<style>
		.btn{ margin-bottom:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>DuroEzy Specification
			<?php echo $this->Html->link('Create New Spec', ['controller' => 'Mailers', 'action' => 'admin_send'], ['class' => 'btn btn-info btn-xs top-button']); ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
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
					<th>Status</th>

					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php 
					
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
					<td><?php echo $mailer['Mailer']['date'] ?>&nbsp;</td>
					<td>
						<?php if (!empty($mailer['Mailer']['pdf_attachment'])): ?>
							<a href="<?php echo h(\Cake\Routing\Router::url('/', true) . $mailer['Mailer']['pdf_attachment']); ?>" target="_blank">View PDF</a>
						<?php else: ?>
							No Attachment
						<?php endif; ?>
					</td>
					
					<!-- <td><?php if($mailer['Mailer']['type'] == 3){ echo 'External Liquid WPM'; } ?></td>					
					<td><?php echo h($mailer['Mailer']['subject']); ?></td>			 -->		
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
						<?php $saveStatus = $mailer['Mailer']['save_status'] ?? ''; ?>
						<?php if ($saveStatus === 'draft'): ?>
							<span class="badge badge-warning">Draft</span>
						<?php else: ?>
							<span class="badge badge-success">Final</span>
						<?php endif; ?>
					</td>

					<td>
						<a class="btn btn-mini btn-primary" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_editsend', $mailer['Mailer']['id']]); ?>">Edit</a>
						
						 <?php if ($saveStatus !== 'draft'): ?>
							<a class="btn btn-mini btn-info" href="<?php echo h(\Cake\Routing\Router::url('/', true) . 'dompdf/' . $pdffilename); ?>" target="_blank">Download</a>
						<?php endif; ?>
							<a onclick="retrun confirm('Are you sure send email?')" class="btn btn-mini btn-danger" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_sendemail', $mailer['Mailer']['id']]); ?>">Send Mail</a>
					</td>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	
</div>	
<script>	
$(document).ready(function() {
		$('#example').DataTable({
			"order": [[ 1, "desc" ]] 
		});
	} );
</script>