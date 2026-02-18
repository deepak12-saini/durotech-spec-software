	
	<style>
		.btn{margin-bottom: 5px; }
		.label-danger, .label.label-danger, .badge.badge-danger, .badge-danger {
			margin-bottom: 5px;
		}
	</style>
	
	<div class="page-content">
	<div class="page-header">
		<h1>Circular Management Reviews List <a href="<?php echo SITEURL.'organisations/add';  ?>" class="btn btn-mini btn-info">Add New</a> </h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>				
					<th><?php echo $this->Paginator->sort('emp_id','Added By'); ?></th>															
					<th><?php echo $this->Paginator->sort('Group'); ?></th>
					<th><?php echo $this->Paginator->sort('Date'); ?></th>
					<th><?php echo $this->Paginator->sort('Time'); ?></th>
					<th><?php echo $this->Paginator->sort('agenda'); ?></th>
					<th><?php echo $this->Paginator->sort('status'); ?></th>					
					<th><?php echo $this->Paginator->sort('created'); ?></th>				
					<th>Action</th>				
					
				</tr>
				</thead>
				<tbody>
				<?php 	foreach ($circularArr as $circularArrs): 	?>
					<tr>
						<td><span class="label label-info"><?php echo $circularArrs['NappUser']['name'].' '.$circularArrs['NappUser']['lname']; ?></span></td>						
						<td>
						<?php 
							if(!empty($circularArrs['CircularRelation'])){
								foreach($circularArrs['CircularRelation'] as $CircularRelations){
									$department_title = '';
									if(isset($CircularRelations['NappUser']['Department']['department_title']) && !empty($CircularRelations['NappUser']['Department']['department_title'])){
										$department_title = ' - '.$CircularRelations['NappUser']['Department']['department_title'];
									}
									echo '<span class="label label-info">'.$CircularRelations['NappUser']['name'].' '.$CircularRelations['NappUser']['lname'].''.$department_title.'</span><br/><br/>';
								}					
							}
						?>
						</td>						
						<td><?php echo $circularArrs['CircularManagementReview']['date']; ?></td>						
						<td><?php echo $circularArrs['CircularManagementReview']['start_time'].' To '.$circularArrs['CircularManagementReview']['end_time']; ?></td>						
						<td>
						<?php
						
						$agenda = explode("##",$circularArrs['CircularManagementReview']['agenda']);
						$i=1;
						foreach($agenda as $agends){	
							if(!empty($agends)){
								echo $i.'. <b>'.$agends.'</b><br/>';							
								$i++;
							}
							
						}	
						if(!empty($circularArrs['CircularManagementReview']['extra'])){
							echo $i.'. <b>'.$circularArrs['CircularManagementReview']['extra'].'</b><br/>';	
						}	
						?>
						</td>						
						<td><?php if($circularArrs['CircularManagementReview']['status'] == 1){ echo '<span class="label label-success">Completed</span>'; }else{  echo '<span class="label label-danger">Pending</span>'; }  ?></td>						
						<td><?php echo $circularArrs['CircularManagementReview']['created']; ?></td>						
						<th>
							<?php if($emp_id == $circularArrs['CircularManagementReview']['emp_id']){ ?>
								<a href="<?php echo SITEURL.'organisations/edit/'.$circularArrs['CircularManagementReview']['id']?>" class="btn btn-mini btn-info">Edit</a>
								<?php if($circularArrs['CircularManagementReview']['status'] == 0){ ?>
									<a href="<?php echo SITEURL.'organisations/closemom/'.$circularArrs['CircularManagementReview']['id']?>" class="btn btn-mini btn-primary">Close Meeting</a>
								<?php } ?>
							<?php }?>
							<?php if($circularArrs['CircularManagementReview']['status'] == 1){ ?>
								<a href="<?php echo SITEURL.'organisations/result/'.$circularArrs['CircularManagementReview']['id']?>" class="btn btn-mini btn-primary">Result</a>
							<?php }else{ echo 'N/A'; } ?>
						</th>			                    				
					</tr>
					<?php endforeach; ?>

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