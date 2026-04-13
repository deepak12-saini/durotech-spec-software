<?php
$nappUser = $nappUser ?? [];
$name = $name ?? '';
?>
<style>
.btn { margin-bottom: 5px; }
.label { margin-bottom: 5px; }
</style>

<div class="page-content">
	<div class="page-header">
		<h1>Customer Management
			<form action="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_customer']) ?>" method="get" style="float:right;">
				<input type="text" name="name" value="<?= h($name) ?>" placeholder="Search By Name">
				<input type="submit" name="search" value="search" class="btn btn-info btn-xs">
				<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_customer']) ?>" class="btn btn-warning btn-xs">Show All</a>
			</form>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="simple-table">
					<thead>
						<tr>
							<th><?= $this->Paginator->sort('name', 'Name') ?></th>
							<th><?= $this->Paginator->sort('email') ?></th>
							<th><?= $this->Paginator->sort('mobile_number', 'Mobile / phone') ?></th>
							<th><?= $this->Paginator->sort('company', 'Company/position/zipcode/website') ?></th>
							<th><?= $this->Paginator->sort('address_1', 'Address') ?></th>
							<th>Assign Level</th>
							<th><?= $this->Paginator->sort('insert_date', 'Date') ?></th>
							<th class="actions"><?= __('Actions') ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($nappUser as $user): ?>
						<tr>
							<td><?= h(ucfirst($user->name ?? '') . ' ' . ucfirst($user->lname ?? '')) ?></td>
							<td><?= h($user->email) ?></td>
							<td>
								Mobile: <?= h($user->mobile_number ?? '') ?><br>
								Phone: <?= h($user->phone ?? '') ?>
							</td>
							<td>
								<b>Company:</b> <?= h($user->company ?? '') ?><br>
								<b>Position:</b> <?= h($user->position ?? '') ?><br>
								<b>Zipcode:</b> <?= h($user->zipcode ?? '') ?><br>
								<b>Website:</b> <?= h($user->website ?? '') ?>
							</td>
							<td>
								<?= h($user->address_1 ?? '') ?>
								<?= h($user->address_2 ?? '') ?>
								<?= h($user->address_3 ?? '') ?>
								<?= h($user->address_4 ?? '') ?>
								<?= h($user->address_5 ?? '') ?>
							</td>
							<td>
								<?php
								$labels = '';
								$labAssigns = $user->lab_assigns ?? [];
								foreach ($labAssigns as $labAssign) {
									$labFile = $labAssign->lab_file ?? null;
									if ($labFile) {
										$type = (int)($labFile->type ?? 0);
										$label = h($labFile->label ?? '');
										$labels .= $type === 0
											? '<b class="label label-success">' . $label . '</b><br> '
											: '<b class="label label-danger">' . $label . '</b><br> ';
									}
								}
								echo $labels ?: '&nbsp;';
								?>
							</td>
							<td><?= ($user->insert_date ? format_db_date('d-M-Y', $user->insert_date) : '') ?></td>
							<td>
								<?php if ((int)($user->is_active ?? 0) === 1): ?>
									<a class="btn btn-xs btn-success" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_customer_status', $user->id, 0]) ?>" onclick="return confirm('Deactivate this customer account? They will not be able to login.');">Deactivate Login</a>
								<?php else: ?>
									<a class="btn btn-xs btn-danger" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_customer_status', $user->id, 1]) ?>" onclick="return confirm('Activate this customer account?');">Activate Login</a>
								<?php endif; ?>
								<?php if ((int)($user->is_natspec_presentation ?? 0) === 0): ?>
									<a class="btn btn-xs btn-danger" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_natspec_presentation_status', $user->id, 1]) ?>">Presentation Active</a>
								<?php else: ?>
									<a class="btn btn-xs btn-success" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_natspec_presentation_status', $user->id, 0]) ?>">Presentation Deactive</a>
								<?php endif; ?>
								<?php if ((int)($user->is_cpd_presentation ?? 0) === 0): ?>
									<a class="btn btn-xs btn-danger" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_cpd_presentation_status', $user->id, 1]) ?>">Refuel CPD Active</a>
								<?php else: ?>
									<a class="btn btn-xs btn-success" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_cpd_presentation_status', $user->id, 0]) ?>">Refuel CPD Deactive</a>
								<?php endif; ?>
								<a class="btn btn-xs btn-info" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_access', $user->id]) ?>">Price PDF</a>
								<a class="btn btn-xs btn-warning" href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'admin_customerpermission', $user->id]) ?>">Customer Permission</a>
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
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">
				<?= $this->Paginator->counter(__('showing {{current}} records out of {{count}} entries')) ?>
			</div>
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
