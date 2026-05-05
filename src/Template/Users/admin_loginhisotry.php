<div class="page-content">
		<div class="page-header">
			<h1>Login History Logs</h1>
		</div>

	<?= $this->Flash->render() ?>
	<?= $this->Form->create(null, ['url' => ['action' => 'admin_loginhisotry'], 'id' => 'bulk-delete-loginhistory-form']) ?>
	<input type="hidden" name="delete_scope" id="delete-scope-login-history" value="selected">
	<div class="row" style="margin-bottom:12px;">
		<div class="col-xs-12 col-sm-8">
			<button type="submit" class="btn btn-danger btn-sm" id="bulk-delete-loginhistory-btn">
				<i class="fa fa-trash"></i> Delete
			</button>
		</div>
		<div class="col-xs-12 col-sm-4" style="text-align:right; margin-top:6px;">
			<label style="font-weight:normal; cursor:pointer;">
				<input type="checkbox" id="delete-all-pages-login-history"> Delete all pages (all records)
			</label>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th style="width:42px; text-align:center;">
						<input type="checkbox" id="select-all-login-history" title="Select all">
					</th>
					<th><?php echo $this->Paginator->sort('id'); ?></th>					
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('email'); ?></th>			
					<th><?php echo $this->Paginator->sort('role'); ?></th>			
					<th><?php echo $this->Paginator->sort('Login Time'); ?></th>									
					<th><?php echo $this->Paginator->sort('Logout Time'); ?></th>	
					
				</tr>
				</thead>
				<tbody>
					<?php
					foreach ($LoginHistoryArr as $LoginHistoryArrs):
						if (($LoginHistoryArrs->role ?? '') === 'Admin' && $LoginHistoryArrs->user) {
							$name = $LoginHistoryArrs->user->name ?? '';
							$email = $LoginHistoryArrs->user->email ?? '';
						} else {
							$nu = $LoginHistoryArrs->napp_user;
							$name = $nu ? trim(($nu->name ?? '') . ' ' . ($nu->lname ?? '')) : '';
							$email = $nu ? ($nu->email ?? '') : '';
						}
					?>
					<tr>
						<td style="text-align:center;">
							<input
								type="checkbox"
								class="login-history-row-check"
								name="selected_ids[]"
								value="<?php echo (int)$LoginHistoryArrs->id; ?>"
							>
						</td>
						<td>#<?php echo h($LoginHistoryArrs->id); ?>&nbsp;</td>
						<td><?php echo h($name); ?>&nbsp;</td>
						<td><?php echo h($email); ?>&nbsp;</td>
						<td><?php echo h($LoginHistoryArrs->role); ?>&nbsp;</td>
						<td><?php echo h($LoginHistoryArrs->logintime); ?>&nbsp;</td>
						<td><?php
						$logout = $LoginHistoryArrs->logouttime ?? '';
						if ($logout && $logout !== '0000-00-00 00:00:00') {
							echo h($logout);
						} else {
							echo '-';
						}
						?>&nbsp;</td>	
					
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter(array('format' => __('showing {{current}} records out of {{count}} entries')));?>	</div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><?php
				echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));?></li>
				
				<li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><?php echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));?></li>
				
			</ul>
			</div>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>		
<script>
(function () {
	var selectAll = document.getElementById('select-all-login-history');
	var deleteAllPages = document.getElementById('delete-all-pages-login-history');
	var deleteScope = document.getElementById('delete-scope-login-history');
	var form = document.getElementById('bulk-delete-loginhistory-form');
	function getRowChecks() {
		return Array.prototype.slice.call(document.querySelectorAll('.login-history-row-check'));
	}
	if (selectAll) {
		selectAll.addEventListener('change', function () {
			getRowChecks().forEach(function (cb) { cb.checked = selectAll.checked; });
		});
	}
	getRowChecks().forEach(function (cb) {
		cb.addEventListener('change', function () {
			if (deleteAllPages && deleteAllPages.checked) {
				deleteAllPages.checked = false;
				if (deleteScope) { deleteScope.value = 'selected'; }
			}
			var checks = getRowChecks();
			var checkedCount = checks.filter(function (x) { return x.checked; }).length;
			if (selectAll) {
				selectAll.checked = checks.length > 0 && checkedCount === checks.length;
				selectAll.indeterminate = checkedCount > 0 && checkedCount < checks.length;
			}
		});
	});
	if (deleteAllPages) {
		deleteAllPages.addEventListener('change', function () {
			var isAll = !!deleteAllPages.checked;
			if (deleteScope) { deleteScope.value = isAll ? 'all' : 'selected'; }
			if (isAll) {
				if (selectAll) {
					selectAll.checked = false;
					selectAll.indeterminate = false;
				}
				getRowChecks().forEach(function (cb) { cb.checked = false; });
			}
		});
	}
	if (form) {
		form.addEventListener('submit', function (e) {
			var isAllPages = deleteAllPages && deleteAllPages.checked;
			if (deleteScope) { deleteScope.value = isAllPages ? 'all' : 'selected'; }
			if (isAllPages) {
				if (!confirm('Delete ALL login history records from all pages?')) {
					e.preventDefault();
				}
				return;
			}
			var anyChecked = getRowChecks().some(function (cb) { return cb.checked; });
			if (!anyChecked) {
				e.preventDefault();
				alert('Please select at least one record to delete.');
				return;
			}
			if (!confirm('Delete selected login history records?')) {
				e.preventDefault();
			}
		});
	}
})();
</script>