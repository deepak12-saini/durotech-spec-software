<style>
.contact-send-btn .contact-submit {
	display: inline-block;
	font-size: 16px;
	color: #34495e;
	text-decoration: none;
	line-height: 50px;
	background: none;
	border: none;
	cursor: pointer;
	padding: 0 15px;
	z-index: 2;
	position: relative;
}
.contact-send-btn:hover .contact-submit {
	color: #fff !important;
}
</style>
<div class="contact_banner col-lg-12 col-md-12 col-sm-12">
 <img src="<?php echo SITEURL; ?>customdurotech/images/contact_banner.jpg">
</div>
	<div class="contact_us_page col-lg-12 col-md-12 col-sm-12">

	<div class="container animated fadeIn">

	<div class="row">
 
    <h1 class="header-title"> Contact </h1>
    <hr>
    <div class="col-sm-12" id="parent">
			
    	<div class="col-sm-6">
			<?= $this->Flash->render() ?>
    		<?= $this->Form->create(null, ['url' => ['controller' => 'Fronts', 'action' => 'contact'], 'type' => 'post', 'class' => 'contact-form', 'id' => 'formemailnews']) ?>
	
		        <div class="form-group">
		          <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="" autofocus="" value="">
		        </div>
		        <div class="form-group form_left">
		          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required="" value="">
		        </div>
		      <div class="form-group">
		           <input type="text" class="form-control" id="phone" name="phone" maxlength="10" placeholder="Mobile No." required="" value="">
		      </div>
		      <div class="form-group">
		      <textarea class="form-control textarea-contact" rows="5" id="message" name="message" placeholder="Type Your Message/Feedback here..." required=""></textarea>
		      <br>
		      <div class="form-group">
					<input type="hidden" value="<?= h($cap_code ?? $this->request->getSession()->read('cap_code')) ?>" id="newcaptch">
		           <input type="text" class="form-control" id="captcha" name="captcha" maxlength="6" required="" style="width:200px;" placeholder="Enter captcha" value="">
				   <br>
				   <img src="<?= $this->Url->build(['controller' => 'Fronts', 'action' => 'captch']) ?>" alt="Captcha" style="vertical-align:middle;" />
		      </div>
			  <div class="form-group">
	      	   <div class="button-4 contact-send-btn">
				<div class="eff-4"></div>
				<button type="submit" class="btn-link contact-submit"> SEND </button>
				</div>
			  </div>
		      </div>
			
			  
     		<?= $this->Form->end() ?>
    	</div>
		
		<div class="col-sm-6">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3306.906870705087!2d150.84016091521423!3d-34.020601380614615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ec14b95fb3e5%3A0x849fcaeff6aba18e!2sDurotech+Industries!5e0!3m2!1sen!2sin!4v1517992006603" width="100%" height="320px" frameborder="0" style="border:0" allowfullscreen></iframe>
		
    	
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
							<i class="fa fa-envelope" aria-hidden="true"></i> &nbsp <?php echo MAILTO;  ?>
							<br>
							<br>
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
	function subscribe(){	
		var name = $("#name").val();		
		var phone = $("#phone").val();		
		var email = $("#email").val();		
		var message = $("#message").val();		
		if(name != '' && phone != '' && email != '' && message != ''){
			$("#formemailnews").submit();
		}else{
			$("#formemailnews").submit();
		}	
	}

	jQuery(function(){ //short for $(document).ready(function(){
	$("#captcha").validate({
		 expression: "if (VAL) return true; else return false;",
		message: "Please enter captcha"
	});$("#name").validate({
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