	<div class="page-content">
		<div class="page-header">
			<h1>
			
			Broucher Product List <?php echo $this->Html->link('Add New', ['controller' => 'BroucherProducts', 'action' => 'admin_add'], ['class' => 'btn btn-info btn-xs top-button']); ?>
			
			<?php echo $this->Form->create(null, ['url' => ['action' => 'admin_index'], 'type' => 'get', 'style' => 'float:right;']); ?>
				<input type="text" name="productname" value="<?php echo h($name); ?>" placeholder="Search By Product Name">
				<?php echo $this->Form->submit('search', ['class' => 'btn btn-info btn-xs top-button']); ?>
				<?php if ($name !== ''): ?>
					<?php echo $this->Html->link('Clear', ['controller' => 'BroucherProducts', 'action' => 'admin_index'], ['class' => 'btn btn-default btn-xs top-button']); ?>
				<?php endif; ?>
			<?php echo $this->Form->end(); ?>				
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('title','Product Name'); ?></th>
				<th><?php echo $this->Paginator->sort('product_code'); ?></th>
				<th><?php echo $this->Paginator->sort('Category Name'); ?></th>
				<th><?php echo $this->Paginator->sort('Broucher Cate'); ?></th> 
				
				<th><?php echo $this->Paginator->sort('image'); ?></th>
			
				 <th><?php echo $this->Paginator->sort('active'); ?></th>
				 <th><?php echo $this->Paginator->sort('featured'); ?></th>
                  <th><?php echo $this->Paginator->sort('created'); ?></th>

				<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
				</thead>
				<tbody>
						<?php if(!empty($product)){ foreach ($product as $product_arr): ?>
					<tr>
					<td>#<?php echo h($product_arr['BroucherProduct']['id']); ?>&nbsp;</td>
					<td><?php echo h($product_arr['BroucherProduct']['title']); ?>&nbsp;</td>
					<td><?php echo h($product_arr['BroucherProduct']['product_code']); ?>&nbsp;</td>
					<td><?php echo h($product_arr['Category']['category_name']); ?>&nbsp;</td>
					<td><?php echo h($product_arr['BorucherCategory']['title']); ?>&nbsp;</td>
					
					<td>
					<?php if(!empty($product_arr['BroucherProduct']['image'])){?>
						<img style="height:50px; width:50px"src="<?php echo SITEURL.'productimg/'.$product_arr['BroucherProduct']['image']?>">
					<?php }else{?>
						No Image
					<?php }?>
					</td>
					 <td>
						<?php if($product_arr['BroucherProduct']['status']==1){?>
							<span class="label label-success">Active</span>
						<?php }else{ ?>
						<span class="label label-danger">Inactive</span>
						<?php }?>&nbsp;
					</td>
					 <td>
						<?php if($product_arr['BroucherProduct']['is_featured']==1){?>
							<span class="label label-success">Featured</span>
						<?php }else{ ?>
						<span class="label label-danger">Non featured</span>
						<?php }?>&nbsp;
					</td>
                    <td> <?php echo format_db_date('d-M-Y', $product_arr['BroucherProduct']['created']); ?></td>
					 <td class="actions">
						<?php echo $this->Html->link(__('Edit'), ['controller' => 'BroucherProducts', 'action' => 'admin_edit', $product_arr['BroucherProduct']['id']], ['class' => 'btn btn-mini btn-info']); ?>
						<?php echo $this->Html->link(__('Project Image'), ['controller' => 'Products', 'action' => 'project', $product_arr['BroucherProduct']['id']], ['class' => 'btn btn-mini btn-primary']); ?>
						<?php echo $this->Form->postLink(__('Delete'), ['controller' => 'BroucherProducts', 'action' => 'admin_delete', $product_arr['BroucherProduct']['id']], ['class' => 'btn btn-mini btn-danger', 'style' => 'margin-top:2px;'], __('Are you sure you want to delete # %s?', $product_arr['BroucherProduct']['id'])); ?>
						
						</td>
					</tr>
					<?php endforeach; }else{ ?>
						<tr>
							 <td colspan="10" style="text-align:center; color:red; font-weight:bold;">No Product Found</td>
						</tr>
					<?php } ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php
				echo $this->Paginator->counter(['format' => __('showing {{current}} records out of {{count}} entries')]);
			?></div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<?php echo $this->Paginator->prev('< ' . __('previous'), ['tag' => 'li'], null, ['tag' => 'li', 'class' => 'prev disabled', 'disabledTag' => 'a']); ?>
				<?php echo $this->Paginator->numbers(['tag' => 'li', 'separator' => '', 'currentTag' => 'a', 'currentClass' => 'active']); ?>
				<?php echo $this->Paginator->next(__('next') . ' >', ['tag' => 'li'], null, ['tag' => 'li', 'class' => 'next disabled', 'disabledTag' => 'a']); ?>
			</ul>
			</div>
		</div>
	</div>	
</div>		