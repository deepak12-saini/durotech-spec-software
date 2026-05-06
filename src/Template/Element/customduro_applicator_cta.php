<?php
/**
 * Applicator portal CTA — shown above footer (not on Contact page).
 * File must be .php: AppView sets $_ext = '.php' (see src/View/AppView.php).
 */
?>
<style>
.applicator-cta-section {
	background: #e4edf4;
	padding: 48px 15px 56px;
	font-family: 'Raleway', 'Helvetica Neue', Helvetica, Arial, sans-serif;
}
.applicator-cta-inner {
	max-width: 1140px;
	margin: 0 auto;
}
.applicator-cta-row {
	display: flex;
	flex-wrap: wrap;
	align-items: center;
	margin: 0 -15px;
}
.applicator-cta-col-text {
	flex: 1 1 300px;
	padding: 15px 15px 25px;
	min-width: 280px;
}
.applicator-cta-col-img {
	flex: 1 1 320px;
	padding: 15px;
	min-width: 280px;
}
.applicator-cta-label-row {
	display: flex;
	align-items: center;
	gap: 10px;
	margin-bottom: 16px;
}
.applicator-cta-label-text {
	font-size: 15px;
	font-weight: 600;
	color: #000000;
	margin: 0;
}
.applicator-cta-headline {
	font-size: 28px;
	font-weight: 800;
	line-height: 1.25;
	color: #4B2C8C;
	margin: 0 0 16px;
}
.applicator-cta-sub {
	font-size: 15px;
	line-height: 1.6;
	color: #666666;
	margin: 0 0 28px;
	max-width: 520px;
}
.applicator-cta-btn {
	display: inline-block;
	padding: 12px 32px;
	border-radius: 999px;
	border: 1px solid #cccccc;
	background: transparent;
	color: #4B2C8C !important;
	font-size: 15px;
	font-weight: 600;
	text-decoration: none !important;
	transition: border-color 0.2s, background 0.2s;
}
.applicator-cta-btn:hover,
.applicator-cta-btn:focus {
	border-color: #4B2C8C;
	background: rgba(75, 44, 140, 0.04);
	color: #4B2C8C !important;
}
button.applicator-cta-btn {
	cursor: pointer;
	font-family: inherit;
}
/* Above .navbar-nav .dropdown-menu { z-index: 9999 } in site CSS; BS default modal is 1050 */
.modal-duro-contact.modal {
	z-index: 10050 !important;
}
body.modal-open .modal-backdrop.in {
	z-index: 10045 !important;
}
.modal-duro-contact .modal-dialog {
	width: 94%;
	max-width: 760px;
	margin: 24px auto;
}
@media (min-width: 768px) {
	.modal-duro-contact .modal-dialog {
		width: 90%;
		max-width: 760px;
	}
}
@media (min-width: 1200px) {
	.modal-duro-contact .modal-dialog {
		max-width: 820px;
	}
}
.modal-duro-contact .modal-content {
	border-radius: 10px;
	border: none;
	background: #eceef2;
	box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
}
.modal-duro-contact .modal-header {
	border: none;
	padding: 12px 16px 0;
	min-height: 0;
}
.modal-duro-contact .modal-header .close {
	font-size: 28px;
	font-weight: 300;
	opacity: 0.5;
	margin-top: -4px;
}
.modal-duro-contact .modal-body {
	padding: 8px 28px 28px;
	color: #2e2a77;
}
/* Names: stacked on mobile; side-by-side from tablet — no Bootstrap grid (avoids float/clipping bugs) */
.modal-duro-contact .applicator-contact-names .form-group {
	margin-bottom: 14px;
}
@media (min-width: 768px) {
	.modal-duro-contact .applicator-contact-names {
		display: flex;
		gap: 12px;
		align-items: flex-start;
	}
	.modal-duro-contact .applicator-contact-names .form-group {
		flex: 1 1 0;
		min-width: 0;
		margin-bottom: 14px;
	}
}
@media (max-width: 767px) {
	.modal-duro-contact .modal-dialog {
		margin: 10px !important;
		width: auto !important;
		max-width: none !important;
	}
	/* Let Bootstrap .modal scroll the dialog; inner overflow was clipping the first field on some phones */
	.modal-duro-contact .modal-content {
		max-height: none;
		overflow: visible;
	}
	.modal-duro-contact .modal-body {
		padding: 12px 16px 20px;
	}
}
.modal-duro-contact .form-control {
	background: #dfe8f0;
	border: none;
	border-radius: 6px;
	height: 44px;
	box-shadow: none;
	color: #333;
}
.modal-duro-contact textarea.form-control {
	height: auto;
	min-height: 140px;
	resize: vertical;
}
.modal-duro-contact .form-group {
	margin-bottom: 14px;
}
.modal-duro-contact .help-block-duro {
	font-size: 13px;
	color: #555;
	line-height: 1.45;
	margin: 8px 0 14px;
}
.modal-duro-contact .captcha-row {
	display: flex;
	align-items: center;
	gap: 12px;
	flex-wrap: wrap;
}
.modal-duro-contact .captcha-row img {
	border-radius: 4px;
	height: 34px;
}
.modal-duro-contact .btn-duro-submit {
	width: 100%;
	background: #8CC63F;
	color: #fff !important;
	border: none;
	border-radius: 24px;
	padding: 14px 16px;
	font-size: 16px;
	font-weight: 700;
	margin-top: 8px;
}
.modal-duro-contact .btn-duro-submit:disabled {
	opacity: 0.65;
	cursor: not-allowed;
}
.modal-duro-contact .success-msg {
	text-align: center;
	padding: 24px 8px;
	font-size: 16px;
	color: #2e7d32;
	font-weight: 600;
}
.applicator-cta-img-wrap {
	border-radius: 14px;
	overflow: hidden;
	box-shadow: 0 6px 20px rgba(46, 42, 119, 0.1);
	height: 260px;
	background: #e8e8ec;
}
.applicator-cta-img-wrap img {
	width: 100%;
	height: 100%;
	object-fit: cover;
	object-position: center;
	display: block;
}
@media (min-width: 992px) {
	.applicator-cta-img-wrap {
		height: 300px;
	}
}
@media (max-width: 767px) {
	.applicator-cta-section {
		padding: 32px 12px 40px;
	}
	.applicator-cta-headline {
		font-size: 22px;
	}
	.applicator-cta-col-text {
		padding-bottom: 8px;
	}
}
</style>
<section class="applicator-cta-section col-lg-12 col-md-12 col-sm-12" aria-labelledby="applicator-cta-heading">
	<div class="applicator-cta-inner">
		<div class="applicator-cta-row">
			<div class="applicator-cta-col-text">
				<div class="applicator-cta-label-row">
					<svg width="36" height="36" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
						<circle cx="12" cy="9" r="4" fill="#8CC63F"/>
						<path d="M6 19c0-3 2.5-5 6-5s6 2 6 5" fill="none" stroke="#8CC63F" stroke-width="2" stroke-linecap="round"/>
					</svg>
					<p class="applicator-cta-label-text">For applicators</p>
				</div>
				<h2 id="applicator-cta-heading" class="applicator-cta-headline">Applicator ordering, specifications &amp; project support</h2>
				<p class="applicator-cta-sub">Durotech is an Australian manufacturer of waterproofing membranes and coatings for wet areas, decks, roofs and facades — systems contractors have relied on for over 48 years. Contact us for product selection, documentation and on-site advice.</p>
				<button type="button" class="applicator-cta-btn" data-toggle="modal" data-target="#applicatorContactModal">Contact Us</button>
			</div>
			<div class="applicator-cta-col-img">
				<div class="applicator-cta-img-wrap">
					<img src="<?php echo h(SITEURL); ?>customdurotech/images/durotech_applicator_cta_hero.png" alt="Commercial waterproofing and rooftop construction, Durotech applicators">
				</div>
			</div>
		</div>
	</div>
