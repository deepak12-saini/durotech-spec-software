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

			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('tracknumber'); ?></th>					
					<th><?php echo $this->Paginator->sort('Employee Name'); ?></th>					
					<th><?php echo $this->Paginator->sort('name','Name/Attn'); ?></th>
					<th><?php echo $this->Paginator->sort('Email'); ?></th>
					<th><?php echo $this->Paginator->sort('Company'); ?></th>
					<th><?php echo $this->Paginator->sort('address'); ?></th>
					<th><?php echo $this->Paginator->sort('specification'); ?></th>
					<th><?php echo $this->Paginator->sort('date'); ?></th>
					<!-- <th><?php echo $this->Paginator->sort('type'); ?></th>					
					<th><?php echo $this->Paginator->sort('subject'); ?></th>				 -->	
					<th><?php echo $this->Paginator->sort('created'); ?></th>
										<th><?php echo $this->Paginator->sort('status', 'Approve Status'); ?></th>

					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($mailers as $mailer):
					$pdfUrl = !empty($mailer->pdf_attachment)
						? (rtrim(SITEURL, '/') . '/' . ltrim($mailer->pdf_attachment, '/'))
						: null;
						$status = (int)($mailer->status ?? 0);
						$is_review = (int)($mailer->is_review ?? 0);
						$id = (int)($mailer->id ?? 0);
					?>
					<tr>
					<td>#<?php echo h($mailer->tracknumber ?? ''); ?>&nbsp;</td>
					<td><?php
						$empName = (!empty($mailer->employee) && isset($mailer->employee->name)) ? $mailer->employee->name : ($mailer->employee_name ?? null);
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
                    <td> <?php echo !empty($mailer->created) ? date('d-M-Y h:i a',strtotime((string)$mailer->created)) : ''; ?></td>
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
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter(array(
'format' => __('showing {{start}} to {{end}} records out of {{count}} entries')));?>	</div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));?></li>
				
				<li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><?php echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));?></li>
				
			</ul>
			</div>
		</div>
	</div>	
</div>		