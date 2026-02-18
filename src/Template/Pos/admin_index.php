<div class="page-content">
		<div class="page-header">
			<h1>Po Order List</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>				
					<th><?php echo $this->Paginator->sort('orderid','Order Id'); ?></th>					
					<th><?php echo $this->Paginator->sort('Added By'); ?></th>
					<th><?php echo $this->Paginator->sort('suplier_name'); ?></th>
					<th><?php echo $this->Paginator->sort('approvedby'); ?></th>									
					<th><?php echo $this->Paginator->sort('status'); ?></th>									
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th></th>
				</tr>
				</thead>
				<tbody>
					<?php 
					$k = 1; 
					foreach ($poorders as $poorder): 
						$po = $poorder['PoOrder'] ?? [];
						$nu = $poorder['NappUser'] ?? [];
						$nuName = trim(($nu['name'] ?? '') . ' ' . ($nu['lname'] ?? ''));
					?>
					<tr>								
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null">#<?php echo h($po['orderid'] ?? ''); ?>&nbsp;</a></td>
						<td><?php echo h($po['suplier_name'] ?? ''); ?>&nbsp;</td>
						<td><?php echo h($nuName); ?>&nbsp;</td>
						<td><?php echo h($po['approvedby'] ?? ''); ?>&nbsp;</td>
						<td>
						<?php  
							$status = (int)($po['status'] ?? 0);
							if($status == 0){
								echo '<span class="label label-primary">Pending</span>';
							}else if($status == 1){
								echo '<span class="label label-danger">In-Process</span>';
							}else if($status == 2){
								echo '<span class="label label-success">Completed</span>';
							}	
						?>&nbsp;</td>					
						<td><?php echo !empty($po['created']) ? date('d-M-Y h:i a', strtotime($po['created'])) : ''; ?></td>	
									
					</tr>
					<?php $k++; endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter([
'format' => __('showing {{current}} records out of {{count}} entries')
]); ?>	</div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><?php
				echo $this->Paginator->prev('< ' . __('previous'), [], null, ['class' => 'prev disabled']); ?></li>
				
				<li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><?php echo $this->Paginator->next(__('next') . ' >', [], null, ['class' => 'next disabled']); ?></li>
				
			</ul>
			</div>
		</div>
	</div>	
</div>		
	<?php 
	$j=1;
	foreach ($poorders as $poorder):	
	?>
	<div id="myModal_<?php echo $j; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Po Order Detail: <?php echo h($poorder['PoOrder']['orderid'] ?? ''); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<?php
				$po = $poorder['PoOrder'] ?? [];
				$status = (int)($po['status'] ?? 0);
				?>
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Order Id: </th><td><span class="label label-inverse"><?php echo h($po['orderid'] ?? ''); ?></span></td></tr>							
					<tr><th>Suplier Name: </th><td><?php echo h($po['suplier_name'] ?? ''); ?></td></tr>				
					<tr><th>Status: </th><td>
					<?php
						if($status == 0){
							echo '<span class="label label-primary">Pending</span>';
						}else if($status == 1){
							echo '<span class="label label-danger">In-Process</span>';
						}else if($status == 2){
							echo '<span class="label label-success">Completed</span>';
						}				
					?>&nbsp;
						</td></tr>	
					<tr><th>Approved By: </th><td><?php echo h($po['approvedby'] ?? ''); ?></td></tr>
					<tr><th>Created: </th><td><?php echo !empty($po['created']) ? date('d-M-Y', strtotime($po['created'])) : ''; ?></td></tr>	
					</tbody>
					
				</table>
				<table class="table table-striped table-bordered table-hover"  >
					<thead>		
						<tr>
							<th>S.no</th>
							<th>Product Name</th>							
							<th>qty</th>
						<tr>	
					</thead>
					<tbody>
						<?php 
						$k=1;
						$details = $poorder['PoOrderDetail'] ?? [];
						foreach($details as $records){  
							$rec = is_array($records) ? $records : (is_object($records) ? $records->toArray() : []);
						?>
							<tr>
								<th><?php echo $k; ?></th>
								<th><?php echo h($rec['item_name'] ?? ''); ?></th>													
								<th><?php echo h($rec['quantity'] ?? ''); ?></th>
								
							<tr>		
						<?php  $k++; } ?>	
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
					