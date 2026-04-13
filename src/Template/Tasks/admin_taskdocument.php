<div class="page-content">
	<div class="page-header">
		<h1>DuroLab:
			<?php
			$taskId = $taskArr ? $taskArr->task_id : ($task_id ?? '');
			if ($taskId !== '') {
				echo '<a href="' . h($this->Url->build(['action' => 'admin_uploaddoc', $taskId], true)) . '" class="btn btn-mini btn-info">Upload Document</a>';
			}
			?>
			<a style="float:right;" href="<?= $this->Url->build(['action' => 'admin_index']) ?>" class="btn btn-mini btn-inverse">Back</a>
		</h1>
	</div>

	<?php if ($taskArr): ?>
	<p><span class="label label-danger">Task:</span> <br/><b><?= h($taskArr->title ?? '') ?></b></p>
	<p><span class="label label-danger">Description:</span><br/>
	<?php if (!empty($taskArr->description)): ?>
		<div class="task-description"><?= $taskArr->description ?></div>
	<?php else: ?>
		—
	<?php endif; ?>
	</p>
	<?php endif; ?>

	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table">
				<thead>
				<tr>
					<th>Uploaded By</th>
					<th>Document</th>
					<th>File Type</th>
					<th>Created</th>
				</tr>
				</thead>
				<tbody>
					<?php
					$taskDocuments = ($taskArr && isset($taskArr->task_documents)) ? $taskArr->task_documents : [];
					$i = 1;
					foreach ($taskDocuments as $doc):
						$adminId = $doc->admin_id ?? null;
						$nappUser = $doc->napp_user ?? null;
						$user = $doc->user ?? null;
						$uploader = '';
						if ((int)$adminId === 0 && $nappUser) {
							$uploader = '<span class="label label-info">' . h(($nappUser->name ?? '') . ' ' . ($nappUser->lname ?? '')) . '</span>';
						} else {
							$uploader = '<span class="label label-success">' . h($user->name ?? '') . '</span>';
						}
						$downloadUrl = $this->Url->build(['action' => 'admin_download', $doc->id], true);
					?>
					<tr>
						<td><?= $uploader ?></td>
						<td><a href="<?= h($downloadUrl) ?>" target="_blank">Download Document</a></td>
						<td><?= h($doc->ext ?? '') ?></td>
						<td><?= $doc->created ? format_db_date('d M Y h:i a', $doc->created) : '' ?></td>
					</tr>
					<?php $i++; endforeach; ?>
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
