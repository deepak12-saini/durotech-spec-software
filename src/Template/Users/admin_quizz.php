	<div class="page-content">
		<div class="page-header">
			<h1>
			Questionnaire Attendees			
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('user_id','Submited By'); ?></th>					
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>
					<th><?php echo $this->Paginator->sort('phone'); ?></th>                
					<th><?php echo $this->Paginator->sort('landlineno'); ?></th>                
					<th><?php echo $this->Paginator->sort('company'); ?></th>                
					<th><?php echo $this->Paginator->sort('company_address'); ?></th>                
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					
				</tr>
				</thead>
				<tbody>
					<?php foreach ($QuestionSubmitArr as $QuestionSubmitArrs): 
						$qs = $QuestionSubmitArrs['QuestionSubmit'] ?? [];
						$nu = $QuestionSubmitArrs['NappUser'] ?? [];
						$nuName = trim(($nu['name'] ?? '') . ' ' . ($nu['lname'] ?? ''));
						$qsName = trim(($qs['name'] ?? '') . ' ' . ($qs['lname'] ?? ''));
					?>
					<tr>
						<td><?php echo h($nuName); ?>&nbsp;</td>
						<td><?php echo h($qsName); ?>&nbsp;</td>
						<td><?php echo h($qs['email'] ?? ''); ?>&nbsp;</td>
						<td><?php echo h($qs['phone'] ?? ''); ?>&nbsp;</td>									
						<td><?php echo h($qs['landlineno'] ?? ''); ?>&nbsp;</td>							
						<td><?php echo h($qs['company'] ?? ''); ?>&nbsp;</td>														
						<td><?php echo h($qs['company_address'] ?? ''); ?>&nbsp;</td>														
						<td><?php echo !empty($qs['created']) ? format_db_date('d M Y h:i a', $qs['created']) : ''; ?></td>					
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