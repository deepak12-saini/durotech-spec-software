	<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
	
	<?php
		$email = '';
		$company = '';
		$name = '';
		$address = '';
		if(!empty($SheetTaskArr)){
			foreach($SheetTaskArr as $SheetTaskArrs){
				if(isset($SheetTaskArrs['SsSheetColumn']['filed_type']) && ($SheetTaskArrs['SsSheetColumn']['filed_type'] == 'email')){
					$email = $SheetTaskArrs['SheetTask']['value'];
				}
				if(isset($SheetTaskArrs['SsSheetColumn']['filed_type']) && ($SheetTaskArrs['SsSheetColumn']['filed_type'] == 'company')){
					$company = $SheetTaskArrs['SheetTask']['value'];
				}
				if(isset($SheetTaskArrs['SsSheetColumn']['filed_type']) && ($SheetTaskArrs['SsSheetColumn']['filed_type'] == 'address')){
					$address = $SheetTaskArrs['SheetTask']['value'];
				}
				if(isset($SheetTaskArrs['SsSheetColumn']['filed_type']) && ($SheetTaskArrs['SsSheetColumn']['filed_type'] == 'name')){
					$name = $SheetTaskArrs['SheetTask']['value'];
				}
			}
		}	
	?>
	
	<div class="page-content">
		<div class="page-header">			
			<h1><small> Comments - Add New Commments</small>
			<a href="<?php echo SITEURL.'admin/sheets/sendtoclient/'.$argu ?>" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
			</h1>
		</div>
	
	<div>
		<div class="col-xs-12">	
			<div class="row">
				<div class="col-xs-12" style="border-bottom: 1px solid #e2e2e2 !important;border-left: 1px solid #e2e2e2 !important;	border-right: 1px solid #e2e2e2 !important;">
				<?php echo $this->Form->create('Sheet',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
					
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email: <br/> <small></small></label>
						<div class="col-sm-9">
							<input type="text" required name="data[email]" class="col-xs-10 col-sm-5" placeholder="Enter Email Id" value="<?php echo $email; ?>">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject: <br/> <small></small></label>
						<div class="col-sm-9">
							<input type="text" required name="data[subject]" class="col-xs-10 col-sm-5" placeholder="Write Subject">
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Comments: <br/> <small></small></label>
						<div class="col-sm-9">
							<textarea required name="data[comment]" class="col-xs-10 col-sm-5" placeholder="Write your comments here"></textarea>
						</div>
					</div>	
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status: <br/> <small>If you send notification related to order.</small></label>
						<div class="col-sm-9">
							<select name="status" >
								<option value="">Select Order Status</option>
								<option value="Booked">Booked</option>
								<option value="Picked Up">Picked Up</option>
								<option value="Deleiverd">Deleiverd</option>
							</select>
						</div>
					</div>	
					<!--div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Upload Document: </label>
						<div class="col-sm-9">
							<input type="file" name="documents" class="col-xs-10 col-sm-5" />
						</div>
					</div-->
				
					<div class="form-group">
						<div class="col-md-offset-3 col-md-9">
							<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-xs btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
							<?php echo $this->Html->link('Cancel','javascript:window.history.back();',array('class' => 'btn btn-xs btn-danger'));?>

						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>	
		
		</div>
		
	</div>	
</div>	
<script type="text/javascript">
jQuery(function(){ 

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',			
	});
	
	$("#title").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter  employe id"
	}); $("#assignedto").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select employee"
	}); $("#assignedby").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please eneter assigned by user"
	}); 
	
	
});
</script>
