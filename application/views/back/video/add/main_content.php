		<section class="content">
		 <div class="box box-info" >
			<div class="box-header with-border">
				<h3 class="box-title">Video əlavə etmə Formu</h3>
			</div>
			<?php echo form_open(base_url('admin/video_adding'),array('class' => "form-horizontal container", 'method'=>"post",'enctype'=>"multipart/form-data" ));?>
			   <div class="box-body">
			   	<input type="hidden" name="token" value="<?=createToken();?>">
		                <div class="row">
		                  <div class="col-md-6">
		                    <div class="form-group">
		                      <label >Video ünvanı(youtube link) <span class="required">*</span></label>
		                      <input type="text" name="video_url" class="form-control" placeholder="Url daxil edin..." >
		                    </div>
		                  </div>
		                </div>
		                <div class="row">
		                  <div class="col-md-8">
		                    <div class="form-group">
		                      <label >Video başlıqı (AZ) <span class="required">*</span></label>
		                       <textarea name="title_az" class="form-control" rows="2" placeholder="Video başlıqını daxil edin..."></textarea>
		                    </div>
		                  </div>
		                  <div class="col-md-8">
		                    <div class="form-group">
		                      <label >Video başlıqı (EN) <span class="required">*</span></label>
		                      <textarea name="title_en" class="form-control" rows="2" placeholder="Video başlıqını daxil edin..."></textarea>
		                    </div>
		                  </div>
		                   <div class="col-md-8">
		                    <div class="form-group">
		                      <label >Video başlıqı (RU) <span class="required">*</span></label>
		                      <textarea name="title_ru" class="form-control" rows="2" placeholder="Video başlıqını daxil edin..."></textarea>
		                    </div>
		                  </div>
		                </div>
		                <div class="row">
		                  <div class="col-md-8">
		                    <div class="form-group">
		                      <label>Şəkil (Cover)<span class="required">*</span></label>
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
		                      <input type="text" name="add_date" class="form-control" placeholder="2020-12-31 17:52:00">
		                      <span class="text-red">Qeyd: Əgər bu xananı boş buraxsanız əlavə olunma tarixi kimi hal hazırki tarix qeyd olunacaq.</span>
		                    </div>
		                  </div>
		                </div>
		              </div>
	             
	            </div>
	            <div class="box-footer ">
					<a href="<?php echo base_url('admin/video'); ?>" class="btn btn-default">Geri</a>
					<button type="submit" class="btn btn-info pull-right">Əlavə et</button>
				</div>
			  <?=form_close()?>
</section>
