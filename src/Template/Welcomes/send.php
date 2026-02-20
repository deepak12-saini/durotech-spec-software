	<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>Welcome Mailer  <small><i class="ace-icon fa fa-angle-double-right"></i>Send Welcome Mailer</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('Mailer',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Track Number:</label>
				<div class="col-sm-9">
					<input type="text" name="tracknumber" value="<?php echo $refernce; ?>" readonly id="tracknumber" class = "col-xs-10 col-sm-8" style="background:#ddd !important; cursor:pointer;" >
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name:</label>
				<div class="col-sm-9">
					<input type="text" name="name" value="" id="name" class = "col-xs-10 col-sm-8">
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="" id="email"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Message:</label>
				<div class="col-sm-9">
				
					<textarea type="text" name="message" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><p>Hello ###NAME###,</p>

<div>
<div id=":oq">
<div id=":ol">
<div dir="ltr">
<div dir="ltr">
<div dir="ltr">
<div dir="ltr">
<p>I am pleased to have met you in Newcastle earlier this week.</p>

<p>Sorry that it has been awhile to get back to you regarding our initial discussion.&nbsp;</p>

<p>Let me start by saying that we would be very happy to support you in your efforts to establish a wholesale / distribution outlet.</p>

<p>Whilst our discussions revolved around pu&rsquo;s and primers, please note that we manufacture a very comprehensive range of</p>

<p>Products including:</p>

<ul>
	<li>Water based membranes &ndash; Durabit, Azcothane ranges.</li>
	<li>Cementitious 2 pack membranes- Crystoflex and Crystoseal.</li>
	<li>PU membranes &ndash; single and 2 pack</li>
	<li>Aliphatic PU membranes</li>
	<li>Trafficable membranes</li>
	<li>Anti-slip coatings &ndash; over membranes and stand alone.</li>
	<li>Sealers</li>
</ul>

<p>However, confining this proposal to the polyurethane membranes and primers, as we discussed, let me provide you with some indicative prices.</p>

<p>These prices are for pallet lot buys (mixed pallets, within reason, &nbsp;would be acceptable), ex factory and ex GST.</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</textarea>
				</div>
			</div>
		
			
			
			<div class="form-group" id="userArea">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">
					<table>
						<tr>
							<th>Product</th>
							<th>Weight/Size</th>
							<th>Price($)</th>
						</tr>
						<tr>
							<td><input type="text" style="width:225px;" name="product_name[]" value="DuroProof PUM 1k solvent based high performance polyurethane"></td>
							<td><input type="text" style="width:225px;" name="weight[]" value="15 Lt"></td>
							<td><input type="text" style="width:225px;" name="price[]" value="$99.00"></td>
						</tr>
						<tr>
							<td><input type="text" style="width:225px;" name="product_name[]" value="Duroproof ECO Black anti-sag, high viscosity,  rollablepolyurethane membrane"></td>
							<td><input type="text" style="width:225px;" name="weight[]" value="15 Lt"></td>
							<td><input type="text" style="width:225px;" name="price[]" value="$99.00"></td>
						</tr>
					</table>
					<div id="addnew"></div>
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore()"><i class="fa fa-plus"></i> Add More</a>
				</div>
			</div>		
			<div id="newdiv"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="Durotech: Welcome Emailer" id="subject" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Price List:</label>
				<div class="col-sm-9">
					<select name="price_id" class = "col-xs-10 col-sm-8">
						<option value="">Select Price List</option>
						<?php
						if (!empty($LabFile)) {
							foreach ($LabFile as $item) {
								$pid = is_object($item) ? $item->id : ($item['LabFile']['id'] ?? $item['id'] ?? '');
								$plabel = is_object($item) ? $item->label : ($item['LabFile']['label'] ?? $item['label'] ?? '');
								if ($pid !== '' && $pid !== null) {
									echo '<option value="' . h($pid) . '">' . h($plabel) . '</option>';
								}
							}
						}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-mini  btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
				
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
	
<script type="text/javascript">
	function addmore(){
		var numItems = $('.newitem').length;		
		var newdiv = 	numItems + 1;
		
		var addnew ='<table class="newitem"  id="div_'+newdiv+'" ><tr><td><input type="text" style="width:225px;" name="product_name[]" value=""></td><td><input type="text" style="width:225px;" name="weight[]" value=""></td><td><input type="text" style="width:225px;" name="price[]" value=""></td><td><a href="javascript:void(0);" style="color:red;" onclick="remove('+newdiv+')">&nbsp;&nbsp; X </a></td></tr></table>';
		$("#addnew").append(addnew);
	}	
	function remove(id){	
		$("#div_"+id).remove();
	}
	function checkornot(){
		var isChecked = $("#use_area").is(":checked");
		if (isChecked) {
			$("#userArea").show();
		} else {
			$("#userArea").hide();
		}
	}	

	jQuery(function(){ //short for $(document).ready(function(){

		$('.datepicker').datepicker({
			format: "dd/mm/yyyy",			
		});
		$("#tracknumber").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter tracknumber"
		});
		$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		}); $("#name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name/attn"
		});; $("#company").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter company"
		}); $("#subject").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter subject"
		});
	});

</script>