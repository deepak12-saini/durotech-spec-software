	<style>
		.btn{ margin:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Legal Actions 
				<?= $this->Html->link('Send Legal Actions', ['controller' => 'LegalActions', 'action' => 'send'], ['class' => 'btn btn-info btn-xs top-button']) ?>			
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
				<thead>
				<tr>
								
					<th>UniqueId</th>
					<th>Company Name</th>
					<th>Amount</th>									
					<th>Email</th>
					<th>Date</th>
					<th>Created</th>
					<th></th>
		
				</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$legalActionList = $LegalAction ?? [];
					foreach ($legalActionList as $mailer):
						$la = $mailer['LegalAction'] ?? $mailer;
						$uid = $la['unique_id'] ?? '';
						$lid = $la['id'] ?? '';
					?>
					<tr>
					<td><?= h($uid) ?>&nbsp;</td>
					<td><?= h($la['company_name'] ?? '') ?>&nbsp;</td>
					<td>$<?= h($la['amount'] ?? '') ?>&nbsp;</td>
					<td><?= h($la['email'] ?? '') ?>&nbsp;</td>
					<td><?= !empty($la['date']) ? date('d-M-Y', strtotime($la['date'])) : '' ?>&nbsp;</td>
					<td><?= !empty($la['created']) ? date('d-M-Y', strtotime($la['created'])) : '' ?></td>
					<td>
					<?= $this->Html->link('Edit', ['action' => 'edit', $lid], ['class' => 'btn btn-mini btn-warning']) ?>
					<?= $this->Html->link('Send Mail', ['action' => 'sendemails', $lid], ['class' => 'btn btn-mini btn-primary']) ?>
					<a target="_blank" href="<?= h((defined('SITEURL') ? SITEURL : '') . 'dompdf/' . $uid . '.pdf') ?>" class="btn btn-mini btn-info">Download PDF</a>
					</td>
					</tr>
					<?php $i++; endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		

</div>		
<script>
	$(document).ready(function() {
		$('#example').DataTable();
	});

</script>	