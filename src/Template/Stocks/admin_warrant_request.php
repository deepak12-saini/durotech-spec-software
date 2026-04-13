	<style>
		.btn{ margin-bottom:5px; }
	</style>
	 


	<div class="page-content">
		<div class="page-header">
			<h1>Duro Warranty Request</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
				<thead>
				<tr>
					<th style="display:none;">SortId</th>
					<th>Requested Id</th>
					<th>Name</th>
					<th>Email</th>
					<th>Phone</th>
					<th>Project Name</th>							
					<th>Year</th>							
					<th>Status</th>	
					<th>Certificate</th>	
					<th>Date/Time</th>		
					<th>Action</th>		
				</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					$WarrantyRequest = $WarrantyRequest ?? [];
					foreach ($WarrantyRequest as $WarrantyRequests):
						$wr = $WarrantyRequests['WarrantyRequest'] ?? [];
						$wrId = $wr['id'] ?? null;
						$uniqueId = $wrId ? base64_encode(base64_encode(base64_encode((string)$wrId))) : '';
						$status = (int)($wr['status'] ?? 0);
					?>
					<tr>
						<td style="display:none;"><?php echo (int)($wr['id'] ?? 0); ?></td>
						<td><?php echo h($wr['unique_id'] ?? ''); ?></td>
						<td><?php echo h($wr['name'] ?? ''); ?></td>
						<td><?php echo h($wr['email'] ?? ''); ?></td>
						<td><?php echo h($wr['phone'] ?? ''); ?></td>
						<td><?php echo h($wr['project_name'] ?? ''); ?></td>
						<td><?php echo h($wr['year'] ?? ''); ?></td>
						<td>
						<?php
						if ($status == 0) {
							echo "Pending";
						} elseif ($status == 1) {
							echo "Form Sent";
						} elseif ($status == 2) {
							echo "Submited";
						} elseif ($status == 3) {
							echo "Approved";
						}
						?>
						</td>
						<td>
							<?php if (!empty($wr['certificate'])) { ?>
								<a target="_blank" href="<?php echo $this->Url->build('/pdf/FPDI/' . $wr['certificate']); ?>" class="btn btn-xs btn-info">Download</a>
							<?php } ?>
						</td>
						<td><?php echo h($this->DateDisplay->mysqlDate($wr['created'] ?? null, 'd F Y', [$wr['modified'] ?? null])); ?></td>
						<td>
							<?php if ($status < 2) { ?>
								<a href="<?php echo $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_sendformtocsutomer', $uniqueId]); ?>" class="btn btn-xs btn-info">Send Form Request</a>
							<?php } else { ?>
								<a data-toggle="modal" data-target="#myModal_<?php echo $i; ?>" href="#null" class="btn btn-xs btn-info">Form Detail</a>
								<a href="<?php echo $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_preview_warranty_certificate', $uniqueId]); ?>" target="_blank" class="btn btn-xs btn-warning">Preview</a>
								<?php if ($status == 2) { ?>
									<a href="<?php echo $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_approve_warranty_request', $uniqueId]); ?>" class="btn btn-xs btn-success" onclick="return confirm('Approve this submitted request and generate certificate PDF?');">Approve</a>
								<?php } ?>
							<?php } ?>
							<a href="<?php echo $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_delete_warranty_request', $uniqueId]); ?>" class="btn btn-xs btn-danger" onclick="return confirm('Are you sure you want to delete this warranty request? This action cannot be undone.');">Delete</a>
						</td>
					</tr>
					<?php $i++; endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	
</div>	
<?php
	$k = 1;
	foreach ($WarrantyRequest as $WarrantyRequests):
		$wr = $WarrantyRequests['WarrantyRequest'] ?? [];
		$logs = $WarrantyRequests['WarrantyRequestLog'] ?? [];
	?>
	<div id="myModal_<?php echo $k; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Requested Id: <?php echo h($wr['unique_id'] ?? ''); ?></h4>
			</div>
				<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="simple-table" >
							<tbody>
							<?php foreach ($logs as $WarrantyRequestLogs):
								$log = is_array($WarrantyRequestLogs) ? $WarrantyRequestLogs : (is_object($WarrantyRequestLogs) ? $WarrantyRequestLogs->toArray() : []);
							?>
								<tr><th>Serial Number: </th><td><span class="label label-inverse"><?php echo h($log['serialnumber'] ?? ''); ?></span></td></tr>
								<tr><th>Date Of Purchase of Products: </th><td><?php echo !empty($log['dateofpurchase']) ? format_db_date('d/m/Y', $log['dateofpurchase']) : ''; ?></td></tr>
								<tr><th>Product: </th><td><?php echo h($log['product'] ?? ''); ?></td></tr>
								<tr><th>Used As: </th><td><?php echo h($log['used_as'] ?? ''); ?></td></tr>
								<tr><th>Application: </th><td><?php echo h($log['application'] ?? ''); ?></td></tr>
								<tr><th>Area Warranted: </th><td><?php echo h($log['area_warranted'] ?? ''); ?></td></tr>
								<tr><th>Building Address: </th><td><?php echo h($log['building_address'] ?? ''); ?></td></tr>
								<tr><th>Building Name: </th><td><?php echo h($log['building_name'] ?? ''); ?></td></tr>
								<tr><th>Building Area Name: </th><td><?php echo h($log['building_area_name'] ?? ''); ?></td></tr>
								<tr><th>Applicator Active ABN: </th><td><?php echo h($log['applicator_active_abn'] ?? ''); ?></td></tr>
								<tr><th>Applicator Address: </th><td><?php echo h($log['applicator_address'] ?? ''); ?></td></tr>
								<tr><th>Applicator contact Detail: </th><td><?php echo h($log['applicator_contact'] ?? ''); ?></td></tr>
								<tr><th>Applicator: </th><td><?php echo h($log['applicator'] ?? ''); ?></td></tr>
								<tr><th>Requested Warranty Period: </th>
								<td><?php echo (!empty($log['start_requested_warranty']) ? format_db_date('d/m/Y', $log['start_requested_warranty']) : '') . ' To ' . (!empty($log['end_requested_warranty']) ? format_db_date('d/m/Y', $log['end_requested_warranty']) : ''); ?></td></tr>
								<tr><th>Contractors Company Name: </th><td><?php echo h($log['contract_company_name'] ?? ''); ?></td></tr>
								<tr><th>Contractors Full Name: </th><td><?php echo h($log['contract_name'] ?? ''); ?></td></tr>
								<tr><th>Sign_date: </th><td><?php echo !empty($log['sign_date']) ? format_db_date('d/m/Y', $log['sign_date']) : ''; ?></td></tr>
							<?php endforeach; ?>
							</tbody>						
							</table>			
							</div>
						</div>
					</div>				
				</div>				
			</div>				
		</div>				
	</div>	
	<?php $k++; endforeach; ?>	
	<script>
	$(document).ready(function() {
		$('#example').DataTable({
			"order": [[0, "desc"]],
			"displayStart": 0,
			"stateSave": false,
			"columnDefs": [
				{ "targets": [0], "visible": false, "searchable": false }
			]
		});
	} );
	function openpoup(id){
		var url = '<?php echo $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_comment', '_full' => true]); ?>' + id;
		$('#abc_frame').attr('src', url);
		$("#myModalNew").trigger('click');
	}
</script>	