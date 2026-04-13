	
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
				
			<div style="width:100%; height:1300px;; border:1px solid #000; border-radius:5px; margin:10px 0%;">
				<div class="col-xs-12" style="margin-top:20px;">
					<div class="col-xs-9">
						<h4><img src="https://www.durotechindustries.com.au/customdurotech/images/durotech_logo.png" ></h4>
					</div>
					<div class="col-xs-3">
						<h4 style="text-align:left; margin-top:20px; color:#0684c7;">FORMAL MEETING MINUTES</h4>
						<p style="text-align:left;"><span  style="color:#0684c7;">DATE:</span>	<?php echo format_db_date('D, F d, Y', $MintueMeetAll['MintueMeet']['date']); ?> </p>
						<p style="text-align:left;"><span  style="color:#0684c7;">TIME:</span>	<?php echo $MintueMeetAll['MintueMeet']['time']; ?> </p>
						<p style=" text-align:left;"><span  style="color:#0684c7;">LOCATION:</span>	<?php echo $MintueMeetAll['MintueMeet']['referid']; ?></p>
					</div>
					<div class="col-xs-12" style="margin-top:20px;">
					
					<div class="col-xs-12">
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">MEETING CREATED BY:</div>
						<div class="col-xs-4"><input type="text" name="meeting_created_by" required  value="<?php echo $MintueMeetAll['MintueMeet']['meeting_created_by']; ?>"></div>
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">TIME TAKEN:</div>
						<div class="col-xs-4"><input type="text" name="minute_taker" id="minute_taker" value="<?php echo $MintueMeetAll['MintueMeet']['minute_taker']; ?>" ></div>
					</div>
				
					<div class="col-xs-12" style="margin-top:20px;">
						<!--div class="col-xs-2 text-lable" style=" color:#0684c7;">FACILITATOR:</div>
						<div class="col-xs-4"><input type="text" name="facilitator" value="<?php echo $MintueMeetAll['MintueMeet']['facilitator']; ?>"></div-->
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">TIME KEEPER(Meeting Start):</div>
						<div class="col-xs-4"><input type="text" name="time_keeper" id="time_keeper" value="<?php echo $MintueMeetAll['MintueMeet']['time_keeper']; ?>" ></div>
					</div>

					<div class="col-xs-12" style="margin-top:40px;">
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">MEETING TOPIC:</div>
						<div class="col-xs-4"><input type="text" name="please_read" value="<?php echo $MintueMeetAll['MintueMeet']['please_read']; ?>"></div>						
					</div>
					<!--div class="col-xs-12" style="margin-top:40px;">
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">PLEASE BRING:</div>
						<div class="col-xs-4"><input type="text" name="please_bring" value="<?php //echo $MintueMeetAll['MintueMeet']['please_bring']; ?>"></div>						
					</div-->
					<?php $attendees_present = explode(',',$MintueMeetAll['MintueMeet']['attendees_present']); ?>
					<div class="col-xs-12" style="margin-top:40px;">
						<div class="col-xs-2 text-lable" style=" color:#0684c7;">ATTENDEES PRESENT:</div>										
					</div>
					<div class="col-xs-12" style="margin-top:40px;">
					<?php foreach($attendees_present  as $value){ ?>
						<div class="col-xs-3 text-lable"><input type="text" name="attendees_present[]" value="<?php echo $value; ?>"></div>
					<?php } ?>	
											
					</div>
										
					<div class="col-xs-12" style="margin-top:80px;text-align:center; color:#0684c7; font-weight:bold;">MINUTES</div>
						<div class="col-xs-12" style="margin-top:10px; text-align:center; background:#0684c7; color:#fff; padding:10px;">
							<?php if(isset($MintueMeetAll['MintueAgend'][0]['agenda_topic'])){ echo $MintueMeetAll['MintueAgend'][0]['agenda_topic'];  }  ?>
						</div>
						<table style="width:100%;">
							<tr>
								<th class="th_2">TIME ALLOCATED</th>
								<td><input type="text" name="time_allocate" value="<?php if(isset($MintueMeetAll['MintueAgend'][0]['time_allocate'])){ echo $MintueMeetAll['MintueAgend'][0]['time_allocate'];  }  ?>"></td>
								<th  class="th_2">PRESENTED BY</th>
								<td><input type="text" name="presented_by" value="<?php if(isset($MintueMeetAll['MintueAgend'][0]['presented_by'])){ echo $MintueMeetAll['MintueAgend'][0]['presented_by'];  }  ?>"></td>
							</tr>
							<tr>
								<th  class="th_1">DISCUSSION</th>
								<td colspan="3"><input type="text" name="discussion"  value="<?php if(isset($MintueMeetAll['MintueAgend'][0]['discussion'])){ echo $MintueMeetAll['MintueAgend'][0]['discussion'];  }  ?>"></td>								
							</tr>
							<tr>
								<th class="th_2" >CONCLUSION</th>
								<td colspan="3"><input type="text" name="conclusion"  value="<?php if(isset($MintueMeetAll['MintueAgend'][0]['discussion'])){ echo $MintueMeetAll['MintueAgend'][0]['discussion'];  }  ?>"></td>								
							</tr>
						</table>
						<table style="width:100%;">
							<tr>
								<th class="th_1" style="height:37px;">ACTION</th>
								<th class="th_1" style="height:37px;" >ACTION TO BE TAKEN BY</th>
								<th class="th_1" style="height:37px;">DATE TO BE ACTIONED BY</th>								
							</tr>
							<?php if(!empty($MintueMeetAll['MintueAgendDetail'])){  foreach($MintueMeetAll['MintueAgendDetail'] as $MintueAgendDetail){ ?>
							<tr>					
								<td style="border-right:1px solid #ddd;"><input type="text" value="<?php echo $MintueAgendDetail['action'];?>"></td>								
								<td style="border-right:1px solid #ddd;"><input type="text" value="<?php echo $MintueAgendDetail['action_to_be_taken_by'];?>"></td>								
								<td style="border-right:1px solid #ddd;"><input type="text" value="<?php echo $MintueAgendDetail['date_to_be_actioned_by'];?>"></td>								
														
							</tr>
							<?php } } ?>
						</table>
						<div class="col-xs-12" style="margin-top:40px;">
							<div class="col-xs-1 text-lable" style=" color:#0684c7;">Notes:</div>
							<div class="col-xs-11"><input type="text" name="note" value="<?php echo $MintueMeetAll['MintueMeet']['note']; ?>"></div>						
						</div>
						<div class="col-xs-12" style="margin-top:40px;">	
							<div class="col-xs-6">
								<h4 style="text-align:right; color:#0684c7;">SECRETARY APPROVAL: </h4>						
							</div>
							<div class="col-xs-6">
								<h4 style=""><span style="width:200px; text-decoration:underline; color:#0684c7;"><input type="text" name="signature" value="<?php echo $MintueMeetAll['MintueMeet']['signature']; ?>" ></span></h4>						
							</div>
						</div>	
							
					</div>
				</div>
			</div>
		
		</div>
	</div>	
	</div>	
	