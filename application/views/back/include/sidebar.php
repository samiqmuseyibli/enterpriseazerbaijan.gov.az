<?php $last_login = $this->session->userdata('last_login'); $last_ip = $this->session->userdata('last_ip');?>
<aside class="main-sidebar">
	<section class="sidebar">
		<div class="user-panel">
			<div class="pull-left image">
				<img src="<?=base_url('files/favicon.png')?>" class="img-circle" alt="Logo">
			</div>
			<div class="pull-left info">
				<p>Enterprise Azberbaijan</p>
				<a href="#"><i class="fa fa-circle text-success"></i> Son giriş tarixi <br> <?php echo $last_login;?> </a>
			</div>
		</div>
		<br />
		<?php $active_link_2 =$this->uri->segment(2); $active_link_3 =$this->uri->segment(3); ?>
		<ul class="sidebar-menu" data-widget="tree">
			<li style="color: white;" class="header text-center ">Son IP: <?php echo $last_ip;?></li>
			<li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> <span>Ana səhifə</span></a></li>
			<li <?php if ($active_link_2 == 'news' || $active_link_2 == 'news_add' || $active_link_2 == 'update_news'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/news');?>"><i class="fa fa-newspaper-o"></i> <span> Xəbərlər</span></a></li>
			<li <?php if ($active_link_2 == 'video' || $active_link_2 == 'video_add' || $active_link_2 == 'update_video'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/video');?>"><i class="fa fa-video-camera"></i> <span> Videolar</span></a></li>
            <li <?php if ($active_link_2 == 'uploadedfiles'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/uploadedfiles');?>"><i class="fa fa-file-o"></i> <span> Fayllar</span></a></li>
            <li <?php if ($active_link_2 == 'documents' || $active_link_2 == 'documents_add' || $active_link_2 == 'update_documents'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/documents');?>"><i class="fa fa-files-o"></i> <span> Qanunvericilik</span></a></li>
			<li class="treeview <?php if ($active_link_2 == 'users' || $active_link_2 == 'get_subcribers' || $active_link_2 == 'messages'): ?>  active <?php endif ?>">
				<a href="#">
					<i class="fa fa-user-o"></i>
					<span>İstifadəçilər</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li <?php if ($active_link_2 == 'users'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/users'); ?>"><i class="fa fa-circle-o"></i>İstifadəçi listi</a></li>
					<li <?php if ($active_link_2 == 'get_subcribers'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/get_subcribers'); ?>"><i class="fa fa-circle-o"></i>İzləyicilər</a></li>
					<li <?php if ($active_link_2 == 'messages'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/messages'); ?>"><i class="fa fa-circle-o"></i>Müraciətlər</a></li>
				</ul>
			</li>
			<li class="treeview <?php if ($active_link_2 == 'projects' || $active_link_2 == 'wantcjprojects' || $active_link_2 == 'wantcjprojects'): ?>  active <?php endif ?>">
				<a href="#">
					<i class="fa fa-diamond"></i>
					<span>Layihələr</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li <?php if ($active_link_2 == 'projects'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/projects'); ?>"><i class="fa fa-circle-o"></i>Bütün layihələr</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-money"></i>
					<span>Kraudfandinq</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url('admin/cfprojects'); ?>"><i class="fa fa-circle-o"></i>KF layihələri</a></li>
					<li><a href="<?php echo base_url('admin/cfcategories'); ?>"><i class="fa fa-circle-o"></i>KF kateqoriyaları</a></li>
					<li><a href="<?php echo base_url('admin/updatecfabout'); ?>"><i class="fa fa-circle-o"></i>Kraudfandinq nədir?</a></li>
				</ul>
			</li>
			<li class="treeview <?php if ($active_link_2 == 'edit_location' || $active_link_2 == 'companies' || $active_link_3 == 'add_location'): ?>  active <?php endif ?>">
				<a href="#">
					<i class="fa fa-map"></i>
					<span>Geoiqtisadi xəritə</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url('admin/category/add'); ?>"><i class="fa fa-circle-o"></i>Kateqoriya əlavə et</a></li>
					<li><a href="<?php echo base_url('admin/category/update'); ?>"><i class="fa fa-circle-o"></i>Kateqoriya redaktə et</a></li>
					<li><a href="<?php echo base_url('admin/category/delete'); ?>"><i class="fa fa-circle-o"></i>Kategoriya sil</a></li>
					<br />
					<li><a href="<?php echo base_url('admin/category/add_sub'); ?>"><i class="fa fa-circle-o"></i>Alt kateqoriya əlavə et</a></li>
					<li><a href="<?php echo base_url('admin/category/update_sub'); ?>"><i class="fa fa-circle-o"></i>Alt kateqoriya redaktə et</a></li>
					<li><a href="<?php echo base_url('admin/category/delete_sub'); ?>"><i class="fa fa-circle-o"></i>Alt kategoriya sil</a></li>
					<br />
					<li <?php if ($active_link_3 == 'add_location'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/category/add_location'); ?>"><i class="fa fa-circle-o"></i>Yer əlavə et</a></li>
					<li <?php if ($active_link_2 == 'edit_location'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/edit_location'); ?>"><i class="fa fa-circle-o"></i>Yer redaktə et</a></li>
					<br />
					<li <?php if ($active_link_2 == 'companies'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/companies'); ?>"><i class="fa fa-circle-o"></i>Şirkətlər</a></li>
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-cubes"></i>
					<span>Sabit səhifələr</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url('admin/project_categories'); ?>"><i class="fa fa-circle-o"></i>Kateqoriyalar</a></li>
					<li><a href="<?php echo base_url('admin/sectors'); ?>"><i class="fa fa-circle-o"></i>Sektorlar</a></li>
					<li><a href="<?php echo base_url('admin/updateprivacy'); ?>"><i class="fa fa-circle-o"></i>Məxfilik şərtləri</a></li>
					<li><a href="<?php echo base_url('admin/updateservices'); ?>"><i class="fa fa-circle-o"></i>Xidmətlər</a></li>
					<li><a href="<?php echo base_url('admin/updatetermsofuse'); ?>"><i class="fa fa-circle-o"></i>İstifadə qaydaları</a></li>
					<li><a href="<?php echo base_url('admin/about_content'); ?>"><i class="fa fa-circle-o"></i>Haqqimizda</a></li>
					<li><a href="<?php echo base_url('admin/strategic_plan'); ?>"><i class="fa fa-circle-o"></i>Strateji Plan</a></li>
					<li><a href="<?php echo base_url('admin/partners'); ?>"><i class="fa fa-circle-o"></i>Tərəfdaşlarımız</a></li>
					<li><a href="<?php echo base_url('admin/sliders'); ?>"><i class="fa fa-circle-o"></i>Sliderlər</a></li>
				</ul>
			</li>
			<li class="treeview <?php if ($active_link_2 == 'get_settings' || $active_link_2 == 'site_translation' || $active_link_2 == 'update_site_translation'): ?>  active <?php endif ?>">
				<a href="#">
					<i class="fa fa-cog"></i>
					<span>Sayt tənzimləmələri</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li <?php if ($active_link_2 == 'get_settings'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/get_settings'); ?>"><i class="fa fa-circle-o"></i>Sayt tənzimləmələri</a></li>
					<li <?php if ($active_link_2 == 'site_translation' || $active_link_2 == 'update_site_translation'): ?> class = "active" <?php endif ?>><a href="<?php echo base_url('admin/site_translation'); ?>"><i class="fa fa-circle-o"></i>Saytın tərcüməsi</a></li>
					
				</ul>
			</li>
			<li class="treeview">
				<a href="#">
					<i class="fa fa-lock"></i>
					<span>Təhlükəsizlik</span>
					<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
				</a>
				<ul class="treeview-menu">
					<li><a href="<?php echo base_url('admin/update_password'); ?>"><i class="fa fa-circle-o"></i>Şifrəni yenilə</a></li> 
					<li><a href="<?php echo base_url('admin/getlogins'); ?>"><i class="fa fa-circle-o"></i>Daxil olma cəhdləri</a></li> 
					<li><a href="<?php echo base_url('admin/getlogs'); ?>"><i class="fa fa-circle-o"></i>Loglar</a></li> 
				</ul>
			</li>
			<li><a href="<?php echo base_url(); ?>" target="_blank"><i class="fa fa-external-link"></i> <span> Vebsayta bax</span></a></li>
			<li><a href="<?php echo base_url('admin/logout'); ?>"><i class="fa fa-circle-o text-red"></i> <span>Çıxış</span></a></li>
		</ul>
	</section>
</aside>