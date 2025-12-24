<section class="content">
        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Mesaj Göndərmə Formu</h3>
          </div>
          <?php echo form_open(base_url('admin/mailto_subcribers'),array('class' => "form-horizontal  container",'method'=>"post",'enctype'=>"multipart/form-data" ));?>
        
            <div class="box-body">
              <!-- Input -->
               <input type="hidden" name="token" value="<?=createToken();?>">
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Mövzu</label>
                            <div class="col-sm-10 ">
                            <textarea  name="subject" rows="8" cols="80"></textarea>
                            </div>
                          </div>
                          <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Mesaj</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor1" name="message" rows="8" cols="80"></textarea>
                            </div>
                          </div>
           </div>
            <div class="box-footer ">
              <a href="<?php echo base_url('admin/get_subcribers'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Göndər</button>
            </div>
          </form>
        </div>
</section>
