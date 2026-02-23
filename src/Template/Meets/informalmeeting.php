	<?php
		$start = $this->request->getSession()->read('start');		
		$end = date('Y-m-d H:i:s');
		$diff = abs(strtotime($end) - strtotime($start));
				
		$years = floor($diff / (365*60*60*24));  
		$months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));  
		$days = floor(($diff - $years * 365*60*60*24 -   $months*30*60*60*24)/ (60*60*24)); 
		$hours = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24) / (60*60));
		$minutes = floor(($diff - $years * 365*60*60*24  - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
		
	?>
	<style>
		input{ border-bottom: 1px dashed #ddd !important;border-left: 0px !important ;border-right: 0px !important ;border-top: 0px !important ; width: 100%; }
		.text-lable{ margin-top:10px;}
		.th_1{ background:#0684c7; color:#fff;  text-align:center;}
		.th_2{ background:#82c1e2; color:#fff; text-align:center; }
	</style>
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ></div>
		<h1>Informal Meeting Minutes Template <a href="<?php echo $this->Url->build(['controller' => 'Meets', 'action' => 'meetingform']); ?>" class="btn btn-xs btn-primary" style="float:right;">Back</a></h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<?php echo $this->Form->create(null, ['url' => ['action' => 'informalmeeting'], 'type' => 'post', 'id' => 'informal-meeting-form']); ?>
			<input type="hidden" name="referid" value="<?php echo h($refernce ?? ''); ?>">
			<input type="hidden" name="date" value="<?php echo date('Y-m-d'); ?>">
			<input type="hidden" name="time" value="<?php echo date('h:i A'); ?>">
			<div style="width:100%; height:1300px;; border:1px solid #000; border-radius:5px; margin:10px 0%;">
				<div class="col-xs-12" style="margin-top:20px;">
					<div class="col-xs-9">
						<h4><img src="https://www.durotechindustries.com.au/customdurotech/images/durotech_logo.png" ></h4>
					</div>
					<div class="col-xs-3">
						<h4 style="text-align:left; margin-top:20px; color:#0684c7;">FORMAL MEETING MINUTES</h4>
						<p style="text-align:left;"><span  style="color:#0684c7;">DATE:</span>	<?php echo date('D, F d, Y' ); ?> </p>
						<p style="text-align:left;"><span  style="color:#0684c7;">TIME:</span>	<?php echo date('h:m A'); ?> </p>
						<p style=" text-align:left;"><span  style="color:#0684c7;">LOCATION:</span>	<?php echo $refernce; ?></p>
					</div>
					<div class="col-xs-12" style="margin-top:20px;">
					
					<div class="col-xs-12">
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">MEETING CREATED BY:</div>
						<div class="col-xs-4"><input type="text" name="meeting_created_by" required placeholder="kal bhinder"></div>
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">TIME TAKEN:</div>
						<div class="col-xs-4"><input type="text" name="minute_taker" id="minute_taker" placeholder="<?php echo date('h:m A'); ?>" ></div>
					</div>
				 
					<div class="col-xs-12" style="margin-top:20px;">
						<!--div class="col-xs-2 text-lable" style=" color:#0684c7;">FACILITATOR:</div>
						<div class="col-xs-4"><input type="text" name="facilitator" placeholder="New Client Relations Manual"></div-->
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">TIME KEEPER(Meeting Start):</div>
						<div class="col-xs-4"><input type="text" name="time_keeper" id="time_keeper" placeholder="<?php echo date('h:m A'); ?>" ></div>
					</div>

					<div class="col-xs-12" style="margin-top:40px;">
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">MEETTING TOPIC:</div>
						<div class="col-xs-10"><input type="text" name="please_read" placeholder="MEETTING TOPIC" onkeyup="putcontent(this.value)"></div>						
					</div>
					<!--div class="col-xs-12" style="margin-top:40px;">
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">PLEASE BRING:</div>
						<div class="col-xs-4"><input type="text" name="please_bring" placeholder="Laptop and Reports"></div>						
					</div-->
					
					<div class="col-xs-12" style="margin-top:40px;">
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">ATTENDEES PRESENT:</div>										
					</div>
					<div class="col-xs-12" style="margin-top:40px;">
						<div class="col-xs-3 text-lable"><input type="text" name="attendees_present[]" placeholder="Sam"></div>						
						<div class="col-xs-3 text-lable"><input type="text" name="attendees_present[]" placeholder="Sam"></div>						
						<div class="col-xs-3 text-lable"><input type="text" name="attendees_present[]" placeholder="Sam"></div>						
						<div class="col-xs-3 text-lable"><input type="text" name="attendees_present[]" placeholder="Sam"></div>
						<div id="addmore"></div>	

						
					</div>
					
					<a href="javascript:void();" onclick="addmore()" class="btn btn-xs btn-success" style="margin-left:20px;margin-top:40px;">Add More</a>	
					
					<div class="col-xs-12" style="margin-top:80px;text-align:center; color:#0684c7; font-weight:bold;">MINUTES</div>
						<div class="col-xs-12" style="margin-top:10px; text-align:center; background:#0684c7;">
							<input type="text" id="agenda_topic" name="agenda_topic" placeholder="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[Agenda Topic Here]" style="width:300px;  background:#0684c7; color:#fff;">
						</div>
						<table style="width:100%;">
							<tr>
								<th class="th_2">TIME ALLOCATED</th>
								<td><input type="text" name="time_allocate" placeholder="5 min"></td>
								<th  class="th_2">PRESENTED BY</th>
								<td><input type="text" name="presented_by" placeholder="Anna James"></td>
							</tr>
							<tr>
								<th  class="th_1">DISCUSSION</th>
								<td colspan="3"><input type="text" name="discussion"  placeholder="Remarks"></td>								
							</tr>
							<tr>
								<th class="th_2" >CONCLUSION</th>
								<td colspan="3"><input type="text" name="conclusion"  placeholder="Remarks"></td>								
							</tr>
						</table>
						<table style="width:100%;">
							<tr>
								<th class="th_1" style="height:37px;">ACTION</th>
								<th class="th_1" style="height:37px;" >ACTION TO BE TAKEN BY</th>
								<th class="th_1" style="height:37px;">DATE TO BE ACTIONED BY</th>								
							</tr>
							<tr>					
								<td style="border-right:1px solid #ddd;"><input type="text" name="action[]"></td>								
								<td style="border-right:1px solid #ddd;"><input type="text" name="action_to_be_taken_by[]"></td>
								<td style="border-right:1px solid #ddd;"><input type="text" class="datepicker"  name="date_to_be_actioned_by"></td>								
							</tr>
							<tr>					
								<td style="border-right:1px solid #ddd;"><input type="text" name="action[]"></td>								
								<td style="border-right:1px solid #ddd;"><input type="text" name="action_to_be_taken_by[]"></td>
								<td style="border-right:1px solid #ddd;"><input type="text"class="datepicker"  name="date_to_be_actioned_by"></td>								
							</tr>
							<tr>					
								<td style="border-right:1px solid #ddd;"><input type="text" name="action[]"></td>								
								<td style="border-right:1px solid #ddd;"><input type="text" name="action_to_be_taken_by[]"></td>
								<td style="border-right:1px solid #ddd;"><input type="text" class="datepicker" name="date_to_be_actioned_by[]"></td>								
							</tr>
						</table>
						<div class="col-xs-12" style="margin-top:40px;">
							<div class="col-xs-1 text-lable" style=" color:#0684c7;">Notes:</div>
							<div class="col-xs-11"><input type="text" name="note" placeholder="Notes"></div>						
						</div>
						<div class="col-xs-12" style="margin-top:40px;">	
							<div class="col-xs-6">
								<h4 style="text-align:right; color:#0684c7;">SECRETARY APPROVAL: </h4>						
							</div>
							<div class="col-xs-6">
								<h4 style=""><span style="width:200px; text-decoration:underline; color:#0684c7;"><input type="text" name="signature" placeholder="signature"></span></h4>						
							</div>
						</div>	
						
						<div class="col-xs-12" style="margin-top:40px;">	
							<div class="col-xs-6">
								 <input type="submit" class="btn btn-success" value="Submit" style="width:100px;">					
							</div>
							<div class="col-xs-6">
 							
							</div>
						</div>	
					</div>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
	<script>
		function putcontent(arg){
			$("#agenda_topic").val(arg);
		}
		jQuery(function(){ 
			$('.datepicker').datepicker({
				format: 'yyyy-mm-dd',			
			});	
		});	
		function addmore(){
			$("#addmore").append('<div class="col-xs-3 text-lable"><input type="text" name="attendees_present[]" placeholder="Sam"></div>');
		}

		var 
			seconds = 0, minutes = <?php echo $minutes; ?>, hours = <?php echo $hours; ?>,
			t;

		function add() {
			seconds++;
			if (seconds >= 60) {
				seconds = 0;
				minutes++;
				if (minutes >= 60) {
					minutes = 0;
					hours++;
				}
			}
			
		var timekeeper = (hours ? (hours > 9 ? hours : "0" + hours) : "00") + ":" + (minutes ? (minutes > 9 ? minutes : "0" + minutes) : "00") + ":" + (seconds > 9 ? seconds : "0" + seconds);
		$("#minute_taker").val(timekeeper);
			timer();
		}
		function timer() {
			t = setTimeout(add, 1000);
		}
		timer();
		
		var  k_seconds = 0, k_minutes = <?php echo date('i'); ?>, k_hours = <?php echo date('h'); ?>,t;

		function k_add() {
			k_seconds++;
			if (k_seconds >= 60) {
				k_seconds = 0;
				k_minutes++;
				if (k_minutes >= 60) {
					k_minutes = 0;
					k_hours++;
				}
			}
			
		var k_timekeeper = (k_hours ? (k_hours > 9 ? k_hours : "0" + k_hours) : "00") + ":" + (k_minutes ? (k_minutes > 9 ? k_minutes : "0" + k_minutes) : "00") + ":" + (k_seconds > 9 ? k_seconds : "0" + k_seconds);
		$("#time_keeper").val(k_timekeeper);
			k_timer();
		}
		function k_timer() {
			t = setTimeout(k_add, 1000);
		}
		k_timer();

</script>