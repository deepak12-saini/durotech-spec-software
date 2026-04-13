	 <script src="<?php echo SITEURL ?>signature_pad-master/signature_pad-master/js/signature_pad.js"></script>
	 
	  <style>
            #signature-pad{
                 border: 1px solid #c0c0c0;
            }
    </style>
	<div class="row">
		<div class="col-sm-12">
			<div class="login-containerd">
				<div class="center">
					<h1>
						<a href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL; ?>customdurotech/images/durotech_logo.png"/></a>
					</h1>
					<?= $this->Flash->render() ?>
				</div>
				<h4 class="blue" id="id-company-text">Visitor Entery Register (<?php echo date('d/m/Y'); ?>)			
					<a class="btn btn-mini btn-primary" href="javascript:void();"  style="float:right;"  data-toggle="modal" data-target="#myModal">Visitor In</a>
				</h4>
				<div class="page-content">
									
					<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="simple-table" >
							<thead>
							<tr>
								
								<th>Visitor Pass Id</th>
								<th>Date</th>
								<th>Visitor's Name</th>
								<th>Visitor For?</th>
								<th>Time In</th>
								<th>Time Out</th>
								<th>Initial</th>
								<th>Photo</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
								<?php if(!empty($visitor)){ foreach ($visitor as $visitors): ?>
								<tr>
									<td>#<?php echo $visitors['Visitor']['visitor_card_id']; ?>&nbsp;</td>
									<td><?php echo format_db_date('d/m/Y', $visitors['Visitor']['date']); ?>&nbsp;</td>
									<td><?php echo h($visitors['Visitor']['visitor_name']); ?>&nbsp;</td>					
									<td><?php echo h($visitors['Visitor']['visit_for']); ?>&nbsp;</td>					
									<td><?php if($visitors['Visitor']['timein'] != '0000-00-00 00:00:00') { echo format_db_date('h:i a', $visitors['Visitor']['timein']); }else{ echo '--'; } ?></td>
									<td><?php if($visitors['Visitor']['timeout'] != '0000-00-00 00:00:00') { echo format_db_date('h:i a', $visitors['Visitor']['timeout']); }else{ echo '--'; } ?></td>
									<td><?php if(!empty($visitors['Visitor']['sign'])){  ?> <img src="<?php echo SITEURL.'signature/'.$visitors['Visitor']['sign'] ?>" width="100"/>  <?php } ?>&nbsp;</td>
									<td><?php if(!empty($visitors['Visitor']['image'])){  ?> <a target="_blank" href="<?php echo SITEURL.'signature/'.$visitors['Visitor']['image'] ?>"><img src="<?php echo SITEURL.'signature/'.$visitors['Visitor']['image'] ?>" width="100"/>  <?php } ?></a>&nbsp;</td>
									<td>
									<?php if($visitors['Visitor']['timeout'] == '0000-00-00 00:00:00') { ?>
										<a onclick="return confirm('Are you sure punch out right record?')" class="btn btn-mini btn-danger" href="<?php echo SITEURL.'fronts/punchout/'.base64_encode($visitors['Visitor']['id']);?>">Visitor Out</a>
									<?php } ?>
									</td>					
								</tr>
								<?php endforeach; }else{ ?>
								<tr>
									 <td colspan="7" style="text-align:center; color:red; font-weight:bold;">No Visit Today</td>
								</tr>
								<?php } ?>

							</tbody>
						</table>			
						</div>
					</div>
				</div>		
				
				</div>		
			</div>		
		</div>		
	</div>		
	<!-- Modal -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
		<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Visitor Entery Register</h4>
				</div>
			 <div class="modal-body">					 
				 <?php echo $this->Form->create('Front',array('action'=> '','name'=>'loginForm','id'=>'materialorder','enctype'=>'multipart/form-data'));?>
				
					<fieldset>
						<label class="block clearfix">
							<span class="block input-icon input-icon-right">									
								<input readonly name="data[Front][date]" class="form-control" value="<?php echo date('d/m/Y'); ?>" type="text" style="background: #e6e6e6 !important;">								
							</span>
						</label>
						<label class="block clearfix">
							<span class="block input-icon input-icon-right">									
								<?php echo $this->Form->input('Front.visitor_name',array('div'=>false,'label'=>false, 'class' => array('form-control'),'placeholder'=>'Visitor Name','id'=>'visitor_name','required')); ?>								
							</span>
						</label>
						<label class="block clearfix">
							<span class="block input-icon input-icon-right">									
								<select name="data[Front][visitor_card_id]" id="visitor_card_id" class="form-control">
									<option value="">Select Visitor Pass Number</option>
									<?php for($i=1; $i<= 15;  $i++){ ?>
										<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
									<?php } ?>
								</select>	
							</span>
						</label>
						
						<label class="block clearfix">
							<span class="block input-icon input-icon-right">	
								<textarea autocomplete="off" name="data[Front][visit_for]" class="form-control" placeholder="Visitor For?" id="visit_for" required></textarea>
													
							</span>
						</label>
						<label class="block clearfix">
							<span class="block input-icon input-icon-right">	
								<input id="myFileInput" type="file" name="file" accept="image/*;capture=camera">
							</span>
						</label>	
						
						<label class="block clearfix">
							<small>Singature</small>
							<span class="block input-icon input-icon-right">	
								<canvas id="signature-pad" class="signature-pad" width="300px" height="100px"></canvas>		
							</span>
						</label>
						<input type="hidden" name="sigimage" id='output' > 
					
						<div class="space"></div>
						<div class="clearfix">	
							<a href='#null' id='click' class="btn btn-xs btn-success" >Save</a>		
							<?php // echo $this->Form->submit('Submit',array('div'=>false,'class'=>'width-35 pull-right btn btn-sm btn-primary')); ?>
						</div>

						<div class="space-4"></div>
					</fieldset>
				<?php echo $this->Form->end();?>
			  </div>		 
		</div>
	  </div>
	</div>
	<script>
	
	var myInput = document.getElementById('myFileInput');
	function sendPic() {
		var file = myInput.files[0];
	}
	myInput.addEventListener('change', sendPic, false);
	
	$(document).ready(function() {
		var signaturePad = new SignaturePad(document.getElementById('signature-pad'));
		$('#click').click(function(){
			var data = signaturePad.toDataURL('image/png');
			$('#output').val(data);
			var visitor_name = $("#visitor_name").val();
			var visit_for = $("#visit_for").val();
			var visitor_card_id = $("#visitor_card_id").val();
			var output = $("#output").val();
			if(visitor_name == '' || visit_for == ''){
				alert('visitor name or visit for is required');
				return false;
			}else if(visitor_card_id == ''){
				alert('Please select visitor pass number');
				return false;
			}else if(output == ''){
				alert('Signature required.');
				return false;
			}else{
				$("#materialorder").submit();
			}
			//$("#sign_prev").show();
			//$("#sign_prev").attr("src",data);                   
		});
	});
	</script>