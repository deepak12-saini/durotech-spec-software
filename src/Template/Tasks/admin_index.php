	<style>
		.btn{ margin-bottom:5px;}
	</style>
	
	<div class="page-content">
		<div class="page-header">
			<h1>DuroLab <?= $this->Html->link('Add New', ['controller' => 'Tasks', 'action' => 'admin_add'], ['class' => 'btn btn-info btn-xs top-button']); ?>
			
			<form action="<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'admin_index']); ?>" method="get" style="float:right;">
				<input type="text" name="keyowrd" value="<?= h($keyword ?? ''); ?>" placeholder="Search By TaskID, title" style="width:174px !important">
				<input type="submit" name="search" value="search" class="btn btn-info btn-xs" style="margin-top:10px">
				<a href="<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'admin_index']); ?>" class="btn btn-warning btn-xs" style="margin-top:10px">Show All</a>
			</form></h1>
		</div>
	<?php if($is_access == 1){ ?>	
	<div class="row">
	
		<div class="col-xs-12">
 
			<?= $this->Form->create(null, ['class' => 'form-horizontal', 'method' => 'post']); ?>
				<?php
				$usernewArr = $usernewArr ?? null;
				$userEmail = $usernewArr ? ($usernewArr->username ?? $usernewArr->email ?? '') : '';
				$userPhone = $usernewArr ? ($usernewArr->phone ?? '') : '';
				if (!empty($userEmail) && !empty($userPhone)) { ?>
					<p><b>For enhanced security of your account, we have sent One-Time Password (OTP) to your mobile number <?= h($userPhone) ?> and email Id <?= h($userEmail) ?></b></p>
				<?php } else { ?>
					<p><b>For enhanced security of your account, we have sent One-Time Password (OTP) to your email Id <?= h($userEmail) ?></b></p>
				<?php } ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Please enter One Time Password (OTP): </label>
					<div class="col-sm-9">
						<?= $this->Form->control('otp', ['type' => 'password', 'class' => 'col-xs-10 col-sm-5 ErrorField', 'placeholder' => 'Fill OTP received on mobile / email', 'label' => false]); ?>
					</div>
				</div>				
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?= $this->Form->button('Verify', ['class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']); ?>
					</div>
				</div>
			<?= $this->Form->end(); ?>
			<p class="alert alert-warning"><b>Please check your mail. Enter one time pssword received on your registered email address.</b> </p>
		</div>		
	</div>
	<?php }else if($is_access == 2){ ?>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>
					<th><?php echo $this->Paginator->sort('task_id','Project Number'); ?></th>
					<th><?php echo $this->Paginator->sort('Assigned By'); ?></th>
					<th><?php echo $this->Paginator->sort('Assigned To'); ?></th>
					
					<th><?php echo $this->Paginator->sort('title','Project Description'); ?></th>
					<th><?php echo $this->Paginator->sort('priority_number'); ?></th>	
					<th><?php echo $this->Paginator->sort('results_summary'); ?></th>	
					<th><?php echo $this->Paginator->sort('alloteddate','Project Started/Assigned/Deadline Date'); ?></th>						
					
					<th><?php echo $this->Paginator->sort('countdown'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
			<!-- 	<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('assignedby'); ?></th>
				<th><?php echo $this->Paginator->sort('task_id','Task id'); ?></th>
				<th><?php echo $this->Paginator->sort('title'); ?></th>
				<th><?php echo $this->Paginator->sort('alloteddate','Alloted/Assigned/Deadline Date'); ?></th>				
				<th><?php echo $this->Paginator->sort('Assigned'); ?></th>
				<th><?php echo $this->Paginator->sort('countdown'); ?></th>
				<th><?php echo $this->Paginator->sort('status'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
				<th class="actions"><?php echo __('Actions'); ?></th>
				</tr> -->
				</thead>
				<tbody>
					<?php $i = 1; foreach ($task as $tasks): ?>
					<tr>
					<td><?= $i; ?>&nbsp;</td>
					<td><a data-toggle="modal" data-target="#myModal_<?= $i; ?>" href="#null"><?= h($tasks->task_id); ?></a>&nbsp;</td>
					<td>
					<?php if ((int)$tasks->admin_id === 0 && $tasks->napp_user) { ?>
						<span class="label label-info"><?= h(($tasks->napp_user->name ?? '') . ' ' . ($tasks->napp_user->lname ?? '')); ?></span>
					<?php } else { ?>
						<span class="label label-success"><?= h($tasks->user->name ?? ''); ?></span>
					<?php } ?>
					</td>
					<td>
						<?php if (!empty($tasks->task_assigns)) {
							foreach ($tasks->task_assigns as $taskAssign) {
								$na = $taskAssign->napp_user ?? null;
								echo '<span class="label label-success">' . h(($na->name ?? '') . ' ' . ($na->lname ?? '')) . '</span><br><br>';
							}
						} ?>
					</td>
					<td><?= h($tasks->title); ?>&nbsp;</td>
					<td><?= h($tasks->priority_number ?? ''); ?>&nbsp;</td>
					<td><?= h($tasks->results_summary ?? ''); ?>&nbsp;</td>
					<td>
					<span class="label label-info">Project Started: <?= ($tasks->alloteddate && $tasks->alloteddate !== '0000-00-00') ? date('d M Y', strtotime($tasks->alloteddate)) : 'N/A'; ?></span> <br/><br/>
					<span class="label label-warning">Assigned Date: <?= ($tasks->assigned_date && $tasks->assigned_date !== '0000-00-00') ? date('d M Y', strtotime($tasks->assigned_date)) : 'N/A'; ?></span> <br/><br/>
					<span class="label label-danger">Deadline Date: <?= (!$tasks->task_completion_date || $tasks->task_completion_date === '0000-00-00') ? 'N/A' : date('d M Y', strtotime($tasks->task_completion_date)); ?></span>
					</td>			
								
								
							
							
					<td>
						<?php if ((int)$tasks->task_status === 3) {
							$assigndatetime = $tasks->assigndatetime ?? null;
							$taskcompletetime = $tasks->taskcompletetime ?? null;
							if ($assigndatetime && $taskcompletetime) {
								$then = new \DateTime($assigndatetime);
								$now = new \DateTime($taskcompletetime);
								$sinceThen = $then->diff($now);
								echo '<span class="label label-danger">' . $sinceThen->d . 'd ' . $sinceThen->h . 'h ' . $sinceThen->i . 'm ' . $sinceThen->s . 's</span>';
							} else {
								echo '<span class="label label-danger">N/A</span>';
							}
						} else { ?>
							<span class="label label-danger" id="demo_<?= $i; ?>">N/A</span>
							<?php if ($tasks->task_completion_date && $tasks->task_completion_date !== '0000-00-00') { ?>
							<script>
							var countDownDate_<?= $i; ?> = new Date("<?= date('M d, Y 10:00:00', strtotime($tasks->task_completion_date)); ?>").getTime();
							var x = setInterval(function() {
								var now = new Date().getTime();
								var distance_<?= $i; ?> = countDownDate_<?= $i; ?> - now;
								var days = Math.floor(distance_<?= $i; ?> / (1000 * 60 * 60 * 24));
								var hours = Math.floor((distance_<?= $i; ?> % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
								var minutes = Math.floor((distance_<?= $i; ?> % (1000 * 60 * 60)) / (1000 * 60));
								var seconds = Math.floor((distance_<?= $i; ?> % (1000 * 60)) / 1000);
								document.getElementById("demo_<?= $i; ?>").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
								if (distance_<?= $i; ?> < 0) {
									document.getElementById("demo_<?= $i; ?>").innerHTML = "EXPIRED";
								}
							}, 1000);
							</script>
							<?php }
						} ?>
					</td>
					<td>
					<?php
					$st = (int)$tasks->task_status;
					if ($st === 0) { ?><span class="label label-primary">Not Assign</span>
					<?php } elseif ($st === 1) { ?><span class="label label-info">Assigned</span>
					<?php } elseif ($st === 2) { ?><span class="label label-warning">Submited</span>
					<?php } elseif ($st === 3) { ?><span class="label label-success">Completed</span>
					<?php } ?>&nbsp;
					</td>
					<td><?= $tasks->created ? date('d-M-Y', strtotime($tasks->created)) : ''; ?></td>
					<td class="actions">
						<?= $this->Html->link(__('Comments'), ['action' => 'admin_comment', $tasks->task_id], ['class' => 'btn btn-mini btn-inverse']); ?>
						<?= $this->Html->link(__('Document'), ['action' => 'admin_taskdocument', $tasks->task_id], ['class' => 'btn btn-mini btn-primary']); ?>
						<?php
						$userId = (int)$this->request->getSession()->read('User.id');
						if ($userId === (int)$tasks->admin_id && (int)$tasks->task_status < 3) { ?>
							<?= $this->Html->link(__('Assign'), ['action' => 'admin_assign', $tasks->id], ['class' => 'btn btn-mini btn-info']); ?>
							<?= $this->Html->link(__('Edit'), ['action' => 'admin_edit', $tasks->id], ['class' => 'btn btn-mini btn-warning']); ?>
							<?= $this->Form->postLink(__('Delete'), ['action' => 'admin_delete', $tasks->id], ['class' => 'btn btn-mini btn-danger', 'confirm' => __('Are you sure you want to delete # %s?', $tasks->id)]); ?>
							<?= $this->Form->postLink(__('Complete'), ['action' => 'admin_completetask', $tasks->task_id, 'completed'], ['class' => 'btn btn-mini btn-success', 'confirm' => __('Mark task # %s as completed?', $tasks->task_id)]); ?>
						<?php } ?>
					</td>
					</tr>
					<?php $i++; endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?= $this->Paginator->counter(['format' => __('showing {{current}} records out of {{count}} entries')]); ?></div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
				<ul class="pagination">
					<li class="paginate_button previous"><?= $this->Paginator->prev('< ' . __('previous'), [], null, ['class' => 'prev disabled']); ?></li>
					<li class="paginate_button next"><?= $this->Paginator->next(__('next') . ' >', [], null, ['class' => 'next disabled']); ?></li>
				</ul>
			</div>
		</div>
	</div>
	<?php } ?>	
	
<?php $j = 1; foreach ($task as $tasknew): ?>
<div id="myModal_<?= $j; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Project Number: <?= h($tasknew->task_id); ?></h4>
		</div>
		<div class="modal-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="simple-table">
						<tbody>
						<tr><th>Project Number: </th><td><span class="label label-inverse"><?= h($tasknew->task_id); ?></span></td></tr>
						<tr><th>Assigned By: </th><td><?php if ((int)$tasknew->admin_id === 0 && $tasknew->napp_user) { ?><span class="label label-info"><?= h(($tasknew->napp_user->name ?? '') . ' ' . ($tasknew->napp_user->lname ?? '')); ?></span><?php } else { ?><span class="label label-success"><?= h($tasknew->user->name ?? ''); ?></span><?php } ?></td></tr>
						<tr><th>Assigned To: </th>
							<td>
								<?php if (!empty($tasknew->task_assigns)) {
									foreach ($tasknew->task_assigns as $TaskAssigns) {
										$na = $TaskAssigns->napp_user ?? null;
										echo '<span class="label label-success">' . h(($na->name ?? '') . ' ' . ($na->lname ?? '')) . '</span><br><br>';
									}
								} ?>
							</td>	
						</tr>	
						<tr>
							<th>Project Description: </th>
							<td><?php echo h($tasknew['Task']['title']); ?>&nbsp;</td>
						</tr>	
						<tr>
							<th>Background: </th>
							<td><?php echo htmlspecialchars_decode($tasknew['Task']['description']); ?>&nbsp;</td>
						</tr>
						
						<tr>
							<th>Priority Number: </th>
							<td><?php echo $tasknew['Task']['priority_number']; ?>nbsp;</td>
						</tr>
						<tr>
							<th>Results Summary: </th>
							<td><?php echo $tasknew['Task']['results_summary']; ?>&nbsp;</td>
						</tr>
						<tr>
							<th>Date Alloted on: </th>
							<td><?php echo $tasknew['Task']['alloteddate']; ?>&nbsp;</td>
						</tr>
						
						<tr>
							<th>Assigned Date: </th>
							<td>
							<?php 
							$assigned_date = $tasknew['Task']['assigned_date'];	
							if($assigned_date != '0000-00-00'){ echo $assigned_date; } 
							?>
							&nbsp;</td>
						</tr>
						
						<tr>
							<th>Deadline: </th>
							<td><?= ($tasknew->task_completion_date && $tasknew->task_completion_date !== '0000-00-00') ? h($tasknew->task_completion_date) : 'N/A'; ?></td>
						</tr>
						<tr>
							<th>Priority number: </th>
							<td><?= h($tasknew->priority_number ?? ''); ?></td>
						</tr>
						<tr>
							<th>Project Started/Assigned/Deadline Date: </th>
							<td>
							<span class="label label-info">Project Started: <?= ($tasknew->alloteddate && $tasknew->alloteddate !== '0000-00-00') ? date('d M Y', strtotime($tasknew->alloteddate)) : 'N/A'; ?></span> <br/><br/>
							<span class="label label-warning">Assigned Date: <?= ($tasknew->assigned_date && $tasknew->assigned_date !== '0000-00-00') ? date('d M Y', strtotime($tasknew->assigned_date)) : 'N/A'; ?></span> <br/><br/>
							<span class="label label-danger">Deadline Date: <?= (!$tasknew->task_completion_date || $tasknew->task_completion_date === '0000-00-00') ? 'N/A' : date('d M Y', strtotime($tasknew->task_completion_date)); ?></span>
							</td>
						</tr>
						<tr>
							<th>Status: </th>
							<td>
								<?php $st = (int)$tasknew->task_status; ?>
								<?php if ($st === 0) { ?><span class="label label-primary">Not Assign</span>
								<?php } elseif ($st === 1) { ?><span class="label label-info">Assigned</span>
								<?php } elseif ($st === 2) { ?><span class="label label-warning">Submited</span>
								<?php } elseif ($st === 3) { ?><span class="label label-success">Completed</span>
								<?php } ?>
							</td>
						</tr>
						<?php
						$durolab_type = $this->request->getSession()->read('durolab_type');
						if ($durolab_type === 'project_enquiry') { ?>
						<tr>
							<th>New customer or Existing customer: </th>
							<td><?= (int)($tasknew->is_new_old ?? 0) === 1 ? 'New customer' : 'Existing customer'; ?></td>
						</tr>
						<tr><th>Client Name: </th><td><?= h($tasknew->client_name ?? ''); ?></td></tr>
						<tr><th>Client Company Name: </th><td><?= h($tasknew->client_company_name ?? ''); ?></td></tr>
						<tr><th>Projected Sales figure $: </th><td><?= h($tasknew->projected_sales_figure ?? ''); ?></td></tr>
						<tr><th>What time frame does client need it in?: </th><td><?= h($tasknew->time_frame ?? ''); ?></td></tr>
						<?php } ?>
						</tbody>
					</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php $j++; endforeach; ?>
</div>		