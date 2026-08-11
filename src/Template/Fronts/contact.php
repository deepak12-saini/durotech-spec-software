<style>
/* --- Contact page: modern product-company layout --- */
.contact_us_page .header-title {
	font-size: 36px;
	font-weight: 700;
	letter-spacing: -0.02em;
	color: #1a2b3c;
	margin: 8px 0 6px;
	text-align: center;
}
.contact_us_page > .container > .row > hr {
	display: none;
}
.contact_us_page .contact-lead {
	text-align: center;
	color: #5a6a7a;
	font-size: 15px;
	margin: 0 auto 28px;
	max-width: 420px;
	line-height: 1.5;
}
.contact-card {
	background: #fff;
	border: 1px solid rgba(40, 137, 201, 0.12);
	border-radius: 16px;
	box-shadow: 0 8px 28px rgba(26, 43, 60, 0.06);
	padding: 28px 24px;
	margin-bottom: 24px;
}
.contact-card-title {
	margin: 0 0 18px;
	font-size: 13px;
	font-weight: 700;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	color: #2889c9;
}
.contact-form .form-control {
	height: 48px;
	border: 1px solid #d8e0e8;
	border-radius: 10px;
	box-shadow: none;
	padding: 10px 14px;
	font-size: 15px;
	transition: border-color 0.2s ease, box-shadow 0.2s ease;
}
.contact-form .form-control:focus {
	border-color: #2889c9;
	box-shadow: 0 0 0 3px rgba(40, 137, 201, 0.15);
	outline: none;
}
.contact-form .textarea-contact {
	height: auto;
	min-height: 120px;
	resize: vertical;
}
.contact-form .form-group {
	margin-bottom: 14px;
}
.contact-captcha-row {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	gap: 12px;
}
.contact-captcha-row .form-control {
	width: 160px;
	max-width: 100%;
}
.contact-captcha-row img {
	border-radius: 8px;
	border: 1px solid #e2e8f0;
}
.contact-send-btn {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	position: relative;
	overflow: hidden;
	background: #2889c9;
	border-radius: 999px;
	min-width: 140px;
	box-shadow: 0 6px 18px rgba(40, 137, 201, 0.35);
	transition: background 0.2s ease, transform 0.15s ease, box-shadow 0.2s ease;
}
.contact-send-btn .eff-4 {
	display: none;
}
.contact-send-btn .contact-submit {
	display: inline-block;
	font-size: 14px;
	font-weight: 700;
	letter-spacing: 0.06em;
	color: #fff !important;
	text-decoration: none;
	line-height: 48px;
	background: none;
	border: none;
	cursor: pointer;
	padding: 0 28px;
	z-index: 2;
	position: relative;
}
.contact-send-btn:hover {
	background: #1f74ad;
	transform: translateY(-1px);
	box-shadow: 0 8px 22px rgba(40, 137, 201, 0.42);
}
.contact-send-btn:hover .contact-submit {
	color: #fff !important;
}

