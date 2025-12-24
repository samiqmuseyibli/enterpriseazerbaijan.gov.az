<?php $l=curLang();?>
<div class="clearfix"></div>
<div class="page_title2 sty2">
	<div class="container">
		<h1><?php echo translate('layiheler_fondu');?></h1>
		<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/</i><?php echo translate('layiheler_fondu');?></div>                   
	</div>
</div>
<div class="clearfix"></div>
<?php include('filter.php');?>
<!-- end feature_section 2 -->
<div id="sektorbase">      
	<div class="feature_section2" id="investbase">
		<div class="container">          
			<!--<h2 class="caps "><?php echo translate('Projects');?></h2>-->
			<div class="row" >
				<?php
				if ($allprojects){    
				 	foreach($allprojects as $item) {
						$total_price=($item['total_price']*100)/$item['price'];
				 		?>
						<a href="<?php echo base_url('cfprojects/detail/').$item['project_id'].'-'.$item['link'];?>">
							<div class="col-md-4">
								<div class="box">
									<p style="font-size:13px"><i class="fa fa-briefcase fati18"></i><?php echo $item['category_name'];?></p>
									<img class="imgframe2" src="<?php echo base_url('cf_images/').$item['image'];?>" alt="<?php echo $item['title'];?>" style="max-width: 369px; max-height: 241px; margin-bottom: 8px;"/>
									<h5 ><strong style="margin-left: 4px ; margin-right: 4px;"><?php echo $item['title'];?></strong><br /></h5>
                                    <blockquote><?php echo word_limiter($item['about'],25);?></blockquote>
                                    <br />
									</p>
									<div style="width: 95%; " id="progress_bar5" class="container ui-progress-bar ui-container">
									<div class="ui-progress five" style="width: <?php echo number_format($total_price);?>%;"><span class="ui-label" style="display: block;"><b class="value"></b></span></div>
									</div>
								   <div class="col-md-6 col-xs-6"><ul><li><p style="float: left; line-height: 3px; font-size: 18px; color: #cf000f;"><?php echo number_format($total_price);?>%</p></li><li><p style="color: #afafaf;"><?php echo translate('yiqilmish_mebleg');?></p></li></ul></div>
								   <div class="col-md-6 col-xs-6"><ul style="float: right;"><li><p style="float: right; line-height: 3px; font-size: 18px; color: #cf000f;"><?php echo $item['price'];?> <?php echo translate('AZN');?>  </p></li><li><p class="text-muted" style="color: #afafaf;"><?php echo translate('umumi_mebleg');?></p></li></ul></div>
								  <br>     
								</div>
							</div>
						</a>
						<?php 
					}
				}else{
					echo'
						<div class="successmes">
							<div class="message-box-wrap">
								<i class=""></i>'.translate('no_project_filter').'</div>
							</div>
					';
				}
				?>
			</div>    
		</div>
		<div class="clearfix divider_line13 margin_top4 lessm"></div>
		<div class="pagenation center">
			<?php echo $links;?>   
		</div>
	</div>
</div>  




