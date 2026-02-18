	<div class="page-content">
		<div class="page-header">
			<h1>New Joining List </h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('documentid'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id','Added By'); ?></th>				
					<th><?php echo $this->Paginator->sort('date'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('qualification'); ?></th>
					<th><?php echo $this->Paginator->sort('designation'); ?></th>
					<th><?php echo $this->Paginator->sort('experience'); ?></th>						
					<th><?php echo $this->Paginator->sort('term_conditions'); ?></th>						
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($HrNewJoiningDetailArr as $HrNewJoiningDetailArrs): ?>
					<tr>
						<td><?php echo h($HrNewJoiningDetailArrs['HrNewJoiningDetail']['documentid']); ?>&nbsp;</td>
						<td><?php echo $HrNewJoiningDetailArrs['NappUser']['name'].' '.$HrNewJoiningDetailArrs['NappUser']['lname']; ?>&nbsp;</td>
						<td><?php echo date('d-M-Y',strtotime($HrNewJoiningDetailArrs['HrNewJoiningDetail']['date'])); ?>&nbsp;</td>
						<td><?php echo h($HrNewJoiningDetailArrs['HrNewJoiningDetail']['name']); ?>&nbsp;</td>
						<td><?php echo h($HrNewJoiningDetailArrs['HrNewJoiningDetail']['qualification']); ?>&nbsp;</td>
						<td><?php echo h($HrNewJoiningDetailArrs['HrNewJoiningDetail']['designation']); ?>&nbsp;</td>
						<td><?php echo h($HrNewJoiningDetailArrs['HrNewJoiningDetail']['experience']); ?>&nbsp;</td>
						<td>
						<?php 
						if($HrNewJoiningDetailArrs['HrNewJoiningDetail']['term_conditions'] == 1){
							echo 'Yes';
						}else{
							echo 'No';
						}	
						?>
						
						&nbsp;</td>
								
						<td> <?php echo date('d-M-Y',strtotime($HrNewJoiningDetailArrs['HrNewJoiningDetail']['created'])); ?></td>
									
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
]);?>	</div>
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
