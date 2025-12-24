<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Şirkət əlavə etmə Formu</h3>
           <a href="https://www.latlong.net/" target="_blank" class="btn btn-primary pull-right"><i class="fa fa-website" type="button" style="padding-right: 4px;"></i><b>latlong.net</b></a>
          </div>

 <?php echo form_open(base_url('admin/company_adding'),array('class' => "form-horizontal  container",'method'=>"post" ));?>
            <div class="box-body">
              <!-- Input -->
                         <input type="hidden" name="token" value="<?=createToken();?>">
                             <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Ad</label>
                            <div class="col-sm-10 ">
                            <textarea  name="name" rows="4" cols="80"></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Ünvan</label>
                            <div class="col-sm-10 ">
                            <textarea  name="address" rows="4" cols="80"></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">LAT</label>
                            <div class="col-sm-10 ">
                            <input type="text" name="lat">
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">LNG</label>
                            <div class="col-sm-10 ">
                            <input type="text" name="lng">
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10 ">
                            <textarea  name="link_id" rows="4" cols="80"></textarea>
                            </div>
                          </div>

                         
         
            </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/companies'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Əlavə et</button>
            </div>
          </form>
        </div>
</section>
