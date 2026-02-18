<?php
$stockreturn = $stockreturn ?? [];
$acctype = $acctype ?? '';
?>
<style>
.btn { margin-bottom: 5px; }
</style>

<div class="page-content">
	<div class="page-header">
		<h1>Duortech <?= h(ucfirst($acctype)) ?> Stock Return Logs</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="example">
					<thead>
						<tr>
							<th></th>
							<th>Return Id</th>
							<th>Customer Type</th>
							<th>Created By</th>
							<th style="width: 145px !important;">FTIR SCAN(yes or no)</th>
							<th>created</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i = 1; foreach ($stockreturn as $coas): ?>
						<tr>
							<td>
								<a href="javascript:void(0);" onclick="openpoup('<?= (int)$coas->id ?>')" title="Comments"><i class="fa fa-comment"></i></a>&nbsp;&nbsp;
								<a href="javascript:void(0);" data-toggle="modal" data-target="#myModal_<?= (int)$coas->id ?>" href="#null"><i class="fa fa-eye"></i></a>
							</td>
							<td><a data-toggle="modal" data-target="#myModal_<?= (int)$coas->id ?>" href="#null"><?= h($coas->return_id ?? '') ?></a>&nbsp;</td>
							<td><?= h($coas->type ?? '') ?>&nbsp;</td>
							<td><?= h(($coas->napp_user->name ?? '') . ' (' . ($coas->napp_user->lname ?? '') . ')') ?>&nbsp;</td>
							<td>
								<?php if ((int)($coas->qc_ftir ?? 0) === 1): ?>
									<a class="label label-success" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_status', 0, $coas->id, $coas->type]) ?>">Yes</a>
								<?php else: ?>
									<a class="label label-danger" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_status', 1, $coas->id, $coas->type]) ?>">No</a>
								<?php endif; ?>
							</td>
							<td><?= $coas->created ? date('d-M-Y h:i a', strtotime($coas->created)) : '' ?></td>
							<td>
								<a onclick="return confirm('Are you sure delete this record?');" class="btn btn-mini btn-danger" href="<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_delete', $coas->id, $acctype]) ?>">Delete</a>
							</td>
						</tr>
						<?php $i++; endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<?php foreach ($stockreturn as $stockreturns): ?>
<div id="myModal_<?= (int)$stockreturns->id ?>" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Return Id: <?= h($stockreturns->return_id ?? '') ?></h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover" id="simple-table">
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
									<?php
									$items = $stockreturns->stock_return_data ?? [];
									foreach ($items as $StockReturnDatas):
										$d = is_object($StockReturnDatas) ? $StockReturnDatas : (object)$StockReturnDatas;
									?>
									<tr>
										<td><?= $d->date ?? '' ? date('d-M-Y', strtotime($d->date)) : '' ?></td>
										<td><?= h($d->customer ?? '') ?></td>
										<td><?= h($d->items ?? '') ?></td>
										<td><?= h($d->reason ?? '') ?></td>
										<td><?= h($d->conditions ?? '') ?></td>
										<td><?= h($d->batch ?? '') ?></td>
										<td><?= h($d->received ?? '') ?></td>
									</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endforeach; ?>

<span data-toggle="modal" data-target="#myModal_new" id="myModalNew"><i></i></span>
<div id="myModal_new" class="modal fade" role="dialog">
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
});
function openpoup(id) {
	var url = '<?= $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_comment', '']) ?>' + id;
	$('#abc_frame').attr('src', url);
	$("#myModalNew").trigger('click');
}
</script>
