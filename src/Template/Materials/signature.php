	 <script src="<?php echo SITEURL ?>signature_pad-master/signature_pad-master/js/signature_pad.js"></script>
	  <style>
            #signature{
                width: 300px; height: 100px;
                border: 1px solid black;
            }
    </style>
	<?php
		$sign = $this->request->getSession()->read('Customer.sign');
	?>
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>Signature  <small><i class="ace-icon fa fa-angle-double-right"></i> Save your Signature</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create(null, ['class' => 'form-horizontal', 'type' => 'file', 'id' => 'materialorder', 'url' => ['controller' => 'Materials', 'action' => 'signature']]); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Signature: </label>
				<div class="col-sm-9">
					<div id="signature" >
						<canvas id="signature-pad" class="signature-pad" width="300px" height="200px"></canvas>					
						
					</div>
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">					
					<input type="hidden" name="sigimage" id='output' >   				
				</div>
			</div>	
			<?php if(!empty($sign)){ ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Previous Image: </label>
					<div class="col-sm-9">					
						<img src="<?php echo SITEURL.'signature/'.$sign; ?>">				
					</div>
				</div>		
			<?php } ?>	
					
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<a href='#null' id='click' class="btn btn-xs btn-success" >Save Your Signature</a>					
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
<script>
$(document).ready(function() {
	var signaturePad = new SignaturePad(document.getElementById('signature-pad'));
	$('#click').click(function(){
		var data = signaturePad.toDataURL('image/png');
		$('#output').val(data);
		var r = confirm("Are you sure save signature?");
		if (r == true) {
			$("#materialorder").submit();
		} else {
			window.location.href = '<?php echo SITEURL.'materials/signature' ?>';
		} 
		//$("#sign_prev").show();
		//$("#sign_prev").attr("src",data);                   
	});
});
</script>