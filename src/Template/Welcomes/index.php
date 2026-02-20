	<style>
		.btn{ margin-bottom:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Welcome Mailer
			<?php echo $this->Html->link('Send Welcome Mailer',array('controller' => 'welcomes','action' => 'send'),array('class'=>'btn btn-info btn-xs top-button')); ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('id'); ?></th>							
					<th><?php echo $this->Paginator->sort('tracknumber'); ?></th>							
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('email','Email'); ?></th>					
					<th><?php echo $this->Paginator->sort('subject'); ?></th>					
					<th><?php echo $this->Paginator->sort('Price List'); ?></th>					
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php
						$i = 1;
						foreach ($mailers as $mailer):
							// CakePHP 3: entity; CakePHP 2: array
							$w = is_object($mailer) ? $mailer : ($mailer['Welcome'] ?? []);
							$trackNum = is_object($mailer) ? $mailer->tracknumber : ($w['tracknumber'] ?? '');
							$pdffile = is_object($mailer) ? ($mailer->pdffile ?? '') : ($w['pdffile'] ?? '');
							$pdffilename = $trackNum . '.pdf';
							$tracknumberEnc = base64_encode(base64_encode($pdffilename));
							$mid = is_object($mailer) ? $mailer->id : ($w['id'] ?? '');
					?>
					<tr>
					<td><?php echo $i; ?>&nbsp;</td>
					<td>#<?php echo h($trackNum); ?>&nbsp;</td>
					<td><?php echo h(is_object($mailer) ? $mailer->name : ($w['name'] ?? '')); ?>&nbsp;</td>
					<td><?php echo h(is_object($mailer) ? $mailer->email : ($w['email'] ?? '')); ?>&nbsp;</td>
					<td><?php echo h(is_object($mailer) ? $mailer->subject : ($w['subject'] ?? '')); ?>&nbsp;</td>
					<td><?php echo h(is_object($mailer) ? ($mailer->label ?? '') : ($w['label'] ?? '')); ?>&nbsp;</td>
					<td><?php echo date('d-M-Y h:i a', strtotime(is_object($mailer) ? $mailer->created : ($w['created'] ?? 'now'))); ?></td>
					<td>
						<?php echo $this->Html->link('Edit', ['controller' => 'Welcomes', 'action' => 'edit', $mid], ['class' => 'btn btn-mini btn-primary']); ?>
						<?php if ($pdffile): ?><a class="btn btn-mini btn-info" href="<?php echo SITEURL . 'welcomes/download/' . h($pdffile); ?>" target="_blank">Download</a><?php endif; ?>
						<a onclick="return confirm('Are you sure send email?');" class="btn btn-mini btn-danger" href="<?php echo SITEURL . 'welcomes/sendemails/' . h($mid); ?>">Send Mail</a>
					</td>
					</tr>
					<?php $i++; endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter(array(
'format' => __('showing {{current}} records out of {{count}} entries')));?>	</div>
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
</div>		