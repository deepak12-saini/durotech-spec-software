	<style>
		.btn{ margin-bottom:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Project Reminders List
			<?php echo $this->Html->link('Add New ',array('controller' => 'project_reminders','action' => 'add'),array('class'=>'btn btn-info btn-xs top-button')); ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
				<thead>
				<tr>
					<th></th>		
					<th>Project Code</th>							
					<th>Project name</th>							
					<th>Important</th>
					<th>Status</th>	
					<th>Reminders</th>						
					<th>Date/Time</th>
				</tr>
				</thead>
				<tbody>
					<?php 
					$i=1;					
					foreach ($ProjectReminder as $ProjectReminders):					
					?>
					<tr>
						<td><?php echo $i; ?>&nbsp;</td>
						
						<td><?php echo h($ProjectReminders['ProjectReminder']['project_code']); ?>&nbsp;</td>						
						<td><?php echo h($ProjectReminders['ProjectReminder']['project_name']); ?>&nbsp;</td>
						<td><?php echo h($ProjectReminders['ProjectReminder']['important']); ?>&nbsp;</td>	
						<td><?php if($ProjectReminders['ProjectReminder']['status'] == 1) { echo 'Completed'; } else{ echo 'Pending'; } ?>&nbsp;</td>						
						<td><?php echo format_db_date('d F Y H:i a', $ProjectReminders['ProjectReminder']['datetime']); ?>&nbsp;</td>
						<td>
							<a href="<?php echo SITEURL.'project_reminders/edit/'.$ProjectReminders['ProjectReminder']['id']; ?>" class="btn btn-mini btn-success" >Edit</a>
						</td>
					</tr>
					<?php $i++; endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	
</div>	

<?php 
/*
$i=1;
foreach ($stockreturn as $stockreturns): 				
?>
<div id="myModal_<?php echo $stockreturns['StockReturn']['id']; ?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Return Id: <?php echo h($stockreturns['StockReturn']['return_id']); ?></h4>
		</div>
			<div class="modal-body">
			<div class="row">
				<div class="col-xs-12">
					<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover" id="simple-table" >
						<tbody>
						<tr>
							<th>Date</th>
							<th>Customer</th>
							<th>Item</th>
							<th>Reason For Return</th>
							<th>Condition OF Good</th>
							<th>Batch Number</th>
							<th>Received By</th>
						</tr>	
						<?php if(!empty($stockreturns)){ foreach($stockreturns['StockReturnData'] as $StockReturnDatas){ ?>
							<tr>
								<td><?php echo format_db_date('d-M-Y', $StockReturnDatas['date']); ?></td>
								<td><?php echo $StockReturnDatas['customer']; ?></td>
								<td><?php echo $StockReturnDatas['items']; ?></td>
								<td><?php echo $StockReturnDatas['reason']; ?></td>
								<td><?php echo $StockReturnDatas['conditions']; ?></td>
								<td><?php echo $StockReturnDatas['batch']; ?></td>
								<td><?php echo $StockReturnDatas['received']; ?></td>
								
							</tr>	
						<?php } } ?>
						</tbody>
						
					</table>			
					</div>
				</div>
				</div>				
			</div>				
		</div>				
	</div>				
</div>				

<?php $i++; endforeach;  */?>
	
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