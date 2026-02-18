<div class="page-content">
		<div class="page-header">
			<h1>Material List <?php echo $this->Html->link('Add New',array('controller' => 'materials','action' => 'admin_add'),array('class'=>'btn btn-info btn-xs top-button')); ?></h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example">
				<thead>
				<tr>				
					<th>Unique Code</th>					
					<th>Material Type</th>
					<th>Weight/dimensions</th>			
					<th>Quantity</th>									
					<th>Description</th>									
					<th>created</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
					<?php 
				
					foreach ($materials as $material): ?>
					<tr>								
					<td>#<?php echo h($material['Material']['id']); ?>&nbsp;</td>
					<td><?php echo h($material['Material']['material_type']); ?>&nbsp;</td>
					<td><?php echo h($material['Material']['weight']); ?>&nbsp;</td>
					<td><?php echo h($material['Material']['quantity']); ?>&nbsp;</td>					
					<td><?php echo h($material['Material']['description']); ?>&nbsp;</td>					
                    <td> <?php echo date('d-M-Y h:i a',strtotime($material['Material']['created'])); ?></td>
					<td>
					<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $material['Material']['id']),array('class'=>'btn btn-mini btn-info')); ?>
					<a href="javascript:void()" onclick="qrcode('<?php echo $material['Material']['id']; ?>')" class="btn btn-mini btn-danger">QR Code</a>
					</td>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
		
</div>	
<a href="javascript:void"  data-toggle="modal" data-target="#mySharedModals" id="linkmySharedModald">&nbsp;</a>
<div id="mySharedModals" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content" style="text-align: center;">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Scan This QR Code</h4>
	  </div>
	  <div class="modal-body" style="text-align:center;" >
		<iframe frameborder="0" id="iframe-id" scrolling="yes" src="" style="width: 100%;height: 200px; margin-left: 33%;" ></iframe>	
	  </div>	 
	</div>
  </div>
</div>
<script>
	$(document).ready(function() {
		$('#example').DataTable();
	} );
	function qrcode(argu){
		var url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://www.durotechindustries.com.au/materials/readqrcode/'+argu;
		
		$('#iframe-id').attr('src', url);
		$("#linkmySharedModald").trigger('click');
	}	
</script>	