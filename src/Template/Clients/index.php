	<style>
		select {
			padding: 0px 4px;
			height: 29px;
			width: 205px;
			font-size: 14px;
		}
		.label {			
			margin-top: 5px;
		}
		.table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
			padding: 0px 5px 0px !important;
			line-height: 1px !important;
		}
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Clients Management 
			<?php echo $this->Html->link('Add New',array('controller' => 'clients','action' => 'add'),array('class'=>'btn btn-info btn-xs top-button')); ?>
			
			<?= $this->Form->create(null, ['url' => ['action' => 'index'], 'type' => 'post', 'style' => 'float:right;']) ?>
				<select name="data[category_id]" style="width:160px;">
					<option value="">Select Category </option>
					<?php foreach (($ClientTypeArr ?? []) as $ClientTypeArrs) {
						$ct = $ClientTypeArrs['ClientType'] ?? $ClientTypeArrs;
						$ctId = is_array($ct) ? ($ct['id'] ?? '') : ($ct->id ?? '');
						$ctName = is_array($ct) ? ($ct['name'] ?? '') : ($ct->name ?? '');
						?>
						<option <?php if (isset($category_id) && $category_id == $ctId) echo 'selected'; ?> value="<?php echo h($ctId); ?>"><?php echo h($ctName); ?></option>
					<?php } ?>
				</select>
				<input type="search" name="search" placeholder="Search  name or email or phone" value="<?php echo $search; ?>" style="width:220px">
				<input type="submit"  class="btn btn-xs btn-primary" value="Search">
				
				<a class="btn btn-xs btn-warning" href="<?php echo SITEURL.'clients/index/clear'; ?>" >Clear All</a>
				<a class="btn btn-xs btn-info" href="#null" onclick="return dialclients()">Dial Number</a>
			<?= $this->Form->end() ?>
				
			</h1>
			
			
		</div>
	
	<form action="<?php echo SITEURL.'admin/clients/assign'?>" method="post">

	<div class="row">
	
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>				
				<th>Dial</th>
				<th><?php echo $this->Paginator->sort('chat'); ?></th>
				<!-- <th><?php echo $this->Paginator->sort('id'); ?></th> -->
				
				<th><?php echo $this->Paginator->sort('Category_id','Category Name'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('email'); ?></th>
				<th>#<?php echo $this->Paginator->sort('mobile'); ?></th>
				<th>#<?php echo $this->Paginator->sort('landline'); ?></th>
				<th><?php echo $this->Paginator->sort('company'); ?></th>
		
				<th><?php echo $this->Paginator->sort('address'); ?></th>				
				<th>Action</th>				
               
				</tr>
				</thead>
				<tbody>
					
						<?php
					$clientArr = $clientArr ?? [];
					$i = 1;
					foreach ($clientArr as $clientArrs):
						$isEntity = is_object($clientArrs);
						$cid = $isEntity ? ($clientArrs->id ?? '') : ($clientArrs['Client']['id'] ?? '');
						$cfname = $isEntity ? ($clientArrs->fname ?? '') : ($clientArrs['Client']['fname'] ?? '');
						$cemail = $isEntity ? ($clientArrs->email ?? '') : ($clientArrs['Client']['email'] ?? '');
						$cmobile = $isEntity ? ($clientArrs->mobile ?? '') : ($clientArrs['Client']['mobile'] ?? '');
						$clandline = $isEntity ? ($clientArrs->landline ?? '') : ($clientArrs['Client']['landline'] ?? '');
						$ccompany = $isEntity ? ($clientArrs->company ?? '') : ($clientArrs['Client']['company'] ?? '');
						$ccatId = $isEntity ? ($clientArrs->category_id ?? '') : ($clientArrs['Client']['category_id'] ?? '');
						$catName = '';
						if ($isEntity) {
							$ctAssoc = $clientArrs->client_type ?? $clientArrs->client_types ?? null;
							$catName = ($ctAssoc && is_object($ctAssoc)) ? ($ctAssoc->name ?? '') : '';
						} elseif (!empty($clientArrs['ClientType']['name'])) {
							$catName = $clientArrs['ClientType']['name'];
						}
						if ($catName === '' && $ccatId !== '' && !empty($ClientTypeArr)) {
							foreach ($ClientTypeArr as $ctRow) {
								$ct = $ctRow['ClientType'] ?? $ctRow;
								$ctId = is_array($ct) ? ($ct['id'] ?? null) : ($ct->id ?? null);
								if ((string)$ctId === (string)$ccatId) {
									$catName = is_array($ct) ? ($ct['name'] ?? '') : ($ct->name ?? '');
									break;
								}
							}
						}
						$staffList = [];
						if ($isEntity && !empty($clientArrs->staff_clients)) {
							foreach ($clientArrs->staff_clients as $sc) {
								$nu = $sc->napp_user ?? null;
								if ($nu) $staffList[] = trim(($nu->name ?? '') . ' ' . ($nu->lname ?? ''));
							}
						} elseif (!empty($clientArrs['StaffClient'])) {
							foreach ($clientArrs['StaffClient'] as $StaffClients) {
								$staffList[] = trim(($StaffClients['NappUser']['name'] ?? '') . ' ' . ($StaffClients['NappUser']['lname'] ?? ''));
							}
						}
						$cleintname = implode(' , ', $staffList);
					?>
							<tr>
							<td><input type="checkbox" value="<?php echo h($cid); ?>" name="dialnumber" class="ckbCheckAll"></td>
							<td><a href="#null" onclick="openpoup(<?php echo (int)$cid; ?>)"><i class="fa fa-comment"></i></a></td>
							<td><input type="text" value="<?php echo h($catName); ?>" style="border: 0px;width: 350px !important;"></td>
							<td><?php if ($cfname !== '') { ?><input type="text" value="<?php echo h($cfname); ?>" style="border: 0px;width: 150px !important;"><?php } ?></td>
							<td><input type="text" value="<?php echo h($cemail); ?>" style="border: 0px;width: 350px !important;"></td>
							<td><input type="text" value="<?php echo h($cmobile); ?>" style="border: 0px;width: 130px !important;"></td>
							<td><input type="text" value="<?php echo h($clandline); ?>" style="border: 0px;width: 130px !important;"></td>
							<td><input type="text" value="<?php echo h($ccompany); ?>" style="border: 0px;width: 160px !important;"></td>
							<td><span class="label label-info"><?php echo h($cleintname); ?></span></td>
							<td>
							<?php
								if ((int)$ccatId === 13) {
									echo $this->Html->link('Edit', ['controller' => 'clients', 'action' => 'edit', $cid], ['class' => 'btn btn-primary btn-xs top-button']);
								} else {
									echo 'N/A';
								}
							?>
							</td>
							</tr>
						<?php $i++; endforeach; ?>
					
				</tbody>
			</table>			
			</div>
		</div>
	</div>		
	</form>
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="dynamic-table_info" role="status" aria-live="polite"><?php	echo $this->Paginator->counter(array(
'format' => __('showing {{current}} records out of {{count}} entries')));?>	</div>
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
<a href="#null"  data-toggle="modal" data-target="#myModal_new" id="myModalNew"><i></i></a>
<div id="myModal_new" class="modal fade" role="dialog">
  <div class="modal-dialog">


	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Client Comments  </h4>
	  </div>
	  <div class="modal-body">
			<iframe src="" id="abc_frame" style="width:100%; border:none; height:400px;"></iframe>
	  </div>      
	</div>

  </div>
</div>

<script>

function openpoup(id){
	var url = '<?php echo SITEURL.'clients/comment/' ?>'+id;
	$('#abc_frame').attr('src', url);
	$("#myModalNew").trigger('click');	
}


$(document).ready(function () {
	$('#ckbCheckAll').on('click',function(){
		if(this.checked){
			$('.checkBoxClass').each(function(){
				this.checked = true;
			});
		}else{
			 $('.checkBoxClass').each(function(){
				this.checked = false;
			});
		}
	});
});
var favorite = [];
$(document).ready(function () {
	$(".ckbCheckAll").click(function(){
		$.each($("input[name='dialnumber']:checked"), function(){            
			favorite.push($(this).val());
		});
	});
});
function onlyUnique(value, index, self) { 
    return self.indexOf(value) === index;
}
function dialclients(){
	var unique = favorite.filter( onlyUnique );
	if (unique.length !== 0) {
		$.ajax({
			url: "<?php  echo SITEURL ?>clients/addclientdialers",
			type: "POST",
			data: {client_list:unique},
			dataType: "html",
			success: function(response) {
				window.location.href="<?php echo SITEURL;?>dialers";
			}
		});
	}else{
		alert("Please select clients");
		return false;
	}
}
</script>