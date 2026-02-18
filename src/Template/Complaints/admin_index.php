	
	<style>
		.btn{margin-bottom: 5px; }
		.label-danger, .label.label-danger, .badge.badge-danger, .badge-danger {
			margin-bottom: 5px;
		}
	</style>
	
	<div class="page-content">
	<div class="page-header">
		<h1>
			Complaint Lists
			<div style="float:right;">
				<?php echo $this->Form->create(null, ['url' => ['action' => 'admin_index'], 'style' => 'display:inline-block;']); ?>
					<?php 
					$options = ['' => 'Select Complaint Type'];
					foreach($ComplaintType as $ComplaintTypes){ 
						$options[$ComplaintTypes['ComplaintType']['id']] = $ComplaintTypes['ComplaintType']['title'];
					}
					echo $this->Form->control('complaint_type', [
						'type' => 'select',
						'options' => $options,
						'value' => $complaint_type,
						'label' => false,
						'style' => 'font-size: 13px; display:inline-block; width:auto;'
					]); 
					?>
					<?php echo $this->Form->control('complaint_id', [
						'type' => 'text',
						'value' => $complaint_id,
						'placeholder' => 'Search By Complaint Id',
						'label' => false,
						'style' => 'display:inline-block; width:auto;'
					]); ?>
					<?php echo $this->Form->button('search', [
						'class' => 'btn btn-info btn-xs',
						'name' => 'search',
						'style' => 'display:inline-block;'
					]); ?>
				<?php echo $this->Form->end(); ?>
				<a href="<?php echo SITEURL.'admin/complaints'?>" class="btn btn-warning btn-xs" style="display:inline-block;">Show All</a>
			</div>
		</h1>
	</div>
	
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
						</td>
						
						<td><?php echo h($ComplaintArrs['Complaint']['created']); ?></td>					
						<td>
							<a href="<?php echo SITEURL.'admin/complaints/detail/'.base64_encode($ComplaintArrs['Complaint']['complaint_id']) ?>" class="btn btn-mini btn-danger">View </a>
																					
							<?php if(isset($ComplaintArrs['Conformance']) && !empty($ComplaintArrs['Conformance']) && isset($ComplaintArrs['Conformance'][0]['nc_number'])){ ?>
								
								<a href="<?php echo SITEURL.'admin/staffs/detail/'.base64_encode($ComplaintArrs['Conformance'][0]['nc_number']); ?>" class="btn btn-mini btn-warning ">NC Detail</a>
								
							<?php }  ?>
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
</div>		