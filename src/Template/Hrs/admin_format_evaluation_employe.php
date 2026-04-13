	<div class="page-content">
		<div class="page-header">
			<h1> Hr Format Evaluation Employee <a href="<?php echo SITEURL.'hrs/format_evaluation_employe_add' ?>" class="btn btn-mini btn-primary"> Add New </a></h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
					<th><?php echo $this->Paginator->sort('documentid'); ?></th>
					<th><?php echo $this->Paginator->sort('user_id','Added By'); ?></th>				
					<th><?php echo $this->Paginator->sort('name_of_expert_advisor'); ?></th>
					<th><?php echo $this->Paginator->sort('area_of_expertise'); ?></th>
					<th><?php echo $this->Paginator->sort('total_experience'); ?></th>
					<th><?php echo $this->Paginator->sort('other'); ?></th>
					<th><?php echo $this->Paginator->sort('remark'); ?></th>
					<th><?php echo $this->Paginator->sort('reviewed_by'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($HrDuringLeaveArr as $HrPerformanceFeedbackArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $HrPerformanceFeedbackArrs['NappUser']['name'].' '.$HrPerformanceFeedbackArrs['NappUser']['lname']; ?>&nbsp;</td>
						 
						<td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['name_of_expert_advisor']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['area_of_expertise']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['total_experience']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['other']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['remark']; ?></td>
						<td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['reviewed_by']; ?></td>
						<td> <?php echo format_db_date('d-M-Y H:i a', $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['created']); ?></td>
						<td>
							<a href="<?php echo SITEURL.'hrs/format_evaluation_employe_edit/'.$HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['id']; ?>" class="btn btn-mini btn-info">Edit</a>							
											
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
			<h4 class="modal-title"> Hr Format Training Calendars : <?php echo h($DocumentLibraryArrs['HrFormatEvaluationEmployee']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['HrFormatEvaluationEmployee']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					<tr><th>Name of Expert Advisor: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['name_of_expert_advisor']; ?></td></tr>
					<tr><th>Area of Experties: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['area_of_expertise']; ?></td></tr>
					<tr><th>Total Experience: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['total_experience']; ?></td></tr>
					<tr><th>Other: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['other']; ?></td></tr>
					<tr><th>Remark: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['remark']; ?></td></tr>
					<tr><th>Reviewed By: </th><td> <?php echo $HrPerformanceFeedbackArrs['HrFormatEvaluationEmployee']['reviewed_by']; ?></td></tr>
					
					<tr><th>Created: </th><td><?php echo format_db_date('d-M-Y H:i a', $DocumentLibraryArrs['HrFormatEvaluationEmployee']['created']); ?></td></tr>	
					</tbody>
					
				</table>
				<h3 class="label label-inverse">Hr Format Evaluation Employe </h3>
				<table class="table table-striped table-bordered table-hover"  >
					<thead>		
						<tr>
							
							<th>Daetil</th>
							<th>Acceptable</th>
							<th>Not Acceptable</th>
							<th>To Be Improved</th>
							
						<tr>	
					</thead>
					<tbody>
						<?php 
						$k=1;
						foreach($DocumentLibraryArrs['HrFormatEvaluationEmployeRecord'] as $records){  ?>
							<tr>
								
								<th><?php echo $k; ?></th>
								<th><?php echo $records['detail']; ?></th>
								<th><?php echo $records['acceptable']; ?></th>
								<th><?php echo $records['not_acceptable']; ?></th>
								<th><?php echo $records['to_be_improved']; ?></th>
														
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
					