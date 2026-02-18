	<div class="page-content">
		<div class="page-header">
			<h1>
			<?php
			$nu = is_object($napuser) ? $napuser : (object)($napuser['NappUser'] ?? $napuser);
			$nuName = trim(($nu->name ?? $napuser['NappUser']['name'] ?? '') . ' ' . ($nu->lname ?? $napuser['NappUser']['lname'] ?? ''));
			$nuId = $nu->id ?? $napuser['NappUser']['id'] ?? null;
			?>
			Duro Sales Report >> <small><?php echo h($nuName); ?>
			
			<?php echo $this->Form->create(null, ['url' => ['controller' => 'Sales', 'action' => 'admin_report', $nuId], 'style' => 'float:right;']); ?>
				<select name="slaetype">
					<option value="">Show All</option>
					<?php foreach($slatestype as $slatestypes){ 
						$sq = is_object($slatestypes) ? $slatestypes : (object)($slatestypes['SaleQuestion'] ?? $slatestypes);
						$sqId = $sq->id ?? null;
						$sqTitle = $sq->title ?? '';
						if ($sqId !== null && $sqTitle !== '') {
					?>
						<option <?php echo $slaetype == $sqId ? 'selected' : ''; ?> value="<?php echo h($sqId); ?>"><?php echo h($sqTitle); ?></option>
					<?php } } ?>
				</select>
				<input type="text" name="startdate" value="<?php echo h($startdate ?? ''); ?>" class="datepicker" placeholder="Start Date" >
				<input type="text" name="enddate" value="<?php echo h($enddate ?? ''); ?>" class="datepicker1" placeholder="End Date" >
				<input type="submit" name="search" value="search" class="btn btn-info btn-xs" >	
			<?php echo $this->Form->end(); ?>
			<?php if ($nuId !== null): ?>
			<a href="<?php echo $this->Url->build(['controller' => 'Sales', 'action' => 'admin_report', $nuId]); ?>" class="btn btn-warning btn-xs" style="float:right; margin-right:10px;">Show All</a>
			<?php endif; ?>
			<a href="<?php echo $this->Url->build(['controller' => 'Sales', 'action' => 'admin_index']); ?>" class="btn btn-nverse btn-xs" style="float:right; margin-right:10px;">Back</a>		
			
			</h1>
			<br><h1>
			<?php
			$totalsale = array();
			foreach ($SaleRepArr as $SaleRepArrs){
				$sr = is_object($SaleRepArrs) ? $SaleRepArrs : (object)($SaleRepArrs['SaleRep'] ?? $SaleRepArrs);
				$sq = null;
				if (is_object($SaleRepArrs)) {
					$sq = $SaleRepArrs->sale_question ?? null;
				} else {
					$sq = isset($SaleRepArrs['SaleQuestion']) ? (is_object($SaleRepArrs['SaleQuestion']) ? $SaleRepArrs['SaleQuestion'] : (object)$SaleRepArrs['SaleQuestion']) : null;
				}
				$sqId = $sq ? ($sq->id ?? null) : null;
				if($sqId !== null && !empty($sqId)){
					$srName = $sr->name ?? $SaleRepArrs['SaleRep']['name'] ?? '';
					if ($srName !== '') {
						$totalsale[$sqId][] = $srName;
					}
				}
			}
						
			$color = array('warning','success','info','danger','info','primary','inverse');
			$i=0; 
			foreach($slatestype as $slatestypes){ 
				$sq = is_object($slatestypes) ? $slatestypes : (object)($slatestypes['SaleQuestion'] ?? $slatestypes);
				$sqId = $sq->id ?? null;
				$sqTitle = $sq->title ?? '';
				if ($sqId !== null && $sqTitle !== '') {
			?>
				<span class="label label-<?php echo $color[$i]; ?>">
				<?php echo h($sqTitle); ?> (<?php if(!empty($totalsale[$sqId])){ echo count($totalsale[$sqId]); }else{ echo '0'; } ?>)</span>
			<?php $i++; } }  ?>
			
			<span class="label label-inverse">
				Dailer Called (<?php echo is_countable($totallogs) ? count($totallogs) : 0; ?>)</span>			
			</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
				<th><?php echo $this->Paginator->sort('id'); ?></th>
				<th><?php echo $this->Paginator->sort('Contact Type'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('email'); ?></th>
				<th><?php echo $this->Paginator->sort('phone'); ?></th>
				<th><?php echo $this->Paginator->sort('company'); ?></th>
				<th><?php echo $this->Paginator->sort('spoken_to'); ?></th>
				<th><?php echo $this->Paginator->sort('sample_given_request'); ?></th>
				<th><?php echo $this->Paginator->sort('comment'); ?></th>				
				<th><?php echo $this->Paginator->sort('address'); ?></th>				
				<th><?php echo $this->Paginator->sort('Call Duration'); ?></th>				
				<th><?php echo $this->Paginator->sort('Recording'); ?></th>				
				<th><?php echo $this->Paginator->sort('created'); ?></th>				
               

				
				</tr>
				</thead>
				<tbody>
					<?php $i=1; foreach ($totallogs as $totallogss): 
						$log = is_object($totallogss) ? $totallogss : (object)($totallogss['Log'] ?? $totallogss);
						$client = null;
						if (is_object($totallogss)) {
							$client = $totallogss->client ?? null;
						} else {
							$client = isset($totallogss['Client']) ? (is_object($totallogss['Client']) ? $totallogss['Client'] : (object)$totallogss['Client']) : null;
						}
						$clientFname = $client ? ($client->fname ?? $totallogss['Client']['fname'] ?? '') : '';
						$clientLname = $client ? ($client->lname ?? $totallogss['Client']['lname'] ?? '') : '';
						$clientName = trim($clientFname . ' ' . $clientLname);
						$clientEmail = $client ? ($client->email ?? $totallogss['Client']['email'] ?? '') : '';
						$clientCompany = $client ? ($client->company ?? $totallogss['Client']['company'] ?? '') : '';
						$logPhone = $log->phone_number ?? $totallogss['Log']['phone_number'] ?? '';
						$logVoiceUrl = $log->voice_url ?? $totallogss['Log']['voice_url'] ?? '';
						$logCallDuration = $log->call_duration ?? $totallogss['Log']['call_duration'] ?? '';
						$logCreated = $log->created ?? $totallogss['Log']['created'] ?? '';
					?>
					<tr>
					<td>#<?php echo $i; ?>&nbsp;</td>
					<td>
						<span class="label label-danger">Dailer Called</span>					
					</td>
					<td><?php echo h($clientName); ?>&nbsp;</td>
					<td><?php echo h($clientEmail); ?>&nbsp;</td>
					<td><?php echo h($logPhone); ?>&nbsp;</td>
					<td><?php echo h($clientCompany); ?>&nbsp;</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td>
						<?php if(!empty($logVoiceUrl)){ ?>
							<?php echo h($logCallDuration); ?> Sec
						<?php  }else{	echo '--';	}	?>
					</td>
					<td style="text-align:center;">
						<?php if(!empty($logVoiceUrl)){ ?>							
							<a href="<?php echo h($logVoiceUrl); ?>" target="_blank" ><i class="fa fa-play" style="font-size:20px;"></i></a>
						<?php  }else{	echo '--';	}	?>
					</td>
					<td><?php echo $logCreated ? date('d M Y h:i a', strtotime($logCreated)) : ''; ?></td>
					<?php $i++; endforeach; ?>
					
					<?php  $j = $i + 1; foreach ($SaleRepArr as $SaleRepArrs): 
						$sr = is_object($SaleRepArrs) ? $SaleRepArrs : (object)($SaleRepArrs['SaleRep'] ?? $SaleRepArrs);
						$sq = null;
						if (is_object($SaleRepArrs)) {
							$sq = $SaleRepArrs->sale_question ?? null;
						} else {
							$sq = isset($SaleRepArrs['SaleQuestion']) ? (is_object($SaleRepArrs['SaleQuestion']) ? $SaleRepArrs['SaleQuestion'] : (object)$SaleRepArrs['SaleQuestion']) : null;
						}
						$sqId = $sq ? ($sq->id ?? null) : null;
						$sqTitle = $sq ? ($sq->title ?? '') : '';
						$srName = $sr->name ?? $SaleRepArrs['SaleRep']['name'] ?? '';
						$srEmail = $sr->email ?? $SaleRepArrs['SaleRep']['email'] ?? '';
						$srPhone = $sr->phone ?? $SaleRepArrs['SaleRep']['phone'] ?? '';
						$srCompany = $sr->company ?? $SaleRepArrs['SaleRep']['company'] ?? '';
						$srSpokenTo = $sr->spoken_to ?? $SaleRepArrs['SaleRep']['spoken_to'] ?? '';
						$srSampleGiven = $sr->sample_given_request ?? $SaleRepArrs['SaleRep']['sample_given_request'] ?? '';
						$srComment = $sr->comment ?? $SaleRepArrs['SaleRep']['comment'] ?? '';
						$srAddress = $sr->address ?? $SaleRepArrs['SaleRep']['address'] ?? '';
						$srCreated = $sr->created ?? $SaleRepArrs['SaleRep']['created'] ?? '';
					?>
					<tr>
					<td>#<?php echo $j; ?>&nbsp;</td>
					<td>
					<?php 
					if($sqId == 1){
						echo '<span class="label label-warning">'.h($sqTitle).'</span>';
					}else if($sqId == 2){
						echo '<span class="label label-success">'.h($sqTitle).'</span>';
					}else if($sqId == 3){
						echo '<span class="label label-info">'.h($sqTitle).'</span>';
					}else{
						echo '<span class="label label-danger">'.h($sqTitle).'</span>';
					}
					?>
					</td>
					<td><?php echo h($srName); ?>&nbsp;</td>
					<td><?php echo h($srEmail); ?>&nbsp;</td>
					<td><?php echo h($srPhone); ?>&nbsp;</td>
					<td><?php echo h($srCompany); ?>&nbsp;</td>					
					<td><?php echo h($srSpokenTo); ?>&nbsp;</td>					
					<td><?php echo h($srSampleGiven); ?>&nbsp;</td>					
					<td><?php echo h($srComment); ?>&nbsp;</td>					
					<td><?php echo h($srAddress); ?>&nbsp;</td>	
					<td>N/A</td>
					<td>N/A</td>					
					<td><?php echo $srCreated ? date('d M Y h:i a', strtotime($srCreated)) : ''; ?>&nbsp;</td>					
					
					</tr>
					<?php $j++; endforeach; ?>

				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter([
'format' => __('showing {{current}} records out of {{count}} entries')
]); ?>	</div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_simple_numbers" id="dynamic-table_paginate">
			<ul class="pagination">
				<li class="paginate_button previous disabled" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_previous"><?php
				echo $this->Paginator->prev('< ' . __('previous'), [], null, ['class' => 'prev disabled']); ?></li>
				
				<li class="paginate_button next" aria-controls="dynamic-table" tabindex="0" id="dynamic-table_next"><?php echo $this->Paginator->next(__('next') . ' >', [], null, ['class' => 'next disabled']); ?></li>
				
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