<style>
	/* Specs list v3 — polish within Ace admin */
	.spec-v3-page .page-header {
		margin: 0 0 16px;
		padding-bottom: 12px;
		border-bottom: 1px solid #e5e5e5;
	}
	.spec-v3-page .page-header h1 {
		margin: 0;
		font-size: 24px;
		font-weight: 300;
		line-height: 1.3;
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		justify-content: space-between;
		gap: 10px;
	}
	.spec-v3-page .page-header .spec-v3-actions {
		display: inline-flex;
		flex-wrap: wrap;
		gap: 6px;
		align-items: center;
	}
	.spec-v3-page .page-header .spec-v3-actions .btn {
		margin: 0;
	}
	.spec-v3-page .page-header .spec-v3-actions .spec-tab-btn {
		display: inline-flex;
		align-items: center;
		gap: 6px;
		padding-left: 8px;
		padding-right: 12px;
	}
	.spec-v3-page .spec-tab-icon-wrap {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 22px;
		height: 22px;
		background: #1b1b1b;
		border-radius: 50%;
		flex-shrink: 0;
	}
	.spec-v3-page .spec-tab-icon {
		display: block;
		width: 16px;
		height: 16px;
		object-fit: contain;
		margin: 0;
		padding: 0;
		border: 0;
		background: transparent;
	}

	.spec-v3-filters {
		background: #f8f9fb;
		border: 1px solid #e3e6ea;
		border-radius: 4px;
		padding: 14px 14px 6px;
		margin-bottom: 14px;
	}
	.spec-v3-filters .spec-v3-filters-title {
		font-size: 12px;
		font-weight: 600;
		color: #6a6a6a;
		text-transform: uppercase;
		letter-spacing: 0.04em;
		margin: 0 0 10px;
	}
	.spec-v3-filters .form-control {
		margin: 0 8px 8px 0;
		min-width: 140px;
		vertical-align: middle;
	}
	.spec-v3-filters input[type="date"].form-control {
		min-width: 150px;
	}
	.spec-v3-filters .btn {
		margin: 0 6px 8px 0;
		vertical-align: middle;
	}

	.spec-v3-panel {
		background: #fff;
		border: 1px solid #e3e6ea;
		border-radius: 4px;
		padding: 12px 12px 4px;
	}
	.spec-v3-toolbar {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		justify-content: space-between;
		gap: 8px;
		margin-bottom: 4px;
	}
	.spec-v3-export .btn {
		margin: 0;
		min-width: 64px;
	}
	.spec-v3-export .btn + .btn {
		margin-left: 4px;
	}

	/* DataTables controls */
	.spec-v3-panel .dataTables_wrapper .row:first-child {
		margin-bottom: 8px;
	}
	/* Align table / length / search with export toolbar (remove Bootstrap col inset) */
	.spec-v3-panel .dataTables_wrapper > .row {
		margin-left: 0;
		margin-right: 0;
	}
	.spec-v3-panel .dataTables_wrapper > .row > [class*="col-"] {
		padding-left: 0;
		padding-right: 0;
	}
	.spec-v3-panel .dataTables_length,
	.spec-v3-panel .dataTables_filter {
		margin-bottom: 6px;
	}
	.spec-v3-panel .dataTables_filter input {
		margin-left: 0;
		height: 30px;
		padding: 4px 8px;
		min-width: 180px;
	}
	.spec-v3-panel .dataTables_info {
		padding-top: 8px;
		color: #666;
		font-size: 13px;
	}
	.spec-v3-panel .dataTables_paginate {
		padding-top: 4px;
	}

	table#example.table {
		margin-bottom: 0;
		background: #fff;
	}
	table#example.table > thead > tr > th {
		background: #f3f5f7;
		border-bottom-width: 1px;
		color: #478fca;
		font-weight: 600;
		white-space: nowrap;
		vertical-align: middle !important;
		padding: 10px 8px;
	}
	table#example.table > tbody > tr > td {
		vertical-align: middle !important;
		padding: 10px 8px;
		color: #393939;
	}
	table#example.table > tbody > tr:hover > td {
		background-color: #f5f9fc !important;
	}

	.spec-sno {
		width: 48px;
		text-align: center;
		white-space: nowrap;
		font-weight: 600;
		color: #666;
	}
	table#example.table > thead > tr > th.spec-sno {
		text-align: center;
	}
	.spec-pdf-link {
		display: inline-block;
		padding: 2px 8px;
		border: 1px solid #6fb3e0;
		border-radius: 3px;
		color: #4f99c6 !important;
		background: #edf5fa;
		font-size: 11px;
		line-height: 1.4;
		text-decoration: none !important;
		white-space: nowrap;
	}
	.spec-pdf-link:hover {
		background: #dceef8;
		color: #2e6da4 !important;
	}
	.spec-pdf-none {
		color: #999;
		font-size: 12px;
	}
	.spec-email-cell .label {
		display: inline-block;
		margin-bottom: 2px;
	}
	.spec-email-cell small {
		display: block;
		line-height: 1.35;
	}

	.action-btns {
		display: inline-flex;
		flex-wrap: nowrap;
		gap: 4px;
		align-items: center;
		white-space: nowrap;
	}
	.action-btns .btn {
		margin: 0;
		border-radius: 3px;
	}

	@media (max-width: 767px) {
		.spec-v3-page .page-header h1 {
			display: block;
		}
		.spec-v3-filters .form-control {
			width: 100%;
			min-width: 0;
			margin-right: 0;
		}
	}
