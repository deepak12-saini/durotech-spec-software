	<div class="page-content">
		<div class="page-header">
			<h1>QC Result <a href="<?php echo SITEURL.'productions/batch_count_sheet_add' ?>" class="btn btn-mini btn-info" >Add New</a></h1>
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
				<th>Action</th>
				</tr>
				</thead>
				<tbody>
						<?php foreach ($BatchRegisterArr as $BatchRegisterArrs): ?>
					<tr>
					<td>#<?php echo h($BatchRegisterArrs['BatchCountSheet']['id']); ?>&nbsp;</td>
					<td><?php echo $BatchRegisterArrs['NappUser']['name'].' '.$BatchRegisterArrs['NappUser']['lname']; ?>&nbsp;</td>
					<td><?php echo h($BatchRegisterArrs['BatchCountSheet']['employee_name']); ?>&nbsp;</td>
					<td><?php echo h($BatchRegisterArrs['BatchCountSheet']['batch_number']); ?>&nbsp;</td>
					<td><?php echo h($BatchRegisterArrs['BatchCountSheet']['product_name']); ?>&nbsp;</td>
					<td><?php echo h($BatchRegisterArrs['BatchCountSheet']['quantity']); ?>&nbsp;</td>
					<td><?php echo h($BatchRegisterArrs['BatchCountSheet']['no_of_pails']); ?>&nbsp;</td>
					<td><?php echo h($BatchRegisterArrs['BatchCountSheet']['date']); ?>&nbsp;</td>
					<td><?php echo h($BatchRegisterArrs['BatchCountSheet']['date_completed']); ?>&nbsp;</td>
					<td><?php echo h($BatchRegisterArrs['BatchCountSheet']['signature']); ?>&nbsp;</td>									
                    <td> <?php echo format_db_date('d-M-Y', $BatchRegisterArrs['BatchCountSheet']['created']); ?></td>
					<td><a href="<?php echo SITEURL.'productions/batch_count_sheet_edit/'.$BatchRegisterArrs['BatchCountSheet']['id'] ?>" class="btn btn-mini btn-info" >Edit</a></td>
					</tr>
					<?php endforeach; ?>

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