<div class="content_fullwidth less2">
    <div class="container">
        <div id="pencere" class="logregform two">
            <div class="title">
                <h3>Torpaq satışı</h3>

            </div>

            <div class="feildcont">
                <?php echo form_open(base_url('user/update_land_sale'),array('role' => "form",'method'=>"post",'enctype'=>"multipart/form-data" ));?>
                   
                        <input type="hidden" name="lang" value="<?php echo $l?>">
                        <input type="hidden" name="project_id" value="<?php echo $detail['project_id']; ?>">
                        <input type="hidden" name="translation_id" value="<?php echo $detail['translation_id']; ?>">
                        <input type="hidden" name="image_url" value="<?php echo $detail['url_image']; ?>">
                        <!-- Layihənin adı -->
                        <div class="row">
                            <div class="col-md-12 ">
                                <label for="projectName">Elanın adı <em>*</em></label>
                                <input type="text" name="projectName" id="projectName" required value="<?php echo $detail['project_title']; ?>" />
                            </div>
                        </div>
                        <!-- Layihənin adı -->

                        <div class="clearfix"></div>

                        <!-- Qısa Məlumat -->
                        <div class="row">
                            <div class="col-md-12">
                                <label for="project-info">Qısa məlumat <em>*</em></label>
                                <textarea name="project_info" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;" required>
                                    <?php echo $detail['project_description']; ?>
                                </textarea>
                            </div>
                        </div>
                        <!-- Qısa Məlumat -->

                        <div class="clearfix"></div>
                        <div class="margin_bottom2"></div>

                        <div class="row">
                            <!-- Sektor -->
                            <div class="col-md-6 col-xs-12">
                                <label for="porject-sector">Sector <em>*</em></label>
                                <select name="sector" required>
                                    <option value="">- Siyahıdan seçin -</option>
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

                            <!-- Mülkiyyət forması -->
                            <div class="col-md-6 col-xs-12">
                                <label for="porject-sector">Mülkiyyət forması</label>
                                <select name="property" required>
                                    <option value="">- Siyahıdan seçin -</option>
                                    <?php foreach($property_type as $property) {
						        if($property['property_type_id']==$detail['property_type_id']) {
						 		$selected='selected';
						 	}else{
						 		$selected='';
						 	}
					echo'<option '.$selected.' value="'.$property['property_type_id'].'">'.$property['property_name_'.$l.''].'</option>';

						  }?>
                                </select>
                            </div>
                            <!-- Mülkiyyət forması -->
                        </div>

                        <div class="clearfix"></div>
                        <div class="margin_bottom2"></div>

                        <div class="row">
                            <!--Yerləşdiyi rayon -->
                            <div class="col-md-6 col-xs-12">
                                <label for="porject-sector">Yerləşdiyi rayon <em>*</em></label>
                                <select name="region" required>
                                    <option value="">- Siyahıdan seçin -</option>
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

                            <!--Yerləşdiyi rayon  -->

                            <!--İstifadəyə verilmə forması -->
                            <div class="col-md-6 col-xs-12">
                                <label for="porject-sector">İstifadəyə verilmə forması</label>
                                <select name="usage_form" required>
                                    <option value="">- Siyahıdan seçin -</option>
                                    <?php foreach($usage_form as $usage) {
						   if($usage['usage_form_id']==$detail['usage_form_id']) {
						 		$selected='selected';
						 	}else{
						 		$selected='';
						 	}
					echo'<option '.$selected.' value="'.$usage['usage_form_id'].'">'.$usage['usage_form_name_'.$l.''].'</option>';

						  }?>
                                </select>
                            </div>

                            <!--İstifadəyə verilmə forması -->
                        </div>

                        <div class="clearfix"></div>
                        <div class="margin_bottom2"></div>

                        <div class="row">
                            <!--Təyinatı -->
                            <div class="col-md-6 col-xs-12">
                                <label for="porject-sector">Təyinatı</label>
                                <select name="appointment" required>
                                    <option value="">- Siyahıdan seçin -</option>
                                    <?php foreach($appointment as $appointment_row) {
						     if($appointment_row['appointment_id']==$detail['appointment_id']) {
						 		$selected='selected';
						 	}else{
						 		$selected='';
						 	}
					echo'<option '.$selected.' value="'.$appointment_row['appointment_id'].'">'.$appointment_row['appointment_name_'.$l.''].'</option>';

						  }?>
                                </select>
                            </div>

                            <!--Təyinatı -->

                            <!--Ümumi Sahə -->
                            <div class="col-md-6 col-xs-12">
                                <label for="projectName">Ümumi Sahə (ha)</label>
                                <input type="number" name="ha" required value="<?php echo $detail['common_area']; ?>" />
                            </div>

                            <!--Ümumi Sahə -->
                        </div>

                        <div class="clearfix"></div>
                        <div class="margin_bottom2"></div>

                        <div class="row">
                            <!-- Torpağın qiyməti -->
                            <div class="col-md-6 col-xs-12">
                                <label for="porject-sector">Torpağın qiyməti (AZN)</label>
                                <input type="number" name="price" required value="<?php echo $detail['price']; ?>" />
                            </div>

                            <!--Torpağın qiyməti -->

                            <!--İnfrastruktur -->
                            <div class="col-md-6 col-xs-12">
                                <label for="porject-sector">İnfrastruktur</label>
                                <textarea name="infrastructure" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;">
                                    <?php echo $detail['infrastructure']; ?>
                                </textarea>
                            </div>

                            <!--İnfrastruktur -->
                        </div>

                        <div class="clearfix"></div>
                        <div class="margin_bottom2"></div>

                        <div class="row">
                            <!-- Digər məluamtlar -->
                            <div class="col-md-12">
                                <label for="project-info">Digər məlumatlar</label>
                                <textarea name="a_information" class="comment_textarea_bg" style=" width:100%; border: 1px solid #e3e3e3;">
                                    <?php echo $detail['other_important_data']; ?>
                                </textarea>
                            </div>
                            <!-- Digər məluamtlar -->
                        </div>

                        <div class="clearfix"></div>
                        <div class="margin_bottom2"></div>

                        <div class="row">
                            <!-- Unvan -->
                            <div class="col-md-6">
                                <label for="projectName">Ünvan <em>*</em></label>
                                <input type="text" name="adress" required value="<?php echo $detail['adress']; ?>" />
                            </div>
                            <!-- Unvan -->

                            <!-- Muellif -->
                            <div class="col-md-6">
                                <label for="projectName">Ad/Soyad və ya Qurum <em>*</em></label>
                                <input type="text" name="author" required value="<?php echo $detail['project_author']; ?>" />
                            </div>
                            <!-- Muellif -->
                        </div>
                        <div class="clearfix"></div>
                        <div class="row">

                            <!-- Nomre -->
                            <div class="col-md-6">
                                <label for="projectName">Telefon Nömrəsi <em>*</em></label>
                                <input type="text" name="telephone" required value="<?php echo $detail['author_telephone']; ?>" />
                            </div>
                            <!-- Nomre -->

                            <!-- Mail -->
                            <div class="col-md-6">
                                <label for="projectName">E-Poçt </label>
                                <input type="email" name="email" value="<?php echo $detail['author_email']; ?>" />
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
                                    <input type="hidden" name="lng" id="lngbox" value="<?php echo $detail['lng'] ?>">
                                    <input type="hidden" name="lat" id="latbox" value="<?php echo $detail['lat'] ?>">
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
                            
                            <div class="row">
                                <hr>
                                <div class="margin_bottom2"></div>
                                <label class="col-sm-4 control-label" for="demo-hor-12">Şəkil əlavə et</label>
                                <div class="col-sm-3">
                                    <input type="file" multiple="" name="images[]" onchange="preview(this);" class="form-control">
                                    <br>
                                    <br>
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

                                <button type="submit" class="fbut">Yenilə</button>

                                </form>

            </div>

        </div>

    </div>
</div>
<!-- end content area -->