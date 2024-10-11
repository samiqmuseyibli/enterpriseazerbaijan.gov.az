<style type="text/css">


.one_fifth_less .box_ent {
     height: 400px!important;
}



.fontmwhite_p {
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    line-height: 16px;
    color: #e9e9e9;
    font-weight: 500;
    font-size: 14px;
    text-shadow: 1px 0 7px #2a363f; 
    margin-top: 15px;
}

.fontmwhite_mp {
    
    font-size: 25px;
    font-weight: bold;

}

@media (min-width: 768px){

.home_1c{

    display: flex;
    justify-content: center;

}

}


@media (max-width: 768px){
.margin-lftr{
  display: block!important;
}

.one_fifth_less .box_ent {
     height: 300px!important;
}

}

.linebg_10 {
    display: block;
    vertical-align: central;
    width: 130px;
    height: 2px;
    margin-top:35px;
    margin-bottom: 35px;
    background-color: #834b9b;
    margin-right: auto;
    margin-left: auto;
}
.linebg_11 {
    display: block;
    vertical-align: central;
    width: 130px;
    height: 2px;
    margin-top:35px;
    margin-bottom: 45px;
    background-color: #834b9b;
    margin-right: auto;
    margin-left: auto;
}
.linebg_12 {
    display: block;
    vertical-align: central;
    width: 130px;
    height: 2px;
    margin-top:0px;
    margin-bottom: 15px;
    background-color: #834b9b;
    margin-right: auto;
    margin-left: auto;
}
.clr_ent {
        background: #834b9b!important;
}

.clr_ent:hover {
        background: #b7883c!important;
}
.feature_section_pdd {

    padding: 120px 0px 97px 0px!important;

}

.ent_title{
   font-size: 23px;
   line-height: 30px;
}

.feature_section7 .box {
  
    border-radius: 25px!important;
   
}
.linebg{
     background-color: #834b9b!important;
}

.less_ent {
    width: 100%;
    margin: 0 auto;
}
.margin-lftr{
  display: flex;
  justify-content: center;

}

</style>
<div class="clearfix"></div>
<div class="feature_section7 feature_section_pdd">
<div class="container">
    <h1 class="caps" style="margin-bottom:0px;"><?=translate('EnterpriseAzerbaijan_PRESENCE');?></h1>
    <div class="clearfix margin_bottom3"></div>

    <div class="linebg_10"></div>   
      <div class="margin-lftr">
     <div class="one_fifth_less">
      <a href="<?=base_url('project/category/5-ideyalar')?>">
        <div class="box  box_ent clr_ent">
           <i class="fa fa-lightbulb-o"></i> <h4 class="white ent_title"><?=translate('enterprise_incubation')?></h4>
           <p class="fontmwhite_p less_ent"><?=translate('enterprise_incubation_p')?></p>
        </div>
      </a>
    </div>
     <div class="one_fifth_less">
      <a href="<?=base_url('project/category/1-startap')?>">
        <div class="box  box_ent clr_ent">
           <i class="fa fa-line-chart"></i> <h4 class="white ent_title"><?=translate('enterprise_acceleration')?></h4>
           <p class="fontmwhite_p less_ent"><?=translate('enterprise_acceleration_p')?></p>
        </div>
      </a>
    </div>
     <div class="one_fifth_less">
      <a href="<?=base_url('project/all')?>">
        <div class="box  box_ent clr_ent">
           <i class="fa fa-list"></i> <h4 class="white ent_title"><?=translate('enterprise_vc_studio')?></h4>
           <p class="fontmwhite_p less_ent"><?=translate('enterprise_vc_studio_p')?></p>
        </div>
      </a>
    </div>
     <div class="one_fifth_less last">
      <a href="https://startupschool.az/">
        <div class="box  box_ent clr_ent">
           <i class="fa fa-graduation-cap"></i> <h4 class="white ent_title"><?=translate('startup_school')?></h4>
           <p class="fontmwhite_p less_ent"><?=translate('startup_school_p')?></p>
        </div>
      </a>
    </div>

    </div>   

