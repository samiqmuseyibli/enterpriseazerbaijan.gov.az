<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">LAYİHƏLƏR FONDU HAQQINDA (Redaktə Formu)</h3>
            
          </div>
  <?php echo $this->session->flashdata('update_datatable'); ?>
 <?php echo form_open(base_url('admin/updatingcfabout'),array('class' => "form-horizontal  container",'method'=>"post"));?>
            <div class="box-body">
              <!-- Input -->
              <input type="hidden" name="token" value="<?=createToken();?>">
              <div class="form-group">
                <label for="AZ" class="col-sm-2 control-label">AZ</label>
                <div class="col-sm-10 ">
                <textarea id="editor1"  name="content_az" rows="8" cols="80"><?php echo $detail['content_az']?></textarea>
              
                </div> 
              </div>
                        <!-- Input -->
                 <div class="form-group">
                   <label for="EN" class="col-sm-2 control-label">EN</label>
                   <div class="col-sm-10 ">
                     <textarea id="editor2"  name="content_en" rows="15" cols="100"><?php echo $detail['content_en']?></textarea>
                   </div>
                 </div>
                <!-- Input -->   
                <!-- Input -->
                 <div class="form-group">
                   <label for="RU" class="col-sm-2 control-label">RU</label>
                   <div class="col-sm-10 ">
                      <textarea id="editor3"  name="content_ru" rows="8" cols="80"><?php echo $detail['content_ru']?></textarea>
                   </div>
                 </div>
                <!-- Input -->     
            </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/updatecfabout'); ?>"  class="btn btn-default">Yenilə</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>
            </div>
          </form>
        </div>
</section>
