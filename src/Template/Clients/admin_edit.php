	
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right"><a href="<?php echo $this->Url->build(['controller' => 'Clients', 'action' => 'admin_index']); ?>" class="btn btn-inverse">Back</a></div>
		<h1>Customer <small><i class="ace-icon fa fa-angle-double-right"></i> Edit Customer</small></h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
		<?php
		$clientData = $clientArr['Client'] ?? $clientArr;
		$clientEntity = is_array($clientData) ? (object)$clientData : $clientData;
		$clientId = $clientEntity->id ?? $clientArr['Client']['id'] ?? $id ?? null;
		echo $this->Form->create($clientEntity, ['class' => 'form-horizontal', 'type' => 'file', 'url' => ['controller' => 'Clients', 'action' => 'admin_edit', $clientId]]);
		$currentCategoryId = $clientEntity->category_id ?? $clientArr['Client']['category_id'] ?? '';
		?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Client Category</label>
				<div class="col-sm-9">
					<select name="data[Client][category_id]" id="category_id" class="col-xs-10 col-sm-5">
						<option value="">Select Category</option>
						<?php
						if (!empty($ClientTypeArr)) {
							foreach ($ClientTypeArr as $ClientTypeArrs) {
								$ct = is_object($ClientTypeArrs) ? $ClientTypeArrs : (object)($ClientTypeArrs['ClientType'] ?? $ClientTypeArrs);
								$ctId = $ct->id ?? $ClientTypeArrs['ClientType']['id'] ?? '';
								$ctName = $ct->name ?? $ClientTypeArrs['ClientType']['name'] ?? '';
								if ($ctId !== '' && $ctName !== '') {
									$selected = ((string)$currentCategoryId === (string)$ctId) ? ' selected' : '';
									echo '<option value="' . h($ctId) . '"' . $selected . '>' . h($ctName) . '</option>';
								}
							}
						}
						?>
					</select>
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Name: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('fname', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'fname', 'placeholder' => 'Name', 'value' => $clientEntity->fname ?? '']); ?>
				</div>
			</div>	
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	Email: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('email', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'email', 'placeholder' => 'Email', 'value' => $clientEntity->email ?? '']); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	Mobile: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('mobile', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'mobile', 'placeholder' => 'Mobile', 'value' => $clientEntity->mobile ?? '']); ?>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	Landline: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('landline', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'landline', 'placeholder' => 'Landline', 'value' => $clientEntity->landline ?? '']); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	Company: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('company', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'company', 'placeholder' => 'Company', 'value' => $clientEntity->company ?? '']); ?>
				</div>
			</div>
			<!--div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	Job Title: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('job_title',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'job_title','placeholder'=>'Job Title'))?>
				</div>
			</div-->
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	Address 1: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('address1', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'address1', 'placeholder' => 'Address 1', 'value' => $clientEntity->address1 ?? '']); ?>
				</div>
			</div>
			<!-- <div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	Address 2: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('address2',array('div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-5','id'=>'address2','placeholder'=>'Address 2'))?>
				</div>
			</div> -->
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	City: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('city', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'city', 'placeholder' => 'City', 'value' => $clientEntity->city ?? '']); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	State: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('state', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'state', 'placeholder' => 'State', 'value' => $clientEntity->state ?? '']); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	zip: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('zip', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'zip', 'placeholder' => 'zip', 'value' => $clientEntity->zip ?? '']); ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">	country: </label>
				<div class="col-sm-9">
					<?php echo $this->Form->control('country', ['div' => false, 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'country', 'placeholder' => 'country', 'value' => $clientEntity->country ?? '']); ?>
				</div>
			</div>
			<div class="form-group">
				<label for="form-field-2" class="col-sm-3 control-label no-padding-right">Status : </label>
				<div class="col-sm-9">
				
				
				<div class="radio"><label>
				<?php $status = (int)($clientEntity->status ?? $clientArr['Client']['status'] ?? 1); ?>
				<input type="radio" value="1" <?php echo $status === 1 ? 'checked' : ''; ?> class="ace" id="CategoryActive1" name="data[Client][status]"><span class="lbl"> Active</span>
				</label></div>
				<div class="radio"><label>
					<input type="radio" value="0" <?php echo $status === 0 ? 'checked' : ''; ?> class="ace" id="CategoryActive0" name="data[Client][status]"><span class="lbl"> Inactive</span>
				</label></div>				
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit', ['div' => false, 'label' => false, 'class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']); ?>&nbsp;
					<?php echo $this->Html->link('Cancel', $this->Url->build(['controller' => 'Clients', 'action' => 'admin_index']), ['class' => 'btn btn-danger']); ?>

				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
<script type="text/javascript">
			jQuery(function(){ //short for $(document).ready(function(){

				$("#fname").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter  name"
                }); $("#lanme").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter last name"
                });  $("#email").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter email"
                }); $("#country").validate({
                     expression: "if (VAL) return true; else return false;",
                    message: "Please enter country"
                });
			});
			</script>
