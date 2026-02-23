<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
<div class="page-content">
	<div class="page-header">
	<h1>
	Debt collection
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Add New
	</small>
		<a href="<?php echo $this->Url->build(['controller' => 'DebitCollections', 'action' => 'index']); ?>" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<style>
	.template{ border:1px solid #000; padding:10px; margin:10px 0px; }
	</style>
	<div class="row">
		<div class="col-xs-12">
		
			<?php echo $this->Form->create($entity ?? null, ['class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data', 'url' => ['action' => 'addnew']]); ?>	
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
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Amount Owing(AUD): </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->control('amount', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'id' => 'amount', 'placeholder' => 'Amount']); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Due Date: </label>
					<div class="col-sm-9">
						<?php 
						echo $this->Form->control('due_date', ['type' => 'text', 'label' => false, 'class' => 'datepicker col-xs-10 col-sm-5', 'id' => 'due_date', 'placeholder' => 'Due Date', 'value' => date('Y-m-d')]); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Reminder: </label>
					<div class="col-sm-9">
						<input type="checkbox" name="is_email" value="1"> Email Reminder
						<input type="checkbox" name="is_sms" value="1"> Sms Reminder
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status: </label>
					<div class="col-sm-9">
						<input type="radio" name="status" value="0" checked> Payment Pending
						<input type="radio" name="status" value="1"> Paid
					</div>
				</div>
				<hr>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Template: </label>
					<div class="col-sm-9">
						<input type="checkbox" name="template_1" value="1"> Reminder ahead of the due date
						<input type="checkbox" name="template_2" value="1"> First-overdue-payment-reminder
						<input type="checkbox" name="template_3" value="1"> Reminder-ahead-of-due-date
						<input type="checkbox" name="template_4" value="1"> Extremely-late-invoices
					</div>
				</div>
				
				<div class="template" id="tempate_1" >
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject 1: </label>
						<div class="col-sm-9">
							<input type="text" name="data[DebitCollection][subject_1]" class="col-xs-10 col-sm-5" value="Reminder ahead of the due date">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Send 1: </label>
						<div class="col-sm-9">
							<input type="text" name="data[DebitCollection][date_1]" class="datepicker col-xs-10 col-sm-5" value="<?php echo date('Y-m-d');?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email Template 1:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="data[DebitCollection][message_1]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><p>Dear [client_name],</p>
							<p>I&rsquo;m contacting you on behalf of [your_company] with regard to the following invoice:</p>

							<p>[invoice_ref_number] / [invoice_balance]</p>

							<p>This invoice is due for payment on [invoice_due_date]. It would be greatly appreciated if you could confirm receipt of&nbsp;&nbsp;&nbsp;&nbsp; this invoice and advise as to whether payment has been scheduled.</p>

							<p>I have attached a copy of the invoice for your reference. If you require any further information from our side, please let me know.</p>

							<p>Best wishes,</p>

							<p>[sender_name]</p>
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">SMS Template 1:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="data[DebitCollection][sms_1]" id="descriptionS" class="col-xs-10 col-sm-5" placeholder="Description">dear [client_name],I&rsquo;m contacting you on behalf of [your_company] with regard to the following invoice: [invoice_ref_number] / [invoice_balance]
							</textarea>
						</div>
					</div>
				</div>
				
				<div class="template" id="tempate_2">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject 2: </label>
						<div class="col-sm-9">
							<input type="text" name="data[DebitCollection][subject_2]" class="col-xs-10 col-sm-5" value="First-overdue-payment-reminder">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Send 2: </label>
						<div class="col-sm-9">
							<input type="text" name="data[DebitCollection][date_2]" class="datepicker col-xs-10 col-sm-5" value="<?php echo date('Y-m-d');?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email Template 2:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="data[DebitCollection][message_2]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><p>Dear [client_name],</p>
							<p>I&rsquo;m contacting you on behalf of [your_company] with regard to the following invoice:</p>

							<p>[invoice_ref_number] / [invoice_balance]</p>

							<p>This invoice is due for payment on [invoice_due_date]. It would be greatly appreciated if you could confirm receipt of&nbsp;&nbsp;&nbsp;&nbsp; this invoice and advise as to whether payment has been scheduled.</p>

							<p>I have attached a copy of the invoice for your reference. If you require any further information from our side, please let me know.</p>

							<p>Best wishes,</p>

							<p>[sender_name]</p>
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">SMS Template 2:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="data[DebitCollection][sms_2]" id="descriptionS" class="col-xs-10 col-sm-5" placeholder="Description">dear [client_name],I&rsquo;m contacting you on behalf of [your_company] with regard to the following invoice: [invoice_ref_number] / [invoice_balance]
							</textarea>
						</div>
					</div>
				</div>
				<div class="template" id="tempate_3">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject 3: </label>
						<div class="col-sm-9">
							<input type="text" name="data[DebitCollection][subject_3]" class="col-xs-10 col-sm-5" value="Reminder-ahead-of-due-date">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Send 3: </label>
						<div class="col-sm-9">
							<input type="text" name="data[DebitCollection][date_3]" class="datepicker col-xs-10 col-sm-5" value="<?php echo date('Y-m-d');?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email Template 3:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="data[DebitCollection][message_3]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><p>Dear [client_name],</p>
							<p>I&rsquo;m contacting you on behalf of [your_company] with regard to the following invoice:</p>

							<p>[invoice_ref_number] / [invoice_balance]</p>

							<p>This invoice is due for payment on [invoice_due_date]. It would be greatly appreciated if you could confirm receipt of&nbsp;&nbsp;&nbsp;&nbsp; this invoice and advise as to whether payment has been scheduled.</p>

							<p>I have attached a copy of the invoice for your reference. If you require any further information from our side, please let me know.</p>

							<p>Best wishes,</p>

							<p>[sender_name]</p>
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">SMS Template 3:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="data[DebitCollection][sms_3]" id="descriptionS" class="col-xs-10 col-sm-5" placeholder="Description">dear [client_name],I&rsquo;m contacting you on behalf of [your_company] with regard to the following invoice: [invoice_ref_number] / [invoice_balance]
							</textarea>
						</div>
					</div>
				</div>
				<div class="template" id="tempate_3">
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject 4: </label>
						<div class="col-sm-9">
							<input type="text" name="data[DebitCollection][subject_4]" class="col-xs-10 col-sm-5" value="Extremely-late-invoices">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Send 4: </label>
						<div class="col-sm-9">
							<input type="text" name="data[DebitCollection][date_4]" class="datepicker col-xs-10 col-sm-5" value="<?php echo date('Y-m-d');?>">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email Template 4:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="data[DebitCollection][message_4]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><p>Dear [client_name],</p>
							<p>I&rsquo;m contacting you on behalf of [your_company] with regard to the following invoice:</p>

							<p>[invoice_ref_number] / [invoice_balance]</p>

							<p>This invoice was due on [invoice_due_date] and remains unpaid.</p>
							
							<p>Given the lack of response on your side after several attempts to contact you, we will shortly begin legal proceedings in order to receive the monies owed to [your_company] </p>

							<p>Immediate payment will result in us closing this issue without need for legal action.</p>
							
							<p>I have attached a copy of the invoice for your reference</p>

							<p>Best wishes,</p>

							<p>[sender_name]</p>
							</textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label no-padding-right" for="form-field-1">SMS Template 4:</label>
						<div class="col-sm-9">
						
							<textarea type="text" name="data[DebitCollection][sms_4]" id="descriptionS" class="col-xs-10 col-sm-5" placeholder="Description">dear [client_name],I&rsquo;m contacting you on behalf of [your_company] with regard to the following invoice: [invoice_ref_number] / [invoice_balance]
							</textarea>
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