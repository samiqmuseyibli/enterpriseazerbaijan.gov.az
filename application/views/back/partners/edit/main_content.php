<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Tərəfdaş Redaktə Formu</h3>
          </div>

<?php echo form_open(base_url('admin/updating_partner'),array('class' => "form-horizontal  container",'method'=>"post",'enctype'=>"multipart/form-data" ));?>
            <div class="box-body">
              <!-- Input -->
              <div class="form-group">
                <input type="hidden" name="token" value="<?=createToken();?>">
                <label for="title" class="col-sm-2 control-label">Web Sayt</label>
                <div class="col-sm-4 ">
                  <input type="text" name="web_site" value="<?php echo $detail['web_site']; ?>" class="form-control" id="title">
                  <input type="hidden" name="id" value="<?php echo $detail['id']; ?>" class="form-control" >
                   <input type="hidden" name="image_url" value="<?php echo $detail['url_image']; ?>" class="form-control" >

                </div> 
              </div>
               <div class="form-group">
                   <label for="title" class="col-sm-2 control-label">Ad</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="title" value="<?php echo $detail['title']; ?>" class="form-control" id="title">
                   </div>
                 </div>
              <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Şəkil</label>
                   <div class="col-sm-4 ">
                <img style="max-height: 100px" src="<?php echo base_url('assets/front/images/');?><?php echo $detail['url_image'];?> ">
                   </div>         
               </div>  
                   <div class="form-group">
                      <label for="image" class="col-sm-2 control-label">Yeni Şəkil</label>
                      <div class="col-sm-4 ">
                        <input type="file" name="image" accept="image/*" value="" class="form-control" id="image">
                      </div>   
                    </div>
            </div>
            <div class="box-footer ">


              <a href="<?php echo base_url('admin/partners'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>


            </div>

          </form>
        </div>
</section>
