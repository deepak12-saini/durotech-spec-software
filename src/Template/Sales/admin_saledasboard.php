	<div class="page-content">
		<div class="page-header">
			<h1>
			Sales Team Dashboard 
			
			<?php echo $this->Form->create(null, ['url' => ['controller' => 'Sales', 'action' => 'admin_saledasboard'], 'style' => 'float:right;']); ?>
				<input type="text" name="startdate" value="<?php echo h($startdate ?? ''); ?>" class="datepicker" placeholder="Start Date" >
				<input type="text" name="enddate" value="<?php echo h($enddate ?? ''); ?>" class="datepicker1" placeholder="End Date" >
				<input type="submit" name="search" value="search" class="btn btn-info btn-xs" >	
			<?php echo $this->Form->end(); ?>
			<a href="<?php echo $this->Url->build(['controller' => 'Sales', 'action' => 'admin_saledasboard']); ?>" class="btn btn-warning btn-xs" style="float:right; margin-right:10px;">Show All</a>		
			
			</h1>
			
		</div>
		

	 <div class="row">
	 
	 
	 <div class="col-lg-3 col-xs-6">
	  <!-- small box -->
	  <div class="small-box bg-yellow" style="background-color: #ebccd1 !important;color:#fff;">
		<div class="inner" style="padding:10px;">
		  <h3>#<?php  if(!empty($LogsArr)){ echo count($LogsArr); }else{  echo '0'; }  ?></h3>
		  <p>Dailer Called</p>
		</div>
			
	  </div>
	</div><!-- ./col -->
	<?php
	$userLog = array(); 
	foreach($LogsArr as $LogsArrs){
		$log = is_object($LogsArrs) ? $LogsArrs : (object)($LogsArrs['Log'] ?? $LogsArrs);
		$userId = $log->user_id ?? $LogsArrs['Log']['user_id'] ?? null;
		$logId = $log->id ?? $LogsArrs['Log']['id'] ?? null;
		if ($userId !== null && $logId !== null) {
			$userLog[$userId][] = $logId;
		}
	}
	
	$totalsale = array();
	$saleperson = array();
	foreach ($SaleRepArr as $SaleRepArrs){
		$sr = is_object($SaleRepArrs) ? $SaleRepArrs : (object)($SaleRepArrs['SaleRep'] ?? $SaleRepArrs);
		$sq = null;
		$nu = null;
		if (is_object($SaleRepArrs)) {
			$sq = $SaleRepArrs->sale_question ?? null;
			$nu = $SaleRepArrs->napp_user ?? null;
		} else {
			$sq = isset($SaleRepArrs['SaleQuestion']) ? (is_object($SaleRepArrs['SaleQuestion']) ? $SaleRepArrs['SaleQuestion'] : (object)$SaleRepArrs['SaleQuestion']) : null;
			$nu = isset($SaleRepArrs['NappUser']) ? (is_object($SaleRepArrs['NappUser']) ? $SaleRepArrs['NappUser'] : (object)$SaleRepArrs['NappUser']) : null;
		}
		
		$sqId = $sq ? ($sq->id ?? null) : null;
		if($sqId !== null && !empty($sqId)){
			$srName = $sr->name ?? '';
			if ($srName !== '') {
				$totalsale[$sqId][] = $srName;
			}
			$id = $nu ? ($nu->id ?? null) : null;
			if ($id !== null) {
				$srId = $sr->id ?? null;
				if ($srId !== null) {
					$saleperson[$id][$sqId][] = $srId;
				}
			}
		}		
	}	
	
	$final = array();
	$finalprospectmet = array();
	$finalprospectcall = array();
	foreach($napuser as $napusers){
		$nu = is_object($napusers) ? $napusers : (object)($napusers['NappUser'] ?? $napusers);
		$name = trim(($nu->name ?? '') . ' ' . ($nu->lname ?? ''));
		$serier['name'] = $name;
		$sermet['name'] = $name;
		$sercall['name'] = $name;
		$nuId = $nu->id ?? null;
		if($nuId !== null && isset($saleperson[$nuId]) && !empty($saleperson[$nuId])){
			ksort($saleperson[$nuId]);
			$seriersval = array();
			
			$j=0;
			for($i=1; $i<=3; $i++){
				if(isset($saleperson[$nuId][$i])){
					$seriersval[]  = count($saleperson[$nuId][$i]);	
				}else{
					$seriersval[] = 0;
				}
			}
	
			
			if(isset($userLog[$nuId])){
				$seriersval[] = count($userLog[$nuId]);
			} else {
				$seriersval[] = 0;
			}
			
			$prospectmet = 0;
			$prospectcall = 0;
			if(isset($saleperson[$nuId][1]) && isset($totalsale[1]) && count($totalsale[1]) > 0){
				$prospectmet = count($saleperson[$nuId][1]) / count($totalsale[1]) * 100;
			}
			if(isset($saleperson[$nuId][2]) && isset($totalsale[2]) && count($totalsale[2]) > 0){
				$prospectcall = count($saleperson[$nuId][2]) / count($totalsale[2]) * 100;
			}				
			
			$serier['data'] = 	$seriersval;			
			$sermet['y']= round($prospectmet);
			$sercall['y']= round($prospectcall);
						
		}else{
			$dilercall = 0;
			if($nuId !== null && isset($userLog[$nuId])){
				$dilercall = count($userLog[$nuId]);
			}
			$sermet['y'] = 0;
			$sercall['y'] = 0;
			$serier['data'] = array(0,0,0,$dilercall);
		}	
		$finalprospectmet[] = $sermet;
		$finalprospectcall[] = $sercall;
		$final[] = $serier;
	}

	$color = array('#F79263','#CC5D5E','#AEC95B','#09729f','#ebccd1','green');
	$i=0; 
	//$cate = 'Dailer Called , ';
	$cate = '';
	foreach($slatestype as $slatestypes){
		$sq = is_object($slatestypes) ? $slatestypes : (object)($slatestypes['SaleQuestion'] ?? $slatestypes);
		$sqId = $sq->id ?? null;
		$sqTitle = $sq->title ?? '';
		if ($sqTitle !== '') {
			$cate .= "'".$sqTitle."' , ";
		}
	?>	
		<div class="col-lg-3 col-xs-6">
		  <!-- small box -->
		  <div class="small-box bg-yellow" style="background-color: <?php echo $color[$i]; ?> !important;color:#fff;">
			<div class="inner" style="padding:10px;">
			  <h3>#<?php if($sqId !== null && !empty($totalsale[$sqId])){ echo count($totalsale[$sqId]); }else{ echo '0'; } ?></h3>
			  <p><?php echo h($sqTitle); ?></p>
			</div>
				
		  </div>
		</div><!-- ./col -->
	<?php 
	$i++; } 	
	$cate  =rtrim($cate,',');
	$cate = $cate."'Dailer Caller'";
	
	
	?>	
	
	</div><!-- /.row -->
	
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script src="https://code.highcharts.com/modules/export-data.js"></script>
	<br><br><br>

	<div class="row">
		<div class="col-lg-12">
			<div id="container" style="min-width: 310px; max-width: 100%; height: 400px; margin: 0 auto"></div>
		</div>
	</div><!-- /.row -->
	
	<div class="row">
		<div class="col-lg-6">
			<div id="piechart" style="min-width: 40px; height: 400px; max-width: 100%; margin: 0 auto"></div>
		</div>
		<div class="col-lg-6">
			<div id="piechart_called" style="min-width: 40px; height: 400px; max-width: 100%; margin: 0 auto"></div>
		</div>
	</div><!-- /.row -->
	<div class="row">	
		<div id="weekly" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
	</div><!-- /.row -->
