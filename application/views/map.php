	<?php include('header.php');?>
    <?php $l=curLang(); ?>
	<?php $_detail=get_site_settings();?>
	<script src="https://api-maps.yandex.ru/2.1/?lang=en_AZ&amp;apikey=62b4a617-6fea-4847-a58a-c3bd7972b96d" type="text/javascript"></script>
	<style>
        html, body, #map {
            width: 100%; height: 900px; padding: 0; margin: 0;
        }
    </style>
    <script type="text/javascript">
    	<?php if ($this->uri->segment(2) == FALSE): ?>
		   ymaps.ready(function () {
			    var myMap = new ymaps.Map('map', {
			            center: [40.4035268,47.531714],
			            zoom: 8
			        },),

			     

			        myPlacemarkWithContent = new ymaps.Placemark([40.3724722,49.8187421], {
			            hintContent: '<?php echo translate('IITKM');?>',
			            balloonContent: '<img style="float:left; margin-top:0px" src="<?php echo base_url('assets/front/images/GERB_Az-100.png');?>" alt="" ><h5><?php echo translate('IITKM');?></h5><hr>'+
					  '<?php echo $_detail['tel1'];?><br />'+
					  'info@ereforms.gov.az<br />'+
					  '<?php echo $_detail['adress_'.$l.''];?><br />'+
					  '<a target="_blank" style="color: #0088cc;" href="https://ereforms.gov.az/"> www.ereforms.gov.az</a>',
			            //iconContent: '12'
			        }, {
			            /**
			             * Options.
			             * You must specify this type of layout.
			             */
			            iconLayout: 'default#imageWithContent',
			            // Custom image for the placemark icon.
			            iconImageHref: '<?=base_url('assets/front/images/emblem_of_azerbaijan.png');?>',
			            // The size of the placemark.
			            iconImageSize: [25, 30],
			            /**
			             * The offset of the upper left corner of the icon relative
			             * to its "tail" (the anchor point).
			             */
			            iconImageOffset: [-30, -30],
			            // Offset of the layer with content relative to the layer with the image.
			            iconContentOffset: [15, 15],
			           
			        });

			        myMap.geoObjects
			        .add(myPlacemarkWithContent);
			});
    <?php else: ?>

	     	 ymaps.ready(init);

					function init() {
					    var myMap = new ymaps.Map("map", {
					            center: [40.4035268,47.531714],
			                   zoom: 8
					        }, {
					            searchControlProvider: 'yandex#search'
					        });

					        myMap.geoObjects
                            <?php if (!isset($have_map_icon) && $this->uri->segment(2) === 'setcategory'): ?>
							   .add(new ymaps.Placemark([40.3724722, 49.8187421], {
						            //balloonContent: 'the color of <strong>Surprise Dauphin</strong>'
						        }, {
	                                iconColor: '#834b9b',
						            iconCaptionMaxWidth: '100'
						        }))

							   .add(new ymaps.Placemark([40.76678189168967, 47.05391428924742], {
						            //balloonContent: 'the color of <strong>Surprise Dauphin</strong>'
						        }, {
	                                iconColor: '#834b9b',
						            iconCaptionMaxWidth: '100'
						        }))

							   .add(new ymaps.Placemark([40.597704532042776, 49.66254849315208], {
						            //balloonContent: 'the color of <strong>Surprise Dauphin</strong>'
						        }, {
	                                iconColor: '#834b9b',
						            iconCaptionMaxWidth: '100'
						        }))
	                        <?php else: ?>
					        <?php  foreach ($detail as $map):  $link = $map['geo_url']; $link_icon = '&#128279; '; ?>
					        
					        .add(new ymaps.Placemark([<?=$map['geo_lng'];?>, <?=$map['geo_lat'];?>], {
					        	<?php if (is_numeric($link)): ?>
                                balloonContent: '<h5><?php echo $map['geo_name_'.$l];?></h5><hr>'+
													'<?php echo $map['geo_description_'.$l];?><br />'+
													'<a target="_blank" style="color: #0088cc;" href="<?php echo base_url();?>project/detail/<?php echo $link; ?>"><?php echo translate('url');?></a>',
					            <?php else: ?>
					            balloonContent: '<h5><?php echo $map['geo_name_'.$l];?></h5><hr>'+
														'<?php echo $map['geo_description_'.$l];?><br />'+
														'<?php if ($link=='#'){?>'+
														'<?php echo '&nbsp;' ?>'+
														'<?php }else{ ?>'+
														'<?php echo $link_icon.'<a href="'.$link.'" target="_blank" style="color: #0088cc;">'.translate('url').'</a>';?>'+
														'<?php };?>'+
														'',
								<?php endif ?>
					            iconCaption: '<?php echo $map['geo_name_'.$l];?>'
					        }, {
                                iconColor: '#834b9b',
					            iconCaptionMaxWidth: '70'
					        }))

					        <?php endforeach ?>
	                        <?php endif ?>
	                }
    		
    <?php endif ?>
    </script>
    <div id="map"></div>
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
