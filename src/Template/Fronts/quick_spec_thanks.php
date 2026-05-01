<div class="contact_us_page col-lg-12 col-md-12 col-sm-12" style="padding-top:40px;padding-bottom:80px;">
	<div class="container animated fadeIn">
		<div class="row">
			<div class="col-sm-12 col-md-8 col-md-offset-2 text-center">
				<?php echo $this->Flash->render(); ?>
				<h1 class="header-title">Thank you</h1>
				<hr>
				<p class="lead">
					We have received your Quick Spec request. Our team will review it and contact you using the details you provided.
				</p>
				<p>
					<a href="<?php echo $this->Url->build(['controller' => 'Fronts', 'action' => 'technicalLiteratureNew']); ?>" class="btn btn-primary">Back to Technical Literature</a>
					<a href="<?php echo $this->Url->build('/'); ?>" class="btn btn-default" style="margin-left:8px;">Home</a>
				</p>
			</div>
		</div>
	</div>
</div>
