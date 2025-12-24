  
			<!-- ### footer ### -->
			<div class="clearfix"></div> 
			<div class="copyright_info">
				<div class="container">
					<div class="clearfix divider_dashed10"></div>
					<div class="one_half"> © | enterpriseazerbaijan.gov.az | <a href="<?php echo base_url('home/termsofuse');?>"><?php echo translate('Terms_of_Use');?></a> | <a href="<?php echo base_url('home/privacypolicy');?>"><?php echo translate('Privacy_Policy');?></a></div>
					<div class="one_half last">
						<ul class="footer_social_links">
							<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="https://www.facebook.com/enterpriseazerbaijan/" target="_blank"><i class="fa fa-facebook"></i></a></li>
							<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-twitter"></i></a></li>
							<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-linkedin"></i></a></li>
							<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-youtube"></i></a></li>
							<li class="animate" data-anim-type="zoomIn" data-anim-delay="200"><a href="#"><i class="fa fa-rss"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</footer>
		<!-- end footer section  -->
		<a href="#" class="scrollup">Scroll</a><!-- end scroll to top of the page-->
    </div>
    <!-- ######### JS FILES ######### --> 
    <script src="<?php echo base_url();?>assets/front/js/animations/js/animations.min.js" ></script>
    <script src="<?php echo base_url();?>assets/front/js/mainmenu/bootstrap.min.js" ></script>
    <script src="<?php echo base_url();?>assets/front/js/mainmenu/customeUI.js" ></script> 
    <script src="<?php echo base_url();?>assets/front/js/mainmenu/sticky.js" ></script>
	<script src="<?php echo base_url();?>assets/front/js/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript">
           $('.delete-div-wrap .close').on('click', function() {
        		var pid = $(this).closest('.delete-div-wrap').find('img').data('id');
        		var here = $(this);
        		$.ajax({
        			url: "<?php echo base_url(); ?>" + 'user/deletefile/' + pid,
        			cache: false,
        			success: function(data) {
        				if (data == 'done') {
        					swal({
				           title: "Image Delete",
				           text: "Successfully",
				           icon: "success",
				            button: "Ok",
			                });
        					here.closest('.delete-div-wrap').remove();
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

           
	window.preview = function (input) {
        if (input.files && input.files[0]) {
            $("#previewImg").html('');
            $(input.files).each(function () {
                var reader = new FileReader();
                reader.readAsDataURL(this);
                reader.onload = function (e) {
                    $("#previewImg").append("<div style='float:left;border:4px solid #303641;padding:5px;margin:5px;'><img height='80' src='" + e.target.result + "'></div>");
                }
            });
        }
    }
</script>
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
	 <link rel="stylesheet" href="<?=base_url();?>assets/front/css/gis_esri.css" />
     <script src="<?=base_url();?>assets/front/js/gis_map.js"></script>
    <script>
      require([
        "esri/Map",
        "esri/views/MapView",
        "esri/Graphic",
        "esri/widgets/Search",
        "esri/tasks/Locator",
      ], function (Map, MapView, Graphic, Search, Locator) {
        var map = new Map({
          basemap: "topo",
        });

        var view = new MapView({
          container: "map",
          map: map,
          <?php if ($this->session->userdata('lat') and $this->session->userdata('lng')): ?>
          center: [<?=$this->session->userdata('lng').' , '.$this->session->userdata('lat')?>],
          <?php else: ?>
          center: [49.0803232,40.4975941],
          <?php endif ?>
          zoom: 8,
        });

        var search = new Search({
          view: view,
        });
        //search.defaultSource.withinViewEnabled = false; // Limit search to visible map area only
        view.ui.add(search, "top-right"); // Add to the map
        <?php if ($this->session->userdata('lat') and $this->session->userdata('lng')): ?>
         var graphic = new Graphic({
            geometry: {
              type: "point",
              latitude: <?=$this->session->userdata('lat')?>,
              longitude: <?=$this->session->userdata('lng')?>,
              spatialReference: view.spatialReference,
            },
            symbol: {
              type: "simple-marker", // autocasts as new SimpleFillSymbol
              color: [255, 10, 10],
              outline: {
                // autocasts as new SimpleLineSymbol()
                color: [255, 255, 255],
                width: 4,
              },
            },
          });
         view.graphics.add(graphic);
        <?php endif ?>
        view.on("click", function (evt) {
          // Create a graphic and add the geometry and symbol to it
          var graphic = new Graphic({
            geometry: {
              type: "point",
              latitude: evt.mapPoint.latitude,
              longitude: evt.mapPoint.longitude,
              spatialReference: view.spatialReference,
            },
            symbol: {
              type: "simple-marker", // autocasts as new SimpleFillSymbol
              color: [255, 10, 10],
              outline: {
                // autocasts as new SimpleLineSymbol()
                color: [255, 255, 255],
                width: 4,
              },
            },
          });
          view.graphics.removeAll();
          view.graphics.add(graphic);
          document.getElementById("latbox").value = evt.mapPoint.latitude;
		  document.getElementById("lngbox").value = evt.mapPoint.longitude;
          search.search(evt.mapPoint);
          search.resultGraphicEnabled = false;
        });
      });
    </script>
  </body>
</html>
