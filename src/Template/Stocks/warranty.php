<style>
	.btn { margin-bottom:2px; }
	input{ border-bottom: 1px dashed #ddd !important;border-left: 0px !important ;border-right !important : 0px;border-top: 0px !important ; margin-bottom:2px;}
</style>
<div class="page-content">
		
		<div class="row">
			<div class="col-lg-8 col-lg-offset-2">
				<p>
				<small style="float:left;">Project Name: <b><?php echo ucfirst($WarrantyRequest['WarrantyRequest']['project_name']); ?></b></small>
				<small style="float:right;">Request Id: <b><?php echo h($WarrantyRequest['WarrantyRequest']['unique_id']); ?></b></small>
				</p><br>
			</div>
				<div class="col-lg-8 col-lg-offset-2" style="border: 2px solid #ddd;">	
					
					<?php if($WarrantyRequest['WarrantyRequest']['status'] > 1){ ?>
					<h4 style="text-align:center;">Thanks you, you have already submit request for warranty certificate.</h4>
					<?php }else{ ?>
					<h4 style="text-align:center;">PRODUCT INSPECTION CERTIFICATE </h4>
					<?php echo $this->Form->create('Mailer',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
					<div class="form-group">
						
						<div class="col-sm-6">						
							<input type="text" name="serialnumber" value="" id="serialnumber" class = "col-xs-12 col-sm-12" placeholder="Warranty Serial No">
						</div>
						<div class="col-sm-6">							
							<input type="text" name="dateofpurchase" value="" id="dateofpurchase" class = "datepicker col-xs-12 col-sm-12" placeholder="Date Of Purchase of Products">
						</div>
					</div>	
					<div class="form-group">
						
						<div class="col-sm-6">						
							<input type="text" name="product" value="" id="product" class = "col-xs-12 col-sm-12" placeholder="Product">
							<br><small>Product (Please specify the amount of the Product used):</small>
						</div>
						<div class="col-sm-6">							
							<input type="text" name="used_as" value="" id="used_as" class = "col-xs-12 col-sm-12" placeholder="Used As">
							<br><small>Used As (Please set out in detail the manner in which the Product was used in relation to 6.) :</small>
						</div>
					</div>	
					<div class="form-group">						
						<div class="col-sm-12">	
							<h5>Application</h5> <small>(Please describe the manner in which the Products were applied, where applicable make reference to Durotech specifications and manuals):ecify the amount of the Product used):</small>
							
							<input type="text" name="application[]" value="" id="application" class = "col-xs-12 col-sm-12" placeholder="Application">
							<input type="text" name="application[]" value="" id="application" class = "col-xs-12 col-sm-12" placeholder="Application">
							<input type="text" name="application[]" value="" id="application" class = "col-xs-12 col-sm-12" placeholder="Application">
							
						</div>
					</div>
					<div class="form-group">
						
						<div class="col-sm-6">						
							<input type="text" name="area_warranted" value="" id="area_warranted" class = "col-xs-12 col-sm-12" placeholder="Area Warranted">
							<br><small>Area Warranted(Please provide specific measurements):</small>
						</div>
						<div class="col-sm-6">							
							<input type="text" name="building_address" value="" id="building_address" class = "col-xs-12 col-sm-12" placeholder="Building Address">
							<br><small>Building Address:</small>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-sm-12">							
							<input type="text" name="building_area_name" value="" id="building_area_name" class = "col-xs-12 col-sm-12" placeholder="Building/Area Name">
							<br><small>Building/Area Name:</small>
						</div>
					</div>					
					<div class="form-group">
						
						<div class="col-sm-6">						
							<input type="text" name="building_name" value="" id="building_name" class = "col-xs-12 col-sm-12" placeholder="Building Name">
							<br><small>Building Name:</small>
						</div>
						<div class="col-sm-6">							
							<input type="text" name="start_requested_warranty" value="<?php echo date('Y-m-d');?>" id="start_requested_warranty" class = "datepicker col-xs-6 col-sm-6" placeholder="Start">
							<input type="text" name="end_requested_warranty" value="<?php echo date('Y-m-d');?>" id="end_requested_warranty" class = "datepicker col-xs-6 col-sm-6" placeholder="End">
							<br><small>Requested Warranty Period:</small>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">							
							<input type="text" name="applicator" value="" id="applicator" class = "col-xs-12 col-sm-12" placeholder="Applicator">
							<br><small>Applicator:</small>
						</div>
						<div class="col-sm-6">							
							<input type="text" name="applicator_contact" value="" id="applicator_contact" class = "col-xs-12 col-sm-12" placeholder="Applicator Contact Details">
							<br><small>Applicator Contact Details:</small>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">							
							<input type="text" name="applicator_active_abn" value="" id="applicator_active_abn" class = "col-xs-12 col-sm-12" placeholder="Applicator’s active ABN">
							<br><small>Applicator’s active ABN:</small>
						</div>
						<div class="col-sm-6">							
							<input type="text" name="applicator_address" value="" id="applicator_address" class = "col-xs-12 col-sm-12" placeholder="Applicator’s Address">
							<br><small>Applicator’s Address:</small>
						</div>
					</div>	
					<div class="form-group">
						<div class="col-sm-12">	<br>
							<p style="font-size:10px;">
							(For reference the process of using the Products listed in point 3 for the purposes set out in point 4, applied in the manner depicted in point 5 for the area described in point 6 in the location set out in points 7 and 8 will be referred to as &lsquo;Durotech Product Application&rsquo;.)<br />
							
							I confirm that I am the Contractor in charge of the building/development/construction of the location stated at point 7 and 8 and I am properly	authorised and in a fully informed position to make these statements.<br />
							
							I certify that the Durotech Product Application was implemented and I confirm that no Durotech representative or employee were present	prior or during the Durotech Product Application process or involved in any aspect of Application noted in point 5.<br />
							
							I understand that Durotech will rely on this certificate in order to issue a report approving the use of Durotech&rsquo;s Products and that the	information on this certificate may be required and relied upon for warranty purposes at a later date. I understand that improper use or				application of Durotech Products may result in their failure which may result in legal action or an award of damages against Durotech. As such,	I further certify and declare that the facts, details and information herein are correct and that the Durotech Product Application has been					conducted in strict accordance with Durotech&rsquo;s specifications and manuals as at the date of purchase of the Product (see point 2).<br />
							
							I understand that Durotech will rely on this certificate in order to issue a report approving the use of Durotech&rsquo;s Products and that the	information on this certificate may be required and relied upon for warranty purposes at a later date. I understand that improper use or application of Durotech Products may result in their failure which may result in legal action or an award of damages against Durotech. As such, I further certify and declare that the facts, details and information herein are correct and that the Durotech Product Application has been conducted in strict accordance with Durotech&rsquo;s specifications and manuals as at the date of purchase of the Product (see point 2).<br />							
							By signing below I acknowledge and confirm that I have read, understood and agreed to what has been stated above and will incur any	liability for and indemnify Durotech against any claim, expense or order for costs arising from any errors in the aforementioned material.</p>

						</div>
					</div>
					<div class="form-group">
						
						<div class="col-sm-4">						
							<input type="text" name="contract_company_name" value="" id="contract_company_name" class = "col-xs-12 col-sm-12" placeholder="Contractors Company name">
							<br><small>Contractors Company name</small>
						</div>
						<div class="col-sm-4">							
							<input type="text" name="sign_date" value="" id="sign_date" class = "datepicker col-xs-12 col-sm-12" placeholder="Date">
							<br><small>Date</small>
						</div>
						<div class="col-sm-4">							
							<input type="text" name="contract_name" value="" id="contract_name" class = "col-xs-12 col-sm-12" placeholder="Contractors full name">
							<br><small>Contractors full name</small>
						</div>
					</div>
					<div class="form-group">						
						<div class="col-sm-12">	
						
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-6">
							<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;						
						</div>
					</div>
					<?php echo $this->Form->end(); ?>		
					<?php } ?>
			</div>		
		</div>	
<script type="text/javascript">
	
	jQuery(function(){ //short for $(document).ready(function(){
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});
		
		$("#product").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter product"
		}); $("#used_as").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter used_as"
		}); $("#subject").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter subject"
		});
	});

</script>
		
	</div>		

