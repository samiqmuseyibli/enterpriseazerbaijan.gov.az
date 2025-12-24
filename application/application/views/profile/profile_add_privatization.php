<div class="content_fullwidth less2">
	<div class="container">
		<div id="pencere" class="logregform two">
			<div class="title">
				<h3><?php echo translate('Privatization');?> </h3>
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
				
				echo form_open(base_url('user/addprivatization/doadd'),array('role' => "form",'method'=>"post",'enctype'=>"multipart/form-data" ));
					?>				
					<!-- Layihənin adı -->
					<div class="row">
						<div class="col-md-12 ">
							<label for="projectName"><?php echo translate('project_name');?> <em>*</em></label>
							<input type="text" name="projectName" id="projectName" required <?php echo form_error('projectName') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('projectName'); ?>"   />
						</div>
					</div>
					<!-- Layihənin adı -->
					
					<div class="clearfix"></div>

					<!-- Qısa Məlumat -->
					<div class="row">
						<div class="col-md-12"><label for="project_info"><?php echo translate('qisa_melumat');?> <em>*</em></label>
						<textarea name="project_info" id="project_info" required class="comment_textarea_bg" style="width:100%; border: 1px solid #<?php echo form_error('project_info') != "" ? 'eb3535' : 'e3e3e3'; ?>;" ><?php echo set_value('project_info'); ?></textarea>
					</div>
						
					</div>
					<!-- Qısa Məlumat -->
				   

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
										<option value="<?php echo $sector['sek_id']; ?>" <?php echo $sector['sek_id'] == set_value('sector') ? 'selected' : null; ?>>
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
							<label for="region"><?php echo translate('Location_Project');?>  <em>*</em></label>                   
							<select name="region" id="region" required <?php echo form_error('region') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> >
								<option value="">- <?php echo translate('choose_one');?> -</option>
								<?php 
									foreach($regions as $region) {
										?>
										<option value="<?php echo $region['reg_id']; ?>" <?php echo $region['reg_id'] == set_value('region') ? 'selected' : null; ?>>
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
						<!-- Nizamnamə kapitalı -->	
						<div class="col-md-6 col-xs-12">
							<label for="charter_capital"><?php echo translate('charter_capital');?>(AZN)<em>*</em></label>
							<input type="number" name="charter_capital" id="charter_capital" min="1" required <?php echo form_error('charter_capital') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('charter_capital'); ?>" />
						</div>
						<!-- Nizamnamə kapitalı -->	
						<!-- Buraxılmış səhmlərin sayı --> 
						<div class="col-md-6 col-xs-12">
							<label for="number_of_issued_stocks"><?php echo translate('number_of_issued_stocks');?>(<?php echo translate('eded');?>) <em>*</em></label>
							<input type="number" name="number_of_issued_stocks" id="number_of_issued_stocks" min="1" required <?php echo form_error('number_of_issued_stocks') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('number_of_issued_stocks'); ?>" />
						</div>
						  
						<!-- Buraxılmış səhmlərin sayı --> 
					</div>
			
					<div class="clearfix"></div>
		

					<div class="row">
						<!-- Bir səhmin nominal dəyəri -->	
						<div class="col-md-6 col-xs-12">
							<label for="nominal_value_of_one_stocks"><?php echo translate('nominal_value_of_one_stocks');?> (AZN)<em>*</em></label>
							<input type="number" name="nominal_value_of_one_stocks" id="nominal_value_of_one_stocks" min="1" required <?php echo form_error('nominal_value_of_one_stocks') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('nominal_value_of_one_stocks'); ?>" />
						</div>
						<!-- Bir səhmin nominal dəyəri -->	
						<!-- Satılan səhm zərfinin həcmi --> 
						<div class="col-md-6 col-xs-12">
							<label for="volume_of_traded_stocks"><?php echo translate('volume_of_traded_stocks');?>(<?php echo translate('eded');?>) <em>*</em></label>
							<input type="number" name="volume_of_traded_stocks" id="volume_of_traded_stocks" min="1" required <?php echo form_error('volume_of_traded_stocks') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('volume_of_traded_stocks'); ?>" />
						</div>
						<!-- Satılan səhm zərfinin həcmi --> 
					</div>

					<div class="clearfix"></div>
					<div class="row">
						<!-- Digər məluamtlar -->  
						<div class="col-md-12"><label for="a_information"><?php echo translate('diger_melumatlar');?></label>
							<textarea name="a_information" id="a_information" class="comment_textarea_bg" style="width:100%; border: 1px solid #<?php echo form_error('a_information') != "" ? 'eb3535' : 'e3e3e3'; ?>;" ><?php echo set_value('a_information'); ?></textarea>
						</div>
						<!-- Digər məluamtlar -->  		
					</div>

					<div class="clearfix"></div>
					<div class="margin_bottom2"></div>

					<div class="row">
						<!-- Unvan -->  	
						<div class="col-md-6">
							<label for="adress"><?php echo translate('Address');?> <em>*</em></label>
							<input type="text" name="adress" id="adress" required <?php echo form_error('adress') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('adress'); ?>" />
						</div>
						<!-- Unvan -->  
						<!-- Muellif -->  
						<div class="col-md-6">
							<label for="author"><?php echo translate('ad_soyad_veya_qurum');?> <em>*</em></label>
  							<input type="text" name="author" id="author" required <?php echo form_error('author') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('author'); ?>" />					
						</div>
						<!-- Muellif -->  
					</div>
					<div class="clearfix"></div>
				
					<div class="row">
						 <!-- videolink -->  
						<div class="col-md-4">
							<label for="youtube_video_link"><?php echo translate('video_link');?> (facebook,youtube,vimeo)  </label>
  							<input type="text" name="youtube_video_link" id="youtube_video_link"  <?php echo form_error('youtube_video_link') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('youtube_video_link'); ?>" />
						</div>
						<!-- videolink -->  
						<!-- Nomre -->  
						<div class="col-md-4">
							<label for="telephone"><?php echo translate('telefon_nomresi');?> (+994001112233) <em>*</em></label>
  							<input type="text" name="telephone" id="telephone" maxlength="15" required <?php echo form_error('telephone') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('telephone'); ?>" />
						</div>
						<!-- Nomre -->  
						<!-- Mail -->  
						<div class="col-md-4">
							<label for="email"><?php echo translate('email');?> </label>
							<input type="email" name="email" id="email" <?php echo form_error('email') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('email'); ?>" />
						</div>
						<!-- Mail --> 
					</div>
					<div class="clearfix"></div>	
					<div class="row">
						<div class="col-md-12">
							<div id="map" style="width:100%; height:400px;"></div>
							<input type="hidden" name="lng" id="lngbox" >
							<input type="hidden" name="lat" id="latbox" >
						</div>
					</div>
					<div class="margin_bottom2"></div>
					<div class="clearfix"></div>
					
					<div class="row">
											<label class="col-sm-4 control-label" for="demo-hor-12"><?php echo translate('images');?></label>

											<div class="col-sm-3">
													<p style="color: red;"><?=translate('you_can_upload_5_image');?></p>
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
					<!-- <div class="row">
						<div class="col-md-12 col-xs-12">
							<div class="col-md-1 col-xs-4" style="padding: 0;margin-right: -25px;">
								<input type="checkbox" name="cf_status" id="cf_status" value="1" />
							</div>
							<div class="col-md-11 col-xs-8" style="padding: 0;">
								<label for="cf_status"><?php echo translate('project_kraudfandinq_checkbox');?></label>
							</div>	
						</div>
					</div> -->
					<button type="submit" class="fbut"><?php echo translate('elave_et');?></button>	
				<?php echo form_close(); ?>			
			
			</div>

		</div>
	</div>
</div><!-- end content area -->

