<div class="page-content">
		<div class="page-header">
			<h1>Material List</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example" >
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
				
					foreach ($materials as $material):
						$m = is_object($material) ? $material : (object)$material;
						$mid = $m->id ?? $material['Material']['id'] ?? '';
						$mtype = $m->material_type ?? $material['Material']['material_type'] ?? '';
						$mweight = $m->weight ?? $material['Material']['weight'] ?? '';
						$mqty = $m->quantity ?? $material['Material']['quantity'] ?? '';
						$mdesc = $m->description ?? $material['Material']['description'] ?? '';
						$mcreated = $m->created ?? $material['Material']['created'] ?? '';
					?>
					<tr>
					<td>#<?php echo h($mid); ?>&nbsp;</td>
					<td><?php echo h($mtype); ?>&nbsp;</td>
					<td><?php echo h($mweight); ?>&nbsp;</td>
					<td><?php echo h($mqty); ?>&nbsp;</td>
					<td><?php echo h($mdesc); ?>&nbsp;</td>
					<td><?php echo $mcreated ? date('d-M-Y h:i a', strtotime($mcreated)) : ''; ?></td>
					<td>
					<a href="javascript:void(0)" onclick="qrcode('<?php echo h($mid); ?>')" class="btn btn-xs btn-danger">QR Code</a>
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
		var baseUrl = '<?php echo $this->Url->build("/materials/readqrcode/", true); ?>';
		var url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(baseUrl + argu);
		
		$('#iframe-id').attr('src', url);
		$("#linkmySharedModald").trigger('click');
	}	
</script>	