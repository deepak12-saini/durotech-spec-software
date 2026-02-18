	<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar                  responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				

				<ul class="nav nav-list">
					<li class="<?php if ($this->params['action']=='monthly_specs') echo 'active'; ?>">
						<a href="<?php echo SITEURL ?>employees/monthly_specs">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>
						<b class="arrow"></b>
					</li>
					
				   <li class="<?php if ($this->params['controller']=='employees' && $this->params['action']=='presentation') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>employees/index">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text">DuroEzy Spec</span>
						</a>
						<b class="arrow"></b>
					</li>		


					<li class="<?php if ($this->params['controller']=='case_studies' && $this->params['action']=='index') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>employees/case_studies">
							<i class="menu-icon fa fa-briefcase"></i>
							<span class="menu-text">Case Studies</span>
						</a>                               
					</li>


					<li class="<?php if ($this->params['controller']=='testimonials' && $this->params['action']=='employee_index') {echo 'active';}?>">
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
					try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
				</script>
			</div>