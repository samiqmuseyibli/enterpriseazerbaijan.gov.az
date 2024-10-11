<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Video redaktə et</h3>
        </div>
        <?php echo $this->session->flashdata('update_datatable'); ?>
        <div class="box-body">
	        <?php echo form_open(base_url('admin/updating_video/'.$detail['v_id']), array('class' => "form-horizontal  container", 'method' => "post", 'enctype' => "multipart/form-data")); ?>
            <input type="hidden" name="token" value="<?=createToken();?>">
                       <div class="row">
                            <div class="col-md-12">
                                    <iframe src="<?=$detail['v_video_url']?>" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                            <div class="col-md-6">
                            <div class="form-group">
                              <label >Yeni video(youtube link)</label>
                              <input type="text" name="video_url" value="" class="form-control" placeholder="Url daxil edin..." >
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                            <div class="form-group">
                              <label >Video başlıqı (AZ) <span class="required">*</span></label>
                               <textarea name="title_az" class="form-control" rows="2" placeholder="Video başlıqını daxil edin..."><?=$detail['v_title_az']?></textarea>
                            </div>
                          </div>
                          <div class="col-md-8">
                            <div class="form-group">
                              <label >Video başlıqı (EN) <span class="required">*</span></label>
                              <textarea name="title_en" class="form-control" rows="2" placeholder="Video başlıqını daxil edin..."><?=$detail['v_title_en']?></textarea>
                            </div>
                          </div>
                           <div class="col-md-8">
                            <div class="form-group">
                              <label >Video başlıqı (RU) <span class="required">*</span></label>
                              <textarea name="title_ru" class="form-control" rows="2" placeholder="Video başlıqını daxil edin..."><?=$detail['v_title_ru']?></textarea>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <img class="img-fluid" style="max-height: 400px"src="<?=base_url().$detail['v_cover']; ?> ">
                             </div>
                        </div>
                        <div class="row">
                          <div class="col-md-8">
                            <div class="form-group">
                              <label>Yeni Şəkil (Cover)<span class="required">*</span></label>
                              <div class="input-group">
                                <div class="custom-file">
                                  <input type="file" name="file"   class="custom-file-input" id="cover">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <hr>
			            <div class="row">     
                           <div class="col-md-3">
                            <div class="form-group">
                              <label >Əlavə olunma tarixi <br><span style="font-size: 14px;" class="text-blue">(Nümunə: 2020-12-31 17:52:00)</span></label>
                              <input value="<?php echo $detail['v_createdAt']; ?>" type="text" name="add_date" class="form-control" placeholder="2020-12-31 17:52:00">
                            </div>
                          </div>
                        </div>   
			
		    </div>
	</div>
	<div class="box-footer ">
		<a href="<?php echo base_url('admin/video'); ?>" class="btn btn-default">Geri</a>
		<button type="submit" class="btn btn-info pull-right">Dəyiş</button>
	</div>
	</form>
        
    </div>
</section>
