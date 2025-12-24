<section class="content">
        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Şirkət Redaktə Formu</h3>
          </div>
           <?php echo form_open(base_url('admin/updating_company'),array('class' => "form-horizontal  container",'method'=>"post" ));?>
       
            <div class="box-body">
              <!-- Input -->
              <input type="hidden" name="token" value="<?=createToken();?>">
              <div class="form-group">       
                 <div class="col-sm-4 ">   
                  <input type="hidden" name="id" value="<?php echo $detail['id']; ?>" class="form-control" >
                </div> 
              </div>
             
                          <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">AD</label>
                            <div class="col-sm-10 ">
                            <textarea  name="name" rows="4" cols="80"> <?php echo $detail['name']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">ÜNVAN</label>
                            <div class="col-sm-10 ">
                            <textarea  name="address" rows="4" cols="80"><?php echo $detail['address']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">lat</label>
                            <div class="col-sm-10 ">
                            <input type="text" name="lat" value="<?php echo $detail['lat']; ?>">
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">lng</label>
                            <div class="col-sm-10 ">
                          <input type="text" name="lng" value="<?php echo $detail['lng']; ?>">
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="link_id" class="col-sm-2 control-label">URL</label>
                            <div class="col-sm-10 ">
                                <textarea  name="link_id" rows="4" cols="80"><?php echo $detail['link_id']; ?></textarea>
                        
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="link_id" class="col-sm-2 control-label">&nbsp; </label>
                            https://azexport.az/index.php?route=product/seller/info&seller_id= 
                          </div>
                          
             
            </div>
            <div class="box-footer ">


              <a href="<?php echo base_url('admin/companies'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>


            </div>

          </form>
        </div>
</section>
