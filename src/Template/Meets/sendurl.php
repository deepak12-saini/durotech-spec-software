
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>Staff In/Out List<small><i class="ace-icon fa fa-angle-double-right"></i>Send URL</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('SiteVisit',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="" id="email" class = "col-xs-10 col-sm-8" placeholder="Enter Email">
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Phone:<br><small>If you enter mobile number staff member get sms. Country code is required.</small></label>
				<div class="col-sm-9">
					<input type="text" name="phone" value="" id="phone" class = "col-xs-10 col-sm-8"  placeholder="61265689412">
				</div>
			</div>
			<div id="newdiv"></div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Send Now',array('div'=>false,'label'=>false, 'class' => 'btn btn-mini  btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
				
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
		
		$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		}); 
	});

</script>