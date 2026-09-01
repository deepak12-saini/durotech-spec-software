<?php
$mailerId = (int)($mailer->id ?? 0);
$tracknumber = (string)($mailer->tracknumber ?? '');
$isReview = (int)($mailer->is_review ?? 0);
$status = (int)($mailer->status ?? 0);
$empId = (int)($mailer->employee_id ?? 0);
$isEmployeeSpec = $empId > 0;
$pdfRel = !empty($mailer->pdf_attachment) ? ltrim((string)$mailer->pdf_attachment, '/') : '';
?>
<div class="page-content">
	<div class="page-header">
		<h1>
			Spec Details
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				#<?= h($tracknumber) ?>
			</small>
			<span class="pull-right">
				<?php if ($isEmployeeSpec && $isReview === 0): ?>
					<?= $this->Html->link('<i class="fa fa-pencil"></i> Review &amp; Edit', ['action' => 'admin_review_edit', $mailerId], ['class' => 'btn btn-primary btn-xs', 'escape' => false]) ?>
				<?php elseif ($isEmployeeSpec && $isReview === 1 && $status === 0): ?>
					<?= $this->Html->link('<i class="fa fa-check"></i> Approve', ['action' => 'admin_approve', $mailerId], [
						'class' => 'btn btn-success btn-xs',
						'escape' => false,
						'onclick' => 'return confirm("Approve this employee spec?");',
					]) ?>
					<?= $this->Html->link('<i class="fa fa-pencil"></i> Re-review', ['action' => 'admin_review_edit', $mailerId], ['class' => 'btn btn-default btn-xs', 'escape' => false]) ?>
				<?php elseif (!$isEmployeeSpec): ?>
					<?= $this->Html->link('<i class="fa fa-pencil"></i> Edit', ['action' => 'admin_editsend_v3', $mailerId], ['class' => 'btn btn-primary btn-xs', 'escape' => false]) ?>
				<?php endif; ?>
				<?= $this->Html->link('Back to List', ['action' => $listAction ?? 'admin_index_v3'], ['class' => 'btn btn-default btn-xs']) ?>
			</span>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12 col-lg-6">
			<div class="widget-box">
				<div class="widget-header"><h4 class="widget-title lighter">Client &amp; project</h4></div>
				<div class="widget-body">
					<div class="widget-main">
						<table class="table table-bordered table-condensed" style="margin-bottom:0;">
							<tbody>
								<tr><th style="width:38%;">Track number</th><td>#<?= h($tracknumber) ?></td></tr>
								<?php if ($isEmployeeSpec): ?>
									<tr><th>Employee</th><td><?= h($employeeName !== '' ? $employeeName : ('#' . $empId)) ?></td></tr>
								<?php endif; ?>
								<tr><th>Name / Attn</th><td><?= h($mailer->name ?? '') ?></td></tr>
								<tr><th>Email</th><td><?= h($mailer->email ?? '') ?></td></tr>
								<tr><th>Project</th><td><?= h($mailer->company ?? '') ?></td></tr>
								<tr><th>Address</th><td><?= h($mailer->address ?? '') ?></td></tr>
								<tr><th>Specification</th><td><?= h($mailer->specification ?? '') ?></td></tr>
								<tr><th>Subject</th><td><?= h($mailer->subject ?? '') ?></td></tr>
								<tr><th>Date</th><td><?= h($mailer->date ?? '') ?></td></tr>
								<tr><th>Revision</th><td><?= h($mailer->revision ?? 0) ?></td></tr>
								<tr>
									<th>Status</th>
									<td>
										<?php
										if ($isEmployeeSpec) {
											if ($isReview === 0) {
												echo '<span class="label label-warning">Pending Review</span>';
											} elseif ($isReview === 1 && $status === 0) {
												echo '<span class="label label-info">Reviewed - Awaiting Approval</span>';
											} elseif ($isReview === 1 && $status === 1) {
												echo '<span class="label label-success">Approved</span>';
											} else {
												echo '<span class="label label-default">Unknown</span>';
											}
										} else {
											echo '<span class="label label-primary">Admin spec</span>';
										}
										?>
									</td>
								</tr>
								<tr>
									<th>Created</th>
									<td>
										<?php
										$created = $mailer->created ?? null;
										if ($created instanceof \DateTimeInterface) {
											echo h($created->format('d-M-Y h:i a'));
										} elseif (!empty($created)) {
											echo h(format_db_date('d-M-Y h:i a', (string)$created));
										}
										?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xs-12 col-lg-6">
			<div class="widget-box">
				<div class="widget-header"><h4 class="widget-title lighter">PDF &amp; actions</h4></div>
				<div class="widget-body">
					<div class="widget-main">
						<p style="margin-bottom:12px;">
							<?php if ($pdfRel !== ''): ?>
								<a class="btn btn-sm btn-info" href="<?= h($this->Pdf->url($pdfRel)) ?>" target="_blank"><i class="fa fa-download"></i> Download PDF</a>
							<?php else: ?>
								<span class="text-muted">No PDF attachment saved yet.</span>
							<?php endif; ?>
							<?= $this->Html->link('<i class="fa fa-history"></i> Audit', ['action' => 'admin_audit_log', $mailerId], ['class' => 'btn btn-sm btn-default', 'escape' => false]) ?>
							<?php if ($isEmployeeSpec && $isReview === 1 && $status === 0): ?>
								<?= $this->Html->link('<i class="fa fa-check"></i> Approve', ['action' => 'admin_approve', $mailerId], [
									'class' => 'btn btn-sm btn-success',
									'escape' => false,
									'onclick' => 'return confirm("Approve this employee spec?");',
								]) ?>
							<?php endif; ?>
						</p>
						<?php if (!empty($mailer->spec_email_sent_at)): ?>
							<p class="text-muted" style="margin:0;">
								<strong>Email sent:</strong>
								<?php
								$sentAt = $mailer->spec_email_sent_at;
								echo h($sentAt instanceof \DateTimeInterface ? $sentAt->format('d-M-Y h:i a') : format_db_date('d-M-Y h:i a', (string)$sentAt));
								if (!empty($mailer->spec_email_sent_to)) {
									echo ' to ' . h($mailer->spec_email_sent_to);
								}
								?>
							</p>
						<?php endif; ?>
					</div>
				</div>
			</div>

			<div class="widget-box">
				<div class="widget-header"><h4 class="widget-title lighter">Comments</h4></div>
				<div class="widget-body">
					<div class="widget-main">
						<?php if (!empty($comments) && count($comments) > 0): ?>
							<ol style="margin:0;padding-left:20px;">
								<?php foreach ($comments as $comment): ?>
									<?php $text = trim((string)($comment->comment ?? '')); ?>
									<?php if ($text !== ''): ?>
										<li style="margin-bottom:8px;"><?= h($text) ?></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ol>
						<?php else: ?>
							<p class="text-muted" style="margin:0;">No comments.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="widget-box">
				<div class="widget-header"><h4 class="widget-title lighter">Use areas &amp; products</h4></div>
				<div class="widget-body">
					<div class="widget-main">
						<?php if (!empty($sections)): ?>
							<?php foreach ($sections as $section): ?>
								<h5 style="margin-top:16px;font-weight:700;"><?= h($section['title'] !== '' ? $section['title'] : 'Section') ?></h5>
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-condensed">
										<thead>
											<tr>
												<th>S.No</th>
												<th>Product Type</th>
												<th>Product</th>
												<th>MFT</th>
												<th>Warranty</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach ($section['rows'] as $row): ?>
												<tr>
													<td><?= h($row->serial ?? '') ?></td>
													<td><?= h($row->coverage ?? '') ?></td>
													<td><?= h($row->product ?? '') ?></td>
													<td><?= h($row->coverage_by_pack ?? '') ?></td>
													<td><?= h($row->Warranty ?? '') ?></td>
												</tr>
											<?php endforeach; ?>
										</tbody>
									</table>
								</div>
							<?php endforeach; ?>
						<?php else: ?>
							<p class="text-muted" style="margin:0;">No use area rows recorded.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
