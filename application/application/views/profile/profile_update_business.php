<div class="content_fullwidth less2">
	<div class="container">
		<div id="pencere" class="logregform two">
			<div class="title">
				<h3><?php echo translate('Business_on_Sale');?></h3>
			</div>
			<div class="feildcont">
				<?php 
				
				if($this->session->flashdata('error_message')){
					?>
					<div class="row">
						<div class="col-md-12 ">
							<div class="errormes">
								<div class="message-box-wrap">
									<?php echo $this->session->flashdata('error_message'); ?>
								</div>
							</div><!-- end box -->
						</div>
					</div>
					<br>
					<br>
					<?php
				};
				
				echo form_open(base_url('user/update_business'),array('role' => "form",'method'=>"post",'enctype'=>"multipart/form-data" ));?>
                    
   	                <input type="hidden" name="lang" value="<?php echo $l?>">
                    <input type="hidden" name="project_id" value="<?php echo $detail['project_id']; ?>">
                    <input type="hidden" name="translation_id" value="<?php echo $detail['translation_id']; ?>">
                    <input type="hidden" name="image_url" value="<?php echo $detail['url_image']; ?>">
					
					<!-- Layihənin adı -->
					<div class="row">
						<div class="col-md-12 ">
							<label for="projectName"><?php echo translate('project_name');?> <em>*</em></label>
							<input type="text" name="projectName" id="projectName" required <?php echo form_error('projectName') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?>  value="<?php echo $detail['project_title']; ?>" />
						</div>
					</div>
					<div class="clearfix"></div>

                   <!-- Qısa Məlumat -->
					<div class="row">
						<div class="col-md-12">
							<label for="project_info"><?php echo translate('qisa_melumat');?> <em>*</em></label>
							<textarea name="project_info" id="project_info" required class="comment_textarea_bg" style="width:100%; border: 1px solid #<?php echo form_error('project_info') != "" ? 'eb3535' : 'e3e3e3'; ?>;" ><?php echo $detail['project_description']; ?></textarea>
						</div>
					</div>
					<div class="clearfix"></div>
					<div class="margin_bottom2"></div>
					
					<div class="row">
						<!-- Sektor -->	
						<div class="col-md-6 col-xs-12">
							<label for="sector"><?php echo translate('Sector_Project');?> <em>*</em></label>
							<select name="sector" id="sector" required <?php echo form_error('sector') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> >
								<option value="">- <?php echo translate('choose_one');?> -</option>
								<?php 
									foreach($sectors as $sector) {
										?>
										<option value="<?php echo $sector['sek_id']; ?>" <?php echo $sector['sek_id'] == $detail['sector_id'] ? 'selected' : null; ?>>
											<?php echo $sector['sek_adi_'.$l.'']; ?>
										</option>
										<?php
									}
								?>
							</select>
							
						</div>
						<!-- Sektor -->	

						<!-- Yerləşdiyi rayon -->
						<div class="col-md-6 col-xs-12">
							<label for="region"><?php echo translate('Location_Project');?> <em>*</em></label>                   
							<select name="region" id="region" required <?php echo form_error('region') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> >
								<option value="">- <?php echo translate('choose_one');?> -</option>
								<?php 
									foreach($regions as $region) {
										?>
										<option value="<?php echo $region['reg_id']; ?>" <?php echo $region['reg_id'] == $detail['region_id'] ? 'selected' : null; ?>>
											<?php echo $region['reg_adi_'.$l.'']; ?>
										</option>
										<?php
									}
								?>
							</select>
							
						</div>
						<!-- Yerləşdiyi rayon -->
					</div>

					<div class="clearfix"></div>
					<div class="margin_bottom2"></div>

					<div class="row">
						<!-- Mülkiyyət forması -->	
						<div class="col-md-6 col-xs-12">
							<label for="property"><?php echo translate('property_form');?> <em>*</em></label>
							<select name="property" id="property" required <?php echo form_error('property') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> >
								<option value="">- <?php echo translate('choose_one');?> -</option>
								<?php 
									foreach($property_type as $property) {
										?>
										<option value="<?php echo $property['property_type_id']; ?>" <?php echo $property['property_type_id'] == $detail['property_type_id'] ? 'selected' : null; ?>>
											<?php echo $property['property_name_'.$l.'']; ?>
										</option>
										<?php
									}
								?>
							</select>
						</div>
						<!--Mülkiyyət forması -->	
						<!--Qiyməti --> 
						<div class="col-md-6 col-xs-12">
							<label for="price"><?php echo translate('price');?> (<?php echo translate('azn');?>) <em>*</em></label>
							<input type="number" name="price" id="price" min="1" required <?php echo form_error('price') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo $detail['price']; ?>" />
						</div>
						<!--Qiyməti --> 
					</div>
					
					<div class="clearfix"></div>
					<div class="row">
						<!-- Digər məluamtlar -->  
						<div class="col-md-12">
							<label for="a_information"><?php echo translate('diger_melumatlar');?></label>
							<textarea name="a_information" id="a_information" required class="comment_textarea_bg" style="width:100%; border: 1px solid #<?php echo form_error('a_information') != "" ? 'eb3535' : 'e3e3e3'; ?>;" ><?php echo $detail['other_important_data']; ?></textarea>
						</div>
						<!-- Digər məluamtlar -->  		
					</div>

					<div class="clearfix"></div>
					<div class="margin_bottom2"></div>

					<div class="row">
						<!-- Unvan -->  	
						<div class="col-md-6">
							<label for="adress"><?php echo translate('Address');?> <em>*</em></label>
							<input type="text" name="adress" id="adress" required <?php echo form_error('adress') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo $detail['adress']; ?>" />
						</div>
						<!-- Unvan -->   
						<!-- Muellif -->  
						<div class="col-md-6">
							<label for="author"><?php echo translate('ad_soyad_veya_qurum');?> <em>*</em></label>
							<input type="text" name="author" id="author" required <?php echo form_error('author') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo $detail['project_author']; ?>" />
						</div>
						<!-- Muellif --> 
					</div>
				
					<div class="clearfix"></div>
					<div class="row">
						<!-- Nomre -->  
						<div class="col-md-6">
							<label for="telephone"><?php echo translate('telefon_nomresi');?> (+994001112233) <em>*</em></label>
							<input type="text" name="telephone" id="telephone" required maxlength="15" <?php echo form_error('telephone') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo $detail['author_telephone']; ?>" />
						</div>
						<!-- Nomre -->  		
						<!-- Mail -->  
						<div class="col-md-6">
							<label for="email"><?php echo translate('email');?> </label>
							<input type="email" name="email" id="email" <?php echo form_error('email') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo $detail['author_email']; ?>" />
						</div>
					   <!-- Mail --> 
					</div>
					<?php
						$this->session->set_userdata('lat',$detail['lat']);
						$this->session->set_userdata('lng',$detail['lng']);
					?>
					<div class="clearfix"></div>
					<div class="row">
						<div class="col-md-12">
							<div id="map" style="width:100%; height:400px;"></div>
							<input type="hidden" name="lng" id="lngbox" value="<?php echo $detail['lng'] ?>" />
							<input type="hidden" name="lat" id="latbox" value="<?php echo $detail['lat'] ?>" />
						</div>
					</div>
					<div class="margin_bottom2"></div>
					<div class="clearfix"></div>
				
					
	<hr>				
