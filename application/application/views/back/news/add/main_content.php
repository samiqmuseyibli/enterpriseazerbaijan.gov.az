<section class="content">
        <div class="box box-info" >
			<div class="box-header with-border">
				<h3 class="box-title">Xəbər əlavə etmə Formu</h3>
			</div>
			<?php echo form_open(base_url('admin/news_adding'),array('class' => "form-horizontal container", 'method'=>"post",'enctype'=>"multipart/form-data" ));?>
			<div class="box-body">
			   <input type="hidden" name="token" value="<?=createToken();?>">
                           <div class="form-group">
				<label for="information" class="col-sm-2 control-label">Başlıq AZ</label>
				<div class="col-sm-8 ">
                                    <textarea name="title_az" rows="2" cols="80"></textarea>
				</div>
			   </div>
			   <div class="form-group">
				<label for="information" class="col-sm-2 control-label">Başlıq EN</label>
				<div class="col-sm-8 ">
                                    <textarea  name="title_en" rows="2" cols="80"></textarea>
				</div>
			   </div>
		           <div class="form-group">
				<label for="information" class="col-sm-2 control-label">Başlıq RU</label>
				<div class="col-sm-8 ">
                                      <textarea  name="title_ru" rows="2" cols="80"></textarea>
				</div>
			   </div>
			   <div class="form-group">
				<label for="information" class="col-sm-2 control-label">Xəbər AZ</label>
				<div class="col-sm-8 ">
                                    <textarea id="editor1" name="content_az" rows="8" size="50"></textarea>
				</div>
			   </div>
			   <div class="form-group">
				<label for="information" class="col-sm-2 control-label">Xəbər EN</label>
				<div class="col-sm-8 ">
                                     <textarea id="editor2" name="content_en" rows="8" cols="50"></textarea>
				</div>
			    </div>
			    <div class="form-group">
			        <label for="information" class="col-sm-2 control-label">Xəbər RU</label>
			        <div class="col-sm-8 ">
                                     <textarea id="editor3" name="content_ru" rows="8" cols="50"></textarea>
				</div>
			    </div>
                           <div class="form-group">
				<label for="image" class="col-sm-2 control-label">Əsas şəkil</label>
				<div class="col-sm-4 ">
				     <input type="file" name="image" value="" class="form-control" id="image">
				</div>
                           </div>
                           <hr>
	                   <div class="row">     
		                   <div class="col-md-3" style="text-align: center;">
		                    <div class="form-group">
		                      <label >Əlavə olunma tarixi <br><span style="font-size: 14px;" class="text-blue">(Nümunə: 2020-12-31 17:52:00)</span></label>
		                      <input type="text" name="add_date" class="form-control" placeholder="2020-12-31 17:52:00">
		                    </div>
		                    <span class="text-red">Qeyd: Əgər bu xananı boş buraxsanız əlavə olunma tarixi kimi hal hazırki tarix qeyd olunacaq.</span>
		                  </div>
		           </div>	
			 </div>
			<div class="box-footer col-sm-10 ">
			<a href="<?php echo base_url('admin/news'); ?>"  class="btn btn-default">Ləğv et</a>
			<button type="submit" class="btn btn-info pull-right">Əlavə et</button>
			</div>
	        </form>
        </div>
</section>
