	
	<style>
		.btn{margin-bottom: 5px; }
		.label-danger, .label.label-danger, .badge.badge-danger, .badge-danger {
			margin-bottom: 5px;
		}
	</style>
	
	<div class="page-content">
	<div class="page-header">
		<h1>Complaint List
			<a href="<?php echo SITEURL.'complaints/add'?>" class="btn btn-mini btn-info">Create Complaint</a>
			
			<a href="#null" data-toggle="modal" data-target="#myModal" class="btn btn-mini btn-primary">What is a NC and how does it work? (Click me for help)</a>
			
			<form action="" method="post" style="float:right;">
				<select id="dept_id" name="complaint_type" style="font-size: 13px;" >
					<option value="">Select Complaint Type</option>
					<?php foreach($ComplaintType as $ComplaintTypes){ ?>
						<option <?php if($ComplaintTypes['ComplaintType']['id'] == $complaint_type){ echo 'selected'; }?> value="<?php echo $ComplaintTypes['ComplaintType']['id'];?>"><?php echo $ComplaintTypes['ComplaintType']['title'];?></option>
					<?php  }  ?>
				</select>
				<input type="text" name="complaint_id" value="<?php echo $complaint_id; ?>" placeholder="Search By Complaint Id " >
				<input type="submit" name="search" value="search" class="btn btn-info btn-xs" >	
				<a href="<?php echo SITEURL.'complaints'?>" class="btn btn-warning btn-xs">Show All</a>
			</form>	
		</h1>
	</div>
	
	<?php
		$name = $this->Session->read('Customer.name').' '.$this->Session->read('Customer.lname');
	?>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>				
					<th><?php echo $this->Paginator->sort('complaint_id','Complaint Id'); ?></th>												
					<th><?php echo $this->Paginator->sort('emp_id','Complaint By'); ?></th>
					<th><?php echo $this->Paginator->sort('compaint_to','Complaint Against'); ?></th>
					<th><?php echo $this->Paginator->sort('customer_name'); ?></th>
					<th><?php echo $this->Paginator->sort('dept_id'); ?></th>
					<th><?php echo $this->Paginator->sort('complaint_type'); ?></th>
					
					<th><?php echo $this->Paginator->sort('status'); ?></th>					
					<th><?php echo $this->Paginator->sort('created'); ?></th>				
					<th>Action</th>				
					
				</tr>
				</thead>
				<tbody>
				<?php 
				$i=1;
				foreach ($ComplaintArr as $ComplaintArrs): 				
				?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $i; ?>" href="#null"><?php echo h($ComplaintArrs['Complaint']['complaint_id']); ?></a></td>					
									
						
						<td>
						<?php	echo '<span class="label label-danger">'.$ComplaintArrs['NappUser1']['name'].' '.$ComplaintArrs['NappUser1']['lname'].'</span>';
						?>						
						</td>				
						<td>
						<?php	echo '<span class="label label-danger">'.$ComplaintArrs['NappUser']['name'].' '.$ComplaintArrs['NappUser']['lname'].'</span>';
						?>						
						</td>
						<td><?php echo h($ComplaintArrs['Complaint']['customer_name']); ?></td>		
						<td><?php echo h($ComplaintArrs['Department']['department_title']); ?></td>								
						<td><?php echo h($ComplaintArrs['ComplaintType']['title']); ?></td>								
												
						<td>
					
						<?php 
						if($ComplaintArrs['Complaint']['is_non_conformance'] == 1){
							echo '<span class="label label-success">Completed</span>';
						}else if($ComplaintArrs['Conformance']){ 
							 if($ComplaintArrs['Conformance'][0]['status'] == 1){ echo '<span class="label label-danger"> Pending</span>'; } else if($ComplaintArrs['Conformance'][0]['status'] == 2){ echo '<span  class="label label-warning"> In-Process</span>'; }else if($ComplaintArrs['Conformance'][0]['status'] == 3){ echo '<span  class="label label-success"> Completed</span>'; } 
						}else{
							 echo '<span  class="label label-success"> N/A</span>';
						}

						?>
						<?php if($ComplaintArrs['Complaint']['is_approve_descline'] == 2){ ?>
								<br><span class="label label-danger">NC Request Declined</span>	
						<?php  } ?>
						</td>							
									
						<td><?php echo h($ComplaintArrs['Complaint']['created']); ?></td>					
						<td>
							<a href="<?php echo SITEURL.'complaints/detail/'.base64_encode($ComplaintArrs['Complaint']['complaint_id']) ?>" class="btn btn-mini btn-danger">View </a>
							
							<?php if($ComplaintArrs['Complaint']['complaint_to'] != $emp_id){?>
								<a href="<?php echo SITEURL.'complaints/edit/'.base64_encode($ComplaintArrs['Complaint']['complaint_id']) ?>" class="btn btn-mini btn-success">Edit </a>
							<?php } ?>
							
							<?php if($ComplaintArrs['Complaint']['is_approve_descline'] == 1){ ?>
								<a href="<?php echo SITEURL.'staffs/detail/'.base64_encode($ComplaintArrs['Conformance'][0]['nc_number']); ?>" class="btn btn-mini btn-warning ">NC Detail</a>				
							<?php }else  if(($ComplaintArrs['Complaint']['is_approve_descline'] == 0) && ( $ComplaintArrs['Complaint']['emp_id'] == $emp_id)){   ?>
								<a onclick="return confirm('Are you sent request for raise NC?')" href="<?php echo SITEURL.'complaints/requesttoraisenc/'.base64_encode($ComplaintArrs['Complaint']['complaint_id']); ?>" class="btn btn-mini btn-info">Request To NC</a>			
							<?php } ?>
						</td>	                    				
					</tr>
					<?php $i++; endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter([
'format' => 'showing {{current}} records out of {{count}} entries']);?>	</div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));?></li>
				
				<li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><?php echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));?></li>
				
			</ul>
			</div>
		</div>
	</div>	
	
