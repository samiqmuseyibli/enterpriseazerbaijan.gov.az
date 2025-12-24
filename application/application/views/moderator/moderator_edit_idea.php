<?php $l=curLang();?>
<div class="content_fullwidth less2">
	<div class="container">
		<div id="pencere" class="logregform two">
			<div class="title">
				<h3>Idealar</h3>
				
			</div>
			
	
			<div class="feildcont">
		<?php echo form_open(base_url('moderator/edit_idea'),array('role' => "form",'method'=>"post",'enctype'=>"multipart/form-data" ));?>	
				 
				  	 <?php foreach ($translation as $translation_row): ?>	
                      <input type="hidden" name="project_id" value="<?php echo $detail['project_id']; ?>">
                       <?php
                        echo '<!-- Layihənin adı -->
					<div class="row">
						<div class="col-md-12 ">
							<label for="projectName" style="color: green">Layihənin adı('.$translation_row['lang_code'].') <em>*</em></label>
							<input type="text" name="projectName_'.$translation_row['lang_code'].'" id="projectName"  value="'.$translation_row['project_title'].'" required />
						</div>
					</div>
                   <!-- Layihənin adı -->
					
					<div class="clearfix"></div>

                   <!-- Qısa Məlumat -->
					<div class="row">
						<div class="col-md-12"><label style="color: green" for="project-info">Qısa məlumat ('.$translation_row['lang_code'].')<em>*</em></label>
						<textarea name="project_info_'.$translation_row['lang_code'].'" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;" required>'.$translation_row['project_description'].'</textarea></div>
					</div>
				   <!-- Qısa Məlumat -->
				  <div class="margin_bottom2"></div>'; 
				  
                       
                       ?>
				 <?php endforeach; ?>
				   

					<div class="clearfix"></div>
					<div class="margin_bottom2"></div>

                   

				<div class="clearfix"></div>
				<div class="margin_bottom2"></div>


				<div class="row">
                <!--Investisiya hecmi --> 
				 <div class="col-md-4 col-xs-12">
						<label for="projectName">Investisiya həcmi(AZN)<em>*</em></label>
						<input type="number" name="investment_volume"  required value="<?php echo $detail['invesment_volume']; ?>" />
						</div>
					  
				<!--Investisiya hecmi -->  
					
                      <!-- Yerləşdiyi rayon -->
                   <div class="col-md-4 col-xs-12">
	               <label for="porject-sector">Yerləşdiyi rayon <em>*</em></label>                   
	          <select name="region" required>
						<option value="">- Siyahıdan seçin -</option>
						 <?php foreach($regions as $region) {
						 	if ($region['reg_id']==$detail['region_id']) {
						 		$selected='selected';
						 	}else{
						 		$selected="";
						 	}
						
					echo'<option '.$selected.' value="'.$region['reg_id'].'">'.$region['reg_adi_'.$l.''].'</option>';
					
						  }?>
                    </select>
				  </div>
				  <!-- Yerləşdiyi rayon -->

                 <!--Investorun payi --> 
				 <div class="col-md-4 col-xs-12">
						<label for="projectName">Ad/Soyad və ya Qurum<em>*</em></label>
						<input type="text" name="company"   required value="<?php echo $detail['project_author']; ?>"/>
						</div>
					  
					<!--Investorun payi --> 
				</div>
                 

<div class="clearfix"></div>
<div class="margin_bottom2"></div>

<div class="row">

	            <!-- Nomre -->  
	           <div class="col-md-6">
		         <label for="projectName">Telefon Nömrəsi <em>*</em></label>
		         <input type="text" name="number" i  required value="<?php echo $detail['author_telephone']; ?>"/>
	           </div>
				<!-- Nomre -->  
				
                <!-- Mail -->  
	           <div class="col-md-6">
		        <label for="projectName">E-Poçt </label>
		        <input type="email" name="email"  value="<?php echo $detail['author_email']; ?>" />
			  </div>
			   <!-- Mail --> 
</div>
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
                       <div class="clearfix"></div>	
					   <div class="margin_bottom2"></div>
                                       <div class="row">
											<label class="col-sm-4 control-label" for="demo-hor-12">Images</label>
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
					<button type="submit" class="fbut">Yenilə</button>

						
				</form>
			
			</div>

		</div>


	</div>
</div><!-- end content area -->

