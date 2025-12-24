<?php $l=curLang();?>
<div class="content_fullwidth less2">
	<div class="container">
		<div id="pencere" class="logregform two">
			<div class="title">
				<h3>Investisiya Layihesi</h3>
				
			</div>
			
			<div class="feildcont">
	<?php echo form_open(base_url('moderator/translate_investment'),array('role' => "form",'method'=>"post",'enctype'=>"multipart/form-data" ));?>			
             
                       	 <?php foreach ($translation as $translation_row){ ?>	
   	                  <input type="hidden" name="lang" value="<?php echo $l?>">
                      <input type="hidden" name="project_id" value="<?php echo $detail['project_id']; ?>">
                      <input type="hidden" name="user_id" value="<?php echo $detail['user_id']; ?>">
                      <input type="hidden" name="translation_id" value="<?php echo $translation_row['translation_id']; ?>">
                      <input type="hidden" name="image_url" value="<?php echo $detail['url_image']; ?>">
					<div class="row">
                           
                    <!-- Layihənin adı -->
					<div class="row">
						<div class="col-md-12 ">
							<label for="projectName" style="color: green">Layihənin adı(az) <em>*</em></label>
							<input type="text" name="projectName_az" id="projectName"  value="<?php if ($translation_row['lang_code']!='az'){}else{echo $translation_row['project_title'];} ?>" required />
						</div>
					</div>
                   <!-- Layihənin adı -->
					<div class="clearfix"></div>
                  <!-- Qısa Məlumat -->
					<div class="row">
						<div class="col-md-12"><label style="color: green" for="project-info">Qısa məlumat (az)<em>*</em></label>
						<textarea name="project_info_az" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;" required><?php if ($translation_row['lang_code']!='az'){}else{echo $translation_row['project_description'];} ?></textarea></div>
					</div>
				   <!-- Qısa Məlumat -->
				  <div class="margin_bottom2"></div>

                    <!-- Layihənin adı -->
					<div class="row">
						<div class="col-md-12 ">
							<label for="projectName" style="color: green">Layihənin adı(en) <em>*</em></label>
							<input type="text" name="projectName_en" id="projectName" value="<?php if ($translation_row['lang_code']!='en'){}else{echo $translation_row['project_title'];} ?>" required />
						</div>
					</div>
                   <!-- Layihənin adı -->
					
					<div class="clearfix"></div>

                   <!-- Qısa Məlumat -->
					<div class="row">
						<div class="col-md-12"><label style="color: green" for="project-info">Qısa məlumat (en)<em>*</em></label>
						<textarea name="project_info_en" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;" required><?php if ($translation_row['lang_code']!='en'){}else{echo $translation_row['project_description'];} ?>
						</textarea></div>
					</div>
				   <!-- Qısa Məlumat -->
				  <div class="margin_bottom2"></div>
                   <!-- Layihənin adı -->
					<div class="row">
						<div class="col-md-12 ">
							<label for="projectName" style="color: green">Layihənin adı(ru) <em>*</em></label>
							<input type="text" name="projectName_ru" id="projectName"  value="<?php if ($translation_row['lang_code']!='ru'){}else{echo $translation_row['project_title'];} ?>" required />
						</div>
					</div>
                   <!-- Layihənin adı -->
					
					<div class="clearfix"></div>

                   <!-- Qısa Məlumat -->
					<div class="row">
						<div class="col-md-12"><label style="color: green" for="project-info">Qısa məlumat (ru)<em>*</em></label>
						<textarea name="project_info_ru" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;" required><?php if ($translation_row['lang_code']!='ru'){}else{echo $translation_row['project_description'];} ?>
						</textarea></div>
					</div>
				   <!-- Qısa Məlumat -->
				  <div class="margin_bottom2"></div>
				
                               <div class="row">
                                      <!-- Digər məluamtlar -->  
		                            <div class="col-md-12"><label style="color: green" for="project-info">Digər məlumatlar (az)</label>
			                          <textarea name="a_information_az" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;"><?php if ($translation_row['lang_code']!='az'){}else{echo $translation_row['other_important_data'];} ?>
			                          </textarea>
	                                </div>
		                                 <!-- Digər məluamtlar -->  		
                               </div>

	                              <div class="margin_bottom2"></div>
                                <div class="row">
	                                      <!-- Unvan -->  	
	                                   <div class="col-md-12">
		                                <label style="color: green" for="projectName">Ünvan (az)<em>*</em></label>
		                                <input type="text" name="adress_az" id="projectName" required value="<?php if ($translation_row['lang_code']!='az'){}else{echo $translation_row['adress'];} ?>" />
	                                   </div>
                                               <!-- Unvan -->  
                                </div>

                                 <div class="margin_bottom2"></div>
				
                               <div class="row">
                                      <!-- Digər məluamtlar -->  
		                            <div class="col-md-12"><label style="color: green" for="project-info">Digər məlumatlar (en)</label>
			                          <textarea name="a_information_en" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;"><?php if ($translation_row['lang_code']!='en'){}else{echo $translation_row['other_important_data'];} ?></textarea>
	                                </div>
		                                 <!-- Digər məluamtlar -->  		
                               </div>

	                              <div class="margin_bottom2"></div>
                                <div class="row">
	                                      <!-- Unvan -->  	
	                                   <div class="col-md-12">
		                                <label style="color: green" for="projectName">Ünvan (en)<em>*</em></label>
		                                <input type="text" name="adress_en" id="projectName" required value="<?php if ($translation_row['lang_code']!='en'){}else{echo $translation_row['adress'];} ?>" />
	                                   </div>
                                               <!-- Unvan -->  
                                </div>
                                 <div class="margin_bottom2"></div>
				
                               <div class="row">
                                      <!-- Digər məluamtlar -->  
		                            <div class="col-md-12"><label style="color: green" for="project-info">Digər məlumatlar (ru)</label>
			                          <textarea name="a_information_ru" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;"><?php if ($translation_row['lang_code']!='ru'){}else{echo $translation_row['other_important_data'];} ?></textarea>
	                                </div>
		                                 <!-- Digər məluamtlar -->  		
                               </div>

	                              <div class="margin_bottom2"></div>
                                <div class="row">
	                                      <!-- Unvan -->  	
	                                   <div class="col-md-12">
		                                <label style="color: green" for="projectName">Ünvan (ru)<em>*</em></label>
		                                <input type="text" name="adress_ru" id="projectName" required value="<?php if ($translation_row['lang_code']!='ru'){}else{echo $translation_row['adress'];} ?>" />
	                                   </div>
                                               <!-- Unvan -->  
                                </div>
                               <div class="margin_bottom2"></div>
                               <div class="row">
                     <!--Layihənin üstünlükləri --> 
				          <div class="col-md-12">
						<label for="projectName">Layihənin üstünlükləri(az)</label>
						<textarea name="main_advantages_az" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;" ><?php if ($translation_row['lang_code']!='az'){}else{echo $translation_row['main_advantages'];} ?></textarea></div>
						</div>
					  
					<!--Layihənin üstünlükləri --> 
					  <div class="margin_bottom2"></div>
                               <div class="row">
                     <!--Layihənin üstünlükləri --> 
				          <div class="col-md-12">
						<label for="projectName">Layihənin üstünlükləri(en)</label>
						<textarea name="main_advantages_en" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;" ><?php if ($translation_row['lang_code']!='en'){}else{echo $translation_row['main_advantages'];} ?></textarea></div>
						</div>
					  
					<!--Layihənin üstünlükləri -->  
					  <div class="margin_bottom2"></div>
                               <div class="row">
                     <!--Layihənin üstünlükləri --> 
				          <div class="col-md-12">
						<label for="projectName">Layihənin üstünlükləri(ru)</label>
						<textarea name="main_advantages_ru" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;" ><?php if ($translation_row['lang_code']!='ru'){}else{echo $translation_row['main_advantages'];} ?></textarea></div>
						</div>
					  
					<!--Layihənin üstünlükləri -->   
                     <?php   }?>
					<div class="clearfix"></div>
					<div class="margin_bottom2"></div>

                   
					<div class="row">
					<!-- Sektor -->	
                    <div class="col-md-6 col-xs-12">
                    <label for="porject-sector">Sector <em>*</em></label>
					<select name="sector" required>
						<option value="">-<?php echo translate('choose_one');?>  -</option>
						  <?php foreach($sectors as $sector) {
						if ($sector['sek_id']==$detail['sector_id']) {
						 		$selected='selected';
						 	}else{
						 		$selected='';
						 	}
					echo'<option '.$selected.' value="'.$sector['sek_id'].'">'.$sector['sek_adi_'.$l.''].'</option>';
					
						  }?>
                    </select>
					</div>
					<!-- Sektor -->	

                    <!-- Yerləşdiyi rayon -->
                   <div class="col-md-6 col-xs-12">
	               <label for="porject-sector">Yerləşdiyi rayon <em>*</em></label>                   
	            <select name="region" required>
						<option value="">- <?php echo translate('choose_one');?> -</option>
						<?php foreach($regions as $region) {
						   if($region['reg_id']==$detail['region_id']) {
						 		$selected='selected';
						 	}else{
						 		$selected='';
						 	}
					echo'<option '.$selected.' value="'.$region['reg_id'].'">'.$region['reg_adi_'.$l.''].'</option>';
					
						  }?>
                    </select>
				  </div>
				  <!-- Yerləşdiyi rayon -->
				</div>

				<div class="clearfix"></div>
				<div class="margin_bottom2"></div>

				<div class="row">
                <!--Investisiya hecmi --> 
				 <div class="col-md-6 col-xs-12">
						<label for="projectName">Investisiya həcmi(AZN)<em>*</em></label>
						<input type="number" name="investment_volume"  required value="<?php echo $detail['invesment_volume']; ?>"/>
						</div>
					  
				<!--Investisiya hecmi -->  
					
                 <!--Investorun payi --> 
				 <div class="col-md-6 col-xs-12">
						<label for="projectName">Investorun payı(%)</label>
						<input type="number" name="investment_percent"   value="<?php echo $detail['investor_percent']; ?>"/>
						</div>
					  
                    <!--Investorun payi --> 
                    </div>
                    
                

                    <div class="clearfix"></div>
                    <div class="margin_bottom2"></div>

