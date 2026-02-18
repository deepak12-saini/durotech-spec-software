	
	<div class="page-content">
		<div class="page-header">
			<div class="right_btn pull-right"><a href="<?php echo $this->Url->build(['controller' => 'Sales', 'action' => 'admin_index']); ?>" class="btn btn-inverse">Back</a></div>
			<h1>DuroTeam <small><i class="ace-icon fa fa-angle-double-right"></i> Set Sales Reminder</small></h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php
		$sr = is_object($SaleReminder) ? $SaleReminder : (object)($SaleReminder['SaleReminder'] ?? []);
		$srData = is_array($SaleReminder) ? ($SaleReminder['SaleReminder'] ?? []) : ($SaleReminder->toArray() ?? []);
		$firstReminder = $srData['first_reminder'] ?? '';
		$fTime = $srData['f_time'] ?? '';
		$secondReminder = $srData['second_reminder'] ?? '';
		$sTime = $srData['s_time'] ?? '';
		$thirdReminder = $srData['third_reminder'] ?? '';
		$tTime = $srData['t_time'] ?? '';
		echo $this->Form->create(null, ['class' => 'form-horizontal', 'type' => 'file', 'url' => ['controller' => 'Sales', 'action' => 'admin_salereminder']]);
		?>
					
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> First Reminder:<br><small>Set Reminder for notification</small> </label>
				<div class="col-sm-9">
					<label class="block">
						<textarea name="first_reminder" placeholder="First Reminder" style="width:300px"><?php echo h($firstReminder); ?></textarea>
						
						<p>Send at 
						<select name="f_time">						
							<option value="06" <?php echo $fTime == '06' ? 'selected' : ''; ?>>06 am</option>
							<option value="07" <?php echo $fTime == '07' ? 'selected' : ''; ?>>07 am</option>
							<option value="08" <?php echo $fTime == '08' ? 'selected' : ''; ?>>08 am</option>
							<option value="12" <?php echo $fTime == '12' ? 'selected' : ''; ?>>12 pm</option>
							<option value="13" <?php echo $fTime == '13' ? 'selected' : ''; ?>>01 pm</option>
							<option value="14" <?php echo $fTime == '14' ? 'selected' : ''; ?>>02 pm</option>
							<option value="17" <?php echo $fTime == '17' ? 'selected' : ''; ?>>05 pm</option>
							<option value="18" <?php echo $fTime == '18' ? 'selected' : ''; ?>>06 pm</option>
							<option value="19" <?php echo $fTime == '19' ? 'selected' : ''; ?>>07 pm</option>
						</select>
						</p>
					</label>
				</div>
			</div>	 		
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Second Reminder:<br><small>Set Reminder for notification</small> </label>
				<div class="col-sm-9">
					<label class="block">
						<textarea name="second_reminder" placeholder="Second Reminder" style="width:300px"><?php echo h($secondReminder); ?></textarea>
						
						<p>Send at 
						<select name="s_time">						
							<option value="06" <?php echo $sTime == '06' ? 'selected' : ''; ?>>06 am</option>
							<option value="07" <?php echo $sTime == '07' ? 'selected' : ''; ?>>07 am</option>
							<option value="08" <?php echo $sTime == '08' ? 'selected' : ''; ?>>08 am</option>
							<option value="12" <?php echo $sTime == '12' ? 'selected' : ''; ?>>12 pm</option>
							<option value="13" <?php echo $sTime == '13' ? 'selected' : ''; ?>>01 pm</option>
							<option value="14" <?php echo $sTime == '14' ? 'selected' : ''; ?>>02 pm</option>
							<option value="17" <?php echo $sTime == '17' ? 'selected' : ''; ?>>05 pm</option>
							<option value="18" <?php echo $sTime == '18' ? 'selected' : ''; ?>>06 pm</option>
							<option value="19" <?php echo $sTime == '19' ? 'selected' : ''; ?>>07 pm</option>
						</select>
						</p>
					</label>
				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Third Reminder:<br><small>Set Reminder for notification</small> </label>
				<div class="col-sm-9">
					<label class="block">
						<textarea name="third_reminder" placeholder="Third Reminder" style="width:300px"><?php echo h($thirdReminder); ?></textarea>
						
						<p>Send at 
						<select name="t_time">						
							<option value="06" <?php echo $tTime == '06' ? 'selected' : ''; ?>>06 am</option>
							<option value="07" <?php echo $tTime == '07' ? 'selected' : ''; ?>>07 am</option>
							<option value="08" <?php echo $tTime == '08' ? 'selected' : ''; ?>>08 am</option>
							<option value="12" <?php echo $tTime == '12' ? 'selected' : ''; ?>>12 pm</option>
							<option value="13" <?php echo $tTime == '13' ? 'selected' : ''; ?>>01 pm</option>
							<option value="14" <?php echo $tTime == '14' ? 'selected' : ''; ?>>02 pm</option>
							<option value="17" <?php echo $tTime == '17' ? 'selected' : ''; ?>>05 pm</option>
							<option value="18" <?php echo $tTime == '18' ? 'selected' : ''; ?>>06 pm</option>
							<option value="19" <?php echo $tTime == '19' ? 'selected' : ''; ?>>07 pm</option>
						</select>
						</p>
					</label>
				</div>
			</div>	
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit', ['div' => false, 'label' => false, 'class' => 'btn btn-success', 'id' => 'add_ser_prd_btn']); ?>&nbsp;
					<?php echo $this->Html->link('Cancel', $this->Url->build(['controller' => 'Sales', 'action' => 'admin_index']), ['class' => 'btn btn-danger']); ?>

				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
<script type="text/javascript">

	function checkremider(type){
		 var is_both = document.getElementById("is_both");
		if(type ==1){
			$("#is_both").prop('checked', false);
		}else{
			if (is_both.checked) {
				$("#is_email").prop('checked', false);
				$("#is_sms").prop('checked', false);
			}	
		}	
	}	
    function Check() {
		
        var chkPassport = document.getElementById("is_reminder");
        if (chkPassport.checked) {
            $(".reminder").show();
        } else {
             $(".reminder").hide();
        }
    }
</script>	
<script type="text/javascript">
jQuery(function(){ 
	
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',	
		 minDate: 0	
	});
	
	$("#title").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter  employe id"
	}); $("#assignedto").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select employee"
	}); $("#assignedby").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please eneter assigned by user"
	}); 
	
	
});
</script>
