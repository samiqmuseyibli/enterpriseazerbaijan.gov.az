<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Sektor Redaktə Formu</h3>
          </div>

 <?php echo form_open(base_url('admin/updating_sector'),array('class' => "form-horizontal  container",'method'=>"post"));?>
            <div class="box-body">
              <!-- Input -->
              <input type="hidden" name="token" value="<?=createToken();?>">
              <div class="form-group">
                <label for="title" class="col-sm-2 control-label">AZ</label>
                <div class="col-sm-4 ">
                  <input type="text" name="sek_adi_az" value="<?php echo $detail['sek_adi_az']; ?>" class="form-control" id="title">
                  <input type="hidden" name="id" value="<?php echo $detail['sek_id']; ?>" class="form-control" >
                </div> 
              </div>
                        <!-- Input -->
                 <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">EN</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="sek_adi_en" value="<?php echo $detail['sek_adi_en']; ?>" class="form-control" id="price">
                   </div>
                 </div>
                <!-- Input -->   
                <!-- Input -->
                 <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">RU</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="sek_adi_ru" value="<?php echo $detail['sek_adi_ru']; ?>" class="form-control" id="price">
                   </div>
                 </div>
                <!-- Input -->     
            </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/sectors'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>
            </div>
          </form>
        </div>
</section>