<div class="row">
	            <!-- Unvan -->  	
	          
				<!-- Muellif -->  
	            <div class="col-md-6">
		           <label for="projectName">Ad/Soyad və ya Qurum <em>*</em></label>
		           <input type="text" name="author"  required value="<?php echo $detail['project_author']; ?>"/>
			   </div>
			   <!-- Muellif -->  


	            <!-- Nomre -->  
	           <div class="col-md-6">
		         <label for="projectName">Telefon Nömrəsi <em>*</em></label>
		         <input type="text" name="telephone"  required value="<?php echo $detail['author_telephone']; ?>" />
	           </div>
				<!-- Nomre -->  
				
                <!-- Mail -->  
	           <div class="col-md-6">
		        <label for="projectName">E-Poçt </label>
		        <input type="email" name="email"  value="<?php echo $detail['author_email']; ?>"  />
			  </div>
			   <!-- Mail --> 
</div>


<div class="clearfix"></div>
<div class="row">
		<div class="col-md-12">
				<div id="map" style="width:100%; height:400px;"></div>
				<input type="hidden" name="lng" id="lngbox" value="<?php echo $detail['lng'] ?>">
				<input type="hidden" name="lat" id="latbox" value="<?php echo $detail['lat'] ?>" >
		</div>
	</div>
	<div class="margin_bottom2"></div>

<div class="clearfix"></div>
  <div>
  <?php $images = getProjectImages($detail['project_id']);
  if(!empty($images)){
	  foreach($images as $image){?>
	    
					<div class="delete-div-wrapmod">
					<span class="close">×</span>
					<div class="inner-div">
					<img class="img-responsive" width="100" src="<?=base_url().$image['files_url'];?>" data-id="<?=$image['files_id'];?>" alt="Project Images">
					</div>
					</div>
	
  <?php } }?>
</div>


<?php
$this->session->set_userdata('lat',$detail['lat']);
$this->session->set_userdata('lng',$detail['lng']);
?>
		

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
					<button type="submit" class="fbut">Təsdiqlə</button>

						
				</form>
			
			</div>

		</div>


	</div>
</div><!-- end content area -->