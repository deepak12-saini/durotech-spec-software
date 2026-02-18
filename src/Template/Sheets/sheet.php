	<style>
		textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]{ padding: 0px 4px 0px; width:105px;}
		select {
			padding: 0px 0px;
			height: 23px;
		}
	</style>	
	<?php
		$permission = '';
		if(!empty($SsSheetShare) && ($SsSheetShare['SsSheetShare']['permission'] == 1)){
			$permission = 'disabled';
		}	
		$optional = '<option value="">Assign To User</option>';
		if(!empty($sheetinfo['SsSheetShare'])){
			foreach($sheetinfo['SsSheetShare'] as $emplist){
				$empid = $emplist['NappUser']['id'];	
				$email = $emplist['NappUser']['email'];	
				$optional .= '<option value="'.$empid.'">'.$email.'</option>'; 
			}
		}
	?>	
	<div class="page-content">
		<div class="page-header">
			<h1><i class="menu-icon fa fa-share" style="color:#438eb9;"></i> <?php echo ucfirst($sheetinfo['SsSheetCategory']['name']); ?> Sheets
			<a href="<?php echo SITEURL.'sheets'; ?>" style="float:right;" class="btn btn-mini btn-info">Back</a>
			</h1>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="simple-table" cellspacing=0 border=1 >
					<thead>
					<tr>					
						<th></th>
						<th>TaskId</th>
						<!--th><i class="fa fa-envelope"></i></th-->
						<?php 
						if(!empty($sheetinfo)){  foreach($sheetinfo['SsSheetColumn'] as $sheetinfos){
							if($sheetinfos['filed_type'] == 'is_reminder'){
						?>
							<th><?php echo $sheetinfos['column'];?><br><a title="If you want to stop reminder uncheck the checkbox." href="javascript:void()" ><i class="fa fa-question-circle"></i></a></th>
						<?php }else{ ?>
							<th><?php echo $sheetinfos['column'];?></th>
						<?php } } } ?>
						<th>Last Updated</th>
					</tr>
					</thead>
					<tbody>
						<?php 
						if(!empty($rows)){						
						foreach($rows as $key=>$rowval){
						$taskId = $key;						
						?>
							<tr id="row_<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>">
								<form action="" method="post" id="form_<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>">
								<input type="hidden" name="data[sheet_cate_id]" value="<?php echo $sheetinfo['SsSheetCategory']['id'] ?>" >
								<input type="hidden" name="data[task_id]" value="<?php echo $taskId ?>" >
								<td >
									<div style="width:110px">
										<!--a href="javascript:void();" onclick="trashrow('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" title="Delete this row"><i class="fa fa-trash"></i></a-->
										&nbsp;
										<a href="javascript:void();" onclick="opendocpoup('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')"  title="Attachment"><i class="fa fa-paperclip"></i></a>
										&nbsp;
										<a href="javascript:void();" onclick="openpoup('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')"  title="Comments"><i class="fa fa-comment"></i></a>
										&nbsp;
										<a href="javascript:void();" onclick="opensendtoclient('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')"  title="Comments"><i class="fa fa-envelope"></i></a>
										&nbsp;
										<a href="javascript:void();" onclick="viewdatanew('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>','<?php echo $taskId; ?>')"><i class="fa fa-eye"></i></a>	
										<?php if($sheetinfo['SsSheetCategory']['is_call'] == 1){ ?>&nbsp;	
											<a href="javascript:void();" onclick="calltocient('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')"  title="Call to client"><i class="fa fa-phone"></i></a>
										<?php } ?>
									</div>									
								</td>
								<td id="<?php echo $taskId; ?>">#<?php echo $taskId; ?></td>
								<?php if(!empty($sheetinfo)){  foreach($sheetinfo['SsSheetColumn'] as $sheetinfos){ ?>
									<?php if($sheetinfos['filed_type'] == 'name'){ ?>
										<td>
											<div style="width:200px">
												<input  type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>" >
												
											</div>
										</td>
									<?php }else if($sheetinfos['filed_type'] == 'email'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>" >
												
											</div>
										</td>
									<?php }else if($sheetinfos['filed_type'] == 'landline'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>" >
												
											</div>
										</td>	
									<?php }else if($sheetinfos['filed_type'] == 'mobile'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>" >
												
											</div>
										</td>
									<?php }else if($sheetinfos['filed_type'] == 'company'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>" >
												
											</div>
										</td>		
									<?php }else if($sheetinfos['filed_type'] == 'address'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>" >
												
											</div>
										</td>		
									<?php }else if($sheetinfos['filed_type'] == 'Text'){ ?>
										<td>
											<div>
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>" >
												
												<!-- <a href="javascript:void();" onclick="viewdata('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>')"><i class="fa fa-eye"></i></a> -->
											</div>
										</td>
									<?php } else if($sheetinfos['filed_type'] == 'date'){ ?>
										<td style="width: 100px;">
											<input <?php echo $permission; ?> type="text" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>" class="datepicker" readonly name="data[column][<?php echo $sheetinfos['id']; ?>]" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')">
										</td>								
									<?php } else if($sheetinfos['filed_type'] == 'assigned'){ ?>
										<td style="width: 100px;">
											<select <?php echo $permission; ?> name="data[column][<?php echo $sheetinfos['id']; ?>]" onchange="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>','assigned')">
												<?php
												if(!empty($sheetinfo['SsSheetShare'])){
													foreach($sheetinfo['SsSheetShare'] as $emplist){
													$empid = $emplist['NappUser']['id'];	
													$email = $emplist['NappUser']['email'];	
												?>
												<option value="">Assign To User</option>
												<option <?php if(isset($rowval[$sheetinfos['id']]) && ($rowval[$sheetinfos['id']]['value'] == $empid )){ echo 'selected'; } ?> value="<?php echo $empid; ?>"><?php echo $email; ?></option>
												<?php }} ?>	
											</select>
										</td>
									<?php } else if($sheetinfos['filed_type'] == 'Checkbox'){ ?>
										<td style="width: 30px;">
											<input type="hidden" name="data[column][<?php echo $sheetinfos['id']; ?>]" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>"  id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId.'_'.$sheetinfos['id']; ?>">									
											
											<input <?php echo $permission; ?> <?php if(isset($rowval[$sheetinfos['id']]) && ($rowval[$sheetinfos['id']]['value']) == 1){ echo 'checked'; } ?> type="checkbox" id="checkbox_<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId.'_'.$sheetinfos['id']; ?>" onclick="ischeckbox('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>','<?php echo $sheetinfos['id']; ?>')" >	
										</td>
									<?php } else if($sheetinfos['filed_type'] == 'Dropdown'){ ?>
										<td style="width: 100px;">
											<select <?php echo $permission; ?> name="data[column][<?php echo $sheetinfos['id']; ?>]" onchange="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')">
												
												<option <?php if(isset($rowval[$sheetinfos['id']]) && ($rowval[$sheetinfos['id']]['value'] == 'Empty')){ echo 'selected'; } ?> value="Empty">Empty</option>	
												
												<option <?php if(isset($rowval[$sheetinfos['id']]) && ($rowval[$sheetinfos['id']]['value'] == 'Quarter')){ echo 'selected'; } ?> value="Quarter">Quarter</option>
												
												<option  <?php if(isset($rowval[$sheetinfos['id']]) && ($rowval[$sheetinfos['id']]['value'] == 'Half')){ echo 'selected'; } ?> value="Half">Half</option>	
												
												<option  <?php if(isset($rowval[$sheetinfos['id']]) && ($rowval[$sheetinfos['id']]['value'] == 'Three Quarter')){ echo 'selected'; } ?> value="Three Quarter">Three Quarter</option>	
												<option  <?php if(isset($rowval[$sheetinfos['id']]) && ($rowval[$sheetinfos['id']]['value'] == 'Full')){ echo 'selected'; } ?>  value="Full">Full</option>	
											</select>
										</td>	
									<?php } else if($sheetinfos['filed_type'] == 'is_reminder'){ ?>
										<td style="width: 30px;">
											<input type="hidden" name="data[column][<?php echo $sheetinfos['id']; ?>]" value="<?php if(isset($rowval[$sheetinfos['id']])){ echo $rowval[$sheetinfos['id']]['value'];  } ?>"  id="<?php echo 'isreminder_'.$sheetinfo['SsSheetCategory']['id'].'_'.$taskId.'_'.$sheetinfos['id']; ?>">									
											
											<input <?php echo $permission; ?> <?php if(isset($rowval[$sheetinfos['id']]) && ($rowval[$sheetinfos['id']]['value']) == 1){ echo 'checked'; } ?> type="checkbox" id="reminder_<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId.'_'.$sheetinfos['id']; ?>" onclick="ischeckboxreminder('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>','<?php echo $sheetinfos['id']; ?>')" >	
											
										</td>	
									<?php } ?>								
								
							<?php } } ?>
							<td style="width: 100px;">
							<?php
								
								foreach($rowval as $rowvals){
									if(isset($rowvals['created'])){
										$createddate = $rowvals['created'];
									}
								}
								if(isset($createddate)){
									echo date('d-m-Y',strtotime($createddate));
								}else if(isset($rowval[0]['created'])){
									echo date('d-m-Y',strtotime($rowval[0]['created']));
								}
							?>
							</td>
							</form>	
							</tr>							
						<?php 
							} }
							if($permission != 'disabled'){
							for($j=0; $j<10; $j++){
							$taskId = rand(00000000,99999999);
							$taskId = substr($taskId, 0, 4);
						?>						
							<tr id="row_<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>">
							<form action="" method="post" id="form_<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>">
							<input type="hidden" name="data[sheet_cate_id]" value="<?php echo $sheetinfo['SsSheetCategory']['id'] ?>" >
							<input type="hidden" name="data[task_id]" value="<?php echo $taskId ?>" >
							<td style="width: 100px;">
								<!--a href="javascript:void();" onclick="trashrow('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" title="Delete this row"><i class="fa fa-trash"></i></a-->
								&nbsp;&nbsp;&nbsp;
								<a href="javascript:void();" onclick="opendocpoup('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')"  title="Attachment"><i class="fa fa-paperclip"></i></a>
								&nbsp;&nbsp;&nbsp;
								<a href="javascript:void();" onclick="openpoup('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')"  title="Comments"><i class="fa fa-comment"></i></a>						
							</td>
							<td id="<?php echo $taskId; ?>">#<?php echo $taskId; ?></td>
							<?php if(!empty($sheetinfo)){  foreach($sheetinfo['SsSheetColumn'] as $sheetinfos){ ?>
									
									<?php if($sheetinfos['filed_type'] == 'name'){ ?>
										<td>
											<div style="width:200px">
												<input  type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="" >
												
											</div>
										</td>
									<?php }else if($sheetinfos['filed_type'] == 'email'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="" >
												
											</div>
										</td>
									<?php }else if($sheetinfos['filed_type'] == 'landline'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="" >
												
											</div>
										</td>	
									<?php }else if($sheetinfos['filed_type'] == 'mobile'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="" >
												
											</div>
										</td>
									<?php }else if($sheetinfos['filed_type'] == 'company'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="" >
												
											</div>
										</td>		
									<?php }else if($sheetinfos['filed_type'] == 'address'){ ?>
										<td>
											<div style="width:200px">
												<input <?php echo $permission; ?> type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" value="" >
												
											</div>
										</td>
									<?php }else if($sheetinfos['filed_type'] == 'Text'){ ?>
										<td>
											<input type="text" id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" style="width:100%" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')" >
											<!-- <a href="javascript:void();" onclick="viewdata('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$sheetinfos['id'].'_'.$taskId; ?>')"><i class="fa fa-eye"></i></a> -->
										</td>
									<?php } else if($sheetinfos['filed_type'] == 'date'){ ?>
										<td style="width: 100px;">
											<input type="text" value="" class="datepicker" readonly name="data[column][<?php echo $sheetinfos['id']; ?>]" onblur="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')">
										</td>								
									<?php } else if($sheetinfos['filed_type'] == 'assigned'){ ?>
										<td style="width: 100px;">
											<select id="assigned_<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>" name="data[column][<?php echo $sheetinfos['id']; ?>]" onchange="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>','assigned')">										
												<?php echo $optional; ?>
											</select>
										</td>
									<?php } else if($sheetinfos['filed_type'] == 'Checkbox'){ ?>
										<td style="width: 30px;">
											<input type="hidden" name="data[column][<?php echo $sheetinfos['id']; ?>]" value="0"  id="<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId.'_'.$sheetinfos['id']; ?>">									
											
											<input type="checkbox" id="checkbox_<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId.'_'.$sheetinfos['id']; ?>" onclick="ischeckbox('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>','<?php echo $sheetinfos['id']; ?>')" >	
										</td>
									<?php } else if($sheetinfos['filed_type'] == 'Dropdown'){ ?>
										<td style="width: 100px;">
											<select name="data[column][<?php echo $sheetinfos['id']; ?>]" onchange="submitform('<?php echo $sheetinfo['SsSheetCategory']['id'].'_'.$taskId; ?>')">
												<option value="Empty">Empty</option>	
												<option value="Quarter">Quarter</option>	
												<option value="Half">Half</option>	
												<option value="Three Quarter">Three Quarter</option>	
												<option value="Full">Full</option>	
											</select>
										</td>
									<?php } else if($sheetinfos['filed_type'] == 'is_reminder'){ ?>
									<td style="width: 100px;"></td>
									<?php } ?>								
								
							<?php } }?>
							<td style="width: 100px;"><?php //echo date('d-m-Y'); ?></td>
							</form>		
						</tr>
						
						<?php } } ?>
					</tbody>
				</table>			
				</div>
			</div>
		</div>				
	</div>	
	<span  data-toggle="modal" data-target="#myModaldoc_new" id="myModalNewdocument"><i></i></span>
	<div id="myModaldoc_new" class="modal fade" role="dialog" >
		<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Client Document  </h4>
			  </div>
			  <div class="modal-body">
					<iframe src="" id="document_frame" style="width:100%; border:none; height:400px;"></iframe>
			  </div>      
			</div>
	  </div>
	</div>	
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		 <div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<p class="modal-title" id="title" style="font-weight:bold;"></p>
			</div>
		 </div>
		
	  </div>
	</div>
	<span data-toggle="modal" data-target="#myModal" id="linkmyModal">&nbsp;</span>
	<span  data-toggle="modal" data-target="#myModal_new" id="myModalNew"><i></i></span>
	<div id="myModal_new" class="modal fade" role="dialog" >
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Comments</h4>
		  </div>
		  <div class="modal-body">
				<iframe src="" id="abc_frame" style="width:100%; border:none; height:400px;"></iframe>
		  </div>      
		</div>

	  </div>
	</div>
	<span  data-toggle="modal" data-target="#myModal_view" id="myModalView"><i></i></span>
	<div id="myModal_view" class="modal fade" role="dialog" >
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title" id="titletaskid"></h4>
		  </div>
		  <div class="modal-body">
				<iframe src="" id="myModal_view_frame" style="width:100%; border:none; height:400px;"></iframe>
		  </div>      
		</div>

	  </div>
	</div>	
	<span  data-toggle="modal" data-target="#myModal_client" id="myModalsendtoclient"><i></i></span>
	<div id="myModal_client" class="modal fade" role="dialog" >
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Send Comment To Client</h4>
		  </div>
		  <div class="modal-body">
				<iframe src="" id="sendtocleint" style="width:100%; border:none; height:400px;"></iframe>
		  </div>      
		</div>

	  </div>
	</div>
	<span  data-toggle="modal" data-target="#myModaldoc_callnew" id="myModalNewcall"><i></i></span>
	<div id="myModaldoc_callnew" class="modal fade" role="dialog" >
	  <div class="modal-dialog">


		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Call To Client: </h4>
		  </div>
		  <div class="modal-body">
				<iframe src="" id="callto_frame" style="width:100%; border:none; height:400px;"></iframe>
		  </div>      
		</div>

	  </div>
	</div>	
	<script type="text/javascript">
		function calltocient(id){		
			var url = '<?php echo SITEURL.'sheets/dailer/' ?>'+id;
			$('#callto_frame').attr('src', url);
			$("#myModalNewcall").trigger('click');	
		}
		function opensendtoclient(id){
			var url = '<?php echo SITEURL.'sheets/sendtoclient/' ?>'+id;
			$('#sendtocleint').attr('src', url);
			$("#myModalsendtoclient").trigger('click');	
		}
		function viewdatanew(argu,titletaskid){
			var url = '<?php echo SITEURL.'admin/sheets/viewdtaa/' ?>'+argu;
			$("#titletaskid").text('Task Id: '+titletaskid);
			$('#myModal_view_frame').attr('src', url);
			$("#myModalView").trigger('click');	
		}
		function opendocpoup(id){		
			var url = '<?php echo SITEURL.'sheets/document/' ?>'+id;
			$('#document_frame').attr('src', url);
			$("#myModalNewdocument").trigger('click');	
		}
		function openpoup(id){
			var url = '<?php echo SITEURL.'sheets/comment/' ?>'+id;
			$('#abc_frame').attr('src', url);
			$("#myModalNew").trigger('click');	
		}
		jQuery(function(){ 
			$('.datepicker').datepicker({
				format: "dd-mm-yyyy",							
			});
			
		});
		function ischeckbox(formid,column_id){
		
			if($("#checkbox_"+formid+"_"+column_id).prop("checked") == true){		
				$("#"+formid+"_"+column_id).val(1);
			}
			else if($("#checkbox_"+formid+"_"+column_id).prop("checked") == false){
				$("#"+formid+"_"+column_id).val(0);
			}
			submitform(formid);
		}
		function ischeckboxreminder(formid,column_id){
			//alert("#isreminder_"+formid+"_"+column_id);
			if($("#reminder_"+formid+"_"+column_id).prop("checked") == true){		
				$("#isreminder_"+formid+"_"+column_id).val(1);
				updatetasktracking(formid,1);
			}
			else if($("#reminder_"+formid+"_"+column_id).prop("checked") == false){
				$("#isreminder_"+formid+"_"+column_id).val(0);
				updatetasktracking(formid,0);
			}
			
			submitform(formid);
		}
		function updatetasktracking(formid,status){		
			$.ajax({
				url:'<?php echo SITEURL.'sheets/updatetasktracking/'?>'+formid+'/'+status,
				type:'POST',
				data:'',
				success:function(result){
					
				}
			});
		}
		function submitform(formid,assigned){
			var userid = '';
			if(assigned != ''){
				var userid = $("#assigned_"+formid).val();				
			}	
			$.ajax({
				url:'<?php echo SITEURL.'sheets/savedata/'; ?>',
				type:'POST',
				data:$("#form_"+formid).serialize(),
				success:function(result){
					//alert(result);
				}
			});
		}

		function trashrow(argu){
		
			var conf = confirm('Are you sure delete this row ?');
			if(conf == true){
				var Actionurl = '<?php echo SITEURL.'sheets/doctrash/' ?>'+argu;
				 $.ajax({
					url:Actionurl,
					type:'POST',
					success:function(result){
						$("#row_"+argu).hide();
					}

				});
			}else{			
				return false;
			}
		}
		function viewdata(argu){
			var task = $("#"+argu).val();
			$("#title").html(task);
			$("#linkmyModal").trigger('click');		
		}
		
		function chckval(){
		
			var selorder1 = 0.00000001;
			var selorder2 = 0.00000003;
			
			var finaltotal = Number.parseFloat(selorder1) + Number.parseFloat(selorder2);
			alert(finaltotal.toFixed(8));
		}
	</script>