<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
          <div class="box-header with-border">
            <h3 class="box-title">Məxvilik Şərtləri</h3>
          </div>
          <?php echo form_open(base_url('admin/updatingprivacy'),array('class' => "form-horizontal  container",'method'=>"post"));?>
            <input type="hidden" name="token" value="<?=createToken();?>">
            <div class="box-body">
                          <div class="form-group">
                            <label for="content_az" class="col-sm-2 control-label">AZ</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor1" name="content_az" rows="8" cols="80"><?php echo $detail['content_az']?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="content_en" class="col-sm-2 control-label">EN</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor2" name="content_en" rows="8" cols="80"><?php echo $detail['content_en']?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="content_ru" class="col-sm-2 control-label">RU</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor3" name="content_ru" rows="8" cols="80"><?php echo $detail['content_ru']?></textarea>
                            </div>
                          </div>
                 
            </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/home'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Yenilə</button>
            </div>
          </form>
      
          </div>
        </div>
      </div>
    </div>
  </section>

