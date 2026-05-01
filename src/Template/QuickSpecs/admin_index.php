<div class="page-content">
	<div class="page-header">
		<h1>Quick Spec requests</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="quick-specs-table">
					<thead>
					<tr>
						<th>ID</th>
						<th>Project</th>
						<th>Type</th>
						<th>Contact</th>
						<th>Email</th>
						<th>Status</th>
						<th>Created</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($quickSpecs as $row): ?>
						<?php
						$r = is_object($row) ? $row : (object)$row;
						$rid = (int)($r->id ?? 0);
						$st = (string)($r->status ?? '');
						?>
						<tr>
							<td data-order="<?php echo h((string)$rid); ?>">#<?php echo h((string)$rid); ?></td>
							<td><?php echo h((string)($r->project_name ?? '')); ?></td>
							<td><?php echo h((string)($r->project_type ?? '')); ?></td>
							<td><?php echo h((string)($r->name ?? '')); ?></td>
							<td><?php echo h((string)($r->email ?? '')); ?></td>
							<td>
								<?php if ($st === 'new') { ?>
									<span class="label label-danger">New</span>
								<?php } elseif ($st === 'seen') { ?>
									<span class="label label-warning">Seen</span>
								<?php } else { ?>
									<span class="label label-success">Done</span>
								<?php } ?>
							</td>
							<td><?php echo !empty($r->created) ? h(format_db_date('d-M-Y H:i', $r->created)) : ''; ?></td>
							<td>
								<?php echo $this->Html->link(__('View'), ['action' => 'admin_view', $rid], ['class' => 'btn btn-xs btn-info']); ?>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="paginator">
				<ul class="pagination">
					<?php echo $this->Paginator->prev('< ' . __('previous')); ?>
					<?php echo $this->Paginator->numbers(); ?>
					<?php echo $this->Paginator->next(__('next') . ' >'); ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<script>
$(document).ready(function() {
	if ($('#quick-specs-table').length) {
		$('#quick-specs-table').DataTable({
			order: [[0, 'desc']],
			columnDefs: [{ orderable: false, targets: 7 }]
		});
	}
});
</script>