</div>	

<?php 
$i=1;
foreach ($ComplaintArr as $ComplaintArrs): 				
?>
<div id="myModal_<?php echo $i; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Complaint Id: <?php echo h($ComplaintArrs['Complaint']['complaint_id']); ?></h4>
		</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="simple-table" >
						<tbody>
						<tr><th>Complaint Id: </th><td><span class="label label-inverse"><?php echo h($ComplaintArrs['Complaint']['complaint_id']); ?></span></td></tr>	
						
						<tr><th>Customer Name</th><td><?php echo h($ComplaintArrs['Complaint']['customer_name']); ?></td><tr>					
						<tr><th>Customer Email</th><td><?php echo h($ComplaintArrs['Complaint']['customer_email']); ?></td><tr>					
						<tr><th>Customer Phone</th><td><?php echo h($ComplaintArrs['Complaint']['customer_phone']); ?></td><tr>					
						<tr><th>Customer Address</th><td><?php echo h($ComplaintArrs['Complaint']['customer_address']); ?></td><tr>						
						<tr><th>Complaint By</th><td> <?php	echo '<span class="label label-danger">'.$ComplaintArrs['NappUser1']['name'].' '.$ComplaintArrs['NappUser1']['lname'].'</span>';?></td><tr>					
						<tr><th>Complaint Against</th><td><?php	echo '<span class="label label-danger">'.$ComplaintArrs['NappUser']['name'].' '.$ComplaintArrs['NappUser']['lname'].'</span>';
								?>	</td><tr>								
						<tr><th>Department</th><td><?php echo h($ComplaintArrs['Department']['department_title']); ?></td><tr>				
						<tr><th>Product Name</th><td><span class="label label-info"><?php echo h($ComplaintArrs['Complaint']['product_name']); ?></span></td><tr>					
						<tr><th>Product Color</th><td><?php echo h($ComplaintArrs['Complaint']['product_color']); ?></td><tr>	
						<?php if($ComplaintArrs['ComplaintType']['title'] != ''){ ?>	
							<tr><th>Complaint Type</th><td><?php echo h($ComplaintArrs['ComplaintType']['title']); ?></td><tr>	
						<?php }else{ ?>	
							<tr><th>Other Complaint Type</th><td><?php echo h($ComplaintArrs['Complaint']['other']); ?></td><tr>						
						<?php } ?>
						<tr><th>Reason For Complaint</th><td><?php echo h($ComplaintArrs['Complaint']['reason_for_complaint']); ?></td><tr>			
						<tr><th>Batch Number</th><td><?php echo h($ComplaintArrs['Complaint']['batch_number']); ?></td><tr>			
						<tr><th>Return Location</th><td><?php echo h($ComplaintArrs['Complaint']['return_location']); ?></td><tr>			
						<tr><th>Stock Transfer To Minto</th><td><?php echo h($ComplaintArrs['Complaint']['stock_transfer_to_minto']); ?></td><tr>			
						<tr><th>No Damaged Pails</th><td><?php echo h($ComplaintArrs['Complaint']['no_damaged_pails']); ?></td><tr>			
						<tr><th>Total Cost Durotech Solution</th><td><?php echo h($ComplaintArrs['Complaint']['total_cost_durotech_solution']); ?></td><tr>			
						<tr><th>Value of Freight For Return</th><td><?php echo h($ComplaintArrs['Complaint']['value_of_freight_for_return']); ?></td><tr>	
						
						<?php if($ComplaintArrs['Complaint']['is_non_conformance'] == 1){ ?>	
							<tr><th>Actioned By Date</th><td><span class="label label-warning"><?php echo $ComplaintArrs['Complaint']['actioned_by_date']; ?></span></td><tr>	
						<?php }else{ ?>	
							<tr><th>Actioned By Date</th><td><span class="label label-warning">N/A</span></td><tr>	
						<?php } ?>
						
						<?php if($ComplaintArrs['Complaint']['is_non_conformance'] == 1){ ?>	
							<tr><th>Is Non-Conformance</th><td><span class="label label-success">N/A</span></td><tr>	
						<?php }else{ ?>	
							<tr><th>Is Non-Conformance</th><td><span class="label label-success">Non-Conformance</span></td><tr>	
						<?php } ?>
						<tr><th>created</th><td><?php echo h($ComplaintArrs['Complaint']['created']); ?></td><tr>
							
						</tbody>
						
					</table>			
					</div>
				</div>
				</div>				
			</div>				
		</div>				
	</div>				
