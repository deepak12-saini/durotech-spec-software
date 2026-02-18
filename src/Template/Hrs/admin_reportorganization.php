	<div class="page-content">
		<div class="page-header">
			<h1>Joining Report To The Organization</h1>
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
					<th><?php echo $this->Paginator->sort('empoyee_name'); ?></th>					
					<th><?php echo $this->Paginator->sort('email'); ?></th>
					<th><?php echo $this->Paginator->sort('phone'); ?></th>						
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($HrReportOrganizationArr as $HrPerformanceFeedbackArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($HrPerformanceFeedbackArrs['HrReportOrganization']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $HrPerformanceFeedbackArrs['NappUser']['name'].' '.$HrPerformanceFeedbackArrs['NappUser']['lname']; ?>&nbsp;</td>
						<td><?php echo date('d-M-Y',strtotime($HrPerformanceFeedbackArrs['HrReportOrganization']['date'])); ?>&nbsp;</td>
						<td><?php echo h($HrPerformanceFeedbackArrs['HrReportOrganization']['empoyee_name']); ?>&nbsp;</td>
						<td><?php echo h($HrPerformanceFeedbackArrs['HrReportOrganization']['email']); ?>&nbsp;</td>
						<td><?php echo h($HrPerformanceFeedbackArrs['HrReportOrganization']['phone']); ?>&nbsp;</td>
								
						<td> <?php echo date('d-M-Y H:i a',strtotime($HrPerformanceFeedbackArrs['HrReportOrganization']['created'])); ?></td>
										
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
	foreach ($HrReportOrganizationArr as $DocumentLibraryArrs): 
	
	?>
	<div id="myModal_<?php echo $j; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Joining Report To The Organization: <?php echo h($DocumentLibraryArrs['HrReportOrganization']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['HrReportOrganization']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					
					<tr><th>Name of Employee: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['empoyee_name']; ?></td></tr>		
					<tr><th>Date: </th><td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['HrReportOrganization']['date'])); ?></td></tr>	
					<tr><th>Permanent Address: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['permanent_address']; ?></td></tr>	
					<tr><th>Corresponding Address: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['corresponding_address']; ?></td></tr>	
					<tr><th>Email: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['email']; ?></td></tr>	
					<tr><th>Phone: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['phone']; ?></td></tr>	
					<tr><th>joining time: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['joining_time']; ?></td></tr>	
					<tr><th>Department: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['department']; ?></td></tr>	
					<tr><th>Designation: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['designation']; ?></td></tr>	
					<tr><th>D.O.B: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['dob']; ?></td></tr>	
					<tr><th>Blood group: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['blood_group']; ?></td></tr>	
					<!-- <tr><th>Signature: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['signature']; ?></td></tr>	
					<tr><th>Remarks: </th><td><?php echo $DocumentLibraryArrs['HrReportOrganization']['remarks']; ?></td></tr>	 -->
							
					<tr><th>Created: </th><td><?php echo date('d-M-Y H:i a',strtotime($DocumentLibraryArrs['HrReportOrganization']['created'])); ?></td></tr>	
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
					