	<div class="page-content">
		<div class="page-header">
			<h1>Career Management <a href="javascript:window.history.back();" class="btn btn-xs btn-inverse" >Back</a></h1>
		</div>
	<h4>Job Code: <?php echo $careers['Career']['code']; ?></h4>
	<h4>Title: <?php echo $careers['Career']['title']; ?></h4>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>					
					<th><?php echo $this->Paginator->sort('phone'); ?></th>
					<th><?php echo $this->Paginator->sort('description'); ?></th>
					<th><?php echo $this->Paginator->sort('resume'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
				</thead>
				<tbody>
						<?php foreach ($CareerApplyJob as $CareerApplyJobs): ?>
					<tr>
					<td>#<?php echo h($CareerApplyJobs['CareerApplyJob']['id']); ?>&nbsp;</td>
					<td><?php echo h($CareerApplyJobs['CareerApplyJob']['name']); ?>&nbsp;</td>
					<td><?php echo h($CareerApplyJobs['CareerApplyJob']['email']); ?>&nbsp;</td>
					<td><?php echo h($CareerApplyJobs['CareerApplyJob']['phone']); ?>&nbsp;</td>
					<td><?php echo h($CareerApplyJobs['CareerApplyJob']['description']); ?>&nbsp;</td>
					<td><a href="<?php echo h($CareerApplyJobs['CareerApplyJob']['resume']); ?>">Download</a> &nbsp;</td>
					<td> <?php echo format_db_date('d-M-Y', $CareerApplyJobs['CareerApplyJob']['created']); ?></td>
					
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