</div>
</div>
<div class="clearfix"></div>
<?php include('filter.php');?>
<div class="clearfix"></div>
<div class="feature_section7">
<div class="container">
    <h1 class="caps" style="margin-bottom:0px;"><?=translate('Why_Azerbaijan')?></h1>
    <div class="clearfix margin_bottom3"></div>
    <div class="linebg_10"></div>
    <div class="one_fifth_less">
      <?php $doing_business=get_doing_business_detail('8');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div  class="box">
      <i class="fa  fa-briefcase "></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
      </div></a>
     </div><!-- end -->
    <div class="one_fifth_less">
       <?php $doing_business=get_doing_business_detail('9');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div class="box two">
      <i class="fa fa-building"></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
    </div></a>
    </div>
    <!-- end -->
    <div class="one_fifth_less">
       <?php $doing_business=get_doing_business_detail('10');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div class="box three">
      <i class="fa fa-lightbulb-o"></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
    </div></a>
    </div>
    <!-- end -->
    <div class="one_fifth_less">
        <?php $doing_business=get_doing_business_detail('11');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div class="box four">
      <i class="fa fa-globe"></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
    </div></a>
    </div>
    <!-- end -->
    <div class="one_fifth_less last">
         <?php $doing_business=get_doing_business_detail('12');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div class="box five">
      <i class="fa fa-dollar"></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
    </div></a>
    </div>
    <!-- end -->
    <div class="clearfix margin_bottom2"></div>
    <div class="one_fifth_less">
       <?php $doing_business=get_doing_business_detail('13');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div class="box six">
      <i class="fa fa-heartbeat"></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
    </div></a>
    </div>
    <!-- end -->
    <div class="one_fifth_less">
        <?php $doing_business=get_doing_business_detail('14');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div class="box seven">
      <i class="fa fa-money"></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
    </div></a>
    </div>
    <!-- end -->
    <div class="one_fifth_less">
        <?php $doing_business=get_doing_business_detail('15');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div class="box eight">
      <i class="fa fa-files-o"></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
    </div></a>
    </div>
    <!-- end -->
    <div class="one_fifth_less">
        <?php $doing_business=get_doing_business_detail('16');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div class="box nine">
      <i class="fa fa-balance-scale"></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
    </div></a>
    </div>
    <!-- end -->
    <div class="one_fifth_less last">
        <?php $doing_business=get_doing_business_detail('17');?>
      <a href="<?php echo base_url('home/doingbusiness/').$doing_business['id'].'-'.$doing_business['top'];?>"><div class="box ten">
      <i class="fa  fa-exclamation-triangle "></i> <h4 class="white"><?php echo $doing_business['title_'.$l.''];?></h4>
    </div></a>
    </div>
    <!-- end -->
</div>
</div>
<div class="clearfix"></div>
<?php if ($news): ?>

 <div class="clearfix"></div>
    <div class="news-layer-yn">
        <div class="container">
            <div class="clearfix margin_bottom3"></div>
            <h1 style="text-align:center; margin-bottom:0px;" class="caps"><?=translate('news')?></h1>
            <div class="clearfix margin_bottom3"></div>
            <div class="linebg"></div>
                <div class="owl-carousel owl-theme owl-loaded">
                    <div class="owl-stage-outer">
                        <div class="owl-stage">
                            <?php foreach ($news as $item): ?>
                             
                              <div class="owl-item">
                                    <div class="news-element-yn">
                                        <img class="photo-yn" src="<?=base_url('assets/front/images/news/').$item['url_image'];?>" alt="<?=$item['title_'.$l.'']?>">
                                        <div class="news-text-yn">
                                            <p class="text-yn"><a href="<?php echo base_url();?>news/detail/<?php echo $item['id'].'-'.$item['top_'.$l.''];?>"><?=qisalt($item['title_'.$l.''], 130); ?></a></p>
                                            <div class="date-sign-yn">
                                                <i style="margin: 5px; color: #834b9b;" class="fa fa-calendar"> </i>
                                                <p class="date-yn"><?=date_for_view($item['date'])?></p>
                                            </div>
                                        </div>
                                    </div>
                             </div> 
                             
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>  
    </div>
</div>
 <?php endif ?>
<div class="clearfix"></div>
    <div class="feature_section1">
        <div class="container">
            <div class="clearfix margin_bottom3"></div>
            <h1 class="caps" style="margin-bottom:0px;margin-top: 40px;"><?php echo translate('partners'); ?></h1>
            <div class="clearfix margin_bottom3"></div>
            <div class="linebg_11"></div>
                <ul id="block" style="text-align: center!important;">
                    <?php 
                        $partners = get_partners();
                        foreach ($partners as $partner) {
                            ?>
                            <li style="display:inline-block!important; *display:inline; /*IE7*/ margin: 60px; margin-top: 0!important;">
                                <a href="<?php echo $partner['web_site'] ?>" target="_blank" title="<?php echo $partner['title'] ?>">
                                    <img style="min-height: 50px; max-width:100%;" rel="nofollow" src="<?php echo base_url(); ?>assets/front/images/<?php echo $partner['url_image'] ?>" alt="<?php echo $partner['title'] ?>" />
                                </a>
                            </li>
                            <?php 
                        } 
                    ?>
                </ul>
        </div>
    </div>
