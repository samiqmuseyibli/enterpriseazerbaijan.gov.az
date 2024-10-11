	<!-- ### footer ### -->
	<div class="clearfix"></div>
	<div class="newsletter">
		<div class="container">
			<div class="one_half">
				<i class="fa fa-envelope-o "></i>
				<h5 class="roboto white"><?php echo translate('our_news'); ?>
					<span class="smallfont light"><?php echo translate('sub_message'); ?></span>
				</h5>
			</div>
			<!-- end section -->
			<div class="one_half last">
				<?php echo $this->session->flashdata('update_datatable'); ?>
				<?php echo form_open(base_url('home/subcribe'), array('id' => "subscribe", 'method' => "post")); ?>
					<input class="enter_email_input" name="subscribeemail" id="subscribeemail" placeholder="<?=translate('enter_email_sbc')?>" onFocus="if(this.value == '') {this.value = '';}" onBlur="if (this.value == '') {this.value = '';}" type="email" />
					<input name="yourname" value="<?php echo translate('subcribe'); ?> " class="input_submit" type="submit" />
				</form>
			</div>
			<!-- end section -->
		</div>
	</div>
	<div class="clearfix"></div>
	<!-- end newsletter section -->
	<footer class="footer">
		<div class="container">
			<div class="one_fourth">
				<div class="qlinks">
					<h4><?php echo translate('useful_links') ?></h4>
					<ul>
						<li><a href="http://www.president.az" target="_blank"><i class="fa fa-angle-right"></i> www.president.az</a></li>
						<li><a href="http://www.ereforms.gov.az" target="_blank"><i class="fa fa-angle-right"></i> www.ereforms.gov.az</a></li>
						<li><a href="https://www.azexport.az" target="_blank"><i class="fa fa-angle-right"></i> www.azexport.az</a></li>
						<li><a href="https://www.dth.az" target="_blank"><i class="fa fa-angle-right"></i> www.dth.az</a></li>
						<li><a href="http://www.economy.gov.az" target="_blank"><i class="fa fa-angle-right"></i> www.economy.gov.az</a></li>
						<li><a href="http://www.azpromo.az" target="_blank"><i class="fa fa-angle-right"></i> www.azpromo.az</a></li>
						<li><a href="http://www.anfes.gov.az" target="_blank"><i class="fa fa-angle-right"></i> www.anfes.gov.az</a></li>
					</ul>
				</div>
			</div>
			<!-- end links -->
			<div class="one_fourth">
				<div class="qlinks">
					<h4><?php echo translate('profile') ?></h4>
					<ul>
						<li><a href="<?php echo base_url(); ?>user/register" target="_blank"><i class="fa fa-angle-right"></i><?php echo translate('sign_up') ?></a></li>
						<li><a href="<?php echo base_url(); ?>user/login" target="_blank"><i class="fa fa-angle-right"></i><?php echo translate('login') ?></a></li>
					</ul>
				</div>
			</div>
			<div class="one_fourth">
				<div class="qlinks">
					<h4><?php echo translate('projects') ?></h4>
					<ul>
						<?php 
							$categories = get_categories();
							foreach ($categories as $category) { 
								?>
								<li>
									<a href="<?php echo base_url('project/category/'); ?><?php echo $category['kat_id'] . '-' . $category['kat_link']; ?>" target="_blank">
										<i class="fa fa-angle-right"></i><?php echo $category['kat_adi_' . $l . ''] ?>
									</a>
								</li>
								<?php 
							}
						?>
					</ul>
				</div>
			</div>
			<!-- end site info -->
			<div class="one_fourth last">
				<ul class="faddress">
					<li><img src="<?php echo base_url(); ?>assets/front/images/logo_new.png" alt="Enterprise Azerbaijan" /></li>
					<li><i class="fa fa-map-marker fa-lg"></i>&nbsp;<?php echo $settings['adress_' . $l . ''] ?></li>
					<li><i class="fa fa-phone"></i>&nbsp; <?php echo $settings['tel1'] ?></li>
					<li><i class="fa fa-print"></i>&nbsp; <?php echo $settings['tel2'] ?> </li>
					<li><i class="fa fa-envelope"></i>&nbsp; <?php echo $settings['mail'] ?></li>
					<li><img src="<?php echo base_url(); ?>assets/front/images/footer-wmap.png" alt="World map" /></li>
				</ul>
			</div>
			<!-- end flickr -->
		</div>
		<!-- end footer -->
		<div class="clearfix"></div>
		<div class="copyright_info">
			<div class="container">
				<div class="clearfix divider_dashed10"></div>
				<div class="one_half"> © | enterpriseazerbaijan.gov.az | <a
							href="<?php echo base_url('home/termsofuse'); ?>"><?php echo translate('Terms_of_Use'); ?></a> |
					<a href="<?php echo base_url('home/privacypolicy'); ?>"><?php echo translate('Privacy_Policy'); ?></a>
				</div>
				<div class="one_half last">
					<ul class="footer_social_links">
						<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="https://www.facebook.com/enterpriseazerbaijan/" target="_blank"><i class="fa fa-facebook"></i></a></li>
						<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-twitter"></i></a></li>
						<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-linkedin"></i></a></li>
						<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-youtube"></i></a></li>
						<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-rss"></i></a></li>
						<!--
						<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-google-plus"></i></a></li>
						<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-skype"></i></a></li>
						<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-flickr"></i></a></li>
						<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-html5"></i></a></li>
						-->
					</ul>
				</div>
			</div>
		</div>
	</footer>
	<!-- end footer section  -->
	<a href="#" class="scrollup">Scroll</a><!-- end scroll to top of the page-->
