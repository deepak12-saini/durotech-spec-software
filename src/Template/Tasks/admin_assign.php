<?php
$empId = [];
if (!empty($TaskAssign) && !empty($TaskAssign->task_assigns)) {
	foreach ($TaskAssign->task_assigns as $a) {
		$empId[] = $a->emp_id;
	}
}
$task = $TaskAssign ?? null;
$assigned_date = $task ? $task->assigned_date : null;
$task_completion_date = $task ? $task->task_completion_date : null;
$is_reminder = $task ? (int)$task->is_reminder : 0;
$is_email = $task ? (int)$task->is_email : 0;
$is_sms = $task ? (int)$task->is_sms : 0;
$is_both = $task ? (int)$task->is_both : 0;
$period = $task ? ($task->period ?? '') : '';
$send_to = $task ? (int)$task->send_to : 0;
$employeArr = $employeArr ?? [];
?>
<div class="page-content">
	<div class="page-header">
		<div class="right_btn pull-right"><a href="javascript:window.history.back();" class="btn btn-inverse">Back</a></div>
		<h1>DuroLab <small><i class="ace-icon fa fa-angle-double-right"></i> Assign Task</small></h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
		<?= $this->Form->create(null, ['class' => 'form-horizontal']); ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Assigned Date:</label>
				<div class="col-sm-9">
					<input type="text" id="assigned_date" name="assigned_date" class="datepicker col-xs-10 col-sm-5" value="<?= ($assigned_date && $assigned_date !== '0000-00-00') ? h($assigned_date) : '' ?>" placeholder="Task Assign Date">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Deadline Date:</label>
				<div class="col-sm-9">
					<input type="text" id="task_completion_date" name="task_completion_date" class="datepicker col-xs-10 col-sm-5" value="<?= ($task_completion_date && $task_completion_date !== '0000-00-00') ? h($task_completion_date) : '' ?>" placeholder="Task completion Date">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Send Task Notifcation:<br><small>If you checked this checkbox email notification send to Assigned staff member</small></label>
				<div class="col-sm-9">
					<label class="block">
						<input type="checkbox" name="is_send" class="ace input-lg" value="1"> <span class="lbl bigger-120"></span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Employee:<br><small>Assign Task to Employee</small></label>
				<div class="col-sm-9">
					<?php foreach ($employeArr as $employe): ?>
					<label class="block">
						<input class="ace input-lg" <?= in_array((int)$employe->id, $empId) ? 'checked' : '' ?> value="<?= (int)$employe->id ?>" name="employe_id[]" type="checkbox">
						<span class="lbl bigger-120"><?= h(($employe->name ?? '') . ' ' . ($employe->lname ?? '')) ?></span>
					</label>
					<div style="clear:both;"></div>
					<?php endforeach; ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Is Reminder:<br><small>Set Reminder for notification</small></label>
				<div class="col-sm-9">
					<label class="block">
						<input type="checkbox" name="is_reminder" id="is_reminder" <?= $is_reminder === 1 ? 'checked' : '' ?> class="ace input-lg" value="1" onclick="Check()"> <span class="lbl bigger-120"></span>
					</label>
				</div>
			</div>

			<div class="form-group reminder" <?= $is_reminder === 0 ? 'style="display:none;"' : '' ?>>
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Reminder Type:</label>
				<div class="col-sm-9">
					<label class="block">
						<input type="checkbox" name="is_email" id="is_email" <?= $is_email === 1 ? 'checked' : '' ?> onclick="checkremider(1)" value="1" class="ace input-lg"> <span class="lbl bigger-120"> Email</span>
					</label>
					<label class="block">
						<input type="checkbox" name="is_sms" id="is_sms" <?= $is_sms === 1 ? 'checked' : '' ?> onclick="checkremider(1)" value="1" class="ace input-lg"> <span class="lbl bigger-120"> SMS</span>
					</label>
					<label class="block">
						<input type="checkbox" name="is_both" id="is_both" <?= $is_both === 1 ? 'checked' : '' ?> onclick="checkremider(2)" value="1" class="ace input-lg"> <span class="lbl bigger-120"> Both</span>
					</label>
				</div>
			</div>

			<div class="form-group reminder" <?= $is_reminder === 0 ? 'style="display:none;"' : '' ?>>
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Period:</label>
				<div class="col-sm-9">
					<select name="period">
						<option <?= $period === '30 min' ? 'selected' : '' ?> value="30 min">Every 30 Min</option>
						<option <?= $period === 'hour' ? 'selected' : '' ?> value="hour">Every 1 Hour</option>
						<option <?= $period === 'day' ? 'selected' : '' ?> value="day">Every Day</option>
						<option <?= $period === 'week' ? 'selected' : '' ?> value="week">Weekly</option>
					</select>
				</div>
			</div>
			<div class="form-group reminder" <?= $is_reminder === 0 ? 'style="display:none;"' : '' ?>>
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Notifcation Time:</label>
				<div class="col-sm-9">
					<select name="send_to">
						<option <?= $send_to === 1 ? 'selected' : '' ?> value="1">Office Work Hour</option>
						<option <?= $send_to === 2 ? 'selected' : '' ?> value="2">24 Hour</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?= $this->Form->button('Submit', ['class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']); ?>
					<?= $this->Html->link('Cancel', 'javascript:window.history.back();', ['class' => 'btn btn-danger']); ?>
				</div>
			</div>
		<?= $this->Form->end(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">
function checkremider(type) {
	if (type == 1) {
		$("#is_both").prop('checked', false);
	} else {
		if (document.getElementById("is_both").checked) {
			$("#is_email").prop('checked', false);
			$("#is_sms").prop('checked', false);
		}
	}
}
function Check() {
	var chkPassport = document.getElementById("is_reminder");
	if (chkPassport.checked) {
		$(".reminder").show();
	} else {
		$(".reminder").hide();
	}
}
jQuery(function(){
	$('.datepicker').datepicker({ format: 'yyyy-mm-dd', minDate: 0 });
});
</script>
