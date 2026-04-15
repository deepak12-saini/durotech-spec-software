<div class="page-content">
		<div class="page-header">
			<h1>Visitor Register List</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="example">
				<thead>
				<tr>				
					<th>Id</th>					
					<th>Visitor Pass Id</th>
					<th>Date</th>
					<th>Visitor's Name</th>
					<th>Visitor For?</th>
					<th>Time In</th>
					<th>Time Out</th>
					<th>Initial</th>
					<th>Photo</th>
					<th>Actions</th>
					
				</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					if (!empty($visitors)) {
						foreach ($visitors as $v) {
							$row = is_object($v) ? $v->toArray() : (isset($v['Visitor']) ? $v['Visitor'] : $v);
					?>
					<tr>
						<td><?php echo $i; ?>&nbsp;</td>
						<td><?php echo h($row['visitor_card_id'] ?? ''); ?>&nbsp;</td>
						<td><?php echo !empty($row['date']) ? format_db_date('d/m/Y', $row['date']) : '—'; ?>&nbsp;</td>
						<td><?php echo h($row['visitor_name'] ?? ''); ?>&nbsp;</td>
						<td><?php echo h($row['visit_for'] ?? ''); ?>&nbsp;</td>
						<td><?php echo (!empty($row['timein']) && $row['timein'] != '0000-00-00 00:00:00') ? format_db_date('h:i a', $row['timein']) : '--'; ?></td>
						<td><?php echo (!empty($row['timeout']) && $row['timeout'] != '0000-00-00 00:00:00') ? format_db_date('h:i a', $row['timeout']) : '--'; ?></td>
						<td><?php if (!empty($row['sign'])) { ?> <img src="<?php echo SITEURL . 'signature/' . h($row['sign']); ?>" width="100"/> <?php } ?>&nbsp;</td>
						<td><?php if (!empty($row['image'])) { ?> <a target="_blank" href="<?php echo SITEURL . 'signature/' . h($row['image']); ?>"><img src="<?php echo SITEURL . 'signature/' . h($row['image']); ?>" width="100"/></a> <?php } ?>&nbsp;</td>
						<td>
							<?php
							$timeout = $row['timeout'] ?? '';
							$isActive = empty($timeout) || $timeout === '0000-00-00 00:00:00';
							?>
							<?php if ($isActive): ?>
								<a class="btn btn-xs btn-warning" onclick="return confirm('Punch out this visitor?')" href="<?php echo SITEURL . 'fronts/punchout/' . base64_encode((string)($row['id'] ?? '')); ?>">Punch Out</a>
							<?php endif; ?>
							<a class="btn btn-xs btn-info" href="<?php echo SITEURL . 'admin/mailers/visitor_view/' . (int)($row['id'] ?? 0); ?>">View</a>
							<?php echo $this->Form->postLink('Delete', SITEURL . 'admin/mailers/visitor_delete/' . (int)($row['id'] ?? 0), ['class' => 'btn btn-xs btn-danger', 'confirm' => 'Delete this visitor record?']); ?>
						</td>
					</tr>
					<?php
							$i++;
						}
					} else {
					?>
					<tr>
						 <td colspan="10" style="text-align:center; color:red; font-weight:bold;">No Visit Today</td>
					</tr>
					<?php } ?>

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
	
</script>