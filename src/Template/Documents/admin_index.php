	<div class="page-content">
		<div class="page-header">
			<h1>Document Title Records of Library List </h1>
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
					<th><?php echo $this->Paginator->sort('name_of_indentor'); ?></th>
					<th><?php echo $this->Paginator->sort('desigaration','Designation'); ?></th>
					<th><?php echo $this->Paginator->sort('department'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>
					<th><?php echo $this->Paginator->sort('created'); ?></th>
					
				</tr>
				</thead>
				<tbody>
					<?php
					$k = 1;
					foreach ($DocumentLibraryArr as $DocumentLibraryArrs): ?>
					<tr>
						<td><a data-toggle="modal" data-target="#myModal_<?php echo $k; ?>" href="#null"><?php echo h($DocumentLibraryArrs['DocumentLibrary']['documentid']); ?></a>&nbsp;</td>
						<td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?>&nbsp;</td>
						
						<!-- <td><?php echo h($DocumentLibraryArrs['DocumentLibrary']['format']); ?>&nbsp;</td> -->
						<td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['DocumentLibrary']['date'])); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['DocumentLibrary']['name_of_indentor']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['DocumentLibrary']['desigaration']); ?>&nbsp;</td>
						<td><?php echo h($DocumentLibraryArrs['DocumentLibrary']['department']); ?>&nbsp;</td>				
						<td>
						<?php
							if($DocumentLibraryArrs['DocumentLibrary']['status'] == 1){
								echo '<span class="label label-primary">Pending</span>';
							}else if($DocumentLibraryArrs['DocumentLibrary']['status'] == 2){
								echo '<span class="label label-success">Active</span>';
							}	
						?>&nbsp;
						</td>					
						<td> <?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['DocumentLibrary']['created'])); ?></td>
										
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
			<h4 class="modal-title">Document Title Records of Library: <?php echo h($DocumentLibraryArrs['DocumentLibrary']['documentid']); ?></h4>
		  </div>
		  <div class="modal-body">
			<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover"  >
					<tbody>
					<tr><th>Documentid: </th><td><span class="label label-inverse"><?php echo h($DocumentLibraryArrs['DocumentLibrary']['documentid']); ?></span></td></tr>	
					
					<tr><th>Added By: </th><td><?php echo $DocumentLibraryArrs['NappUser']['name'].' '.$DocumentLibraryArrs['NappUser']['lname']; ?></td></tr>	
					
					<tr><th>Date: </th><td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['DocumentLibrary']['date'])); ?></td></tr>	
					<tr><th>Name of Indentor: </th><td><?php echo $DocumentLibraryArrs['DocumentLibrary']['name_of_indentor']; ?></td></tr>	
					<tr><th>Designation: </th><td><?php echo $DocumentLibraryArrs['DocumentLibrary']['desigaration']; ?></td></tr>	
					<tr><th>Department: </th><td><?php echo $DocumentLibraryArrs['DocumentLibrary']['department']; ?></td></tr>						
					<tr><th>Status: </th><td>
					<?php 
					if($DocumentLibraryArrs['DocumentLibrary']['status'] == 1){
						echo '<span class="label label-primary">Pending</span>';
					}else if($DocumentLibraryArrs['DocumentLibrary']['status'] == 2){
						echo '<span class="label label-success">Active</span>';
					}	 ?>
					</td></tr>	
					
					<tr><th>Sign of coordinator: </th><td><?php echo $DocumentLibraryArrs['NappUser_2']['name'].' '.$DocumentLibraryArrs['NappUser_2']['lname'] ; ?></td></tr>	
					<tr><th>Sign of hod: </th><td><?php echo $DocumentLibraryArrs['NappUser_3']['name'].' '.$DocumentLibraryArrs['NappUser_3']['lname'] ; ?></td></tr>	
					<tr><th>sign of library: </th><td><?php echo $DocumentLibraryArrs['NappUser_4']['name'].' '.$DocumentLibraryArrs['NappUser_4']['lname'] ; ?></td></tr>	
					
					<tr><th>Created: </th><td><?php echo date('d-M-Y',strtotime($DocumentLibraryArrs['DocumentLibrary']['created'])); ?></td></tr>	
					</tbody>
					
				</table>
				<table class="table table-striped table-bordered table-hover"  >
					<thead>		
						<tr>
							<th>S.no</th>
							<th>Name of the Book</th>
							<th>Qty</th>
							<th>Expected Date of Return</th>
							<th>Remarks</th>
						<tr>	
					</thead>
					<tbody>
						<?php 
						$k=1;
						foreach($DocumentLibraryArrs['DocumentLibraryRecord'] as $records){  ?>
							<tr>
								<th><?php echo $k; ?></th>
								<th><?php echo $records['nameofthebook']; ?></th>
								<th><?php echo $records['qty']; ?></th>
								<th><?php echo $records['expecteddateofreturn']; ?></th>
								
								<th><?php echo $records['remarks']; ?></th>
								
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
					