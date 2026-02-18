<div class="page-content">
		<div class="page-header">
			<h1>DuroEzy Specification
			<?php echo $this->Html->link('Send Mail',array('controller' => 'mailers','action' => 'send'),array('class'=>'btn btn-info btn-xs top-button')); ?>
			
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					
					<th><?php echo $this->Paginator->sort('name','Name'); ?></th>
					<th><?php echo $this->Paginator->sort('Email'); ?></th>
					<th><?php echo $this->Paginator->sort('Phone'); ?></th>
					<th><?php echo $this->Paginator->sort('Company'); ?></th>
					<th><?php echo $this->Paginator->sort('Project'); ?></th>
					<th><?php echo $this->Paginator->sort('type'); ?></th>					
					<th><?php echo $this->Paginator->sort('created'); ?></th>
				</tr>
				</thead>
				<tbody>
					<?php 
					
				//	echo '<pre>';
					//print_r($mailers);
					//die();
					
					foreach ($mailers as $mailer): ?>
					<tr>
					<td>#<?php echo h($mailer['Mailer']['id']); ?>&nbsp;</td>
					<td><?php echo h($mailer['Mailer']['name']); ?>&nbsp;</td>
					<td><?php echo h($mailer['Mailer']['email']); ?>&nbsp;</td>
					<td><?php echo h($mailer['Mailer']['phone']); ?>&nbsp;</td>
					<td><?php echo h($mailer['Mailer']['company']); ?>&nbsp;</td>
					<td><?php echo h($mailer['Mailer']['project']); ?>&nbsp;</td>
					<td><?php 
					if($mailer['Mailer']['type']){ 
						echo '<a href="'.SITEURL.'DuroEzy/Method statement duromastic P15.pdf" target="_blank" >INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE</a>'; 
					}else{
						echo  '<a href="'.SITEURL.'DuroEzy/4 seasons Saba tiling.pdf" target="_blank" >Waterproofing Specification</a>' ;
					}
					?>&nbsp;</td>					
                    <td> <?php echo date('d-M-Y h:i a',strtotime($mailer['Mailer']['created'])); ?></td>
					
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