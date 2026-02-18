	<div class="page-content">
		<div class="page-header">
			<h1>
			Duro Sales Team
				<a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'staff']); ?>" class="btn btn-mini btn-danger" style="float:right;">Give Sale Permssion To Staff</a>
			</h1>
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
				<th><?php echo $this->Paginator->sort('mobile_number'); ?></th>
				<th><?php echo $this->Paginator->sort('department'); ?></th>				
				<th><?php echo $this->Paginator->sort('status'); ?></th>				
               

				<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
				</thead>
				<tbody>
					<?php foreach ($staff as $staffs): ?>
					<?php
					$nu = is_object($staffs) ? $staffs : (object)($staffs['NappUser'] ?? $staffs);
					$dept = null;
					if (is_object($staffs)) {
						$dept = $staffs->department ?? null;
					} else {
						$dept = isset($staffs['Department']) ? (is_object($staffs['Department']) ? $staffs['Department'] : (object)$staffs['Department']) : null;
					}
					$nuId = $nu->id ?? null;
					$nuName = trim(($nu->name ?? '') . ' ' . ($nu->lname ?? ''));
					$nuEmail = $nu->email ?? '';
					$nuMobile = $nu->mobile_number ?? '';
					$deptTitle = $dept ? ($dept->department_title ?? '') : '';
					$isApproved = (int)($nu->is_approved ?? 0);
					?>
					<tr>
					<td>#<?php echo $nuId !== null ? h($nuId) : ''; ?>&nbsp;</td>
					<td><?php echo h($nuName); ?>&nbsp;</td>
					<td><?php echo h($nuEmail); ?>&nbsp;</td>
					<td><?php echo h($nuMobile); ?>&nbsp;</td>
					<td><?php echo h($deptTitle); ?>&nbsp;</td>					
					<td>
					<?php if($isApproved == 1){?>
						<span class="label label-success">Approved</span>
					<?php }else{ ?>
					<span class="label label-danger">Not Approve</span>
					<?php }?>&nbsp;
					</td>
                    <td>
						<?php if ($nuId !== null): ?>
						<a href="<?php echo $this->Url->build('/admin/sales/settarget/' . $nuId); ?>" class="btn btn-mini btn-warning">Set Target</a>
						<a href="<?php echo $this->Url->build('/admin/sales/report/' . $nuId); ?>" class="btn btn-mini btn-danger">Report</a>
						<a href="<?php echo $this->Url->build('/admin/sales/attendance_report/' . $nuId); ?>" class="btn btn-mini btn-info">Attendence Report</a>
						<?php endif; ?>
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