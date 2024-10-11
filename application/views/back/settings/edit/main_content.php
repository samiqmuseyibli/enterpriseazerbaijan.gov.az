<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title"> Redaktə Formu</h3>
          </div>
 <?php echo form_open(base_url('admin/updating_settings'),array('class' => "form-horizontal  container",'method'=>"post",'enctype'=>"multipart/form-data" ));?>
            <div class="box-body">
              <!-- Input -->
              <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Ünvan (AZ)</label>
                <div class="col-sm-4 ">
                  <input type="text" name="adress_az" value="<?php echo $detail['adress_az']; ?>" class="form-control" id="title">
                 
                   <input type="hidden" name="logo_url" value="<?php echo $detail['logo_url']; ?>" class="form-control" >
                   <input type="hidden" name="token" value="<?=createToken();?>">

                </div> 
              </div>
                <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Ünvan (EN)</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="adress_en" value="<?php echo $detail['adress_en']; ?>" class="form-control" id="price">
                   </div>

                 </div>
                   <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Ünvan (RU)</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="adress_ru" value="<?php echo $detail['adress_ru']; ?>" class="form-control" id="price">
                   </div>

                 </div>
              <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Telefon 1</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="tel1" value="<?php echo $detail['tel1']; ?>" class="form-control" id="price">
                   </div>

                 </div>
                 <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Telefon 2</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="tel2" value="<?php echo $detail['tel2']; ?>" class="form-control" id="price">
                   </div>

                 </div>
                 <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Email</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="mail" value="<?php echo $detail['mail']; ?>" class="form-control" id="price">
                   </div>

                 </div>
              <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Logo</label>
                   <div class="col-sm-4 ">
                <img style="max-height: 100px" src="<?php echo base_url('assets/front/images/');?><?php echo $detail['logo_url'];?> ">
                   </div>         
               </div>  
                   <div class="form-group">
                      <label for="image" class="col-sm-2 control-label">Yeni Logo</label>
                      <div class="col-sm-4 ">
                        <input type="file" name="image" accept="image/*" value="" class="form-control" id="image">
                      </div>   
                    </div>
                  
            </div>
            <div class="box-footer ">


              <a href="<?php echo base_url('admin/get_settings'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>


            </div>

          </form>
        </div>
</section>