</div>
<!-- ######### JS FILES ######### -->
<!-- get jQuery used for the theme -->
<script src="<?php echo base_url(); ?>assets/front/js/universal/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/animations/js/animations.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/mainmenu/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/mainmenu/customeUI.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/mainmenu/sticky.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/accordion.js"></script>
<script src="<?php echo base_url(); ?>assets/front/js/scrolltotop/totop.js"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="<?php echo base_url(); ?>assets/front/js/owl.carousel.js"></script>
<script type="text/javascript">
	jQuery(function ($) {

    'use strict';

      // --------------------------------------------------------------------
    // Owl Carousel Video Slider
    // --------------------------------------------------------------------

    (function() {
        $('.owl-carousel').owlCarousel({
            nav:false,
            loop:true,
            center:false,
            autoplay:true,
            autoplayHoverPause:true,
            mouseDrag:true,
            dots:true,
            margin:10,
           
            lazyLoad:true,
         
            responsive:{
                0:{
                    items:1
                },
                600:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        });

    }());

}); // JQuery end
</script>
<script>
	function reloadCaptcha(){
		$('.img-captcha').attr('src','<?php echo base_url().'user/getCaptcha?';?>'+$.now());
	}
</script>
<script src="<?php echo base_url(); ?>assets/front/js/sweetalert/sweetalert.min.js"></script>
<?php if ($this->session->flashdata('succes_message')): ?>
    <script>
        swal({
            title: "<?php echo translate('succes');?>",
            text: "<?php echo $this->session->flashdata('succes_message'); ?>",
            icon: "success",
            button: "Ok",
        });
    </script>
<?php endif; ?>
<?php if ($this->session->flashdata('error_message')): ?>
    <script>
        swal({
            title: "<?php echo translate('error');?>",
            text: "<?php echo $this->session->flashdata('error_message'); ?>",
            icon: "error",
            button: "OK",
        });
    </script>
<?php endif; ?>
<?php
if ($this->session->userdata('lat') and $this->session->userdata('lng')) {?>
<script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=AkTOGppyh5Lihh8Zc32vn5I_YC930xe9KjCt53JptiWBtoPb2CbJKYaAbdUC9Cr8' async defer></script>
<script type="text/javascript">
	         function GetMap() {
		        var map = new Microsoft.Maps.Map('#map',
		        {
                  center: new Microsoft.Maps.Location(<?=$this->session->userdata('lat')?>, <?=$this->session->userdata('lng')?>),
                  zoom: 10,
                  // disableZooming: true,
                  // disableScrollWheelZoom: true
		        });

		        var center = map.getCenter();


				var pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(<?=$this->session->userdata('lat')?>, <?=$this->session->userdata('lng')?>), {
		            icon: '<?=base_url('assets/front/images/marker_map.png');?>',
		            anchor: new Microsoft.Maps.Point(10, 10)
		        });

		        //Add the pushpin to the map
		        map.entities.push(pin);

		    }
</script>
<?php } ?>
</body>
</html>