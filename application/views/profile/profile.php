<?php
$l=curLang();
$this->load->view('header');
?>
	<div class="clearfix"></div>	
	<div class="page_title2 sty2">
		<div class="container">
			<h1><?php echo translate('profile');?></h1>
			<div class="pagenation">&nbsp;<a href="<?php echo base_url()?>"><?php echo translate('home_page');?></a> <i>/</i> <a href=""><?php echo translate('profile');?></a></div>
		</div>
	</div><!-- end page title -->
	<div class="clearfix"></div>
	<div class="content_fullwidth less2">
		<div class="container">
			<!-- left sidebar starts -->
			<div class="left_sidebar">
				<div class="sidebar_widget">
					<div class="sidebar_title"><h4><?php echo translate('profile');?></h4></div>
					<ul class="arrows_list1">
						<li><a href="<?php echo base_url('user/projects'); ?>"><i class="fa fa-angle-right"></i>  <?php echo translate('my_projects');?></a></li>
						<li><a href="<?php echo base_url('user/categories'); ?>"><i class="fa fa-angle-right"></i> <?php echo translate('new_project');?></a></li>
						<li><a href="<?php echo base_url('user/profile'); ?>"><i class="fa fa-angle-right"></i> <?php echo translate('information');?></a></li>
						<li><a href="<?php echo base_url('user/password_update'); ?>"><i class="fa fa-angle-right"> </i> <?php echo translate('reset_password');?></a></li>
						<li><a href="<?php echo base_url('user/logout'); ?>"><i class="fa fa-angle-right"> </i> <?php echo translate('exit');?></a></li>
					</ul>
				</div><!-- end section -->
			</div><!-- end left sidebar -->
			<?php include($page_name.'.php');?>
		</div>
	</div>
<div class="clearfix"></div>
 <?php  $this->load->view('footer_profile')?>   
