<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Circular Management Reviews
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New
	</small>
	<a href="<?php echo SITEURL; ?>organisations/circular" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('Organisation',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Meeting Group: </label>
					<div class="col-sm-9">
						<?php foreach($NappUser as $NappUsers){ ?>
							<input type="checkbox" name="data[emp_id][]" value="<?php echo $NappUsers['NappUser']['id'];?>" > <?php echo $NappUsers['NappUser']['name'].' '.$NappUsers['NappUser']['lname'].' ('.(isset($NappUsers['Department']['department_title']) ? h($NappUsers['Department']['department_title']) : '').')';?> <br>
						<?php  }  ?>
						
					</div>
				</div>			
				<div class="form-group" id="actioned">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'actioned_by_date','placeholder'=>'Actioned By Date','value'=>date('Y-m-d')))?>
					</div>
				</div>
				
				
				<div class="form-group" id="actioned">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Time:<br><small>Our management Reviews meeting is schediled on </small> </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('start_time',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-3','id'=>'start_time','placeholder'=>'Start Time e.g 10:00 am'))?>
						<?php echo $this->Form->input('end_time',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-3','id'=>'end_time','placeholder'=>'End Time  e.g 11:00 am'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">&nbsp;</label>
					<div class="col-sm-9">
						<p>All participants please note and attend the MRM.</p>
						<b>The Agenda of the meeting is as below: </b><br>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Agenda: </label>
					<div class="col-sm-9">
							
							<?php foreach($AgendaArr as $AgendaArrs){ ?>
								<input type="checkbox" name="data[agendId][]" value="<?php echo $AgendaArrs['Agenda']['title'];?>" > <?php echo $AgendaArrs['Agenda']['title'];?> <br>
						<?php  }  ?>			
					</div>
				</div>
				<div class="form-group" >
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Other Agenda: </label>
					<div class="col-sm-9">
						<textarea name="data[Organisation][extra]" placeholder='Other Agenda' class='col-xs-10 col-sm-2' style="width:80%"></textarea>
						
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
	function change(type){
		if(type == 2){
			$("#actioned").hide();
		}else{
			$("#actioned").show();
		}
	}
	jQuery(function(){ 
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});
		
		$("#dept_id").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please select department"
		});$("#non_conforance").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter non Conformance"
		});$("#customer_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter customer name"
		});$("#customer_email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter customer email"
		});$("#product_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter product name"
		});$("#product_color").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter product color"
		}); $("#reason_for_complaint").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter reason for complaint "
		});  $("#batch_number").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter batch number"
		});   
	});
</script>