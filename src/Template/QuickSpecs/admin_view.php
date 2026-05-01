<?php
/** @var \App\Model\Entity\QuickSpec $quickSpec */
$q = $quickSpec;
?>
<div class="page-content">
	<div class="page-header">
		<h1>Quick Spec #<?php echo h((string)$q->id); ?>
			<?php echo $this->Html->link(__('Back to list'), ['action' => 'admin_index'], ['class' => 'btn btn-xs btn-inverse', 'style' => 'float:right;']); ?>
		</h1>
	</div>
	<div class="row">
		<div class="col-md-8">
			<table class="table table-bordered">
				<tr><th>Project name</th><td><?php echo h((string)$q->project_name); ?></td></tr>
				<tr><th>Project type</th><td><?php echo h((string)$q->project_type); ?></td></tr>
				<tr><th>Area</th><td><?php echo h((string)$q->area); ?></td></tr>
				<tr><th>Product / system</th><td><?php echo h((string)$q->system_interest); ?></td></tr>
				<tr><th>Quantity / size</th><td><?php echo h((string)$q->quantity_or_size); ?></td></tr>
				<tr><th>Name</th><td><?php echo h((string)$q->name); ?></td></tr>
				<tr><th>Email</th><td><a href="mailto:<?php echo h((string)$q->email); ?>"><?php echo h((string)$q->email); ?></a></td></tr>
				<tr><th>Phone</th><td><?php echo h((string)$q->phone); ?></td></tr>
				<tr><th>Company</th><td><?php echo h((string)$q->company); ?></td></tr>
				<tr><th>State</th><td><?php echo h((string)$q->state); ?></td></tr>
				<tr><th>Notes</th><td><?php echo nl2br(h((string)($q->notes ?? ''))); ?></td></tr>
				<tr><th>IP</th><td><?php echo h((string)$q->ip_address); ?></td></tr>
				<tr><th>User agent</th><td><small><?php echo h((string)$q->user_agent); ?></small></td></tr>
				<tr><th>Created</th><td><?php echo !empty($q->created) ? h(format_db_date('d-M-Y H:i:s', $q->created)) : ''; ?></td></tr>
			</table>
		</div>
		<div class="col-md-4">
			<div class="widget-box">
				<div class="widget-header"><h4>Status</h4></div>
				<div class="widget-body">
					<?php echo $this->Form->create($q, ['url' => ['controller' => 'QuickSpecs', 'action' => 'admin_view', $q->id]]); ?>
					<?php echo $this->Form->control('status', [
						'type' => 'select',
						'options' => ['new' => 'New', 'seen' => 'Seen', 'done' => 'Done'],
						'label' => false,
						'class' => 'form-control',
					]); ?>
					<?php echo $this->Form->submit(__('Update status'), ['class' => 'btn btn-primary btn-sm', 'style' => 'margin-top:8px;']); ?>
					<?php echo $this->Form->end(); ?>
					<hr>
					<?php echo $this->Form->postLink(
						__('Delete request'),
						['action' => 'admin_delete', $q->id],
						['class' => 'btn btn-danger btn-sm', 'confirm' => __('Delete this request permanently?')]
					); ?>
				</div>
			</div>
		</div>
	</div>
</div>
