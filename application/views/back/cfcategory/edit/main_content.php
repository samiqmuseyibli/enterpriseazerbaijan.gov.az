<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Redaktə Formu</h3>
          </div>

 <?php echo form_open(base_url('admin/updatingcfcategory'),array('class' => "form-horizontal  container",'method'=>"post"));?>
            <div class="box-body">
              <!-- Input -->
              <input type="hidden" name="token" value="<?=createToken();?>">
              <div class="form-group">
                <label for="AZ" class="col-sm-2 control-label">AZ</label>
                <div class="col-sm-4 ">
                  <input type="text" name="title_az" value="<?php echo $detail['title_az']; ?>" class="form-control" id="AZ">
                  <input type="hidden" name="id" value="<?php echo $detail['id']; ?>" class="form-control" >
                </div> 
              </div>
                        <!-- Input -->
                 <div class="form-group">
                   <label for="EN" class="col-sm-2 control-label">EN</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="title_en" value="<?php echo $detail['title_en']; ?>" class="form-control" id="EN">
                   </div>
                 </div>
                <!-- Input -->   
                <!-- Input -->
                 <div class="form-group">
                   <label for="RU" class="col-sm-2 control-label">RU</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="title_ru" value="<?php echo $detail['title_ru']; ?>" class="form-control" id="RU">
                   </div>
                 </div>
                <!-- Input -->     
            </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/cfcategories'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>
            </div>
          </form>
        </div>
</section>
