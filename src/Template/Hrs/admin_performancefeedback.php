	<div class="page-content">
		<div class="page-header">
			<h1>Hr Performance Feedback </h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('documentid'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id','Added By'); ?></th>				
					<th><?php echo $this->Paginator->sort('date'); ?></th>
					<th><?php echo $this->Paginator->sort('name_of_employee'); ?></th>
					<th><?php echo $this->Paginator->sort('department'); ?></th>
					<th><?php echo $this->Paginator->sort('designation'); ?></th>
					<th><?php echo $this->Paginator->sort('date_of_joining'); ?></th>						
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($HrPerformanceFeedbackArr as $HrPerformanceFeedbackArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($HrPerformanceFeedbackArrs['HrPerformanceFeedback']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $HrPerformanceFeedbackArrs['NappUser']['name'].' '.$HrPerformanceFeedbackArrs['NappUser']['lname']; ?>&nbsp;</td>
						<td><?php echo date('d-M-Y',strtotime($HrPerformanceFeedbackArrs['HrPerformanceFeedback']['date'])); ?>&nbsp;</td>
						<td><?php echo h($HrPerformanceFeedbackArrs['HrPerformanceFeedback']['name_of_employee']); ?>&nbsp;</td>
						<td><?php echo h($HrPerformanceFeedbackArrs['HrPerformanceFeedback']['department']); ?>&nbsp;</td>
						<td><?php echo h($HrPerformanceFeedbackArrs['HrPerformanceFeedback']['designation']); ?>&nbsp;</td>
						<td><?php echo h($HrPerformanceFeedbackArrs['HrPerformanceFeedback']['date_of_joining']); ?>&nbsp;</td>
								
						<td> <?php echo date('d-M-Y',strtotime($HrPerformanceFeedbackArrs['HrPerformanceFeedback']['created'])); ?></td>
									
					</tr>
					<?php $k++; endforeach; ?>
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

<?php 

	$j=1;
	foreach ($HrPerformanceFeedbackArr as $DocumentLibraryArrs): 
	
	?>
	<div id="myModal_<?php echo $j; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Hr Performance Feedback: <?php echo h($DocumentLibraryArrs['HrPerformanceFeedback']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['HrPerformanceFeedback']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					
					<tr><th>Name of Employee: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['name_of_employee']; ?></td></tr>	
					<tr><th>Date: </th><td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['HrPerformanceFeedback']['date'])); ?></td></tr>	
					<tr><th>Department: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['department']; ?></td></tr>	
					<tr><th>Designation: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['designation']; ?></td></tr>	
					<tr><th>Date of joining: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['date_of_joining']; ?></td></tr>	
					<tr><th>Job knowledge: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['job_knowledge']; ?></td></tr>	
					<tr><th>Quality of work: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['quality_of_work']; ?></td></tr>	
					<tr><th>Personal Behaviour: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['personal_behaviour']; ?></td></tr>	
					<tr><th>Perforamnce: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['perforamnce']; ?></td></tr>	
					<tr><th>Current Task Assigned: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['current_task_assigned']; ?></td></tr>	
					<tr><th>Getting Trainned Under: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['getting_trainned_under']; ?></td></tr>	
					<tr><th>Punctuality: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['punctuality']; ?></td></tr>	
					<tr><th>Signature of hr executive: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['signature_of_hr_executive']; ?></td></tr>	
					<tr><th>signature of concerned dept. co-ordinator: </th><td><?php echo $DocumentLibraryArrs['HrPerformanceFeedback']['signature_of_concerned_deptt_coordinator']; ?></td></tr>	
							
					<tr><th>Created: </th><td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['HrPerformanceFeedback']['created'])); ?></td></tr>	
					</tbody>
					
				</table>
				
 
				</div>
			</div>
		</div>		
		  </div>
		 
		</div>

	  </div>
	</div>
	<?php $j++; endforeach; ?>
					