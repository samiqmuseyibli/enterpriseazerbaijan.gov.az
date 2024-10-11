<section class="content">
        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Fayl əlavə etmə Formu</h3>
          </div>
<?php echo form_open(base_url('admin/doupload'),array('class' => "form-horizontal  container",'method'=>"post",'enctype'=>"multipart/form-data" ));?>
         
            <div class="box-body">
              <!-- Input -->       
              <input type="hidden" name="token" value="<?=createToken();?>">
                    <!-- Input -->
                    <div class="form-group">
                      <label for="image1" class="col-sm-2 control-label">Fayl</label>
                      <div class="col-sm-4 ">
                        <input type="file" name="file" value="" class="form-control" id="image1">
                      </div>
                    </div>
            </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/uploadedfiles'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Əlavə et</button>
            </div>
          </form>
        </div>
</section>
