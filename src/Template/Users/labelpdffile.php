<?php
$lab = [];
if (is_array($LabFile ?? null) && isset($LabFile['LabFile'])) {
	$lab = (array)$LabFile['LabFile'];
} elseif (is_object($LabFile ?? null)) {
	$lab = $LabFile->toArray();
} elseif (is_array($LabFile ?? null)) {
	$lab = $LabFile;
}
?>
<div class="page-content">
	<div class="page-header">
	<h1>
	<?php echo h($lab['label'] ?? ''); ?> Price PDF

	<a href="<?php echo SITEURL.'users/labfile'?>" class="btn btn-xs btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	
	<?php if($is_access == 0){ ?>
	<div class="row">
		<div class="col-xs-12">
			
			<form action="" method="post" >
				<div class="box">
					<div class="box-header">				  
					</div>					
					<div class="box-body">
						<?php if(!empty($lab['filename'])){ ?>
							<iframe src="<?php echo h(SITEURL . ($lab['dir'] ?? '') . '/' . ($lab['filename'] ?? '')); ?>" style="width:100%; height:530px; border:none;" allowTransparency="true" scrolling="no" frameborder="0"  allow-top-navigation="no"></iframe>
						<?php }else{ ?>
							<h3> Sorry, you don't have access to this folder. You can request the admin to give you access. <a href="<?php echo SITEURL.'users/access/1'; ?>">Click here</a></h3>
						<?php }?>
					</div>
				</div>
			</form>
		</div>		
	</div>
	<?php }else{ ?>
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create(null, ['class' => 'form-horizontal', 'id' => 'labelpdffile-otp-form']); ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="otp"> One Time Password (OTP): </label>
					<div class="col-sm-9">
						<?php echo $this->Form->control('otp', [
							'type' => 'password',
							'label' => false,
							'class' => 'col-xs-10 col-sm-5 ErrorField',
							'id' => 'otp',
							'placeholder' => 'One Time Password (OTP)',
							'autocomplete' => 'one-time-code',
						]); ?>
					</div>
				</div>				
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->submit('Submit', ['class' => 'btn btn-success', 'id' => 'add_ser_prd_btn', 'div' => false]); ?>&nbsp;
					</div>
				</div>
			<?php echo $this->Form->end(); ?>
			<p class="alert alert-warning"><b>Please check your mail. Enter one time pssword received on your registered email address.</b> </p>
		</div>		
	</div>
	<?php } ?>
</div>	

<script type="text/javascript">
	jQuery(function(){ 
		$("#otp").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter otp"
		});
	});
</script>	
	