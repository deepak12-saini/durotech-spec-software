<div class="page-content">
	<div class="page-header">
		<h1>
			Employee Profile
			<small>
				<i class="ace-icon fa fa-angle-double-right"></i>
				Profile Setting
			</small>
		</h1>
	</div><!-- /.page-header -->

	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Form->create('Employee', array('class' => 'form-horizontal')); ?>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right">Name: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('name', array('type' => 'text', 'div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'username', 'placeholder' => 'First Name')); ?>
				</div>
			</div>



			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right">Email: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('email', array('type' => 'email', 'div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'email', 'placeholder' => 'Email')); ?>
				</div>
			</div>

			

			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit', array('div' => false, 'label' => false, 'class' => 'btn btn-success', 'id' => 'add_ser_prd_btn', 'value' => 'Submit')); ?>&nbsp;
					<?php echo $this->Html->link('Cancel', 'javascript:window.history.back();', array('class' => 'btn btn-danger')); ?>
				</div>
			</div>

			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>

<script type="text/javascript">
jQuery(function() {

	$("#name").validate({
		expression: "if (VAL) return true; else return false;",
		message: "Please enter last name"
	});
	$("#email").validate({
		expression: "if (VAL.match(/^[^\\s@]+@[^\\s@]+\\.[^\\s@]+$/)) return true; else return false;",
		message: "Please enter valid email"
	});
	
});
</script>
