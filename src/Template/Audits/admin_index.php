	
	<style>
		.btn{margin-bottom: 5px; }
		.label-danger, .label.label-danger, .badge.badge-danger, .badge-danger {
			margin-bottom: 5px;
		}
	</style>
	
	<div class="page-content">
	<div class="page-header">
		<h1>Internal Audit Planning &nbsp;&nbsp;&nbsp;</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>				
					<th><?php echo $this->Paginator->sort('audit_number'); ?></th>															
					<th><?php echo $this->Paginator->sort('date'); ?></th>
					<th><?php echo $this->Paginator->sort('department_to_be_audited'); ?></th>
					<th><?php echo $this->Paginator->sort('ai_planing_date','A.I Planning Date'); ?></th>
					<th><?php echo $this->Paginator->sort('ai_conducted_date','A.I Conducted Date'); ?></th>
					<th><?php echo $this->Paginator->sort('auditor'); ?></th>
					<th><?php echo $this->Paginator->sort('auditee'); ?></th>
					<th><?php echo $this->Paginator->sort('sign_of_mr','Sign of MR'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>						
					
				</tr>
				</thead>
				<tbody>
				<?php 	foreach ($FormatInternalAuditPlanArr as $FormatInternalAuditPlanArrs): 	?>
					<tr>
						<td><span class="label label-info"><?php echo $FormatInternalAuditPlanArrs['FormatInternalAuditPlan']['audit_number']; ?></span></td>									
						<td><?php echo $FormatInternalAuditPlanArrs['FormatInternalAuditPlan']['date']; ?></td>						
						<td><?php echo $FormatInternalAuditPlanArrs['FormatInternalAuditPlan']['department_to_be_audited']; ?></td>						
						<td><?php echo $FormatInternalAuditPlanArrs['FormatInternalAuditPlan']['ai_planing_date']; ?></td>						
						<td><?php echo $FormatInternalAuditPlanArrs['FormatInternalAuditPlan']['ai_conducted_date']; ?></td>					
						<td><?php echo isset($FormatInternalAuditPlanArrs['NappUser']['name']) ? h($FormatInternalAuditPlanArrs['NappUser']['name']) : ''; ?> <?php echo isset($FormatInternalAuditPlanArrs['NappUser']['lname']) ? h($FormatInternalAuditPlanArrs['NappUser']['lname']) : ''; ?></td>						
						<td><?php echo isset($FormatInternalAuditPlanArrs['NappUser1']['name']) ? h($FormatInternalAuditPlanArrs['NappUser1']['name']) : ''; ?> <?php echo isset($FormatInternalAuditPlanArrs['NappUser1']['lname']) ? h($FormatInternalAuditPlanArrs['NappUser1']['lname']) : ''; ?></td>						
						<td><?php echo $FormatInternalAuditPlanArrs['FormatInternalAuditPlan']['sign_of_mr']; ?></td>		
						<td><?php echo $FormatInternalAuditPlanArrs['FormatInternalAuditPlan']['created']; ?></td>		
						     				
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