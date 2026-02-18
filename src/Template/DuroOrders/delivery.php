	<link rel="stylesheet" type="text/css" media="screen"
     href="<?php echo SITEURL; ?>datetimepicker/bootstrap-datetimepicker.css">
	<div class="page-content">
		<div class="page-header">
			<h1>Durotech Delivery <a href="<?php echo SITEURL.'duro_orders/delivery_add' ?>" class="btn btn-mini btn-primary"> Add New</a></h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					
					<th><?php echo $this->Paginator->sort('order_id'); ?></th>					
					<th><?php echo $this->Paginator->sort('docket_number'); ?></th>		
					<th><?php echo $this->Paginator->sort('user_id','Added By'); ?></th>
					<th><?php echo $this->Paginator->sort('pickup_name','Driver Detail'); ?></th>
					<th><?php echo $this->Paginator->sort('pickup_time','Pickup Date/Time'); ?></th>
					<th><?php echo $this->Paginator->sort('deliver_time','Deliver Date/Time'); ?></th>
					<th><?php echo $this->Paginator->sort('docket_file'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($deliver as $delivers): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($delivers['DuroDelivery']['order_id']); ?></a>&nbsp;</td>		
						<td><?php echo $delivers['DuroDelivery']['docket_number']; ?>&nbsp;</td>	
						<td><?php echo $delivers['NappUser']['name'].' '.$delivers['NappUser']['lname']; ?></td>
						<td><?php echo h($delivers['DuroDelivery']['pickup_name']); ?>&nbsp;</td>
						<td><?php echo date('d-M-Y',strtotime($delivers['DuroDelivery']['pickup_date'])).'<br>'.$delivers['DuroDelivery']['pickup_time']; ?>&nbsp;</td>			
						<td><?php echo date('d-M-Y',strtotime($delivers['DuroDelivery']['deliver_date'])).'<br>'.$delivers['DuroDelivery']['deliver_time']; ?>&nbsp;</td>						
						<td><a href="<?php echo SITEURL.'docket_file/'.$delivers['DuroDelivery']['docket_file'];?>" target="_blank">Download Docket</a></td>						
						<td>
						<?php 
							if($delivers['DuroDelivery']['status'] == 0){
								echo '<span class="label label-primary">New Order</span>';
							}else if($delivers['DuroDelivery']['status'] == 1){
								echo '<span class="label label-danger">Accepted</span>';
							}else if($delivers['DuroDelivery']['status'] == 2){
								echo '<span class="label label-success">Process</span>';
							}else if($delivers['DuroDelivery']['status'] == 3){
								echo '<span class="label label-success">Delivered</span>';
							}				
		
						?>&nbsp;
						</td>					
						<td> <?php echo date('d-M-Y',strtotime($delivers['DuroDelivery']['created'])); ?></td>
						<td>
						<?php if($delivers['DuroDelivery']['status'] < 2){ ?>
							<a href="<?php echo SITEURL.'duro_orders/delivery_edit/'.$delivers['DuroDelivery']['id']; ?>" class="btn btn-mini btn-info">Edit</a>	
							
							<a onclick="return confirm('Are you sure delete this order?')" href="<?php echo SITEURL.'duro_orders/delivery_delete/'.$delivers['DuroDelivery']['id']; ?>" class="btn btn-mini btn-danger">Delete</a>		
						<?php } ?>		
						</td>					
					</tr>
					<?php $k++; endforeach; ?>
				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter(array(
'format' => __('showing {{current}} records out of {{count}} entries')));?>	</div>
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
	$j=1;
	foreach ($deliver as $delivers):
	?>
	<div id="myModal_<?php echo $j; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Deliver Docket: <?php echo h($delivers['DuroDelivery']['docket_number']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover"  >
						<tbody>
						<tr><th>Order id: </th><td><span class="label label-inverse"><?php echo h($delivers['DuroDelivery']['order_id']); ?></span></td></tr>	
						<tr><th>Deliver Docket: </th><td><?php echo h($delivers['DuroDelivery']['docket_number']); ?></td></tr>					
						<tr><th>Deliver File: </th><td>
						<a target="_blank" href="<?php echo h($delivers['DuroDelivery']['docket_file']); ?>"><?php echo h($delivers['DuroDelivery']['docket_file']); ?></a></td></tr>					
						</tbody>					
					</table>				

					</div>
				</div>
			</div>	
			<!--div class="row">
				<div class="col-xs-6">
					<table class="table table-striped table-bordered table-hover"  >
						<thead>
							<tr>
								<th>Pickup Address:</th>
							<tr>
						</thead>
						<tbody>
						<tr><td><span class="label label-inverse"><?php echo h($delivers['DuroDelivery']['pickup_address']); ?></span></td></tr>											
						</tbody>					
					</table>				

				</div>
				<div class="col-xs-6">
					<table class="table table-striped table-bordered table-hover"  >
						<thead>
							<tr>
								<th>Deliver Address:</th>
							<tr>
						</thead>
						<tbody>
						<tr><td><span class="label label-inverse"><?php echo h($delivers['DuroDelivery']['deliver_address']); ?></span></td></tr>											
						</tbody>					
					</table>	
				</div>
			</div-->	
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover"  >
						<tbody>
						<tr><th>Driver Name: </th><td><span class="label label-inverse"><?php echo h($delivers['Driver']['driver_name']); ?></span></td></tr>	
						<tr><th>Driver Email: </th><td><span class="label label-inverse"><?php echo h($delivers['Driver']['driver_email']); ?></span></td></tr>	
						<tr><th>Driver Phone: </th><td><span class="label label-inverse"><?php echo h($delivers['Driver']['driver_phone']); ?></span></td></tr>	
						<tr><th>Drivering License: </th><td><span class="label label-inverse"><?php echo h($delivers['Driver']['id_number']); ?></span></td></tr>	
						<tr><th>Driver DOB: </th><td><span class="label label-inverse"><?php echo h($delivers['Driver']['dob']); ?></span></td></tr>	
									
						</tbody>					
					</table>				

					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover"  >
						<tbody>
						<tr><th>Pickup Time: </th><td><?php echo h($delivers['DuroDelivery']['pickup_time']); ?></td></tr>										
						<tr><th>Deliver Time: </th><td><?php echo h($delivers['DuroDelivery']['deliver_time']); ?></td></tr>		
						
						<tr><th>Order Status: </th>
						<td>
							<?php
							if($delivers['DuroDelivery']['status'] == 0){
								echo '<span class="label label-primary">New Order</span>';
							}else if($delivers['DuroDelivery']['status'] == 1){
								echo '<span class="label label-danger">Accepted</span>';
							}else if($delivers['DuroDelivery']['status'] == 2){
								echo '<span class="label label-success">Process</span>';
							}else if($delivers['DuroDelivery']['status'] == 3){
								echo '<span class="label label-success">Delivered</span>';
							}			
		
							?>
						</td>
						</tr>										
						</tbody>					
					</table>				

					</div>
				</div>
			</div>	
		  </div>
		 
		</div>

	  </div>
	</div>
	<?php $j++; endforeach; ?>
					