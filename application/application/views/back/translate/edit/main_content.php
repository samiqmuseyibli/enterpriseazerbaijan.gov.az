<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Redaktə Formu</h3>
          </div>
<?php echo form_open(base_url('admin/updating_site_translation'),array('class' => "form-horizontal  container",'method'=>"post",'enctype'=>"multipart/form-data" ));?>
            <div class="box-body">
              <!-- Input -->
              <div class="form-group">
               <input type="hidden" name="token" value="<?=createToken();?>">
                <div class="col-sm-4 ">
                  <input type="hidden" name="id" value="<?php echo $detail['word_id']; ?>" class="form-control" >
                </div> 
              </div>
               <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">AZ</label>
                <div class="col-sm-4 ">
                  <input type="text" name="az" value="<?php echo $detail['Azerbaijan']; ?>" class="form-control" >
                </div> 
              </div>
              <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">EN</label>
                <div class="col-sm-4 ">
                  <input type="text" name="en" value="<?php echo $detail['English']; ?>" class="form-control" >
                </div> 
              </div>
              <div class="form-group">
                  <label for="title" class="col-sm-2 control-label">RU</label>
                <div class="col-sm-4 ">
                  <input type="text" name="ru" value="<?php echo $detail['Russian']; ?>" class="form-control" >
                </div> 
              </div>              
            </div>
            <div class="box-footer ">


              <a href="<?php echo base_url('admin/site_translation'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>


            </div>

          </form>
        </div>
</section>
