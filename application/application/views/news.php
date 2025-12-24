<?php 
	$l = curLang();
	include('header.php');

?>
	<div class="clearfix"></div>
	<div class="page_title2 sty2">
		<div class="container">
			<h1><?php echo translate('news');?></h1>
			<div class="pagenation">&nbsp;<a href="<?php echo base_url($l);?>"><?php echo translate('home_page');?></a> <i>/</i> <a href="<?php echo base_url($l);?>/news"><?php echo translate('news');?></a></div>   
		</div>
	</div>
	<div class="clearfix"></div>
	<div id="sektorbase">      
		<div class="feature_section2" id="investbase">
			<div class="container">
				<?php 
					if ($news) {    
						foreach ($news as $item) {?>  
							<a href="<?php echo base_url($l);?>/news/detail/<?php echo $item['id'].'-'.$item['top_'.$l.''];?>">
								<div class="col-md-4">
									<div class="box">
										<p style="font-size:15px; padding: 15px; color:#999; font-weight: bold;">
											<i class="fa fa-calendar"></i> 
											<?php echo date_for_view($item['date'])?>
										</p>
										<div class="imgframe4" style="min-height: 250px; max-height: 260px; margin-bottom: 15px;" >
											<img src="<?php echo base_url('assets/front/images/news/');?><?php echo $item['url_image'];?> " alt="<?=$item['title_'.$l.'']?>" style="max-width: 100%; max-height: 235px; " />
										</div>
										<h5 style="padding: 0px 6px;">
											<?php if ($item['title_'.$l.''] == ""): ?>
												<strong><?php echo qisalt($item['title_az'], 100); ?></strong><br />
											<?php else: ?>
												<strong><?php echo qisalt($item['title_'.$l.''], 100); ?></strong><br />
											<?php endif ?>
										</h5>
										<p> 
										<?php if ($item['content_'.$l.''] == ""): ?>
											<?php echo qisalt(strip_tags($item['content_az']), 200); ?>
										<?php else: ?>
											<?php echo qisalt(strip_tags($item['content_'.$l.'']), 200); ?>
										<?php endif ?>
											
										</p>
									</div>
								</div>
							</a>
							<?php } }else{ ?>
								<div class="successmes">
									<div class="message-box-wrap"><i class=""></i><?php echo translate('no_news_found');?></div>
								</div>
						<?php } ?>
			</div>
			<div class="clearfix margin_top4"></div>
			<div class="pagenation center">
				<?php echo $links;?>   
			</div>
			<div class="clearfix margin_top4"></div>
		</div>
	</div>
<?php include('footer.php');?>   
    