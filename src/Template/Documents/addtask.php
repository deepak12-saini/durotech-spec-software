<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Add Records
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New
	</small>
	<a href="<?php echo SITEURL; ?>documents" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create('DocumentLibraryRecord',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Document Id: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('documentid',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'documentid','placeholder'=>'Document Id','readonly'=>true,'style'=>'background-color: #ddd !important;','value'=>$docArr['DocumentLibrary']['documentid']))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
					<div class="col-sm-9">
						<table border="1">
							<tr>
								<th>S.no</th>
								<th>Name of the Book</th>
								<th>Qty</th>
								<th>Expected Date of Return</th>
								<th>Remarks</th>
							</tr>
							<?php 
							$k=0;
							for($i=1; $i<10; $i++){
								if($i == 1){
									$isrequired = 'required';
								}else{
									$isrequired = '';
								}

								isset($doclibrecArr[$k]['DocumentLibraryRecord']['nameofthebook']) ? $nameofthebook = $doclibrecArr[$k]['DocumentLibraryRecord']['nameofthebook'] : $nameofthebook = '';
								isset($doclibrecArr[$k]['DocumentLibraryRecord']['qty']) ? $qty = $doclibrecArr[$k]['DocumentLibraryRecord']['qty'] : $qty = '';
								isset($doclibrecArr[$k]['DocumentLibraryRecord']['expecteddateofreturn']) ? $expecteddateofreturn = $doclibrecArr[$k]['DocumentLibraryRecord']['expecteddateofreturn'] : $expecteddateofreturn = '';
								isset($doclibrecArr[$k]['DocumentLibraryRecord']['remarks']) ? $remarks = $doclibrecArr[$k]['DocumentLibraryRecord']['remarks'] : $remarks = '';
							?>
							<tr>
								<td style="text-algin:center;"  ><?php echo $i; ?></td>
								<td> <input type="text" name="nameofthebook[<?php echo $i; ?>]" value="<?php echo $nameofthebook; ?>" <?php echo $isrequired; ?>  /></td>
								<td> <input type="text" name="qty[<?php echo $i; ?>]"  value="<?php echo $qty; ?>" style="margin:5px;" <?php echo $isrequired; ?> /></td>
								<td> <input type="text" class="datepicker" name="expecteddateofreturn[<?php echo $i; ?>]"  value="<?php echo $expecteddateofreturn; ?>" style="margin:5px;" <?php echo $isrequired; ?> /></td>
								<td> <input type="text" name="remarks[<?php echo $i; ?>]" value="<?php echo $remarks; ?>"  style="margin:5px;" <?php echo $isrequired; ?> /></td>
							</tr>
							<?php $k++; } ?>
							
						</table>
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