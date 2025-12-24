	<?php include('header.php');?>
	
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<br />
	<div style="margin-left:400px"<?php  print_r($detail);?></div>
	
	<div class="clearfix"></div>
	<script src="https://www.google.com/jsapi"></script>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> 
	
	<script src="https://cdn.rawgit.com/openlayers/openlayers.github.io/master/en/v5.2.0/build/ol.js"></script>
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
	<div id="mapdiv" style="width:100%;margin-top:85px !important; height:125vh;"></div>
	<br />
	<div id="myposition"></div>
	<div id="popup"></div>
	<?php $_detail=get_site_settings();?>
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/openlayers/2.11/lib/OpenLayers.js"></script> -->
    <script type="text/javascript">
	
		// Declare a Tile layer with an OSM source
        var osmLayer = new ol.layer.Tile({
          source: new ol.source.OSM()
        });
		
        // Create latitude and longitude and convert them to default projection
        var azerbaijan = ol.proj.transform([46.9997602, 39.3725721], 'EPSG:4326', 'EPSG:3857');
		
        // Create a View, set it center and zoom level
        var view = new ol.View({
			center: azerbaijan,
			zoom: 7.9,
			priority: 1,
			minZoom: 7,
			maxZoom: 20
        });
		
        // Instanciate a Map, set the object target to the map DOM id
        var map = new ol.Map({
          target: 'mapdiv',
		  interactions: ol.interaction.defaults({
			shiftDragZoom: false
			}).extend([new ol.interaction.DragRotateAndZoom()])
        });
        // Add the created layer to the Map
        map.addLayer(osmLayer);
        // Set the view for the map
        map.setView(view);

		//Adding a marker on the map
		
		
		var iconFeature = new ol.Feature({
			geometry: new ol.geom.Point(ol.proj.transform([49.8187421, 40.3724722], 'EPSG:4326', 'EPSG:3857')),
			name: 'Null Island',
			population: 4000,
			rainfall: 500
		});


		var iconStyle = new ol.style.Style({
		  image: new ol.style.Icon(/** @type {olx.style.IconOptions} */ ({
			anchor: [0.5, 22],
			anchorXUnits: 'fraction',
			anchorYUnits: 'pixels',
			opacity: 0.75,
			src: '<?php echo base_url('assets/front/images/emblem_of_azerbaijan.png');?>',
			rotation: 0
		  }))
		});

		iconFeature.setStyle(iconStyle);

		var vectorSource = new ol.source.Vector({
		  features: [iconFeature]
		});

		var vectorLayer = new ol.layer.Vector({
		  source: vectorSource
		});
		
		map.addLayer(vectorLayer);

		/*
		var feature = new ol.Feature({
			geometry: new ol.geom.Point(
				ol.proj.fromLonLat([49.8187421,40.3724722]),
				// IITKM location 				
			), 
			name: 'Null Island',
			population: 4000,
			rainfall: 500			
		});
		
		feature.setStyle(new ol.style.Style({
			image: new ol.style.Icon(({
				anchor: [0.5, 22],
				anchorXUnits: 'fraction',
				anchorYUnits: 'pixels',
				opacity: 0.75,
				src: '<?php echo base_url('assets/front/images/emblem_of_azerbaijan.png');?>',
				rotation: 0
			}))
		}));
		
		var vectorSource = new ol.source.Vector({
			features: [feature]
		});
		var markerVectorLayer = new ol.layer.Vector({
			source: vectorSource,
		});
		map.addLayer(markerVectorLayer);
		*/
		

		/*
		var feature = new ol.Feature(
			geometry: new ol.geom.
			new ol.Geometry.Point( 49.8125721, 40.3787602).transform(epsg4326, projectTo),
				{description:'<div id="content">'+
					'<div id="siteNotice">'+
					'</div>'+
					'<h3 id="firstHeading" class="firstHeading"><?php echo translate('IITKM');?></h3>'+
					'<div id="bodyContent">'+ 
					'<p><?php echo translate('Telephone');?>:<?php echo $_detail['tel1'];?></p>'+
					'<p><?php echo translate('email');?>:info@ereforms.org</p>'+
					'<p><?php echo translate('Address');?>:<?php echo $_detail['adress_'.$l.''];?></p>'+
					'<p><?php echo translate('website:');?><a target="_blank" href="http://iqtisadiislahat.org/"> www.iqtisadiislahat.org</a></p>'+
					'</div>'+
					'</div>'} ,
				{externalGraphic: '<?php echo base_url('assets/front/images/emblem_of_azerbaijan.png');?>', graphicHeight: 20, graphicWidth: 20, graphicXOffset:-12, graphicYOffset:-25  }
		);    
		vectorLayer.addFeatures(feature);
		*/
		
		// ************************ //
		
		<?php foreach($detail as $map) {
			?>
			var feature = new OpenLayers.Feature.Vector(
				<?php if(is_numeric($map['geo_url'])){
				?>
				new OpenLayers.Geometry.Point( <?php echo ($map['geo_lat']=='')?'46.8187602':$map['geo_lat'];?>, <?php echo ($map['geo_lat']=='')?'38.5725721':$map['geo_lng'];?>).transform(epsg4326, projectTo),
					{description:'<div id = "info_window" class="info_content col-md-12">'+
									'<div class="col-md-12" style="min-width:300px; mix-width:420px; min-height:80px; ">'+
										'<h4><?php echo $map['geo_name_'.$l];?></h4>'+
										'<a target="_blank" href="<?php echo base_url();?>project/detail/<?php echo $map['geo_url'];?>">'+
											'<p style="float: left;"><b><?php echo translate('url');?></b></p>'+
										'</a>'+
									'</div>'+
								'</div>'} ,
					{externalGraphic: 'http://icon-park.com/imagefiles/location_map_pin_red5.png', graphicHeight: 20, graphicWidth: 20, graphicXOffset:-12, graphicYOffset:-25  }
		    );
				
				<?php 
				}else{?>
					new OpenLayers.Geometry.Point( <?php echo $map['geo_lat'];?>, <?php echo $map['geo_lng'];?>).transform(epsg4326, projectTo),
					{description:'<div id = "info_window" class="info_content col-md-12"><div class="col-md-12" style="min-width:300px; max-width:420px"><h4><?php echo $map['geo_name_'.$l];?></h4><p><?php echo $map['geo_description_'.$l];?></p><a target="_blank" href="<?php echo $map['geo_url'];?>"><p style="float: left;"><b><?php echo translate('url');?></b></p></a></div></div>'} ,
					{externalGraphic: 'http://icon-park.com/imagefiles/location_map_pin_red5.png', graphicHeight: 30, graphicWidth: 27, graphicXOffset:-12, graphicYOffset:-25  }
		    );  
				<?php 
				}?>
			vectorLayer.addFeatures(feature);
		
			<?php 
		}?>
		
	    // ********************* //
		
		
		map.addLayer(vectorLayer);
		//Add a selector control to the vectorLayer with popup functions
		var controls = {
		  selector: new OpenLayers.Control.SelectFeature(vectorLayer, { onSelect: createPopup, onUnselect: destroyPopup })
		};

		function createPopup(feature) {
		  feature.popup = new OpenLayers.Popup.FramedCloud("pop",
			  feature.geometry.getBounds().getCenterLonLat(),
			  null,
			  '<div class="markerContent">'+feature.attributes.description+'</div>',
			  null,
			  true,
			  function() { controls['selector'].unselectAll(); }
		  );
		  //feature.popup.closeOnMove = true;
		  map.addPopup(feature.popup);
		}

		function destroyPopup(feature) {
		  feature.popup.destroy();
		  feature.popup = null;
		}
		
		map.addControl(controls['selector']);
		controls['selector'].activate();
		
		//########## Cluster ##############
			
		 
		//########## Cluster ##############
	</script>
	<script>
		$(document).ready(function(){
			 $(".ol-zoom").css('left','97%');
		})
	</script>
	<div class="accord">
		<div class="accordion" style="z-index: 9999;">
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
											<li><i class="fa fa-plus-circle" ></i><a href="<?php echo base_url();?>geomap/setcategory/<?php echo $inv['kat_id'];?>" style="cursor:pointer;<?php if($cat_id!='' && $cat_id==$category['geo_categories_id'] && $s_cat_id!='' && $s_cat_id==$inv['kat_id']){?> font-weight: bold;<?php }?>"><?php echo $inv['kat_adi_'.$l.''];?></a></li>
											<?php 
										}
									}
								}elseif($category['geo_categories_id'] == 9){ 
									?>
									<li><i class="fa fa-plus-circle" ></i><a href="<?php echo base_url();?>geomap/setcompany" style="cursor:pointer;"><?php echo translate('Companies');?></a></li>
									<?php  
								}else{
									foreach($sub as $sub_cat){
										?>
										<li><i class="fa fa-plus-circle" ></i><a href="<?php echo base_url();?>geomap/set/<?php echo $category['geo_categories_id'];?>/<?php echo $sub_cat['geo_subcategories_id'];?>" style="cursor:pointer;<?php if($cat_id!='' && $cat_id==$category['geo_categories_id'] && $s_cat_id!='' && $s_cat_id==$sub_cat['geo_subcategories_id']){?> font-weight: bold;<?php }?>"><?php echo $sub_cat['geo_subcategories_name_'.$l];?></a></li>
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
