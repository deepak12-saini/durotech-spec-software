	<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>DuroEzy Specification  <small><i class="ace-icon fa fa-angle-double-right"></i>Send Mail</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('Mailer',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name:</label>
				<div class="col-sm-9">
					<input type="text" name="data[NewPriceListLog][name]" value="" id="name" class = "col-xs-10 col-sm-8" placeholder="Name ">
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="data[NewPriceListLog][email]" value="" id="email"  class = "col-xs-10 col-sm-8" placeholder="EmailId">
				</div>
			</div>
			<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('NewPriceListLog.date',array('type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'date_of_order','placeholder'=>'Date','value'=>date('Y-m-d')))?>
					</div>
				</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="data[NewPriceListLog][subject]" value="DUROTECH: Notice of General Price Increase" id="subject" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Message:</label>
				<div class="col-sm-9">				
					<textarea type="text" style="height:600px;" name="data[NewPriceListLog][message]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description">
					<div style="background-color:transparent">
<div class="m_-7320978404133276049gmail-m_-553783586769048335gmail-m_-2509026342730614974m_751301868293329094m_-1788262690463642867block-grid" style="margin:0px auto;min-width:320px;max-width:600px;background-color:transparent">
<div style="border-collapse:collapse;display:table;width:100%;background-color:transparent">
<div class="m_-7320978404133276049gmail-m_-553783586769048335gmail-m_-2509026342730614974m_751301868293329094m_-1788262690463642867col m_-7320978404133276049gmail-m_-553783586769048335gmail-m_-2509026342730614974m_751301868293329094m_-1788262690463642867num12" style="min-width:320px;max-width:600px;display:table-cell;vertical-align:top">
<div style="background-color:transparent;width:100%">
<div style="border-color:transparent;border-style:dotted;border-width:0px;padding:30px 0px 0px">
<div>
<div style="color:rgb(35,31,32);font-family:Arial,">
<div style="font-size:12px;line-height:14px;color:rgb(35,31,32);font-family:Arial,">
<p style="text-align:center"><span style="font-size:30px"><strong><span style="font-size:30px">New List Price</span></strong></span></p>

<p style="text-align:center"><span style="font-size:18px">Effective 1st <?php echo date('F');?>, <?php echo date('Y');?></span></p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<div style="background-color:transparent">
<div class="m_-7320978404133276049gmail-m_-553783586769048335gmail-m_-2509026342730614974m_751301868293329094m_-1788262690463642867block-grid" style="margin:0px auto;min-width:320px;max-width:600px;background-color:transparent">
<div style="border-collapse:collapse;display:table;width:100%;background-color:transparent">
<div class="m_-7320978404133276049gmail-m_-553783586769048335gmail-m_-2509026342730614974m_751301868293329094m_-1788262690463642867col m_-7320978404133276049gmail-m_-553783586769048335gmail-m_-2509026342730614974m_751301868293329094m_-1788262690463642867num12" style="min-width:320px;max-width:600px;display:table-cell;vertical-align:top">
<div style="background-color:transparent;width:100%">
<div style="border-color:transparent;border-style:solid;border-width:0px;padding:30px 0px">
<div>
<div style="color:rgb(35,31,32);font-family:Arial,">
<div style="line-height:18px;font-size:12px;color:rgb(35,31,32);font-family:Arial,">
<p><span style="font-size:14px">Dear Valued Customer,<span style="font-size:14px">&nbsp;</span><span style="font-size:14px"> </span></span></p>

<p><span style="font-size:14px">Please note that Durotech will be issuing a new price list which will be effective from <?php echo date('F');?> <?php echo date('d');?>, <?php echo date('Y');?>.</span></p>

<p><span style="font-size:14px">Over the last 12 months, the value of the Australian dollar has declined and raw material prices have escalated, some by increases of over 10 percent.</span></p>

<p><span style="font-size:14px">We have endeavoured to improve operational efficiencies and reduce waste to mitigate these increases. Unfortunately, we are unable to absorb the full impact.&nbsp; </span></p>

<p><span style="font-size:14px">Therefore, we wish to communicate a small price increase of 3% with the launch of our new price list. </span></p>

<p><span style="font-size:14px">We have also <u>Updated the Product Range</u> to reflect our current product offering which will extend the breadth of the range. </span></p>

<p><span style="font-size:14px">Durotech wishes to thank you for your support and our team is excited to continue assisting your business for many years to come. </span></p>

<p><span style="font-size:14px">Detailed price lists will be available after the Christmas break, please contact your sales representative with any questions or if you require any further assistance.</span></p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</textarea>
				</div>
			</div>
					
			
			
			
		
			<div id="newdiv"></div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-mini  btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
				
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
	
<script type="text/javascript">
	function setsubject(type_id){
		
		if(type_id == 1){
			$("#subject").val('DUROTECH: INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE');
		}else if(type_id == 2){
			$("#subject").val('Durotech: Waterproofing Specification – Wet area shower');
		}else if(type_id == 3){
			$("#subject").val('Durotech: External Liquid WPM');
		}
	}	
	jQuery(function(){ //short for $(document).ready(function(){
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});
		
		$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		}); $("#name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name"
		}); $("#subject").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter subject"
		});
	});

</script>