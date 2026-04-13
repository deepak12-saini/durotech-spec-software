	<div class="page-content">
		<div class="page-header">
			<h1>Document Preventive Maintenance Check List <a href="<?php echo SITEURL.'documents/add_preventive_maintenance' ?>" class="btn btn-mini btn-primary"> Add New</a></h1>
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
					<th><?php echo $this->Paginator->sort('machine_id'); ?></th>
					<th><?php echo $this->Paginator->sort('period_from','Period Of Record From'); ?></th>
					<th><?php echo $this->Paginator->sort('period_to','Period Of Record To'); ?></th>
					<th><?php echo $this->Paginator->sort('location'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($DocumentLibraryArr as $DocumentLibraryArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($DocumentLibraryArrs['DocumentPreventiveMaintenance']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?>&nbsp;</td>						
						<td><?php echo format_db_date('d-M-Y', $DocumentLibraryArrs['DocumentPreventiveMaintenance']['date']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['DocumentPreventiveMaintenance']['machine_id']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['DocumentPreventiveMaintenance']['period_from']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['DocumentPreventiveMaintenance']['period_to']); ?>&nbsp;</td>				
						<td><?php echo h($DocumentLibraryArrs['DocumentPreventiveMaintenance']['location']); ?>&nbsp;</td>	
						<td> <?php echo format_db_date('d-M-Y', $DocumentLibraryArrs['DocumentPreventiveMaintenance']['created']); ?></td>
						<td>
							<a href="<?php echo SITEURL.'documents/edit_preventive_maintenance/'.$DocumentLibraryArrs['DocumentPreventiveMaintenance']['id']; ?>" class="btn btn-mini btn-info">Edit</a>										
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
	foreach ($DocumentLibraryArr as $DocumentLibraryArrs): 
	
	?>
	<div id="myModal_<?php echo $j; ?>" class="modal fade" role="dialog">
	  <div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">&times;</button>
			<h4 class="modal-title">Document Preventive Maintenance Check: <?php echo h($DocumentLibraryArrs['DocumentPreventiveMaintenance']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['DocumentPreventiveMaintenance']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					
					<tr><th>Date: </th><td><?php echo format_db_date('d-M-Y', $DocumentLibraryArrs['DocumentPreventiveMaintenance']['date']); ?></td></tr>	
					<tr><th>Machine id: </th><td><?php echo $DocumentLibraryArrs['DocumentPreventiveMaintenance']['machine_id']; ?></td></tr>	
					<tr><th>Period Of Record From: </th><td><?php echo $DocumentLibraryArrs['DocumentPreventiveMaintenance']['period_from']; ?></td></tr>	
					<tr><th>Period Of Record To: </th><td><?php echo $DocumentLibraryArrs['DocumentPreventiveMaintenance']['period_to']; ?></td></tr>	
					<tr><th>Location: </th><td><?php echo $DocumentLibraryArrs['DocumentPreventiveMaintenance']['location']; ?></td></tr>						
					
					
					<tr><th>Created: </th><td><?php echo format_db_date('d-M-Y', $DocumentLibraryArrs['DocumentPreventiveMaintenance']['created']); ?></td></tr>	
					</tbody>
					
				</table>
				<table class="table table-striped table-bordered table-hover"  >
					<thead>		
						<tr>
							<th>Sr. No.</th>
							<th>Job To Be Done</th>
							<th>Frequency</th>
							<th>Date</th>							
							<th>Major job details/Parts changed,etc</th>							
							<th>Sign</th>							
						<tr>	
					</thead>
					<tbody>		
						<?php 
						$i=1;
						foreach($DocumentLibraryArrs['DocumentPreventiveMaintenanceRecord'] as $DocumentPreventiveMaintenanceRecord){ ?>
						<tr>							
							<th><?php echo $i; ?></th>
							<th><?php echo $DocumentPreventiveMaintenanceRecord['job_to_be_done']; ?></th>
							<th><?php echo $DocumentPreventiveMaintenanceRecord['frequency']; ?></th>
							<th><?php echo $DocumentPreventiveMaintenanceRecord['date']; ?></th>										
							<th><?php echo $DocumentPreventiveMaintenanceRecord['major_job_details']; ?></th>										
							<th><?php echo $DocumentPreventiveMaintenanceRecord['sign']; ?></th>										
						<tr>
						<?php $i++; } ?>
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
					