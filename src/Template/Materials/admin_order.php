<div class="page-content">
		<div class="page-header">
			<h1><?php echo $type; ?> Material Order Request
				
			<!--form action="" method="post" style="float:right;">
				
				<input type="search" name="search" placeholder="Search By Requested id" value="<?php echo $search; ?>" style="width:220px">
				<input type="submit"  class="btn btn-xs btn-primary" value="Search">
				
			</form-->
				
			</h1>
		</div>
	<?php if($type == 'Completed'){ ?>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="material-orders-completed" >
				<thead>
				<tr>				
					<th>RequestId</th>					
					<th>DT PO Number</th>
					<th>Material Type</th>
					<th>WeightDimensions</th>			
					<th>Quantity Required</th>									
					<th>Request By</th>	
					<th>status</th>		
					<th>Last Update</th>
					<th>Order Requested</th>
					
				</tr>
				</thead>
				<tbody>
					<?php 
				
					foreach ($MaterialOrder as $MaterialOrders):
						$o = is_object($MaterialOrders) ? $MaterialOrders : (object)($MaterialOrders['MaterialOrder'] ?? $MaterialOrders);
						$oid = $o->id ?? $MaterialOrders['MaterialOrder']['id'] ?? '';
						$orderId = $o->order_id ?? $MaterialOrders['MaterialOrder']['order_id'] ?? '';
						$dtPo = $o->dt_po_number ?? $MaterialOrders['MaterialOrder']['dt_po_number'] ?? '';
						$mtype = $o->material_type ?? $MaterialOrders['MaterialOrder']['material_type'] ?? '';
						$weight = $o->weight ?? $MaterialOrders['MaterialOrder']['weight'] ?? '';
						$qty = $o->quantity ?? $MaterialOrders['MaterialOrder']['quantity'] ?? '';
						$name = $o->name ?? $MaterialOrders['MaterialOrder']['name'] ?? '';
						$st = (int)($o->status ?? $MaterialOrders['MaterialOrder']['status'] ?? 0);
						$lastmod = $o->lastmodification ?? $MaterialOrders['MaterialOrder']['lastmodification'] ?? '';
						$created = $o->created ?? $MaterialOrders['MaterialOrder']['created'] ?? '';
					?>
					<tr>
					<td data-order="<?php echo (int)$oid; ?>">#<?php echo h($orderId); ?>&nbsp;</td>
					<td><?php echo h($dtPo); ?>&nbsp;</td>
					<td><?php echo h($mtype); ?>&nbsp;</td>
					<td><?php echo h($weight); ?>&nbsp;</td>
					<td><?php echo h($qty); ?>&nbsp;</td>
					<td><?php echo h($name); ?>&nbsp;</td>
					<td>
						<?php if ($st == 0) { ?><span class="label label-danger">Pending</span>
						<?php } elseif ($st == 1) { ?><span class="label label-warning">Accepted</span>
						<?php } elseif ($st == 2) { ?><span class="label label-success">Completed</span><?php } ?>
					</td>
					<td><?php echo $lastmod ? format_db_date('d-M-Y h:i a', $lastmod) : ''; ?></td>
					<td><?php echo $created ? format_db_date('d-M-Y h:i a', $created) : ''; ?></td>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>
			</div>
		</div>
	</div>
	<?php } else { ?>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="material-orders-open" >
				<thead>
				<tr>
					<th>RequestId</th>
					<th>Material Type</th>
					<th>WeightDimensions</th>
					<th>Quantity Required</th>
					<th>Request By</th>
					<th>status</th>
					<th>Last Update</th>
					<th>Order Requested</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
					<?php
					foreach ($MaterialOrder as $MaterialOrders):
						$o = is_object($MaterialOrders) ? $MaterialOrders : (object)($MaterialOrders['MaterialOrder'] ?? $MaterialOrders);
						$oid = $o->id ?? $MaterialOrders['MaterialOrder']['id'] ?? '';
						$orderId = $o->order_id ?? $MaterialOrders['MaterialOrder']['order_id'] ?? '';
						$mtype = $o->material_type ?? $MaterialOrders['MaterialOrder']['material_type'] ?? '';
						$weight = $o->weight ?? $MaterialOrders['MaterialOrder']['weight'] ?? '';
						$qty = $o->quantity ?? $MaterialOrders['MaterialOrder']['quantity'] ?? '';
						$name = $o->name ?? $MaterialOrders['MaterialOrder']['name'] ?? '';
						$st = (int)($o->status ?? $MaterialOrders['MaterialOrder']['status'] ?? 0);
						$lastmod = $o->lastmodification ?? $MaterialOrders['MaterialOrder']['lastmodification'] ?? '';
						$created = $o->created ?? $MaterialOrders['MaterialOrder']['created'] ?? '';
						$typeLower = is_string($type) ? strtolower($type) : '';
					?>
					<tr>
					<td data-order="<?php echo (int)$oid; ?>">#<?php echo h($orderId); ?>&nbsp;</td>
					<td><?php echo h($mtype); ?>&nbsp;</td>
					<td><?php echo h($weight); ?>&nbsp;</td>
					<td><?php echo h($qty); ?>&nbsp;</td>
					<td><?php echo h($name); ?>&nbsp;</td>
					<td>
						<?php if ($st == 0) { ?><span class="label label-danger">Pending</span>
						<?php } elseif ($st == 1) { ?><span class="label label-warning">Accepted</span>
						<?php } elseif ($st == 2) { ?><span class="label label-success">Completed</span><?php } ?>
					</td>
					<td><?php echo $lastmod ? format_db_date('d-M-Y h:i a', $lastmod) : ''; ?></td>
					<td><?php echo $created ? format_db_date('d-M-Y h:i a', $created) : ''; ?></td>
					<th>
						<?php if ($st == 0) { ?>
							<a href="<?php echo $this->Url->build(['controller' => 'Materials', 'action' => 'admin_status', 1, $oid, $typeLower]); ?>" class="btn btn-xs btn-success">Accept</a>
						<?php } elseif ($st == 1) { ?>
							<a href="<?php echo $this->Url->build(['controller' => 'Materials', 'action' => 'admin_status', 2, $oid, $typeLower]); ?>" class="btn btn-xs btn-success">Complete</a>
						<?php } ?>
					</th>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>	
	<?php } ?>	
	
</div>		
<script>
	$(document).ready(function() {
		if ($('#material-orders-completed').length) {
			$('#material-orders-completed').DataTable({
				order: [[0, 'desc']]
			});
		}
		if ($('#material-orders-open').length) {
			$('#material-orders-open').DataTable({
				order: [[0, 'desc']],
				columnDefs: [{ orderable: false, targets: 8 }]
			});
		}
	});
</script>	