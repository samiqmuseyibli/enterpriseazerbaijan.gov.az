<?php
	$lang=$this->session->userdata('language');
	if ($lang==='Azerbaijan'){
		$l='az';
	}if ($lang==='Russian'){
		$l='ru';
	}if ($lang==='English'){
		$l='en';
	}
?>
<!doctype html>
<html lang="az" class="no-js">
           <head>
					<meta charset="UTF-8">
					<meta name="google-site-verification" content="uFh0jwPdMw915KBk2LMrq-Q15OBrryMU0raQ28gFU0w" />
					<META name="rating" content="General">
					<META name="distribution" content="Global">
					<meta name="revisit-after" content="1 days" />
					<meta name="robots" content="follow, index, all" />
					<meta name="googlebot" content="follow, index, all" />
					<meta name="Scooter" content="follow, index, all" />
					<meta name="msnbot" content="follow, index, all" />
					<meta name="alexabot" content="follow, index, all" />
					<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
					<meta name="Slurp" content="follow, index, all" />
					<meta name="ZyBorg" content="follow, index, all" />
					<meta name="SPIDERS" content="ALL" />
					<meta name="WEBCRAWLERS" content="ALL" />
					<meta property="author" content="Elmar Tahmazli">
					<meta property="fb:app_id" content="">
					<meta property="og:type" content="website">		
			        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
			        <link rel="shortcut icon" href="<?=base_url('files/favicon.png')?>">
			        <meta name="viewport" content="width=device-width, initial-scale=1.0">
					<meta name="title" content="<?php echo $title;?>" />
		    <?php if (isset($page_name) && $page_name == 'news_detail'){ ?>

	                <title><?php echo $detail['title_'.$l.'']?> | EnterpriseAzerbaijan</title>
	                <meta name="keywords" content="islahat, investisiya, invest, startup, enterprise, ozellesme, azərbaycan, ideya, idea, kraud, crowdfunding, geo-economic map, economic, map" />
			        <meta name="description" content="<?php echo qisalt(strip_tags($detail['content_'.$l.'']),150)?>">
					<meta property="og:title" content="<?php echo $detail['title_'.$l.'']?>" />
					<meta property="og:description" content="<?php echo qisalt(strip_tags($detail['content_'.$l.'']),150)?>" />
					<meta property="og:type" content="article">
	                <meta property="og:url" content="<?php echo base_url('news/detail/').$detail['id'];?>">
					<meta property="og:image" content="<?php echo base_url('assets/front/images/news/');?><?php echo $detail['url_image'];?>" />
					<link rel="image_src" href="<?php echo base_url('assets/front/images/news/');?><?php echo $detail['url_image'];?>" />

			<?php }else if(isset($page_name) && $page_name == 'video_detail'){ ?>

                    <title><?=$title?></title>
	                <meta name="keywords" content="islahat, investisiya, invest, startup, enterprise, ozellesme, azərbaycan, ideya, idea, kraud, crowdfunding, geo-economic map, economic, map" />
			        <meta name="description" content="İnvestisiya layihələri, aktivlər, təbii resurslar və investisiya imkanları haqda məlumatların xarici və yerli investorlara təqdim edilməsi və maliyyələşməsi üçün əlverişli platformanın yaradılması, ölkənin investisiya cəlbediciliyini yüksəldilməsi və alternativ maliyyələşmə mənbələrindən istifadə imkanlarını artırmaq">
					<meta property="og:title" content="<?=$title?>" />
					<meta property="og:description" content="İnvestisiya layihələri, aktivlər, təbii resurslar və investisiya imkanları haqda məlumatların xarici və yerli investorlara təqdim edilməsi və maliyyələşməsi üçün əlverişli platformanın yaradılması, ölkənin investisiya cəlbediciliyini yüksəldilməsi və alternativ maliyyələşmə mənbələrindən istifadə imkanlarını artırmaq" />
					<meta property="og:type" content="article">
	                <meta property="og:url" content="<?php echo base_url('video/detail/').$row['v_id'];?>">
					<meta property="og:image" content="<?=base_url($row['v_cover'])?>" />
					<link rel="image_src" href="<?=base_url($row['v_cover'])?>" />

			<?php }else if(isset($page_name) && $page_name == 'home_detail'){ ?>
	                <title><?php echo $detail['project_title']?> | <?php echo $detail['kat_adi_'.$l.''];?> | EnterpriseAzerbaijan</title>
	                <meta name="keywords" content="islahat, investisiya, invest, startup, enterprise, ozellesme, azərbaycan, ideya, idea, kraud, crowdfunding, geo-economic map, economic, map" />
			        <meta name="description" content="<?php echo $detail['project_description']?>">
	                <meta property="og:title" content="<?php echo $detail['project_title']?>" />
					<meta property="og:description" content="<?php echo $detail['project_description']?>" />
					<meta property="og:type" content="article">
	                <meta property="og:url" content="<?php echo base_url('project/detail/').$detail['project_id'];?>">
					<meta property="og:image" content="<?php echo base_url();?>files/projectimages/noimage.jpg" />
					<link rel="image_src" href="<?php echo base_url();?>files/projectimages/noimage.jpg" />

			<?php }else{ ?>
				    <title><?php echo $title;?></title>
                    <meta name="keywords" content="islahat, investisiya, invest, startup, enterprise, ozellesme, azərbaycan, ideya, idea, kraud, crowdfunding, geo-economic map, economic, map" />
		            <meta name="description" content="İnvestisiya layihələri, aktivlər, təbii resurslar və investisiya imkanları haqda məlumatların xarici və yerli investorlara təqdim edilməsi və maliyyələşməsi üçün əlverişli platformanın yaradılması, ölkənin investisiya cəlbediciliyini yüksəldilməsi və alternativ maliyyələşmə mənbələrindən istifadə imkanlarını artırmaq">
					<meta property="og:title" content="<?php echo $title;?>">
					<meta property="og:site_name" content="<?php echo base_url();?>">
					<meta property="og:url" content="<?php echo base_url();?>">
					<meta property="og:description" content="İnvestisiya layihələri, aktivlər, təbii resurslar və investisiya imkanları haqda məlumatların xarici və yerli investorlara təqdim edilməsi və maliyyələşməsi üçün əlverişli platformanın yaradılması, ölkənin investisiya cəlbediciliyini yüksəldilməsi və alternativ maliyyələşmə mənbələrindən istifadə imkanlarını artırmaq">
					<meta property="og:image" content="<?php echo base_url();?>files/projectimages/noimage.jpg" />
					<meta property="og:image:alt" content="<?php echo $title;?>" />
					<meta property="og:image:type" content="image/jpeg" />
					<meta property="og:image:width" content="400" />
					<meta property="og:image:height" content="600" />
					<meta property="og:image:alt" content="<?php echo $title;?>" />
					<meta name="twitter:card" content="<?php echo $title;?>">
					<meta name="twitter:image:alt" content="<?php echo $title;?>">
			<?php }
			// geomap parameters
			if ($this->uri->segment(1)== 'geomap'){
				?>
				<link rel="stylesheet" href="<?php echo base_url();?>assets/front/css/openlayers/en-v5.2.0-css-ol.css" type="text/css">
				<?php
			} ?>
        <!-- ######### CSS STYLES ######### -->
        <link href="<?php echo base_url();?>assets/front/css/reset-education.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/front/css/style-education.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/front/css/responsive-leyouts.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/front/css/font-awesome/css/font-awesome.min.css" rel="stylesheet" >
        <link href="<?php echo base_url();?>assets/front/css/profile.css" rel="stylesheet" >
        <link href="<?php echo base_url();?>assets/front/js/animations/css/animations.min.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?php echo base_url();?>assets/front/css/responsive-leyouts-education.css" type="text/css" rel="stylesheet" media="screen" />
        <link href="<?php echo base_url();?>assets/front/css/shortcodes-education.css" rel="stylesheet" media="screen" type="text/css" />
		<link href="<?php echo base_url();?>assets/front/js/mainmenu/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/front/js/mainmenu/menu-education.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/front/js/mainmenu/demo.css" rel="stylesheet">
        <link href="<?php echo base_url();?>assets/front/css/owl.carousel.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/front/css/owl.theme.default.min.css" rel="stylesheet" type="text/css" />
					
        <script src="<?php echo base_url();?>assets/front/js/jquery/jquery-3.3.1.min.js"></script> 
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-3W44R04WZL"></script>
		<script>
		  window.dataLayer = window.dataLayer || [];
		  function gtag(){dataLayer.push(arguments);}
		  gtag('js', new Date());

		  gtag('config', 'G-3W44R04WZL');
		</script>
			<style type="text/css">
		.share-post {
		    padding: 1px 0 0 0;
		}
		.sp-elements {
		    display: inline-block;
		}
		.sp-element.facebook {
		    background-color: #3b5998;
		    border: 1px solid #3b5998;
		}
		.sp-element {
		    border-radius: 4px;
		    color: #ffffff;
		    font-size: 15px;
		    padding: 4px 12px;
		    margin-bottom: 20px;
		    display: inline-block;
		    min-width: 40px;
		}
		.facebook {
		    text-align: center;
		}
		.sp-text {
		    font-size: 13px;
		    font-family: Arial;
		}
		.sp-element.twitter {
		    background-color: #1DA1F2;
		    border: 1px solid #1DA1F2;
		}
		.sp-element.telegram {
		    background-color: #0088cc;
		    border: 1px solid #0088cc;
		}

		.captcha{width: 39%;line-height: 37px;float: left;}
		.img-reload{cursor: pointer;float: left;width: 50px;padding: 9px;}
		.img-captcha{float:left;margin-bottom: 15px;}
		.cursor{cursor:pointer;}
		.mySlides {display:none}
		.w3-left, .w3-right, .w3-badge {cursor:pointer}
		.w3-badge {height:13px;width:13px;padding:0}

		 .owl-item{
		    padding: 20px!important;
		 } 
		.news-layer-yn{
		    background: white;
		    padding: 30px;
		}
		.news-element-yn{
		    width: 330px;
		    box-shadow: 0px 0px 20px 5px #e5e5e5;
		    border-radius: 17px 17px 17px 17px;
		}
		.photo-yn{
		    width: 330px;
		    height: 200px;
		    border-radius: 17px 17px 0px 0px;
		}
		.news-text-yn{
		    display: flex;
		    flex-direction: column;
		    padding: 11px 14px 17px 13px;
		    height: 160px;
		    justify-content: space-between;
		    border-radius: 0px 0px 17px 17px;
		}
		.text-yn{
		    font-family: 'Montserrat', sans-serif;
		    font-weight: 700;
		    font-size: 14px;
		    color: black!important;
		}
		.date-sign-yn{
		    display: flex;
		    align-items: center;
		}
		.date-yn{
		    font-family: 'Montserrat', sans-serif;
		    font-weight: 700;
		    font-size: 14px;
		    color: #834b9b;
		}

		@media screen and (min-width:250px) and (max-width: 600px) {
		    .news-layer-yn{
		        gap: 45px;
		        flex-wrap: wrap;
		    }
		    .news-element-yn{
		        width: 260px;
		    }
		    .photo-yn{
		        width: 300px;
		        height: 144px;
		    }
		    .news-text-yn{
		        height: 150px;
		    }
		    .text-yn{
		        font-family: 'Montserrat', sans-serif;
		        font-weight: 500;
		        font-size: 12px;
		        color: #000000;
		    }
		    .date-sign-yn{
		        display: flex;
		        align-items: center;
		    }
		    .date-yn{
		        font-family: 'Montserrat', sans-serif;
		        font-weight: 700;
		        font-size: 12px;
		        color: rgba(0, 0, 0, 0.5);
		    }
		    .fsnts{
		    	font-size: 10px!important;
		    }
		    .toplinks{
		    	padding-left: 10px!important;
		    }
		    
		}
      </style>
	      <div id="fb-root"></div>
	      <script>
	        window.fbAsyncInit = function() {
	          FB.init({
	            xfbml            : true,
	            version          : 'v10.0'
	          });
	        };

	        (function(d, s, id) {
	          var js, fjs = d.getElementsByTagName(s)[0];
	          if (d.getElementById(id)) return;
	          js = d.createElement(s); js.id = id;
	          js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
	          fjs.parentNode.insertBefore(js, fjs);
	        }(document, 'script', 'facebook-jssdk'));
	      </script>
	      <div class="fb-customerchat"
	        attribution="biz_inbox"
	        page_id="1810556542313861">
	      </div>      					
    </head>
    <body class="notranslate">
        <div class="site_wrapper">
            <div class="top_nav">
                <ul class="toplinks">
                    <?php $settings=get_site_settings();?>
                    <li class="fsnts" title="<?php echo $settings['tel1']?>"><i class="fa fa-phone"></i> <?php echo $settings['tel1']?></li>
                    <li class="fsnts" title="<?php echo $settings['mail']?>"><i class="fa fa-envelope"></i> <?php echo $settings['mail']?></li>
                    <?php
                   	if ($this->session->userdata('is_moderator')) {
                   		echo '<li><a href="'.base_url().'moderator/on_waiting_projects"><i class="fa fa-sign-in"></i> '.translate('Moderator').' &nbsp;&nbsp;</a></li>';
                   	}elseif (!$this->session->userdata('user_id')) {
                    	echo '<li><a href="'.base_url().'user/login"><i class="fa fa-sign-in"></i> '.translate('login').'</a></li>';
             			echo '<li><a href="'.base_url().'user/register"><i class="fa fa-user"></i> '.translate('sign_up').' &nbsp;&nbsp;</a></li>';
                  	}else{
                   		echo '<li><a href="'.base_url().'user/profile"><i class="fa fa-sign-in"></i> '.translate('profile').' &nbsp;&nbsp;</a></li>';
                  	}
	                
	                $lang=$this->session->userdata('language');
                    if ($lang==='Azerbaijan') {
						?>
						<li><a href="<?php echo base_url('user/changelanguage?lang=English');?>">EN</a></li>
						<li><a href="<?php echo base_url('user/changelanguage?lang=Russian');?>">RU</a></li>
                   		<?php 
                   	}if($lang==='Russian'){
                   		?>
						<li><a href="<?php echo base_url('user/changelanguage?lang=Azerbaijan');?>">AZ</a></li>
						<li><a href="<?php echo base_url('user/changelanguage?lang=English');?>">EN</a></li>
						<?php 
					}if($lang==='English'){
						?>
                      	<li><a href="<?php echo base_url('user/changelanguage?lang=Azerbaijan');?>">AZ</a></li>
                     	<li><a href="<?php echo base_url('user/changelanguage?lang=Russian');?>">RU</a></li>
                      	<?php 
                    }
                    ?>
                </ul>
            </div>
            <div class="clearfix"></div>
            <header class="header">
                <div class="container_full_menu">
                    <!-- Logo -->
                    <div class="logo"><a href="<?php echo base_url(); ?>" id="logo"></a></div>
                    <!-- Navigation Menu -->
                    <div class="menu_main">
                        <div class="navbar yamm navbar-default">
                            <div class="navbar-header">
                                <div class="navbar-toggle .navbar-collapse .pull-right " data-toggle="collapse" data-target="#navbar-collapse-1" > <span></span>
                                    <button type="button"> <i class="fa fa-bars"></i></button>
                                </div>
                            </div>
							
                            <div id="navbar-collapse-1" class="navbar-collapse collapse pull-right">
                                <nav>
                                    <ul class="nav navbar-nav">
                                        <!--
										<li><a href="<?php echo base_url(); ?>" class="dropdown-toggle <?php if(base_url()===current_url()){echo 'active';}?>" title="<?php echo translate('home_page');?>"><i class="fa fa-home fati20"></i> <?php echo translate('home_page');?></a></li>
										-->
                                        <li><a class="dropdown-toggle" href="<?php echo base_url(); ?>" title="<?php echo translate('home_page');?>"><i class="fa fa-home fati20"></i></a></li>
                                        <li class="dropdown"><a href="<?php echo base_url();?>geomap" class="dropdown-toggle <?php if($this->uri->segment(1)==='geomap'){echo 'active';}?>" title="<?php echo translate('geo-ecicial_map');?>"><?php echo translate('geo-ecicial_map');?></a></li>
                                        <!-- Haqqımızda base_url(); ?>about -->
										<li class="dropdown"><a href="#" class="dropdown-toggle <?php if($this->uri->segment(1)==='about' OR $this->uri->segment(1)==='contact'){echo 'active';}?>" title="<?php echo translate('about');?>"><?php echo translate('about');?><i class="fa fa-sort-desc"></i></a>
											<ul class="dropdown-menu" role="menu">
		                                        <li><a href="<?php echo base_url(); ?>about" class="dropdown-toggle" title="<?php echo translate('portal_profile');?>"><?php echo translate('portal_profile');?></a></li>
		                                        <li><a href="<?php echo base_url(); ?>contact" class="dropdown-toggle" title="<?php echo translate('contact');?>"><?php echo translate('contact');?></a></li>
											</ul>
										</li>
										<!-- Xidmətlər base_url('home/services') -->
                                        <li class="dropdown"><a href="#" class="dropdown-toggle <?php if($this->uri->segment(2)==='services' OR $this->uri->segment(1)==='cfprojects' OR $this->uri->segment(2)==='doingbusiness' ){echo 'active';}?>" title="<?php echo translate('our_services');?>"><?php echo translate('our_services');?><i class="fa fa-sort-desc"></i></a>
											<ul class="dropdown-menu" role="menu">
												<li><a target="_blank" href="https://startupschool.az/" class="dropdown-toggle" title="<?php echo translate('startup_school');?>"><?php echo translate('startup_school');?></a></li>
												<li><a href="<?php echo base_url();?>home/doingbusiness/8-biznese-baslama" class="dropdown-toggle" title="<?php echo translate('Why_Azerbaijan');?>"><?php echo translate('Why_Azerbaijan');?></a></li>
											</ul>
										</li>
										<li class="dropdown"><a href="<?php echo base_url();?>home/documents" class="dropdown-toggle <?php if($this->uri->segment(2)==='documents'){echo 'active';}?>" title="<?php echo translate('doc_header');?>"><?php echo translate('doc_header');?></a></li>

                                        <li class="dropdown"><a href="#" class="dropdown-toggle <?php if($this->uri->segment(2)==='news' OR $this->uri->segment(1)==='video'){echo 'active';}?>" title="<?php echo translate('media_new');?>"><?php echo translate('media_new');?><i class="fa fa-sort-desc"></i></a>
											<ul class="dropdown-menu" role="menu">
												<li><a href="<?php echo base_url();?>news" class="dropdown-toggle" title="<?php echo translate('news');?>"><?php echo translate('news');?></a></li>
												<li><a href="<?php echo base_url();?>video" class="dropdown-toggle" title="<?php echo translate('videos');?>"><?php echo translate('videos');?></a></li>
											</ul>
										</li>

										<li><a href="<?php if(!$this->session->userdata('user_id')){ echo base_url('user/login?return=user/categories');}else{echo base_url('user/categories');}?>" class="buynowbut" title="<?php echo translate('add_new_project');?>" ><b>+</b> <?php echo translate('add_new_project');?></a></li>
										
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
