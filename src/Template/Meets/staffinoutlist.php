	<style>
		.btn{ margin-bottom:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Staff In/Out List
			
			<?php if($isopen == 1){ echo $this->Html->link('Send URL',array('controller' => 'meets','action' => 'sendurl'),array('class'=>'btn btn-info btn-xs top-button')); } ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
				<thead>
				<tr>				
					<th></th>		
					<th>Refer Id</th>		
					<th>Name</th>		
					<th>Email</th>		
					<th>Phone</th>		
					<th>StartTime</th>		
					<th>EmdTime</th>		
					<th>Date</th>		
					<th>Work Status</th>						
				</tr>
				</thead>
				<tbody>
					<?php 
					$i=1;	
					foreach ($StaffTime as $StaffTimes):					
					?>
					<tr>		
						<td><?php echo $i; ?>&nbsp;</td>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $i; ?>" href="#null"><?php echo h($StaffTimes['StaffTime']['referid']); ?></a>	&nbsp;</td>
						<td><?php echo h($StaffTimes['StaffTime']['name']); ?>&nbsp;</td>
						<td><?php echo h($StaffTimes['StaffTime']['email']); ?>&nbsp;</td>
						<td><?php echo h($StaffTimes['StaffTime']['phone']); ?>&nbsp;</td>
						<td><?php echo h($StaffTimes['StaffTime']['start_time']); ?>&nbsp;</td>
						<td><?php echo h($StaffTimes['StaffTime']['end_time']); ?>&nbsp;</td>
						<td><?php if($StaffTimes['StaffTime']['startdate'] != '0000-00-00 00:00:00'){ echo date('d M Y',strtotime($StaffTimes['StaffTime']['startdate']));} ?>&nbsp;</td>
						<td><?php if($StaffTimes['StaffTime']['work_status'] == ''){ echo 'Sent'; }else{ echo $StaffTimes['StaffTime']['work_status']; } ?>&nbsp;</td>
					</tr>
					<?php $i++; endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	
</div>	
	<?php 
	$i=1;	
	foreach ($StaffTime as $StaffTimes):					
	?>
	<div id="myModal_<?php echo $i; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">ReferId: <?php echo h($StaffTimes['StaffTime']['referid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover"  >
							<tbody>
							<tr><th>ReferId: </th><td><span class="label label-inverse"><?php echo h($StaffTimes['StaffTime']['referid']); ?></span></td></tr>								
							<tr><th>Name: </th><td><?php echo h($StaffTimes['StaffTime']['name']); ?></td></tr>	
							<tr><th>Email: </th><td><?php echo h($StaffTimes['StaffTime']['email']); ?></td></tr>	
							<tr><th>Phone: </th><td><?php echo h($StaffTimes['StaffTime']['phone']); ?></td></tr>	
							<tr><th>Start Time: </th><td><?php echo h($StaffTimes['StaffTime']['start_time']); ?></td></tr>	
							<tr><th>End Time: </th><td><?php echo h($StaffTimes['StaffTime']['end_time']); ?></td></tr>	
							<tr><th>Date: </th><td><?php if($StaffTimes['StaffTime']['startdate'] != '0000-00-00 00:00:00'){ echo date('d M Y',strtotime($StaffTimes['StaffTime']['startdate']));} ?></td></tr>	
							<tr><th>Work Status: </th><td><?php echo h($StaffTimes['StaffTime']['work_status']); ?></td></tr>						
							<tr><th>Work Summary: </th><td><?php echo h($StaffTimes['StaffTime']['summary']); ?></td></tr>						
												
							</tbody>
						</table>		
					</div>
				</div>
			</div>		
		  </div>
		</div>
	</div>
	</div>
<?php $i++; endforeach; ?>	
<script>
	$(document).ready(function() {
		$('#example').DataTable();
	} );
	function openpoup(id){
		var url = '<?php echo SITEURL.'stocks/comment/' ?>'+id;
		$('#abc_frame').attr('src', url);
		$("#myModalNew").trigger('click');	
	}
</script>	