<section class="content">
        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Redaktə Formu</h3>
          </div>
 <?php echo form_open(base_url('admin/updatingcfproject'),array('class' => "form-horizontal  container",'method'=>"post",'enctype'=>"multipart/form-data"));?>
            <div class="box-body">
        
                  <!-- Input -->
                  <input type="hidden" name="token" value="<?=createToken();?>">
                 <div class="form-group">
                   <label for="region" class="col-sm-2 control-label">Region</label>
                   <div class="col-sm-2 ">
                    <input type="hidden" name="project_id" value="<?php echo $detail['id'];?>">
                     <input type="hidden" name="current_image" value="<?php echo $detail['image'];?>">
                    <select name="region_id">
                      <?php $regions=get_regions(); foreach ($regions as $region) {
                     if ($detail['region_id']=== $region['reg_id']) {
                      $selected='selected';
                     }else{
                      $selected='';
                     }?>
                  <option  <?php echo $selected;?> value="<?php echo $region['reg_id'];?>"><?php echo $region['reg_adi_az']?></option> 
                     <?php } ?>
                   </select>
                   </div>
                    <label for="category" class="col-sm-2 control-label">Kateqoriya</label>
                   <div class="col-sm-3 ">
                    <select name="category_id">
                      <?php $categories=get_cfcategories(); foreach ($categories as $category) {
                    if($detail['category_id'] === $category['id']) {
                    $selected='selected';
                     }else{
                      $selected='';
                     }?>
                          <option <?php echo $selected;?> value="<?php echo $category['id'];?>"><?php echo $category['title_az']?></option> 
                     <?php } ?>
                   </select>
                   </div>
                 </div>
                <!-- Input -->   
                 <?php $editorid=0; $tr=get_cfproject_translations($detail['id']); foreach ($tr as $item) {  $editorid++;?>  
                 <!-- Input -->
                 <div class="form-group">
                   <label for="<?php echo $item['lang_code']?>" class="col-sm-2 control-label">Başlıq <?php echo $item['lang_code']?></label>
                   <div class="col-sm-4 ">
                     <textarea  name="title_<?php echo $item['lang_code']?>" rows="4" cols="80"><?php echo $item['title']?></textarea>
                   </div>
                 </div>
               

                <!-- Input -->
                 <div class="form-group">
                   <label for="<?php echo $item['lang_code']?>" class="col-sm-2 control-label">Qısa Məlumat <?php echo $item['lang_code']?></label>
                   <div class="col-sm-4 ">
                        <textarea  name="about_<?php echo $item['lang_code']?>" rows="8" cols="80"><?php echo $item['about']?></textarea>
                   </div>
                 </div>
                <!-- Input --> 
               
                    
                  <!-- Input -->
                 <div class="form-group">
                   <label for="address" class="col-sm-2 control-label">Müəllif haqqında məlumat <?php echo $item['lang_code']?></label>
                   <div class="col-sm-4 ">
                        <textarea id="editor<?php echo $editorid;?>"  name="address_<?php echo $item['lang_code']?>" rows="8" cols="80"><?php echo $item['address']?></textarea>
                   </div>
                 </div>
                <!-- Input --> 
                <!-- Input -->
                 <div class="form-group">
                   <label for="<?php echo $item['lang_code']?>" class="col-sm-2 control-label">Layihənin detallı izahı <?php echo $item['lang_code']?></label>
                   <div class="col-sm-8 ">
                        <textarea id="editor<?php echo $editorid+3;?>" name="description_<?php echo $item['lang_code']?>" rows="8" cols="80"><?php echo $item['description']?></textarea>
                   </div>
                 </div>
                <!-- Input -->
                              <?php }?>

               
                 <!-- Input -->
                 <div class="form-group">
                   <label for="AZN" class="col-sm-2 control-label">Məbləğ (AZN)</label>
                   <div class="col-sm-4 ">
                     <input type="number" name="price" value="<?php echo $detail['price'];?>" class="form-control">
                   </div>
                 </div>
                <!-- Input -->    
                 <!-- Input -->
                 <div class="form-group">
                   <label for="image" class="col-sm-2 control-label">Şəkil</label>
                   <div class="col-sm-4 ">
                    <input type="file" name="image" accept="image/*" style="border: 1px solid white"><br>
                     <img style="max-height: 200px;" src="<?php echo base_url('cf_images/').$detail['image'];?>">
                   </div>
                 </div>
                <!-- Input -->  

                 <!-- Input -->
                 <div class="form-group">
                   <label for="image" class="col-sm-2 control-label">Sona Çatma Vaxtı</label>
                   <div class="col-sm-4 ">
                     <input type="date"  name="end_time" value="<?php echo $detail['end_time'];?>" class="form-control">
                   </div>
                 </div>
                <!-- Input -->  

                
    

            </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/cfprojects'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>
            </div>
          </form>
        </div>
</section>
