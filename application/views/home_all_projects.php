 <?php $l=curLang(); include('header.php');?>
<div class="clearfix"></div>
<div class="page_title2 sty2">
	<div class="container">
		<h1><?php echo translate('Investment_Projects_Bank');?></h1>
		<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/ </i><?php echo translate('Investment_Projects_Bank');?></div>                   
	</div>
</div>
<div class="clearfix"></div>
<?php include('filter.php');?>
<div id="sektorbase">      
	<div class="feature_section2" id="investbase">
		<div class="container">          
			<div class="row" >
				<?php
				if ($allprojects){    
				 	foreach($allprojects as $item) {
				 		$image=getProjectImage($item['project_id']);
						echo'
						<a href="'.base_url('project/detail/').''.$item['project_id'].'-'.$item['top'].'">
							<div class="col-md-4">
								<div class="box">
									<p style="font-size:13px"><i class="fa fa-briefcase fati18"></i>'.$item['kat_adi_'.$l.''].'</p>
									<img  class="imgframe1" src="'.$image.'" alt="'.$item['project_title'].'" style="object-fit: contain;max-width: 100%; height: 240px; margin-bottom: 8px;" />
									<h5 style="padding: 0px 4px;">
										<strong>'.qisalt($item['project_title'],100).'</strong><br />
									</h5>
									<center><b><i class="fa fa-calendar"></i> '.date_for_view($item['add_date']).'</b></center>
									<p>
										<span style="float:left" title="'.translate('Location_Project').'"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;<b>'.$item['reg_adi_'.$l.''].'</b></span>';
										if ($item['invesment_volume']) {
											echo '<span style="float:right" title="'.translate('investment_volume_project').'"><i class="fa fa-money"></i>&nbsp;&nbsp;<b>'.number_for_view($item['invesment_volume']).'</b> '.translate('AZN').'</span><br />';
										}

										if ($item['price']) {
											echo '<span style="float:right" title="'.translate('price_project').'"><i class="fa fa-money"></i>&nbsp;&nbsp;<b>'.number_for_view($item['price']).'</b> '.translate('AZN').'</span><br>';
										}
										
										if ($item['nominal_value_of_one_stocks']) {
											echo '<span style="float:right" title="'.translate('nominal_value_of_one_stocks').'"><i class="fa fa-money"></i>&nbsp;&nbsp;<b>'.number_for_view($item['nominal_value_of_one_stocks']).'</b> '.translate('AZN').'</span><br>';
										}
										
										if ($item['number_of_issued_stocks']) {
											echo '<span style="float:left" title="'.translate('number_of_issued_stocks').'"><i class="fa fa-users"></i>&nbsp;&nbsp;<b>3'.$item['number_of_issued_stocks'].'</b> '.translate('eded').'</span>';
										}
										
										if ($item['volume_of_traded_stocks']) {
											echo '<span style="float:right" title="'.translate('volume_of_traded_stocks').'"><i class="fa fa-users"></i>&nbsp;&nbsp;<b>'.number_for_view($item['volume_of_traded_stocks']).'</b> '.translate('eded').'</span>';
										}

										if ($item['investor_percent']) {
											echo ' <span style="float:left" title="'.translate('investor_percent_project').'"><i class="fa fa-pie-chart"></i>&nbsp;&nbsp;'.translate('investor_percent_project').' - <b>'.$item['investor_percent'].'%</b></span>';
										}
										if ($item['common_area']) {
											echo ' <span style="float:left" title="'.translate('common_area_project').'"><i class="fa fa-pie-chart"></i>&nbsp;&nbsp;<b>'.$item['common_area'].' '.translate('ha').'</b></span>';
										}
										echo'<br />
									</p>
									<blockquote>'.qisalt($item['project_description'],200).'</blockquote>
								</div>
							</div>
						</a>
						';

					}
					
				}else{
					echo'
						<div class="successmes">
							<div class="message-box-wrap"><i class=""></i>'.translate('no_project_filter').'</div>
						</div>
					';
				}?>
			</div>    
		</div>
		<div class="clearfix margin_top4"></div>
			<div class="pagenation center">
				<?php echo $links;?>   
			</div>
		<div class="clearfix margin_top4"></div>
	</div>
</div>  

<?php include('footer.php');?> 