</style>

<div class="page-content spec-v3-page">
	<div class="page-header">
		<h1>
			<span>DuroEzy Specification <small>v3</small></span>
			<span class="spec-v3-actions">
				<?php
				$cloneIcon = '<span class="spec-tab-icon-wrap">'
					. $this->Html->image('clone_a_spec.png', ['alt' => '', 'class' => 'spec-tab-icon'])
					. '</span>';
				echo $this->Html->link(
					$cloneIcon . 'Create New Spec',
					'/admin/mailers/send_v3',
					['class' => 'btn btn-info btn-sm spec-tab-btn', 'escape' => false]
				);
				if (!empty($hasDraft)) {
					echo ' ';
					echo $this->Html->link(
						$cloneIcon . 'Resume Draft',
						['controller' => 'Mailers', 'action' => 'admin_send_v3', '?' => ['resume' => '1']],
						['class' => 'btn btn-warning btn-sm spec-tab-btn', 'escape' => false]
					);
				}
				echo ' ';
				echo $this->Html->link(
					$cloneIcon . 'Smart Spec (from Previous)',
					['controller' => 'Mailers', 'action' => 'admin_send_v3', '?' => ['mode' => 'adaptive']],
					['class' => 'btn btn-primary btn-sm spec-tab-btn', 'escape' => false]
				);
				echo ' ';
				echo $this->Html->link(
					$cloneIcon . 'Clone a Spec',
					['controller' => 'Mailers', 'action' => 'admin_send_v3', '?' => ['mode' => 'clone']],
					[
						'class' => 'btn btn-purple btn-sm spec-tab-btn',
						'title' => 'Clone Use Area + comments into a new blank client form',
						'escape' => false,
					]
				);
				?>
			</span>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="spec-v3-filters">
				<div class="spec-v3-filters-title">Filter specs</div>
				<?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']); ?>
					<input type="text" name="tracknumber" class="form-control input-sm" placeholder="Track Number" value="<?php echo h($filters['tracknumber'] ?? ''); ?>">
					<input type="text" name="name" class="form-control input-sm" placeholder="Name/Attn" value="<?php echo h($filters['name'] ?? ''); ?>">
					<input type="text" name="email" class="form-control input-sm" placeholder="Email" value="<?php echo h($filters['email'] ?? ''); ?>">
					<input type="text" name="company" class="form-control input-sm" placeholder="Project" value="<?php echo h($filters['company'] ?? ''); ?>">
					<input type="text" name="specification" class="form-control input-sm" placeholder="Specification" value="<?php echo h($filters['specification'] ?? ''); ?>">
					<input type="date" name="date_from" class="form-control input-sm" title="Date from" value="<?php echo h($filters['date_from'] ?? ''); ?>">
					<input type="date" name="date_to" class="form-control input-sm" title="Date to" value="<?php echo h($filters['date_to'] ?? ''); ?>">
					<button type="submit" class="btn btn-primary btn-sm">Filter</button>
					<?php echo $this->Html->link('Reset', ['controller' => 'mailers', 'action' => 'admin_index_v3'], ['class' => 'btn btn-default btn-sm']); ?>
				<?php echo $this->Form->end(); ?>
			</div>

			<div class="spec-v3-panel">
				<div class="spec-v3-toolbar">
					<div class="spec-v3-export btn-group">
						<button type="button" class="btn btn-success btn-sm" id="adminExportCsv" title="Download CSV of all filtered records">
							<i class="fa fa-file-excel-o"></i> CSV
						</button>
						<button type="button" class="btn btn-danger btn-sm" id="adminExportPdf" title="PDF of all filtered records">
							<i class="fa fa-file-pdf-o"></i> PDF
						</button>
						<button type="button" class="btn btn-default btn-sm" id="adminExportPrint" title="Print all filtered records">
							<i class="fa fa-print"></i> Print
						</button>
					</div>
				</div>

				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="example">
						<thead>
							<tr>
								<th class="spec-sno">S.No</th>
								<th>Track Number</th>
								<th>Send Name</th>
								<th>Name/Attn</th>
								<th>Email</th>
								<th>Project</th>
								<th>Address</th>
								<th>Specification</th>
								<th>Date</th>
								<th>PDF</th>
								<th>Created</th>
								<th>Customer email</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							$sno = 0;
							foreach ($mailers as $mailer):
								$sno++;
								if (!empty($mailer['Mailer']['pdf_attachment'])) {
									$pdffilename = basename($mailer['Mailer']['pdf_attachment']);
								} else {
									$rawPdfname = $mailer['Mailer']['id'] . '-' . $mailer['Mailer']['tracknumber'];
									$pdffilename = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $rawPdfname);
									$pdffilename = preg_replace('/_+/', '_', $pdffilename);
									$pdffilename = trim($pdffilename, '_');
									if (empty($pdffilename)) {
										$pdffilename = 'spec_' . $mailer['Mailer']['id'];
									}
									$pdffilename .= '.pdf';
								}
							?>
							<tr>
								<td class="spec-sno"><?php echo (int)$sno; ?></td>
								<td><span class="spec-track">#<?php echo h($mailer['Mailer']['tracknumber']); ?></span></td>
								<td><?php
									$user = $mailer['User'] ?? [];
									$userName = $user['name'] ?? $user['display_name'] ?? $user['username'] ?? '';
									$userUsername = $user['username'] ?? '';
									echo h($userName) . (!empty($userUsername) ? (' <small class="text-muted">(' . h($userUsername) . ')</small>') : '');
								?></td>
								<td><?php echo h($mailer['Mailer']['name']); ?></td>
								<td><?php echo h($mailer['Mailer']['email']); ?></td>
								<td><?php echo h($mailer['Mailer']['company']); ?></td>
								<td><?php echo h($mailer['Mailer']['address']); ?></td>
								<td><?php echo h($mailer['Mailer']['specification']); ?></td>
								<td style="white-space:nowrap;"><?php echo h($mailer['Mailer']['date']); ?></td>
								<td>
									<?php if (!empty($mailer['Mailer']['pdf_attachment'])): ?>
										<a class="spec-pdf-link" href="<?php echo h($this->Pdf->url(ltrim((string)$mailer['Mailer']['pdf_attachment'], '/'))); ?>" target="_blank">View PDF</a>
									<?php else: ?>
										<span class="spec-pdf-none">No attachment</span>
									<?php endif; ?>
								</td>
								<td data-order="<?php
									$created = $mailer['Mailer']['created'] ?? null;
									$createdTs = 0;
									if ($created instanceof \DateTimeInterface) {
										$createdTs = $created->getTimestamp();
									} elseif (!empty($created)) {
										$createdTs = (int)strtotime((string)$created);
									}
									echo (int)$createdTs;
								?>" style="white-space:nowrap;"><?php
									if ($created instanceof \DateTimeInterface) {
										echo h($created->format('d-M-Y h:i a'));
									} elseif (!empty($created)) {
										echo h(format_db_date('d-M-Y h:i a', $created));
									} else {
										echo '—';
									}
								?></td>
								<td class="spec-email-cell">
									<?php
									$specSentAt = $mailer['Mailer']['spec_email_sent_at'] ?? null;
									$specSentTo = $mailer['Mailer']['spec_email_sent_to'] ?? '';
									if (!empty($specSentAt)) {
										$at = $specSentAt instanceof \DateTimeInterface
											? $specSentAt->format('d-M-Y h:i a')
											: format_db_date('d-M-Y h:i a', (string)$specSentAt);
										echo '<span class="label label-success">Sent</span>';
										echo '<small class="text-muted">' . h($at) . '</small>';
										if ($specSentTo !== '') {
											echo '<small class="text-muted">to ' . h($specSentTo) . '</small>';
										}
									} else {
										echo '<span class="label label-default">Not sent</span>';
									}
									?>
								</td>
								<td style="white-space: nowrap;">
									<div class="action-btns">
									<?php
									$specSentAtBtn = $mailer['Mailer']['spec_email_sent_at'] ?? null;
									$sendBtnClass = !empty($specSentAtBtn) ? 'btn btn-mini btn-warning' : 'btn btn-mini btn-danger';
									?>
									<a class="btn btn-mini btn-primary js-edit-spec" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_editsend_v3', $mailer['Mailer']['id']]); ?>">Edit</a>
									<a class="btn btn-mini btn-warning" title="Copy Use Area + comments into a new blank client form" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_send_v3', '?' => ['mode' => 'clone', 'from_id' => $mailer['Mailer']['id']]]); ?>" style="display:inline-flex;align-items:center;gap:4px;">
										<?php echo $this->Html->image('clone_a_spec.png', ['alt' => '', 'style' => 'width:14px;height:14px;object-fit:contain;background:#1b1b1b;border-radius:50%;padding:1px;box-sizing:content-box;']); ?>
										Clone Spec
									</a>
									<a class="btn btn-mini btn-info" href="<?php echo h($this->Pdf->url('dompdf/' . $pdffilename)); ?>" target="_blank">Download</a>
									<a onclick="return confirm('Are you sure send email?')" class="<?php echo h($sendBtnClass); ?>" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_sendemail', $mailer['Mailer']['id']]); ?>">Send Mail</a>
									<a class="btn btn-mini btn-default" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_audit_log', $mailer['Mailer']['id']]); ?>">Audit</a>
									<?php echo $this->Form->postLink('Delete', ['controller' => 'Mailers', 'action' => 'admin_delete_spec_v3', $mailer['Mailer']['id']], [
										'class' => 'btn btn-mini btn-danger',
										'confirm' => !empty($specSoftDelete)
											? 'Remove this spec from the list? It will be hidden; contact support if you need it restored.'
											: 'Delete this spec permanently? This cannot be undone.',
									]); ?>
									</div>
								</td>
							</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {
	var dt = $('#example').DataTable({
		"order": [[10, "desc"]],
		"columnDefs": [
			{ "targets": 0, "orderable": false, "searchable": false },
			{ "targets": 12, "orderable": false }
		],
		// Distinct labels: top = page size, bottom = range; right = quick filter (no "Search:" vs Filter Specs clash)
		"language": {
			"lengthMenu": "Rows per page _MENU_",
			"search": "_INPUT_",
			"searchPlaceholder": "Quick search in table…",
			"info": "Records _START_–_END_ of _TOTAL_",
			"infoEmpty": "No records to show",
			"infoFiltered": "(filtered from _MAX_ total)",
			"paginate": {
				"previous": "Prev",
				"next": "Next"
			}
		},
		"dom": "<'row'<'col-xs-6'l><'col-xs-6'f>>" +
			"<'row'<'col-xs-12'tr>>" +
			"<'row'<'col-xs-6'i><'col-xs-6'p>>",
		"drawCallback": function () {
			var api = this.api();
			var start = api.page.info().start;
			api.column(0, { page: 'current' }).nodes().each(function (cell, i) {
				cell.innerHTML = start + i + 1;
			});
		}
	});

	var params = new URLSearchParams(window.location.search || '');
	var pageParam = parseInt(params.get('page') || '1', 10);
	if (!isNaN(pageParam) && pageParam > 1) {
		var targetIndex = pageParam - 1;
		if (targetIndex < dt.page.info().pages) {
			dt.page(targetIndex).draw('page');
		}
	}

	$(document).on('click', 'a.js-edit-spec', function() {
		var currentPage = (dt.page.info().page || 0) + 1;
		var href = ($(this).attr('href') || '').split('?')[0];
		if (!href) return;
		$(this).attr('href', href + '?page=' + currentPage);
	});

	var exportBase = <?php echo json_encode($this->Url->build('/admin/mailers/export_specs')); ?>;
	var filterKeys = ['tracknumber', 'name', 'email', 'company', 'specification', 'date_from', 'date_to'];

	function buildExportUrl(format) {
		var q = new URLSearchParams(window.location.search || '');
		var out = new URLSearchParams();
		out.set('format', format);
		for (var i = 0; i < filterKeys.length; i++) {
			var key = filterKeys[i];
			var val = q.get(key);
			if (val) out.set(key, val);
		}
		return exportBase + '?' + out.toString();
	}

	$('#adminExportCsv').on('click', function () {
		window.location.href = buildExportUrl('csv');
	});
	$('#adminExportPdf, #adminExportPrint').on('click', function () {
		window.open(buildExportUrl('print'), '_blank');
	});
});
</script>
