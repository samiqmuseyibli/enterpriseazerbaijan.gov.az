<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
          <div class="box-header with-border">
            <h3 class="box-title">Şifrə Yeniləmə Formu</h3>
          </div>
          <?php echo form_open(base_url('admin/updating_password'),array('class' => "form-horizontal  container",'method'=>"post"));?>
         
            <div class="box-body">
              <!-- Input -->
                 <!-- Input -->
                 <input type="hidden" name="token" value="<?=createToken();?>">
                 <div class="form-group">
                   <label for="name" class="col-sm-2 control-label">Köhnə Şifrə</label>
                   <div class="col-sm-4 ">
                     <input type="password" name="old_password" value="" class="form-control" id="name">
                   </div>
                 </div>
                  <div class="form-group">
                   <label for="name" class="col-sm-2 control-label">Yeni Şifrə</label>
                   <div class="col-sm-4 ">
                     <input type="password" name="password_1" value="" class="form-control" id="name">
                   </div>
                 </div>
                  <div class="form-group">
                   <label for="name" class="col-sm-2 control-label">Yeni Şifrə(təkrar)</label>
                   <div class="col-sm-4 ">
                     <input type="password" name="password_2" value="" class="form-control" id="name">
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

