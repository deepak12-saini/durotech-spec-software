	<style>
		.ErrorField{
			border-color: red !important;
		}	
		.ValidationErrors{ display:none; }
	
	</style>
	<div class="page-content">
		<div class="page-header">
			<h1><i class="menu-icon fa fa-share" style="color:#438eb9;"></i> Sheets <!--a href="javascript:void" data-toggle="modal" data-target="#myModal" class="btn btn-xs btn-primary" > <i class="menu-icon fa fa-plus"></i> Add </a--> </h1>
		</div>
		
		<form action="" method="post" >
		<!--button type="submit" class="btn btn-sm btn-primary" id="delete" style="margin-bottom:5px; padding:0px 12px; display:none;" onclick="return confirm('Are you sure delete?')"><i class="menu-icon fa fa-trash "></i> Delete</button--->
		<div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="simple-table" >
					<thead>
					<tr>
					<!--th><input type="checkbox" id="ckbCheckAll" ></th-->
					<th><?php echo $this->Paginator->sort('name'); ?></th>
					<th><?php echo $this->Paginator->sort('is_shared','Sharing Status'); ?></th>
					<th><?php echo $this->Paginator->sort('Owner'); ?></th>
					<th><?php echo $this->Paginator->sort('created','Last Update'); ?></th>
					<!--th></th-->
					</tr>
					</thead>
					<tbody>						
						<?php foreach ($SsSheetCategory as $SsSheetCategorys): ?>
						<tr>
							<!--td>
							<input type="checkbox" class="checkBoxClass" name="sheetId[]" value="<?php echo h($SsSheetCategorys['SsSheetCategory']['id']); ?>" >
							&nbsp;</td-->
							<td><a href="<?php echo SITEURL.'sheets/sheet/'.$SsSheetCategorys['SsSheetCategory']['id']; ?>"><i class="menu-icon fa fa-file "></i> <?php echo h($SsSheetCategorys['SsSheetCategory']['name']); ?></a>&nbsp;</td>
							<td>
							<?php 
								if($SsSheetCategorys['SsSheetCategory']['is_shared'] == 'Shared'){
									echo '<span class="label label-success">'.$SsSheetCategorys['SsSheetCategory']['is_shared'].'</span>';
								}else{
									echo '<span class="label label-danger">'.$SsSheetCategorys['SsSheetCategory']['is_shared'].'</span>';
								}
							?>&nbsp
							
							<td>
							<?php 
								if($SsSheetCategorys['SsSheetCategory']['createdby'] == 'Admin'){
									echo $SsSheetCategorys['User']['email'];
								}else{
									echo $SsSheetCategorys['NappUser']['email'];
								}
							?>&nbsp;
							</td>
						
							<td> <?php echo date('d-M-Y h:i a',strtotime($SsSheetCategorys['SsSheetCategory']['created'])); ?></td>
							<!--td> 
								<a href="javascript:void" class="btn btn-xs btn-defult" onclick="openmodal(<?php echo $SsSheetCategorys['SsSheetCategory']['id']; ?>)"><i class="menu-icon fa fa-user "></i> Share</a>
								
								<a href="javascript:void" class="btn btn-xs btn-info" onclick="openmodalforcolumn(<?php echo $SsSheetCategorys['SsSheetCategory']['id']; ?>)"><i class="menu-icon fa fa-user "></i> Add /Edit Columns </a>
							</td-->
							
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>			
				</div>
			</div>
		</div>		
	</form>		
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
<a href="javascript:void"  data-toggle="modal" data-target="#mySharedModal" id="linkmySharedModal">&nbsp;</a>
<div id="mySharedModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><i class="menu-icon fa fa-file"></i> Sheet Sharing</h4>
	  </div>
	  <div class="modal-body">
		<iframe frameborder="0" id="iframe-id" scrolling="yes" src="" style="width: 100%;height: 430px;" ></iframe>	
	  </div>	 
	</div>
  </div>
</div>	

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title">Add New Sheet</h4>
	  </div>
	  <div class="modal-body">
		<div class="row">
		<div class="col-xs-12">
		
			<form action="<?php echo SITEURL.'sheets/addnew'?>" method="post" > 
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name: </label>
					<div class="col-sm-9">
						<input type="text" name="data[SsSheetCategory][name]" class='col-xs-10 col-sm-5' placeholder="Sheet Name" id='sheet_name'>&nbsp;&nbsp;		
						<button type="submit" class="btn btn-sm btn-primary" ><i class="menu-icon fa fa-plus "></i> </button>	
							
					</div>
				</div>				
			</form>
		</div>
		</div>	
	  </div>	 
	</div>
  </div>
</div>	
<a href="javascript:void"  data-toggle="modal" data-target="#mySharedModals" id="linkmySharedModald">&nbsp;</a>
<div id="mySharedModals" class="modal fade" role="dialog">
  <div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
	  <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">&times;</button>
		<h4 class="modal-title"><i class="menu-icon fa fa-file"></i> Add/Edit Columns</h4>
	  </div>
	  <div class="modal-body">
		<iframe frameborder="0" id="iframe-share-id" scrolling="yes" src="" style="width: 100%;height: 430px;" ></iframe>	
	  </div>	 
	</div>
  </div>
</div>
<script>
function openmodal(arg){	
	var url = '<?php echo SITEURL.'sheets/share/'; ?>'+arg;
	$('#iframe-id').attr('src', url);
	$("#linkmySharedModal").trigger('click');
}
function openmodalforcolumn(arg){	
	var url = '<?php echo SITEURL.'sheets/column/'; ?>'+arg;
	$('#iframe-share-id').attr('src', url);
	$("#linkmySharedModald").trigger('click');
}

function closeIframe(){
	$(".close").trigger('click');
}
	
jQuery(function(){ 
		
	$("#sheet_name").validate({
		 expression: "if (VAL) return true; else return false;",
		message: ""
	}); 
});
$(document).ready(function () {
	
	$('.checkBoxClass').on('click',function(){
		if(this.checked){			
			$("#delete").show();
		}
	});
	$('#ckbCheckAll').on('click',function(){
		if(this.checked){
			$('.checkBoxClass').each(function(){
				this.checked = true;
			});
			$("#delete").show();
		}else{
			 $('.checkBoxClass').each(function(){
				this.checked = false;
			});
			$("#delete").hide();
		}
	});
});
</script>