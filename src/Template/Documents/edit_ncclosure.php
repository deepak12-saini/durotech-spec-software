<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Format For NC and NC Closure
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New
	</small>
	<a href="<?php echo SITEURL; ?>documents" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('DocumentNcClosure.',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data')); ?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">DocumentId: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentNcClosure.documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Document Id','readonly'=>true,'style'=>'background-color: #ddd !important;'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('DocumentNcClosure.date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'actioned_by_date','placeholder'=>'Date','readonly'=>true,'style'=>'background-color: #ddd !important;'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<label class="col-sm-3" for="form-field-1"><b>Format For NC and NC Closure</b></label>					
				</div>
				<div class="closureform"><br/>	
					<?php if(!empty($DocumentNcClosureArr['DocumentNcClosureRecord'])){ $i=0; foreach($DocumentNcClosureArr['DocumentNcClosureRecord'] as $record){ ?>
					<div style="border:1px solid #000; margin:10px 0px;" class="divnew" id="div_<?php echo $i; ?>">	
					<?php if($i > 0){ ?>
						<a href="#null" onclick="del(<?php echo $i; ?>)" style="float:right;margin-top: -19px; background: red;width: 19px;text-align: center;border-radius: 19px;color: #fff;height: 19px;margin-right: -15px;">X</a>	
					<?php } ?>
					<br/>					
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">NC: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][nc][]" value="<?php echo $record['nc']; ?>" class="col-xs-10 col-sm-5" placeholder="NC">							
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Source of NC: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][source_nc][]"  value="<?php echo $record['source_nc']; ?>" class="col-xs-10 col-sm-5" placeholder="Source of NC">
								
							</div>
						</div>					
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Responsibilty: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][responsiblity][]"  value="<?php echo $record['responsiblity']; ?>" class="col-xs-10 col-sm-5" placeholder="Responsibilty">
								
							</div>
						</div>					
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Root Cause: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][root_cause][]"  value="<?php echo $record['root_cause']; ?>" class="col-xs-10 col-sm-5" placeholder="Root Cause">							
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Action: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][action][]"  value="<?php echo $record['action']; ?>" class="col-xs-10 col-sm-5" placeholder="Action">
								
							</div>
						</div>					
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Resource: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][resource][]"  value="<?php echo $record['resource']; ?>" class="col-xs-10 col-sm-5" placeholder="Resource">								
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Time: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][time][]"  value="<?php echo $record['time']; ?>" class="col-xs-10 col-sm-5" placeholder="Time">								
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Closure: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][closure][]"  value="<?php echo $record['closure']; ?>" class="col-xs-10 col-sm-5" placeholder="Closure">							
							</div>
						</div>					
					</div>
					<?php  $i++; } }else{ ?>
						<div style="border:1px solid #000; margin:10px 0px;" class="divnew">					
						<br/>					
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">NC: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][nc][]" value="" class="col-xs-10 col-sm-5" placeholder="NC">							
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Source of NC: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][source_nc][]"  value="" class="col-xs-10 col-sm-5" placeholder="Source of NC">
								
							</div>
						</div>					
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Responsibilty: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][responsiblity][]"  value="" class="col-xs-10 col-sm-5" placeholder="Responsibilty">
								
							</div>
						</div>					
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Root Cause: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][root_cause][]"  value="" class="col-xs-10 col-sm-5" placeholder="Root Cause">							
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Action: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][action][]"  value="" class="col-xs-10 col-sm-5" placeholder="Action">
								
							</div>
						</div>					
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Resource: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][resource][]"  value="" class="col-xs-10 col-sm-5" placeholder="Resource">								
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Time: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][time][]"  value="" class="col-xs-10 col-sm-5" placeholder="Time">								
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Closure: </label>
							<div class="col-sm-9">
								<input type="text" name="data[DocumentNcClosureRecord][closure][]"  value="" class="col-xs-10 col-sm-5" placeholder="Closure">							
							</div>
						</div>					
					</div>
					<?php } ?>
				</div>
				<a href="javascript:void(0);" onclick="addMore()" class='btn btn-mini btn-warning'>Add More</a>	
				<br>
				<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-mini btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
					<?php echo $this->Html->link('Cancel','javascript:window.history.back();',array('class' => 'btn btn-mini btn-danger'));?>

				</div>
				</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>
<script type="text/javascript">

	function del(n){
		$("#div_"+n).remove();	
	}
	
	function addMore(){
		var n = $(".divnew").length + 1;
		var html  = '<div style="border:1px solid #000; margin:20px 0px;" class="divnew" id="div_'+n+'"><a href="#null" onclick="del('+n+')" style="float:right;margin-top: -19px; background: red;width: 19px;text-align: center;border-radius: 19px;color: #fff;height: 19px;margin-right: -15px;">X</a><br/><div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-1">NC: </label><div class="col-sm-9"><input type="text" name="data[DocumentNcClosureRecord][nc][]" class="col-xs-10 col-sm-5" placeholder="NC"></div></div><div class="form-group">		<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Source of NC: </label><div class="col-sm-9"><input type="text" name="data[DocumentNcClosureRecord][source_nc][]" class="col-xs-10 col-sm-5" placeholder="Source of NC"></div></div><div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-1">Responsibilty: </label><div class="col-sm-9"><input type="text" name="data[DocumentNcClosureRecord][responsiblity][]" class="col-xs-10 col-sm-5" placeholder="Responsibilty"></div></div><div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-1">Root Cause: </label><div class="col-sm-9"><input type="text" name="data[DocumentNcClosureRecord][root_cause][]" class="col-xs-10 col-sm-5" placeholder="Root Cause"></div></div><div class="form-group">		<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Action: </label><div class="col-sm-9"><input type="text" name="data[DocumentNcClosureRecord][action][]" class="col-xs-10 col-sm-5" placeholder="Action"></div></div><div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-1">Resource: </label>		<div class="col-sm-9"><input type="text" name="data[DocumentNcClosureRecord][resource][]" class="col-xs-10 col-sm-5" placeholder="Resource"></div></div><div class="form-group">		<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Time: </label><div class="col-sm-9"><input type="text" name="data[DocumentNcClosureRecord][time][]" class="col-xs-10 col-sm-5" placeholder="Time"></div></div><div class="form-group"><label class="col-sm-3 control-label no-padding-right" for="form-field-1">Closure: </label>	<div class="col-sm-9"><input type="text" name="data[DocumentNcClosureRecord][closure][]" class="col-xs-10 col-sm-5" placeholder="Closure"></div></div></div>';
		$(".closureform").append(html);	
	}
	
	jQuery(function(){ 
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});
		
		$("#documentid").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter document id"
		});$("#desigaration").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter designation"
		});$("#department").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter  department"
		});$("#name_of_indentor").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name of indentor"
		});$("#auditor").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter auditor"
		});$("#auditee").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter auditee"
		}); 
	});
</script>