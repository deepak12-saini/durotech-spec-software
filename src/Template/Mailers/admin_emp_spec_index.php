	<style>
		.btn{ margin-bottom:5px; }


	.btn-group .btn {
		margin-right: 10px;      /* Space between buttons */
		min-width: 120px;        /* Make buttons uniform width */
		transition: all 0.2s;    /* Smooth hover effect */
	}

	.btn-group .btn:hover {
		transform: translateY(-2px); /* Slight lift on hover */
	}

	.btn.active {
		box-shadow: 0 4px 6px rgba(0,0,0,0.2); /* Highlight active button */
		font-weight: bold;
	}
	#simple-table tbody tr {
		display: table-row !important;
	}

	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Employees DuroEzy Specification
			<?php echo $this->Html->link('Create New Spec', '/admin/mailers/send_v3', ['class' => 'btn btn-info btn-xs top-button']); ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">

			<div class="btn-group" role="group" aria-label="Filter">
				<?php
				echo $this->Html->link(
					'All',
					array('action'=>'admin_emp_spec_index', '?' => array('status'=>'all')),
					array('class' => 'btn btn-default ' . ($filter=='all' ? 'active' : ''))
				);
				echo $this->Html->link(
					'Pending',
					array('action'=>'admin_emp_spec_index', '?' => array('status'=>'pending')),
					array('class' => 'btn btn-warning ' . ($filter=='pending' ? 'active' : ''))
				);
				echo $this->Html->link(
					'Approved',
					array('action'=>'admin_emp_spec_index', '?' => array('status'=>'approved')),
					array('class' => 'btn btn-success ' . ($filter=='approved' ? 'active' : ''))
				);
				?>
			</div>

			<div class="alert alert-info" style="margin-top:12px;margin-bottom:16px;">
				<strong>Workflow (employee specs):</strong>
				<ol style="margin:8px 0 0 18px;padding:0;">
					<li><strong>One screen</strong> — Open <em>Review &amp; Edit</em>, then use <strong>Review &amp; Approve</strong> on that page to review and finalise in one step.</li>
					<li><strong>Or two steps</strong> — Use <em>Save review only</em> on the review page, then <em>Pending for Approval</em> on this list (approve is blocked until review is saved).</li>
				</ol>
			</div>

			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th>Tracknumber</th>
					<th>Employee Name</th>
					<th>Name/Attn</th>
					<th>Email</th>
					<th>Project</th>
					<th>Address</th>
					<th>Specification</th>
					<th>Date</th>
					<!-- <th><?php echo $this->Paginator->sort('type'); ?></th>					
					<th><?php echo $this->Paginator->sort('subject'); ?></th>				 -->	
					<th>Created</th>
										<th>Approve Status</th>

					<th>Action <small class="text-muted" title="View Details = full spec summary"><i class="fa fa-eye"></i></small></th>
				</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($mailers as $mailer):
					$pdfUrl = !empty($mailer->pdf_attachment)
						? $this->Pdf->url(ltrim((string)$mailer->pdf_attachment, '/'))
						: null;
						$status = (int)($mailer->status ?? 0);
						$is_review = (int)($mailer->is_review ?? 0);
						$id = (int)($mailer->id ?? 0);
					?>
					<tr>
					<td>#<?php echo h($mailer->tracknumber ?? ''); ?>&nbsp;</td>
					<td><?php
						$empId = (int)($mailer->employee_id ?? 0);
						$empName = $employeeNameMap[$empId] ?? null;
						echo h($empName !== null && $empName !== '' ? $empName : ('#' . ($mailer->employee_id ?? $id)));
					?>&nbsp;</td>
					<td><?php echo h($mailer->name ?? ''); ?>&nbsp;</td>
					<td><?php echo h($mailer->email ?? ''); ?>&nbsp;</td>					
					<td><?php echo h($mailer->company ?? ''); ?>&nbsp;</td>
					<td><?php echo h($mailer->address ?? ''); ?>&nbsp;</td>
					<td><?php echo h($mailer->specification ?? ''); ?>&nbsp;</td>
					<td><?php echo h($mailer->date ?? ''); ?>&nbsp;</td>
					<!-- <td><?php if($mailer['Mailer']['type'] == 3){ echo 'External Liquid WPM'; } ?></td>					
					<td><?php echo h($mailer['Mailer']['subject']); ?></td>			 -->		
                    <td> <?php echo h(!empty($mailer->created) ? format_db_date('d-M-Y h:i a', $mailer->created) : ''); ?></td>
				   <td>
						<?php
							$status = (int)($mailer->status ?? 0);
							$is_review = (int)($mailer->is_review ?? 0);
							$id = (int)($mailer->id ?? 0);

							if ($is_review === 0) {
								echo '<span class="label label-warning">Pending Review</span>';
							} elseif ($status === 0 && $is_review === 1) {
								echo '<a href="' . SITEURL . 'admin/mailers/approve/' . $id . '" class="label label-info" onclick="return confirm(\'Approve this spec?\')">Pending for Approval</a>';
							} elseif ($status === 1 && $is_review === 1) {
								echo '<span class="label label-success">Approved</span>';
							} else {
								echo '<span class="label label-default">Unknown</span>';
							}
						?>
					</td>
					<td>
						<?php if ((int)($mailer->is_review ?? 0) != 1) : ?>
							<div style="display:flex; flex-direction:column; align-items:flex-start; gap:6px;">
								<a class="btn btn-mini btn-info" title="View Details" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_view_spec', $id, '?' => ['from' => 'emp']]); ?>"><i class="fa fa-eye"></i></a>
								<a class="btn btn-mini btn-primary" 
								href="<?php echo SITEURL.'admin/mailers/review_edit/'.$mailer->id; ?>">
									Review & Edit
								</a>

								<?php if ($pdfUrl): ?>
									<a class="btn btn-mini btn-info" href="<?php echo $pdfUrl; ?>" target="_blank">Download</a>
								<?php else: ?>
									<span class="btn btn-mini btn-default" title="PDF not generated">No PDF</span>
								<?php endif; ?>
							</div>
						<?php else: ?>
							<div style="display:flex; flex-direction:column; align-items:flex-start; gap:6px;">
								<a class="btn btn-mini btn-info" title="View Details" href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_view_spec', $id, '?' => ['from' => 'emp']]); ?>"><i class="fa fa-eye"></i></a>
								<span class="badge badge-success p-2">
									<i class="fas fa-check-circle"></i> Reviewed
								</span>

								<?php if ($pdfUrl): ?>
									<a class="btn btn-mini btn-info" href="<?php echo $pdfUrl; ?>" target="_blank">Download</a>
								<?php else: ?>
									<span class="btn btn-mini btn-default" title="PDF not generated">No PDF</span>
								<?php endif; ?>
							</div>
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
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite">
				<?php echo __('showing {0} to {1} records out of {2} entries', $start, $end, $totalCount); ?>
			</div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<li class="paginate_button previous <?php echo $hasPrev ? '' : 'disabled'; ?>" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous">
					<?php if ($hasPrev): ?>
						<a href="<?php echo $this->Url->build(['action' => 'admin_emp_spec_index', '?' => ['status' => $filter, 'page' => $page - 1]]); ?>">&lt; <?php echo __('previous'); ?></a>
					<?php else: ?>
						<a href="javascript:void(0)">&lt; <?php echo __('previous'); ?></a>
					<?php endif; ?>
				</li>
				<li class="paginate_button next <?php echo $hasNext ? '' : 'disabled'; ?>" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next">
					<?php if ($hasNext): ?>
						<a href="<?php echo $this->Url->build(['action' => 'admin_emp_spec_index', '?' => ['status' => $filter, 'page' => $page + 1]]); ?>"><?php echo __('next'); ?> &gt;</a>
					<?php else: ?>
						<a href="javascript:void(0)"><?php echo __('next'); ?> &gt;</a>
					<?php endif; ?>
				</li>
				
			</ul>
			</div>
		</div>
	</div>	
</div>		
<script type="text/javascript">
jQuery(function ($) {
	// Keep server-side paginated rows visible if any legacy script hides table rows.
	$('#simple-table tbody tr').css('display', 'table-row');
});
</script>