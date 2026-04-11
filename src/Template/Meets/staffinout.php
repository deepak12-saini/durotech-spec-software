	<?php
		
		if(!empty($StaffTime['StaffTime']['start_time'])){
			$start_time = $StaffTime['StaffTime']['start_time'];
			$start = date('Y-m-d H:i:s',strtotime($StaffTime['StaffTime']['created']));
		}else{
			$start_time =  '';
			$start = '';
		}
		
		if(!empty($StaffTime['StaffTime']['end_time'])){
			$end_time = $StaffTime['StaffTime']['end_time'];
		}else{
			$end_time =  '';
		}
		
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
		.formmode{ margin-top: 19%; }
		.outerbody{  height:447px; }
		@media screen and (max-width: 768px) {
			.outerbody{  height:850px; }
		}
	</style>
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ></div>
		<h1>Staff In/Out</h1>
	</div>
	<?php echo $this->Flash->render(); ?>
	<div class="row">
		<div class="col-xs-12">
			<?php
			$referParam = $this->request->getParam('pass.0');
			if ($referParam === null && !empty($referid)) {
				$referParam = $referid;
			}
			$formOpts = ['id' => 'formid', 'type' => 'post'];
			if ($referParam !== null && $referParam !== '') {
				$formOpts['url'] = ['action' => 'staffinout', $referParam];
			}
			echo $this->Form->create(null, $formOpts);
			echo $this->Form->hidden('id', ['value' => $StaffTime['StaffTime']['id'] ?? '']);
			echo $this->Form->hidden('referid', ['value' => $StaffTime['StaffTime']['referid'] ?? '']);
			echo $this->Form->hidden('date', ['value' => date('Y-m-d')]);
			echo $this->Form->hidden('time', ['value' => date('h:i A')]);
			?>
			<div class="outerbody" style="width:100%;border:1px solid #000; border-radius:5px; margin:10px 0%;">
				<div class="col-xs-12" style="margin-top:0px;">
					<div class="col-lg-9 col-xs-12">
						<h4><img src="https://www.durotechindustries.com.au/customdurotech/images/durotech_logo.png" ></h4>
					</div>
					<div class="col-lg-3 col-xs-12">
						<h4 style="text-align:left; margin-top:20px; color:#0684c7;">Staff In/Out</h4>
						<p style="text-align:left;"><span  style="color:#0684c7;">DATE:</span>	<?php echo date('D, F d, Y' ); ?> </p>
						<p style="text-align:left;"><span  style="color:#0684c7;">TIME:</span>	<?php echo date('h:m A'); ?> </p>
						<p style=" text-align:left;"><span  style="color:#0684c7;">REF.:</span>	<?php echo $StaffTime['StaffTime']['referid']; ?></p>
					</div>
					<div class="col-xs-12" style="margin-top:20px;">
					
					<div class="col-xs-12">
						<div class="col-lg-2 col-xs-12 text-lable" style=" color:#0684c7;">Name:</div>
						<div class="col-lg-4 col-xs-12"><input type="text" value="<?php if(isset($StaffTime['StaffTime']['name'])){ echo $StaffTime['StaffTime']['name'] ; } ?>" name="name" id="name"  required placeholder="kal bhinder"></div>
						<div class="col-lg-2 col-xs-12 text-lable" style=" color:#0684c7;">Phone Number:</div>
						<div class="col-lg-4 col-xs-12"><input type="text" value="<?php if(isset($StaffTime['StaffTime']['phone'])){ echo $StaffTime['StaffTime']['phone'] ; } ?>" name="phone" id="phone" placeholder="phone" ></div>
					</div>
					
					
					
					<div class="col-xs-12">						
						<div class="col-lg-2 col-xs-12 text-lable" style=" color:#0684c7;">Time Started:</div>
						
						<div class="col-lg-4 col-xs-12"><input readonly type="text" name="start_time" id="start_time" placeholder="09:00 AM" value="<?php echo $start_time; ?>"></div>
						
						<div class="col-lg-2 col-xs-12 text-lable" style=" color:#0684c7;">Time Finished:</div>
						<div class="col-lg-4 col-xs-12"><input readonly type="text" name="end_time" id="end_time" value="<?php echo $end_time; ?>" placeholder="<?php echo date('h:m A'); ?>" ></div>
					</div>
					
					<div class="col-xs-12" style="margin-top:20px;">	
						<input type="hidden" name="work_status" id="work_status">
						<div class="col-lg-2 col-xs-12 text-lable" style=" color:#0684c7;">Shift:</div>
						<div class="col-lg-4 col-xs-12">
							<?php if(!empty($StaffTime['StaffTime']['start_time'])){  ?>
								<a href="javascript:void()" disabled class="btn btn-mini btn-info">Started</a>
							<?php }else{ ?>
								<a href="javascript:void()"  onclick="action('start')" class="btn btn-mini btn-info">Start</a>
							<?php } ?>
							
							<?php if(!empty($StaffTime['StaffTime']['end_time'])){  ?>							
								<a href="javascript:void()" disabled class="btn btn-mini btn-danger">Finished</a>
							<?php }else if(!empty($StaffTime['StaffTime']['start_time'])){ ?>	
								<a href="javascript:void()"  onclick="action('end')" class="btn btn-mini btn-danger">Finish</a>
							<?php }else{ ?>
								<a href="javascript:void()" disabled onclick="return alert('Please click start button first')" class="btn btn-mini btn-danger">Finish</a>
							<?php } ?>
						</div>
					</div>
					<!--div class="col-xs-12" style="margin-top:20px;" >
						<div class="col-lg-2 col-xs-12  text-lable" style=" color:#0684c7;">Work Finished:</div>
						<div class="col-lg-2 col-xs-12 ">
							<select name="work_status" style="width:100%;">
								<option <?php if(isset($StaffTime['StaffTime']['work_status']) && ($StaffTime['StaffTime']['work_status'] == "Started")){ echo 'selected'; } ?> value="Started">Start</option>
								<option <?php if(isset($StaffTime['StaffTime']['work_status']) && ($StaffTime['StaffTime']['work_status'] == "Finished")){ echo 'selected'; } ?> value="Finished">Finished</option>
							</select>
						</div>						
					</div-->
					
					<div class="col-xs-12" style="margin-top:30px;" >
						<div class="col-lg-2 col-xs-12  text-lable" style=" color:#0684c7;">Job Summary:</div>
						<div class="col-lg-10 col-xs-12 ">
							<textarea name="summary" id="summary" required style="width:100%; height:50px;" ><?php echo $StaffTime['StaffTime']['summary']; ?></textarea>
						</div>						
					</div>
					<?php if(isset($StaffTime['StaffTime']['work_status']) && ($StaffTime['StaffTime']['work_status'] != "Finished")){ ?>
						<!--div class="col-xs-12" style="margin-top:40px;">	
							<div class="col-xs-6">
								 <input type="submit" class="btn btn-success" value="Submit" style="width:100px;">
							</div>
							<div class="col-xs-6">						
							</div>
						</div-->	
					<?php } ?>
					</div>
				</div>
			</div>
		<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
	
	<script>
		function action(arg){		
			if(arg == 'start'){
				var name = $("#name").val();
				var phone = $("#phone").val();
				if(phone != '' && name != ''){
					$.ajax({
					url: "<?php echo SITEURL.'meets/starttime/'.$StaffTime['StaffTime']['id']; ?>/"+name+'/'+phone, 
					success: function(result){
						$("#start_time").val(result);
						window.location.href="<?php echo SITEURL.'meets/staffinout/'.$referid; ?>";
					
					}});
				}else{
					alert('Name and phone number required.');
				}						  
			}else{
				var name = $("#name").val();
				var phone = $("#phone").val();
				var summary = $("#summary").val();
				if(summary != '' && phone != '' && name != ''){
					$("#formid").submit();
				}else{
					alert('Summary is required.');
				} 
			}
		}
		jQuery(function(){ 
			$('.datepicker').datepicker({
				format: 'yyyy-mm-dd',			
			});	
		});	
		function addmore(){
			$("#addmore").append('<div class="col-xs-3 text-lable"><input type="text" name="attendees_present[]" placeholder="Sam"></div>');
		}
		<?php if(isset($StaffTime['StaffTime']['work_status']) && ($StaffTime['StaffTime']['work_status'] != "Finished")){ ?>
			var seconds = 0, minutes = <?php echo $minutes; ?>, hours = <?php echo $hours; ?>,t;
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
			<?php if(!empty($start_time)){ ?>
				$("#end_time").val(timekeeper);
				timer();
			<?php } ?>	
			}
			function timer() {
				t = setTimeout(add, 1000);
			}
			timer();
		<?php } ?>
</script>