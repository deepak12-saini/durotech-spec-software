	<div class="page-content">
		<div class="page-header">
			<h1>Category Management <a href="<?= h(rtrim(SITEURL, '/') . '/admin/categories/add') ?>" class="btn btn-info btn-xs top-button">Add New</a></h1>
		</div>

	<div class="row">
		<div class="col-xs-12">
			<?= $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline', 'style' => 'margin-bottom:15px;']) ?>
				<div class="form-group">
					<label for="cat-search" class="control-label" style="margin-right:5px;">Search</label>
					<input type="text"
						   name="q"
						   id="cat-search"
						   value="<?= h($search ?? '') ?>"
						   class="form-control input-sm"
						   placeholder="Name, slug or description">
				</div>
				<div class="form-group" style="margin-left:10px;">
					<label for="cat-status" class="control-label" style="margin-right:5px;">Status</label>
					<select name="status" id="cat-status" class="form-control input-sm">
						<option value="">All</option>
						<option value="1" <?= (isset($status) && $status === '1') ? 'selected' : '' ?>>Active</option>
						<option value="0" <?= (isset($status) && $status === '0') ? 'selected' : '' ?>>Inactive</option>
					</select>
				</div>
				<button type="submit" class="btn btn-sm btn-primary" style="margin-left:10px;">Filter</button>
				<a href="<?= h(rtrim(SITEURL, '/') . '/admin/categories') ?>" class="btn btn-sm btn-default" style="margin-left:5px;">Reset</a>
			<?= $this->Form->end() ?>
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
				<th><?= $this->Paginator->sort('id') ?></th>
				<th><?= $this->Paginator->sort('category_name') ?></th>
				<th><?= $this->Paginator->sort('slug') ?></th>
				<th><?= $this->Paginator->sort('description') ?></th>
				<th><?= $this->Paginator->sort('image') ?></th>
				 <th><?= $this->Paginator->sort('active') ?></th>
                  <th><?= $this->Paginator->sort('created') ?></th>

				<th class="actions"><?= __('Actions') ?></th>
				</tr>
				</thead>
				<tbody>
						<?php foreach ($categories as $category): ?>
					<tr>
					<td>#<?= h($category['Category']['id']) ?>&nbsp;</td>
					<td><?= h($category['Category']['category_name']) ?>&nbsp;</td>
					<td><?= h($category['Category']['slug']) ?>&nbsp;</td>
					<td><?= h($category['Category']['description']) ?>&nbsp;</td>
					<td><?php $img = $category['Category']['image'] ?? ''; if ($img): ?><img src="<?= h(rtrim(SITEURL, '/') . '/files/category/' . $img) ?>" width="150" alt=""/><?php else: ?>—<?php endif; ?>&nbsp;</td>
					 <td>
						<?php if (($category['Category']['status'] ?? 0) == 1): ?>
							<span class="label label-success">Active</span>
						<?php else: ?>
						<span class="label label-danger">Inactive</span>
						<?php endif ?>&nbsp;
						</td>
                    <td> <?= format_db_date('d-M-Y', $category['Category']['created'] ?? 'now') ?></td>
					 <td class="actions">
						<a href="<?= h(rtrim(SITEURL, '/') . '/admin/categories/edit/' . (int)$category['Category']['id']) ?>" class="btn btn-mini btn-info">Edit</a>
						<?= $this->Form->postLink(__('Delete'), ['action' => 'adminDelete', $category['Category']['id']], ['class' => 'btn btn-mini btn-danger', 'confirm' => __('Are you sure you want to delete # {0}?', $category['Category']['id'])]) ?>

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
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?= $this->Paginator->counter(['format' => __('showing {{current}} records out of {{count}} entries')]) ?></div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><?= $this->Paginator->prev('< ' . __('previous'), [], null, ['class' => 'prev disabled']) ?></li>

				<li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><?= $this->Paginator->next(__('next') . ' >', [], null, ['class' => 'next disabled']) ?></li>

			</ul>
			</div>
		</div>
	</div>
</div>
