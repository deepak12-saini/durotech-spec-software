<div class="page-content">
		<div class="page-header">
			<h1>EOI Email Logs 
			<?php // echo $this->Html->link('Send Mail',array('controller' => 'mailers','action' => 'eoisend'),array('class'=>'btn btn-info btn-xs top-button')); ?>
			
			<?php //echo $this->Html->link('Download CSV',array('controller' => 'mailers','action' => 'exportcsv'),array('class'=>'btn btn-warning btn-xs top-button')); ?>
			
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
				<thead>
				<tr>
					<th>id</th>
					<th>ReferenceId</th>
					<th>SenderUser</th>
					<th>Individual Name</th>
					<th>Company Name</th>
					<th>Project Name</th>
					<th>Date</th>
					<th>Insert Name</th>
					<th>Mobile No.</th>
					<th>Landline No.</th>
					<th>Sender Email</th>
					<th>Subject</th>
					<th>Client Request</th>
					<th>created</th>
				</tr>
				</thead>
				<tbody>
					<?php 
					
				//	echo '<pre>';
					//print_r($mailers);
					//die();
					
					foreach ($mailers as $mailer):
						$eo = is_object($mailer) ? $mailer : ($mailer['EoiMailer'] ?? []);
						$nu = is_object($mailer) ? ($mailer->napp_user ?? $mailer->nappUser ?? null) : ($mailer['NappUser'] ?? []);
						$eoArr = is_object($eo) ? $eo->toArray() : (is_array($eo) ? $eo : []);
						$nuArr = is_object($nu) ? $nu->toArray() : (is_array($nu) ? $nu : []);
						$nuName = trim(($nuArr['name'] ?? '') . ' ' . ($nuArr['lname'] ?? ''));
					?>
					<tr>
					<td>#<?php echo h($eoArr['id'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($eoArr['mailer_id'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($nuName); ?>&nbsp;</td>
					<td><?php echo h($eoArr['inserindivdualname'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($eoArr['insertcompanyname'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($eoArr['projectname'] ?? ''); ?>&nbsp;</td>
				
					<td><?php echo h($eoArr['date'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($eoArr['insertname'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($eoArr['mobile'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($eoArr['landlineno'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($eoArr['sender_email'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($eoArr['subject'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($eoArr['client_requested'] ?? ''); ?>&nbsp;</td>
				
                    <td><?php echo !empty($eoArr['created']) ? format_db_date('d-M-Y h:i a', $eoArr['created']) : ''; ?></td>
					
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
		$('#example').DataTable();
	} );
</script>