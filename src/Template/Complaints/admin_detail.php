	
	<style>
		.btn{margin-bottom: 5px; }
		.label-danger, .label.label-danger, .badge.badge-danger, .badge-danger {
			margin-bottom: 5px;
		}
	</style>
	
	<div class="page-content">
	<div class="page-header">
		<h1>Complaint Detail
			<?php if($type==1){?>
				<a href="<?php echo SITEURL.'admin/staffs/conformancelist'?>" class="btn btn-mini btn-info" style="float:right;">Back</a>
			<?php }else{ ?>
				<a href="<?php echo SITEURL.'admin/complaints'?>" class="btn btn-mini btn-info" style="float:right;">Back</a>
			<?php }?>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<tbody>
				<tr><th>Complaint Id: </th><td><span class="label label-inverse"><?php echo h($ComplaintArr['Complaint']['complaint_id']); ?></span></td></tr>	
				
				<tr><th>Customer Name</th><td><?php echo h($ComplaintArr['Complaint']['customer_name']); ?></td><tr>					
				<tr><th>Customer Email</th><td><?php echo h($ComplaintArr['Complaint']['customer_email']); ?></td><tr>					
				<tr><th>Customer Phone</th><td><?php echo h($ComplaintArr['Complaint']['customer_phone']); ?></td><tr>					
				<tr><th>Customer Address</th><td><?php echo h($ComplaintArr['Complaint']['customer_address']); ?></td><tr>						
				<tr><th>Complaint By</th><td> <?php	echo '<span class="label label-danger">'.$ComplaintArr['NappUser1']['name'].' '.$ComplaintArr['NappUser1']['lname'].'</span>';?></td><tr>					
				<tr><th>Complaint Against</th><td><?php	echo '<span class="label label-danger">'.$ComplaintArr['NappUser']['name'].' '.$ComplaintArr['NappUser']['lname'].'</span>';
						?>	</td><tr>								
				<tr><th>Department</th><td><?php echo h($ComplaintArr['Department']['department_title']); ?></td><tr>				
				<tr><th>Product Name</th><td><span class="label label-info"><?php echo h($ComplaintArr['Complaint']['product_name']); ?></span></td><tr>					
				<tr><th>Product Color</th><td><?php echo h($ComplaintArr['Complaint']['product_color']); ?></td><tr>				
				<?php if($ComplaintArr['ComplaintType']['title'] != ''){ ?>	
					<tr><th>Complaint Type</th><td><?php echo h($ComplaintArr['ComplaintType']['title']); ?></td><tr>	
				<?php }else{ ?>	
					<tr><th>Other Complaint Type</th><td><?php echo h($ComplaintArr['Complaint']['other']); ?></td><tr>						
				<?php } ?>						
				
				<tr><th>Reason For Complaint</th><td><?php echo h($ComplaintArr['Complaint']['reason_for_complaint']); ?></td><tr>			
				<tr><th>Batch Number</th><td><?php echo h($ComplaintArr['Complaint']['batch_number']); ?></td><tr>			
				<tr><th>Return Location</th><td><?php echo h($ComplaintArr['Complaint']['return_location']); ?></td><tr>			
				<tr><th>Stock Transfer To Minto</th><td><?php echo h($ComplaintArr['Complaint']['stock_transfer_to_minto']); ?></td><tr>			
				<tr><th>No Damaged Pails</th><td><?php echo h($ComplaintArr['Complaint']['no_damaged_pails']); ?></td><tr>			
				<tr><th>Total Cost Durotech Solution</th><td><?php echo h($ComplaintArr['Complaint']['total_cost_durotech_solution']); ?></td><tr>			
				<tr><th>Value of Freight For Return</th><td><?php echo h($ComplaintArr['Complaint']['value_of_freight_for_return']); ?></td><tr>	
				
				<?php if($ComplaintArr['Complaint']['is_non_conformance'] == 1){ ?>	
					<tr><th>Actioned By Date</th><td><span class="label label-warning"><?php echo $ComplaintArr['Complaint']['actioned_by_date']; ?></span></td><tr>	
				<?php }else{ ?>	
					<tr><th>Actioned By Date</th><td><span class="label label-warning">N/A</span></td><tr>	
				<?php } ?>
				
				<?php if($ComplaintArr['Complaint']['is_non_conformance'] == 1){ ?>	
					<tr><th>Is Non-Conformance</th><td><span class="label label-success">N/A</span></td><tr>	
				<?php }else{ ?>	
					<tr><th>Is Non-Conformance</th><td><span class="label label-success">Non-Conformance</span></td><tr>	
				<?php } ?>
				<tr><th>created</th><td><?php echo h($ComplaintArr['Complaint']['created']); ?></td><tr>
					
				</tbody>
				
			</table>			
			</div>
		</div>
	</div>		

	
</div>		