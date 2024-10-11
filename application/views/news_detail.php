<div class="clearfix"></div>
<div class="page_title2 sty2">
	<div class="container">
		<h1 style="font-size: 20px;"><?php echo $detail['title_'.$l.'']?></h1>
		<div class="pagenation">
			<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> 
			<i>/</i> 
			<a href="<?php echo base_url();?>news"><?php echo translate('news');?></a>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="content_fullwidth less2">
	<div class="container">
		<div class="content_left">       	
			<div class="blog_post">	
				<div class="blog_postcontent">
					<div class="image_frame"><a href="<?php echo base_url('assets/front/images/news/');?><?php echo $detail['url_image'];?>"><img style="object-fit: contain; max-height: 400px; border: 8px solid #fff; box-shadow: 0px 0px 4px 1px rgba(0,0,0,0.20);" src="<?php echo base_url('assets/front/images/news/');?><?php echo $detail['url_image'];?> " alt="" /></a></div>
					<h4><i class="fa fa-calendar"></i> <em><?php echo date_for_view($detail['date'])?></em></h4>
					<div class="clearfix"></div>
					<div class="share-post">
	                     <div class="sp-elements">
	                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=current_url()?>">
	                           <div class="sp-element facebook"> <i class="sp-icons fa fa-facebook"></i> <span class="sp-text mobileHide">Facebook</span></div>
	                        </a>
	                        <a target="_blank" href="http://www.twitter.com/share?url=<?=current_url()?>">
	                           <div class="sp-element twitter"> <i class="sp-icons fa fa-twitter"> <span class="sp-text mobileHide">Twitter</span></i></div>
	                        </a>
	                        <a target="_blank" href="https://telegram.me/share/url?url=<?=current_url()?>&text=<?=$news_title?>">
	                           <div class="sp-element telegram"> <i class="sp-icons fa fa-telegram"> </i> <span class="sp-text mobileHide">Telegram</span></div>
	                        </a>
	                     </div>
                   </div>
					<p><?php echo $detail['content_'.$l.'']?></p>
					<?php 
					// Xəbərə aid əlavə şəkillər varsa

					if($details){
						?>
						<div class="clearfix divider_line21"></div>
						<?php
						foreach ($details as $item) {
							?>
							<div class="image_frame">
								<a target="_blank" href="<?php echo base_url('assets/front/images/news/').$item['file_url']; ?>">
									<img class="imgframe2" src="<?php echo base_url('assets/front/images/news/').$item['file_url']; ?>" alt="" />
								</a>
							</div>
							<?php
						}
						
					}
					?>
				</div>
			</div>  
		</div>
		<div class="right_sidebar">
			<div class="sidebar_widget">  
				<div class="sidebar_title"><h4><?php echo translate('recent_posts');?></h4></div> 
				<ul class="recent_posts_list">
					<?php foreach ($related as $item) {
						if($item['id']!=$detail['id']){
							?>
							<li>
								<span><a href="<?php echo base_url();?>news/detail/<?php echo $item['id'].'-'.$item['top_'.$l.''];?>"><img class="imgframe2" style="max-width:80px" src="<?php echo base_url('assets/front/images/news/');?><?php echo $item['url_image'];?> " alt="" /></a></span>
								<a href="<?php echo base_url();?>news/detail/<?php echo $item['id'].'-'.$item['top_'.$l.''];?>"><?php echo qisalt($item['title_'.$l.''],80) ?></a>
								<i><?php echo date_for_view($item['date'])?></i> 
							</li>
							<?php 
						} 
					}?> 
				</ul>            
			</div><!-- end section -->	
		</div><!-- end right sidebar -->
</div>
</div><!-- end content area -->
<div class="clearfix"></div>