</div>				

<?php $i++; endforeach; ?>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">What is a Non Conformance and how does it work?</h4>
      </div>
      <div class="modal-body">
        <div>The process of online submission of Complaint and NC is :</div>
			<div>
			<ol>
				<li>First, we have to ask ourself before entering any Data (if the Data is a complaint ?&nbsp;or The Data is a Non Conformance?</li>
				<li>Any Data which directly we receive from&nbsp;our client is anyways a complaint.</li>
				<li>Any data which is a complaint and repetitive in nature is a Non-conformance.</li>
				<li>Non-conformance&nbsp;is Internal in nature and also it can be anything which we find hampering our product and process and we&nbsp;identify ourself.</li>
				<li>If we receive any complaint and we find out that it is a non-conformance then first we have to fill online complaint form and link that data to Non-Conformance&nbsp;with the help of option provided on the complaint form.</li>
				<li>so first we need to fill the Complaint form and then Non-Conformance has to be raised for the same.</li>
				<li>For any other process which we identify internally hampering our process, system, Quality straightforward Non-Conformance through Non-Conformance&nbsp;Form available&nbsp;on the portal.</li>
				<li>Any Non Conformance&nbsp;raised has to be addressed within 24 hrs.</li>
			</ol>

			<div>For further querries&nbsp;kindly revert.</div>
			</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
	</div>
</div>