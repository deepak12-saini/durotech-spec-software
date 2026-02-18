<div class="row">
	<div class="col-xs-12">
		
		<table class="table table-striped table-bordered table-hover" id="simple-table" >
			<tbody>
				
				<tr><th>Sheet Name: </th><td><span class="label label-inverse"><?php echo ucfirst($SsSheetCategory['SsSheetCategory']['name']); ?></span></td></tr>
				
				<?php if(!empty($SheetTaskArr)){  ?>
				<tr><th>TaskId: </th><td><span class="label label-inverse"><?php echo ucfirst($SheetTaskArr[0]['SheetTask']['task_id']); ?></span></td></tr>
				
				<?php 
				foreach($SheetTaskArr as $SheetTaskArrs){

					if(isset($SheetTaskArrs['SsSheetColumn']['filed_type']) && ($SheetTaskArrs['SsSheetColumn']['filed_type'] == 'is_reminder')){
						if($SheetTaskArrs['SheetTask']['value'] == 0){
							$SheetTaskArrs['SheetTask']['value'] = 'No';
						}else{
							$SheetTaskArrs['SheetTask']['value'] = 'Yes';
						}
						
					}
					
					if(isset($SheetTaskArrs['SsSheetColumn']['filed_type']) && ($SheetTaskArrs['SsSheetColumn']['filed_type'] == 'Checkbox')){
						if($SheetTaskArrs['SheetTask']['value'] == 0){
							$SheetTaskArrs['SheetTask']['value'] = 'No';
						}else{
							$SheetTaskArrs['SheetTask']['value'] = 'Yes';
						}
						
					}
					if(isset($SheetTaskArrs['SsSheetColumn']['filed_type']) && ($SheetTaskArrs['SsSheetColumn']['filed_type'] == 'assigned')){
						$userId = $SheetTaskArrs['SheetTask']['value'];
						$SheetTaskArrs['SheetTask']['value'] = $this->requestAction('/sheets/getusername/'.$userId);
					}
					
					
				?>
					
					<tr><th><?php echo h($SheetTaskArrs['SsSheetColumn']['column']); ?>: </th><td><?php echo h($SheetTaskArrs['SheetTask']['value']); ?></td></tr>	
					
				<?php } } ?>	
				
			</tbody>
			
		</table>			
		
		<h3>Task Tracking</h3>
		<table class="table table-striped table-bordered table-hover" id="simple-table" >
			<tbody>
				<tr>
					<th>S No.</th>
					<th>Start Time</th>
					<th>End Time</th>
					<th>Task Status</th>
				<tr>
				<?php 
				$i=1;
				if(!empty($SheetTaskTrack)){ foreach($SheetTaskTrack as $SheetTaskTracks){ ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php echo date('d M Y h:i a',strtotime($SheetTaskTracks['SheetTaskTrack']['start'])); ?></td>
						<td><?php 
						if($SheetTaskTracks['SheetTaskTrack']['end'] != '0000-00-00 00:00:00'){
							echo date('d M Y h:i a',strtotime($SheetTaskTracks['SheetTaskTrack']['end']));
						}else{
							echo '-';
						}
						?></td>						
						<td>
							<?php 
								if($SheetTaskTracks['SheetTaskTrack']['status'] == 1){
									echo 'in-process';
								}else{
									echo 'completed';
								}
							?>
						</td>
					<tr>
				<?php $i++; } } ?>
			</tbody>			
		</table>	
		
	</div>
	</div>	