	
	<style>
		.modal-header .close {
			margin-top: -15px;
		}
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Driver <a href="#null" class="btn btn-xs btn-info" data-toggle="modal" data-target="#myModalone">Add Driver</a></h1>
		</div>	
		<div class="data-table-area">
	
		<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
					<div class="table-responsive">
                         <table id="example" class="table table-striped">
							<thead>
								<tr>                                     
									<th>Driver Id</th>                                        
									<th>Driver Name</th>                                        
									<th>Driver Email</th>                                        
									<th>Driver Phone</th>                                        
									<th>Driver Username</th>                                        
									<th>Driver Licence</th>    
									<th>Active</th>
									<th>Created</th>
									<th>Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($DriverAll as $DriverAlls): ?>
								<tr>
									
									<td><?php echo 'KDL-'.$DriverAlls['Driver']['id']; ?>&nbsp;</td>				
									<td><?php echo h($DriverAlls['Driver']['driver_name']); ?>&nbsp;</td>
									<td><?php echo h($DriverAlls['Driver']['driver_email']); ?>&nbsp;</td>
									<td><?php echo h($DriverAlls['Driver']['driver_phone']); ?>&nbsp;</td>
									<td><?php echo h($DriverAlls['Driver']['driver_username']); ?>&nbsp;</td>
									<td><?php echo h($DriverAlls['Driver']['id_number']); ?>&nbsp;</td>
									<td>
										<?php if($DriverAlls['Driver']['status']==1){?>
										<span class="label label-success">Active</span>
										<?php }else{ ?>
										<span class="label label-danger">Inactive</span>
										<?php }?>&nbsp;
									</td>
									<td> <?php echo format_db_date('d-M-Y', $DriverAlls['Driver']['created']); ?></td>
									<td class="actions">
									<?php //echo $this->Html->link(__('Edit'), array('action' => 'edit', $brandAlls['Driver']['id']),array('class'=>'btn btn-xs btn-info')); ?>
									<a href="javascript:void()" class="btn btn-xs btn-info" onclick="editbrand(<?php echo $DriverAlls['Driver']['id']; ?>)">Edit</a>
									<?php //echo $this->Form->postLink(__('Delete'), array('action' => 'branddelete', $DriverAlls['Driver']['id']), array('class'=>'btn btn-xs btn-danger'), __('Are you sure you want to delete # %s?', $DriverAlls['Driver']['id'])); ?>

									</td>
									</tr>
								<?php endforeach; ?>
								 </tbody>
							</table>
                        </div>
                    </div>
                </div>
            </div>       				
		<div class="modal fade" id="myModalone" role="dialog">
		<div class="modal-dialog modals-default">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
				<h2>Add New Driver</h2><hr/>		
								
				<?php echo $this->Form->create('DuroOrder',array('action'=>'adddriver','class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
				<input type="hidden" name="data[Driver][id]" id="driver_id">
				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Name:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('Driver.driver_name',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'driver_name','placeholder'=>'Driver Name'))?>
				</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Email:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.driver_email',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'driver_email','placeholder'=>'Driver Email'))?>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Username:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.driver_username',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'driver_username','placeholder'=>'Driver Username'))?>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Password:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.driver_password',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'driver_password','placeholder'=>'Driver Password'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Phone:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.driver_phone',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'driver_phone','placeholder'=>'Driver Phone'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Licence Id:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.id_number',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'id_number','placeholder'=>'Driver Licence Id'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Photo:</label>
					<div class="col-sm-9">
						<input type="file" name="photo" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Police Certificate:</label>
					<div class="col-sm-9">
						<input type="file" name="police_certificate" >
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Certificate:</label>
					<div class="col-sm-9">
						<input type="file" name="driver_certificate" >
					</div>
				</div>
				<div class="form-group">
					<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Status: </label>
					<div class="col-sm-9">		
					
					<div class="radio"><label>
					<input type="radio" checked="checked" value="1"  class="ace"  name="data[Driver][status]"><span class="lbl"> Active</span>
					</label></div>
					
					<div class="radio"><label>
						<input type="radio" value="0"  class="ace"  name="data[Driver][status]"><span class="lbl"> Inactive</span>
					</label></div>				
					</div>
				</div>				
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-info btn-inverse','id'=>'add_ser_prd_btn','value'=>'Submit','style'=>'color:#fff; border-color:#31b0d5; background:#31b0d5 !important'));?>&nbsp;
						<?php echo $this->Html->link('Cancel','javascript:window.history.back();',array('class' => 'btn btn-danger'));?>

					</div>
				</div>
				<?php echo $this->Form->end(); ?>
					
				</div>
				
			</div>
		</div>
	</div>	
	
	<div class="modal fade" id="myModaloneedit" role="dialog">
		<div class="modal-dialog modals-default">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
				<h2>Edit Driver</h2><hr/>
				<?php echo $this->Form->create('DuroOrder',array('action'=>'adddriver','class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
				<input type="hidden" name="data[Driver][id]" id="e_driver_id">
				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Name:</label>
				<div class="col-sm-9">
					<?php echo $this->Form->input('Driver.driver_name',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'e_driver_name','placeholder'=>'Driver Name'))?>
				</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Email:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.driver_email',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'e_driver_email','placeholder'=>'Driver Email'))?>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Username:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.driver_username',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'e_driver_username','placeholder'=>'Driver Username'))?>
					</div>
				</div>	
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Password:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.driver_password',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'e_driver_password','placeholder'=>'Driver Password'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Phone:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.driver_phone',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'e_driver_phone','placeholder'=>'Driver Phone'))?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Licence Id:</label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('Driver.id_number',array('div'=>false,'label'=>false, 'class' => 'form-control','id'=>'e_id_number','placeholder'=>'Driver Licence Id'))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Photo:</label>
					<div class="col-sm-9">
						<input type="file" name="photo" ><br>
						<a href="" id="photo_anchor" target="_blank" style="display:none"><img src="" id="photo_img" width="100" height="100"  /></a>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Police Certificate:</label>
					<div class="col-sm-9">
						<input type="file" name="police_certificate" ><br>
						<a href="" id="police_certificate_anchor" target="_blank" style="display:none"><img src="" id="police_certificate_img" width="100" height="100"  /></a>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Driver Certificate:</label>
					<div class="col-sm-9">
						<input type="file" name="driver_certificate" ><br>
						<a href="" id="driver_certificate_anchor" target="_blank" style="display:none"><img src="" id="driver_certificate_img" width="100" height="100"  /></a>
					</div>
				</div>
				<div class="form-group">
					<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Status: </label>
					<div class="col-sm-9">		
					
					<div class="radio"><label>
					<input type="radio" id="e_status_1" value="1"  class="ace"  name="data[Driver][status]"><span class="lbl"> Active</span>
					</label></div>
					
					<div class="radio"><label>
						<input type="radio" id="e_status_0" value="0"  class="ace"  name="data[Driver][status]"><span class="lbl"> Inactive</span>
					</label></div>				
					</div>
				</div>				
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-info btn-inverse','id'=>'add_ser_prd_btn','value'=>'Submit','style'=>'color:#fff; border-color:#31b0d5; background:#31b0d5 !important'));?>&nbsp;
						<?php echo $this->Html->link('Cancel','javascript:window.history.back();',array('class' => 'btn btn-danger'));?>

					</div>
				</div>
				<?php echo $this->Form->end(); ?>
					
				</div>
				
			</div>
		</div>
	</div>
