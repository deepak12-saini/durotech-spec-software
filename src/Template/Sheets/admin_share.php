<link rel="stylesheet" href="<?php echo SITEURL ?>theme/css/bootstrap.css" />
<link rel="stylesheet" href="<?php echo SITEURL ?>theme/css/font-awesome.css" />

<!-- page specific plugin styles -->

<!-- text fonts -->
<link rel="stylesheet" href="<?php echo SITEURL ?>theme/css/ace-fonts.css" />

<!-- ace styles -->
<link rel="stylesheet" href="<?php echo SITEURL ?>theme/css/ace.css" class="ace-main-stylesheet" id="main-ace-style" />
 <link rel="stylesheet" href="<?php echo SITEURL ?>theme/css/css/bootstrap-multiselect.css" type="text/css">
       
<!-- ace settings handler -->
<script src="<?php echo SITEURL ?>theme/js/jquery.js"></script>
<script src="<?php echo SITEURL ?>theme/js/ace-extra.js"></script>
<script src="<?php echo SITEURL ?>theme/js/jquery.validate.js"></script>
<script src="<?php echo SITEURL ?>theme/js/jquery-ui.js"></script>
<div class="row" style="overflow-y: scroll;">
	<div class="col-xs-12">
		<?php 
		// Flash messages are handled automatically in CakePHP 3
		// Remove Session->flash() as it doesn't exist in CakePHP 3
		?>
		<?php echo $this->Form->create(null, ['url' => ['controller' => 'Sheets', 'action' => 'admin_share', $sheet_id], 'type' => 'post']); ?> 
			<div class="form-group">
				<div class="col-xs-6">
					<label for="form-field-1">Invite Collaborators </label><br>	
					<select id="example-getting-started" name="email[]" multiple="multiple">
						<?php
						foreach($NappUser as $NappUsers){
						$name = $NappUsers['NappUser']['name'].' '.$NappUsers['NappUser']['lname'];
						?>
							<option value="<?php echo $NappUsers['NappUser']['id'].'###'.$name; ?>"><?php echo $NappUsers['NappUser']['email']?> (<?php echo $NappUsers['NappUser']['name']?>)</option>
						<?php } ?>	
					</select>
					
				</div>	
				<div class="col-xs-6">
					<label for="form-field-1">Permission </label><br>						
					<select name="permission" class='col-xs-10 col-sm-10' style="height: 33px;">
						<option value="1">Viewer Only</option>
						<option value="2">Edit & Viewer</option>
					</select>
				</div>	
			</div>	
			<div style="clear:both;"></div>
			
			<div class="form-group">	
				<div class="col-xs-6"><h5 style="font-weight:bold;">Invite Details:</h5></div>	
			</div>
			<div style="clear:both;"></div>
			<div class="form-group">
				<div class="col-xs-12">
					<label for="form-field-1">Subject Line</label><br>						
					<?php 
					$subjectValue = isset($SsSheetCategory['SsSheetCategory']['name']) ? h($SsSheetCategory['SsSheetCategory']['name']) . ' - Invitation to Edit' : 'Invitation to Edit';
					echo $this->Form->control('subject', [
						'type' => 'text',
						'class' => 'col-xs-12 col-sm-12',
						'placeholder' => 'Subject',
						'id' => 'shareemail',
						'value' => $subjectValue,
						'label' => false
					]); 
					?>
				</div>
			</div>
		
			<div style="clear:both;"></div>
			<div class="form-group">
				<br>
				<div class="col-xs-12">								
					<?php echo $this->Form->control('message', [
						'type' => 'textarea',
						'style' => 'height:168px;',
						'placeholder' => 'Personal Message (option)',
						'class' => 'col-xs-12 col-sm-12',
						'label' => false
					]); ?>
				</div>
			</div>
			<div style="clear:both;"></div>
			<div class="form-group">
				<br>
				<div class="col-xs-6"></div>	
				<div class="col-xs-6">				
					<?php echo $this->Form->submit('Share Sheet', [
						'class' => 'btn btn-xs btn-primary',
						'style' => 'float:right; margin-left:10px;'
					]); ?> 
				
					<a href="javascript: window.parent.closeIframe()" id="closeIframe" class="btn btn-xs btn-defult" style="float:right;">Cancel</a> 
					
				</div>
			</div>
			
		<?php echo $this->Form->end(); ?>
		<br>
		<h4>Collaborators (<?php echo count($SsSheetShare); ?>)</h4>
		<div class="table-responsive" style="margin-top:13px;">
		
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>Permission</th>				
						<th></th>				
					</tr>	
				</thead>
				<tbody>
					<?php 
						if(!empty($SsSheetShare)){
							foreach($SsSheetShare as $SsSheetShares){
					?>
						<tr>
							<td style="font-size:13px;"><?php echo $SsSheetShares['NappUser']['name'].' '.$SsSheetShares['NappUser']['lname'];  ?></td>
							<td style="font-size:13px;"><?php echo $SsSheetShares['NappUser']['email']; ?></td>
							<td style="font-size:13px;">
							<?php 
								/*
								if($SsSheetShares['SsSheetShare']['permission'] == 1){
									echo 'Viewer Only';
								}else{
									echo 'Edit & Viewer';
								}
								*/
							?>
							<select onchange="changepermission(this.value)" class='col-xs-10 col-sm-10' style="height: 33px;">
								<option <?php if($SsSheetShares['SsSheetShare']['permission'] == 1){ echo 'selected'; } ?> value="<?php echo $SsSheetShares['SsSheetShare']['id'].'_1'; ?>">Viewer Only</option>
								<option <?php if($SsSheetShares['SsSheetShare']['permission'] == 2){ echo 'selected'; } ?> value="<?php echo $SsSheetShares['SsSheetShare']['id'].'_2'; ?>">Edit & Viewer</option>
							</select>
							</td>
							<td style="font-size:13px;">	
								<a href="<?php echo SITEURL.'admin/sheets/deletesheet/'.$SsSheetShares['SsSheetShare']['id'].'/'.$SsSheetShares['SsSheetShare']['sheet_id']; ?>"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php  } }else{ ?>
						<tr>
							<td colspan="4" style="text-align:center;">	
								No Record Found	
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		
	</div>
	</div>	
<script src="<?php echo SITEURL ?>theme/js/bootstrap.js"></script>	
<script src="<?php echo SITEURL ?>theme/js/jquery-ui.custom.js"></script>
<script type="text/javascript" src="<?php echo SITEURL ?>theme/js/bootstrap-multiselect.js"></script>
<script>
	
	function changepermission(argu){
	
		if(argu != ''){
		
			var Actionurl = '<?php echo SITEURL.'admin/sheets/changepermission/' ?>'+argu;
			 $.ajax({
				url:Actionurl,
				type:'POST',
				success:function(result){
					
				}

			});
		}
	}

	// Material Select Initialization
	$(document).ready(function() {		
		$('#example-getting-started').multiselect();			
		
		<?php if($status == 'success'){ ?>
			// Clear multiselect selection so dropdown checkboxes are removed
			$('#example-getting-started').multiselect('deselectAll', false);
			$('#example-getting-started').multiselect('updateButtonText');
			// Then close the iframe
			$("#closeIframe").trigger('click');
		<?php } ?>			
	});
</script>