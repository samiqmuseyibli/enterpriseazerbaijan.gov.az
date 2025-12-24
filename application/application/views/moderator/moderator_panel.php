<?php  $this->load->view('header'); ?>
 <div class="clearfix"></div>
<div class="page_title2 sty2">
<div class="container">
    <h1><?php echo translate('moderator_panel');?></h1>
    <div class="pagenation">&nbsp;<a href="<?php echo base_url()?>"><?php echo translate('home_page');?></a> <i>/</i> <a href=""><?php echo translate('moderator_panel');?></a></div>
</div>
</div><!-- end page title -->
<div class="clearfix"></div>
<div class="content_fullwidth less2">
<div class="container">
<!-- left sidebar starts -->
<div class="left_sidebar">
  <div class="sidebar_widget">
      <div class="sidebar_title"><h4><?php echo translate('moderator_panel');?></h4></div>
    <ul class="arrows_list1">
            <li><a href="<?php echo base_url('moderator/all_projects'); ?>"><i class="fa fa-angle-right"></i> <?php echo translate('all_projects');?></a> - <?php echo $usercount = get_project_count_admin(); ?></li>
             <li><a href="<?php echo base_url('moderator/accepted_projects'); ?>"><i class="fa fa-angle-right"></i> <?php echo translate('accepted_project');?></a> - <?php echo $usercount = get_project_count_moderator('1'); ?> </li>
            <li><a href="<?php echo base_url('moderator/on_waiting_projects'); ?>"><i class="fa fa-angle-right"></i> <?php echo translate('on_waiting_projects');?></a> - <a style="color: red;"><?php echo $usercount = get_project_count_moderator(0); ?> </a></li>
             <li><a href="<?php echo base_url('moderator/edited_projects'); ?>"><i class="fa fa-angle-right"></i> <?php echo translate('edited_projects');?></a> - <?php echo $usercount = get_project_count_moderator(3); ?> </li>
            <li><a href="<?php echo base_url('moderator/deleted_projects'); ?>"><i class="fa fa-angle-right"></i> <?php echo translate('deleted_projects');?></a> - <?php echo $usercount = get_project_count_moderator(2); ?></li>
            <li><a href="<?php echo base_url('moderator/logout'); ?>"><i class="fa fa-angle-right"> </i> <?php echo translate('exit');?></a></li> 
    </ul>
  </div><!-- end section -->
</div><!-- end left sidebar -->
  <?php  $this->load->view('moderator/'.$page_name.'.php')?>
</div>
</div>
<div class="clearfix"></div>
<?php  $this->load->view('footer_profile')?>   
<script>
  $('.delete-div-wrapmod .close').on('click', function() {
            var pid = $(this).closest('.delete-div-wrapmod').find('img').data('id');
            var here = $(this);
            $.ajax({
              url: "<?php echo base_url(); ?>" + 'moderator/deletefile/' + pid,
              cache: false,
              success: function(data) {
                if (data == 'done') {
                  swal({
                   title: "Image Delete",
                   text: "Successfully",
                   icon: "success",
                    button: "Ok",
                      });
                  here.closest('.delete-div-wrapmod').remove();
                } else {
                  swal({
                   title: "Image Delete",
                   text: "Can't delete",
                   icon: "danger",
                    button: "Ok",
                      });
                }
              }
            });
          });
</script>>