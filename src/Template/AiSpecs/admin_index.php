<?php
$aispecActions = $aispecActions ?? [
	'index' => 'admin_index',
	'send' => 'admin_send',
	'edit' => 'admin_edit',
	'delete' => 'admin_delete',
];
$showAispecStats = $showAispecStats ?? true;
$showAispecWidgetTitle = $showAispecWidgetTitle ?? true;
$enableAispecTableSearch = $enableAispecTableSearch ?? false;
$showAispecPaginator = $showAispecStats;
$totalCount = 0;
$draftCount = 0;
$submittedCount = 0;
if ($showAispecStats) {
	$totalCount = (int)$this->Paginator->param('count');
	foreach ($aiSpecs as $row) {
		$r = is_object($row) ? $row : (object)$row;
		if (($r->save_status ?? '') === 'draft') {
			$draftCount++;
		} else {
			$submittedCount++;
		}
	}
}
?>
<div class="page-content aispec-admin">
	<div class="page-header clearfix">
		<div class="pull-right page-header-actions">
			<?php echo $this->Html->link(
				'<i class="ace-icon fa fa-plus"></i> New materials matrix',
				['action' => $aispecActions['send']],
				['class' => 'btn btn-success', 'escape' => false]
			); ?>
		</div>
		<h1>
			AiSpec materials matrix
			<small><i class="ace-icon fa fa-angle-double-right"></i> Manage specifications &amp; PDFs</small>
		</h1>
	</div>

	<?php if ($showAispecStats): ?>
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
	<?php endif; ?>

	<div class="row">
		<div class="col-xs-12">
			<div class="widget-box">
				<?php if ($showAispecWidgetTitle): ?>
				<div class="widget-header clearfix">
					<h5 class="pull-left"><i class="ace-icon fa fa-table"></i> All materials matrices</h5>
				</div>
				<?php endif; ?>
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
										<?php echo $this->Html->link('Create your first one', ['action' => $aispecActions['send']]); ?>.
									</td>
								</tr>
							<?php endif; ?>
							<?php foreach ($aiSpecs as $row): ?>
								<?php
								$r = is_object($row) ? $row : (object)$row;
								$rid = (int)($r->id ?? 0);
								$st = (string)($r->save_status ?? '');
								$pdf = trim((string)($r->pdf_attachment ?? ''));
								$searchBlob = preg_replace('/\s+/u', ' ', trim(implode(' ', array_filter([
									(string)$rid,
									(string)($r->tracknumber ?? ''),
									(string)($r->project ?? ''),
									(string)($r->client ?? ''),
									(string)($r->revision ?? ''),
									(string)($r->doc_reference ?? ''),
									$st === 'draft' ? 'draft' : 'submitted',
									!empty($r->created) ? format_db_date('d M Y, H:i', $r->created) : '',
								], function ($v) {
									return $v !== '' && $v !== '—';
								}))));
								?>
								<tr data-search="<?php echo h(function_exists('mb_strtolower') ? mb_strtolower($searchBlob, 'UTF-8') : strtolower($searchBlob)); ?>">
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
												['action' => $aispecActions['edit'], $rid],
												['class' => 'btn btn-xs btn-info', 'escape' => false, 'title' => 'Edit']
											); ?>
											<?php echo $this->Form->postLink(
												'<i class="ace-icon fa fa-trash-o"></i>',
												['action' => $aispecActions['delete'], $rid],
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
			<?php if ($showAispecPaginator): ?>
			<div class="paginator" style="margin-top:12px;">
				<ul class="pagination">
					<?php echo $this->Paginator->prev('< ' . __('previous')); ?>
					<?php echo $this->Paginator->numbers(); ?>
					<?php echo $this->Paginator->next(__('next') . ' >'); ?>
				</ul>
			</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php echo $this->element('AiSpecs/admin_styles'); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css" />
<?php if ($enableAispecTableSearch): ?>
<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<?php endif; ?>
<script>
(function() {
	if (!window._aispecListFilterFn) {
		window._aispecListFilterFn = true;
		window.aispecListFilter = '';
		$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
			var tableId = settings.sTableId || (settings.nTable && settings.nTable.id) || '';
			if (tableId !== 'aispec-table') {
				return true;
			}
			var term = window.aispecListFilter || '';
			if (term === '') {
				return true;
			}
			var api = new $.fn.dataTable.Api(settings);
			var node = api.row(dataIndex).node();
			var haystack = '';
			if (node && node.getAttribute) {
				haystack = node.getAttribute('data-search') || '';
			}
			if (haystack === '' && data && data.length) {
				haystack = data.join(' ');
			}
			return haystack.indexOf(term) !== -1;
		});
	}

	function bindAispecFilterInput(dt) {
		var $filter = $(dt.table().container()).find('.dataTables_filter input');
		if (!$filter.length) {
			return;
		}
		$filter.attr('placeholder', 'Project, client, track…');
		$filter.off('keyup.DT search.DT input.DT paste.DT cut.DT .aispecFilter')
			.on('keyup.aispecFilter change.aispecFilter paste.aispecFilter', function() {
				window.aispecListFilter = $.trim($(this).val()).toLowerCase();
				dt.draw();
			});
	}

	$(document).ready(function() {
		var $table = $('#aispec-table');
		var isEmpty = $table.find('tbody tr td[colspan]').length > 0;

		if (!isEmpty && $.fn.DataTable) {
			var dt = $table.DataTable({
				order: [[0, 'desc']],
				pageLength: 25,
				lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
				columnDefs: [{ orderable: false, targets: 7 }],
				language: {
					search: 'Filter:',
					searchPlaceholder: 'Project, client, track…',
					zeroRecords: 'No matching matrices found.'
				},
				initComplete: function() {
					bindAispecFilterInput(this.api());
				}
			});
			// Disable built-in global search (regex); custom ext.search handles filtering.
			dt.search('');
		}
	});
})();
</script>