<label for="projectName">Şəkillər </label>
<div>
  <?php $images = getProjectImages($detail['project_id']);
  if(!empty($images)){
	  foreach($images as $image){?>
	    
					<div class="delete-div-wrap">
					<span class="close">×</span>
					<div class="inner-div">
					<img class="img-responsive" width="100" src="<?=base_url().$image['files_url'];?>" data-id="<?=$image['files_id'];?>" alt="Project Images">
					</div>
					</div>
	
  <?php } }?>
</div>
<hr>
                                      <div class="row">
                                      	<div class="margin_bottom2"></div>
											<label class="col-sm-4 control-label" for="demo-hor-12">Şəkil əlavə et</label>
											<div class="col-sm-3">
												<input type="file" multiple="" name="images[]" onchange="preview(this);" class="form-control">
												<br><br>
											</div>
										
										<div class="form-group btm_border clearfix" style="height:auto;">
											<div class="col-sm-9">
												<span id="previewImg"></span>
											</div>
										</div>
					                       </div>

	
					
					
					<div class="clearfix"></div>
					<div class="margin_bottom2"></div>
                    <div class="row">
											<?php if($detail['youtube_video_link']!=''){?>
											<label class="col-sm-4 control-label" for="demo-hor-12">Video</label>
											<div class="col-sm-6">
					                         <iframe width="500" height="300" src="<?php echo $detail['youtube_video_link'];?>"></iframe>
										 	</div>										
										    <?php }?>								
										
										 	<label class="col-sm-4 control-label" for="demo-hor-12">Video link</label>
											<div class="col-sm-6">
										   <input type="text" name="youtube_video_link"   value="<?php echo $detail['youtube_video_link']; ?>"/>
											</div>
										

					</div>
					<div class="margin_bottom2"></div>
					
					<div class="row">
						<div class="col-md-12 col-xs-12">
							<div class="col-md-1 col-xs-4" style="padding: 0;margin-right: -25px;">
								<input type="checkbox" checked name="accept" id="agree" required  />
							</div>
							<div class="col-md-11 col-xs-8" style="padding: 0;">
								<label for="agree">
									<?php echo translate('I accept terms and');?>
									<a target="_blank" href="<?php echo base_url('home/termsofuse');?>"><?php echo translate('conditions');?></a>
								</label>
							</div>	
						</div>
					</div>
						
					<div class="clearfix"></div>
					<div class="margin_bottom2"></div>	
					<button type="submit" class="fbut"><?php echo translate('update_project');?></button>	
				<?php echo form_close(); ?>
			
			</div>

		</div>


	</div>
</div><!-- end content area -->
