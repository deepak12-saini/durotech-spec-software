			<?php
				$projectcode = $this->Session->read('projectcode');
			?>
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar responsive menu-min" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
			<!-- <div id="sidebar" class="sidebar                  responsive"> -->
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				
			
				<ul class="nav nav-list">
					<li class="<?php if ($this->params['controller']=='installers' ) {echo 'active';}?>">
						<a href="<?php echo SITEURL?>installers/quation/<?php echo $projectcode; ?>">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Porject </span>
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