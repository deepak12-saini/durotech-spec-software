	<div class="page-content">
		<div class="page-header">
			<h1>Career Management <?php echo $this->Html->link('Add New', ['controller' => 'Careers', 'action' => 'admin_add'], ['class' => 'btn btn-info btn-xs top-button']); ?></h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('code'); ?></th>
					<th><?php echo $this->Paginator->sort('title'); ?></th>					
					<th><?php echo $this->Paginator->sort('description'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
				</thead>
				<tbody>
						<?php foreach ($careers as $career): ?>
					<tr>
					<td>#<?php echo h($career['Career']['id']); ?>&nbsp;</td>
					<td><?php echo h($career['Career']['code']); ?>&nbsp;</td>
					<td><?php echo h($career['Career']['title']); ?>&nbsp;</td>
					<td><?php echo h($career['Career']['description']); ?>&nbsp;</td>
					 <td>
						<?php if($career['Career']['status']==1){?>
							<span class="label label-success">Active</span>
						<?php }else{ ?>
						<span class="label label-danger">Inactive</span>
						<?php }?>&nbsp;
						</td>
                    <td> <?php echo format_db_date('d-M-Y', $career['Career']['created']); ?></td>
					 <td class="actions">
						
						<?php echo $this->Html->link(__('Edit'), ['action' => 'admin_edit', $career['Career']['id']], ['class' => 'btn btn-mini btn-info']); ?>
						<?php echo $this->Form->postLink(__('Delete'), ['action' => 'admin_delete', $career['Career']['id']], ['class' => 'btn btn-mini btn-danger', 'confirm' => __('Are you sure you want to delete # %s?', $career['Career']['id'])]); ?>
						<?php echo $this->Html->link(__('Apply User'), ['action' => 'admin_apply', $career['Career']['id']], ['class' => 'btn btn-mini btn-primary']); ?>
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
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php echo $this->Paginator->counter(['format' => __('showing {{current}} records out of {{count}} entries')]); ?></div>
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