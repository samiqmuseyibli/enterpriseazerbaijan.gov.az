<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">Redaktə Formu</h3>
          </div>

     <?php echo form_open(base_url('admin/update_about_content'),array('class' => "form-horizontal  container",'method'=>"post" ));?>
        
            <div class="box-body">
              <!-- Input -->
                           <input type="hidden" name="token" value="<?=createToken();?>">
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Başlıq AZ</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor1" name="basliq_az" rows="8" cols="80"><?php echo $details['basliq_az']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Başlıq EN</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor2" name="basliq_en" rows="8" cols="80"><?php echo  $details['basliq_en']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Başlıq RU</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor3" name="basliq_ru" rows="8" cols="80"><?php echo  $details['basliq_ru']; ?></textarea>
                            </div>
                          </div>

                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Məksəd AZ</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor4" name="meksed_az" rows="8" cols="80"><?php echo  $details['meksed_az']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Məksəd EN</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor5" name="meksed_en" rows="8" cols="80"><?php echo  $details['meksed_en']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Məksəd RU</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor6" name="meksed_ru" rows="8" cols="80"><?php echo  $details['meksed_ru']; ?></textarea>
                            </div>
                          </div>

                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Hədəf AZ</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor7" name="hedef_az" rows="8" cols="80"><?php echo  $details['hedef_az']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Hədəf EN</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor8" name="hedef_en" rows="8" cols="80"><?php echo  $details['hedef_en']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Hədəf RU</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor9" name="hedef_ru" rows="8" cols="80"><?php echo  $details['hedef_ru']; ?></textarea>
                            </div>
                          </div>

                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Missiya AZ</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor10" name="missiya_az" rows="8" cols="80"><?php echo  $details['missiya_az']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Missiya EN</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor11" name="missiya_en" rows="8" cols="80"><?php echo  $details['missiya_en']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Missiya RU</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor12" name="missiya_ru" rows="8" cols="80"><?php echo  $details['missiya_ru']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Mətn AZ</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor13" name="content_az" rows="8" cols="80"><?php echo  $details['content_az']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Mətn EN</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor14" name="content_en" rows="8" cols="80"><?php echo  $details['content_en']; ?></textarea>
                            </div>
                          </div>
                           <div class="form-group">
                            <label for="information" class="col-sm-2 control-label">Mətn RU</label>
                            <div class="col-sm-10 ">
                            <textarea id="editor15" name="content_ru" rows="8" cols="80"><?php echo  $details['content_ru']; ?></textarea>
                            </div>
                          </div>
                  
            </div>

            <div class="box-footer ">


              <a href="<?php echo base_url('admin/about_content'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>


            </div>

          </form>
        </div>
</section>
