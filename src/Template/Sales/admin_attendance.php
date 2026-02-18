	<div class="page-content">
		<div class="page-header">
			<h1>
				Sale Person Attdendance 			
				
				<form action="" method="post" style="float:right;">
					<input type="text" name="date" value="<?php echo $date; ?>" class="datepicker" placeholder="Start Date" >	
					<input type="submit" name="search" value="search" class="btn btn-info btn-xs" >					
				</form>	
			</h1>
			
			
		</div>
	
	<div class="row">
		<span class="label label-danger" style="text-align:center;">Attdendance Day: <?php echo $date; ?></span>
		<br/><br/>  
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('email'); ?></th>
				<th><?php echo $this->Paginator->sort('address'); ?></th>
				<th><?php echo $this->Paginator->sort('Login Time'); ?></th>				
				</tr>
				</thead>
				<tbody>
					<?php 
				
					$i=1;					
					foreach ($AttendanceArr as $AttendanceArrs): 
					?>
					<tr>
					<td>#<?php echo $i; ?>&nbsp;</td>
					<td><?php echo $AttendanceArrs['NappUser']['name'].' '.$AttendanceArrs['NappUser']['lname']; ?>&nbsp;</td>
					<td><?php echo h($AttendanceArrs['NappUser']['email']); ?>&nbsp;</td>
					<td><?php echo h($AttendanceArrs['Attendance']['address']); ?>&nbsp;</td>
					<td><?php echo date('d M Y h:i a',strtotime($AttendanceArrs['Attendance']['created'])); ?>&nbsp;</td>				
				
					<?php $i++;  endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter(array(
'format' => __('showing {:current} records out of {:count} entries')));?>	</div>
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
<script>
jQuery(function(){ 
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',			
	});$('.datepicker1').datepicker({
		format: 'yyyy-mm-dd',			
	});
});
</script>