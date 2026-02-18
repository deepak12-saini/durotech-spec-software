	<script src="<?php echo SITEURL; ?>ckeditor/ckeditor.js"></script>
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><?php echo $this->Html->link('Back', ['controller' => 'BroucherProducts', 'action' => 'admin_index'], ['class' => 'btn btn-inverse']); ?></div>
		<h1>Broucher Product<small><i class="ace-icon fa fa-angle-double-right"></i> Add Product</small>
		</h1>
		</div>
	
	<div class="row">
		<div class="col-xs-12">
	
		<?php echo $this->Form->create('BroucherProduct',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Category: </label>
				<div class="col-sm-9">
				
					<select class="col-xs-10 col-sm-5" name="data[BroucherProduct][category_id]" id="category_id">
					<option value="">Please select  category </option>
						<?php foreach($category as $category_arr){?>
							<option value="<?php echo $category_arr['Category']['id']?>" ><?php echo $category_arr['Category']['category_name']?></option>
						<?php }?>
					</select>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Broucher Category: </label>
				<div class="col-sm-9">				
					<select class="col-xs-10 col-sm-5" name="data[BroucherProduct][boucher_cate_id]" id="boucher_cate_id">
						<option value="">select broucher category </option>
							<?php foreach($BorucherCategory as $BorucherCategorys){?>
							<option value="<?php echo $BorucherCategorys['BorucherCategory']['id']?>" ><?php echo $BorucherCategorys['BorucherCategory']['title']?></option>
						<?php }?>				
					</select>	
					
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Name: </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][title]" id="product_name" class="col-xs-10 col-sm-5" placeholder="Product Name">

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Product Code: </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][product_code]" id="product_code" class="col-xs-10 col-sm-5" placeholder="Product Code" value="<?php echo $product_code?>">

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Brief Description: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][brief_description]" id="brief_description" class="col-xs-10 col-sm-5" placeholder="Brief Description"></textarea>

				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Description: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][description]" id="description" class="ckeditor col-xs-10 col-sm-5" placeholder="Description"></textarea>

				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Featured: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][feature]" id="feature"  class="ckeditor col-xs-10 col-sm-5" placeholder="Description"></textarea>

				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> User Area: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][userarea]" id="userarea"  class="ckeditor col-xs-10 col-sm-5" placeholder="Description"></textarea>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Process: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][process]" id="process" class="ckeditor col-xs-10 col-sm-5" placeholder="Process"></textarea>

				</div>
			</div>
				<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> Instruction: </label>
				<div class="col-sm-9">
					<textarea type="text" name="data[BroucherProduct][instruction]" id="instruction"  class="ckeditor col-xs-10 col-sm-5" placeholder="Instruction"></textarea>

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Technical Literature: </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][datasheet]" id="datasheet" class="col-xs-10 col-sm-5" placeholder="Technical Literature">

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Product MSDS: </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][msds]" id="msds" class="col-xs-10 col-sm-5" placeholder="Product MSDS">

				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Voc sheet: </label>
				<div class="col-sm-9">
					<input type="text" name="data[BroucherProduct][voc_pdf]" id="voc" class="col-xs-10 col-sm-5" placeholder="Voc sheet">

				</div>
			</div>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">upload Product Image : </label>
				<div class="col-sm-9">
					<input type="file" name="data[BroucherProduct][image]" id="image" class="col-xs-10 col-sm-5">

				</div>
			</div>										
			<div class="form-group">
			<label for="form-field-2" class="col-sm-3 control-label no-padding-right">Product Status : </label>
				<div class="col-sm-9">
				
				
				<div class="radio"><label>
				<input type="radio" checked="checked" value="1"  class="ace" id="CategoryActive1" name="data[BroucherProduct][status]"><span class="lbl"> Active</span>
				</label></div>
				
				<div class="radio"><label>
					<input type="radio" value="0"  class="ace" id="CategoryActive0" name="data[BroucherProduct][status]"><span class="lbl"> Inactive</span>
				</label></div>				
				</div>
			</div>
			<div class="form-group">
			<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Featured : </label>
				<div class="col-sm-9">
				
				
				<div class="radio"><label>
				<input type="radio"  value="1"  class="ace" id="CategoryActive1" name="data[BroucherProduct][is_featured]"><span class="lbl"> featured</span>
				</label></div>
				
				<div class="radio"><label>
					<input type="radio" checked="checked" value="0"  class="ace" id="CategoryActive0" name="data[BroucherProduct][is_featured]"><span class="lbl"> Non featured</span>
				</label></div>				
				</div>
			</div>	
		
				<div class="form-group">
			<label for="form-field-2" class="col-sm-3 control-label no-padding-right"> Is Image : </label>
				<div class="col-sm-9">
								
				<div class="radio"><label>
				<input type="radio"  value="0"  class="ace" id="CategoryActive1" name="data[BroucherProduct][is_image]"><span class="lbl"> Yes Image</span>
				</label></div>
				
				<div class="radio"><label>
					<input type="radio" checked="checked" value="1"  class="ace" id="CategoryActive0" name="data[BroucherProduct][is_image]"><span class="lbl">
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
	$("#product_name").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter product name"
	});$("#product_code").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter product code"
	}); $("#price_euro").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter price euro"
	}); $("#price_dollar").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter price dollar"
	});  $("#stock").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter stock"
	}); $("#category_id").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please select category"
});
});
</script>
