<div class="page-content">
		<div class="page-header">
			<h1>New Price List Mailer Logs 
			<?= $this->Html->link('Send Mail', ['controller' => 'Mailers', 'action' => 'priceListMailers'], ['class' => 'btn btn-info btn-xs top-button']) ?>
			
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>					
					<th><?php echo $this->Paginator->sort('reference_id'); ?></th>
					<th><?php echo $this->Paginator->sort('name','Name'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>					
					<th><?php echo $this->Paginator->sort('date'); ?></th>					
					<th><?php echo $this->Paginator->sort('subject'); ?></th>
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
						<td>#<?php echo h($mailer['NewPriceListLog']['id']); ?>&nbsp;</td>
						<td><?php echo h($mailer['NewPriceListLog']['reference_id']); ?>&nbsp;</td>
						<td><?php echo h($mailer['NewPriceListLog']['name']); ?>&nbsp;</td>
						<td><?php echo h($mailer['NewPriceListLog']['email']); ?>&nbsp;</td>					
						<td><?php echo date('d-M-Y',strtotime($mailer['NewPriceListLog']['date'])); ?>&nbsp;</td>
						<td><?php echo h($mailer['NewPriceListLog']['subject']); ?>&nbsp;</td>						
						<td> <?php echo date('d-M-Y h:i a',strtotime($mailer['NewPriceListLog']['created'])); ?></td>					
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