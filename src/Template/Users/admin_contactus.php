	<div class="page-content">
		<div class="page-header">
			<h1>ContactUs List </h1>
		</div>
	
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
                  <th><?php echo $this->Paginator->sort('message'); ?></th>
                  <th><?php echo $this->Paginator->sort('created'); ?></th>
                  <th>Action</th>

				</tr>
				</thead>
				<tbody>
						<?php foreach ($contact as $contacts ): ?>
					<tr>
					<td>#<?php echo h($contacts['Contact']['id']); ?>&nbsp;</td>
					<td><?php echo h($contacts['Contact']['name']); ?>&nbsp;</td>
					<td><?php echo h($contacts['Contact']['email']); ?>&nbsp;</td>
					<td><?php echo h($contacts['Contact']['phone']); ?>&nbsp;</td>
					<td><?php echo h($contacts['Contact']['message']); ?>&nbsp;</td>					
                    <td> <?php echo date('d-M-Y',strtotime($contacts['Contact']['created'])); ?></td>
					<td><a class="btn btn-mini btn-success" 
					href="<?= $this->Url->build(['action' => 'admin_contact_delete', $contacts['Contact']['id']]) ?>"> Delete</a></td>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?= $this->Paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} records out of {{count}} total')]) ?></div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><?= $this->Paginator->prev('< ' . __('previous'), ['class' => 'prev disabled']) ?></li>
				
				<li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><?= $this->Paginator->next(__('next') . ' >', ['class' => 'next disabled']) ?></li>
				
			</ul>
			</div>
		</div>
	</div>	
</div>		