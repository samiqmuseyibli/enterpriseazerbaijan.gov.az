<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Tərəfdaş əlavə etmə Formu</h3>
          </div>
<?php echo form_open(base_url('admin/partner_adding'),array('class' => "form-horizontal  container",'method'=>"post",'enctype'=>"multipart/form-data" ));?>
            <div class="box-body">
              <!-- Input -->
             <input type="hidden" name="token" value="<?=createToken();?>">
                 <!-- Input -->
                 <div class="form-group">
                   <label for="url" class="col-sm-2 control-label">Web Sayt</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="web_site" value="" class="form-control" id="url">
                   </div>
                 </div>
                  <div class="form-group">
                   <label for="title" class="col-sm-2 control-label">Ad</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="title" value="" class="form-control" id="title">
                   </div>
                 </div>
                    <!-- Input -->
                    <div class="form-group">
                      <label for="image1" class="col-sm-2 control-label">Şəkil</label>
                      <div class="col-sm-4 ">
                        <input type="file" name="image" value="" class="form-control" id="image1">
                      </div>
 
                    </div>
                           

            </div>

            <div class="box-footer ">


              <a href="<?php echo base_url('admin/partners'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Əlavə et</button>


            </div>

          </form>
        </div>
</section>
