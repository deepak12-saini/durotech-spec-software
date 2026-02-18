	<div class="page-content">
		<div class="page-header">
			<h1>Batches Made List <a href="<?php echo $this->Url->build(['controller' => 'Productions', 'action' => 'adminBatchRegisterAdd']); ?>" class="btn btn-mini btn-info" style="float:right;">Add New</a></h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('batch_no'); ?></th>
				<th><?php echo $this->Paginator->sort('date'); ?></th>
				<th><?php echo $this->Paginator->sort('product'); ?></th>
				<th><?php echo $this->Paginator->sort('apearance'); ?></th>
				<th><?php echo $this->Paginator->sort('viscosity'); ?></th>
				<th><?php echo $this->Paginator->sort('t_degree_c'); ?></th>
				<th><?php echo $this->Paginator->sort('s_g'); ?></th>
				<th><?php echo $this->Paginator->sort('check_test'); ?></th>
				<th><?php echo $this->Paginator->sort('test_by'); ?></th>
				<th><?php echo $this->Paginator->sort('comments'); ?></th>
                  <th><?php echo $this->Paginator->sort('created'); ?></th>
				<th>Action</th>
				</tr>
				</thead>
				<tbody>
						<?php foreach ($BatchRegisterArr as $BatchRegisterArrs): 
							$br = $BatchRegisterArrs['BatchRegister'] ?? [];
							$nu = $BatchRegisterArrs['NappUser'] ?? [];
							$nuName = trim(($nu['name'] ?? '') . ' ' . ($nu['lname'] ?? ''));
						?>
					<tr>
					<td>#<?php echo h($br['id'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($nuName); ?>&nbsp;</td>
					<td><?php echo h($br['batch_no'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($br['date'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($br['product'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($br['apearance'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($br['viscosity'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($br['t_degree_c'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($br['s_g'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($br['check_test'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($br['test_by'] ?? ''); ?>&nbsp;</td>					
					<td><?php echo h($br['comments'] ?? ''); ?>&nbsp;</td>					
                    <td><?php echo !empty($br['created']) ? date('d-M-Y', strtotime($br['created'])) : ''; ?></td>
					<td><a href="<?php echo $this->Url->build(['controller' => 'Productions', 'action' => 'adminBatchRegisterEdit', $br['id'] ?? '']); ?>" class="btn btn-mini btn-info">Edit</a></td>
					</tr>
					<?php endforeach; ?>

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