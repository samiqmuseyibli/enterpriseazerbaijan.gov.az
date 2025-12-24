	<?php include('header.php');?>
    <?php $l=curLang(); ?>
	<?php $_detail=get_site_settings();?>

	  <style type="text/css">
	  	

	  </style>
      <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&key=ApP8eKV-9YlOWD2FyfxDOxqs96N1iHmokcd2bz5CTqvroYmvxUAnbBYt6DlnM6Xb' async defer></script>
      <div id="myMap" style="position:relative;width:100%!importtant;height: 900px;"></div>
      <script type='text/javascript'>
      	<?php if ($this->uri->segment(2) == FALSE): ?>
      		function GetMap() {
		        var map = new Microsoft.Maps.Map('#myMap',
		        {
                  center: new Microsoft.Maps.Location(40.4035268,47.531714),
                  zoom: 8
		        });

		        var center = map.getCenter();
                var iitkm = new Microsoft.Maps.Location(40.3724722,49.8187421);

		        //Create an infobox at the center of the map but don't show it.
		        infobox = new Microsoft.Maps.Infobox(iitkm, {
		            visible: false
		        });

		        //Assign the infobox to a map instance.
		        infobox.setMap(map);

		        //Create a pushpin at a random location in the map bounds.
		        var pin = new Microsoft.Maps.Pushpin(iitkm, {
		            icon: '<?=base_url('assets/front/images/emblem_of_azerbaijan.png');?>',
		            anchor: new Microsoft.Maps.Point(9, 10)
		        });

		        //Store some metadata with the pushpin.
		        pin.metadata = {
		            description: '<img style="float:left; margin-top:0px" src="<?php echo base_url('assets/front/images/GERB_Az-100.png');?>" alt="" ><h5><?php echo translate('IITKM');?></h5><hr>'+
					  '<?php echo $_detail['tel1'];?><br />'+
					  'info@ereforms.gov.az<br />'+
					  '<?php echo $_detail['adress_'.$l.''];?><br />'+
					  '<a target="_blank" style="color: #0088cc;" href="https://ereforms.gov.az/"> www.ereforms.gov.az</a>',
		        };

		        //Add a click event handler to the pushpin.
		        Microsoft.Maps.Events.addHandler(pin, 'click', pushpinClicked);

		        //Add pushpin to the map.
		        map.entities.push(pin);
		    }
		    function pushpinClicked(e) {
		        //Make sure the infobox has metadata to display.
		        if (e.target.metadata) {
		            //Set the infobox options with the metadata of the pushpin.
		            infobox.setOptions({
		            	maxHeight:220,
		            	maxWidth: 300,
		                location: new Microsoft.Maps.Location(40.3724722, 49.8187421),
		                title: e.target.metadata.title,
		                description: e.target.metadata.description,
		                visible: true
		            });
		        }
		    }
      	<?php else: ?>

      		<?php if (!isset($have_map_icon) && $this->uri->segment(2) === 'setcategory'): ?>

                function GetMap() {
		        var map = new Microsoft.Maps.Map('#myMap',
		        {
                  center: new Microsoft.Maps.Location(40.4035268,47.531714),
                  zoom: 8
		        });

		        var center = map.getCenter();


				var pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(40.3724722, 49.8187421), {
		            icon: '<?=base_url('assets/front/images/marker_map.png');?>',
		            anchor: new Microsoft.Maps.Point(10, 10)
		        });

		        //Add the pushpin to the map
		        map.entities.push(pin);

		        var pin2 = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(40.76678189168967, 47.05391428924742), {
		            icon: '<?=base_url('assets/front/images/marker_map.png');?>',
		            anchor: new Microsoft.Maps.Point(10, 10)
		        });

		        //Add the pushpin to the map
		        map.entities.push(pin2);

		         var pin3 = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(40.597704532042776, 49.66254849315208), {
		            icon: '<?=base_url('assets/front/images/marker_map.png');?>',
		            anchor: new Microsoft.Maps.Point(10, 10)
		        });

		        //Add the pushpin to the map
		        map.entities.push(pin3);
		    }
		   	
      		<?php else: ?>
      			             var map, infobox;
                             function GetMap() {
						        map = new Microsoft.Maps.Map('#myMap', {
						        	 center: new Microsoft.Maps.Location(40.4035268,47.531714),
                                     zoom: 8
						        });

						        //Create an infobox at the center of the map but don't show it.
						        infobox = new Microsoft.Maps.Infobox(map.getCenter(), {
						            visible: false
						        });

						        //Assign the infobox to a map instance.
						        infobox.setMap(map);

              <?php  foreach ($detail as $map):  $link = $map['geo_url']; $link_icon = '&#128279; '; ?>
             	<?php if (is_numeric($link)): ?>
						        
							        var pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(<?=$map['geo_lng'];?>, <?=$map['geo_lat'];?>),
							        	{
								            icon: '<?=base_url('assets/front/images/marker_map.png');?>',
								            anchor: new Microsoft.Maps.Point(10, 10)
								        });
						            //Store some metadata with the pushpin.
						            pin.metadata = {
						                description: '<h5><?php echo $map['geo_name_'.$l];?></h5><hr>'+
													'<?php echo $map['geo_description_'.$l];?><br />'+
													'<a target="_blank" style="color: #0088cc;" href="<?php echo base_url();?>project/detail/<?php echo $link; ?>"><?php echo translate('url');?></a>'

						            };



						            //Add a click event handler to the pushpin.
						            Microsoft.Maps.Events.addHandler(pin, 'click', pushpinClicked);

						            //Add pushpin to the map.
						            map.entities.push(pin);
												    

             	<?php else: ?>
             		               var pin = new Microsoft.Maps.Pushpin(new Microsoft.Maps.Location(<?=$map['geo_lng'];?>, <?=$map['geo_lat'];?>),
             		                  	{
								            icon: '<?=base_url('assets/front/images/marker_map.png');?>',
								            anchor: new Microsoft.Maps.Point(9, 10)
								        });

						            //Store some metadata with the pushpin.
						            pin.metadata = {
						                description:    '<h5><?php echo $map['geo_name_'.$l];?></h5><hr>'+
														'<?php echo $map['geo_description_'.$l];?><br />'+
														'<?php if ($link=='#'){?>'+
														'<?php echo '&nbsp;' ?>'+
														'<?php }else{ ?>'+
														'<?php echo $link_icon.'<a href="'.$link.'" target="_blank" style="color: #0088cc;">'.translate('url').'</a>';?>'+
														'<?php };?>'+
														''
	
						            };

						            //Add a click event handler to the pushpin.
						            Microsoft.Maps.Events.addHandler(pin, 'click', pushpinClicked);

						            //Add pushpin to the map.
						            map.entities.push(pin);
             		
             	<?php endif ?>
             	
             <?php endforeach ?>
                            }
                            function pushpinClicked(e) {
						        //Make sure the infobox has metadata to display.
						        if (e.target.metadata) {
						            //Set the infobox options with the metadata of the pushpin.
						            infobox.setOptions({
						                location: e.target.getLocation(),
						                maxHeight:220,
		            	                maxWidth: 300, 
						                title: e.target.metadata.title,
						                description: e.target.metadata.description,
						                visible: true
						            });
						        }
						    }  
                        
      		<?php endif ?>
      		
      	<?php endif ?>
		    
    </script>
	<div class="accord">
		<div class="accordion" style="z-index: 9;">
			<div class="accordion-sectin" >
				<span class="accordion-section-title " style="text-align: center;" ><?php echo translate('Naviqasiya');?></span>
			</div>
			<?php
			foreach($categories as $category) {
				?>
				<div class="accordion-section" style="display:block">
					<a class="accordion-section-title <?php if($cat_id!='' && $cat_id==$category['geo_categories_id']){echo 'active';}?>" href="#accordion-<?php echo $category['geo_categories_id'];?>"><?php echo $category['geo_categories_name_'.$l.''];?> </a>
					<div id="accordion-<?php echo $category['geo_categories_id'];?>" class="accordion-section-content" <?php if($cat_id!='' && ($cat_id==$category['geo_categories_id'] || $cat_id=='set_cat')){?> style="display: block;"<?php }?>>
						<ul style="margin: 0;">
							<?php
								$sub=$this->db->get_where('geo_subcategories',array('geo_categories_id'=>$category['geo_categories_id']))->result_array();
								if($category['geo_categories_id'] == 5){
									$invest = $this->db->where('status', 1)->get('categories')->result_array();
									foreach($invest as $inv){
										//if ($inv['kat_id']!=5) {
											?>
											<li><i class="fa fa-plus-circle" ></i><a href="<?php echo base_url();?>geomap/setcategory/<?php echo $inv['kat_id'];?>" style="cursor:pointer;<?php if($cat_id!='' && $cat_id==$category['geo_categories_id'] && $s_cat_id!='' && $s_cat_id==$inv['kat_id']){?> font-weight: bold;<?php }?>"><?php echo $inv['kat_adi_'.$l.''];?></a></li>
											<?php 
										//}
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
