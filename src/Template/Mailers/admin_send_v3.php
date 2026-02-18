	<style>
	.frmSearch { }
	#country-list{float:left;list-style:none;margin-top:0px;padding:0;width:225px;position: absolute;z-index: 999;margin-left:0px; }
	#country-list li{padding: 10px; background: #e6fddd; border-bottom: #bbb9b9 1px solid; }
	#country-list li:hover{background:#ece3d2;cursor: pointer;}
	#search-box{padding: 10px;border: #a8d4b1 1px solid;border-radius:4px;}


	.title-dropdown {
	list-style: none;
	padding-left: 0;
	margin: 0;
	position: absolute;
	z-index: 999;
	background: #fff;
	border: 1px solid #ccc;
	width: 100%;
	max-height: 200px;
	overflow-y: auto;
	}
	.title-dropdown li {
	padding: 5px 10px;
	 background: #e6fddd;
    border-bottom: 1px solid #bbb9b9;
	cursor: pointer;
	}
	.title-dropdown li:hover {
	background-color: #f0f0f0;
	}

	</style>	
	<div class="page-content">
		<div class="page-header">
		<div class="right_btn pull-right" ><a href="javascript:window.history.back();" class="btn btn-inverse" >Back</a></div>
		<h1>DuroEzy Specification v3 <small><i class="ace-icon fa fa-angle-double-right"></i>Create New Spec</small>
		</h1>
	</div>
	
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('Mailer',array('class'=>'form-horizontal','enctype'=>'multipart/form-data')); ?>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Track Number:</label>
				<div class="col-sm-9">
					<input type="text" name="tracknumber" value="<?php echo $refernce; ?>" readonly id="tracknumber" class = "col-xs-10 col-sm-8" style="background:#ddd !important; cursor:pointer;" >
				</div>
			</div>
		
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Name/Attn:</label>
				<div class="col-sm-9">
					<input type="text" name="name" value="" id="name" class = "col-xs-10 col-sm-8">
				</div>
			</div>	
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Company:</label>
				<div class="col-sm-9">
					<input type="text" name="company" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Address:</label>
				<div class="col-sm-9">
					<input type="text" name="address" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Specification:</label>
				<div class="col-sm-9">
					<input type="text" name="specification" value=""  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Email:</label>
				<div class="col-sm-9">
					<input type="text" name="email" value="" id="email"  class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date:</label>
				<div class="col-sm-9">
					<input type="text" name="date" value="<?php echo date('d/m/Y');?>" id="date"  class = "datepicker col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Mailer Type:</label>
				<div class="col-sm-9">
					<select name="type" class="col-xs-10 col-sm-8"  onchange="setsubject(this.value)"  >
						<!-- <option value="">Select Client Requested</option> -->
						<!--option value="1">INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE</option>
						<option value="2">Waterproofing Specification – Wet area shower</option-->
						<option value="3">External Liquid WPM</option> 
					</select>
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Subject:</label>
				<div class="col-sm-9">
					<input type="text" name="subject" value="Durotech: External Liquid WPM" id="subject" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Spec Type:</label>
				<div class="col-sm-9">
					<select name="spectype" class="col-xs-10 col-sm-8">						
						<option value="1">With Warranty Column</option> 
						<option value="0">Without Warranty Column</option> 
					</select>
				</div>
			</div>
			<!--div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">MFT(Minimum Film Thickness):</label>
				<div class="col-sm-9">
					<input type="text" name="mft" placeholder="MFT(Minimum Film Thickness)" id="mft" class = "col-xs-10 col-sm-8">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Warranty Period:</label>
				<div class="col-sm-9">
					<input type="text" name="warranty_period" placeholder="Warrenty Period" id="warranty_period" class = "col-xs-10 col-sm-8">
				</div>
			</div-->
			<!--div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Is Use Area:</label>
				<div class="col-sm-1">
					<input type="checkbox" name="use_area" value="1" id="use_area" class = "col-xs-10 col-sm-8" onclick="checkornot()" style="margin-top: 12px;">
				</div>
			</div-->
			
			
			<div id="addsection"></div>
			
			<div class="form-group">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-1">
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addnewsection()"><i class="fa fa-plus"></i> Add Section</a>
				</div>
			</div>
			<div id="newdiv"></div>
			
			<div class="form-group" style="margin-top:40px;">
				<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
				<div class="col-sm-9">				
					<table  class="commentdiv">
						<tr>	
							<th>Comments 1.</th>							
						</tr>
						<tr>							
							<td><input type="text" style="width:400px;" name="comment[]" value=""></td>
						</tr>
					</table>
					<div id="addcommentnew"></div>
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmorecomment()"><i class="fa fa-plus"></i> Add More Comment</a>
				</div>
			</div>

			<div class="form-group">
				    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Attach PDF Datasheet:</label>
					<div class="col-sm-9">
						<input type="file" name="datasheet_pdf" accept="application/pdf" class="col-xs-10 col-sm-8">
						<p class="help-block">Select a PDF file (e.g., Duromastic ARW datasheet)</p>
					</div>
			</div>
			
			<div class="form-group">
				<div class="col-md-offset-3 col-md-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-mini  btn-success','id'=>'add_ser_prd_btn','value'=>'Submit'));?>&nbsp;
				
				</div>
			</div>
			<?php echo $this->Form->end(); ?>
		</div>
	</div>	
	</div>	
	
