<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Xəbəri redaktə et</h3>
        </div>

        <div class="box-body">
	        <?php echo form_open(base_url('admin/updating_news'), array('class' => "form-horizontal  container", 'method' => "post", 'enctype' => "multipart/form-data")); ?>
            <div class="form-group">
                <div class="col-sm-4 ">
                    <input type="hidden" name="id" value="<?php echo $detail['id']; ?>" class="form-control">
                    <input type="hidden" name="image_url" value="<?php echo $detail['url_image']; ?>" class="form-control">
                    <input type="hidden" name="token" value="<?=createToken();?>">
                </div>
            </div>
            <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Başlıq AZ</label>
                <div class="col-sm-10 ">
                    <textarea name="title_az" rows="2" cols="80"><?php echo $detail['title_az']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Başlıq EN</label>
                <div class="col-sm-10 ">
                    <textarea name="title_en" rows="2" cols="80"><?php echo $detail['title_en']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Başlıq RU</label>
                <div class="col-sm-10 ">
                    <textarea name="title_ru" rows="2" cols="80"><?php echo $detail['title_ru']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Xəbər AZ</label>
                <div class="col-sm-10 ">
                    <textarea id="editor1" name="content_az" rows="8"
                              cols="80"><?php echo $detail['content_az']; ?> </textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Xəbər EN</label>
                <div class="col-sm-10 ">
                    <textarea id="editor2" name="content_en" rows="8"
                              cols="80"><?php echo $detail['content_en']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Xəbər RU</label>
                <div class="col-sm-10 ">
                    <textarea id="editor3" name="content_ru" rows="8"
                              cols="80"><?php echo $detail['content_ru']; ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label for="price" class="col-sm-2 control-label">Əsas şəkil</label>
                <div class="col-sm-4 ">
                    <img class="img-fluid" style="max-height: 400px"
                         src="<?php echo base_url('assets/front/images/news/'); ?><?php echo $detail['url_image']; ?> ">
                </div>
            </div>
            <div class="form-group">
				<label for="price" class="col-sm-2 control-label">Digər şəkillər</label>
				<div class="col-sm-8 ">
					<div class="timeline-item">
						<div class="timeline-body">
							<?php foreach ($details as $detail){
								?>
								<img style="height: 150px" class="margin" src="<?php echo base_url('assets/front/images/news/'); ?><?php echo $detail['file_url']; ?>" />
								<?php
							}?>
						</div>
					</div>
				</div>
			</div>
             <div class="form-group">
                <label for="image" class="col-sm-2 control-label">Əsas şəkli dəyiş</label>
                <div class="col-sm-4 ">
                    <input type="file" name="image" accept="image/*" value="" class="form-control" id="image">
                </div>
            </div>
            <hr>
			<div class="row">     
                           <div class="col-md-3" style="text-align: center;">
                            <div class="form-group">
                              <label >Əlavə olunma tarixi <br><span style="font-size: 14px;" class="text-blue">(Nümunə: 2020-12-31 17:52:00)</span></label>
                              <input value="<?php echo $detail['date']; ?>" type="text" name="add_date" class="form-control" placeholder="2020-12-31 17:52:00">
                            </div>
                            <span class="text-red">Qeyd: Əgər bu xananı boş buraxsanız əlavə olunma tarixi kimi hal hazırki tarix qeyd olunacaq.</span>
                          </div>
            </div>   
			
		</div>
		
	</div>
	<div class="box-footer ">
		<a href="<?php echo base_url('admin/news'); ?>" class="btn btn-default">Geri</a>
		<button type="submit" class="btn btn-info pull-right">Dəyiş</button>
	</div>
	</form>
        
    </div>
</section>
