<div class="contact_banner col-lg-12 col-md-12 col-sm-12">
	<img src="<?php echo SITEURL; ?>customdurotech/images/contact_banner.jpg" alt="">
</div>
<div class="contact_us_page col-lg-12 col-md-12 col-sm-12">
	<div class="container animated fadeIn">
		<div class="row">
			<h1 class="header-title">Method Statement request</h1>
			<hr>
			<div class="col-sm-12 col-md-10 col-md-offset-1">
				<?php echo $this->Flash->render(); ?>
				<p class="lead" style="margin-bottom:20px;">
					Tell us about your project scope and we will follow up. Fields marked <span style="color:#c00;">*</span> are required.
				</p>
				<?php
				echo $this->Form->create(null, [
					'url' => '/method-statement',
					'type' => 'post',
					'class' => 'contact-form',
					'id' => 'method-statement-form',
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
							<label for="start_date">Preferred start / timeline</label>
							<input type="text" class="form-control" id="start_date" name="start_date" maxlength="64"
								placeholder="e.g. Q2 2026 or ASAP"
								value="<?php echo h($this->request->getData('start_date') ?? ''); ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="scope_of_work">Scope of work <span style="color:#c00;">*</span></label>
					<textarea class="form-control" rows="5" id="scope_of_work" name="scope_of_work" required maxlength="5000" placeholder="Describe the work required for the method statement"><?php echo h($this->request->getData('scope_of_work') ?? ''); ?></textarea>
				</div>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label for="system_used">Product / system (if known)</label>
							<select class="form-control" id="system_used" name="system_used">
								<option value="">— Optional —</option>
								<?php
								$su = (string)($this->request->getData('system_used') ?? '');
								foreach ($productOptions ?? [] as $p) {
									$title = is_object($p) ? (string)($p->title ?? '') : (string)($p['title'] ?? '');
									if ($title === '') {
										continue;
									}
									$sel = ($su === $title) ? ' selected' : '';
									echo '<option value="' . h($title) . '"' . $sel . '>' . h($title) . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
							<label for="substrate">Substrate</label>
							<input type="text" class="form-control" id="substrate" name="substrate" maxlength="255"
								placeholder="e.g. concrete, membrane over existing"
								value="<?php echo h($this->request->getData('substrate') ?? ''); ?>">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="project_address">Project address / location</label>
					<input type="text" class="form-control" id="project_address" name="project_address" maxlength="512"
						value="<?php echo h($this->request->getData('project_address') ?? ''); ?>">
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
					<label for="notes">Additional notes</label>
					<textarea class="form-control" rows="4" id="notes" name="notes" maxlength="2000" placeholder="Optional"><?php echo h($this->request->getData('notes') ?? ''); ?></textarea>
				</div>
				<div class="form-group">
					<input type="text" name="website" value="" tabindex="-1" autocomplete="off" style="position:absolute;left:-10000px;top:auto;width:1px;height:1px;overflow:hidden;" aria-hidden="true">
				</div>
				<div class="form-group">
					<label for="captcha">Captcha <span style="color:#c00;">*</span></label><br>
					<input type="text" class="form-control" id="captcha" name="captcha" maxlength="6" required style="max-width:220px;display:inline-block;" placeholder="Enter code"
						value="">
					<img src="<?php echo $this->Url->build('/method-statement/captcha'); ?>" alt="Captcha" style="vertical-align:middle;margin-left:8px;">
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