<script type="text/javascript">
	function addmorecomment(){
		var numItems = $('.commentdiv').length; 
		var newdiv = 	numItems + 1;
		//var dtserial = id+'.'+newdiv;	
		var html = '<table class="commentdiv" id="commentdiv_'+newdiv+'"><tr><th>Comments '+newdiv+'.</th><th><th></tr><tr><td><input type="text" style="width:400px;" name="comment[]" value=""></td><td><a href="javascript:void(0);" style="color:red;" onclick="commnetdivremove('+newdiv+')">&nbsp;&nbsp; X </a></td></tr></table>';
		$("#addcommentnew").append(html);
	}	
	function commnetdivremove(newdiv){
		$("#commentdiv_"+newdiv).remove();
	}
	function onkeyups(id,newdiv){
		var csrfToken = $('input[name="_csrfToken"]').val() || '';
		$.ajax({
		type: "POST",
		url: "<?php echo SITEURL.'admin/mailers/list' ?>/"+id+"/"+newdiv,
		data: {
			keyword: $("#pro_"+id+"_"+newdiv).val(),
			_csrfToken: csrfToken
		},
		beforeSend: function(){
			//$("#search-box").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			if(data != ''){
				$("#suggesstion-box_"+id+"_"+newdiv+"").show();
				$("#suggesstion-box_"+id+"_"+newdiv+"").html(data);
				$("#pro_"+id+"_"+newdiv).css("background","#FFF");
			}else{
				$("#suggesstion-box_"+id+"_"+newdiv+"").hide();
				$("#suggesstion-box_"+id+"_"+newdiv+"").html('');
				$("#pro_"+id+"_"+newdiv).css("background","#FFF");
			}
		}
		});
	}
	function selectCountry(product,coverage,coverage_by_pack,Warranty,id,newdiv) {
		
		$("#pro_"+id+"_"+newdiv).val(product);
		$("#coverage_by_pack_"+id+"_"+newdiv).val(coverage_by_pack);
		$("#coverage_"+id+"_"+newdiv).val(coverage);
		$("#warranty_"+id+"_"+newdiv).val(Warranty);
		$("#suggesstion-box_"+id+"_"+newdiv+"").hide();
		$(".suggesstion-box").hide();
	}

	function addmore(id){
		var numItems = $('.newitem_'+id).length;		
		var newdiv = 	numItems + 1;
		var dtserial = id+'.'+newdiv;
				
		var addnew ='<table class="newitem_'+id+'"  id="div_'+id+'_'+newdiv+'"><tr><td><input type="hidden" style="width:30px;" name="types[]" value="'+id+'"><input type="text" style="width:63px;" name="serial[]" value="'+dtserial+'"></td><td><input type="text" style="width:225px;" name="coverage[]" value=""  id="coverage_'+id+'_'+newdiv+'"></td><td><div class="frmSearch"><input autocomplete="off" type="text" style="width:225px;" name="product[]" value="" id="pro_'+id+'_'+newdiv+'" onkeyup="onkeyups('+id+','+newdiv+')"><div class="suggesstion-box" id="suggesstion-box_'+id+'_'+newdiv+'"></div></div></td><td><input type="text" style="width:100px;" name="coverage_by_pack[]" value=""  id="coverage_by_pack_'+id+'_'+newdiv+'"></td><td><input type="text" style="width:100px;" name="Warranty[]" value=""  id="warranty_'+id+'_'+newdiv+'"></td><td><a href="javascript:void(0);" style="color:red;" onclick="remove('+id+','+newdiv+')">&nbsp;&nbsp; <i class="fa fa-times"></i> </a></td></tr></table>';
		$("#addnew_"+id).append(addnew);
	}	
	function remove(id,newdiv){	
		$("#div_"+id+"_"+newdiv).remove();
	}
	function checkornot(){
		var isChecked = $("#use_area").is(":checked");
		if (isChecked) {
			$("#userArea").show();
		} else {
			$("#userArea").hide();
		}
	}	
	function setsubject(type_id){
		
		if(type_id == 1){
			$("#subject").val('DUROTECH: INSTALLATION OF DUROMASTIC P-15 WATERPROOFING MEMBRANE');
		}else if(type_id == 2){
			$("#subject").val('Durotech: Waterproofing Specification – Wet area shower');
		}else if(type_id == 3){
			$("#subject").val('Durotech: External Liquid WPM');
		}
	}	
	jQuery(function(){ //short for $(document).ready(function(){

		$('.datepicker').datepicker({
			format: "dd/mm/yyyy",			
		});
		$("#tracknumber").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter tracknumber"
		});
		$("#email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter email"
		}); $("#name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter name/attn"
		});; $("#company").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter company"
		}); $("#subject").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter subject"
		});
	});
	function removesection(id){
		$("#section_"+id).remove();
	}


	function addnewsection() {
		var numItems = $('.addsection').length;
		var newdiv = numItems + 1;

		var varhtml = '' +
			'<div class="form-group addsection" id="section_' + newdiv + '">' +
				'<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>' +
				'<div class="col-sm-9">' +
					'<table>' +
						'<tr style="border-bottom: 15px solid #ffff;">' +
							'<td colspan="5">' +
								'<div class="frmSearch">' +
									'<input type="text" style="width:100%;" name="title[' + newdiv + ']" id="title_' + newdiv + '" ' +
									'value="" placeholder="enter title e.g. Wet area or planter box" ' +
									'onkeyup="onTitleSearch(' + newdiv + ')" required>' +
									'<div class="suggesstion-box" id="title-suggestion-box_' + newdiv + '"></div>' +
								'</div>' +
							'</td>' +
						'</tr>' +
						'<tr>' +
							'<th></th>' +
							'<th>Product Type</th>' +
							'<th>Product</th>' +
							'<th>MFT</th>' +
							'<th>Warranty Period</th>' +
						'</tr>' +
						'<tr>' +
							'<td>' +
								'<input type="hidden" style="width:30px;" name="types[]" value="' + newdiv + '">' +
								'<input type="text" style="width:63px;" name="serial[]" value="' + newdiv + '">' +
							'</td>' +
							'<td>' +
								'<input type="text" style="width:225px;" name="coverage[]" value="" id="coverage_' + newdiv + '_0">' +
							'</td>' +
							'<td>' +
								'<div class="frmSearch">' +
									'<input type="text" autocomplete="off" style="width:225px;" name="product[]" ' +
									'id="pro_' + newdiv + '_0" value="" onkeyup="onkeyups(' + newdiv + ',0)">' +
									'<div class="suggesstion-box" id="suggesstion-box_' + newdiv + '_0"></div>' +
								'</div>' +
							'</td>' +
							'<td>' +
								'<input type="text" style="width:100px;" name="coverage_by_pack[]" value="" id="coverage_by_pack_' + newdiv + '_0">' +
							'</td>' +
							'<td>' +
								'<input type="text" style="width:100px;" name="Warranty[]" value="" id="warranty_' + newdiv + '_0">' +
							'</td>' +
							'<td>' +
								'<a href="javascript:void(0);" style="color:red;" onclick="removesection(' + newdiv + ')" title="Remove" style="color: red; font-size: 22px;">&nbsp;&nbsp; <i class="fa fa-times"></i> </a>' +
							'</td>' +
						'</tr>' +
					'</table>' +
					'<div id="addnew_' + newdiv + '"></div>' +
					'<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore(' + newdiv + ')" >' +
						'<i class="fa fa-plus"></i> Add More' +
					'</a>' +
				'</div>' +
			'</div>';

		$("#addsection").append(varhtml);
	}


	function debounce(func, delay) {
	let timer;
	return function(...args) {
		clearTimeout(timer);
		timer = setTimeout(() => func.apply(this, args), delay);
	};
  }

	function fetchTitleSuggestions(id) {
		const keyword = $("#title_" + id).val();
		
		if (keyword.length === 0) {
			$("#title-suggestion-box_" + id).hide().html('');
			return;
		}

		$.ajax({
			type: "POST",
			url: "<?php echo SITEURL.'admin/mailers/title_list' ?>/" + id,
			data: { keyword: keyword },
			success: function(data) {
				const suggestionBox = $("#title-suggestion-box_" + id);
				if (data.trim() !== '') {
					suggestionBox.show().html(data);
					$("#title_" + id).css("background", "#FFF");
				} else {
					suggestionBox.hide().html('');
				}
			}
		});
	}

	// Create a debounced version of the function, with 300ms delay
	const debouncedFetch = debounce(fetchTitleSuggestions, 300);

	// Change your onTitleSearch to just call the debounced function
	function onTitleSearch(id) {
	  debouncedFetch(id);
	}

	function selectTitle(title, id) {
		$("#title_" + id).val(title);
		$("#title-suggestion-box_" + id).hide().html('');
	}





</script>