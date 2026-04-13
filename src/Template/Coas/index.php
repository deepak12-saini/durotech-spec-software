	<style>
		.btn{ margin-bottom:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>COA Durotech 
			<?php echo $this->Html->link('Create New COA',array('controller' => 'coas','action' => 'create'),array('class'=>'btn btn-info btn-xs top-button')); ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>					
					<th><?php echo $this->Paginator->sort('Created By'); ?></th>					
					<th><?php echo $this->Paginator->sort('product'); ?></th>					
					<th><?php echo $this->Paginator->sort('batch_no'); ?></th>
					<th><?php echo $this->Paginator->sort('date_of_manu'); ?></th>
					<th><?php echo $this->Paginator->sort('expiry_date'); ?></th>
					<th><?php echo $this->Paginator->sort('form_no'); ?></th>					
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php 					
					foreach ($coa as $coas):					
					?>
					<tr>
					<td>#<?php echo h($coas['Coa']['id']); ?>&nbsp;</td>
					<td><?php echo $coas['NappUser']['name'].'('.$coas['NappUser']['lname'].')'; ?>&nbsp;</td>
					<td><?php echo h($coas['Coa']['product']); ?>&nbsp;</td>
					<td><?php echo h($coas['Coa']['batch_no']); ?>&nbsp;</td>					
					<td><?php echo h($coas['Coa']['date_of_manu']); ?>&nbsp;</td>
					<td><?php echo h($coas['Coa']['expiry_date']); ?>&nbsp;</td>
					<td><?php echo h($coas['Coa']['form_no']); ?>&nbsp;</td>					
                    <td> <?php echo format_db_date('d-M-Y h:i a', $coas['Coa']['created']); ?></td>
					<td>
						<?= $this->Html->link('Edit', ['action' => 'edit', $coas['Coa']['id'] ?? ''], ['class' => 'btn btn-mini btn-primary']) ?>
						<?= $this->Html->link('Download', ['action' => 'download', $coas['Coa']['id'] ?? ''], ['class' => 'btn btn-mini btn-info', 'target' => '_blank']) ?>
						<?= $this->Html->link('Send Mail', ['action' => 'sendemails', $coas['Coa']['id'] ?? ''], ['class' => 'btn btn-mini btn-danger', 'onclick' => "return confirm('Are you sure send email?');"]) ?>
					</td>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?= $this->Paginator->counter(__('showing {{current}} records out of {{count}} entries')) ?></div>
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