<div class="page-content">
	<div class="page-header">
	<h1>
	Circular Management Reviews
	<small>
		<i class="ace-icon fa fa-angle-double-right"></i>
		Result Page</small>
		<a href="<?php echo SITEURL; ?>organisations/circular" class="btn btn-mini btn-inverse" style="float:right;">Back</a>
	</h1>
	</div><!-- /.page-header -->
	<?php
		$emp_id = array();
		$agendaArr = array();
		if(!empty($CircularManagementReviewArr['CircularRelation'])){
			foreach($CircularManagementReviewArr['CircularRelation'] as $CircularManagementReviewArrs){
				$emp_id[] = $CircularManagementReviewArrs['emp_id'];
			}	
		}
		
		$agenda = explode('##',$CircularManagementReviewArr['CircularManagementReview']['agenda']);
		if(!empty($agenda)){
			foreach($agenda as $agendas){
				if(!empty($agendas)){
					$agendaArr[] = $agendas;
				}
			}	
		}
	
	?>
	<div class="row">
		<div class="col-xs-12">
		<?php echo $this->Form->create('Organisation',array('class'=>'form-horizontal','role'=>'form','enctype'=>'multipart/form-data'));?>	
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Meeting Group: </label>
					
						<label class="col-sm-9" style="font-weight:bold; margin-top:7px;"> <?php foreach($NappUser as $NappUsers){ if(in_array($NappUsers['NappUser']['id'],$emp_id)){   ?>
							<?php echo $NappUsers['NappUser']['name'].' '.$NappUsers['NappUser']['lname'].' ('.(isset($NappUsers['Department']['department_title']) ? h($NappUsers['Department']['department_title']) : '').')';?> <br>
							
						<?php  } }  ?>
						</label>
					
				</div>			
				<div class="form-group" id="actioned">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date: </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('date',array('disabled'=>true,'type'=>'text','div'=>false,'label'=>false, 'class' => 'datepicker col-xs-10 col-sm-5','id'=>'actioned_by_date','placeholder'=>'Actioned By Date','value'=>date('Y-m-d')))?>
					</div>
				</div>
				
				
				<div class="form-group" id="actioned">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Time:<br><small>Our management Reviews meeting is schediled on </small> </label>
					<div class="col-sm-9">
						<?php echo $this->Form->input('start_time',array('disabled'=>true,'type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-3','id'=>'start_time','placeholder'=>'Start Time e.g 10:00 am','value'=>$CircularManagementReviewArr['CircularManagementReview']['start_time']))?>
						<?php echo $this->Form->input('end_time',array('disabled'=>true,'type'=>'text','div'=>false,'label'=>false, 'class' => 'col-xs-10 col-sm-3','id'=>'end_time','placeholder'=>'End Time  e.g 11:00 am','value'=>$CircularManagementReviewArr['CircularManagementReview']['end_time']))?>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">&nbsp;</label>
					<div class="col-sm-9">
						<b>The Agenda of the meeting is as below: </b><br>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Agenda: </label>
					<div class="col-sm-9">						
							<?php $i=1; foreach($reviewArr as $reviewArrs){  ?>
							<p><b><?php echo $i.'. '.$reviewArrs['CircularAction']['agenda'];?></b></p>
							<p>Action Taken: <?php echo $reviewArrs['CircularAction']['description'];?></p>	
							<p>Responsiblity: <?php echo $reviewArrs['CircularAction']['responsiblity'];?></p>	
							<p>Time Frame: <?php echo $reviewArrs['CircularAction']['time_frame'];?></p>	
							<hr/>
						<?php $i++; } ?>
						
					</div>
				</div>
			
			
		</div>
	</div>
</div>
<script type="text/javascript">
	function change(type){
		if(type == 2){
			$("#actioned").hide();
		}else{
			$("#actioned").show();
		}
	}
	jQuery(function(){ 
		$('.datepicker').datepicker({
			format: 'yyyy-mm-dd',			
		});
		
		$("#dept_id").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please select department"
		});$("#non_conforance").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter non Conformance"
		});$("#customer_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter customer name"
		});$("#customer_email").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter customer email"
		});$("#product_name").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter product name"
		});$("#product_color").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter product color"
		}); $("#reason_for_complaint").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter reason for complaint "
		});  $("#batch_number").validate({
			 expression: "if (VAL) return true; else return false;",
			message: "Please enter batch number"
		});   
	});
</script>