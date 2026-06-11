	<?php
	$reqController = strtolower($this->request->getParam('controller'));
	$reqAction = \Cake\Utility\Inflector::underscore($this->request->getParam('action'));

	// New employee spec requests since admin last opened Employees Spec list (see MailersController::refreshEmpSpecMenuLastSeenMarker).
	$empSpecPendingCount = 0;
	if ($this->request->getSession()->read('is_admin')) {
		try {
			$mailerTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Mailer');
			$lastSeenMaxId = (int)$this->request->getSession()->read('Mailers.emp_spec_menu_last_seen_max_id');
			$pendingWhere = [
				'Mailer.type' => 3,
				'Mailer.employee_id >' => 0,
				'Mailer.id >' => $lastSeenMaxId,
				'OR' => [
					['Mailer.status' => 0],
					['Mailer.is_review' => 0],
				],
			];
			$schema = $mailerTable->getSchema();
			if ($schema && $schema->getColumn('save_status')) {
				$pendingWhere[] = [
					'OR' => [
						['Mailer.save_status IS' => null],
						['Mailer.save_status !=' => 'draft'],
					],
				];
			}
			$empSpecPendingCount = (int)$mailerTable->find()->where($pendingWhere)->count();
		} catch (\Throwable $e) {
			$empSpecPendingCount = 0;
		}
	}
	?>
	<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>

			<!-- #section:basics/sidebar -->
			<div id="sidebar" class="sidebar                  responsive">
				<script type="text/javascript">
					try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
				</script>

				

				<ul class="nav nav-list">
					
					<li class="<?php if ($reqController=='users' && $reqAction=='admin_dashboard') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/users/dashboard">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Dashboard </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if ($reqController=='mailers' && $reqAction=='admin_visitor') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/mailers/visitor">
							<i class="menu-icon fa fa-tachometer"></i>
							<span class="menu-text"> Visitor Register </span>
						</a>

						<b class="arrow"></b>
					</li>
					<?php 
					$userid = $this->request->getSession()->read('User.id');
					if($userid != 7){ ?>
					
					
					<li class="<?php if ($reqController=='duro_orders') { echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/duro_orders">
							<i class="menu-icon fa fa-file"></i>
							<span class="menu-text"> Duro Order </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if ($reqController=='natas') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/natas">
							<i class="menu-icon fa fa-certificate"></i>
							<span class="menu-text"> NATA </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if ($reqController=='users' && $reqAction=='admin_loginhisotry') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/users/loginhisotry">
							<i class="menu-icon fa fa-certificate"></i>
							<span class="menu-text"> Login History </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if ($reqController=='materials') {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-file "></i>
							<span class="menu-text">Material Order</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>
					
						<b class="arrow"></b>

						<ul class="submenu">
						
							<li class="<?php if (($reqController=='materials') && ($reqAction=='admin_index' || $reqAction=='admin_add' || $reqAction=='admin_edit' )) {echo 'active'; } ?>">
								<a href="<?php echo SITEURL?>admin/materials">
									<i class="menu-icon fa fa-user"></i>
									 Materials 
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if (($reqController=='materials') && ($reqAction=='admin_orders')){ echo 'active'; } ?>">
								<a href="<?php echo SITEURL?>admin/materials/order/pending">
									<i class="menu-icon fa fa-user"></i>
									 Materials Pending Order
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if (($reqController=='materials') && ($reqAction=='admin_orders')){ echo 'active'; } ?>">
								<a href="<?php echo SITEURL?>admin/materials/order/accepted">
									<i class="menu-icon fa fa-user"></i>
									 Materials Accepted Order
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if (($reqController=='materials') && ($reqAction=='admin_orders')){ echo 'active'; } ?>">
								<a href="<?php echo SITEURL?>admin/materials/order/completed">
									<i class="menu-icon fa fa-user"></i>
									 Materials Completed Order
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
							
					<li class="<?php if ($reqController=='sales' && (($reqAction=='admin_saledasboard') || ($reqAction=='admin_index') || ($reqAction=='admin_salereminder'))) {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-file "></i>
							<span class="menu-text">Sales</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>
					
						<b class="arrow"></b>

						<ul class="submenu">
						
							<li class="<?php if ($reqController=='clients') {echo 'active'; } ?>">
								<a href="<?php echo SITEURL?>admin/clients">
									<i class="menu-icon fa fa-user"></i>
									 CRM
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="<?php if ($reqController=='sales' && $reqAction=='admin_saledasboard') {echo 'active';}?>">
								<a href="<?php echo SITEURL.'admin/sales/saledasboard'; ?>">
									<i class="menu-icon fa fa-setting"></i>
									Sale Dashboard
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='sales' && $reqAction=='admin_index') {echo 'active';}?>">
								<a href="<?php echo SITEURL.'admin/sales'; ?>">
									<i class="menu-icon fa fa-setting"></i>
									Sale Team
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='sales' && $reqAction=='admin_salereminder') {echo 'active';}?>">
								<a href="<?php echo SITEURL.'admin/sales/salereminder'; ?>">
									<i class="menu-icon fa fa-setting"></i>
									Sale Reminder
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					
					<li class="<?php if ($reqController=='productions') {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-file "></i>
							<span class="menu-text">Production App</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							
								<li class="<?php if ($reqController=='productions' && $reqAction=='admin_index') {echo 'active';}?>">
								<a href="<?php echo $this->Url->build(['controller' => 'Productions', 'action' => 'adminIndex']); ?>">
									<i class="menu-icon fa fa-setting"></i>
									Batches Made 
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='productions' && $reqAction=='admin_batch_count_sheet') {echo 'active';}?>">
								<a href="<?php echo $this->Url->build(['controller' => 'Productions', 'action' => 'adminBatchCountSheet']); ?>">
									<i class="menu-icon fa fa-setting"></i>
									QC Result
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>	
					<li class="<?php if ($reqController=='pos' && $reqAction=='admin_index') {echo 'active';}?>">
						<a href="<?php echo $this->Url->build(['controller' => 'Pos', 'action' => 'admin_index']); ?>">
							<i class="menu-icon fa fa-user "></i>
							<span class="menu-text"> DT PO</span>
						</a>
					</li>	
					<li class="<?php if ($reqController=='users' && $reqAction=='admin_quizz') {echo 'active';}?>">
						<a href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'admin_quizz']); ?>">
							<i class="menu-icon fa fa-user "></i>
							<span class="menu-text"> Quest Attendees</span>
						</a>
					</li>
					
					
					<li class="<?php if ($reqController=='fronts' && $reqAction=='admin_index') {echo 'active';}?>">
						<a href="<?php echo $this->Url->build(['controller' => 'Fronts', 'action' => 'admin_index']); ?>">
							<i class="menu-icon fa fa-bell "></i>
							<span class="menu-text"> Push Notification</span>
						</a>
					</li>
					<?php // } ?>


					<li class="<?php if ($reqController=='mailers' && $reqAction=='admin_index') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/mailers">
							<i class="menu-icon fa fa-image "></i>
							<span class="menu-text">DuroEzy Spec</span></b>
						</a>
					</li>


					<!-- //new_code deepak -->

					<li class="<?php if ($reqController=='mailers' && $reqAction=='admin_index_v3') {echo 'active';}?>">
						<a href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_index_v3']); ?>">
							<i class="menu-icon fa fa-image "></i>
							<span class="menu-text">DuroEzy Spec v3 <span class="label label-warning" style="margin-left:6px;">New</span></span></b>
						</a>
					</li>

					<li class="<?php if ($reqController == 'aispecs' && strpos($reqAction, 'admin_') === 0) {echo 'active';} ?>">
						<a href="<?php echo $this->Url->build(['controller' => 'AiSpecs', 'action' => 'admin_index']); ?>">
							<i class="menu-icon fa fa-table"></i>
							<span class="menu-text">AiSpec materials matrix</span></b>
						</a>
					</li>

					<!-- //new_code end deepak -->

					<!-- //new_code deepak 14 june 2025 -->

					<li class="<?php
						if ($reqController == 'mailers' || $reqController == 'quickspecs' || $reqController == 'methodstatements') {
							echo 'active';
							if ($reqController == 'quickspecs' || $reqController == 'methodstatements') {
								echo ' open';
							}
						}
					?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-image"></i>
							<span class="menu-text">Easy Spec Request</span>
							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							<li class="<?php if ($reqController=='mailers' && $reqAction=='admin_specRequest_index') {echo 'active';} ?>">
								<a href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_specRequest_index']); ?>">
									<i class="menu-icon fa fa-plus"></i>
									Add Spec Request
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if ($reqController=='mailers' && $reqAction=='admin_specRequest_approved') {echo 'active';} ?>">
								<a href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_specRequest_approved']); ?>">
									<i class="menu-icon fa fa-check-circle"></i>
									Approved Specs
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if ($reqController=='mailers' && $reqAction=='admin_specRequest_disapproved') {echo 'active';} ?>">
								<a href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_specRequest_disapproved']); ?>">
									<i class="menu-icon fa fa-times-circle"></i>
									Disapproved Specs
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if ($reqController == 'quickspecs' && strpos($reqAction, 'admin_') === 0) {echo 'active';} ?>">
								<a href="<?php echo $this->Url->build(['controller' => 'QuickSpecs', 'action' => 'admin_index']); ?>">
									<i class="menu-icon fa fa-file-text-o"></i>
									Quick Spec requests
								</a>
								<b class="arrow"></b>
							</li>

							<li class="<?php if ($reqController == 'methodstatements' && strpos($reqAction, 'admin_') === 0) {echo 'active';} ?>">
								<a href="<?php echo $this->Url->build(['controller' => 'MethodStatements', 'action' => 'admin_index']); ?>">
									<i class="menu-icon fa fa-file-o"></i>
									Method Statement requests
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>


                   <!-- //new_code end deepak -->


					<li class="<?php if ($reqController=='mailers' && $reqAction=='admin_spec_index') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/mailers/spec_index">
							<i class="menu-icon fa fa-image "></i>
							<span class="menu-text">DuroEzy Spec 1.01</span></b>
						</a>
					</li> 


					<li class="<?php if ($reqController=='mailers' && $reqAction=='emp_spec_index') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/mailers/emp_spec_index">
							<i class="menu-icon fa fa-image "></i>
							<span class="menu-text">Employees Spec<?php
								if ($empSpecPendingCount > 0) {
									$n = (int)$empSpecPendingCount;
									$badgeText = $n === 1 ? '(1)' : '(' . $n . ')';
									echo ' <span class="label label-danger" style="margin-left:6px;font-size:11px;font-weight:600;white-space:nowrap;" title="New employee spec request(s) since you last opened this list — click to review">'
										. h($badgeText)
										. '</span>';
								}
							?></span>
						</a>
					</li>

					<li class="<?php if ($reqController=='mailers' && $reqAction=='admin_eoi') {echo 'active';}?>">
						<a href="<?php echo $this->Url->build(['controller' => 'Mailers', 'action' => 'admin_eoi']); ?>">
							<i class="menu-icon fa fa-image "></i>
							<span class="menu-text">EOI Mailer</span>
						</a>
					</li>
					<li class="<?php if ($reqController=='stocks' && $reqAction=='admin_warrant_request') {echo 'active';}?>">
						<a href="<?php echo $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_warrant_request']); ?>">
							<i class="menu-icon fa fa-image "></i>
							<span class="menu-text">Warrant Request</span>
						</a>
					</li>


					<li class="<?php if ($reqController=='stocks' && $reqAction=='admin_product_warranty_request') {echo 'active';}?>">
						<a href="<?php echo $this->Url->build(['controller' => 'Stocks', 'action' => 'admin_product_warranty_request']); ?>">
							<i class="menu-icon fa fa-image "></i>
							<span class="menu-text">Product Warranty Req</span>
						</a>
					</li>

					<li class="<?php if ($reqController=='casestudies' && $reqAction=='admin_index') {echo 'active';}?>">
						<a href="<?= $this->Url->build(['controller' => 'CaseStudies', 'action' => 'adminIndex']); ?>">
							<i class="menu-icon fa fa-briefcase"></i>
							<span class="menu-text">Case Studies</span>
						</a>
					</li>

					<li class="<?php if ($reqController=='testimonials' && $reqAction=='admin_index') {echo 'active';}?>">
						<a href="<?= $this->Url->build(['controller' => 'Testimonials', 'action' => 'admin_index']); ?>">
							<i class="menu-icon fa fa-comments"></i>
							<span class="menu-text">Testimonials</span>
						</a>
					</li>

					<li class="<?php if ($reqController=='herosections' && $reqAction=='admin_index') {echo 'active';}?>">
						<a href="<?= $this->Url->build(['controller' => 'HeroSections', 'action' => 'admin_index']); ?>">
							<i class="menu-icon fa fa-video-camera"></i>
							<span class="menu-text">Hero Section</span>
						</a>
					</li>

					<li class="<?php if ($reqController=='instagramposts') {echo 'active';}?>">
						<a href="<?= $this->Url->build(['controller' => 'InstagramPosts', 'action' => 'admin_index']); ?>">
							<i class="menu-icon fa fa-instagram"></i>
							<span class="menu-text">Instagram Posts</span>
						</a>
					</li>



					<li class="<?php if ($reqController=='coas') {echo 'active';}?>">
						<a href="<?= $this->Url->build(['controller' => 'Coas', 'action' => 'admin_index']); ?>">
							<i class="menu-icon fa fa-image "></i>
							<span class="menu-text">Duro COA</span>
						</a>
					</li>
					<li class="<?php if ($reqController=='tasks') {echo 'active';}?>">
						<a href="<?= $this->Url->build(['controller' => 'Tasks', 'action' => 'admin_type']); ?>">
							<i class="menu-icon fa fa-flask"></i>
							<span class="menu-text">DuroLab</span>
						</a>

						<b class="arrow"></b>
					</li>

					<?php  } ?>
					<li class="<?php if ($reqController=='stocks') {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-file "></i>
							<span class="menu-text">Stock Return</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>
					
						<b class="arrow"></b>

						<ul class="submenu">
						
							<li class="<?php if (($reqController=='stocks') && ($reqAction=='index/customer' || $reqAction=='add' || $reqAction=='edit' )) {echo 'active'; } ?>">
								<a href="<?php echo SITEURL?>admin/stocks/index/customer">
									<i class="menu-icon fa fa-user"></i>
									Customer Returns 
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if (($reqController=='stocks') && ($reqAction=='index/supplier')){ echo 'active'; } ?>">
								<a href="<?php echo SITEURL?>admin/stocks/index/supplier">
									<i class="menu-icon fa fa-user"></i>
									Supplier Returns
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
						</li>
					<li class="<?php if (($reqController=='products') && ($reqAction=='admin_label')) {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bars "></i>
							<span class="menu-text"> Label</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>
						<ul class="submenu">						
							<li class="<?php if ($reqController=='products' && $reqAction=='admin_label') {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/products/label">
									<i class="menu-icon fa fa-setting"></i>
									Normal Product Label
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='products' && ($reqAction=='admin_edit_label' || $reqAction=='admin_addlabel' || $reqAction=='admin_editlabel')) {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/products/edit_label">
									<i class="menu-icon fa fa-setting"></i>
									Editable Product Label
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>
					<li class="<?php if ($reqController=='broucher_products' && $reqAction=='admin_index'){echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bars "></i>
							<span class="menu-text">Broucher Product</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							
							<li class="<?php if ($reqController=='broucher_products' && $reqAction=='admin_index') {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/broucher_products">
									<i class="menu-icon fa fa-setting"></i>
									Product List
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>
					<li class="<?php if ($reqController=='categories' || ($reqController=='products' && $reqAction=='admin_index')) {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bars "></i>
							<span class="menu-text"> Product</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="<?php if ($reqController=='categories') {echo 'active';}?>">
								<a href="<?php echo rtrim(SITEURL, '/') . '/admin/categories'; ?>">
									<i class="menu-icon fa fa-setting"></i>
									Category
								</a>
								<b class="arrow"></b>
							</li>
						
							<li class="<?php if ($reqController=='products' && $reqAction=='admin_index') {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/products">
									<i class="menu-icon fa fa-setting"></i>
									Product List
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="<?php if($reqController=='products'  && $reqAction=='admin_voc_vertificate') { echo 'active'; }?>">
								<a href="<?php echo SITEURL?>admin/products/voc_vertificate">
									<i class="menu-icon fa fa-setting"></i>
									Voc Certificate
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li class="<?php if ($reqController=='users' && $reqAction=='admin_staff') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/users/staff">
							<i class="menu-icon fa fa-user "></i>
							<span class="menu-text"> Staff List</span></b>
						</a>
					</li>
					<li class="<?php if ($reqController=='users' && $reqAction=='admin_customer') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/users/customer">
							<i class="menu-icon fa fa-user "></i>
							<span class="menu-text">Customers </span></b>
						</a>

					</li>
					<li class="<?php if ($reqController=='users' && $reqAction=='admin_labfile') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/users/labfile">
							<i class="menu-icon fa fa-money "></i>
							<span class="menu-text">Price List</span></b>
						</a>

					</li>
						
					<li class="<?php if ($reqController=='sheets') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/sheets">
							<i class="menu-icon fa fa-file-excel-o"></i>
							<span class="menu-text"> Smart Sheet </span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if ($reqController=='careers') {echo 'active';}?>">
						<a href="<?php echo SITEURL?>admin/careers">
							<i class="menu-icon fa fa-file-excel-o"></i>
							<span class="menu-text"> careers</span>
						</a>

						<b class="arrow"></b>
					</li>
					<li class="<?php if (($reqController=='purchases') ||  ($reqController=='organisations') || ($reqController=='documents') ||  ($reqController=='audits') ||  ($reqController=='complaints') || ($reqController=='staffs') || ($reqController=='hrs')) { echo 'active'; } ?>" >
					   
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-certificate"></i>
							<span class="menu-text"> ISO </span>
							<b class="arrow fa fa-angle-down"></b>
						</a>	
						<ul class="submenu">
						
						<li class="<?php if (($reqController=='staffs') && ($reqAction=='admin_conformancelist') || $reqAction=='datasheet') {echo 'active';}?>">
							<a href="<?php echo SITEURL?>admin/staffs/conformancelist">
								<i class="menu-icon fa fa-tasks"></i>
								<span class="menu-text">Non Conformance</span></b>
							</a>
						</li>
						<li class="<?php if ($reqController=='complaints') {echo 'active';}?>">
							<a href="<?php echo SITEURL?>admin/complaints">
								<i class="menu-icon fa fa-image "></i>
								<span class="menu-text">Complaints  List</span></b>
							</a>
						</li>
						
						<li class="<?php if ($reqController=='documents') {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-bars "></i>
							<span class="menu-text"> Document</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="<?php if ($reqController=='documents' && $reqAction=='admin_index') {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/documents">
									<i class="menu-icon fa fa-setting"></i>
									Record of library
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='documents' && $reqAction=='admin_receiving_insepction') {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/documents/receiving_insepction">
									<i class="menu-icon fa fa-setting"></i>
									Receive Inspection
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='documents' && $reqAction=='admin_preventive_maintenance') {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/documents/preventive_maintenance">
									<i class="menu-icon fa fa-setting"></i>
									Preventive Maintenance
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='documents' && $reqAction=='admin_executive_duty_requisition') {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/documents/executive_duty_requisition">
									<i class="menu-icon fa fa-setting"></i>
									Executive Duty Requisition
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='documents' && $reqAction=='admin_calibration_equipment') {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/documents/calibration_equipment">
									<i class="menu-icon fa fa-setting"></i>
									Calibration Equipment
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='documents' && $reqAction=='admin_nc_closure') {echo 'active';}?>">
								<a href="<?php echo SITEURL?>admin/documents/nc_closure">
									<i class="menu-icon fa fa-setting"></i>
									Format For NC and NC Closure
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
					<li class="<?php if ($reqController=='hrs') {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-file "></i>
							<span class="menu-text"> HR </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="<?php if ($reqController=='hrs'  && $reqAction=='admin_index') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/hrs">
									<i class="menu-icon fa fa-setting"></i>
									Training Need Assessment
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='hrs'  && $reqAction=='attendence') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/hrs/attendence">
									<i class="menu-icon fa fa-setting"></i>
									Attendence
								</a>
								<b class="arrow"></b>
							</li>
								<li class="<?php if ($reqController=='hrs'  && $reqAction=='admin_performancefeedback') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/hrs/performancefeedback">
									<i class="menu-icon fa fa-setting"></i>
									Performance Feedback
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='hrs'  && $reqAction=='admin_newjoining') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/hrs/newjoining">
									<i class="menu-icon fa fa-setting"></i>
									New Joining 
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='hrs'  && $reqAction=='admin_reportorganization') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/hrs/reportorganization">
									<i class="menu-icon fa fa-setting"></i>
									Joining Report to the Organization
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='hrs'  && $reqAction=='admin_format_training_calendars') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/hrs/format_training_calendars">
									<i class="menu-icon fa fa-setting"></i>
									Format Training Calendars
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='hrs'  && $reqAction=='admin_format_evaluation_employe') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/hrs/format_evaluation_employe">
									<i class="menu-icon fa fa-setting"></i>
									Format Evaluation Employee
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='hrs'  && $reqAction=='admin_hr_appraisal_form') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/hrs/hr_appraisal_form">
								<i class="menu-icon fa fa-setting"></i>
									Performance Appraisal Form
								</a>
								<b class="arrow"></b>
							</li>
						</ul>	
					</li>
					<li class="<?php if ($reqController=='organisations' || $reqController=='purchases') {echo 'active';}?>">
						<a href="" class="dropdown-toggle">
							<i class="menu-icon fa fa-briefcase"></i>
							<span class="menu-text"> Organisation </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="<?php if ($reqController=='organisations' ) {echo 'active';}?>">
								 
								<a href="<?php echo SITEURL;?>admin/organisations"> 
									<i class="menu-icon fa fa-setting"></i>
									Circular Review
								</a>
								<b class="arrow"></b>
							</li>
							
							<li class="<?php if ($reqController=='purchases' && $reqAction=='admin_index') {echo 'active';}?>">
								 
								<a href="<?php echo SITEURL;?>admin/purchases"> 
									<i class="menu-icon fa fa-setting"></i>
									Purchases
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='purchases' && $reqAction=='admin_resource_requirement') {echo 'active';}?>">
								 
								<a href="<?php echo SITEURL;?>admin/purchases/resource_requirement"> 
									<i class="menu-icon fa fa-setting"></i>
									Resource Requirement
								</a>
								<b class="arrow"></b>
							</li>
							
						</ul>
					</li>	
				
							<li class="<?php if ($reqController=='audits') {echo 'active';}?>">
								<a href="#" class="dropdown-toggle">
									<i class="menu-icon fa fa-thumbs-up "></i>
									<span class="menu-text"> Quality Assurance </span>

									<b class="arrow fa fa-angle-down"></b>
								</a>

								<b class="arrow"></b>

								<ul class="submenu">
										<li class="<?php if ($reqController=='audits'  && $reqAction=='admin_index') {echo 'active';}?>">
										<a href="<?php echo SITEURL;?>admin/audits">
											<i class="menu-icon fa fa-setting"></i>
											Audit
										</a>
										<b class="arrow"></b>
									</li>
									<li class="<?php if ($reqController=='audits'  && $reqAction=='admin_circularinternalauditlist') {echo 'active';}?>">
										<a href="<?php echo SITEURL;?>admin/audits/circularinternalauditlist">
											<i class="menu-icon fa fa-setting"></i>
											Circular Internal Audit
										</a>
										<b class="arrow"></b>
									</li>						
								</ul>
							</li>					
						</ul>					
					</li>
					
					<li class="" style="display:none;">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-file "></i>
							<span class="menu-text"> Test certificates </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="">
								<a href="">
									<i class="menu-icon fa fa-setting"></i>
									CSIRO
								</a>
								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="">
									<i class="menu-icon fa fa-setting"></i>
									CETEC
								</a>
								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="">
									<i class="menu-icon fa fa-setting"></i>
									BRANZ
								</a>
								<b class="arrow"></b>
							</li>
							<li class="">
								<a href="">
									<i class="menu-icon fa fa-setting"></i>
									EUROPEAN 
								</a>
								<b class="arrow"></b>
							</li>
						</ul>	
					</li>
						<li class="<?php if ($reqController=='users' && (($reqAction=='admin_subscriber_list') || ($reqAction=='admin_contactus') || ($reqAction=='admin_contact'))) {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-file "></i>
							<span class="menu-text">Subscriber</span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="<?php if ($reqController=='users' && $reqAction=='admin_subscriber_list') {echo 'active';}?>">
								<a href="<?php echo SITEURL.'admin/users/subscriber_list'; ?>">
									<i class="menu-icon fa fa-setting"></i>
									Subscriber List
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='users' && $reqAction=='admin_contactus') {echo 'active';}?>">
								<a href="<?php echo SITEURL.'admin/users/contactus'; ?>">
									<i class="menu-icon fa fa-setting"></i>
									Contact List
								</a>
								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='users' && $reqAction=='admin_contact') {echo 'active';}?>">
								<a href="<?php echo SITEURL.'admin/users/contact'; ?>">
									<i class="menu-icon fa fa-setting"></i>
									Dept Members
								</a>
								<b class="arrow"></b>
							</li>
						</ul>
					</li>
										
					<li class="<?php if (($reqController=='users') && ($reqAction=='admin_payment_setting' ||	$reqAction=='admin_profile'  ||  $reqAction=='admin_change_password') ) {echo 'active';}?>">
						<a href="#" class="dropdown-toggle">
							<i class="menu-icon fa fa-cog "></i>
							<span class="menu-text"> Settings </span>

							<b class="arrow fa fa-angle-down"></b>
						</a>

						<b class="arrow"></b>

						<ul class="submenu">
							
							<li class="<?php if ($reqController=='users' && $reqAction=='admin_profile') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/users/profile">
									<i class="menu-icon fa fa-setting"></i>
									Profile
								</a>

								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='users' && $reqAction=='admin_web_setting') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/users/web_setting">
									<i class="menu-icon fa fa-setting"></i>
									Website Settings
								</a>

								<b class="arrow"></b>
							</li>
							<li class="<?php if ($reqController=='users' && $reqAction=='admin_change_password') {echo 'active';}?>">
								<a href="<?php echo SITEURL;?>admin/users/change_password">
									<i class="menu-icon fa fa-setting"></i>
									Change Password
								</a>

								<b class="arrow"></b>
							</li>
							
						</ul>
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