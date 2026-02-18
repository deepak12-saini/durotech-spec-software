	<div class="page-content">
		<div class="page-header">
			<h1>QC Result</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('employee_name'); ?></th>				
				<th><?php echo $this->Paginator->sort('batch_number'); ?></th>
				<th><?php echo $this->Paginator->sort('product_name'); ?></th>
				<th><?php echo $this->Paginator->sort('quantity'); ?></th>
				<th><?php echo $this->Paginator->sort('no_of_pails'); ?></th>
				<th><?php echo $this->Paginator->sort('date'); ?></th>
				<th><?php echo $this->Paginator->sort('date_completed'); ?></th>
				<th><?php echo $this->Paginator->sort('signature'); ?></th>
                  <th><?php echo $this->Paginator->sort('created'); ?></th>

				</tr>
				</thead>
				<tbody>
						<?php foreach ($BatchRegisterArr as $BatchRegisterArrs): 
							$bcs = $BatchRegisterArrs['BatchCountSheet'] ?? [];
							$nu = $BatchRegisterArrs['NappUser'] ?? [];
							$nuName = trim(($nu['name'] ?? '') . ' ' . ($nu['lname'] ?? ''));
						?>
					<tr>
					<td>#<?php echo h($bcs['id'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($nuName); ?>&nbsp;</td>
					<td><?php echo h($bcs['employee_name'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($bcs['batch_number'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($bcs['product_name'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($bcs['quantity'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($bcs['no_of_pails'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($bcs['date'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($bcs['date_completed'] ?? ''); ?>&nbsp;</td>
					<td><?php echo h($bcs['signature'] ?? ''); ?>&nbsp;</td>									
                    <td><?php echo !empty($bcs['created']) ? date('d-M-Y', strtotime($bcs['created'])) : ''; ?></td>
					
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