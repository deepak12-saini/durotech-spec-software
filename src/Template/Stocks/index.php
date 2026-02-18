	<style>
		.btn{ margin-bottom:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Duortech <?php echo ucfirst($acctype); ?> Stock Return Logs
			<?php echo $this->Html->link('Add New',array('controller' => 'stocks','action' => 'create/'.$acctype),array('class'=>'btn btn-info btn-xs top-button')); ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
				<thead>
				<tr>
					<th></th>		
					<th>Return Id</th>		
					<th>Customer Type</th>							
					<th>Created By</th>	
					<th style="width: 145px !important;">FTIR SCAN (yes or no) </th>		
					<th>Created</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php 					
					foreach ($stockreturn as $coas):					
					?>
					<tr>
					<td>
						<a href="javascript:void();" onclick="openpoup('<?php echo $coas['StockReturn']['id']; ?>')"  title="Comments"><i class="fa fa-comment"></i></a>	&nbsp;&nbsp;
						<a href="javascript:void();" data-toggle="modal" data-target="#myModal_<?php echo $coas['StockReturn']['id']; ?>" href="#null"><i class="fa fa-eye"></i></a>							
					</td>
					
					<td><a data-toggle="modal" data-target="#myModal_<?php echo $coas['StockReturn']['id']; ?>" href="#null"><?php echo h($coas['StockReturn']['return_id']); ?></a>&nbsp;</td>
					<td><?php echo h($coas['StockReturn']['type']); ?>&nbsp;</td>
					<td><?php echo $coas['NappUser']['name'].' ('.$coas['NappUser']['lname'].')'; ?>&nbsp;</td>	
					<td>
					<?php if($coas['StockReturn']['qc_ftir'] == 1){ ?>
						<a  class="label label-success" href="<?php echo SITEURL.'stocks/status/0/'.$coas['StockReturn']['id'].'/'.$coas['StockReturn']['type']; ?>">Yes</a>	
					<?php }else{ ?>
						<a class="label label-danger" href="<?php echo SITEURL.'stocks/status/1/'.$coas['StockReturn']['id'].'/'.$coas['StockReturn']['type']; ?>">No</a>		
					<?php } ?></td>	
                    <td> <?php echo date('d-M-Y h:i a',strtotime($coas['StockReturn']['created'])); ?></td>
					<td>
						<a class="btn btn-mini btn-primary" href="<?php echo SITEURL.'stocks/edit/'.$coas['StockReturn']['id'].'/'.$acctype; ?>" >Edit</a>
						<!--a class="btn btn-mini btn-info" href="<?php echo SITEURL.'dompdf/'.$coas['StockReturn']['pdfname']; ?>" target="blank">Download</a--->
						<a onclick="retrun confirm('Are you sure delete this record?')" class="btn btn-mini btn-danger"  href="<?php echo SITEURL.'stocks/delete/'.$coas['StockReturn']['id'].'/'.$acctype;; ?>" >Delete</a>
					</td>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	
</div>	

<?php 
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

<?php $i++; endforeach; ?>
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