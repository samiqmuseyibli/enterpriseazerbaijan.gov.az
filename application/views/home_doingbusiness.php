<div class="clearfix"></div>
    <div class="page_title2 sty2">
            <div class="container">
                <h1> <?php echo $detail['title_'.$l.''];?> </h1>
                <div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a><i> / </i><?php echo $detail['title_'.$l.''];?></div>
            </div>
        </div>
<style type="text/css">
    img{
    -webkit-box-shadow: 10px 20px 10px -10px #454545;
    -moz-box-shadow: 10px 20px 10px -10px #454545;
     box-shadow: 10px 20px 10px -10px #454545;
     margin-bottom: 10px;
}
</style>
        <div class="clearfix"></div>
        <div class="content_fullwidth less2">
            <div class="container">
                <div class="left_sidebar">
                    <div class="sidebar_widget">
                        <div class="sidebar_title">
                            <h4><?php echo translate('Why_Azerbaijan');?></h4>
                        </div>
                        <ul class="arrows_list1">
                            <?php foreach ($items as $item) {
                                if ($item['id']===$detail['id']) {
                                    $active='class="active"';
                                }else{
                                    $active='';
                                }
                                ?>
                            <li><a <?php echo $active; ?> href="<?php echo base_url('home/doingbusiness/').$item['id'].'-'.$item['top'];?>"><i class="fa fa-angle-right"></i> <?php echo $item['title_'.$l.''];?></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="content_right">
                    <div class="row" >
                      <div id="business" > <?php echo $detail['url_image_'.$l.''];?> </div>
                    </div>
                </div>
            </div>
        </div>
