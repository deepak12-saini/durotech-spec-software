	<style>
		.btn{ margin-bottom:5px; }
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>DuroEzy Specification
			<?php echo $this->Html->link('Create New Spec',['controller' => 'Mailers','action' => 'admin_create_dwps'],['class'=>'btn btn-info btn-xs top-button']); ?>
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('tracknumber'); ?></th>					
					<th><?php echo $this->Paginator->sort('Send Name'); ?></th>					
					<th><?php echo $this->Paginator->sort('name','Name/Attn'); ?></th>
					<th><?php echo $this->Paginator->sort('Email'); ?></th>
					<th><?php echo $this->Paginator->sort('Company'); ?></th>
					<th><?php echo $this->Paginator->sort('address'); ?></th>
					<th><?php echo $this->Paginator->sort('specification'); ?></th>
					<th><?php echo $this->Paginator->sort('date'); ?></th>
					<!-- <th><?php echo $this->Paginator->sort('type'); ?></th>					
					<th><?php echo $this->Paginator->sort('subject'); ?></th>				 -->	
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<?php 
				foreach ($mailers as $mailer):
				$pdfUrl = !empty($mailer->pdf_attachment)
					? (rtrim(SITEURL, '/') . '/' . ltrim($mailer->pdf_attachment, '/'))
					: null;
				?>
					<tr>
				<td>#<?php echo h($mailer->tracknumber ?? ''); ?>&nbsp;</td>
				<td><?php echo !empty($mailer->user) ? h($mailer->user->name . '(' . $mailer->user->username . ')') : '-'; ?>&nbsp;</td>
				<td><?php echo h($mailer->name ?? ''); ?>&nbsp;</td>
				<td><?php echo h($mailer->email ?? ''); ?>&nbsp;</td>					
				<td><?php echo h($mailer->company ?? ''); ?>&nbsp;</td>
				<td><?php echo h($mailer->address ?? ''); ?>&nbsp;</td>
				<td><?php echo h($mailer->specification ?? ''); ?>&nbsp;</td>
				<td><?php echo h($mailer->date ?? ''); ?>&nbsp;</td>
					<!-- <td><?php if($mailer['Mailer']['type'] == 3){ echo 'External Liquid WPM'; } ?></td>					
					<td><?php echo h($mailer['Mailer']['subject']); ?></td>			 -->		
                    <td> <?php echo !empty($mailer->created) ? date('d-M-Y h:i a',strtotime((string)$mailer->created)) : ''; ?></td>
					<td>
						<a class="btn btn-mini btn-primary" href="<?php echo SITEURL.'admin/mailers/editv/'.$mailer->id; ?>" >Edit</a>
						<?php if ($pdfUrl): ?>
							<a class="btn btn-mini btn-info" href="<?php echo $pdfUrl; ?>" target="blank">Download</a>
						<?php else: ?>
							<span class="btn btn-mini btn-default" title="PDF not generated">No PDF</span>
						<?php endif; ?>
						<a onclick="retrun confirm('Are you sure send email?')" class="btn btn-mini btn-danger"  href="<?php echo SITEURL.'admin/mailers/sendemail/'.$mailer->id; ?>" >Send Mail</a>
					</td>
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter(array(
'format' => __('showing {{start}} to {{end}} records out of {{count}} entries')));?>	</div>
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