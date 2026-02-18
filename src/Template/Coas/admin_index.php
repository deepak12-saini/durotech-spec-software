<style>
	.btn{ margin-bottom:5px; }
</style>
<div class="page-content">
	<div class="page-header">
		<h1>COA Durotech
		<?= $this->Html->link('Create New COA', ['controller' => 'Coas', 'action' => 'admin_create'], ['class' => 'btn btn-info btn-xs top-button']); ?>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="simple-table">
					<thead>
						<tr>
							<th><?= $this->Paginator->sort('id'); ?></th>
							<th><?= $this->Paginator->sort('Created By', 'Users.name'); ?></th>
							<th><?= $this->Paginator->sort('product'); ?></th>
							<th><?= $this->Paginator->sort('batch_no'); ?></th>
							<th><?= $this->Paginator->sort('date_of_manu'); ?></th>
							<th><?= $this->Paginator->sort('expiry_date'); ?></th>
							<th><?= $this->Paginator->sort('form_no'); ?></th>
							<th><?= $this->Paginator->sort('created'); ?></th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($coa as $item): ?>
							<?php
							$userName = $item->user->name ?? '';
							$userUsername = $item->user->username ?? '';
							?>
							<tr>
								<td>#<?= h($item->id); ?>&nbsp;</td>
								<td><?= h($userName) . ($userUsername ? ' (' . h($userUsername) . ')' : ''); ?>&nbsp;</td>
								<td><?= h($item->product); ?>&nbsp;</td>
								<td><?= h($item->batch_no); ?>&nbsp;</td>
								<td><?= h($item->date_of_manu); ?>&nbsp;</td>
								<td><?= h($item->expiry_date); ?>&nbsp;</td>
								<td><?= h($item->form_no); ?>&nbsp;</td>
								<td><?= $item->created ? date('d-M-Y h:i a', strtotime($item->created)) : ''; ?></td>
								<td>
									<a class="btn btn-mini btn-primary" href="<?= $this->Url->build(['controller' => 'Coas', 'action' => 'admin_edit', $item->id]); ?>">Edit</a>
									<a class="btn btn-mini btn-info" href="<?= $this->Url->build(['controller' => 'Coas', 'action' => 'admin_download', $item->id]); ?>" target="_blank">Download</a>
									<a class="btn btn-mini btn-danger" href="<?= $this->Url->build(['controller' => 'Coas', 'action' => 'admin_sendemail', $item->id]); ?>" onclick="return confirm('Are you sure send email?');">Send Mail</a>
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
			<div class="dataTables_info"><?= $this->Paginator->counter('Showing {{current}} records out of {{count}} entries'); ?></div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers">
				<ul class="pagination">
					<li><?= $this->Paginator->prev('< ' . __('previous'), [], null, ['class' => 'prev disabled']); ?></li>
					<li><?= $this->Paginator->next(__('next') . ' >', [], null, ['class' => 'next disabled']); ?></li>
				</ul>
			</div>
		</div>
	</div>
</div>
