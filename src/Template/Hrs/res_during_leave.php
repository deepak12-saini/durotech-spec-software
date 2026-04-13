	<div class="page-content">
		<div class="page-header">
			<h1>Handling/Taking Over Duties & Responsibilties During Leave <a href="<?php echo SITEURL.'hrs/res_during_leave_add' ?>" class="btn btn-mini btn-primary"> Add New</a></h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('documentid'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id','Added By'); ?></th>				
					<!-- <th><?php echo $this->Paginator->sort('date'); ?></th> -->
					<th><?php echo $this->Paginator->sort('name_of_employee'); ?></th>					
					<th><?php echo $this->Paginator->sort('designation'); ?></th>
					<th><?php echo $this->Paginator->sort('department'); ?></th>						
					<th><?php echo $this->Paginator->sort('leave_from'); ?></th>						
					<th><?php echo $this->Paginator->sort('leave_to'); ?></th>						
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($HrDuringLeaveArr as $HrPerformanceFeedbackArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($HrPerformanceFeedbackArrs['HrDuringLeave']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $HrPerformanceFeedbackArrs['NappUser']['name'].' '.$HrPerformanceFeedbackArrs['NappUser']['lname']; ?>&nbsp;</td>
						
						<td><?php echo h($HrPerformanceFeedbackArrs['HrDuringLeave']['name_of_employee']); ?>&nbsp;</td>
						<td><?php echo h($HrPerformanceFeedbackArrs['HrDuringLeave']['designation']); ?>&nbsp;</td>
						<td><?php echo h($HrPerformanceFeedbackArrs['HrDuringLeave']['department']); ?>&nbsp;</td>
						<td><?php echo format_db_date('d-M-Y', $HrPerformanceFeedbackArrs['HrDuringLeave']['leave_from']); ?>&nbsp;</td>
						<td><?php echo format_db_date('d-M-Y', $HrPerformanceFeedbackArrs['HrDuringLeave']['leave_to']); ?>&nbsp;</td>
								
						<td> <?php echo format_db_date('d-M-Y H:i a', $HrPerformanceFeedbackArrs['HrDuringLeave']['created']); ?></td>
						<td>
							<a href="<?php echo SITEURL.'hrs/res_during_leave_edit/'.$HrPerformanceFeedbackArrs['HrDuringLeave']['id']; ?>" class="btn btn-mini btn-info">Edit</a>							
											
						</td>					
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
			<h4 class="modal-title">Handling/Taking Over Duties & Responsibilties During Leave: <?php echo h($DocumentLibraryArrs['HrDuringLeave']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['HrDuringLeave']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					
					<tr><th>Name of Employee: </th><td><?php echo $DocumentLibraryArrs['HrDuringLeave']['name_of_employee']; ?></td></tr>		
					<tr><th>Designation: </th><td><?php echo $DocumentLibraryArrs['HrDuringLeave']['designation']; ?></td></tr>		
					<tr><th>Department: </th><td><?php echo $DocumentLibraryArrs['HrDuringLeave']['department']; ?></td></tr>		
					<tr><th>Leave From: </th><td><?php echo format_db_date('d-M-Y', $DocumentLibraryArrs['HrDuringLeave']['leave_from']); ?></td></tr>	
					<tr><th>Leave To: </th><td><?php echo format_db_date('d-M-Y', $DocumentLibraryArrs['HrDuringLeave']['leave_to']); ?></td></tr>	
				
							
					<tr><th>Created: </th><td><?php echo format_db_date('d-M-Y H:i a', $DocumentLibraryArrs['HrDuringLeave']['created']); ?></td></tr>	
					</tbody>
					
				</table>
				
				<table class="table table-striped table-bordered table-hover"  >
					<thead>		
						<tr>
							
							<th>Description of Duties</th>
							<th>Description of Responsibilities</th>
							<th>Handed over</th>
							<th>Assigned To</th>
							<th>Signature</th>
							
						<tr>	
					</thead>
					<tbody>
						<?php 
						$k=1;
						foreach($DocumentLibraryArrs['HrDuringLeaveRecord'] as $records){  ?>
							<tr>
								
								<th><?php echo $records['description_of_duty']; ?></th>
								<th><?php echo $records['description_of_responsibility']; ?></th>
								<th><?php echo $records['handed_over']; ?></th>
								<th><?php echo $records['assigned_to']; ?></th>
								<th><?php echo $records['signature']; ?></th>							
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
					