<style>
	/* Spec list filters — one clean inline row */
	.spec-emp-filters {
		background: #f8f9fb;
		border: 1px solid #e3e6ea;
		border-radius: 4px;
		padding: 12px;
		margin-bottom: 12px;
	}
	.spec-emp-filters-form {
		display: flex;
		flex-wrap: wrap;
		align-items: center;
		gap: 8px;
		margin: 0;
	}
	.spec-emp-filters-form .form-control {
		margin: 0;
		min-width: 130px;
		flex: 0 1 140px;
		height: 30px;
	}
	.spec-emp-filters-form input[type="date"].form-control {
		min-width: 145px;
		flex: 0 0 145px;
	}
	.spec-emp-filters-form .btn {
		margin: 0;
		height: 30px;
		padding-top: 4px;
		padding-bottom: 4px;
		flex: 0 0 auto;
	}
	/* Keep action buttons on one horizontal row */
	.action-btns {
		display: inline-flex;
		flex-wrap: nowrap;
		gap: 4px;
		align-items: center;
		white-space: nowrap;
	}
	.action-btns .btn { margin-bottom: 0; margin-right: 0; }
	/* Center cell content when Address/Project wrap (overrides Ace/Bootstrap top align) */
	table#example.table > thead > tr > th,
	table#example.table > tbody > tr > td {
		vertical-align: middle !important;
	}
	table#example.table > thead > tr > th.spec-sno,
	table#example.table > tbody > tr > td.spec-sno {
		width: 48px;
		text-align: center;
		white-space: nowrap;
		font-weight: 600;
		color: #666;
	}
	/* Spec top action buttons — match admin btn-sm height */
	.page-header h1 .top-button.spec-tab-btn,
	.page-header h1 .btn.spec-tab-btn {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		gap: 6px;
		vertical-align: middle;
		box-sizing: border-box;
		height: 30px;
		min-height: 30px;
		max-height: 30px;
		line-height: 1.3;
		font-size: 12px;
		padding-top: 0;
		padding-bottom: 0;
		padding-left: 10px;
		padding-right: 12px;
		margin-top: 0;
		margin-bottom: 0;
	}
	.page-header h1 .top-button.spec-tab-btn .fa,
	.page-header h1 .btn.spec-tab-btn .fa {
		font-size: 13px;
		line-height: 1;
		width: 14px;
		text-align: center;
		margin-right: 0 !important;
	}
	.page-header h1 .top-button.spec-tab-btn .clone-btn-icon-wrap,
	.page-header h1 .btn.spec-tab-btn .clone-btn-icon-wrap {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 20px;
		height: 20px;
		background: #1b1b1b;
		border-radius: 50%;
		box-shadow: 0 0 0 1px rgba(0,0,0,0.25);
		flex-shrink: 0;
	}
	.page-header h1 .top-button.spec-tab-btn .clone-btn-icon,
	.page-header h1 .btn.spec-tab-btn .clone-btn-icon {
		display: block;
		width: 14px;
		height: 14px;
		object-fit: contain;
		margin: 0;
		padding: 0;
		border: 0;
		border-radius: 0;
		background: transparent;
	}
	/* Row-level Clone button (mini) */
	.btn-mini.spec-tab-btn {
		display: inline-flex;
		align-items: center;
		gap: 4px;
		padding-left: 5px;
		padding-right: 8px;
		height: 24px;
		min-height: 24px;
		line-height: 1.2;
		box-sizing: border-box;
	}
	.btn-mini.spec-tab-btn .clone-btn-icon-wrap {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		width: 16px;
		height: 16px;
		background: #1b1b1b;
		border-radius: 50%;
		flex-shrink: 0;
	}
	.btn-mini.spec-tab-btn .clone-btn-icon {
		width: 12px;
		height: 12px;
		object-fit: contain;
		display: block;
		margin: 0;
		padding: 0;
		background: transparent;
	}
	/* Distinct Spec action colors (Create=teal, Smart=blue, Clone=purple) */
	.page-header h1 .btn.spec-tab-btn.btn-spec-create,
	.btn.spec-tab-btn.btn-spec-create {
		background-color: #6fb3e0 !important;
		border-color: #5aa3d4 !important;
		color: #fff !important;
	}
	.page-header h1 .btn.spec-tab-btn.btn-spec-create:hover,
	.page-header h1 .btn.spec-tab-btn.btn-spec-create:focus,
	.btn.spec-tab-btn.btn-spec-create:hover,
	.btn.spec-tab-btn.btn-spec-create:focus {
		background-color: #5aa3d4 !important;
		border-color: #4a93c4 !important;
		color: #fff !important;
	}
	.page-header h1 .btn.spec-tab-btn.btn-spec-smart,
	.btn.spec-tab-btn.btn-spec-smart {
		background-color: #2563eb !important;
		border-color: #1d4ed8 !important;
		color: #fff !important;
	}
	.page-header h1 .btn.spec-tab-btn.btn-spec-smart:hover,
	.page-header h1 .btn.spec-tab-btn.btn-spec-smart:focus,
	.btn.spec-tab-btn.btn-spec-smart:hover,
	.btn.spec-tab-btn.btn-spec-smart:focus {
		background-color: #1d4ed8 !important;
		border-color: #1e40af !important;
		color: #fff !important;
	}
	.page-header h1 .btn.spec-tab-btn.btn-spec-clone,
	.btn.spec-tab-btn.btn-spec-clone {
		background-color: #7c3aed !important;
		border-color: #6d28d9 !important;
		color: #fff !important;
	}
	.page-header h1 .btn.spec-tab-btn.btn-spec-clone:hover,
	.page-header h1 .btn.spec-tab-btn.btn-spec-clone:focus,
	.btn.spec-tab-btn.btn-spec-clone:hover,
	.btn.spec-tab-btn.btn-spec-clone:focus {
		background-color: #6d28d9 !important;
		border-color: #5b21b6 !important;
		color: #fff !important;
	}
