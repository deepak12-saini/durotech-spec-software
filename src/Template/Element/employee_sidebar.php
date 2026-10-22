<style>
	/* Bolder sidebar labels for clearer UI */
	#sidebar.sidebar .nav-list > li > a .menu-text {
		font-weight: 700;
		color: #393939;
	}
	#sidebar.sidebar .nav-list > li.active > a .menu-text {
		font-weight: 700;
		color: #2b6a9b;
	}
	#sidebar.sidebar .nav-list > li > a:hover .menu-text {
		font-weight: 700;
	}
	#sidebar.sidebar .nav-list > li .submenu > li > a {
		font-weight: 600;
	}
	#sidebar.sidebar .nav-list > li .submenu > li.active > a {
		font-weight: 700;
		color: #478fca;
	}
	#main-container > #sidebar.sidebar {
		position: relative;
		z-index: 1026;
	}
	#main-container > #sidebar.sidebar .sidebar-toggle,
	#main-container > #sidebar.sidebar #sidebar-collapse {
		position: relative;
		z-index: 1030;
	}
</style>
	<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				

				<?php
				$activeController = strtolower((string)$this->request->getParam('controller'));
				$activeAction = strtolower((string)$this->request->getParam('action'));
				$activeMode = (string)$this->request->getQuery('mode');

				$isDashboardActive = $activeController === 'employees'
					&& in_array($activeAction, ['dashboard', 'monthly_specs', 'monthlyspecs'], true);
				$isSmartSpecActive = $activeController === 'employees'
					&& in_array($activeAction, ['employee_send_v3', 'employeesendv3'], true)
					&& $activeMode === 'adaptive';
				$isDuroEzySpecActive = $activeController === 'employees'
					&& (
						in_array($activeAction, ['index', 'audit_log', 'auditlog'], true)
						|| (
							in_array($activeAction, ['employee_send_v3', 'employeesendv3'], true)
							&& $activeMode !== 'adaptive'
						)
					);
				$isCaseStudiesActive = $activeController === 'employees'
					&& in_array($activeAction, ['case_studies', 'casestudies', 'case_add', 'caseadd', 'case_edit', 'caseedit', 'case_delete', 'casedelete'], true);
				$isTestimonialsActive = $activeController === 'testimonials'
					&& in_array($activeAction, ['employee_index', 'employeeindex', 'employee_add', 'employeeadd', 'employee_edit', 'employeeedit', 'employee_delete', 'employeedelete'], true);
				$isAiSpecsActive = $activeController === 'aispecs'
					&& in_array($activeAction, ['employee_index', 'employeeindex', 'employee_send', 'employeesend', 'employee_view', 'employeeview', 'employee_edit', 'employeeedit', 'employee_delete', 'employeedelete'], true);
				$isClaudeSpecsActive = $activeController === 'claudespecs'
					&& in_array($activeAction, ['employee_index', 'employeeindex', 'employee_send', 'employeesend', 'employee_view', 'employeeview', 'employee_edit', 'employeeedit', 'employee_regenerate', 'employeeregenerate', 'employee_apply', 'employeeapply', 'employee_delete', 'employeedelete'], true);
				?>

				<ul class="nav nav-list">
					<li class="<?php echo $isDashboardActive ? 'active' : ''; ?>">
						<a href="<?php echo SITEURL ?>employees/monthly_specs">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>
						<b class="arrow"></b>
					</li>
					
				   <li class="<?php echo $isDuroEzySpecActive ? 'active' : ''; ?>">
						<a href="<?php echo SITEURL?>employees/index">
							<i class="menu-icon fa fa-file-text-o"></i>
							<span class="menu-text">DuroEzy Spec</span>
						</a>
						<b class="arrow"></b>
					</li>

					<li class="<?php echo ($activeController === 'spechub') ? 'active' : ''; ?>">
						<a href="<?php echo SITEURL; ?>employees/spec-hub">
							<i class="menu-icon fa fa-sitemap"></i>
							<span class="menu-text">Project Specifications</span>
						</a>
						<b class="arrow"></b>
					</li>

					<li class="<?php echo $isSmartSpecActive ? 'active' : ''; ?>">
						<a href="<?php echo SITEURL?>employees/employee_send_v3?mode=adaptive">
							<i class="menu-icon fa fa-magic"></i>
							<span class="menu-text">Smart Spec</span>
						</a>
						<b class="arrow"></b>
					</li>

					<?php /* Claude Spec Assistant hidden for now. Uncomment when ready to enable.
					<li class="<?php echo $isClaudeSpecsActive ? 'active' : ''; ?>">
						<a href="<?php echo $this->Url->build(['controller' => 'ClaudeSpecs', 'action' => 'employee_index']); ?>">
							<i class="menu-icon fa fa-comments"></i>
							<span class="menu-text">Claude Spec Assistant</span>
						</a>
						<b class="arrow"></b>
					</li>
					*/ ?>

					<li class="<?php echo $isAiSpecsActive ? 'active' : ''; ?>">
						<a href="<?php echo $this->Url->build(['controller' => 'AiSpecs', 'action' => 'employee_index']); ?>">
							<i class="menu-icon fa fa-th"></i>
							<span class="menu-text">AiSpec materials matrix</span>
						</a>
						<b class="arrow"></b>
					</li>

					<?php /* Template Presets — hidden until client confirms Template Spec. Uncomment to enable.
					<li class="<?php echo ($activeController === 'employees' && in_array($activeAction, ['template_presets', 'templatepresets', 'edit_template_preset', 'edittemplatepreset'], true)) ? 'active' : ''; ?>">
						<a href="<?php echo SITEURL; ?>employees/template_presets" title="Template Presets">
							<i class="menu-icon fa fa-bookmark"></i>
							<span class="menu-text">Template Presets</span>
						</a>
						<b class="arrow"></b>
					</li>
					*/ ?>


					<li class="<?php echo $isCaseStudiesActive ? 'active' : ''; ?>">
						<a href="<?php echo SITEURL?>employees/case_studies">
							<i class="menu-icon fa fa-briefcase"></i>
							<span class="menu-text">Case Studies</span>
						</a>                               
					</li>


					<li class="<?php echo $isTestimonialsActive ? 'active' : ''; ?>">
						<a href="<?php echo $this->Url->build(['controller' => 'Testimonials', 'action' => 'employee_index']); ?>">
							<i class="menu-icon fa fa-comment"></i>
							<span class="menu-text">Testimonials</span>
						</a>
					</li>


					<!-- <li class="<?php //if ($this->params['action']=='monthly_specs') echo 'active'; ?>">
						<a href="<?php //echo SITEURL ?>employees/monthly_specs">
							<i class="menu-icon fa fa-bar-chart"></i>
							<span class="menu-text"> Monthly Specs </span>
						</a>
						<b class="arrow"></b>
					</li> -->





					
					<!--<li class="<?php if ($this->params['controller']=='users' && $this->params['action']=='questionlist') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>users/questionlist">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Architect  Refuel CPD </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if ($this->params['controller']=='users' && $this->params['action']=='labfile') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>users/labfile">
							<i class="menu-icon fa fa-bars "></i>
							<span class="menu-text">Price List</span></b>
						</a>

					</li>	 -->
					<!-- <li class="<?php if (($this->params['controller']=='products') && ($this->params['action']=='label' || $this->params['action']=='datasheet')) {echo 'active';}?>">
						<a href="<?php echo SITEURL?>products/label">
							<i class="menu-icon fa fa-file "></i>
							<span class="menu-text">Product Label</span></b>
						</a>
					</li>	 -->
					<!-- <li class="<?php if (($this->params['controller']=='users') && ($this->params['action']=='profile'  ||  $this->params['action']=='change_password') ) {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cog "></i>
							<span class="menu-text"> Settings </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="<?php if ($this->params['controller']=='users' && $this->params['action']=='profile') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>users/profile">
									<i class="menu-icon fa fa-setting"></i>
									Profile
								</a>

								<b class="arrow"></b>
							</li>
							
							<li class="<?php if ($this->params['controller']=='users' && $this->params['action']=='change_password') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>users/change_password">
									<i class="menu-icon fa fa-setting"></i>
									Change Password
								</a>

								<b class="arrow"></b>
							</li>
							
						</ul>
					</li> -->

					<li class="">
						<a href="<?php echo SITEURL?>">
							<i class="menu-icon fa fa-home"></i>
							<span class="menu-text"> Home Page </span>
						</a>

						<b class="arrow"></b>
					</li>
							
				</ul><!-- /.nav-list -->

				<!-- #section:basics/sidebar.layout.minimize -->
				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<!-- /section:basics/sidebar.layout.minimize -->
				<script type="text/javascript">
					/* Do not run ace.settings.check('sidebar','collapsed') here —
					   cookie can fight hardcoded menu-min and break the expand toggle. */
				</script>
			</div>