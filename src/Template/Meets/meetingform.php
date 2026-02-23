	<style>
		.btn{ margin-bottom:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Mintue Meeting List
			<?php echo $this->Html->link('Add New', ['controller' => 'Meets', 'action' => 'informalmeeting'], ['class' => 'btn btn-info btn-xs top-button']); ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
				<thead>
				<tr>
				
					<th>Refer Id</th>		
					<th>Date</th>							
					<th>Time</th>							
					<th>Meeting Created By</th>	
					<th>Minute Taker</th>	
					<th>Facilitator</th>	
					<th>Time Keeper</th>	
					<th>Please Read</th>	
					<th>Please Bring</th>	
					<th></th>	
					
				</tr>
				</thead>
				<tbody>
					<?php 					
					foreach ($MintueMeetAll as $MintueMeetAllS):					
					?>
					<tr>
						<td><a href="<?php echo $this->Url->build(['controller' => 'Meets', 'action' => 'view', $MintueMeetAllS['MintueMeet']['id']]); ?>"><?php echo h($MintueMeetAllS['MintueMeet']['referid']); ?></a>&nbsp;</td>
						<td><?php echo h($MintueMeetAllS['MintueMeet']['date']); ?>&nbsp;</td>
						<td><?php echo h($MintueMeetAllS['MintueMeet']['time']); ?>&nbsp;</td>
						<td><?php echo h($MintueMeetAllS['MintueMeet']['meeting_created_by']); ?>&nbsp;</td>
						<td><?php echo h($MintueMeetAllS['MintueMeet']['minute_taker']); ?>&nbsp;</td>
						<td><?php echo h($MintueMeetAllS['MintueMeet']['facilitator']); ?>&nbsp;</td>
						<td><?php echo h($MintueMeetAllS['MintueMeet']['time_keeper']); ?>&nbsp;</td>
						<td><?php echo h($MintueMeetAllS['MintueMeet']['please_read']); ?>&nbsp;</td>
						<td><?php echo h($MintueMeetAllS['MintueMeet']['please_bring']); ?>&nbsp;</td>
						<td>
						<?php if(!empty($MintueMeetAllS['MintueMeet']['pdffile'])){ ?>
							<a target="_blank" class="btn btn-mini btn-success" href="<?php echo (defined('SITEURL') ? SITEURL : '') . 'pdf/FPDI/' . ($MintueMeetAllS['MintueMeet']['pdffile'] ?? ''); ?>">Open PDF</a>
							<a class="btn btn-mini btn-primary" href="<?php echo $this->Url->build(['controller' => 'Meets', 'action' => 'sendpdf', $MintueMeetAllS['MintueMeet']['referid']]); ?>">Send PDF</a>
						<?php }else{ echo 'N/A'; } ?>
						</td>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
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