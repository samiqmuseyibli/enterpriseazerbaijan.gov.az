<section class="content">
        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Slider Redaktə Formu</h3>
          </div>
          <?php echo form_open(base_url('admin/updating_slider'),array('class' => "form-horizontal  container",'method'=>"post",'enctype'=>"multipart/form-data" ));?>
        
            <div class="box-body">
              <!-- Input -->
              <input type="hidden" name="token" value="<?=createToken();?>">
              <div class="form-group">       
                 <div class="col-sm-4 ">   
                  <input type="hidden" name="id" value="<?php echo $detail['id']; ?>" class="form-control" >
                </div> 
              </div>
             
                          <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Başlıq(AZ)</label>
                            <div class="col-sm-10 ">
                            <textarea  name="title_az" rows="4" cols="80"> <?php echo $detail['title_az']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Başlıq(EN)</label>
                            <div class="col-sm-10 ">
                            <textarea  name="title_en" rows="4" cols="80"><?php echo $detail['title_en']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Başlıq(RU)</label>
                            <div class="col-sm-10 ">
                            <textarea  name="title_ru" rows="4" cols="80"><?php echo $detail['title_ru']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Şəkil(AZ)</label>
                            <div class="col-sm-10 ">
                            <textarea  id="editor1" name="url_image_az" rows="8" cols="80"><?php echo $detail['url_image_az']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Şəkil(EN)</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor2" name="url_image_en" rows="8" cols="80"><?php echo $detail['url_image_en']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Şəkil(RU)</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor3" name="url_image_ru" rows="8" cols="80"><?php echo $detail['url_image_ru']; ?></textarea>
                            </div>
                          </div>
             
            </div>
            <div class="box-footer ">


              <a href="<?php echo base_url('admin/sliders'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>


            </div>

          </form>
        </div>
</section>
