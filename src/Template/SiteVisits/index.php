	<style>
		.btn{ margin:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Site Visit 
				<?= $this->Html->link('Send Mailer', ['controller' => 'SiteVisits', 'action' => 'send'], ['class' => 'btn btn-info btn-xs top-button']) ?>			
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
				<thead>
				<tr>
					<th>S. no</th>					
					<th>VisitId</th>
					<th>Product Name</th>
					<th>Company Name</th>
					<th>Customer Name</th>
					<th>Project Name</th>
					<th>Date</th>
					<th>Subject</th>
					<th>Send By</th>
					<th>Created</th>
					<th></th>
		
				</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$sitevisitList = $sitevisit ?? [];
					foreach ($sitevisitList as $mailer):
						$sv = $mailer['SiteVisit'] ?? $mailer;
						$dateVal = $sv['date'] ?? null;
						$createdVal = $sv['created'] ?? null;
						$dateStr = is_object($dateVal) && method_exists($dateVal, 'format') ? $dateVal->format('d-M-Y') : ($dateVal ? date('d-M-Y', strtotime((string)$dateVal)) : '');
						$createdStr = is_object($createdVal) && method_exists($createdVal, 'format') ? $createdVal->format('d-M-Y') : ($createdVal ? date('d-M-Y', strtotime((string)$createdVal)) : '');
					?>
					<tr>
					<td>#<?= $i ?>&nbsp;</td>
					<td><?= h($sv['visit_id'] ?? '') ?>&nbsp;</td>
					<td><?= h($sv['userarea'] ?? '') ?>&nbsp;</td>
					<td><?= h($sv['company_name'] ?? '') ?>&nbsp;</td>
					<td><?= h($sv['customer_name'] ?? '') ?>&nbsp;</td>
					<td><?= h($sv['project_name'] ?? '') ?>&nbsp;</td>
					<td><?= $dateStr ?>&nbsp;</td>
					<td><?= h($sv['subject'] ?? '') ?>&nbsp;</td>
					<td><?= h($sv['send_from'] ?? '') ?>&nbsp;</td>
					<td><?= $createdStr ?></td>
					<td>
					<?= $this->Html->link('Edit', ['action' => 'edit', $sv['id'] ?? ''], ['class' => 'btn btn-mini btn-warning']) ?>
					<?= $this->Html->link('Send Mail', ['action' => 'sendemails', $sv['id'] ?? ''], ['class' => 'btn btn-mini btn-primary']) ?>
					<?= $this->Html->link('Download PDF', ['action' => 'downloadPdf', $sv['id'] ?? ''], ['class' => 'btn btn-mini btn-info', 'target' => '_blank']) ?>
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