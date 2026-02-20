	<?php
	// Support both CakePHP 3 entity and CakePHP 2 array
	$isEntity = is_object($WelcomeArr);
	$wTrack = $isEntity ? ($WelcomeArr->tracknumber ?? '') : ($WelcomeArr['Welcome']['tracknumber'] ?? '');
	$wName = $isEntity ? ($WelcomeArr->name ?? '') : ($WelcomeArr['Welcome']['name'] ?? '');
	$wEmail = $isEntity ? ($WelcomeArr->email ?? '') : ($WelcomeArr['Welcome']['email'] ?? '');
	$wMessage = $isEntity ? ($WelcomeArr->message ?? '') : ($WelcomeArr['Welcome']['message'] ?? '');
	$wSubject = $isEntity ? ($WelcomeArr->subject ?? '') : ($WelcomeArr['Welcome']['subject'] ?? '');
	$wPriceId = $isEntity ? ($WelcomeArr->price_id ?? '') : ($WelcomeArr['Welcome']['price_id'] ?? '');
	$welcomeProducts = $isEntity ? ($WelcomeArr->welcome_products ?? []) : ($WelcomeArr['WelcomeProduct'] ?? []);
	?>
	<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>Welcome Mailer  <small><i class="ace-icon fa fa-angle-double-right"></i>Send Welcome Mailer</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('Mailer', array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data')); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Track Number:</label>
				<div class="col-sm-9">
					<input type="text" name="tracknumber" value="<?php echo h($wTrack); ?>" readonly id="tracknumber" class="col-xs-10 col-sm-8" style="background:#ddd !important; cursor:pointer;">
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name:</label>
				<div class="col-sm-9">
					<input type="text" name="name" value="<?php echo h($wName); ?>" id="name" class="col-xs-10 col-sm-8">
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="<?php echo h($wEmail); ?>" id="email" class="col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Message:</label>
				<div class="col-sm-9">
					<textarea type="text" name="message" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><?php echo h($wMessage); ?></textarea>
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
					</table>	
					<?php
					$i = 1;
					if (!empty($welcomeProducts)) {
						foreach ($welcomeProducts as $wp) {
							$pn = is_object($wp) ? ($wp->product_name ?? '') : ($wp['product_name'] ?? '');
							$wt = is_object($wp) ? ($wp->weight ?? '') : ($wp['weight'] ?? '');
							$pr = is_object($wp) ? ($wp->price ?? '') : ($wp['price'] ?? '');
					?>
					<table class="newitem" id="div_<?php echo $i; ?>">	
						<tr>
							<td><input type="text" style="width:225px;" name="product_name[]" value="<?php echo h($pn); ?>"></td>
							<td><input type="text" style="width:225px;" name="weight[]" value="<?php echo h($wt); ?>"></td>
							<td><input type="text" style="width:225px;" name="price[]" value="<?php echo h($pr); ?>"></td>
							<td><a href="javascript:void(0);" style="color:red;" onclick="remove('<?php echo $i; ?>')">&nbsp;&nbsp; X </a></td>
						</tr>
					</table>
					<?php $i++; } } ?>
					<div id="addnew"></div>
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore()"><i class="fa fa-plus"></i> Add More</a>
				</div>
			</div>		
			<div id="newdiv"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="<?php echo h($wSubject); ?>" id="subject" class="col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Price List:</label>
				<div class="col-sm-9">
					<select name="price_id" class="col-xs-10 col-sm-8">
						<option value="">Select Price List</option>
						<?php
						$currentPriceId = $wPriceId;
						if (!empty($LabFile)) {
							foreach ($LabFile as $item) {
								$pid = is_object($item) ? $item->id : ($item['LabFile']['id'] ?? $item['id'] ?? '');
								$plabel = is_object($item) ? $item->label : ($item['LabFile']['label'] ?? $item['label'] ?? '');
								if ($pid !== '' && $pid !== null) {
									$sel = ($currentPriceId != '' && (string)$currentPriceId === (string)$pid) ? ' selected="selected"' : '';
									echo '<option value="' . h($pid) . '"' . $sel . '>' . h($plabel) . '</option>';
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