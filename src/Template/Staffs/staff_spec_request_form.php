<style>
    .frmSearch {}

    #country-list {
        float: left;
        list-style: none;
        margin-top: -3px;
        padding: 0;
        width: 190px;
        position: absolute;
        z-index: 99;
    }

    #country-list li {
        padding: 10px;
        background: #e6fddd;
        border-bottom: #bbb9b9 1px solid;
    }

    #country-list li:hover {
        background: #ece3d2;
        cursor: pointer;
    }

    #search-box {
        padding: 10px;
        border: #a8d4b1 1px solid;
        border-radius: 4px;
    }

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
        <div class="right_btn pull-right">
            <a href="javascript:window.history.back();" class="btn btn-inverse">Back</a>
        </div>
        <h1>DuroEzy Specification
            <small><i class="ace-icon fa fa-angle-double-right"></i> Create Easy Spec Request</small>
        </h1>
    </div>

    <div class="row">
        <div class="col-xs-12">

			<?php echo $this->Form->create('Staffs', array(
				'url' => array('controller' => 'staffs', 'action' => 'staff_specRequest_form'),
				'class' => 'form-horizontal',
				'enctype' => 'multipart/form-data'
			)); ?>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Name/Attn:</label>
                <div class="col-sm-9">
                    <input type="text" name="name" id="name" class="col-xs-10 col-sm-8" value="<?php echo h($sourceMailer->name ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Project:</label>
                <div class="col-sm-9">
                    <input type="text" name="company" class="col-xs-10 col-sm-8" value="<?php echo h($sourceMailer->company ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Address:</label>
                <div class="col-sm-9">
                    <input type="text" name="address" class="col-xs-10 col-sm-8" value="<?php echo h($sourceMailer->address ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Specification:</label>
                <div class="col-sm-9">
                    <input type="text" name="specification" class="col-xs-10 col-sm-8" value="<?php echo h($sourceMailer->specification ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Email:</label>
                <div class="col-sm-9">
                    <input type="text" name="email" id="email" class="col-xs-10 col-sm-8" value="<?php echo h($sourceMailer->email ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label class="col-sm-3 control-label no-padding-right">Date:</label>
                <div class="col-sm-9">
                    <?php $prefDate = !empty($sourceMailer->date) ? format_db_date('d/m/Y', $sourceMailer->date) : date('d/m/Y'); ?>
                    <input type="text" name="date" id="date" class="datepicker col-xs-10 col-sm-8" value="<?php echo h($prefDate); ?>">
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
					<input type="text" name="subject" value="<?php echo h($sourceMailer->subject ?? 'Durotech: External Liquid WPM'); ?>" id="subject" class = "col-xs-10 col-sm-8">
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

            <?php if (!empty($sourceProducts)): ?>
                <?php $si = 1; foreach ($sourceProducts as $products): ?>
                <div class="form-group addsection" id="section_<?php echo (int)$si; ?>">
                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>
                    <div class="col-sm-9">
                        <table>
                            <tbody>
                                <tr><td colspan="5">
                                    <div class="frmSearch" style="position:relative;">
                                        <input
                                            class="newitem_<?php echo (int)$si; ?>"
                                            type="text"
                                            style="width:100%;"
                                            name="title[<?php echo (int)$si; ?>]"
                                            id="title_<?php echo (int)$si; ?>"
                                            value="<?php echo h($products[0]['title'] ?? ''); ?>"
                                            placeholder="enter title e.g. Wet area or planter box"
                                            required
                                            onkeyup="onTitleSearch(<?php echo (int)$si; ?>)"
                                        >
                                        <div class="suggesstion-box" id="title-suggestion-box_<?php echo (int)$si; ?>"></div>
                                    </div>
                                </td></tr>
                                <tr>
                                    <th></th>
                                    <th>Product Type</th>
                                    <th>Product</th>
                                    <th>MFT</th>
                                    <th>Warranty Period</th>
                                </tr>
                                <?php $sk = 0; foreach ($products as $key => $pro): ?>
                                <tr <?php if ($sk > 0): ?>class="newitem_<?php echo (int)$si; ?>" id="div_<?php echo (int)$si; ?>_<?php echo (int)$sk; ?>"<?php endif; ?>>
                                    <td><input type="hidden" style="width:30px;" name="types[]" value="<?php echo (int)$si; ?>"><input type="text" style="width:63px;" name="serial[]" value="<?php echo h($pro['serial'] ?? ''); ?>"></td>
                                    <td><input type="text" style="width:225px;" name="coverage[]" value="<?php echo h($pro['coverage'] ?? ''); ?>" id="coverage_<?php echo (int)$si; ?>_<?php echo (int)$key; ?>"></td>
                                    <td><div class="frmSearch"><input type="text" autocomplete="off" style="width:225px;" name="product[]" id="pro_<?php echo (int)$si; ?>_<?php echo (int)$key; ?>" value="<?php echo h($pro['product'] ?? ''); ?>" onkeyup="onkeyups(<?php echo (int)$si; ?>,<?php echo (int)$key; ?>)"><div id="suggesstion-box_<?php echo (int)$si; ?>_<?php echo (int)$key; ?>"></div></div></td>
                                    <td><input type="text" style="width:100px;" name="coverage_by_pack[]" value="<?php echo h($pro['coverage_by_pack'] ?? ''); ?>" id="coverage_by_pack_<?php echo (int)$si; ?>_<?php echo (int)$key; ?>"></td>
                                    <td><input type="text" style="width:100px;" name="Warranty[]" value="<?php echo h($pro['Warranty'] ?? ''); ?>" id="warranty_<?php echo (int)$si; ?>_<?php echo (int)$key; ?>"></td>
                                    <td>
                                        <?php if ($sk === 0): ?>
                                            <a href="javascript:void(0);" style="color:red;" onclick="removesection('<?php echo (int)$si; ?>')">&nbsp;&nbsp; X </a>
                                        <?php else: ?>
                                            <a href="javascript:void(0);" style="color:red;" onclick="remove('<?php echo (int)$si; ?>','<?php echo (int)$sk; ?>')">&nbsp;&nbsp; X </a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php $sk++; endforeach; ?>
                            </tbody>
                        </table>
                        <div id="addnew_<?php echo (int)$si; ?>"></div>
                        <a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore(<?php echo (int)$si; ?>)"><i class="fa fa-plus"></i> Add More</a>
                    </div>
                </div>
                <?php $si++; endforeach; ?>
            <?php endif; ?>
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
                    <?php if (!empty($sourceComments)): ?>
                        <?php $cm = 1; foreach ($sourceComments as $existingComment): ?>
                        <table class="commentdiv" id="commentdiv_<?php echo (int)$cm; ?>">
                            <tr>
                                <th>Comments <?php echo (int)$cm; ?>.</th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><input type="text" style="width:400px;" name="comment[]" value="<?php echo h($existingComment); ?>"></td>
                                <td><a href="javascript:void(0);" style="color:red;" onclick="commnetdivremove('<?php echo (int)$cm; ?>')">&nbsp;&nbsp; X </a></td>
                            </tr>
                        </table>
                        <?php $cm++; endforeach; ?>
                    <?php else: ?>
                        <table class="commentdiv">
                            <tr>
                                <th>Comments 1.</th>
                            </tr>
                            <tr>
                                <td><input type="text" style="width:400px;" name="comment[]" value=""></td>
                            </tr>
                        </table>
                    <?php endif; ?>
					<div id="addcommentnew"></div>
					<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmorecomment()"><i class="fa fa-plus"></i> Add More Comment</a>
				</div>
			</div>

        

            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
					<?php echo $this->Form->submit('Submit',array('div'=>false,'label'=>false, 'class' => 'btn btn-mini  btn-success','id'=>'add_request_prd_btn','value'=>'Submit'));?>&nbsp;
                </div>
            </div>

            <?php echo $this->Form->end(); ?>

        </div>
    </div>