</section>

<?php
$applicatorContactUrl = $this->Url->build(['controller' => 'Fronts', 'action' => 'contact']);
$applicatorModalInitUrl = $this->Url->build(['controller' => 'Fronts', 'action' => 'contactModalInit']);
$applicatorCaptchaUrl = $this->Url->build(['controller' => 'Fronts', 'action' => 'captch']);
$applicatorCsrf = (string)$this->request->getCookie('csrfToken');
?>
<div class="modal fade modal-duro-contact" id="applicatorContactModal" tabindex="-1" role="dialog" aria-labelledby="applicatorContactModalTitle">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="applicatorContactModalTitle" style="font-weight:700;color:#2e2a77;">Contact us</h4>
			</div>
			<div class="modal-body">
				<div id="applicator-contact-success" class="success-msg" style="display:none;"></div>
				<div id="applicator-contact-form-body">
					<form id="applicator-contact-form" method="post" action="<?php echo h($applicatorContactUrl); ?>" autocomplete="on">
						<input type="hidden" name="_csrfToken" value="<?php echo h($applicatorCsrf); ?>">
						<input type="text" name="website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-9999px;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
						<div class="applicator-contact-names">
							<div class="form-group">
								<label class="sr-only" for="applicator-first-name">First name</label>
								<input type="text" class="form-control" id="applicator-first-name" name="first_name" placeholder="First name*" required maxlength="80" autocomplete="given-name">
							</div>
							<div class="form-group">
								<label class="sr-only" for="applicator-last-name">Last name</label>
								<input type="text" class="form-control" id="applicator-last-name" name="last_name" placeholder="Last name*" required maxlength="80" autocomplete="family-name">
							</div>
						</div>
						<div class="form-group">
							<label class="sr-only" for="applicator-enquiry-type">Enquiry type</label>
							<select class="form-control" id="applicator-enquiry-type" name="enquiry_type" required>
								<option value="">Select</option>
								<option value="Sales">Sales</option>
								<option value="Technical">Technical</option>
							</select>
						</div>
						<div class="form-group">
							<label class="sr-only" for="applicator-phone">Phone number</label>
							<input type="text" class="form-control" id="applicator-phone" name="phone" placeholder="Phone number*" required maxlength="20">
						</div>
						<div class="form-group">
							<label class="sr-only" for="applicator-email">Email address</label>
							<input type="email" class="form-control" id="applicator-email" name="email" placeholder="Email address*" required maxlength="120">
						</div>
						<div class="form-group">
							<label class="sr-only" for="applicator-company">Company name</label>
							<input type="text" class="form-control" id="applicator-company" name="company" placeholder="Company name*" required maxlength="160">
						</div>
						<p class="help-block-duro">Please tell us below what your enquiry is about. If it&rsquo;s related to a product or a specification for a project, please enter this below before you submit your enquiry.</p>
						<div class="form-group">
							<label class="sr-only" for="applicator-message">Your enquiry</label>
							<textarea class="form-control" id="applicator-message" name="message" placeholder="Enter answer here" required maxlength="2000"></textarea>
						</div>
						<div class="form-group captcha-row">
							<input type="text" class="form-control" id="applicator-captcha" name="captcha" placeholder="Enter captcha" required maxlength="6" style="max-width:160px;">
							<img id="applicator-contact-captcha-img" src="" alt="Captcha" width="80" height="30">
						</div>
						<button type="submit" class="btn btn-duro-submit" id="applicator-contact-submit" disabled>Please wait&hellip;</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
