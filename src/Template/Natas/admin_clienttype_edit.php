	
	<div class="page-content">
		<div class="page-header">
			<div class="right_btn pull-right"><a href="<?php echo $this->Url->build(['controller' => 'Natas', 'action' => 'admin_clienttype']); ?>" class="btn btn-xs btn-inverse">Back</a></div>
			<h1>National Association of Testing Authorities  <small>>> Edit Instrument</small></h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create(null, ['class' => 'form-horizontal', 'type' => 'file', 'url' => ['controller' => 'Natas', 'action' => 'admin_clienttype_edit', $ClientTypeArr[0]['NataCategory']['id'] ?? null]]); ?>
			
			<!-- <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Select Parent:</label>
				<div class="col-sm-9">
					<select name="data[NataCategory][parent_id]" class ='col-xs-10 col-sm-5' >
						<option value="">Select Parent</option>
						<?php if(!empty($natacate)){ foreach($natacate as $natacates){ ?>
							<option <?php if($ClientTypeArr['NataCategory']['parent_id'] == $natacates['NataCategory']['id'])?> value="<?php echo $natacates['NataCategory']['id'];?>"><?php echo $natacates['NataCategory']['name'];?></option>
						<?php } } ?>
					</select>
				</div>
			</div> -->
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Instrument Name:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('NataCategory.name', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'name', 'placeholder' => 'Equipment Name']); ?>&nbsp;
				
				</div>
			</div>	
				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Make Model Type:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('NataCategory.make_model_type', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Make Model Type']); ?>&nbsp;
				
				</div>
			</div> 	
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Update',array('div'=>false,'label'=>false, 'class' => 'btn btn-xs btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
					
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
<script type="text/javascript">
	jQuery(function(){ 
		$("#name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter equipment name"
		});
	});
</script>	
