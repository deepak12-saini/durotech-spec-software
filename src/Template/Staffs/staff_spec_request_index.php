<style>
	.btn { margin-bottom: 5px; }
</style>

<div class="page-content">
	<div class="page-header">
		<h1>DuroEzy Specification
			<?php echo $this->Html->link('Create Easy Spec Request', ['controller' => 'staffs', 'action' => 'staff_specRequest_form'], ['class' => 'btn btn-info btn-xs top-button']); ?>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="well well-sm" style="margin-bottom:12px;">
				<?php echo $this->Form->create(null, ['type' => 'get', 'class' => 'form-inline']); ?>
					<input type="text" name="tracknumber" class="form-control input-sm" placeholder="Track Number" value="<?php echo h($filters['tracknumber'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="text" name="name" class="form-control input-sm" placeholder="Name/Attn" value="<?php echo h($filters['name'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="text" name="email" class="form-control input-sm" placeholder="Email" value="<?php echo h($filters['email'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="text" name="company" class="form-control input-sm" placeholder="Company" value="<?php echo h($filters['company'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<input type="text" name="specification" class="form-control input-sm" placeholder="Specification" value="<?php echo h($filters['specification'] ?? ''); ?>" style="margin-right:6px;margin-bottom:6px;">
					<button type="submit" class="btn btn-primary btn-xs" style="margin-right:6px;margin-bottom:6px;">Filter</button>
					<?php echo $this->Html->link('Reset', ['controller' => 'staffs', 'action' => 'staff_specRequest_index'], ['class' => 'btn btn-default btn-xs', 'style' => 'margin-bottom:6px;']); ?>
				<?php echo $this->Form->end(); ?>
			</div>

			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="example">
					<thead>
						<tr>
							<th>TrackNumber</th>
							<th>Name/Attn</th>
							<th>Email</th>
							<th>Company</th>
							<th>Address</th>
							<th>Specification</th>
							<th>Date</th>
							<th>PDF Attachment</th>
							<th>Created</th>
							<th>Customer email</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach (($mailers ?? []) as $mailer): ?>
							<?php
								$mailerData = method_exists($mailer, 'toArray') ? $mailer->toArray() : (array)$mailer;
							?>
							<tr>
								<td>#<?php echo h($mailerData['tracknumber'] ?? ''); ?>&nbsp;</td>
								<td><?php echo h($mailerData['name'] ?? ''); ?>&nbsp;</td>
								<td><?php echo h($mailerData['email'] ?? ''); ?>&nbsp;</td>
								<td><?php echo h($mailerData['company'] ?? ''); ?>&nbsp;</td>
								<td><?php echo h($mailerData['address'] ?? ''); ?>&nbsp;</td>
								<td><?php echo h($mailerData['specification'] ?? ''); ?>&nbsp;</td>
								<td><?php echo h($mailerData['date'] ?? ''); ?>&nbsp;</td>
								<td>
									<?php if (!empty($mailerData['pdf_attachment'])): ?>
										<a href="<?php echo h(\Cake\Routing\Router::url('/', true) . ltrim((string)$mailerData['pdf_attachment'], '/')); ?>" target="_blank">View PDF</a>
									<?php else: ?>
										No Attachment
									<?php endif; ?>
								</td>
								<td>
									<?php
									$created = $mailerData['created'] ?? null;
									if ($created instanceof \DateTimeInterface) {
										echo h($created->format('d-M-Y h:i a'));
									} elseif (!empty($created)) {
										echo h(format_db_date('d-M-Y h:i a', (string)$created));
									} else {
										echo '—';
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
								<td>
									<?php
									$specSentAtBtn = $mailerData['spec_email_sent_at'] ?? null;
									$sendBtnClass = !empty($specSentAtBtn) ? 'btn btn-mini btn-warning' : 'btn btn-mini btn-danger';
									$pdfHref = '';
									if (!empty($mailerData['pdf_attachment'])) {
										$pdfHref = \Cake\Routing\Router::url('/', true) . ltrim((string)$mailerData['pdf_attachment'], '/');
									} else {
										$pdfBaseName = (string)($mailerData['id'] ?? '') . '-' . (string)($mailerData['tracknumber'] ?? '');
										$pdfBaseName = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $pdfBaseName);
										$pdfBaseName = preg_replace('/_+/', '_', (string)$pdfBaseName);
										$pdfBaseName = trim((string)$pdfBaseName, '_');
										if ($pdfBaseName !== '') {
											$pdfHref = \Cake\Routing\Router::url('/', true) . 'dompdf/' . $pdfBaseName . '.pdf';
										}
									}
									?>
									<?php echo $this->Html->link('Edit', ['controller' => 'staffs', 'action' => 'staff_specRequest_form', '?' => ['source_id' => (int)($mailerData['id'] ?? 0)]], ['class' => 'btn btn-mini btn-primary']); ?>
									<?php if ($pdfHref !== ''): ?>
										<a class="btn btn-mini btn-info" href="<?php echo h($pdfHref); ?>" target="_blank">Download</a>
									<?php endif; ?>
									<?php echo $this->Html->link('Send Mail', ['controller' => 'staffs', 'action' => 'staff_sendemail', (int)($mailerData['id'] ?? 0)], ['class' => $sendBtnClass, 'onclick' => 'return confirm("Are you sure send email?")']); ?>
									<?php echo $this->Html->link('Audit', ['controller' => 'staffs', 'action' => 'staff_audit_log', (int)($mailerData['id'] ?? 0)], ['class' => 'btn btn-mini btn-default']); ?>
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
