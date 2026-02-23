
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><?= $this->Html->link('Back', 'javascript:void(0)', ['class' => 'btn btn-inverse', 'onclick' => 'window.history.back();']) ?></div>
		<h1>Site Visit<small><i class="ace-icon fa fa-angle-double-right"></i>Send Mail</small></h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?= $this->Form->create(null, ['url' => ['action' => 'send'], 'class' => 'form-horizontal', 'type' => 'post']) ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Email:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('email', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-8', 'id' => 'email']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Company Name:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('company_name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-8', 'id' => 'company_name']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer Name:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('customer_name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-8', 'id' => 'customer_name']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Project Name:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('project_name', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-8', 'id' => 'project_name']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Sale Rep:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('sale_reps', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-8', 'id' => 'sale_reps']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('date', ['type' => 'text', 'label' => false, 'value' => date('Y-m-d'), 'class' => 'col-xs-10 col-sm-8 datepicker']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product Name:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('userarea', ['type' => 'text', 'label' => false, 'class' => 'col-xs-10 col-sm-8', 'id' => 'userarea']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('subject', ['type' => 'text', 'label' => false, 'value' => 'DUROTECH : Site Visit', 'class' => 'col-xs-10 col-sm-8', 'id' => 'subject']) ?>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Send By:</label>
				<div class="col-sm-9">
					<?= $this->Form->control('send_from', ['type' => 'text', 'label' => false, 'value' => 'kal@durotechindustries.com.au', 'class' => 'col-xs-10 col-sm-8', 'id' => 'send_from']) ?>
				</div>
			</div>
			<div id="newdiv"></div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?= $this->Form->submit('Send Email To User', ['class' => 'btn btn-mini btn-success', 'id' => 'add_ser_prd_btn']) ?>
				</div>
			</div>
			<?= $this->Form->end() ?>
		</div>
	</div>	
	</div>	
	
<script type="text/javascript">
	
	jQuery(function(){ //short for $(document).ready(function(){
		$('.datepicker').datepicker({
			format: "yyyy-mm-dd",			
		});
		
		$("#userarea").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter userarea"
		});$("#company_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter company name"
		});$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		}); $("#customer_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter customer name"
		});$("#project_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter project name"
		}); $("#subject").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter subject"
		});
	});

</script>