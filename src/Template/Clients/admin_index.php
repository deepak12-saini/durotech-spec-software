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
		.table > thead > tr > th, .table > tbody > tr > th, .table > tfoot > tr > th, .table > thead > tr > td, .table > tbody > tr > td, .table > tfoot > tr > td {
			padding: 0px 5px 0px !important;
			line-height: 1px !important;
		}
		
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1>Clients Management 
			
			<?php echo $this->Html->link('Import csv', $this->Url->build(['controller' => 'Clients', 'action' => 'admin_import']), ['class' => 'btn btn-danger btn-sm top-button']); ?>
			<?php echo $this->Html->link('Add New', $this->Url->build(['controller' => 'Clients', 'action' => 'admin_add']), ['class' => 'btn btn-info btn-sm top-button']); ?>
			<button type="button" class="btn btn-warning btn-sm top-button" data-toggle="modal" data-target="#myModal">Client Category</button>

			<?php echo $this->Form->create(null, ['url' => ['controller' => 'Clients', 'action' => 'admin_index'], 'style' => 'float:right;']); ?>
				<select name="client_id" style="width:160px;">
					<option value="">Select Sales Person</option>
					<?php foreach ($cuser as $cusers): $cu = is_object($cusers) ? $cusers : (object)$cusers; $cuid = $cu->id ?? $cusers['NappUser']['id'] ?? ''; $cuname = trim(($cu->name ?? '') . ' ' . ($cu->lname ?? '')); ?>
						<option <?php if ((string)$client_id === (string)$cuid) echo 'selected'; ?> value="<?php echo h($cuid); ?>"><?php echo h($cuname); ?></option>
					<?php endforeach; ?>
				</select>
				<select name="category_id" style="width:160px;">
					<option value="">Select Category</option>
					<?php foreach ($ClientTypeArr as $ClientTypeArrs): $ct = is_object($ClientTypeArrs) ? $ClientTypeArrs : (object)($ClientTypeArrs['ClientType'] ?? $ClientTypeArrs); ?>
						<option <?php if ((string)$category_id === (string)($ct->id ?? '')) echo 'selected'; ?> value="<?php echo h($ct->id ?? ''); ?>"><?php echo h($ct->name ?? ''); ?></option>
					<?php endforeach; ?>
				</select>
				<input type="search" name="search" placeholder="Search name or email or phone" value="<?php echo h($search ?? ''); ?>" style="width:220px">
				<?php echo $this->Form->submit('Search', ['class' => 'btn btn-xs btn-primary']); ?>
				<a class="btn btn-xs btn-warning" href="<?php echo $this->Url->build(['controller' => 'Clients', 'action' => 'admin_index', 'clear']); ?>">Clear All</a>
			<?php echo $this->Form->end(); ?>
				
			</h1>
			
			
		</div>
	
	<?php echo $this->Form->create(null, ['url' => $this->Url->build('/admin/clients/assign')]); ?>
	<div style="margin-bottom:10px;">
	<select name="client_id" onchange="selected(this.value)">
		<option value="">Select Sales Person</option>
		<?php foreach ($cuser as $cusers): $cu = is_object($cusers) ? $cusers : (object)$cusers; $cuid = $cu->id ?? $cusers['NappUser']['id'] ?? ''; $cuname = trim(($cu->name ?? '') . ' ' . ($cu->lname ?? '')); ?>
			<option <?php if ((string)$clientId === (string)$cuid) echo 'selected'; ?> value="<?php echo h($cuid); ?>"><?php echo h($cuname); ?></option>
		<?php endforeach; ?>
	</select>
	<?php echo $this->Form->submit('Assign Client', ['class' => 'btn btn-xs btn-info', 'style' => 'margin-bottom:4px;']); ?>
	</div>
	<div class="row">
	
		<div class="col-xs-12">
			<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover" id="simple-table" >
				<thead>
				<tr>
				<th><input type="checkbox" id="ckbCheckAll" ></th>
				<th><?php echo $this->Paginator->sort('chat'); ?></th>
				<!-- <th><?php echo $this->Paginator->sort('id'); ?></th> -->
				
				<th><?php echo $this->Paginator->sort('Category_id','Category Name'); ?></th>
				<th><?php echo $this->Paginator->sort('name'); ?></th>
				<th><?php echo $this->Paginator->sort('email'); ?></th>
				<th>#<?php echo $this->Paginator->sort('mobile'); ?></th>
				<th>#<?php echo $this->Paginator->sort('landline'); ?></th>
				<th><?php echo $this->Paginator->sort('company'); ?></th>
				<th><?php echo $this->Paginator->sort('Assign Staff'); ?></th>
				<!-- th><?php echo $this->Paginator->sort('job_title'); ?></th-->
				<th><?php echo $this->Paginator->sort('address'); ?></th>				
                
                <th><?php echo $this->Paginator->sort('status'); ?></th>

				<th class="actions"><?php echo __('Actions'); ?></th>
				</tr>
				</thead>
				<tbody>
					
						<?php $i = 1; foreach ($clientArr as $clientArrs):
							$c = is_object($clientArrs) ? $clientArrs : (object)$clientArrs;
							$cid = $c->id ?? $clientArrs['Client']['id'] ?? '';
							$ctName = $c->client_type->name ?? $clientArrs['ClientType']['name'] ?? '';
							$fname = $c->fname ?? $clientArrs['Client']['fname'] ?? '';
							$email = $c->email ?? $clientArrs['Client']['email'] ?? '';
							$mobile = $c->mobile ?? $clientArrs['Client']['mobile'] ?? '';
							$landline = $c->landline ?? $clientArrs['Client']['landline'] ?? '';
							$company = $c->company ?? $clientArrs['Client']['company'] ?? '';
							$address1 = $c->address1 ?? $clientArrs['Client']['address1'] ?? '';
							$status = (int)($c->status ?? $clientArrs['Client']['status'] ?? 0);
							$staffClients = $c->staff_clients ?? $clientArrs['StaffClient'] ?? [];
							$cleintname = '';
							foreach ($staffClients as $sc) {
								$nu = is_object($sc) ? ($sc->napp_user ?? null) : ($sc['NappUser'] ?? null);
								if ($nu) {
									$cleintname .= (is_object($nu) ? trim(($nu->name ?? '') . ' ' . ($nu->lname ?? '')) : trim(($nu['name'] ?? '') . ' ' . ($nu['lname'] ?? ''))) . ' , ';
								}
							}
						?>
							<tr>
							<td>
								<input type="checkbox" <?php if (in_array((string)$cid, array_map('strval', $StaffClientArr ?? []))) echo 'checked'; ?> class="checkBoxClass" value="<?php echo h($cid); ?>" name="selectids[]">
							</td>
							<td><a href="#null" onclick="openpoup(<?php echo (int)$cid; ?>)"><i class="fa fa-comment"></i></a></td>
							<td><input type="text" value="<?php echo h($ctName); ?>" style="border: 0px;width: 350px !important;" readonly></td>
							<td><input type="text" value="<?php echo h($fname); ?>" style="border: 0px;width: 150px !important;" readonly></td>
							<td><input type="text" value="<?php echo h($email); ?>" style="border: 0px;width: 350px !important;" readonly></td>
							<td><input type="text" value="<?php echo h($mobile); ?>" style="border: 0px;width: 130px !important;" readonly></td>
							<td><input type="text" value="<?php echo h($landline); ?>" style="border: 0px;width: 130px !important;" readonly></td>
							<td><input type="text" value="<?php echo h($company); ?>" style="border: 0px;width: 160px !important;" readonly></td>
							<td><span class="label label-info"><?php echo h($cleintname); ?></span></td>
							<td><input type="text" value="<?php echo h($address1); ?>" style="border: 0px;width: 400px !important;" readonly></td>
							<td><?php echo $status === 1 ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Deactive</span>'; ?></td>
							<td><?php echo $this->Html->link('Edit', $this->Url->build(['controller' => 'Clients', 'action' => 'admin_edit', $cid]), ['class' => 'label label-primary']); ?></td>
							</tr>
						<?php $i++; endforeach; ?>
					
				</tbody>
			</table>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
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
<div id="myModal_new" class="modal fade" role="dialog" >
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

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content" style="height:500px;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Client Category </h4>
      </div>
      <div class="modal-body">
			<iframe src="<?php echo $this->Url->build(['controller' => 'Clients', 'action' => 'admin_clienttype']); ?>" style="width:100%; border:none; height:400px;"></iframe>
      </div>      
    </div>

  </div>
</div>
<script>

function openpoup(id){
	var baseUrl = "<?php echo $this->Url->build('/admin/clients/comment/'); ?>";
	var url = baseUrl + id;
	$('#abc_frame').attr('src', url);
	$("#myModalNew").trigger('click');	
}

function selected(id){
	var baseUrl = "<?php echo $this->Url->build('/admin/clients/index/'); ?>";
	window.location.href = baseUrl + (id ? id : '');
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
</script>