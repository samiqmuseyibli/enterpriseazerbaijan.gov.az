<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Kateqoriya Redaktə Formu</h3>
          </div>

 <?php echo form_open(base_url('admin/updating_project_category'),array('class' => "form-horizontal  container",'method'=>"post" ));?>
            <div class="box-body">
              <!-- Input -->
              <input type="hidden" name="token" value="<?=createToken();?>">
              <div class="form-group">
                <div class="col-sm-4 ">
                  <input type="hidden" name="kat_id" value="<?php echo $detail['kat_id']; ?>" class="form-control" >
                </div> 
              </div>
               <!-- Input -->
                 <div class="form-group">
                   <label for="kat_adi_az" class="col-sm-2 control-label">Kateqoriya ad(AZ)</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="kat_adi_az" value="<?php echo $detail['kat_adi_az']; ?>" class="form-control" id="kat_adi_az">
                   </div>

                 </div>
                    <!-- Input -->
                     <!-- Input -->
                 <div class="form-group">
                   <label for="kat_adi_az" class="col-sm-2 control-label">Kateqoriya ad(EN)</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="kat_adi_en" value="<?php echo $detail['kat_adi_en']; ?>" class="form-control" id="kat_adi_az">
                   </div>

                 </div>
                    <!-- Input -->
                    <!-- Input -->
                 <div class="form-group">
                   <label for="kat_adi_az" class="col-sm-2 control-label">Kateqoriya ad(RU)</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="kat_adi_ru" value="<?php echo $detail['kat_adi_ru']; ?>" class="form-control" id="kat_adi_az">
                   </div>

                 </div>
                    <!-- Input -->
            </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/project_categories'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>
            </div>
          </form>
        </div>
</section>
