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
					<td data-order="<?php echo (int)$mid; ?>">#<?php echo h($mid); ?>&nbsp;</td>
					<td><?php echo h($mtype); ?>&nbsp;</td>
					<td><?php echo h($mweight); ?>&nbsp;</td>
					<td><?php echo h($mqty); ?>&nbsp;</td>
					<td><?php echo h($mdesc); ?>&nbsp;</td>
					<td><?php echo $mcreated ? format_db_date('d-M-Y h:i a', $mcreated) : ''; ?></td>
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
		<iframe frameborder="0" id="iframe-id" scrolling="no" src="" style="width:180px;height:180px;border:0;margin:0 auto;display:block;"></iframe>
		<div style="margin-top:14px;padding:0 10px;text-align:left;max-width:100%;">
			<label for="material-readqrcode-url" style="font-weight:normal;font-size:12px;display:block;margin-bottom:4px;">Or copy this link and open it in a browser:</label>
			<div class="input-group input-group-sm">
				<input type="text" readonly="readonly" id="material-readqrcode-url" class="form-control" value="" style="font-size:11px;" />
				<span class="input-group-btn">
					<button type="button" class="btn btn-default" id="material-readqrcode-copy" title="Copy to clipboard">Copy</button>
				</span>
			</div>
			<a id="material-readqrcode-open" href="#" target="_blank" rel="noopener noreferrer" class="btn btn-xs btn-info" style="margin-top:8px;">Open in new tab</a>
		</div>
	  </div>	 
	</div>
  </div>
</div>
<script>
	$(document).ready(function() {
		$('#example').DataTable({
			order: [[0, 'desc']],
			columnDefs: [{ orderable: false, targets: 6 }]
		});
		$('#material-readqrcode-copy').on('click', function() {
			var $inp = $('#material-readqrcode-url');
			var text = $inp.val();
			if (!text) { return; }
			if (navigator.clipboard && window.isSecureContext) {
				navigator.clipboard.writeText(text).then(function() {
					$('#material-readqrcode-copy').text('Copied!');
					setTimeout(function() { $('#material-readqrcode-copy').text('Copy'); }, 2000);
				});
				return;
			}
			$inp.focus();
			$inp[0].setSelectionRange(0, text.length);
			try {
				document.execCommand('copy');
				$('#material-readqrcode-copy').text('Copied!');
				setTimeout(function() { $('#material-readqrcode-copy').text('Copy'); }, 2000);
			} catch (e) {}
		});
	});
	function qrcode(argu) {
		var baseUrl = '<?php echo $this->Url->build("/materials/readqrcode/", true); ?>';
		var orderPageUrl = baseUrl + encodeURIComponent(argu);
		var qrImg = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(orderPageUrl);
		$('#iframe-id').attr('src', qrImg);
		$('#material-readqrcode-url').val(orderPageUrl);
		$('#material-readqrcode-open').attr('href', orderPageUrl);
		$('#material-readqrcode-copy').text('Copy');
		$('#linkmySharedModald').trigger('click');
	}
</script>	