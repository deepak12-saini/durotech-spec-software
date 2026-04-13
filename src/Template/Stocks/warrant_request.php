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
					foreach ($WarrantyRequest as $WarrantyRequests):	
						$uniqueId = base64_encode(base64_encode(base64_encode($WarrantyRequests['WarrantyRequest']['id'])));
					?>
					<tr>						
						<td><?php echo $WarrantyRequests['WarrantyRequest']['unique_id']; ?></td>
						<td><?php echo $WarrantyRequests['WarrantyRequest']['name']; ?></td>
						<td><?php echo $WarrantyRequests['WarrantyRequest']['email']; ?></td>
						<td><?php echo $WarrantyRequests['WarrantyRequest']['phone']; ?></td>
						<td><?php echo $WarrantyRequests['WarrantyRequest']['project_name']; ?></td>
						<td><?php echo $WarrantyRequests['WarrantyRequest']['year']; ?></td>
						<td>
						<?php 
						if($WarrantyRequests['WarrantyRequest']['status'] == 0){
							echo "Pending";
						}else if($WarrantyRequests['WarrantyRequest']['status'] == 1){ 
							echo "Form Sent"; 
						}else if($WarrantyRequests['WarrantyRequest']['status'] == 2){ 
							echo "Submited"; 
						}else if($WarrantyRequests['WarrantyRequest']['status'] == 3){ 
							echo "Completed"; 
						}  
						?>
						</td>		
						
						<td>						
							<?php if(!empty($WarrantyRequests['WarrantyRequest']['certificate'])){ ?>
								<a target="_blank" href="<?php echo SITEURL.'pdf/FPDI/'.$WarrantyRequests['WarrantyRequest']['certificate']; ?>" class="btn btn-xs btn-info">Download</a>
							<?php } ?>
						</td>
						<td><?php
							$wrRow = $WarrantyRequests['WarrantyRequest'] ?? [];
							echo h($this->DateDisplay->mysqlDate($wrRow['created'] ?? null, 'd F Y', [$wrRow['modified'] ?? null]));
						?></td>
						<td>
						
							<?php if($WarrantyRequests['WarrantyRequest']['status'] < 2){ ?>
								<a href="<?php echo SITEURL.'stocks/sendformtocsutomer/'.$uniqueId?>" class="btn btn-xs btn-info">Send Form Request</a>
							<?php }else{ ?>
								<a data-toggle="modal" data-target="#myModal_<?php echo $i; ?>" href="#null" class="btn btn-xs btn-info" >Form Detail</a>
							<?php } ?>
							
							<?php if($WarrantyRequests['WarrantyRequest']['status'] == 2){ ?>
								<a href="<?php echo SITEURL.'stocks/change_status/'.$WarrantyRequests['WarrantyRequest']['id']; ?>" class="btn btn-xs btn-warning">Complete</a>
							<?php } ?>
							
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
	$k=1;
	foreach ($WarrantyRequest as $WarrantyRequests): 				
	?>
	<div id="myModal_<?php echo $k; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Requested Id: <?php echo h($WarrantyRequests['WarrantyRequest']['unique_id']); ?></h4>
			</div>
				<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="simple-table" >
							<tbody>
							<?php foreach ($WarrantyRequests['WarrantyRequestLog'] as $WarrantyRequestLogs){ ?>
							
								<tr><th>Serial Number: </th><td><span class="label label-inverse"><?php echo $WarrantyRequestLogs['serialnumber']; ?></span></td></tr>	
								<tr><th>Date Of Purchase of Products: </th><td><?php echo date('d/m/Y',strtotime($WarrantyRequestLogs['dateofpurchase'])); ?></td></tr>	
								<tr><th>Product: </th><td><?php echo $WarrantyRequestLogs['product']; ?></td></tr>	
								<tr><th>Used As: </th><td><?php echo $WarrantyRequestLogs['used_as']; ?></td></tr>	
								<tr><th>Application: </th><td><?php echo $WarrantyRequestLogs['application']; ?></td></tr>	
								<tr><th>Area Warranted: </th><td><?php echo $WarrantyRequestLogs['area_warranted']; ?></td></tr>									
								<tr><th>Building Address: </th><td><?php echo $WarrantyRequestLogs['building_address']; ?></td></tr>	
								<tr><th>Building Name: </th><td><?php echo $WarrantyRequestLogs['building_name']; ?></td></tr>	
								<tr><th>Requested Warranty Period: </th>
								<td><?php echo date('d/m/Y',strtotime($WarrantyRequestLogs['start_requested_warranty'])).' To '.date('d/m/Y',strtotime($WarrantyRequestLogs['end_requested_warranty'])); ?></td></tr>	
								
								<tr><th>Building Name: </th><td><?php echo $WarrantyRequestLogs['building_area_name']; ?></td></tr>	
								<tr><th>Applicator Active ABN: </th><td><?php echo $WarrantyRequestLogs['applicator_active_abn']; ?></td></tr>	
								<tr><th>Applicator Address: </th><td><?php echo $WarrantyRequestLogs['applicator_address']; ?></td></tr>	
								<tr><th>Applicator contact Detail: </th><td><?php echo $WarrantyRequestLogs['applicator_contact']; ?></td></tr>	
								<tr><th>Applicator: </th><td><?php echo $WarrantyRequestLogs['applicator']; ?></td></tr>	
								
								
								<tr><th>Contractors Company Name: </th><td><?php echo $WarrantyRequestLogs['contract_company_name']; ?></td></tr>	
								<tr><th>Contractors Full Name: </th><td><?php echo $WarrantyRequestLogs['contract_name']; ?></td></tr>	
								<tr><th>Sign_date: </th><td><?php echo date('d/m/Y',strtotime($WarrantyRequestLogs['sign_date'])); ?></td></tr>	
								
								
							<?php } ?>
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
		$('#example').DataTable();
	} );
	function openpoup(id){
		var url = '<?php echo SITEURL.'stocks/comment/' ?>'+id;
		$('#abc_frame').attr('src', url);
		$("#myModalNew").trigger('click');	
	}
</script>	