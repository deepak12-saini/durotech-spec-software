	<div class="page-content">
		<div class="page-header">
			<h1>Format For NC and NC Closure List <a href="<?php echo SITEURL.'documents/add_ncclosure' ?>" class="btn btn-mini btn-primary"> Add New</a></h1>
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
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($DocumentLibraryArr as $DocumentLibraryArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($DocumentLibraryArrs['DocumentNcClosure']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?>&nbsp;</td>						
						<td><?php echo format_db_date('d-M-Y', $DocumentLibraryArrs['DocumentNcClosure']['date']); ?>&nbsp;</td>										
						<td> <?php echo format_db_date('d-M-Y h:i a', $DocumentLibraryArrs['DocumentNcClosure']['created']); ?></td>
						<td>
							<a href="<?php echo SITEURL.'documents/edit_ncclosure/'.$DocumentLibraryArrs['DocumentNcClosure']['id']; ?>" class="btn btn-mini btn-info">Add/Edit Records</a>							
											
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
			<h4 class="modal-title">Format For NC and NC Closure: <?php echo h($DocumentLibraryArrs['DocumentNcClosure']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['DocumentNcClosure']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					
					<tr><th>Date: </th><td><?php echo format_db_date('d-M-Y', $DocumentLibraryArrs['DocumentNcClosure']['date']); ?></td></tr>	
				
					<tr><th>Created: </th><td><?php echo format_db_date('d-M-Y h:i a', $DocumentLibraryArrs['DocumentNcClosure']['created']); ?></td></tr>	
					</tbody>
					
				</table>
				<table class="table table-striped table-bordered table-hover"  >
					<thead>		
						<tr>
							<th>S.no</th>
							<th>NC</th>
							<th>Source of NC</th>
							<th>Responsibilty</th>
							<th>Root Cause</th>
							<th>Action</th>
							<th>Resource</th>
							<th>Time</th>
							<th>Closure</th>
						<tr>	
					</thead>
					<tbody>
						<?php 
						$k=1;
						foreach($DocumentLibraryArrs['DocumentNcClosureRecord'] as $records){  ?>
							<tr>
								<th><?php echo $k; ?></th>
								<th><?php echo $records['nc']; ?></th>
								<th><?php echo $records['source_nc']; ?></th>
								<th><?php echo $records['responsiblity']; ?></th>
								<th><?php echo $records['root_cause']; ?></th>
								<th><?php echo $records['action']; ?></th>
								<th><?php echo $records['resource']; ?></th>
								<th><?php echo $records['time']; ?></th>								
								<th><?php echo $records['closure']; ?></th>
								
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
					