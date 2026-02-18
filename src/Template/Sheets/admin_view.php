	<div class="page-content">
		<div class="page-header">
			<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
			<h1>Services : <small>Service Details</small></h1>	
		</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">	
				<table class="table" >
				<tbody>
				<tr>
					<th>Category  </th>
					<td><?php echo h($Service['Category']['category_name']); ?></td>
				</tr>
				<tr>
					<th>Service Name </th>
					<td><?php echo h($Service['Service']['service_name']); ?></td>
				</tr>
				<tr>
					<th>Description </th>
					<td><?php echo h($Service['Service']['service_description']); ?></td>
				</tr>
				<tr>
					<th>Price </th>
					<td>£<?php echo h($Service['Service']['price']); ?></td>
				</tr>
				<tr>
					<th>Price for shop</th>
					<td>£<?php echo h($Service['Service']['price_for_shop']); ?></td>
				</tr>
				
				<tr>
					<th>Image </th>
					<td><img style="width:100px;height:100px; "src="<?php echo SITEURL; ?>services_img/<?php echo $Service['Service']['image'];?>"></td>
				</tr>
				
				<tr>
				<th>Status</th>
					<td><?php  if(($Service['Service']['status']==1)){ echo 'Active';}else{ echo 'Inactive'; } ?></td>
				</tr>
					<tr>
						
				<tr><th>Created </th><td><?php echo date('m-d-Y',strtotime($Service['Service']['created'])); ?></td></tr>
				
				<tr><th> </th><td><?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $Service['Service']['id']),array('class'=>'btn btn-mini btn-warning')); ?>
						</td></tr>			
					
			</tbody>
			</table>
		</div>
	</div>
</div>
</div>