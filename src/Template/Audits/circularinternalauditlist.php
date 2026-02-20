	
	<style>
		.btn{margin-bottom: 5px; }
		.label-danger, .label.label-danger, .badge.badge-danger, .badge-danger {
			margin-bottom: 5px;
		}
	</style>
	
	<div class="page-content">
	<div class="page-header">
		<h1>Circular Internal Audit List &nbsp;&nbsp;&nbsp;
		
		<a href="<?php echo SITEURL.'audits/circularinternalauditadd'; ?>" class="btn btn-mini btn-info">Add Circular Internal Audit </a>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>				
					<th><?php echo $this->Paginator->sort('audi_no','Audti Number'); ?></th>								
					<th><?php echo $this->Paginator->sort('from_mr'); ?></th>
					<th><?php echo $this->Paginator->sort('to_mr'); ?></th>
					<th><?php echo $this->Paginator->sort('opening_held_on','Opening Held On'); ?></th>
					<th><?php echo $this->Paginator->sort('opening_place_at','Opening Place At'); ?></th>
					<th><?php echo $this->Paginator->sort('closing_held_on','Closing Held On'); ?></th>
					<th><?php echo $this->Paginator->sort('closing_place_at','Closing Held At'); ?></th>
					<th><?php echo $this->Paginator->sort('sign','Sign of MR'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
						
					
				</tr>
				</thead>
				<tbody>
				<?php 	foreach ($CircularInternalAuditArr as $CircularInternalAuditArrs): 	?>
					<tr>
						<td><span class="label label-info"><?php echo $CircularInternalAuditArrs['CircularInternalAudit']['audi_no']; ?></span></td>									
							
						<td><?php echo $CircularInternalAuditArrs['CircularInternalAudit']['from_mr']; ?></td>		
						<td><?php echo $CircularInternalAuditArrs['CircularInternalAudit']['to_mr']; ?></td>		
						<td><?php echo $CircularInternalAuditArrs['CircularInternalAudit']['opening_held_on']; ?></td>		
						<td><?php echo $CircularInternalAuditArrs['CircularInternalAudit']['opening_place_at']; ?></td>		
						<td><?php echo $CircularInternalAuditArrs['CircularInternalAudit']['closing_held_on']; ?></td>		
						<td><?php echo $CircularInternalAuditArrs['CircularInternalAudit']['closing_place_at']; ?></td>		
						<td><?php echo $CircularInternalAuditArrs['CircularInternalAudit']['sign']; ?></td>		
						
						
						<td><?php echo $CircularInternalAuditArrs['CircularInternalAudit']['created']; ?></td>		
						
						<th>							
							<?php 
							
							if($CircularInternalAuditArrs['CircularInternalAudit']['user_id'] == $userid){ ?>
								<a href="<?php echo SITEURL.'audits/circularinternalauditedit/'.$CircularInternalAuditArrs['CircularInternalAudit']['id']?>" class="btn btn-mini btn-primary">Edit</a>
								
								<a href="<?php echo SITEURL.'audits/circularinternalauditresult/'.$CircularInternalAuditArrs['CircularInternalAudit']['id']?>" class="btn btn-mini btn-danger">Result</a>
							<?php }else{ echo 'N/A'; }    ?>
						</th>			                    				
					</tr>
					<?php endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter([
'format' => __('showing {{current}} records out of {{count}} entries')
]);?>	</div>
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