/* Office tabs — short codes (VIC / NSW / QLD / SA) */
.contact-locations {
	margin-top: 0;
}
.contact-loc-tabs {
	display: flex;
	flex-wrap: nowrap;
	gap: 8px;
	width: 100%;
	margin: 0 0 18px;
	padding: 6px;
	list-style: none;
	background: #f0f4f8;
	border-radius: 12px;
}
.contact-loc-tabs li {
	flex: 1 1 0;
	min-width: 0;
	margin: 0;
	padding: 0;
}
.contact-loc-tabs button {
	width: 100%;
	appearance: none;
	border: 0;
	border-radius: 9px;
	background: transparent;
	color: #4a5a6a;
	font-size: 13px;
	font-weight: 700;
	letter-spacing: 0.06em;
	padding: 10px 6px;
	cursor: pointer;
	transition: background 0.2s ease, color 0.2s ease, box-shadow 0.2s ease;
}
.contact-loc-tabs button.is-active,
.contact-loc-tabs button:hover,
.contact-loc-tabs button:focus {
	background: #2889c9;
	color: #fff;
	outline: none;
	box-shadow: 0 4px 12px rgba(40, 137, 201, 0.3);
}
.contact-loc-name {
	margin: 0 0 14px;
	font-size: 18px;
	font-weight: 700;
	color: #1a2b3c;
	letter-spacing: -0.01em;
}
.contact-loc-panel {
	padding: 0;
}
.contact-loc-rows {
	margin: 0;
	padding: 0;
	list-style: none;
	display: grid;
	gap: 10px;
}
.contact-loc-rows li {
	display: flex;
	align-items: flex-start;
	gap: 12px;
	margin: 0;
	padding: 12px 14px;
	font-size: 14px;
	line-height: 1.45;
	color: #2c3a48;
	background: #f7fafc;
	border: 1px solid #e8eef4;
	border-radius: 12px;
}
.contact-loc-rows .fa {
	color: #2889c9;
	width: 18px;
	text-align: center;
	margin-top: 2px;
	flex: 0 0 18px;
}
.contact-loc-rows a {
	color: #2c3a48;
	text-decoration: none;
	word-break: break-word;
}
.contact-loc-rows a:hover {
	color: #2889c9;
}
.contact-loc-social {
	display: flex;
	gap: 10px;
	margin: 16px 0 20px;
	padding: 0;
	list-style: none;
}
.contact-loc-social a {
	display: inline-flex;
	align-items: center;
	justify-content: center;
	width: 40px;
	height: 40px;
	border-radius: 50%;
	background: #eef4f9;
	color: #2889c9 !important;
	text-decoration: none !important;
	border: 1px solid rgba(40, 137, 201, 0.15);
	transition: background 0.2s ease, color 0.2s ease, transform 0.15s ease;
}
.contact-loc-social a:hover {
	background: #2889c9;
	color: #fff !important;
	transform: translateY(-2px);
}
.contact-loc-map-title {
	margin: 0 0 12px;
	font-size: 13px;
	font-weight: 700;
	letter-spacing: 0.08em;
	text-transform: uppercase;
	color: #2889c9;
}
.contact-loc-map-wrap {
	position: relative;
	border-radius: 14px;
	overflow: hidden;
	border: 1px solid #e2e8f0;
	box-shadow: 0 4px 16px rgba(26, 43, 60, 0.06);
}
.contact-loc-map-frame {
	width: 100%;
	height: 300px;
	border: 0;
	display: block;
	background: #e8eef4;
}
.contact-loc-directions {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	margin-top: 12px;
	font-size: 14px;
	font-weight: 600;
	color: #2889c9;
	text-decoration: none;
}
.contact-loc-directions:hover {
	color: #1f74ad;
	text-decoration: underline;
}
.contact-address-list {
	margin: 0;
	padding: 0;
	list-style: none;
}
.contact-address-list li {
	margin: 0 0 10px;
	line-height: 1.4;
}
.contact-address-list .state {
	display: inline-block;
	min-width: 36px;
	font-weight: 700;
	color: #2889c9;
}
.contact_us_page .second-portion .box {
	border-radius: 14px;
	overflow: hidden;
	border: 1px solid rgba(40, 137, 201, 0.1);
	box-shadow: 0 6px 20px rgba(26, 43, 60, 0.05);
}
@media (max-width: 767px) {
	.contact_us_page .header-title {
		font-size: 28px;
	}
	.contact-card {
		padding: 20px 16px;
	}
	.contact-loc-tabs {
		gap: 4px;
		padding: 4px;
	}
	.contact-loc-tabs button {
		font-size: 12px;
		padding: 9px 4px;
	}
	.contact-loc-map-frame {
		height: 240px;
	}
}
</style>
<?php
$offices = (array)\Cake\Core\Configure::read('Durotech.offices');
$defaultOfficeKey = array_key_exists('vic', $offices) ? 'vic' : (string)array_key_first($offices);
$defaultOffice = $offices[$defaultOfficeKey] ?? [];
$defaultPhone = (string)($defaultOffice['phone'] ?? (defined('PHONE') ? PHONE : '1300 434 272'));
$defaultEmail = (string)($defaultOffice['email'] ?? (defined('MAILTO') ? MAILTO : 'info@durotechindustries.com.au'));
$defaultAddress = (string)($defaultOffice['address'] ?? (defined('ADDRESS') ? ADDRESS : ''));
$defaultHours = (string)($defaultOffice['hours'] ?? 'Mon - Fri: 6.30 am - 4.00 pm');
$defaultEmbed = (string)($defaultOffice['embedUrl'] ?? '');
$defaultMaps = (string)($defaultOffice['mapUrl'] ?? '#');
$officesJson = json_encode($offices, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
?>
<div class="contact_banner col-lg-12 col-md-12 col-sm-12">
 <img src="<?php echo SITEURL; ?>customdurotech/images/contact_banner.jpg" alt="Contact">
</div>
	<div class="contact_us_page col-lg-12 col-md-12 col-sm-12">

	<div class="container animated fadeIn">

	<div class="row">
 
    <h1 class="header-title">Contact</h1>
    <p class="contact-lead">Get in touch with our team across Australia.</p>
    <div class="col-sm-12" id="parent">
			
    	<div class="col-sm-6">
			<div class="contact-card">
				<h2 class="contact-card-title">Send a message</h2>
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
			      <input type="text" name="website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
		      <textarea class="form-control textarea-contact" rows="5" id="message" name="message" placeholder="Type your message or feedback..." required=""></textarea>
		      </div>
		      <div class="form-group">
					<input type="hidden" value="<?= h($cap_code ?? $this->request->getSession()->read('cap_code')) ?>" id="newcaptch">
					<div class="contact-captcha-row">
		           <input type="text" class="form-control" id="captcha" name="captcha" maxlength="6" required="" placeholder="Enter captcha" value="">
				   <img src="<?= $this->Url->build(['controller' => 'Fronts', 'action' => 'captch']) ?>" alt="Captcha" />
					</div>
		      </div>
			  <div class="form-group" style="margin-bottom:0;">
	      	   <div class="button-4 contact-send-btn">
				<div class="eff-4"></div>
				<button type="submit" class="btn-link contact-submit">Send</button>
				</div>
			  </div>
     		<?= $this->Form->end() ?>
			</div>
    	</div>
		
		<div class="col-sm-6">
			<?php if (!empty($offices)): ?>
			<div class="contact-card contact-locations" id="contactLocations" data-default-office="<?= h($defaultOfficeKey) ?>">
				<h2 class="contact-card-title">Our offices</h2>
				<ul class="contact-loc-tabs" role="tablist" aria-label="Office locations">
					<?php foreach ($offices as $key => $office): ?>
					<li role="presentation">
						<button
							type="button"
							role="tab"
							id="contact-tab-<?= h($key) ?>"
							aria-controls="contact-loc-panel"
							aria-selected="<?= $key === $defaultOfficeKey ? 'true' : 'false' ?>"
							class="<?= $key === $defaultOfficeKey ? 'is-active' : '' ?>"
							data-office-key="<?= h($key) ?>"
						><?= h($office['tab'] ?? $office['code'] ?? strtoupper($key)) ?></button>
					</li>
					<?php endforeach; ?>
				</ul>

				<div class="contact-loc-panel" id="contact-loc-panel" role="tabpanel" aria-labelledby="contact-tab-<?= h($defaultOfficeKey) ?>">
					<ul class="contact-loc-rows">
						<li>
							<i class="fa fa-phone" aria-hidden="true"></i>
							<a href="tel:<?= h(preg_replace('/[^0-9+]/', '', $defaultPhone)) ?>" id="contactLocPhone"><?= h($defaultPhone) ?></a>
						</li>
						<li>
							<i class="fa fa-envelope" aria-hidden="true"></i>
							<a href="mailto:<?= h($defaultEmail) ?>" id="contactLocEmail"><?= h($defaultEmail) ?></a>
						</li>
						<li>
							<i class="fa fa-map-marker" aria-hidden="true"></i>
							<span id="contactLocAddress"><?= h($defaultAddress) ?></span>
						</li>
						<li>
							<i class="fa fa-clock-o" aria-hidden="true"></i>
							<span id="contactLocHours"><?= h($defaultHours) ?></span>
						</li>
					</ul>

					<ul class="contact-loc-social" aria-label="Social media">
						<li><a href="https://www.instagram.com/durotech_australia" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
						<li><a href="<?= h(FACEBOOK) ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
						<li><a href="<?= h(TWITER) ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
					</ul>

					<h3 class="contact-loc-map-title">Where we are</h3>
					<div class="contact-loc-map-wrap">
					<iframe
						id="contactLocMap"
						class="contact-loc-map-frame"
						src="<?= h($defaultEmbed) ?>"
						title="Durotech office map"
						loading="lazy"
						referrerpolicy="no-referrer-when-downgrade"
						allowfullscreen
					></iframe>
					</div>
					<a id="contactLocMapsLink" class="contact-loc-directions" href="<?= h($defaultMaps) ?>" target="_blank" rel="noopener">Get directions →</a>
				</div>
			</div>
			<?php else: ?>
			<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3306.906870705087!2d150.84016091521423!3d-34.020601380614615!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6b12ec14b95fb3e5%3A0x849fcaeff6aba18e!2sDurotech+Industries!5e0!3m2!1sen!2sin!4v1517992006603" width="100%" height="320px" frameborder="0" style="border:0" allowfullscreen></iframe>
			<?php endif; ?>
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
							<i class="fa fa-envelope" aria-hidden="true"></i> &nbsp
							<a href="mailto:<?php echo h(MAILTO); ?>"><?php echo h(MAILTO); ?></a>
							<br>
							<br>
							<i class="fa fa-globe" aria-hidden="true"></i> &nbsp
							<a href="https://www.durotechindustries.com.au" target="_blank" rel="noopener">www.durotechindustries.com.au</a>
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
							<i class="fa fa-mobile" aria-hidden="true"></i> &nbsp
							<a href="tel:<?php echo h(preg_replace('/[^0-9+]/', '', (string)PHONE)); ?>"><?php echo h(PHONE); ?></a>
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
						<h3 class="title">ADDRESSES</h3>
						<?php if (!empty($offices)): ?>
    					<ul class="contact-address-list">
							<?php foreach ($offices as $office): ?>
							<li>
								<span class="state"><?= h($office['code'] ?? '') ?></span>
								<a href="<?= h($office['mapUrl'] ?? '#') ?>" target="_blank" rel="noopener"><?= h($office['address'] ?? '') ?></a>
							</li>
							<?php endforeach; ?>
						</ul>
						<?php else: ?>
    					<p>
							 <i class="fa fa-map-marker" aria-hidden="true"></i> &nbsp 
								<a href="https://www.google.com/maps/search/?api=1&amp;query=<?= rawurlencode((string)ADDRESS) ?>" target="_blank" rel="noopener"><?= h(ADDRESS) ?></a>
						</p>
						<?php endif; ?>
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

	(function () {
		var offices = <?= $officesJson ?: '{}' ?>;
		var root = document.getElementById('contactLocations');
		if (!root || !offices) return;

		var tabs = root.querySelectorAll('.contact-loc-tabs button');
		var phoneEl = document.getElementById('contactLocPhone');
		var emailEl = document.getElementById('contactLocEmail');
		var addressEl = document.getElementById('contactLocAddress');
		var hoursEl = document.getElementById('contactLocHours');
		var mapEl = document.getElementById('contactLocMap');
		var mapsLink = document.getElementById('contactLocMapsLink');
		var panel = document.getElementById('contact-loc-panel');

		function setOffice(key) {
			var office = offices[key];
			if (!office) return;

			tabs.forEach(function (btn) {
				var active = btn.getAttribute('data-office-key') === key;
				btn.classList.toggle('is-active', active);
				btn.setAttribute('aria-selected', active ? 'true' : 'false');
			});

			if (panel) {
				panel.setAttribute('aria-labelledby', 'contact-tab-' + key);
			}

			var phone = office.phone || '';
			var email = office.email || '';
			if (phoneEl) {
				phoneEl.textContent = phone;
				phoneEl.href = 'tel:' + String(phone).replace(/[^0-9+]/g, '');
			}
			if (emailEl) {
				emailEl.textContent = email;
				emailEl.href = 'mailto:' + email;
			}
			if (addressEl) addressEl.textContent = office.address || '';
			if (hoursEl) hoursEl.textContent = office.hours || '';
			if (mapEl && office.embedUrl) {
				mapEl.src = office.embedUrl;
				mapEl.title = (office.name || 'Durotech') + ' map';
			}
			if (mapsLink) {
				mapsLink.href = office.mapUrl || '#';
			}
		}

		tabs.forEach(function (btn) {
			btn.addEventListener('click', function () {
				setOffice(btn.getAttribute('data-office-key'));
			});
		});
	})();
</script>
