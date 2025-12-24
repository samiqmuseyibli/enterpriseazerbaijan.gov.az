<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Layihə əlavə etmə formu</h3>
          </div>
 <?php echo form_open(base_url('admin/addingcfproject'),array('class' => "form-horizontal  container",'method'=>"post",'enctype'=>"multipart/form-data"));?>
            <div class="box-body">
                  <!-- Input -->
                  <input type="hidden" name="token" value="<?=createToken();?>">
                 <div class="form-group">
                   <label for="region" class="col-sm-2 control-label">Region</label>
                   <div class="col-sm-2 ">
                    <select name="region_id">
                      <?php $regions=get_regions(); foreach ($regions as $region) {?>
                          <option value="<?php echo $region['reg_id'];?>"><?php echo $region['reg_adi_az']?></option> 
                     <?php } ?>
                   </select>
                   </div>
                    <label for="category" class="col-sm-2 control-label">Kateqoriya</label>
                   <div class="col-sm-3 ">
                    <select name="category_id">
                      <?php $categories=get_cfcategories(); foreach ($categories as $category) {?>
                          <option value="<?php echo $category['id'];?>"><?php echo $category['title_az']?></option> 
                     <?php } ?>
                   </select>
                   </div>
                 </div>
                <!-- Input -->             
                 <!-- Input -->
                 <div class="form-group">
                   <label for="AZ" class="col-sm-2 control-label">Başlıq AZ</label>
                   <div class="col-sm-4 ">
                     <textarea  name="title_az" rows="4" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input --> 
                <!-- Input -->
                 <div class="form-group">
                   <label for="EN" class="col-sm-2 control-label">Başlıq EN</label>
                   <div class="col-sm-4 ">
                     <textarea  name="title_en" rows="4" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input --> 
                <!-- Input -->
                 <div class="form-group">
                   <label for="RU" class="col-sm-2 control-label">Başlıq RU</label>
                   <div class="col-sm-4 ">
                     <textarea  name="title_ru" rows="4" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input --> 



                <!-- Input -->
                 <div class="form-group">
                   <label for="AZ" class="col-sm-2 control-label">Qısa Məlumat AZ</label>
                   <div class="col-sm-4 ">
                        <textarea  name="about_az" rows="8" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input --> 
                <!-- Input -->
                 <div class="form-group">
                   <label for="EN" class="col-sm-2 control-label">Qısa Məlumat EN</label>
                   <div class="col-sm-4 ">
                      <textarea  name="about_en" rows="8" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input --> 
                <!-- Input -->
                 <div class="form-group">
                   <label for="RU" class="col-sm-2 control-label">Qısa Məlumat RU</label>
                   <div class="col-sm-4 ">
                     <textarea  name="about_ru" rows="8" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input --> 
               


              


                 <!-- Input -->
                 <div class="form-group">
                   <label for="AZ" class="col-sm-2 control-label">Layihənin detallı izahı AZ</label>
                   <div class="col-sm-8 ">
                        <textarea id="editor1" name="description_az" rows="8" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input -->    
                 <!-- Input -->
                 <div class="form-group">
                   <label for="AZ" class="col-sm-2 control-label">Layihənin detallı izahı EN</label>
                   <div class="col-sm-8 ">
                        <textarea id="editor2" name="description_en" rows="8" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input -->    
                 <!-- Input -->
                 <div class="form-group">
                   <label for="AZ" class="col-sm-2 control-label">Layihənin detallı izahı RU</label>
                   <div class="col-sm-8 ">
                        <textarea id="editor3" name="description_ru" rows="8" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input -->

                 <!-- Input -->
                 <div class="form-group">
                   <label for="AZN" class="col-sm-2 control-label">Məbləğ (AZN)</label>
                   <div class="col-sm-4 ">
                     <input type="number" name="price" value="" class="form-control">
                   </div>
                 </div>
                <!-- Input -->    
                 <!-- Input -->
                 <div class="form-group">
                   <label for="image" class="col-sm-2 control-label">Şəkil</label>
                   <div class="col-sm-4 ">
                    <input type="file" name="image" accept="image/*" style="border: 1px solid white">
                   </div>
                 </div>
                <!-- Input -->  

                 <!-- Input -->
                 <div class="form-group">
                   <label for="image" class="col-sm-2 control-label">Sona Çatma Vaxtı</label>
                   <div class="col-sm-4 ">
                     <input type="date"  name="end_time" value="" class="form-control">
                   </div>
                 </div>
                <!-- Input -->  

                  <!-- Input -->
                 <div class="form-group">
                   <label for="address" class="col-sm-2 control-label">Müəllif haqqında məlumat AZ</label>
                   <div class="col-sm-4 ">
                        <textarea id="editor4" name="address_az" rows="8" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input --> 
                <!-- Input -->
                 <div class="form-group">
                   <label for="address" class="col-sm-2 control-label">Müəllif haqqında məlumat EN</label>
                   <div class="col-sm-4 ">
                        <textarea id="editor5"  name="address_en" rows="8" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input --> 
                <!-- Input -->
                 <div class="form-group">
                   <label for="address" class="col-sm-2 control-label">Müəllif haqqında məlumat RU</label>
                   <div class="col-sm-4 ">
                        <textarea  id="editor6" name="address_ru" rows="8" cols="80"></textarea>
                   </div>
                 </div>
                <!-- Input --> 
            </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/cfprojects'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Əlavə et</button>
            </div>
          </form>
        </div>
</section>
