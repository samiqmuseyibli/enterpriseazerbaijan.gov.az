 
<div class="clearfix"></div>
<?php    $total_price=($detail['total_price']*100)/$detail['price'];?>
<div class="page_title2 sty2">
<div class="container">

    <h1><?php echo translate('Project_Detail');?></h1>
    <div class="pagenation">&nbsp;<a href="<?php echo base_url()?>"><?php echo translate('home_page');?></a> <i>/</i> <a href="<?php echo base_url()?>cfprojects/category/<?php echo $detail['category_id'];?>"><?php echo $detail['category_name'];?></a> <i>/</i> <?php echo $detail['title'];?></div>

</div>
</div><!-- end page title -->

<div class="clearfix"></div>


<div class="content_fullwidth less2">
<div class="container">

<div class="content_left">

        <div class="blog_post">
            <div class="blog_postcontent">
            <div class="image_frame"><a target="_blank" href="<?php echo base_url('cf_images/').$detail['image'];?>"><img src="<?php echo base_url('cf_images/').$detail['image'];?>" alt="<?php echo $detail['title'];?>"  style="max-width: 800px; border: 8px solid #fff; box-shadow: 0px 0px 4px 1px rgba(0,0,0,0.20);" /></a></div>
            <h3><a ><?php echo $detail['title'];?></a></h3>

           <!--  <ul class="post_meta_links">

                <li class="post_categoty"><i><?php echo translate('Category');?>:</i> <a href="<?php echo base_url()?>cfprojects/category/<?php echo $detail['category_id'].'-'.$detail['category_link'];?>"><?php echo $detail['category_name'];?></a></li>
                <li class="post_comments"><i><?php echo translate('Comments');?>:</i> <a>18 </a></li>
            </ul> -->
              <div class="clearfix"></div>
            <div class="col-md-12">
            <div class="crowd-frame">
              <div class="row">
                         <div class="col-md-7">
                           <div class="prog">
                             <div style="width: 95%; margin-top: auto; " id="progress_bar5" class="container ui-progress-bar ui-container">
 <div class="ui-progress five" style="width: <?php echo number_format($total_price);?>%;"><span class="ui-label" style="display: block;"><b class="value"></b></span></div>
</div></div>
  <div class="col-md-6 col-xs-6  margin_top1"><ul><li><p style=" font-size: 18px; color: #cf000f;"><?php echo number_format($total_price);?>%</p></li><li><p style="color: #afafaf;"><?php echo translate('yiqilmish_mebleg');?></p></li></ul></div>
<div class="col-md-6 col-xs-6  margin_top1"><ul style="float: right;"><li><p style=" font-size: 18px; color: #cf000f;"><?php echo $detail['price'];?> <?php echo translate('AZN');?></p></li><li><p class="text-muted" style="color: #afafaf;"><?php echo translate('umumi_mebleg');?></p></li></ul></div>
<br>
                 </div><div class="col-md-5">
            <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li style="color: #2ecc71;" class="listing"><?php echo translate('Hedef');?></li>
                         <li class="listing2"><?php echo $detail['price'];?>    <?php echo translate('AZN');?></li>
                    </ul>
                </div>
                 <div class="col-md-6">
                     <ul>
                        <li style="color: #2ecc71;" class="listing"><?php echo translate('Toplanan');?></li>
                         <li class="listing2"><?php echo $detail['total_price'];?> <?php echo translate('AZN');?></li>
                    </ul>
                </div>
            </div>
              <div class="row">
                <div class="col-md-6">
                    <ul>
                        <li style="color: #2ecc71;" class="listing"><?php echo translate('Yerleshdirme_Tarixi');?></li>
                         <li class="listing2"><?php echo $detail['create_time'];?></li>
                    </ul>
                </div>
                 <div class="col-md-6">
                     <ul>
                        <li style="color: #2ecc71;" class="listing"><?php echo translate('Sona_catma_tarixi');?></li>
                         <li class="listing2"><?php echo $detail['end_time'];?></li>
                    </ul>
                </div>
            </div>
                 </div>
</div>
            </div>

            </div>

                    <div class="clearfix"></div>
    <button id="myBtn" style="float: right ; margin: 10px 16px;" class="btn btn-success" ><?php echo translate('Confirm');?></button> 

