<?php
$labelArr = $labelArr ?? [];
$label = $label ?? '';
$label_cate_id = $label_cate_id ?? '';
$LabelCategory = $LabelCategory ?? [];
?>
<style>
select { padding: 0px 4px; height: 29px; width: 205px; font-size: 14px; }
.label { margin-top: 5px; }
</style>
<div class="page-content">
	<div class="page-header">
		<h1>
			Product Label List
			<a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'admin_addlabel']) ?>" class="btn btn-mini btn-success">Add Label</a>
			<form action="<?= $this->Url->build(['controller' => 'Products', 'action' => 'admin_label']) ?>" method="get" style="float:right;">
				<select name="label_cate_id" id="category_id">
					<option value="">Please select category</option>
					<?php foreach ($LabelCategory as $cat): ?>
						<option <?= ($label_cate_id !== '' && $label_cate_id == ($cat->id ?? '')) ? 'selected' : '' ?> value="<?= h($cat->id ?? '') ?>"><?= h($cat->category ?? '') ?></option>
					<?php endforeach; ?>
				</select>
				<input type="text" name="label" value="<?= h($label) ?>" placeholder="Search By Label">
				<input type="submit" name="search" value="search" class="btn btn-info btn-xs top-button">
				<a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'admin_label']) ?>" class="btn btn-warning btn-xs top-button">Clear All</a>
			</form>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="simple-table">
					<thead>
						<tr>
							<th><?= $this->Paginator->sort('id') ?></th>
							<th><?= $this->Paginator->sort('Label Category') ?></th>
							<th><?= $this->Paginator->sort('name', 'Label Name') ?></th>
							<th><?= $this->Paginator->sort('weight') ?></th>
							<th>Download Files</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php if (!empty($labelArr)): $i = 1; foreach ($labelArr as $item): ?>
						<tr>
							<td>#<?= $i ?>&nbsp;</td>
							<td><?= h($item->label_category->category ?? '') ?>&nbsp;</td>
							<td><?= h($item->name ?? '') ?>&nbsp;</td>
							<td><?= h($item->weight ?? '') ?>&nbsp;</td>
							<td><a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'download', $item->url ?? '']) ?>"><?= h($item->url ?? '') ?></a>&nbsp;</td>
							<td>
								<a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'admin_editlabel', $item->id]) ?>" class="btn btn-mini btn-info">Edit</a>&nbsp;
								<a href="<?= $this->Url->build(['controller' => 'Products', 'action' => 'admin_deletelabel', $item->id]) ?>" onclick="return confirm('Are you sure delete?')" class="btn btn-mini btn-danger">Delete</a>&nbsp;
							</td>
						</tr>
						<?php $i++; endforeach; else: ?>
						<tr>
							<td colspan="10" style="text-align:center; color:red; font-weight:bold;">No Product label Found</td>
						</tr>
						<?php endif; ?>
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
					<li class="paginate_button previous"><?= $this->Paginator->prev('< ' . __('previous'), [], null, ['class' => 'prev disabled']) ?></li>
					<li class="paginate_button next"><?= $this->Paginator->next(__('next') . ' >', [], null, ['class' => 'next disabled']) ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>