<a href="javascript:void();"  data-toggle="modal" data-target="#myModaloneedit" id="myModaloneeditnew">&nbsp;</a>	
<script type="text/javascript">
$(document).ready(function() {
	$('#example').DataTable();
} );
function editbrand(driver_id){
	if(driver_id > 0){
		 $.ajax({url: "<?php echo SITEURL.'duro_orders/editdriver/' ?>"+driver_id, success: function(result){
			var obj = jQuery.parseJSON(result);
			$("#e_driver_id").val(obj.id);
			$("#e_driver_name").val(obj.driver_name);
			$("#e_driver_email").val(obj.driver_email);
			$("#e_driver_username").val(obj.driver_username);
			$("#e_driver_password").val(obj.driver_password);
			$("#e_driver_phone").val(obj.driver_phone);
			$("#e_id_number").val(obj.id_number);
			
			var photo = obj.photo;
			var brandstatus = obj.status;
			var police_certificate = obj.police_certificate;
			var driver_certificate = obj.driver_certificate;
		
			if(photo != ''){				
				var src = '<?php echo SITEURL.'driver/'?>'+photo;				
				$("#photo_anchor").show();;
				$("#photo_anchor").attr("src",src);
				$("#photo_img").attr("src",src);			
			}else{
				$("#photo_img").hide();
			}	
			if(police_certificate != ''){				
				var src = '<?php echo SITEURL.'driver/'?>'+police_certificate;				
				$("#police_certificate_anchor").show();;
				$("#police_certificate_anchor").attr("src",src);
				$("#police_certificate_img").attr("src",src);			
			}else{
				$("#police_certificate_img").hide();
			}	
			if(driver_certificate != ''){				
				var src = '<?php echo SITEURL.'driver/'?>'+driver_certificate;				
				$("#driver_certificate_anchor").show();;
				$("#driver_certificate_anchor").attr("src",src);
				$("#driver_certificate_img").attr("src",src);			
			}else{
				$("#driver_certificate_img").hide();
			}	
			
			if(brandstatus == 1){			
				
				$("#e_status_1").prop("checked", true); 
				$("#e_status_1").attr('checked', 'checked');
				
			}else{
				
				$("#e_status_0").prop("checked", true); 
				$("#e_status_0").attr('checked', 'checked');
				
			}
			 
			$('#myModaloneeditnew').trigger('click');
		}
		});
	}
}

jQuery(function(){ 
	$("#vehicle_id").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please assign vehicle"
	});$("#d_vehicle_id").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please assign vehicle"
	});$("#driver_name").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter driver name"
	});$("#driver_email").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter driver email"
	});$("#driver_username").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter driver username"
	});$("#driver_password").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter driver password"
	});$("#driver_phone").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter driver phone"
	});$("#id_number").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter licence number"
	});$("#transports").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select transport type"
	});$("#e_transports_id").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please selec  transport type"
	});
});
</script>
