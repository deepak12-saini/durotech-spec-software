<?php
$totalCount = (int)$this->Paginator->param('count');
$draftCount = 0;
$submittedCount = 0;
foreach ($aiSpecs as $row) {
	$r = is_object($row) ? $row : (object)$row;
	if (($r->save_status ?? '') === 'draft') {
		$draftCount++;
	} else {
		$submittedCount++;
	}
}
?>
<div class="page-content aispec-admin">
	<div class="page-header clearfix">
		<div class="pull-right page-header-actions">
			<?php echo $this->Html->link(
				'<i class="ace-icon fa fa-plus"></i> New materials matrix',
				['action' => 'admin_send'],
				['class' => 'btn btn-success', 'escape' => false]
			); ?>
		</div>
		<h1>
			AiSpec materials matrix
			<small><i class="ace-icon fa fa-angle-double-right"></i> Manage specifications &amp; PDFs</small>
		</h1>
	</div>

	<div class="row aispec-stat-row">
		<div class="col-sm-4">
			<div class="aispec-stat-card">
				<div class="stat-num"><?php echo h((string)$totalCount); ?></div>
				<div class="stat-label">Total records</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="aispec-stat-card">
				<div class="stat-num" style="color:#5cb85c;"><?php echo h((string)$submittedCount); ?></div>
				<div class="stat-label">Submitted (this page)</div>
			</div>
		</div>
		<div class="col-sm-4">
			<div class="aispec-stat-card">
				<div class="stat-num" style="color:#f0ad4e;"><?php echo h((string)$draftCount); ?></div>
				<div class="stat-label">Drafts (this page)</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="widget-box">
				<div class="widget-header clearfix">
					<h5 class="pull-left"><i class="ace-icon fa fa-table"></i> All materials matrices</h5>
				</div>
				<div class="widget-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="aispec-table">
							<thead>
							<tr>
								<th>ID</th>
								<th>Track #</th>
								<th>Project / Client</th>
								<th>Rev</th>
								<th>Doc reference</th>
								<th>Status</th>
								<th>Created</th>
								<th class="text-center">Actions</th>
							</tr>
							</thead>
							<tbody>
							<?php if (count($aiSpecs) === 0): ?>
								<tr>
									<td colspan="8" class="text-center" style="padding:32px;color:#7a8a99;">
										<i class="ace-icon fa fa-inbox fa-2x" style="display:block;margin-bottom:8px;"></i>
										No materials matrices yet.
										<?php echo $this->Html->link('Create your first one', ['action' => 'admin_send']); ?>.
									</td>
								</tr>
							<?php endif; ?>
							<?php foreach ($aiSpecs as $row): ?>
								<?php
								$r = is_object($row) ? $row : (object)$row;
								$rid = (int)($r->id ?? 0);
								$st = (string)($r->save_status ?? '');
								$pdf = trim((string)($r->pdf_attachment ?? ''));
								?>
								<tr>
									<td data-order="<?php echo h((string)$rid); ?>"><strong>#<?php echo h((string)$rid); ?></strong></td>
									<td><span class="aispec-track"><?php echo h((string)($r->tracknumber ?? '')); ?></span></td>
									<td>
										<div class="aispec-project">
											<strong title="<?php echo h((string)($r->project ?? '')); ?>"><?php echo h((string)($r->project ?? '')); ?></strong>
											<small><?php echo h((string)($r->client ?? '')); ?></small>
										</div>
									</td>
									<td class="text-center"><span class="badge badge-grey"><?php echo h((string)($r->revision ?? '')); ?></span></td>
									<td><small><?php echo h((string)($r->doc_reference ?? '—')); ?></small></td>
									<td class="text-center">
										<?php if ($st === 'draft') { ?>
											<span class="label label-warning label-draft">Draft</span>
										<?php } else { ?>
											<span class="label label-success label-submitted">Submitted</span>
										<?php } ?>
									</td>
									<td class="aispec-created"><?php echo !empty($r->created) ? h(format_db_date('d M Y, H:i', $r->created)) : '—'; ?></td>
									<td class="text-center aispec-actions">
										<div class="btn-group">
											<?php if ($pdf !== '') { ?>
												<a href="<?php echo h(SITEURL . $pdf); ?>" target="_blank" class="btn btn-xs btn-primary" title="View PDF">
													<i class="ace-icon fa fa-file-pdf-o"></i> PDF
												</a>
											<?php } ?>
											<?php echo $this->Html->link(
												'<i class="ace-icon fa fa-pencil"></i>',
												['action' => 'admin_edit', $rid],
												['class' => 'btn btn-xs btn-info', 'escape' => false, 'title' => 'Edit']
											); ?>
											<?php echo $this->Form->postLink(
												'<i class="ace-icon fa fa-trash-o"></i>',
												['action' => 'admin_delete', $rid],
												[
													'confirm' => 'Delete this materials matrix?',
													'class' => 'btn btn-xs btn-danger',
													'escape' => false,
													'title' => 'Delete',
												]
											); ?>
										</div>
									</td>
								</tr>
							<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="paginator" style="margin-top:12px;">
				<ul class="pagination">
					<?php echo $this->Paginator->prev('< ' . __('previous')); ?>
					<?php echo $this->Paginator->numbers(); ?>
					<?php echo $this->Paginator->next(__('next') . ' >'); ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php echo $this->element('AiSpecs/admin_styles'); ?>
<script>
$(document).ready(function() {
	if ($('#aispec-table tbody tr').length && !$('#aispec-table tbody tr td[colspan]').length && $.fn.DataTable) {
		$('#aispec-table').DataTable({
			order: [[0, 'desc']],
			pageLength: 25,
			lengthMenu: [[10, 25, 50, -1], [10, 25, 50, 'All']],
			columnDefs: [{ orderable: false, targets: 7 }],
			language: { search: 'Filter:', searchPlaceholder: 'Project, client, track…' }
		});
	}
});
</script>
