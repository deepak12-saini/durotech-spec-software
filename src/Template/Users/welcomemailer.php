<style>
.form-group {
    margin-bottom: 23px;
}
table tr td { }
</style>
<div class="page-content">
	<div class="page-header">
	<h1>
	CPD Presentation Management
	<small>
	<i class="ace-icon fa fa-angle-double-right"></i>
	Send CPD Presentation Mailer
	</small>
	</h1>
	</div><!-- /.page-header -->
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create(null, ['url' => ['action' => 'welcomemailer'], 'type' => 'post']); ?>
          <div class="box">
				<div class="box-header">
					<h3 class="box-title" style="width:100%;">
						<!-- <input type="submit" name="submit" id="formSubmit" value="Save" class="btn btn-primary" style="float:right;"> -->
					</h3>			  			  
				</div>
				
				<div class="box-body">
					<table  class="table table-bordered table-striped">
						<tbody>
							<tr>
								<td>
									
									<br/>							
									<div class="form-group">
										<label for="inputEmail" class="col-sm-4 control-label" style="text-align:right;">First Name: </label>
										<div class="col-sm-6">
										 <input type="text" class="form-control" placeholder="First Name" value="" id="name" name="name" style="width:300px;">	
										</div>
									</div>
									<br>
									<div class="form-group">
										<label for="inputEmail" class="col-sm-4 control-label" style="text-align:right;">Last Name: </label>
										<div class="col-sm-6">
										 <input type="text" class="form-control" placeholder="Last Name" value="" id="lname" name="lname" style="width:300px;">	
										</div>
									</div>
									<br>
									<div class="form-group">
										<label for="inputEmail" class="col-sm-4 control-label" style="text-align:right;">Email: </label>
										<div class="col-sm-6">
										 <input type="email" class="form-control" placeholder="Email" value="" id="email" name="email" style="width:300px;">
										
										</div>
									</div>
									<br>
									<div class="form-group">
										<label for="inputEmail" class="col-sm-4 control-label" style="text-align:right;"> Mobile Number: </label>
										<div class="col-sm-6">
										 <input type="text" class="form-control" placeholder="Mobile Number" value="" id="mobile" name="phone" style="width:300px;">
										
										</div>
									</div>
								
									<br>
									<div class="form-group" style="margin-top:5px;">
										<label for="inputEmail" class="col-sm-4 control-label" style="text-align:right;">&nbsp;</label>
										<div class="col-sm-6">
										 <input type="submit" name="submit"  class="btn btn-mini btn-primary" value="Send" >
										
										</div>
									</div>
								</td>
							</tr>	
						</tbody>				
				  </table>
				</div>
		<?php echo $this->Form->end(); ?>
			
		</div>
	</div>
</div>


	<div class="page-header">
		<h1> CPD Presentation Mailer Logs</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('Name'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>				
					<th><?php echo $this->Paginator->sort('phone'); ?></th>
					
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($CpdMailer as $CpdMailers): ?>
					<tr>
						
						<td><?php echo $k; ?>&nbsp;</td>
						<td><?php echo $CpdMailers['CpdMailer']['name'].' '.$CpdMailers['CpdMailer']['lname']; ?>&nbsp;</td>
						<td><?php echo h($CpdMailers['CpdMailer']['email']); ?>&nbsp;</td>
						<td><?php echo h($CpdMailers['CpdMailer']['phone']); ?>&nbsp;</td>				
						
						<td> <?php echo date('d-M-Y H:i:s',strtotime($CpdMailers['CpdMailer']['created'])); ?></td>
										
					</tr>
					<?php $k++; endforeach; ?>
				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter(array(
'format' => __('showing {{current}} records out of {{count}} entries')));?>	</div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));?></li>
				
				<li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><?php echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));?></li>
				
			</ul>
			</div>
		</div>
	</div>	
</div>
<script type="text/javascript">
jQuery(function(){ 
	$("#name").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter first name"
	});$("#lname").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter last name"
	});$("#email").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter email"
	});jQuery("#email").validate({
		expression: "if (VAL.match(/^[^\\W][a-zA-Z0-9\\_\\-\\.]+([a-zA-Z0-9\\_\\-\\.]+)*\\@[a-zA-Z0-9_]+(\\.[a-zA-Z0-9_]+)*\\.[a-zA-Z]{2,4}$/)) return true; else return false;",
		message: "Please enter a valid Email ID"
	});
});	
	
</script>	