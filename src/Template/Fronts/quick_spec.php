<div class="contact_banner col-lg-12 col-md-12 col-sm-12">
	<img src="<?php echo SITEURL; ?>customdurotech/images/contact_banner.jpg" alt="">
</div>
<div class="contact_us_page col-lg-12 col-md-12 col-sm-12">
	<div class="container animated fadeIn">
		<div class="row">
			<h1 class="header-title">Quick Spec request</h1>
			<hr>
			<div class="col-sm-12 col-md-10 col-md-offset-1">
				<?php echo $this->Flash->render(); ?>
				<p class="lead" style="margin-bottom:20px;">
					Tell us about your project and we will follow up. Fields marked <span style="color:#c00;">*</span> are required.
				</p>
				<?php
				echo $this->Form->create(null, [
					'url' => '/quick-spec',
					'type' => 'post',
					'class' => 'contact-form',
					'id' => 'quick-spec-form',
				]);
				?>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="project_name">Project name <span style="color:#c00;">*</span></label>
							<input type="text" class="form-control" id="project_name" name="project_name" required maxlength="255"
								value="<?php echo h($this->request->getData('project_name') ?? ''); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="project_type">Project type <span style="color:#c00;">*</span></label>
							<select class="form-control" id="project_type" name="project_type" required>
								<option value="">— Select —</option>
								<?php
								$pt = (string)($this->request->getData('project_type') ?? '');
								foreach (['Residential', 'Commercial', 'Industrial', 'Infrastructure', 'Other'] as $opt) {
									$sel = ($pt === $opt) ? ' selected' : '';
									echo '<option value="' . h($opt) . '"' . $sel . '>' . h($opt) . '</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="area">Area / application <span style="color:#c00;">*</span></label>
							<select class="form-control" id="area" name="area" required>
								<option value="">— Select —</option>
								<?php
								$ar = (string)($this->request->getData('area') ?? '');
								foreach (['Roof', 'Balcony', 'Basement', 'Podium', 'Planter box', 'Pod', 'Other'] as $opt) {
									$sel = ($ar === $opt) ? ' selected' : '';
									echo '<option value="' . h($opt) . '"' . $sel . '>' . h($opt) . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="system_interest">Product / system of interest</label>
							<select class="form-control" id="system_interest" name="system_interest">
								<option value="">— Optional —</option>
								<?php
								$si = (string)($this->request->getData('system_interest') ?? '');
								foreach ($productOptions ?? [] as $p) {
									$title = is_object($p) ? (string)($p->title ?? '') : (string)($p['title'] ?? '');
									$id = is_object($p) ? (string)($p->id ?? '') : (string)($p['id'] ?? '');
									if ($title === '') {
										continue;
									}
									$val = $title;
									$sel = ($si === $val) ? ' selected' : '';
									echo '<option value="' . h($val) . '"' . $sel . '>' . h($title) . '</option>';
								}
								?>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="quantity_or_size">Quantity / size (optional)</label>
					<input type="text" class="form-control" id="quantity_or_size" name="quantity_or_size" maxlength="128"
						placeholder="e.g. approx. m², number of levels"
						value="<?php echo h($this->request->getData('quantity_or_size') ?? ''); ?>">
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="name">Your name <span style="color:#c00;">*</span></label>
							<input type="text" class="form-control" id="name" name="name" required maxlength="255"
								value="<?php echo h($this->request->getData('name') ?? ''); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="email">Email <span style="color:#c00;">*</span></label>
							<input type="email" class="form-control" id="email" name="email" required maxlength="255"
								value="<?php echo h($this->request->getData('email') ?? ''); ?>">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="phone">Phone <span style="color:#c00;">*</span></label>
							<input type="text" class="form-control" id="phone" name="phone" required maxlength="20"
								value="<?php echo h($this->request->getData('phone') ?? ''); ?>">
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="company">Company</label>
							<input type="text" class="form-control" id="company" name="company" maxlength="255"
								value="<?php echo h($this->request->getData('company') ?? ''); ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="state">State / territory</label>
					<select class="form-control" id="state" name="state">
						<option value="">— Optional —</option>
						<?php
						$st = (string)($this->request->getData('state') ?? '');
						foreach (['NSW', 'VIC', 'QLD', 'SA', 'WA', 'TAS', 'NT', 'ACT', 'Other'] as $opt) {
							$sel = ($st === $opt) ? ' selected' : '';
							echo '<option value="' . h($opt) . '"' . $sel . '>' . h($opt) . '</option>';
						}
						?>
					</select>
				</div>
				<div class="form-group">
					<label for="notes">Notes</label>
					<textarea class="form-control" rows="5" id="notes" name="notes" maxlength="2000" placeholder="Additional details (optional)"><?php echo h($this->request->getData('notes') ?? ''); ?></textarea>
				</div>
				<div class="form-group">
					<input type="text" name="website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
				</div>
				<div class="form-group">
					<label for="captcha">Captcha <span style="color:#c00;">*</span></label><br>
					<input type="text" class="form-control" id="captcha" name="captcha" maxlength="6" required style="max-width:220px;display:inline-block;" placeholder="Enter code"
						value="">
					<img src="<?php echo $this->Url->build('/quick-spec/captcha'); ?>" alt="Captcha" style="vertical-align:middle;margin-left:8px;">
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Submit request</button>
					<a href="<?php echo $this->Url->build(['controller' => 'Fronts', 'action' => 'technicalLiteratureNew']); ?>" class="btn btn-default" style="margin-left:8px;">Back to Technical Literature</a>
				</div>
				<?php echo $this->Form->end(); ?>
			</div>
		</div>
	</div>
</div>
