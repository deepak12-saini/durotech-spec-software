	<div class="page-content">
		<div class="page-header">
			<h1>Field Executive Duty Requisition Form </h1>
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
					<th><?php echo $this->Paginator->sort('name_of_requistioner'); ?></th>
					<th><?php echo $this->Paginator->sort('designation','Designation'); ?></th>
					<th><?php echo $this->Paginator->sort('deptartment'); ?></th>
					<th><?php echo $this->Paginator->sort('contact_no'); ?></th>
					<th><?php echo $this->Paginator->sort('place_of_visit'); ?></th>
					<th><?php echo $this->Paginator->sort('date_of_visit'); ?></th>
					<th><?php echo $this->Paginator->sort('priority'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($DocumentLibraryArr as $DocumentLibraryArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?>&nbsp;</td>
						
						<!-- <td><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['format']); ?>&nbsp;</td> -->
						<td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['date'])); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['name_of_requistioner']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['designation']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['deptartment']); ?>&nbsp;</td>				
						<td><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['contact_no']); ?>&nbsp;</td>				
						<td><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['place_of_visit']); ?>&nbsp;</td>				
						<td><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['date_of_visit']); ?>&nbsp;</td>				
						<td><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['priority']); ?>&nbsp;</td>				
									
						<td> <?php echo date('d-M-Y h:i a',strtotime($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['created'])); ?></td>
											
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
	foreach ($DocumentLibraryArr as $DocumentLibraryArrs): 
	
	?>
	<div id="myModal_<?php echo $j; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Document Receive Inspection: <?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					
					<tr><th>Date: </th><td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['date'])); ?></td></tr>	
				</tbody>
				</table>	
				<h5 class="label label-inverse">Fixed Executive Duty Requisition Form</h5>
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Name of the Requistioner: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['name_of_requistioner']; ?></td></tr>					
					<tr><th>Designation: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['designation']; ?></td></tr>	
					<tr><th>Contact no: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['contact_no']; ?></td></tr>	
					<tr><th>Department: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['deptartment']; ?></td></tr>	
					<tr><th>Date of Visit: </th><td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['DocumentFieldExecutiveDuty']['date_of_visit'])); ?></td></tr>	
					<tr><th>Place of Visit: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['place_of_visit']; ?></td></tr>	
					<tr><th>Priority: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['priority']; ?></td></tr>	
					<tr><th>sign of requisitoner: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['sign_of_requisitoner']; ?></td></tr>	
					<tr><th>Sign of HOD: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['sign_of_hod']; ?></td></tr>	
					</tbody>
					
				</table>
				<h5 class="label label-inverse">Particulars of Contact Person</h5>
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Name of the contact person meet: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['name_of_contact_person_meet']; ?></td></tr>					
					<tr><th>Address of the Contact Person: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['contact_address']; ?></td></tr>	
					<tr><th>Contact no: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['particular_contact_no']; ?></td></tr>	
					<tr><th>Detail of work assigned: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['detail_of_work_assigned']; ?></td></tr>	
					
					</tbody>
					
				</table>
				<h5 class="label label-inverse">For Administration Dept. Use</h5>
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Name of the feild Executive alloted: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['name_executive_alloted']; ?></td></tr>					
					<tr><th>Date of Visit: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['dept_date_of_visit']; ?></td></tr>	
					<tr><th>No of days of visit: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['no_of_days_of_visit']; ?></td></tr>	
					<tr><th>Sing admin executive: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['sing_admin_executive']; ?></td></tr>	
					<tr><th>Approved by: </th><td><?php echo $DocumentLibraryArrs['DocumentFieldExecutiveDuty']['approved_by']; ?></td></tr>	
					
					</tbody>
					
				</table>
			
			
				</div>
			</div>
		</div>		
		  </div>
		 
		</div>

	  </div>
	</div>
	<?php $j++; endforeach;  ?>
					