	<div class="page-content">
		<div class="page-header">
			<h1>Hr Training Need Assessment List <a href="<?php echo SITEURL.'hrs/add' ?>" class="btn btn-mini btn-primary"> Add New</a></h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('documentid'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id','Added By'); ?></th>				
					<!-- <th><?php echo $this->Paginator->sort('format'); ?></th> -->
					<th><?php echo $this->Paginator->sort('date'); ?></th>
					<th><?php echo $this->Paginator->sort('employee_name'); ?></th>
					<th><?php echo $this->Paginator->sort('qualification'); ?></th>
					<th><?php echo $this->Paginator->sort('designation','Designation'); ?></th>
					<th><?php echo $this->Paginator->sort('department'); ?></th>
					<th><?php echo $this->Paginator->sort('experience'); ?></th>
					<th><?php echo $this->Paginator->sort('signature'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($HrTrainingNeedAssessmentArr as $DocumentLibraryArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?>&nbsp;</td>
						
						<!-- <td><?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['format']); ?>&nbsp;</td> -->
						<td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['HrTrainingNeedAssessment']['date'])); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['employee_name']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['qualification']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['designation']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['department']); ?>&nbsp;</td>				
						<td><?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['experience']); ?>&nbsp;</td>				
						<td><?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['signature']); ?>&nbsp;</td>				
										
						<td> <?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['HrTrainingNeedAssessment']['created'])); ?></td>
						<td>
							<a href="<?php echo SITEURL.'hrs/edit/'.$DocumentLibraryArrs['HrTrainingNeedAssessment']['id']; ?>" class="btn btn-mini btn-info">Edit</a>							
											
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
	foreach ($HrTrainingNeedAssessmentArr as $DocumentLibraryArrs): 
	
	?>
	<div id="myModal_<?php echo $j; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Document Title Records of Library: <?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['HrTrainingNeedAssessment']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					
					<tr><th>Date: </th><td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['HrTrainingNeedAssessment']['date'])); ?></td></tr>	
					<tr><th>Employee Name: </th><td><?php echo $DocumentLibraryArrs['HrTrainingNeedAssessment']['employee_name']; ?></td></tr>	
					<tr><th>Qualification: </th><td><?php echo $DocumentLibraryArrs['HrTrainingNeedAssessment']['qualification']; ?></td></tr>	
					<tr><th>Designation: </th><td><?php echo $DocumentLibraryArrs['HrTrainingNeedAssessment']['designation']; ?></td></tr>	
					<tr><th>Department: </th><td><?php echo $DocumentLibraryArrs['HrTrainingNeedAssessment']['department']; ?></td></tr>	
					<tr><th>experience: </th><td><?php echo $DocumentLibraryArrs['HrTrainingNeedAssessment']['experience']; ?></td></tr>					
					<tr><th>Signature: </th><td><?php echo $DocumentLibraryArrs['HrTrainingNeedAssessment']['signature']; ?></td></tr>					
					<tr><th>Created: </th><td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['HrTrainingNeedAssessment']['created'])); ?></td></tr>	
					</tbody>
					
				</table>
				<table class="table table-striped table-bordered table-hover"  >
					<thead>		
						<tr>
							
							<th>Performance/Rating</th>
							<th>Result-1</th>
							<th>Result-2</th>
							<th>Result-3</th>
							<th>Result-4</th>
							<th>Result-5</th>
							<th>Remark</th>
						<tr>	
					</thead>
					<tbody>
						<?php 
						$k=1;
						foreach($DocumentLibraryArrs['HrTrainingNeedAssessmentRecord'] as $records){  ?>
							<tr>
								
								<th><?php echo $records['performance_rating']; ?></th>
								<th><?php echo $records['record_1']; ?></th>
								<th><?php echo $records['record_2']; ?></th>
								<th><?php echo $records['record_3']; ?></th>
								<th><?php echo $records['record_4']; ?></th>
								<th><?php echo $records['record_5']; ?></th>
								
								<th><?php echo $records['remark']; ?></th>
								
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
					