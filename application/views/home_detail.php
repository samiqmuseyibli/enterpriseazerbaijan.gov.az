<?php $image=getProjectImage($detail['project_id']);?>
<div class="clearfix"></div>
<div class="page_title2 sty2">
   <div class="container">
      <h1 style="font-size:25px;"><?php echo $detail['project_title']?></h1>
      <div class="pagenation">&nbsp;<a href="<?php echo base_url()?>"><?php echo translate('home_page');?></a> <i>/ </i> <a href="<?php echo base_url()?>project/category/<?php echo $detail['kat_id'];?>"><?php echo $detail['kat_adi_'.$l.''];?></a></div>
   </div>
</div>
<div class="clearfix"></div>
<div class="content_fullwidth less2">
   <div class="container">
      <div class="content_left">
         <div class="blog_post">
            <div class="blog_postcontent">
               <div class="image_frame">
                  <a href="<?=$image;?>" target="_blank">
                  <img  style="object-fit: contain; max-height: 400px; border: 8px solid #fff; box-shadow: 0px 0px 4px 1px rgba(0,0,0,0.20);" src="<?=$image;?>" alt="<?=$detail['project_title'];?>" />
                  </a>
               </div>
               <h4><i class="fa fa-calendar"></i> <em><?php echo date_for_view($detail['add_date']); ?></em></h4>
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
               <ul>
                  <li class="post_by"><i class="fa fa-map-marker"></i> <strong><?php echo translate('Location_Project');?>:</strong> <a href="<?php echo base_url('/geomap/');?>"><?php echo $detail['reg_adi_'.$l.'']?></a></li>
                  <?php
                     if ($detail['kat_id']==5) {
                     	echo null;
                     }else{
                     	echo '<li class="post_categoty"><i class="fa fa-bookmark "></i> <strong>'.translate('Sector_Project').':</strong> '.$detail['sek_adi_'.$l.''].'</li>';
                     }
                     ?>
                  <li class="post_categoty"><i class="fa fa-tasks"></i> <strong><?php echo translate('Category_Project');?>: </strong><a href="#"><?php echo $detail['kat_adi_'.$l.'']?></a></li>
               </ul>
               <p><?php echo $detail['project_description']?></p>
            </div>
         </div>
         <?php
            if ($detail['kat_id']==1) {
            	// 1-startap 
            	?>
         <div class="clearfix divider_line21"></div>
         <div class="one_half">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('investment_volume');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['invesment_volume']).' '.translate('AZN');?></li>
               </ul>
            </div>
         </div>
         <div class="one_half last">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('investor_percent');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php if($detail['investor_percent']!=0){echo $detail['investor_percent'].' (%)';}else{ echo translate('razilashamyoluile');}?></li>
               </ul>
            </div>
         </div>
         <!-- end popular posts -->
         <div class="clearfix"></div>
         <h4 class="light"><br/><?=translate('other_important_data_project');?></h4>
         <div class="about_author">
         	 <?php if($detail['other_important_data'] != ''){?>
             <p><?=$detail['other_important_data'];?></p>
             <?php }else{ ?>
              <p><?=translate('Not_Mentioned');?></p>
             <?php } ?>
         </div> 
         <?php
            }else if ($detail['kat_id']==2) {
            	// 2-Torpaq sahələri  
            	?>
         <div class="clearfix divider_line21"></div>
         <div class="one_half">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('property_form');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo $detail['property_name_'.$l.''];?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('usage_form');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo $detail['usage_form_name_'.$l.''];?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('Price');?> </h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['price']).' '.translate('AZN');?></li>
               </ul>
            </div>
         </div>
         <div class="one_half last">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('appointment');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo $detail['appointment_name_'.$l.''];?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('umumi_sahe');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo $detail['common_area'].' '.translate('ha');?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('infrastructure');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list" >
                  <li><?php echo $detail['infrastructure'];?></li>
               </ul>
            </div>
         </div>
         <?php if($detail['other_important_data']!=''){?>
         <div class="clearfix"></div>
         <h5 class="light"><br/><?php echo translate('other_important_data_project');?></h5>
         <div class="about_author">
            <p><?php echo $detail['other_important_data'];?></p>
         </div>
         <?php }?>
         <?php
            }else if ($detail['kat_id']==3) {
            	// 3-Özəlləşdirmə  
            	?>
         <div class="clearfix divider_line21"></div>
         <div class="one_half">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('charter_capital');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['charter_capital']).' '.translate('AZN'); ?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('number_of_issued_stocks');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['number_of_issued_stocks']).' '.translate('eded');?></li>
               </ul>
            </div>
         </div>
         <div class="one_half last">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('nominal_value_of_one_stocks');?> </h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['nominal_value_of_one_stocks']).' '.translate('AZN');?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('volume_of_traded_stocks');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['volume_of_traded_stocks']).' '.translate('eded') ;?> </li>
               </ul>
            </div>
         </div>
         <!-- end popular posts -->
         <?php if($detail['other_important_data']!=''){?>
         <div class="clearfix"></div>
         <h5 class="light"><br/><?php echo translate('other_important_data_project');?></h5>
         <div class="about_author">
            <p><?php echo $detail['other_important_data'];?></p>
         </div>
         <?php }?>
         <?php
            }else if ($detail['kat_id']==4) {
            	// 4-Hazır biznes satışı  
            	?>
         <div class="clearfix divider_line21"></div>
         <div class="one_half">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('property_form');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo $detail['property_name_'.$l.''];?></li>
               </ul>
            </div>
         </div>
         <div class="one_half last">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('Price');?> </h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['price']).' '.translate('AZN') ;?></li>
               </ul>
            </div>
         </div>
         <?php if($detail['other_important_data']!=''){?>
         <div class="clearfix"></div>
         <h5 class="light"><br/><?php echo translate('other_important_data_project');?></h5>
         <div class="about_author">
            <p><?php echo $detail['other_important_data'];?></p>
         </div>
         <?php }?>
         <?php
            }else if ($detail['kat_id']==5) {
            	// 5-ideyalar  
            	?>
         <div class="clearfix divider_line21"></div>
         <div class="one_half">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('investment_volume');?> </h5>
               <div class="clearfix marb2"></div>
               <ul>
                  <li><?php echo number_for_view($detail['invesment_volume']).' '.translate('AZN');?></li>
               </ul>
            </div>
         </div>
         <div class="one_half last">
            <div class="popular-posts-area">
               <h5 class="light">&nbsp;</h5>
               <div class="clearfix marb2"></div>
               <ul >
                  <li> &nbsp;</li>
               </ul>
            </div>
         </div>
         <?php
            }else if ($detail['kat_id']==6) {
            	// 6-sehm-satisi  
            	
            	?>
         <div class="clearfix divider_line21"></div>
         <div class="one_half">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('charter_capital');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['charter_capital']).' '.translate('AZN'); ?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('number_of_issued_stocks');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['number_of_issued_stocks']).' '.translate('eded');?></li>
               </ul>
            </div>
         </div>
         <div class="one_half last">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('nominal_value_of_one_stocks');?> </h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['nominal_value_of_one_stocks']).' '.translate('AZN');?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('volume_of_traded_stocks');?></h5>
               <div class="clearfix marb2"></div>
               <ul >
                  <li><?php echo number_for_view($detail['volume_of_traded_stocks']).' '.translate('eded') ;?> </li>
               </ul>
            </div>
         </div>
         <?php if($detail['other_important_data']!=''){?>
         <div class="clearfix"></div>
         <h5 class="light"><br/><?php echo translate('other_important_data_project');?></h5>
         <div class="about_author">
            <p><?php echo $detail['other_important_data'];?></p>
         </div>
         <?php }?>
         <?php
            }else if ($detail['kat_id']==7) {
            	// 7-emlak-satisi  
            	?>
         <div class="clearfix divider_line21"></div>
         <div class="one_half">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('property_form');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo $detail['property_name_'.$l.''];?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('usage_form');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo $detail['usage_form_name_'.$l.''];?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('Price');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['price']).' '.translate('AZN') ;?></li>
               </ul>
            </div>
         </div>
         <div class="one_half last">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('infrastructure');?> </h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo $detail['infrastructure']; ?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('umumi_sahe');?> </h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo $detail['common_area'].' '.translate('ha');?></li>
               </ul>
               <h5 class="light">&nbsp;</h5>
               <div class="clearfix marb2"></div>
               <ul >
                  <li> &nbsp;</li>
               </ul>
            </div>
         </div>
         <?php if($detail['other_important_data']!=''){?>
         <div class="clearfix"></div>
         <h5 class="light"><br/><?php echo translate('other_important_data_project');?></h5>
         <div class="about_author">
            <p><?php echo $detail['other_important_data'];?></p>
         </div>
         <?php }
         }else if ($detail['kat_id']==9) {  ?>
         <div class="clearfix divider_line21"></div>
         <div class="one_half">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('investment_volume');?> </h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php echo number_for_view($detail['invesment_volume']).' '.translate('AZN');?></li>
               </ul>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('main_advantages_project');?> </h5>
               <div class="clearfix marb2"></div>
               <ul>
                  <li><?php echo $detail['main_advantages'];?></li>
               </ul>
            </div>
         </div>
         <div class="one_half last">
            <div class="popular-posts-area">
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('investor_percent');?></h5>
               <div class="clearfix marb2"></div>
               <ul class="recent_posts_list">
                  <li><?php if($detail['investor_percent']!=0){echo $detail['investor_percent'].' (%)';}else{ echo translate('razilashamyoluile');}?></li>
               </ul>
               <?php if($detail['other_important_data']!=''){?>
               <h5 class="light"><i class="fa fa-check"></i> <?php echo translate('other_important_data_project');?></h5>
               <div class="clearfix marb2"></div>
               <ul>
               	  <?php if(empty($detail['other_important_data'])): ?>
               	  	  <li><?=translate('Not_Mentioned');?></li>
               	  <?php else: ?>
               	  	 <li><?=$detail['other_important_data'];?></li>
               	  <?php endif ?>
               </ul>
               <?php }?>
            </div>
         </div>
          <div class="clearfix"></div>
         <!-- end popular posts -->
         <?php
            }
            ?>
         <?php $images=getProjectImages($detail['project_id']); if($images!=null && count($images)>1){?>
            <div class="clearfix divider_line21"></div>
            <h4 class="light"><?php echo translate('Other images');?></h4>
            <br>
            <?php foreach ($images as $image){ ?>
               <img  style="object-fit: contain; max-height: 400px; border: 8px solid #fff; box-shadow: 0px 0px 4px 1px rgba(0,0,0,0.20); margin: 5px;" src="<?=base_url($image['files_url']);?>" alt="<?=$detail['project_title'];?>" />
            <?php }?>
         <?php }?>
         <?php  if($detail['youtube_video_link']!=''){?>
         <div class="clearfix divider_line21"></div>
         <h4 class="light"><?php echo translate('Video link');?></h4>
         <div class="w3-content w3-display-container"> 
            <iframe  style="top: 0;left: 0;width: 100%; min-height: 500px;" src="<?=$detail['youtube_video_link']?>"></iframe>
         </div>
         <?php }?>
         <?php
            if($detail['kat_id']!=5 && $detail['kat_id']!=1) {
            	?>
         <div class="clearfix divider_line21"></div>
         <h4 class="light"><?php echo translate('Location_Project');?></h4>
         <br>
         <div class="row">
            <?php
               if ($detail['lat'] and $detail['lng']) {
               	$this->session->set_userdata('lat',$detail['lat']);
               	$this->session->set_userdata('lng',$detail['lng']);
               	echo'
               		<div class="col-md-12">
               			<div id="map" style="width:100%; height:400px;"></div>
               		</div>
               	';
               }else{
               	echo '<div class="col-md-12">
               			<p style="color;red;">'.translate('Not_Mentioned').'</p>
               		  </div>';
               }
                 ?>
         </div>
         <?php 
            } 
            ?>
          <div class="clearfix divider_line21"></div>
         <h4 class="light"><?php echo translate('about_author_project');?></h4>
         <div class="about_author">
            <a href=""><?php echo translate('author');?>: </a><?php echo translate('IITKM');?><br />
            <a href=""><?php echo translate('Telephone');?>: </a><?php echo $settings['tel1'];?><br />
            <a href=""><?php echo translate('Email');?>: </a><?php echo $settings['mail'];?><br />
            <a href=""><?php echo translate('Address');?>: </a><?php echo $settings['adress_'.$l.'']?><br />
         </div>
      </div>
      <div class="right_sidebar">
         <div class="sidebar_widget">
            <div class="sidebar_title">
               <h4><?php echo translate('Categories');?></h4>
            </div>
            <ul class="arrows_list1">	
               <?php
                  foreach ($category as $kat) {
                  	if ($detail['kat_id']==$kat['kat_id']) {
                  		$class='class="active"';
                  	}else{
                  		$class='class=""';
                  	}
                  	echo '<li><a href="'.base_url('project/category/').''.$kat['kat_id'].'-'.$kat['kat_link'].'"><i class="fa fa-angle-right"></i>'.$kat['kat_adi_'.$l.''].'</a></li>';
                  }
                  ?>
            </ul>
         </div>
         <div class="clearfix margin_top4"></div>
         <div class="sidebar_widget">
            <div class="sidebar_title">
               <h4><?php echo translate('Related_Projects');?></h4>
            </div>
            <ul class="recent_posts_list">
               <?php 
                  foreach ($related_projects as $related ) {
                  
                  	if ($related['project_id']!=$detail['project_id']) {
                  		$rimage=getProjectImage($related['project_id']);
                  	   echo'
                  			<li>
                  				<span><a href="'.base_url('project/detail/').''.$related['project_id'].'-'.$related['top'].'"><img class="imgframe2" src="'.$rimage.'" alt="'.$related['project_title'].'" style="width:90px ; height:70px;" /></a></span>
                  				<a href="'.base_url('project/detail/').''.$related['project_id'].'-'.$related['top'].'">'.qisalt($related['project_title'],55).'</a>
                  				<i>'.date_for_view($related['add_date']).'</i>
                  			</li>
                  		';
                  	}
                  }
                  ?>
            </ul>
         </div>
         <div class="clearfix margin_top4"></div>
         <div class="sidebar_widget">
            <div class="sidebar_title">
               <h4><?php echo translate('Most_Visited_Projects');?></h4>
            </div>
            <ul class="recent_posts_list">
               <?php
                  foreach($most_viewed as $viewed) {
                  	$mimage=getProjectImage($viewed['project_id']);
                  	echo'
                  		<li>
                  			<span><a href="'.base_url('project/detail/').''.$viewed['project_id'].'-'.$viewed['top'].'"><img class="imgframe2" src="'.$mimage.'" alt="'.$viewed['project_title'].'"  style="width:90px ; height:70px;" /></a></span>
                  			<a href="'.base_url('project/detail/').''.$viewed['project_id'].'-'.$viewed['top'].'">'.qisalt($viewed['project_title'], 55).'</a>
                  			<i>'.date_for_view($viewed['add_date']).'</i>
                  		</li>
                  	';
                  }
                  ?>
            </ul>
         </div>
      </div>
   </div>
</div>
<div class="clearfix"></div>
<script>
   var slideIndex = 1;
   showDivs(slideIndex);
   
   function plusDivs(n) {
     showDivs(slideIndex += n);
   }
   
   function currentDiv(n) {
     showDivs(slideIndex = n);
   }
   
   function showDivs(n) {
     var i;
     var x = document.getElementsByClassName("mySlides");
     var dots = document.getElementsByClassName("demo");
     if (n > x.length) {slideIndex = 1}
     if (n < 1) {slideIndex = x.length}
     for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
     }
     for (i = 0; i < dots.length; i++) {
       dots[i].className = dots[i].className.replace(" w3-white", "");
     }
     x[slideIndex-1].style.display = "block";  
     dots[slideIndex-1].className += " w3-white";
   }
</script>