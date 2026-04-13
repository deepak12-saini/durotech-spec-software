	<script src="<?= h($this->Url->build('/', true)) ?>ckeditor/ckeditor.js"></script>

	<div class="page-content">
		<div class="page-header">
			<div class="right_btn pull-right"><a href="<?= $this->Url->build(['action' => 'admin_index']) ?>" class="btn btn-inverse">Back</a></div>
			<h1>DuroLab <small><i class="ace-icon fa fa-angle-double-right"></i> Comments</small></h1>
		</div>

	<div>
		<div class="col-xs-9">
			<div class="row">
			<div class="col-xs-12" style="border-bottom: 1px solid #e2e2e2 !important;border-left: 1px solid #e2e2e2 !important;border-right: 1px solid #e2e2e2 !important;">
			<?= $this->Form->create(null, ['class' => 'form-horizontal', 'type' => 'file']); ?>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Comments: <br/><small></small></label>
					<div class="col-sm-9">
						<?= $this->Form->control('comment', ['type' => 'textarea', 'label' => false, 'class' => 'col-xs-10 col-sm-5', 'placeholder' => 'Write your comments here']); ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Upload Document: </label>
					<div class="col-sm-9">
						<input type="file" name="documents" class="col-xs-10 col-sm-5">
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-9">
						<?= $this->Form->button('Submit', ['class' => 'btn btn-xs btn-success', 'id' => 'add_ser_prd_btn']); ?>
						<?= $this->Html->link('Cancel', 'javascript:window.history.back();', ['class' => 'btn btn-xs btn-danger']); ?>
					</div>
				</div>
			<?= $this->Form->end(); ?>
			</div>
		</div>	
		
			
		<div id="user-profile-12" class="user-profile row-fluid">
		<div class="span9">								

			<div class="widget-box transparent">
				<div class="widget-header widget-header-small">
					<h4 class="blue smaller">
						<i class="icon-rss orange"></i>
						Recent Activities
					</h4>

				</div>

				<div class="widget-body">
					<div class="widget-main padding-8">
						<div id="profile-feed-1" class="profile-feed">
							<?php
							$taskComments = $TaskAssign ? ($TaskAssign->task_comments ?? []) : [];
							foreach ($taskComments as $c):
								$name = '';
								if ((int)($c->type ?? 0) === 1 && !empty($c->user)) {
									$name = $c->user->name ?? '';
								} elseif (!empty($c->napp_user)) {
									$name = trim(($c->napp_user->name ?? '') . ' ' . ($c->napp_user->lname ?? ''));
								}
								$commentId = $c->id ?? null;
								$created = $c->created ?? null;
							?>
							<div class="profile-activity clearfix">
								<div>
									<i class="pull-left thumbicon icon-picture btn-info no-hover"></i>
									<a class="user" href="#"><?= h($name) ?>: </a>
									<?= h($c->comment ?? '') ?>
									<?php if (!empty($c->documents)) { ?>
										<a href="<?= h($this->Url->build(['action' => 'admin_commentdownload', base64_encode(base64_encode((string)$commentId))], true)) ?>"><i class="fa fa-download"></i></a>
									<?php } ?>
									<div class="time">
										<i class="icon-time bigger-110"></i>
										<?= $created ? format_db_date('d M Y h:i a', $created) : '' ?>
									</div>
								</div>
								<div class="tools action-buttons">
									<a href="#" class="blue"><i class="icon-pencil bigger-125"></i></a>
									<a href="#" class="red"><i class="icon-remove bigger-125"></i></a>
								</div>
							</div>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>

		</div>
		</div>
		</div>
		<div class="col-xs-3">
		<div class="span6 widget-container-span ui-sortable">
		<div class="widget-box">
			<div class="widget-header">
				<h5>Task Documents <?php
				$taskIdForUrl = $TaskAssign ? $TaskAssign->task_id : ($task_id ?? '');
				if ($taskIdForUrl !== '') {
					echo '<a href="' . h($this->Url->build(['action' => 'admin_uploaddoc', $taskIdForUrl], true)) . '" class="btn btn-mini btn-warning" style="float:right;">Upload Doc</a>';
				}
				?></h5>
			</div>
			<div class="widget-body">
				<div class="widget-main">
					<?php
					$taskDocuments = ($TaskAssign && isset($TaskAssign->task_documents)) ? $TaskAssign->task_documents : [];
					if (!empty($taskDocuments)) {
						$i = 0;
						foreach ($taskDocuments as $doc) {
							$docId = $doc->id ?? $doc['id'] ?? null;
							$adminId = $doc->admin_id ?? $doc['admin_id'] ?? null;
							$nappUser = $doc->napp_user ?? $doc['NappUser'] ?? null;
							$user = $doc->user ?? $doc['User'] ?? null;
							$uploaderName = '';
							if ((int)$adminId === 0 && $nappUser) {
								$uploaderName = '<span class="label label-info">' . h(($nappUser->name ?? $nappUser['name'] ?? '') . ' ' . ($nappUser->lname ?? $nappUser['lname'] ?? '')) . '</span>';
							} else {
								$uploaderName = '<span class="label label-success">' . h($user->name ?? $user['name'] ?? '') . '</span>';
							}
							$created = $doc->created ?? $doc['created'] ?? null;
							$createdStr = $created ? format_db_date('d M Y h:i a', $created) : '';
							$cls = ($i % 2 === 0) ? 'alert alert-info' : 'alert alert-success';
							$downloadUrl = $this->Url->build(['action' => 'admin_download', $docId], true);
					?>
					<p class="<?= $cls ?>">
						<a href="<?= h($downloadUrl) ?>" target="_blank">Download Document</a>&nbsp;<br>
						<small><?= $uploaderName ?> (<?= $createdStr ?>)</small>
					</p>
					<?php $i++; }
					} ?>
				</div>
			</div>
		</div>
		</div>
		</div>
	</div>	
</div>	
<script type="text/javascript">
jQuery(function(){ 

	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',			
	});
	
	$("#title").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter  employe id"
	}); $("#assignedto").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select employee"
	}); $("#assignedby").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please eneter assigned by user"
	}); 
	
	
});
</script>
