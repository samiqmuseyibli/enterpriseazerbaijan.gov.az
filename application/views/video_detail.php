<style type="text/css">
.video-thumbnail {
  position: relative;
  display: inline-block;
  cursor: pointer;

  &:before {
    position:absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    content: "\f01d";
    font-family: FontAwesome;
    font-size: 40px;
    color: #fff;
    opacity: .8;
    text-shadow: 0px 0px 30px rgba(0, 0, 0, 0.5);
  }
  &:hover:before {
    color: #eee;
  }
}
</style>
<div class="clearfix"></div>
<div class="page_title2 sty2">
	<div class="container">
		<h1 style="font-size: 20px;"><?=$row['v_title_'.$l.'']?></h1>
		<div class="pagenation">
			<a href="<?=base_url();?>"><?=translate('home_page');?></a> 
			<i>/</i> 
			<a href="<?=base_url();?>video"><?=translate('videos');?></a>
		</div>
	</div>
</div>
<div class="clearfix"></div>
<div class="content_fullwidth less2">
	<div class="container">
		<div class="content_left">       	
			<div class="blog_post">	
				<div class="blog_postcontent">
					<div class="image_frame">
						 <iframe src="<?=$row['v_video_url']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="width: 100%; height:500px;"></iframe>
					</div>
					<h4>
						<i class="fa fa-calendar"></i> 
						<em><?=date_for_view($row['v_createdAt'])?></em>
					</h4>
					<div class="clearfix"></div>
					<div class="share-post">
	                 <div class="sp-elements">
	                        <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?=current_url()?>">
	                           <div class="sp-element facebook"> <i class="sp-icons fa fa-facebook"></i> <span class="sp-text mobileHide">Facebook</span></div>
	                        </a>
	                        <a target="_blank" href="http://www.twitter.com/share?url=<?=current_url()?>">
	                           <div class="sp-element twitter"> <i class="sp-icons fa fa-twitter"> <span class="sp-text mobileHide">Twitter</span></i></div>
	                        </a>
	                        <a target="_blank" href="https://telegram.me/share/url?url=<?=current_url()?>&text=<?=$row['v_title_'.$l.'']?>">
	                           <div class="sp-element telegram"> <i class="sp-icons fa fa-telegram"> </i> <span class="sp-text mobileHide">Telegram</span></div>
	                        </a>
	                   </div>
                   </div>
				</div>
			 </div>  
		 </div>
		 <?php if (!empty($rows)): ?>
		 <div class="right_sidebar">
			<div class="sidebar_widget">  
				<div class="sidebar_title"><h4><?php echo translate('other_videos');?></h4></div> 
				<ul class="recent_posts_list">
					<?php foreach ($rows as $item) { ?>
							<li>
								<span>
									<a href="<?=base_url('video/detail/'.$item['v_id'])?>">
										<div class="video-thumbnail">
										   <img class="imgframe2" style="max-width:90px" src="<?=base_url($item['v_cover'])?>" alt="<?=$item['v_title_'.$l]?>" />
									    </div>
									</a>
								</span>
								<a href="<?=base_url('video/detail/'.$item['v_id'])?>"><?=qisalt($item['v_title_'.$l.''], 80) ?></a>
								<i><?=date_for_view($item['v_createdAt'])?></i> 
							</li>
							<?php } ?> 
				</ul>            
			</div>
		</div>
		<?php endif ?>
 </div>
</div>
