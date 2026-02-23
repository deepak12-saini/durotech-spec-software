	<style>
		.btn{ margin-bottom:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Debt Collection Software
			<?php echo $this->Html->link('Add New', ['controller' => 'DebitCollections', 'action' => 'addnew'], ['class' => 'btn btn-info btn-xs top-button']); ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
				<thead>
				<tr>
					<th></th>		
					<th>InvoiceId</th>							
					<th>Name</th>							
					<th>Phone Number</th>							
					<th>Amount owing</th>							
					<th>Email</th>
					<th>Status</th>
					<th>Sms</th>
					<th>Email Reminder</th>
					<th>Last Update</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					foreach ($DebitCollection as $DebitCollections):
						$dc = $DebitCollections['DebitCollection'] ?? [];
						$lastUpdate = $dc['modified_date'] ?? $dc['created'] ?? '';
					?>
					<tr>
						<td><?php echo $i; ?>&nbsp;</td>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo h($dc['invoice_id'] ?? $dc['id'] ?? ''); ?>" href="#null"><?php echo h($dc['invoice_id'] ?? ''); ?></a>&nbsp;</td>
						<td><?php echo h($dc['name'] ?? ''); ?>&nbsp;</td>
						<td><?php echo h($dc['number'] ?? ''); ?>&nbsp;</td>
						<td><?php echo h($dc['amount'] ?? ''); ?>&nbsp;</td>
						<td><?php echo h($dc['email'] ?? ''); ?>&nbsp;</td>
						<td><?php echo (isset($dc['status']) && (int)$dc['status'] === 1) ? 'Paid' : 'Payment Pending'; ?>&nbsp;</td>
						<td><?php echo (isset($dc['is_sms']) && (int)$dc['is_sms'] === 1) ? 'Yes' : 'No'; ?>&nbsp;</td>
						<td><?php echo (isset($dc['is_email']) && (int)$dc['is_email'] === 1) ? 'Yes' : 'No'; ?>&nbsp;</td>
						<td><?php echo h($lastUpdate); ?>&nbsp;</td>
						<td>
							<a href="<?php echo $this->Url->build(['controller' => 'DebitCollections', 'action' => 'edit', $dc['id'] ?? '']); ?>" class="btn btn-mini btn-success">Edit</a>
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
								<td><?php echo date('d-M-Y',strtotime($StockReturnDatas['date'])); ?></td>
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