</div>		
<script>

Highcharts.chart('weekly', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Daily sale report'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: <?php echo json_encode($finaldate); ?>,
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Sale Report'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: <?php echo json_encode($finaldata); ?>
});
Highcharts.chart('piechart', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Top Prospects Met (<?php echo !empty($startdate) ? date('d,M',strtotime($startdate)) : ''; ?> To <?php echo !empty($enddate) ? date('d,M',strtotime($enddate)) : ''; ?>)'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'red'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: <?php echo json_encode($finalprospectmet); ?>
    }]
});


Highcharts.chart('piechart_called', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Top Prospects Called (<?php echo !empty($startdate) ? date('d,M',strtotime($startdate)) : ''; ?> To <?php echo !empty($enddate) ? date('d,M',strtotime($enddate)) : ''; ?>)'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                style: {
                    color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'red'
                }
            }
        }
    },
    series: [{
        name: 'Brands',
        colorByPoint: true,
        data: <?php echo json_encode($finalprospectcall); ?>
    }]
});
Highcharts.chart('container', {
  chart: {
    type: 'bar'
  },
  title: {
    text: 'Sale Report'
  },
  xAxis: {
    categories: [<?php echo $cate; ?>]
  },
    yAxis: {
        min: 0,
        title: {
          text: 'Report:  <?php echo !empty($startdate) ? date('d, M Y',strtotime($startdate)) : ''; ?> To <?php echo !empty($enddate) ? date('d, M Y',strtotime($enddate)) : ''; ?>'
        }
    },
  legend: {
    reversed: true
  },
  plotOptions: {
    series: {
      stacking: 'normal'
    }
  },
  series: <?php echo json_encode($final);?>
});

jQuery(function(){ 
	$('.datepicker').datepicker({
		format: 'yyyy-mm-dd',			
	});$('.datepicker1').datepicker({
		format: 'yyyy-mm-dd',			
	});
});


</script>