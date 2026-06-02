<!-- #section:basics/content.breadcrumbs -->
<div class="breadcrumbs" id="breadcrumbs">
	<script type="text/javascript">
	try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
	</script>

	<ul class="breadcrumb">
		<li>
			<i class="ace-icon fa fa-home home-icon"></i>
			<a href="#">Home</a>
		</li>
			<li class="active">Dashboard</li>
	</ul><!-- /.breadcrumb -->

</div>
<style>
.small-box {
    border-radius: 2px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);
    display: block;
    margin-bottom: 20px;
    position: relative;
}
.small-box .icon {
    color: rgba(0, 0, 0, 0.15);
    font-size: 90px;
    position: absolute;
    right: 10px;
    top: -10px;
    transition: all 0.3s linear 0s;
    z-index: 0;
}
.small-box > .small-box-footer {
    background: rgba(0, 0, 0, 0.1) none repeat scroll 0 0;
    color: rgba(255, 255, 255, 0.8);
    display: block;
    padding: 3px 0;
    position: relative;
    text-align: center;
    text-decoration: none;
    z-index: 10;
}
.spec-overview-grid {
	display: flex;
	flex-wrap: wrap;
	margin: 0 -8px 14px;
}
.spec-overview-col {
	padding: 0 8px;
	margin-bottom: 12px;
	width: 100%;
}
@media (min-width: 992px) {
	.spec-overview-col {
		width: 33.333%;
	}
}
.spec-overview-card {
	border: 1px solid #e4ebf2;
	border-radius: 8px;
	padding: 14px 16px;
	background: #fff;
	box-shadow: 0 8px 20px rgba(33, 54, 79, 0.10);
	min-height: 132px;
	transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
}
.spec-overview-link {
	display: block;
	color: inherit;
	text-decoration: none !important;
}
.spec-overview-link:hover .spec-overview-card {
	transform: translateY(-2px);
	box-shadow: 0 12px 24px rgba(33, 54, 79, 0.16);
	border-color: #c8d9ea;
}
.spec-overview-title {
	font-size: 13px;
	font-weight: 700;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	color: #6f7f92;
	margin: 0 0 10px;
}
.spec-overview-total {
	font-size: 24px;
	font-weight: 700;
	color: #2f7fbf;
	line-height: 1.2;
}
.spec-overview-meta {
	margin-top: 8px;
	color: #5e6b77;
	font-size: 13px;
}
.spec-overview-meta .label {
	margin-right: 6px;
}
</style>
<div class="page-content">
<div class="page-header">
	<h1>
		Dashboard
	</h1>
</div><!-- /.page-header -->
<div class="row">
	<div class="col-xs-12">
	<?php $specStats = isset($specStats) && is_array($specStats) ? $specStats : []; ?>
	 <div class="row">
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-yellow" style="background-color: #F79263 !important;color:#fff;">
                <div class="inner" style="padding:10px;">
                  <h3>#<?php echo $totalcate; ?></h3>
                  <p>Category</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <a href="<?php echo rtrim(SITEURL, '/') . '/admin/categories'; ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
              
              <div class="small-box bg-red" style="background-color: #CC5D5E !important;color:#fff;">
                <div class="inner" style="padding:10px;">
                  <h3>#<?php echo $totalpro; ?></h3>
                  <p>Products</p>
                </div>
                <div class="icon">
                  <i class="fa fa-briefcase "></i>
                </div>
                <a href="<?php echo SITEURL.'admin/products' ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
			<div class="col-lg-3 col-xs-6">
              <!-- small box -->
              <div class="small-box bg-aqua" style="background-color: #AEC95B !important;color:#fff;">
                <div class="inner" style="padding:10px;">
                  <h3>#<?php echo $totalStaff; ?></h3>
                  <p>Total Staff Member</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <a href="<?php echo SITEURL.'admin/users/staff' ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div><!-- ./col -->
            <div class="col-lg-3 col-xs-6">
             
              <div class="small-box bg-green" style="background-color: #8BC1E4 !important;color:#fff;">
                <div class="inner" style="padding:10px;">
                  <h3>#<?php echo $totalCustomer; ?></h3>
                  <p>Total Customer</p>
                </div>
                <div class="icon">
                  <i class="fa fa-user"></i>
                </div>
                <a href="<?php echo SITEURL.'admin/users/customer' ?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          </div><!-- /.row -->
		  
		  <div class="page-header">
			<h1>Specs Overview</h1>
		  </div>
		  <div class="spec-overview-grid">
			<div class="spec-overview-col">
				<a class="spec-overview-link" href="<?php echo SITEURL.'admin/mailers'; ?>">
					<div class="spec-overview-card">
						<p class="spec-overview-title">DuroEzy Specs</p>
						<div class="spec-overview-total">#<?php echo (int)($specStats['duroezy_total'] ?? 0); ?></div>
						<div class="spec-overview-meta">
							<span class="label label-success">Submitted: <?php echo (int)($specStats['duroezy_submitted'] ?? 0); ?></span>
							<span class="label label-warning">Draft: <?php echo (int)($specStats['duroezy_draft'] ?? 0); ?></span>
						</div>
					</div>
				</a>
			</div>
			<div class="spec-overview-col">
				<a class="spec-overview-link" href="<?php echo SITEURL.'admin/mailers/emp_spec_index'; ?>">
					<div class="spec-overview-card">
						<p class="spec-overview-title">Employee Specs</p>
						<div class="spec-overview-total">#<?php echo (int)($specStats['employee_total'] ?? 0); ?></div>
						<div class="spec-overview-meta">
							<span class="label label-success">Submitted: <?php echo (int)($specStats['employee_submitted'] ?? 0); ?></span>
							<span class="label label-warning">Draft: <?php echo (int)($specStats['employee_draft'] ?? 0); ?></span>
						</div>
					</div>
				</a>
			</div>
			<div class="spec-overview-col">
				<a class="spec-overview-link" href="<?php echo SITEURL.'admin/ai-specs'; ?>">
					<div class="spec-overview-card">
						<p class="spec-overview-title">AiSpec Matrix</p>
						<div class="spec-overview-total">#<?php echo (int)($specStats['aispec_total'] ?? 0); ?></div>
						<div class="spec-overview-meta">
							Open waterproofing materials matrix
						</div>
					</div>
				</a>
			</div>
		  </div>
		  
		  <div class="page-header">
			<h1>EOI Mailer Stats</h1>
		</div>
		  <div class="row">
			<div class="col-xs-12">
				<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover" id="example" >
					<thead>
						<tr>
							<th>id</th>
							<th>Name</th>
							<th>Total Sent</th>
						</tr>	
					</thead>
					<tbody>
						<?php 
						$i=1;
						foreach ($UserPermission as $UserPermissions): ?>
						<tr>
						<td><?php echo $i; ?>&nbsp;</td>
						<td><?php
							$napp = $UserPermissions['NappUser'] ?? [];
							$name = $napp['name'] ?? $napp['first_name'] ?? '';
							$lname = $napp['lname'] ?? $napp['last_name'] ?? '';
							echo h(trim($name . ' ' . $lname)) ?: '—';
							?>&nbsp;</td>
          <td>
              <?php echo !empty($UserPermissions['NappUser']['EoiMailer']) 
                  ? count($UserPermissions['NappUser']['EoiMailer']) 
                  : 0; 
              ?>&nbsp;
          </td>
						<?php $i++; endforeach; ?>
						</tbody>
				</table>			
				</div>
			</div>
		</div>
</div>
</div>
<script>
$(document).ready(function() {
		$('#example').DataTable();
	} );
</script>