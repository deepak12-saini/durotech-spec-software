	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>Batches Made <small><i class="ace-icon fa fa-angle-double-right"></i> Edit </small>
		</h1>
	</div>	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('BatchRegister',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Batch Number:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('batch_no',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'batch_no','placeholder'=>'Batch Number'))?>
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date','placeholder'=>'Date'))?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product Name:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('product',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'product_name','placeholder'=>'Product Name'))?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Apearance:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('apearance',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'apearance','placeholder'=>'Apearance'))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Viscosity:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('viscosity',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'viscosity','placeholder'=>'viscosity'))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">T<sup>o</sup>C:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('t_degree_c',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'t_degree_c','placeholder'=>'T Degree c'))?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">S.G:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('s_g',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'s_g','placeholder'=>'S.G'))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Check Test:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('check_test',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'check_test','placeholder'=>'Check Test'))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Test By:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('test_by',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'test_by','placeholder'=>'Test By'))?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Comments:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('comments',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'comments','placeholder'=>'Comments'))?>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
					<?php echo $this->Html->link('Cancel','javascript:window.history.back();',array('class' => 'btn btn-danger'));?>

				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
<script type="text/javascript">
jQuery(function(){ //short for $(document).ready(function(){
	$('.datepicker').datepicker({
		format: "yyyy-mm-dd",
	});	
	$("#product_name").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter product name"
	});$("#batch_no").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter batch no."
	}); $("#apearance").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter apearance"
	}); $("#viscosity").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter viscosity"
	}); $("#check_test").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter check test"
	});$("#test_by").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter test by"
	});
});
</script>
