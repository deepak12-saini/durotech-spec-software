<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>	
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><?php echo $this->Html->link('Back', ['controller' => 'BroucherProducts', 'action' => 'admin_index'], ['class' => 'btn btn-inverse']); ?></div>
		<h1>Broucher Product<small><i class="ace-icon fa fa-angle-double-right"></i> Edit Product</small>
		</h1>
	</div>

	<div class="row">
		<div class="col-xs-12">
	
		<?php
			$editUrl = ['controller' => 'BroucherProducts', 'action' => 'admin_edit', $product_arr['BroucherProduct']['id'] ?? null];
			echo $this->Form->create(null, [
				'url' => $editUrl,
				'type' => 'post',
				'class' => 'form-horizontal',
				'role' => 'form',
				'enctype' => 'multipart/form-data'
			]);
		?>
		<input type="hidden" name="data[BroucherProduct][id]" value="<?php echo h($product_arr['BroucherProduct']['id'] ?? ''); ?>">
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Broucher Category: </label>
				<div class="col-sm-9">				
					<select class="col-xs-10 col-sm-5" name="data[BroucherProduct][boucher_cate_id]" id="boucher_cate_id">
						<option value="">select broucher category </option>
							<?php foreach($BorucherCategory as $BorucherCategorys){?>
								<option <?php if($BorucherCategorys['BorucherCategory']['id']== $product_arr['BroucherProduct']['boucher_cate_id']){ echo 'selected'; }?> value="<?php echo $BorucherCategorys['BorucherCategory']['id']?>" ><?php echo $BorucherCategorys['BorucherCategory']['title']?></option>
							<?php }?>				
					</select>	
					
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category: </label>
				<div class="col-sm-9">
				
					<select class="col-xs-10 col-sm-5" name="data[BroucherProduct][category_id]" id="category_id">
					
						<?php foreach($category as $category_arr){?>
							<option value="<?php echo $category_arr['Category']['id']?>" <?php if($category_arr['Category']['id']== $product_arr['BroucherProduct']['category_id']){ echo 'selected';}?>><?php echo $category_arr['Category']['category_name']?></option>
						<?php }?>
					</select>

				</div>
			</div>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Name : </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][title]" id="product_name" class="col-xs-10 col-sm-5" value="<?php echo $product_arr['BroucherProduct']['title']?>"placeholder="Product Name">

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Code : </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][product_code]" id="product_code" class="col-xs-10 col-sm-5" placeholder="Product Code" value="<?php echo $product_arr['BroucherProduct']['product_code']?>">

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Brief Description : </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][brief_description]" id="brief_description" class="col-xs-10 col-sm-5" placeholder="Brief Description"><?php echo $product_arr['BroucherProduct']['brief_description']?></textarea>

				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description : </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][description]" id="description"  class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><?php echo $product_arr['BroucherProduct']['description']?></textarea>

				</div>
			</div>	
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Featured: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][feature]" id="feature"  class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><?php echo $product_arr['BroucherProduct']['feature']?></textarea>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> User Area: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][userarea]" id="userarea"  class="ckeditor col-xs-10 col-sm-5" placeholder="Description"><?php echo $product_arr['BroucherProduct']['userarea']?></textarea>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Process: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][process]" id="process" class="ckeditor col-xs-10 col-sm-5" placeholder="Process"><?php echo $product_arr['BroucherProduct']['process']?></textarea>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Instruction: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][instruction]" id="instruction"  class="ckeditor col-xs-10 col-sm-5" placeholder="Instruction"><?php echo $product_arr['BroucherProduct']['instruction']?></textarea>

				</div>
			</div>
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Technical Literature : </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][datasheet]" id="datasheet" class="col-xs-10 col-sm-5" value="<?php echo $product_arr['BroucherProduct']['datasheet']?>"  placeholder="Technical Literature">

				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product MSDS : </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][msds]" id="msds" class="col-xs-10 col-sm-5" value="<?php echo $product_arr['BroucherProduct']['msds']?>"  placeholder="Product MSDS">

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Voc sheet : </label>
				<div class="col-sm-9">
					<input type="text"  value="<?php echo $product_arr['BroucherProduct']['voc_pdf']?>"  name="data[BroucherProduct][voc_pdf]" id="voc" class="col-xs-10 col-sm-5" placeholder="Voc sheet">

				</div>
			</div>
			
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Image : </label>
				<div class="col-sm-9">
					<input type="file" name="data[BroucherProduct][image]"  class="col-xs-10 col-sm-5">

				</div>
			</div>
			<?php if(!empty($product_arr['BroucherProduct']['image'])){ ?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Preview Image : </label>
				<div class="col-sm-9">
					<img style="height:50px; width:50px"src="<?php echo SITEURL.'productimg/'.$product_arr['BroucherProduct']['image']?>">

				</div>
			</div>				
			<?php }?>
			
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Video Url : </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][video_url]"  value="<?php echo $product_arr['BroucherProduct']['video_url']?>" class="col-xs-10 col-sm-5">
				</div>
			</div>
			<div class="form-group">
					<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Product Type : </label>
						<div class="col-sm-9">
						<?php 
						
						if($product_arr['BroucherProduct']['product_type'] == 1){  $normal_inactive=''; $product_active='checked';$product_inactive=''; }else if($product_arr['BroucherProduct']['product_type'] == 2) {   $normal_inactive=''; $product_active='';$product_inactive='checked';}else{
						$product_active=''; $product_inactive=''; $normal_inactive='checked'; 
						}
						
						?>
						<div class="radio"><label>
						<input type="radio"  value="0" <?php echo $normal_inactive; ?>  class="ace" id="ServiceCategoryActive1" name="data[BroucherProduct][product_type]"><span class="lbl"> Normal Product</span>
						</label></div>
						
						<div class="radio"><label>
						<input type="radio"  value="1" <?php echo $product_active; ?>  class="ace" id="ServiceCategoryActive1" name="data[BroucherProduct][product_type]"><span class="lbl"> Product Type</span>
						</label></div>
						
						<div class="radio"><label>
							<input type="radio" value="2" class="ace" <?php echo $product_inactive; ?> id="ServiceCategoryActive0" name="data[BroucherProduct][product_type]"><span class="lbl"> By Use</span>
						</label></div>
						
						
					</div>
				</div>
				<div class="form-group">
					<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Status : </label>
						<div class="col-sm-9">
						<?php if($product_arr['BroucherProduct']['status'] == 1) { $active='checked';$inactive='';}else{  $active='';$inactive='checked';}?>
						
						<div class="radio"><label>
						<input type="radio"  value="1" <?php echo $active; ?>  class="ace" id="ServiceCategoryActive1" name="data[BroucherProduct][status]"><span class="lbl"> Active</span>
						</label></div>
						
						<div class="radio"><label>
							<input type="radio" value="0" class="ace" <?php echo $inactive; ?> id="ServiceCategoryActive0" name="data[BroucherProduct][status]"><span class="lbl"> Inactive</span>
						</label></div>
						
						
					</div>
				</div>
				<div class="form-group">
					<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Featured : </label>
						<div class="col-sm-9">
						<?php if($product_arr['BroucherProduct']['is_featured'] == 1) { $active='checked';$inactive='';}else{  $active='';$inactive='checked';}?>
						
						<div class="radio"><label>
						<input type="radio"  value="1" <?php echo $active; ?>  class="ace" id="ServiceCategoryActive1" name="data[BroucherProduct][is_featured]"><span class="lbl"> Featured</span>
						</label></div>
						
						<div class="radio"><label>
							<input type="radio" value="0" class="ace" <?php echo $inactive; ?> id="ServiceCategoryActive0" name="data[BroucherProduct][is_featured]"><span class="lbl"> Non featured</span>
						</label></div>
						
						
					</div>
				</div>
				<div class="form-group">
			<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Is Image : </label>
				<div class="col-sm-9">
				
				<?php if($product_arr['BroucherProduct']['is_image'] == 1){ $inactives='checked'; $actives='';}else{  $inactives='';$actives='checked';}?>
						
				<div class="radio"><label>
				<input type="radio"  value="0"  <?php echo $actives; ?> class="ace" id="CategoryActive1" name="data[BroucherProduct][is_image]"><span class="lbl"> Yes Image</span>
				</label></div>
				
				<div class="radio"><label>
					<input type="radio"  <?php echo $inactives; ?> value="1"  class="ace" id="CategoryActive0" name="data[BroucherProduct][is_image]"><span class="lbl">
					No Image</span>
				</label></div>				
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
					<?php echo $this->Html->link('Cancel', ['controller' => 'BroucherProducts', 'action' => 'admin_index'], ['class' => 'btn btn-danger']); ?>

				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>
</div>	

<script type="text/javascript">
jQuery(function(){ 

	$("#boucher_cate_id").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select broucher category"
	});$("#product_name").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter  product name"
	});  $("#price_euro").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter price_euro"
	}); $("#price_dollar").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter price_dollar"
	});  $("#stock").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter stock"
	}); $("#category_id").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select category"
	});  $("#sub_category_id").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select sub category"
	}); 
});
</script>
