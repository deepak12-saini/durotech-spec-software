<div class="page-content">
	<div class="page-header">
		<h1>National Association of Testing Authorities <small>&gt;&gt; Instrument List</small>
			<a href="<?php echo $this->Url->build(['controller' => 'Natas', 'action' => 'index']); ?>" class="btn btn-xs btn-inverse">Back to NATA list</a>
			<a href="<?php echo $this->Url->build(['controller' => 'Natas', 'action' => 'addevent']); ?>" class="btn btn-xs btn-info">Add event</a>
		</h1>
	</div>
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="simple-table">
					<thead>
					<tr>
						<th>Id</th>
						<th>Unique Code</th>
						<th>Instrument Name</th>
						<th>Make Model Type</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($ClientTypeArr as $ClientTypeArrs): ?>
					<tr>
						<td>#<?php echo h($ClientTypeArrs['NataCategory']['id']); ?>&nbsp;</td>
						<td>#<?php echo h($ClientTypeArrs['NataCategory']['unique_id']); ?>&nbsp;</td>
						<td><?php echo h($ClientTypeArrs['NataCategory']['name']); ?>&nbsp;</td>
						<td><?php echo h($ClientTypeArrs['NataCategory']['make_model_type']); ?>&nbsp;</td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
