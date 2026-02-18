<div class="contact_banner col-lg-12 col-md-12 col-sm-12">
 <!--img src="<?php echo SITEURL ;?>customdurotech/images/contact_banner.jpg"-->
</div>
	<div class="contact_us_page col-lg-12 col-md-12 col-sm-12">

	<div class="container animated fadeIn">

	<div class="row">
 
    <h1 class="header-title"> Apply Job </h1>
    <hr>
	
    <div class="col-sm-12" id="parent">
			
    	<div class="col-sm-3">
		</div>
    	<div class="col-sm-6">
			<p style="font-weight:bold;">Job Title: <?php echo $careers['Career']['title'].'  (#'.$careers['Career']['code'].')'?></p>
    		<?php echo $this->Form->create(null, ['url' => ['controller' => 'Careers', 'action' => 'apply', $careers['Career']['code']], 'class' => 'contact-form', 'id' => 'formemailnews', 'enctype' => 'multipart/form-data']); ?>
				<?php echo $this->Form->hidden('CareerApplyJob.job_id', ['value' => $careers['Career']['id']]); ?>
		        <div class="form-group">
		          <?php echo $this->Form->control('CareerApplyJob.name', ['type' => 'text', 'class' => 'form-control', 'id' => 'name', 'placeholder' => 'Name', 'autofocus' => '', 'label' => false]); ?>
		        </div>
		        <div class="form-group form_left">
		          <?php echo $this->Form->control('CareerApplyJob.email', ['type' => 'email', 'class' => 'form-control', 'id' => 'email', 'placeholder' => 'Email', 'label' => false]); ?>
		        </div>
			 <div class="form-group">
		           <?php echo $this->Form->control('CareerApplyJob.phone', ['type' => 'text', 'class' => 'form-control', 'id' => 'phone', 'maxlength' => '10', 'placeholder' => 'Mobile No.', 'label' => false]); ?>
		      </div>
			   <div class="form-group">
		           <?php echo $this->Form->control('file', ['type' => 'file', 'class' => 'form-control', 'id' => 'file', 'label' => false]); ?>
				   <p style="font-weight:bold;"><br/>Upload Resume: pdf,docx,doc</p>
		      </div>
		      <div class="form-group">
		      <?php echo $this->Form->control('CareerApplyJob.description', ['type' => 'textarea', 'class' => 'form-control textarea-contact', 'rows' => '5', 'id' => 'message', 'placeholder' => 'Describe your self', 'label' => false]); ?>
		     </div>	  
	      	  <div class="form-group">
				<?php echo $this->Form->button('Submit', ['type' => 'submit', 'name' => 'submit', 'class' => 'btn btn-primary']); ?>
				</div>
			<?php echo $this->Form->end(); ?>
		      </div>
			<div class="col-sm-3">
			</div>
			  
     		</form>
    	</div>
				
    </div>
  </div>

  <div class="container second-portion">
	<div class="row">
        <!-- Boxes de Acoes -->
    	<div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fa fa-envelope" aria-hidden="true"></i></div>
					<div class="info">
						<h3 class="title">MAIL & WEBSITE</h3>
						<p>
							<i class="fa fa-globe" aria-hidden="true"></i> &nbsp www.durotechindustries.com.au
						</p>
					
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
			
        <div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fa fa-mobile" aria-hidden="true"></i></div>
					<div class="info">
						<h3 class="title">CONTACT</h3>
    					<p>
							<i class="fa fa-mobile" aria-hidden="true"></i> &nbsp  <?php echo PHONE;  ?>
							<br>
							
						</p>
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>
			
        <div class="col-xs-12 col-sm-6 col-lg-4">
			<div class="box">							
				<div class="icon">
					<div class="image"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
					<div class="info">
						<h3 class="title">ADDRESS</h3>
    					<p>
							 <i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp 
								<?php echo ADDRESS;  ?>
						</p>
					</div>
				</div>
				<div class="space"></div>
			</div> 
		</div>		    
		<!-- /Boxes de Acoes -->
		
		<!--My Portfolio  dont Copy this -->
	    
	</div>
</div>
</div>
</div>
<script>
	
	jQuery(function(){ //short for $(document).ready(function(){
	$("#name").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter name"
	});$("#phone").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter phone"
	});$("#email").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter email"
	});$("#message").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter message"
	});jQuery("#email").validate({
		expression: "if (VAL.match(\/^([a-zA-Z0-9_\\.\\-])+\\@(([a-zA-Z0-9\\-])+\\.)+([a-zA-Z0-9]{2,4})+$\/) && VAL) return true; else return false;",
		message: "Please enter valid email"
	});jQuery("#captcha").validate({
			expression: "if ((VAL == jQuery('#newcaptch').val()) && VAL) return true; else return false;",
			message: "Wrong captch code. "
		}); 
	});

	</script>		