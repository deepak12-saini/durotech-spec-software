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
		
		<?php 
		$sheetId = isset($sheetinfo['SsSheetCategory']['id']) ? $sheetinfo['SsSheetCategory']['id'] : '';
		$columId = isset($SsSheetColumns['SsSheetColumn']['id']) ? $SsSheetColumns['SsSheetColumn']['id'] : null;
		$formUrl = ['controller' => 'Sheets', 'action' => 'admin_column', $sheetId];
		if (!empty($columId)) {
			$formUrl[] = $columId;
		}
		echo $this->Form->create(null, ['url' => $formUrl, 'type' => 'post']); 
		?>
			
			<div class="form-group">
				<div class="col-xs-12">
					<label for="form-field-1">Column Type</label><br>						
					<?php 
					$columnValue = isset($SsSheetColumns['SsSheetColumn']['column']) ? $SsSheetColumns['SsSheetColumn']['column'] : '';
					echo $this->Form->control('column', [
						'type' => 'text',
						'id' => 'column',
						'class' => 'col-xs-12 col-sm-12',
						'placeholder' => 'column title',
						'value' => $columnValue,
						'required' => true,
						'label' => false
					]); 
					?>
				</div>
			</div>
		
			<div style="clear:both;"></div>
			<div class="form-group">
				<br>
				<div class="col-xs-12" >								
					<?php 
					$filedTypeValue = isset($SsSheetColumns['SsSheetColumn']['filed_type']) ? $SsSheetColumns['SsSheetColumn']['filed_type'] : '';
					echo $this->Form->control('filed_type', [
						'type' => 'select',
						'id' => 'filed_type',
						'class' => 'col-xs-12 col-sm-12',
						'options' => [
							'Text' => 'Text',
							'Dropdown' => 'Dropdown (Status)',
							'date' => 'Date',
							'assigned' => 'Assigned',
							'Checkbox' => 'Checkbox',
							'is_reminder' => 'Set Reminder',
							'email' => 'Email',
							'landline' => 'Landline',
							'mobile' => 'Mobile',
							'company' => 'Company',
							'address' => 'Address',
							'name' => 'Name'
						],
						'value' => $filedTypeValue,
						'required' => true,
						'label' => false
					]); 
					?>
				</div>
			</div>
			<div style="clear:both;"></div>
			<div class="form-group">
				<br>
				<div class="col-xs-6"></div>	
				<div class="col-xs-6">				
					<?php echo $this->Form->submit('Submit', [
						'class' => 'btn btn-xs btn-primary',
						'style' => 'float:right; margin-left:10px;'
					]); ?>
				
					<a href="javascript: window.parent.closeIframe()" id="closeIframe" class="btn btn-xs btn-defult" style="float:right;">Cancel</a> 
					
				</div>
			</div>
			
		<?php echo $this->Form->end(); ?>
		<br>
		<h4><?php echo $sheetinfo['SsSheetCategory']['name'];?> (#<?php echo count($SsSheetColumn); ?>)</h4>
		<div class="table-responsive" style="margin-top:13px;">
		
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
					<tr>
						<th>Column</th>
						<th>Type</th>							
						<th>Action</th>				
					</tr>	
				</thead>
				<tbody>
					<?php 
						if(!empty($SsSheetColumn)){
							foreach($SsSheetColumn as $SsSheetColumns){
					?>
						<tr>
							<td style="font-size:13px;"><?php echo $SsSheetColumns['SsSheetColumn']['column'];  ?></td>
							<td style="font-size:13px;">
							<?php
							echo $SsSheetColumns['SsSheetColumn']['filed_type']; 
							if($SsSheetColumns['SsSheetColumn']['filed_type'] == 'Dropdown'){
								echo '<br/>Empty,Quarter,Half,Three Quarter,Full';
							}
							?>
							
							</td>
							<td style="font-size:13px;">	
								<a href="<?php echo SITEURL.'admin/sheets/column/'.$SsSheetColumns['SsSheetColumn']['sheet_id'].'/'.$SsSheetColumns['SsSheetColumn']['id']; ?>"><i class="fa fa-pencil"></i></a>
								<a onclick="return confirm('Are you sure delete this column?')" href="<?php echo SITEURL.'admin/sheets/trash/'.$SsSheetColumns['SsSheetColumn']['sheet_id'].'/'.$SsSheetColumns['SsSheetColumn']['id']; ?>"><i class="fa fa-trash"></i></a>
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
	// Material Select Initialization
	$(document).ready(function() {		
		$('#example-getting-started').multiselect();			
		
		<?php if($status == 'success'){ ?>
			//$(".alert").hide();
			$("#closeIframe").trigger('click');
		<?php } ?>			
	});
</script>