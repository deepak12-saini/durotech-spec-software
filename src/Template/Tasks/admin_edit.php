<?php
$task = $task ?? null;
$durolab_type = $durolab_type ?? 'technical';
$alloteddate = $task ? ($task->alloteddate ?? '') : '';
$assigned_date = $task ? ($task->assigned_date ?? '') : '';
$task_completion_date = $task ? ($task->task_completion_date ?? '') : '';
$is_new_old = $task ? (int)($task->is_new_old ?? 1) : 1;
$time_frame = $task ? ($task->time_frame ?? '') : '';
?>
<script src="<?= h(SITEURL ?? '') ?>ckeditor/ckeditor.js"></script>
<div class="page-content">
	<div class="page-header">
		<div class="right_btn pull-right"><a href="javascript:window.history.back();" class="btn btn-inverse">Back</a></div>
		<h1>DuroLab <small><i class="ace-icon fa fa-angle-double-right"></i> Edit Task</small></h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
		<?= $this->Form->create($task, ['class' => 'form-horizontal', 'enctype' => 'multipart/form-data', 'url' => ['action' => 'admin_edit', $task ? (int)$task->id : '']]); ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Title:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('title', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-10', 'id' => 'title', 'placeholder' => 'Task Title']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('description', ['label' => false, 'class' => 'ckeditor col-xs-10 col-sm-5', 'id' => 'description', 'placeholder' => 'Description']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date Alloted on:</label>
				<div class="col-sm-9">
					<input type="text" id="alloteddate" name="alloteddate" class="datepicker col-xs-10 col-sm-5" value="<?= ($alloteddate && $alloteddate !== '0000-00-00') ? h($alloteddate) : '' ?>">
				</div>
			</div>

			<?php if ($durolab_type === 'project_enquiry'): ?>
			<div class="form-group reminder">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> New customer or Existing customer:</label>
				<div class="col-sm-9">
					<label class="block">
						<input type="radio" name="is_new_old" <?= $is_new_old === 1 ? 'checked' : '' ?> value="1" class="ace input-lg"> <span class="lbl bigger-120"> New customer </span>
					</label>
					<label class="block">
						<input type="radio" name="is_new_old" <?= $is_new_old === 0 ? 'checked' : '' ?> value="0" class="ace input-lg"> <span class="lbl bigger-120"> Existing customer</span>
					</label>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Client Name:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('client_name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'client_name', 'placeholder' => 'Client Name']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Client Company Name:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('client_company_name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'client_company_name', 'placeholder' => 'Client Company Name']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Projected Sales figure $:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('projected_sales_figure', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'projected_sales_figure', 'placeholder' => 'Projected Sales figure $']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">What time frame does client need it in?:</label>
				<div class="col-sm-9">
					<select name="time_frame" class="col-xs-10 col-sm-1">
						<option <?= $time_frame === '1 week' ? 'selected' : '' ?> value="1 week">1 Week</option>
						<option <?= $time_frame === '1 month' ? 'selected' : '' ?> value="1 month">1 Month</option>
						<option <?= $time_frame === '6 months' ? 'selected' : '' ?> value="6 months">6 Months</option>
						<option <?= $time_frame === '12 months' ? 'selected' : '' ?> value="12 months">12 Months</option>
					</select>
				</div>
			</div>
			<?php endif; ?>

			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Assigned Date:</label>
				<div class="col-sm-9">
					<input type="text" id="assigned_date" name="assigned_date" class="datepicker col-xs-10 col-sm-5" value="<?= ($assigned_date && $assigned_date !== '0000-00-00') ? h($assigned_date) : '' ?>" placeholder="Task Assign Date">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Deadline:</label>
				<div class="col-sm-9">
					<input type="text" id="task_completion_date" name="task_completion_date" class="datepicker col-xs-10 col-sm-5" value="<?= ($task_completion_date && $task_completion_date !== '0000-00-00') ? h($task_completion_date) : '' ?>" placeholder="Task completion Date">
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
jQuery(function(){
	$('.datepicker').datepicker({ format: 'yyyy-mm-dd' });
	$("#title").validate({ expression: "if (VAL) return true; else return false;", message: "Please enter employe id" });
	$("#assignedto").validate({ expression: "if (VAL) return true; else return false;", message: "Please select employee" });
	$("#assignedby").validate({ expression: "if (VAL) return true; else return false;", message: "Please enter assigned by user" });
});
</script>
