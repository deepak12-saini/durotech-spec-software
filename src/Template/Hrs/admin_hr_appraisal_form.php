	<div class="page-content">
		<div class="page-header">
			<h1>Hr Performance Appraisal Form </h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('documentid'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id','Added By'); ?></th>				
					<th><?php echo $this->Paginator->sort('employee_name'); ?></th>
					<th><?php echo $this->Paginator->sort('evaluation_period'); ?></th>
					<th><?php echo $this->Paginator->sort('designation'); ?></th>
					<th><?php echo $this->Paginator->sort('name_appraiser'); ?></th>
					<th><?php echo $this->Paginator->sort('suitable_for_confirmation'); ?></th>
					<th><?php echo $this->Paginator->sort('suitable_for_promition'); ?></th>
					<th><?php echo $this->Paginator->sort('continue_with_notice'); ?></th>
					<th><?php echo $this->Paginator->sort('terminate'); ?></th>
					<th><?php echo $this->Paginator->sort('signature'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($HrDuringLeaveArr as $HrPerformanceFeedbackArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($HrPerformanceFeedbackArrs['HrAppraisalForm']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $HrPerformanceFeedbackArrs['NappUser']['name'].' '.$HrPerformanceFeedbackArrs['NappUser']['lname']; ?>&nbsp;</td>
						 
						<td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['employee_name']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['evaluation_period']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['designation']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['name_appraiser']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['suitable_for_confirmation']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['suitable_for_promition']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['continue_with_notice']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['terminate']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['signature']; ?></td>
						<td> <?php echo date('d-M-Y',strtotime($HrPerformanceFeedbackArrs['HrAppraisalForm']['created'])); ?></td>
									
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
	foreach ($HrDuringLeaveArr as $DocumentLibraryArrs): 
	
	?>
	<div id="myModal_<?php echo $j; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Performance Appraisal Form: <?php echo h($DocumentLibraryArrs['HrAppraisalForm']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['HrAppraisalForm']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					<tr><th>Employee Name: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['employee_name']; ?></td></tr>
					<tr><th>Date: </th><td><?php echo date('d-M-Y',strtotime($HrPerformanceFeedbackArrs['HrAppraisalForm']['date'])); ?></td></tr>	
					<tr><th>Evaluation Period: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['evaluation_period']; ?></td></tr>
					<tr><th>Designation: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['designation']; ?></td></tr>
					<tr><th>Name Appraiser: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['name_appraiser']; ?></td></tr>
					<tr><th>Suitable For Confirmation: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['suitable_for_confirmation']; ?></td></tr>
					<tr><th>Suitable For Promition: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['suitable_for_promition']; ?></td></tr>
					<tr><th>Continue with Notice: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['continue_with_notice']; ?></td></tr>
					<tr><th>Terminate: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['terminate']; ?></td></tr>
					<tr><th>Signature: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrAppraisalForm']['signature']; ?></td></tr>
					
					<tr><th>Created: </th><td><?php echo date('d-M-Y',strtotime($HrPerformanceFeedbackArrs['HrAppraisalForm']['created'])); ?></td></tr>	
					</tbody>
					
				</table>
				<h3 class="label label-inverse">Performance Citerias</h3>
				<table class="table table-striped table-bordered table-hover"  >
					<thead>		
						<tr>							
							<th>Performance Citeria</th>
							<th>Applicabe For</th>
							<th>Rating</th>
							<th>Rating by Appraiser</th>
							
						<tr>	
					</thead>
					<tbody>
						<?php 
						$k=1;
						foreach($DocumentLibraryArrs['HrAppraisalFormRecord'] as $records){  ?>
							<tr>
								
								<th><?php echo $records['performance_criteria']; ?></th>
								<th><?php echo $records['applicabe_for']; ?></th>					
								<th><?php echo $records['rating']; ?></th>
								<th><?php echo $records['rating_by_appraiser']; ?></th>
														
							<tr>		
						<?php  $k++; } ?>	
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
					