</style>

<div class="page-content">
	<!-- Page header with title and spec actions -->
	<div class="page-header">
		<h1>DuroEzy Specification
			<?php
			$cloneIcon = '<span class="clone-btn-icon-wrap">'
				. $this->Html->image('clone_a_spec.png', [
					'alt' => '',
					'class' => 'clone-btn-icon',
				])
				. '</span>';
			$faIcon = function ($faClass) {
				return '<i class="fa ' . h($faClass) . '" style="margin-right:5px;"></i>';
			};
			// Create New Spec: always opens a blank form (no draft loaded; no auto-resume)
			echo $this->Html->link(
				$faIcon('fa-plus') . 'Create New Spec',
				['controller' => 'employees', 'action' => 'employee_send_v3'],
				['class' => 'btn btn-xs top-button spec-tab-btn btn-spec-create', 'escape' => false]
			);
			// Resume Draft: only when a draft exists AND user clicks this button
			if (!empty($hasDraft)) {
				echo ' ';
				echo $this->Html->link(
					$faIcon('fa-pencil') . 'Resume Draft',
					['controller' => 'employees', 'action' => 'employee_send_v3', '?' => ['resume' => '1']],
					['class' => 'btn btn-warning btn-xs top-button spec-tab-btn', 'escape' => false]
				);
			}
			echo ' ';
			echo $this->Html->link(
				$faIcon('fa-magic') . 'Smart Spec (from Previous)',
				['controller' => 'employees', 'action' => 'employee_send_v3', '?' => ['mode' => 'adaptive']],
				['class' => 'btn btn-xs top-button spec-tab-btn btn-spec-smart', 'escape' => false]
			);
			// Template Spec — hidden until client confirms. Uncomment to enable.
			// echo ' ';
			// echo $this->Html->link(
			// 	$faIcon('fa-file-text-o') . 'Template Spec',
			// 	['controller' => 'employees', 'action' => 'employee_send_v3', '?' => ['mode' => 'template']],
			// 	['class' => 'btn btn-success btn-xs top-button spec-tab-btn', 'escape' => false]
			// );
			echo ' ';
			echo $this->Html->link(
				$cloneIcon . 'Clone a Spec',
				['controller' => 'employees', 'action' => 'employee_send_v3', '?' => ['mode' => 'clone']],
				[
					'class' => 'btn btn-xs top-button spec-tab-btn btn-spec-clone',
					'title' => 'Clone Use Area + comments into a new blank client form',
					'escape' => false,
				]
			);
			?>
		</h1>
	</div>

	<!-- Main content row -->
	<div class="row">
		<div class="col-xs-12">
			<div class="spec-emp-filters">
				<?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'spec-emp-filters-form']); ?>
					<input type="text" name="tracknumber" class="form-control input-sm" placeholder="Track Number" value="<?php echo h($filters['tracknumber'] ?? ''); ?>">
					<input type="text" name="name" class="form-control input-sm" placeholder="Name/Attn" value="<?php echo h($filters['name'] ?? ''); ?>">
					<input type="text" name="email" class="form-control input-sm" placeholder="Email" value="<?php echo h($filters['email'] ?? ''); ?>">
					<input type="text" name="company" class="form-control input-sm" placeholder="Project" value="<?php echo h($filters['company'] ?? ''); ?>">
					<input type="date" name="date_from" class="form-control input-sm" title="Date from" value="<?php echo h($filters['date_from'] ?? ''); ?>">
					<input type="date" name="date_to" class="form-control input-sm" title="Date to" value="<?php echo h($filters['date_to'] ?? ''); ?>">
					<button type="submit" class="btn btn-primary btn-sm">Filter</button>
					<?php echo $this->Html->link('Reset', ['controller' => 'employees', 'action' => 'index'], ['class' => 'btn btn-default btn-sm']); ?>
				<?php echo $this->Form->end(); ?>
			</div>

			<!-- Makes the table scrollable if necessary -->
			<div class="table-responsive">
				<div class="clearfix" style="margin-bottom:8px;">
					<div class="pull-left dt-buttons btn-group" style="margin-bottom:6px;">
						<button type="button" class="btn btn-success btn-sm" id="empExportCsv" title="Download CSV of all filtered records">CSV</button>
						<button type="button" class="btn btn-danger btn-sm" id="empExportPdf" title="PDF of all filtered records">PDF</button>
						<button type="button" class="btn btn-default btn-sm" id="empExportPrint" title="Print all filtered records">Print</button>
					</div>
					<div class="pull-right" style="max-width:280px;">
						<input type="text" id="employeeTableSearch" class="form-control input-sm" placeholder="Search in current table...">
					</div>
				</div>
				<!-- Main data table -->
				<table class="table table-striped table-bordered table-hover" id="example">
					<!-- Table header -->
					<thead>
						<tr>
							<th class="spec-sno">S.No</th>
							<th>TrackNumber</th>
							<th>Employee Name</th>
							<th>Name/Attn</th>
							<th>Email</th>
							<th>Project</th>
							<th>Address</th>
							<th>Specification</th>
							<th>Date</th>
							<th>PDF Attachment</th>
							<th>Approve Status</th>
							<th>Revision</th>
							<th>Created</th>
							<th>Customer email</th>
							<th>Action</th>
						</tr>
					</thead>

					<!-- Table body -->
					<tbody>
						<?php
						$pagingParams = $this->Paginator->params();
						$sno = max(0, (int)($pagingParams['start'] ?? 1) - 1);
						// Loop through each mailer record from the controller
						foreach ($mailers as $mailer):
							$sno++;
							// Support both CakePHP 2 arrays and CakePHP 3 entities.
							if (is_array($mailer) && isset($mailer['Mailer'])) {
								$mailerData = (array)$mailer['Mailer'];
							} elseif (is_object($mailer) && method_exists($mailer, 'toArray')) {
								$mailerData = (array)$mailer->toArray();
							} else {
								$mailerData = (array)$mailer;
							}

							if (is_array($mailer) && isset($mailer['Employee'])) {
								$employeeData = (array)$mailer['Employee'];
							} elseif (is_object($mailer) && isset($mailer->employee) && $mailer->employee) {
								$employeeData = method_exists($mailer->employee, 'toArray') ? (array)$mailer->employee->toArray() : (array)$mailer->employee;
							} else {
								$employeeData = [];
							}

							$mailerId = $mailerData['id'] ?? null;
							$tracknumber = $mailerData['tracknumber'] ?? '';
							$pdfBaseName = $mailerId . '-' . $tracknumber;
							$pdfBaseName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', (string)$pdfBaseName);
							$pdfBaseName = preg_replace('/_+/', '_', (string)$pdfBaseName);
							$pdfBaseName = trim((string)$pdfBaseName, '_');
							if ($pdfBaseName === '') {
								$pdfBaseName = 'spec_' . (string)$mailerId;
							}
							$pdffilename = $pdfBaseName . '.pdf';
							// Prefer DB path after edit/regen so Download matches the latest PDF.
							$pdfRel = 'dompdf/' . $pdffilename;
							if (!empty($mailerData['pdf_attachment'])) {
								$pdfRel = ltrim((string)$mailerData['pdf_attachment'], '/');
							}
							$pdfHref = $this->Pdf->url($pdfRel);
						?>
						<tr>
							<td class="spec-sno"><?php echo (int)$sno; ?></td>
							<!-- Output data for each column -->
							<td>#<?php echo h($tracknumber); ?>&nbsp;</td>
							<td><?php echo h($employeeData['name'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['name'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['email'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['company'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['address'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['specification'] ?? ''); ?>&nbsp;</td>
							<td><?php echo h($mailerData['date'] ?? ''); ?>&nbsp;</td>

							<!-- PDF View Link -->
							<td>
								<?php if (!empty($mailerData['pdf_attachment'])): ?>
									<a href="<?php echo h($this->Pdf->url(ltrim((string)$mailerData['pdf_attachment'], '/'))); ?>" target="_blank">View PDF</a>
								<?php else: ?>
									No Attachment
								<?php endif; ?>
							</td>

							<td>
								<?php
									$status = (int)($mailerData['status'] ?? 0);
									$is_review = (int)($mailerData['is_review'] ?? 0);

									if ($is_review === 0) {
										echo '<span class="label label-warning">Pending Review</span>';
									} elseif ($is_review === 1 && $status === 0) {
										echo '<span class="label label-info">Reviewed - Awaiting Approval</span>';
									} elseif ($is_review === 1 && $status === 1) {
										echo '<span class="label label-success">Approved</span>';
									} else {
										echo '<span class="label label-default">Unknown</span>';
									}
								?>
							</td>


							<td><?php echo h($mailerData['revision'] ?? 0); ?></td>


							<!-- Created Date -->
							<td>
								<?php
								$created = $mailerData['created'] ?? null;

								if (!empty($created)) {
									if ($created instanceof \DateTimeInterface) {
										echo $created->format('d-M-Y h:i a');
									} else {
										echo format_db_date('d-M-Y h:i a', trim($created));
									}
								}
								?>
								</td>

							<td>
								<?php
								$specSentAt = $mailerData['spec_email_sent_at'] ?? null;
								$specSentTo = $mailerData['spec_email_sent_to'] ?? '';
								if (!empty($specSentAt)) {
									$at = $specSentAt instanceof \DateTimeInterface
										? $specSentAt->format('d-M-Y h:i a')
										: format_db_date('d-M-Y h:i a', (string)$specSentAt);
									echo '<span class="label label-success">Sent</span><br><small>' . h($at) . '</small>';
									if ($specSentTo !== '') {
										echo '<br><small class="text-muted">to ' . h($specSentTo) . '</small>';
									}
								} else {
									echo '<span class="label label-default">Not sent</span>';
								}
								?>
							</td>

							<!-- Action buttons (horizontal) -->
							<td style="white-space: nowrap;">
								<div class="action-btns">
								<?php
									$is_review = (int)($mailerData['is_review'] ?? 0);
									$specSentAtBtn = $mailerData['spec_email_sent_at'] ?? null;
									$sendBtnClass = !empty($specSentAtBtn) ? 'btn btn-mini btn-warning' : 'btn btn-mini btn-danger';

									// Allow edit, send, download if not submitted yet
									if ($is_review === 0) {
										echo $this->Html->link(
											'Edit',
											['controller' => 'employees', 'action' => 'editsend_v3', $mailerId, '?' => ['page' => max(1, (int)$this->request->getQuery('page'))]],
											['class' => 'btn btn-mini btn-primary']
										);
									} else {
										echo $this->Html->link(
											'Edit',
											['controller' => 'employees', 'action' => 'editsend_v3', $mailerId, '?' => ['page' => max(1, (int)$this->request->getQuery('page'))]],
											['class' => 'btn btn-mini btn-primary']
										);

										// Only allow download once submitted
										//echo $this->Html->link('Download', SITEURL . 'dompdf/' . $pdffilename, array('class' => 'btn btn-mini btn-info', 'target' => '_blank'));
									}
									echo $this->Html->link('Send Mail', ['controller' => 'employees', 'action' => 'emp_sendemail', $mailerId], ['class' => $sendBtnClass, 'onclick' => 'return confirm("Are you sure send email?")']);

									echo $this->Html->link('History', array('controller' => 'employees', 'action' => 'audit_log', $mailerId), array('class' => 'btn btn-mini btn-default'));

									echo $this->Html->link(
										'<i class="fa fa-eye"></i> Preview',
										['controller' => 'employees', 'action' => 'preview_pdf', $mailerId],
										[
											'class' => 'btn btn-mini btn-success',
											'target' => '_blank',
											'title' => 'Preview PDF with current design',
											'escape' => false,
										]
									);

									$pdfDownloadUrl = $pdfHref;
									echo $this->Html->link('Download', $pdfDownloadUrl, array('class' => 'btn btn-mini btn-info', 'target' => '_blank'));

									echo $this->Html->link(
										$cloneIcon . 'Clone Spec',
										['controller' => 'employees', 'action' => 'employee_send_v3', '?' => ['mode' => 'clone', 'from_id' => $mailerId]],
										['class' => 'btn btn-mini btn-warning spec-tab-btn', 'title' => 'Copy Use Area + comments into a new blank client form', 'escape' => false]
									);

									// Save Template — hidden until client confirms Template Spec. Uncomment to enable.
									// echo $this->Form->postLink(
									// 	'Save Template',
									// 	['controller' => 'employees', 'action' => 'saveTemplateFromSpec', $mailerId],
									// 	['class' => 'btn btn-mini btn-success', 'confirm' => 'Save this spec as template preset?']
									// );

									echo $this->Form->postLink('Delete', array('controller' => 'employees', 'action' => 'deleteSpec', $mailerId), array(
										'class' => 'btn btn-mini btn-xs btn-default',
										'confirm' => !empty($specSoftDelete)
											? 'Remove this spec from your list? It will be hidden from your dashboard; contact support if you need it restored.'
											: 'Delete this spec? This cannot be undone.',
										'escape' => false,
									));

								?>
								</div>
							</td>

						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
			<div class="text-center" style="margin-top: 10px;">
				<?php $this->Paginator->options(['url' => array_filter((array)($filters ?? []), function ($v) { return $v !== null && $v !== ''; })]); ?>
				<ul class="pagination" style="margin:0;">
					<?php echo $this->Paginator->first('<< First'); ?>
					<?php echo $this->Paginator->prev('< Prev'); ?>
					<?php echo $this->Paginator->numbers(); ?>
					<?php echo $this->Paginator->next('Next >'); ?>
					<?php echo $this->Paginator->last('Last >>'); ?>
				</ul>
				<div style="margin-top:6px;">
					<?php echo $this->Paginator->counter('{{start}}-{{end}} of {{count}} records'); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
(function () {
	var input = document.getElementById('employeeTableSearch');
	var table = document.getElementById('example');
	if (table) {
		var tbody = table.getElementsByTagName('tbody')[0];
		if (input && tbody) {
			input.addEventListener('input', function () {
				var q = (input.value || '').toLowerCase().trim();
				var rows = tbody.getElementsByTagName('tr');
				for (var i = 0; i < rows.length; i++) {
					var text = (rows[i].innerText || rows[i].textContent || '').toLowerCase();
					rows[i].style.display = (q === '' || text.indexOf(q) !== -1) ? '' : 'none';
				}
			});
		}
	}

	// Server export: all filtered pages (same filters as list), not just current page
	var exportBase = <?php echo json_encode($this->Url->build(['controller' => 'employees', 'action' => 'export_specs'])); ?>;
	var filterKeys = ['tracknumber', 'name', 'email', 'company', 'date_from', 'date_to'];

	function buildExportUrl(format) {
		var params = new URLSearchParams(window.location.search || '');
		var out = new URLSearchParams();
		out.set('format', format);
		for (var i = 0; i < filterKeys.length; i++) {
			var key = filterKeys[i];
			var val = params.get(key);
			if (val) out.set(key, val);
		}
		return exportBase + '?' + out.toString();
	}

	var csvBtn = document.getElementById('empExportCsv');
	var pdfBtn = document.getElementById('empExportPdf');
	var printBtn = document.getElementById('empExportPrint');

	if (csvBtn) {
		csvBtn.addEventListener('click', function () {
			window.location.href = buildExportUrl('csv');
		});
	}
	if (pdfBtn) {
		pdfBtn.addEventListener('click', function () {
			window.open(buildExportUrl('print'), '_blank');
		});
	}
	if (printBtn) {
		printBtn.addEventListener('click', function () {
			window.open(buildExportUrl('print'), '_blank');
		});
	}
})();
</script>