</div>

<script>

    function addnewsection() {
		var numItems = $('.addsection').length;
		var newdiv = numItems + 1;

		var varhtml = '' +
			'<div class="form-group addsection" id="section_' + newdiv + '">' +
				'<label class="col-sm-3 control-label no-padding-right" for="form-field-1"></label>' +
				'<div class="col-sm-9">' +
					'<table>' +
						'<tr>' +
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
								'<a href="javascript:void(0);" style="color:red;" onclick="removesection(' + newdiv + ')">&nbsp;&nbsp; X </a>' +
							'</td>' +
						'</tr>' +
					'</table>' +
					'<div id="addnew_' + newdiv + '"></div>' +
					'<a href="javascript:void(0);" class="btn btn-xs btn-primary" style="margin-top:10px;" onclick="addmore(' + newdiv + ')">' +
						'<i class="fa fa-plus"></i> Add More' +
					'</a>' +
				'</div>' +
			'</div>';

		$("#addsection").append(varhtml);
	}

    function removesection(id){
		$("#section_"+id).remove();
	}

    function addmore(id){
		var numItems = $('.newitem_'+id).length;		
		var newdiv = 	numItems + 1;
		var dtserial = id+'.'+newdiv;
				
		var addnew ='<table class="newitem_'+id+'"  id="div_'+id+'_'+newdiv+'"><tr><td><input type="hidden" style="width:30px;" name="types[]" value="'+id+'"><input type="text" style="width:63px;" name="serial[]" value="'+dtserial+'"></td><td><input type="text" style="width:225px;" name="coverage[]" value=""  id="coverage_'+id+'_'+newdiv+'"></td><td><div class="frmSearch"><input autocomplete="off" type="text" style="width:225px;" name="product[]" value="" id="pro_'+id+'_'+newdiv+'" onkeyup="onkeyups('+id+','+newdiv+')"><div class="suggesstion-box" id="suggesstion-box_'+id+'_'+newdiv+'"></div></div></td><td><input type="text" style="width:100px;" name="coverage_by_pack[]" value=""  id="coverage_by_pack_'+id+'_'+newdiv+'"></td><td><input type="text" style="width:100px;" name="Warranty[]" value=""  id="warranty_'+id+'_'+newdiv+'"></td><td><a href="javascript:void(0);" style="color:red;" onclick="remove('+id+','+newdiv+')">&nbsp;&nbsp; X </a></td></tr></table>';
		$("#addnew_"+id).append(addnew);
	}	
	function remove(id,newdiv){	
		$("#div_"+id+"_"+newdiv).remove();
	}

    //use area section
    function debounce(func, delay) {
        let timer;
        return function(...args) {
            clearTimeout(timer);
            timer = setTimeout(() => func.apply(this, args), delay);
        };
    }

	var titleSuggestMinChars = 3;
	var titleSuggestXhrById = {};
	var lastTitleKeywordById = {};

    
	function fetchTitleSuggestions(id) {

		const keyword = ($("#title_" + id).val() || '').trim();
		
		if (keyword.length < titleSuggestMinChars) {
			$("#title-suggestion-box_" + id).hide().html('');
			lastTitleKeywordById[id] = '';
			if (titleSuggestXhrById[id] && titleSuggestXhrById[id].readyState !== 4) {
				titleSuggestXhrById[id].abort();
			}
			titleSuggestXhrById[id] = null;
			return;
		}

		if (lastTitleKeywordById[id] === keyword) {
			return;
		}
		lastTitleKeywordById[id] = keyword;

		if (titleSuggestXhrById[id] && titleSuggestXhrById[id].readyState !== 4) {
			titleSuggestXhrById[id].abort();
		}

		titleSuggestXhrById[id] = $.ajax({
			type: "GET",
			url: "<?php echo rtrim(SITEURL, '/').'/admin/mailers/title_list' ?>/" + id,
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

	// Debounce avoids request burst while user is typing.
	const debouncedFetch = debounce(fetchTitleSuggestions, 500);

	// Change your onTitleSearch to just call the debounced function
	function onTitleSearch(id) {
	  debouncedFetch(id);
	}

	function selectTitle(title, id) {
		$("#title_" + id).val(title);
		$("#title-suggestion-box_" + id).hide().html('');
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
	var productSuggestMinChars = 3;
	var productSuggestXhrByKey = {};
	var lastProductKeywordByKey = {};
	var productSuggestTimerByKey = {};

    function onkeyups(id,newdiv){
		var fieldKey = id + '_' + newdiv;
		var keyword = ($("#pro_"+id+"_"+newdiv).val() || '').trim();
		if (productSuggestTimerByKey[fieldKey]) {
			clearTimeout(productSuggestTimerByKey[fieldKey]);
		}
		if (keyword.length < productSuggestMinChars) {
			$("#suggesstion-box_"+id+"_"+newdiv+"").hide().html('');
			lastProductKeywordByKey[fieldKey] = '';
			if (productSuggestXhrByKey[fieldKey] && productSuggestXhrByKey[fieldKey].readyState !== 4) {
				productSuggestXhrByKey[fieldKey].abort();
			}
			productSuggestXhrByKey[fieldKey] = null;
			return;
		}
		var csrfToken = $('input[name="_csrfToken"]').val() || '';
		productSuggestTimerByKey[fieldKey] = setTimeout(function() {
			if (lastProductKeywordByKey[fieldKey] === keyword) {
				return;
			}
			lastProductKeywordByKey[fieldKey] = keyword;
			if (productSuggestXhrByKey[fieldKey] && productSuggestXhrByKey[fieldKey].readyState !== 4) {
				productSuggestXhrByKey[fieldKey].abort();
			}
			productSuggestXhrByKey[fieldKey] = $.ajax({
				type: "POST",
				url: "<?php echo SITEURL.'admin/mailers/list' ?>/"+id+"/"+newdiv,
				data: {
					keyword: keyword,
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
		}, 500);
	}

    function selectCountry(product,coverage,coverage_by_pack,Warranty,id,newdiv) {
		
		$("#pro_"+id+"_"+newdiv).val(product);
		$("#coverage_by_pack_"+id+"_"+newdiv).val(coverage_by_pack);
		$("#coverage_"+id+"_"+newdiv).val(coverage);
		$("#warranty_"+id+"_"+newdiv).val(Warranty);
		$("#suggesstion-box_"+id+"_"+newdiv+"").hide();
		$(".suggesstion-box").hide();
	}

	$(document).ready(function() {
		if (typeof $.fn.datepicker !== 'undefined' && $('.datepicker').length) {
			$('.datepicker').datepicker({
				format: 'dd/mm/yyyy',
				autoclose: true
			});
		}
	});

    </script>