<!-- The Modal -->
<div id="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <span style="position: absolute; top: 10px; right: 15px;" class="close">&times;</span>
    <div class="row">
  
          <div class="col-md-11">
              <div class="row">
                 <!--  <h5>Ödəniş</h5> -->
                  <div class="col-md-12">
                 
                        <img width="410px;" src="<?php echo base_url('/assets/front/images/uploads/1526637054__d__ni__2.png');?>">
                  </div>


                  <div class="col-md-12">
                      <div class="col-md-6"></div>
                        <div class="col-md-6">
                            <ul>
                                <li><label><?php echo translate('mebleg');?></label></li>
       
                                 <li> <input id="inputt"  type="text" / ></li>
                            </ul>
                         
                        </div>
                  </div>


                  <div class="col-md-12">
                    <div class="col-md-12">
                        <ul>
                                <li><label><?php echo translate('card_number');?></label></li>
       
                                 <li> <input  id="inputt" type="text" / ></li>
                            </ul> 
                    </div>
                      
                  </div>


                     <div class="col-md-12">
                      <div class="col-md-6">
                          <ul>
                                <li><label><?php echo translate('month');?></label></li>
       
                                 <li> <input  id="inputt" type="text" / ></li>
                            </ul>
                      </div>
                        <div class="col-md-6">
                            <ul>
                                <li><label><?php echo translate('year');?></label></li>
       
                                 <li> <input  id="inputt" type="text" / ></li>
                            </ul>
                         
                        </div>
                  </div>

                        <div class="col-md-12">
                      <div class="col-md-6">
                          <ul>
                                <li><label>CVV/CVC </label></li>
       
                                 <li> <input  id="inputt" type="text" / ></li>
                            </ul>
                      </div>
                        <div class="col-md-6">
                            <ul>
                                <li><label><?php echo translate('cvc?');?></label></li>
       
                                 <li><label><?php echo translate('cvc_cavab');?></label></li>
                            </ul>
                         
                        </div>
                  </div>

                   <div class="col-md-12">
                      <div class="col-md-10">
                          
                      </div>
                        <div class="col-md-2">
                           <button style="float: right ; margin: 10px 16px;" class="btn btn-success" ><?php echo translate('pay_now');?></button>  
                         
                        </div>
                  </div>


              </div>
          </div>
    </div>
   
  </div>



</div>
    <div class="clearfix"></div>
<hr/>
           <div class="clearfix"></div>
             <div class="margin_top1"></div>
            <p><?php echo $detail['about'];?> </p>

             <div class="clearfix"></div>
             <div class="margin_top1"></div>
            <p><?php echo $detail['description'];?> </p>
            </div>
            </div><!-- /# end post -->

            <div class="clearfix divider_line1"></div>


            <div class="sharepost">
				<h5 class="light"><?php echo translate('Share');?></h5>
					<ul>
						<li><a href="#">&nbsp;<i class="fa fa-facebook fa-lg"></i>&nbsp;</a></li>

						<li><a href="#"><i class="fa fa-google-plus fa-lg"></i></a></li>


					</ul>

				</div><!-- end share post links -->

                <div class="clearfix"></div>

            <h5 class="light"><?php echo translate('about_author_project');?></h5>
            <div class="about_author">
        <?php echo $detail['address'];?>
              
            </div>

            <div class="clearfix margin_top7"></div>

   <div class="clearfix divider_line9 lessm"></div> 

</div><!-- end content left side -->



<!-- right sidebar starts -->
<div class="right_sidebar">

	<div class="sidebar_widget">
    	<div class="sidebar_title"><h4><?php echo translate('Categories');?></h4></div>
		<ul class="arrows_list1">
      <?php $categoreis=get_cfcategories(); foreach ($categoreis as $category) { if($detail['category_id']===$category['id']){$active='active';}else{$active='';} ?>
       
            <li><a class="<?php echo $active;?>" href="<?php echo base_url()?>cfprojects/category/<?php echo $category['id'].'-'.$category['link'];?>"><i class="fa fa-angle-right"></i><?php echo $category['title_'.$l.''];?></a></li>
       
     <?php }?>
		</ul>
	</div><!-- end section -->

    <div class="clearfix margin_top4"></div>

    <div class="sidebar_widget">

    	<div class="sidebar_title"><h4><?php echo translate('Recenct_Projects');?></h4></div>

			<ul class="recent_posts_list">
       <?php $recent=get_recent_cfprojects(); foreach ($recent as $project) { if($project['project_id']!==$detail['project_id']){?>
                <li>
                <span><a  href="<?php echo base_url('cfprojects/detail/').$project['project_id'].'-'.$project['link'];?>"><img style="width:65px ; height:45px; " src="<?php echo base_url('cf_images/').$project['image'];?>" alt="<?php echo $project['title'];?>" /></a></span>
                <a href="<?php echo base_url('cfprojects/detail/').$project['project_id'].'-'.$project['link'];?>"><?php echo word_limiter($project['title'],5);?></a>
                <i><?php echo $project['create_time'];?></i>
                </li>
                  <?php }}?>
            </ul>
	</div><!-- end section -->
<div class="clearfix margin_top4"></div>
</div><!-- end right sidebar -->
</div>
</div><!-- end content area -->
<div class="clearfix"></div>