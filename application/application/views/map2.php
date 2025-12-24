	<?php include('header.php');?>
	<div class="clearfix"></div>
	<script src="https://www.google.com/jsapi"></script>
	<script  src="<?php echo base_url();?>assets/front/js/mapcluster.js"></script>
	<?php
		$lang=$this->session->userdata('language');
		if ($lang==='Azerbaijan') {
			$l='az';
		}if ($lang==='Russian') {
			$l='ru';
		}if ($lang==='English') {
			$l='en';
		}
	?>
	<div id="map" style="width:100%;margin-top:85px; height:170vh;"></div>
	<script>
		var geo_details = [
			<?php 
			foreach($detail as $row){
				$title 			= $row['geo_name_'.$l];
				if(is_numeric($row['geo_url'])){$link=base_url().'project/detail/'.$row['geo_url'];}else{$link=$row['geo_url'];}
				$lng 			= $row['geo_lng'];
				$lat 			= $row['geo_lat'];
				$description 	= $row['geo_description_'.$l];
				?>
				['<?php echo $title;  ?>','<?php echo $description;  ?>',"<?php echo $link; ?>", <?php echo $lng;  ?>, <?php echo $lat;  ?>],
				<?php
			}
			?> 
		];
		function search_loc(){
			geo_details_new = geo_details;
			initialize(geo_details_new);
		}
		google.load('maps', '3', {
			other_params: 'key=AIzaSyA3pPOJFYvDgiNhHWY7GwWpndYUZ8bm8iE'
		});
				
		google.setOnLoadCallback(search_loc);
		var styles = [
			[{
				url: '../images/conv30.png',
				height: 27,
				width: 30,
				anchor: [3, 0],
				textColor: '#ff00ff',
				opt_textSize: 10
			}, {
				url: '../images/conv40.png',
				height: 36,
				width: 40,
				opt_anchor: [6, 0],
				opt_textColor: '#ff0000',
				opt_textSize: 11
			}, {
				url: '../images/conv50.png',
				width: 50,
				height: 45,
				opt_anchor: [8, 0],
				opt_textSize: 12
			}],
			[{
				url: '../images/heart30.png',
				height: 26,
				width: 30,
				opt_anchor: [4, 0],
				opt_textColor: '#ff00ff',
				opt_textSize: 10
			}, {
				url: '../images/heart40.png',
				height: 35,
				width: 40,
				opt_anchor: [8, 0],
				opt_textColor: '#ff0000',
				opt_textSize: 11
			}, {
				url: '../images/heart50.png',
				width: 50,
				height: 44,
				opt_anchor: [12, 0],
				opt_textSize: 12
			}]
		];
		var markerClusterer = null;
		var map = null;
		var imageUrl = 'https://chart.apis.google.com/chart?cht=mm&chs=24x32&'+'chco=FF0000,FF0000,FF0000&ext=.png';
		//$('#vendors_list').on('shown.bs.modal', function (e) {
		//})
		function refreshMap(geo_details) {
			//if (markerClusterer) {
			//  markerClusterer.clearMarkers();
			//}
			var markers = [];
			var infoWindows = [];
			var markerImage = new google.maps.MarkerImage(imageUrl,
			new google.maps.Size(24, 32));
			var bound = new google.maps.LatLngBounds();
			// Loop through our array of markers & place each one on the map
			for (i = 0; i < geo_details.length; i++) {
				var latLng = new google.maps.LatLng(geo_details[i][3], geo_details[i][4])
				var marker = new google.maps.Marker({
					position: latLng,
					draggable: false,
					icon: markerImage,
					animation: google.maps.Animation.DROP,
					infoWindowIndex: i
				});
				bound.extend(new google.maps.LatLng(geo_details[i][3], geo_details[i][4]));
				var saytlink=geo_details[i][2];
				
				if(saytlink == '#'){
					var content = '<div id = "info_window" class="info_content col-md-12">' +
					'<div class="col-md-12" style="min-width:310px;">' +
					'<h3>' + geo_details[i][0] + '</h3>' +
					'<p>' + geo_details[i][1] + '</p>'+
					'</div></div>';
				}else{
					var content = '<div id = "info_window" class="info_content col-md-12">' +
					'<div class="col-md-12" style="min-width:310px;">' +
					'<h3>' + geo_details[i][0] + '</h3>' +
					'<p>' + geo_details[i][1] + '</p>'+
					'<a target="_blank" href="'+saytlink+'"><p style="float: left;"><b><?php echo translate('url');?></b></p></a>'+
					'</div></div>';
				}
					
				var infoWindow = new google.maps.InfoWindow({
					content: content
				});

				google.maps.event.addListener(
					marker, 'click',
					function(event) {
						// $('#info_window').css('display','none');
						// infoWindow.close();
						//infoWindows[this.infoWindowIndex].open(map, marker);
						var x=0;
						x=this.infoWindowIndex;
						//alert(x);
						for (i = 0; i < geo_details.length; i++) {
							if(i == x){
								infoWindows[this.infoWindowIndex].open(map, this);
							}else{
								infoWindows[i].close();}
						}
					}
				);
				infoWindows.push(infoWindow);
				markers.push(marker);
			}
			var zoom = parseInt(16);
			var size = parseInt(40);
			var style = parseInt(-1);

			markerClusterer = new MarkerClusterer(map, markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'});
			//map.setCenter(bound.getCenter())
			//map1.setCenter(bound1.getCenter())
			map.fitBounds(bound);
		}
		
		function initialize(geo_details){
		   
			map = new google.maps.Map(document.getElementById('map'),{  
				zoom: 8,
				center: new google.maps.LatLng('39.5725721','47.8187602'),
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var image={
				url: '<?php echo base_url('assets/front/images/emblem_of_azerbaijan.png');?>',
			};
			var marker = new google.maps.Marker({
				position: new google.maps.LatLng('40.3725721','49.8187602'),
				map: map,
				icon: image,
				title:'<?php echo translate('IITKM');?>'
			});
			<?php $detail=get_site_settings();?>
			var contentString = '<div id="content">'+
				'<div id="siteNotice">'+
				'</div>'+
				'<h3 id="firstHeading" class="firstHeading"><?php echo translate('IITKM');?></h3>'+
				'<div id="bodyContent">'+ 
				'<p><?php echo translate('Telephone');?>:<?php echo $detail['tel1'];?></p>'+
				'<p><?php echo translate('email');?>:info@ereforms.org</p>'+
				'<p><?php echo translate('Address');?>:<?php echo $detail['adress_'.$l.''];?></p>'+
				'<p><?php echo translate('website:');?>  <a  target="_blank" href=http://iqtisadiislahat.org/">'+
				'www.iqtisadiislahat.org</a> '+
				'</p>'+
				'</div>'+
				'</div>';

			var infowindow = new google.maps.InfoWindow({
				content: contentString
			});

			marker.addListener('click', function() {
				infowindow.open(map, marker);
			});
			var stylesr = [
			  {
				stylers: [
				  { hue: '#00ffe6' },
				  { saturation: -20 }
				]
			  },{
				featureType: "road",
				elementType: "geometry",
				stylers: [
				  { lightness: 100 },
				  { visibility: "simplified" }
				]
			  },{
				featureType: "road",
				elementType: "labels",
				stylers: [
				  { visibility: "off" }
				]
			  }
			];
			//map.setOptions({styles: stylesr});
			if (geo_details!='') { refreshMap(geo_details);}
		}
		function clearClusters(e) {
			e.preventDefault();
			e.stopPropagation();
			markerClusterer.clearMarkers();
		}
	</script>
	<div class="accord">
		<div class="accordion">
			<div class="accordion-sectin" >
				<span class="accordion-section-title " style="text-align: center;" ><?php echo translate('Naviqasiya');?></span>
			</div>
			<?php
			$lang=$this->session->userdata('language');
			if ($lang==='Azerbaijan') {
				$l='az';
			}if ($lang==='Russian') {
				$l='ru';
			}if ($lang==='English') {
				$l='en';
			}
			foreach($categories as $category) {
				?>
				<div class="accordion-section">
					<a class="accordion-section-title <?php if($cat_id!='' && $cat_id==$category['geo_categories_id']){echo 'active';}?>" href="#accordion-<?php echo $category['geo_categories_id'];?>"><?php echo $category['geo_categories_name_'.$l.''];?> </a>
					<div id="accordion-<?php echo $category['geo_categories_id'];?>" class="accordion-section-content" <?php if($cat_id!='' && ($cat_id==$category['geo_categories_id'] || $cat_id=='set_cat')){?> style="display: block;"<?php }?>>
						<ul style="margin: 0;">
							<?php
								$sub=$this->db->get_where('geo_subcategories',array('geo_categories_id'=>$category['geo_categories_id']))->result_array();
								if($category['geo_categories_id'] == 5){
									$invest = $this->db->get('categories')->result_array();
									foreach($invest as $inv){
										if ($inv['kat_id']!=5) {?>
											<li><i class="fa fa-plus-circle" ></i><a href="<?php echo base_url();?>geomap2/setcategory/<?php echo $inv['kat_id'];?>" style="cursor:pointer;<?php if($cat_id!='' && $cat_id==$category['geo_categories_id'] && $s_cat_id!='' && $s_cat_id==$inv['kat_id']){?> font-weight: bold;<?php }?>"><?php echo $inv['kat_adi_'.$l.''];?></a></li>
											<?php 
										}
									}
								}elseif($category['geo_categories_id'] == 9){ 
									?>
									<li><i class="fa fa-plus-circle" ></i><a href="<?php echo base_url();?>geomap2/setcompany" style="cursor:pointer;"><?php echo translate('Companies');?></a></li>
									<?php  
								}else{
									foreach($sub as $sub_cat){
										?>
										<li><i class="fa fa-plus-circle" ></i><a href="<?php echo base_url();?>geomap2/set/<?php echo $category['geo_categories_id'];?>/<?php echo $sub_cat['geo_subcategories_id'];?>" style="cursor:pointer;<?php if($cat_id!='' && $cat_id==$category['geo_categories_id'] && $s_cat_id!='' && $s_cat_id==$sub_cat['geo_subcategories_id']){?> font-weight: bold;<?php }?>"><?php echo $sub_cat['geo_subcategories_name_'.$l];?></a></li>
										<?php 
									}
								}
							?>
						</ul>
					</div>
				</div>
				<?php 
			}
			?>
		</div>
	</div>
	<?php include('footer_map.php');?>