(function() {
	var initUrl = <?php echo json_encode($applicatorModalInitUrl); ?>;
	var captchaBase = <?php echo json_encode($applicatorCaptchaUrl); ?>;
	var $modal = jQuery('#applicatorContactModal');
	if (!$modal.length) { return; }
	function refreshCaptcha() {
		jQuery('#applicator-contact-captcha-img').attr('src', captchaBase + '?t=' + Date.now());
	}
	function armSubmitButton() {
		var $btn = jQuery('#applicator-contact-submit');
		$btn.prop('disabled', true).text('Please wait…');
		window.setTimeout(function() {
			$btn.prop('disabled', false).text('Submit');
		}, 3200);
	}
	$modal.on('show.bs.modal', function() {
		if (!$modal.parent().is('body')) {
			$modal.appendTo('body');
		}
	});
	$modal.on('shown.bs.modal', function() {
		$modal.scrollTop(0);
		jQuery(document).scrollTop(0);
		jQuery.getJSON(initUrl).always(function() {
			refreshCaptcha();
			armSubmitButton();
		});
	});
	$modal.on('hidden.bs.modal', function() {
		var f = document.getElementById('applicator-contact-form');
		if (f) { f.reset(); }
		jQuery('#applicator-contact-form-body').show();
		jQuery('#applicator-contact-success').hide().text('');
		jQuery('#applicator-captcha').val('');
	});
	jQuery('#applicator-contact-form').on('submit', function(e) {
		e.preventDefault();
		var $form = jQuery(this);
		var $btn = jQuery('#applicator-contact-submit');
		$btn.prop('disabled', true);
		jQuery.ajax({
			url: $form.attr('action'),
			type: 'POST',
			data: $form.serialize(),
			dataType: 'json',
			headers: { 'X-Requested-With': 'XMLHttpRequest' },
			complete: function() {
				$btn.prop('disabled', false).text('Submit');
			},
			success: function(res) {
				if (res && res.success) {
					jQuery('#applicator-contact-form-body').hide();
					jQuery('#applicator-contact-success').text(res.message || 'Sent.').show();
					window.setTimeout(function() { $modal.modal('hide'); }, 2200);
					return;
				}
				var msg = (res && res.message) ? res.message : 'Could not send. Please try again.';
				window.alert(msg);
				if (res && res.refreshCaptcha) {
					jQuery.getJSON(initUrl).always(function() { refreshCaptcha(); armSubmitButton(); });
				}
			},
			error: function(xhr) {
				var msg = 'Could not send. Please try again.';
				if (xhr.responseJSON && xhr.responseJSON.message) {
					msg = xhr.responseJSON.message;
				}
				window.alert(msg);
			}
		});
	});
})();
</script>
