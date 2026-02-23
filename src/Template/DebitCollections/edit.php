<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Debt collection
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Edit
	</small>
		<a href="<?php echo $this->Url->build(['controller' => 'DebitCollections', 'action' => 'index']); ?>" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		
			<?php
			$editEntity = $entity ?? null;
			echo $this->Form->create($editEntity, ['class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data', 'url' => ['action' => 'edit', $editEntity ? $editEntity->id : null]]);
			echo $this->Form->control('id', ['type' => 'hidden']);
			$dc = $DebitCollection['DebitCollection'] ?? [];
			?>	
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Invoice Id: </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->control('invoice_id', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'invoice_id', 'placeholder' => 'Invoice Id']); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name: </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->control('name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'name', 'placeholder' => 'Name']); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Phone Number: </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->control('number', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'number', 'placeholder' => 'Phone Number']); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email: </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->control('email', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'email', 'placeholder' => 'Email']); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Amount owing: </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->control('amount', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'amount', 'placeholder' => 'Amount']); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Due Date: </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->control('due_date', ['type' => 'text', 'label' => false, 'class' => 'datepicker col-xs-10 col-sm-5', 'id' => 'due_date', 'placeholder' => 'Due Date', 'value' => $dc['due_date'] ?? date('Y-m-d')]); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Reminder: </label>
					<div class="col-sm-9">
						<input type="checkbox" name="is_email" value="1" <?php if (($dc['is_email'] ?? 0) == 1) { echo 'checked'; } ?>> Email Reminder
						<input type="checkbox" name="is_sms" value="1" <?php if (($dc['is_sms'] ?? 0) == 1) { echo 'checked'; } ?>> Sms Reminder
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status: </label>
					<div class="col-sm-9">
						<input type="radio" name="status" value="0" <?php if (($dc['status'] ?? 0) == 0) { echo 'checked'; } ?>> Payment Pending
						<input type="radio" name="status" value="1" <?php if (($dc['status'] ?? 1) == 1) { echo 'checked'; } ?>> Paid
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Template: </label>
					<div class="col-sm-9">
						<input type="checkbox" name="template_1" value="1" <?php if (($dc['template_1'] ?? 0) == 1) { echo 'checked'; } ?>> Reminder ahead of the due date
						<input type="checkbox" name="template_2" value="1" <?php if (($dc['template_2'] ?? 0) == 1) { echo 'checked'; } ?>> First-overdue-payment-reminder
						<input type="checkbox" name="template_3" value="1" <?php if (($dc['template_3'] ?? 0) == 1) { echo 'checked'; } ?>> Reminder-ahead-of-due-date
						<input type="checkbox" name="template_4" value="1" <?php if (($dc['template_4'] ?? 0) == 1) { echo 'checked'; } ?>> Extremely-late-invoices
					</div>
				</div>
				
				<div class="template" id="tempate_1" >
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject 1: </label>
						<div class="col-sm-9">
							<input type="text" name="DebitCollection[subject_1]" class="col-xs-10 col-sm-5" value="<?php echo h($dc['subject_1'] ?? ''); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Send 1: </label>
						<div class="col-sm-9">
							<input type="text" name="DebitCollection[date_1]" class="datepicker col-xs-10 col-sm-5" value="<?php echo h($dc['date_1'] ?? ''); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email Template 1:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="DebitCollection[message_1]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><?php echo h($dc['message_1'] ?? ''); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">SMS Template 1:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="DebitCollection[sms_1]" id="descriptionS" class="col-xs-10 col-sm-5" placeholder="Description"><?php echo h($dc['sms_1'] ?? ''); ?></textarea>
						</div>
					</div>
				</div>
				
				<div class="template" id="tempate_2">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject 2: </label>
						<div class="col-sm-9">
							<input type="text" name="DebitCollection[subject_2]" class="col-xs-10 col-sm-5" value="<?php echo h($dc['subject_2'] ?? ''); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Send 2: </label>
						<div class="col-sm-9">
							<input type="text" name="DebitCollection[date_2]" class="datepicker col-xs-10 col-sm-5" value="<?php echo h($dc['date_2'] ?? ''); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email Template 2:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="DebitCollection[message_2]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><?php echo h($dc['message_2'] ?? ''); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">SMS Template 2:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="DebitCollection[sms_2]" id="descriptionS" class="col-xs-10 col-sm-5" placeholder="Description"><?php echo h($dc['sms_2'] ?? ''); ?></textarea>
						</div>
					</div>
				</div>
				<div class="template" id="tempate_3">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject 3: </label>
						<div class="col-sm-9">
							<input type="text" name="DebitCollection[subject_3]" class="col-xs-10 col-sm-5" value="<?php echo h($dc['subject_3'] ?? ''); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Send 3: </label>
						<div class="col-sm-9">
							<input type="text" name="DebitCollection[date_3]" class="datepicker col-xs-10 col-sm-5" value="<?php echo h($dc['date_3'] ?? ''); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email Template 3:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="DebitCollection[message_3]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><?php echo h($dc['message_3'] ?? ''); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">SMS Template 3:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="DebitCollection[sms_3]" id="descriptionS" class="col-xs-10 col-sm-5" placeholder="Description"><?php echo h($dc['sms_3'] ?? ''); ?></textarea>
						</div>
					</div>
				</div>
				<div class="template" id="tempate_3">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject 4: </label>
						<div class="col-sm-9">
							<input type="text" name="DebitCollection[subject_4]" class="col-xs-10 col-sm-5" value="<?php echo h($dc['subject_4'] ?? ''); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Send 4: </label>
						<div class="col-sm-9">
							<input type="text" name="DebitCollection[date_4]" class="datepicker col-xs-10 col-sm-5" value="<?php echo h($dc['date_4'] ?? ''); ?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email Template 4:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="DebitCollection[message_4]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><?php echo h($dc['message_4'] ?? ''); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">SMS Template 4:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="DebitCollection[sms_4]" id="descriptionS" class="col-xs-10 col-sm-5" placeholder="Description"><?php echo h($dc['sms_4'] ?? ''); ?></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit', ['class' => 'btn btn-xs btn-success', 'id' => 'add_ser_prd_btn']); ?>&nbsp;
					<?php echo $this->Html->link('Cancel', 'javascript:window.history.back();', ['class' => 'btn btn-xs btn-danger']); ?>

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
		$("#name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name"
		});$("#number").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter number"
		});$("#amount").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter amount"
		});$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		});
	});
</script>