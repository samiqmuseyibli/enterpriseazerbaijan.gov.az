<section class="content">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Sənəd redaktə et</h3>
        </div>
	    <?php echo form_open(base_url('admin/updating_documents'), array('class' => "form-horizontal  container", 'method' => "post", 'enctype' => "multipart/form-data")); ?>
        <div class="box-body">
               <input type="hidden" name="token" value="<?=createToken();?>">
               <input type="hidden" name="id" value="<?=$detail->doc_id;?>">
               <div class="row">
                <div class="col-sm-6">
                   <div class="form-group">
                    <div class="col-sm-3">
                        <label  class="control-label">Sənədin tipi</label>
                    </div>
                    <div class="col-sm-6">
                       <select class="form-control" name="doc_category">
                        <option value="">- Seçin -</option>
                        <?php foreach ($categories as $key): ?>
                         <option 
                         <?php if ($key->dc_id == $detail->doc_category): ?>
                             <?php echo 'selected' ?>
                         <?php endif ?>
                         value="<?=$key->dc_id?>">-> <?=$key->dc_name_az?></option> 
                        <?php endforeach ?>
                       </select>
                       </div>
                   </div>   
                </div>
                <div class="col-sm-6">
                       <div class="form-group">
                    <label for="information" class="col-sm-6 control-label">Sənədin sıralaması</label>
                    <div class="col-sm-6">
                        <input type="number" value="<?=$detail->doc_sort;?>" name="doc_sort" class="form-control" placeholder="Sıra nömrəsi daxil edin">
                    </div>
                   </div>
                </div>
               </div>
               <hr>
                           <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Sənədin adı AZ</label>
                <div class="col-sm-8 ">
                                    <textarea name="title_az" rows="2" cols="80"><?=$detail->doc_title_az;?></textarea>
                </div>
               </div>
               <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Sənədin adı EN</label>
                <div class="col-sm-8 ">
                                    <textarea  name="title_en" rows="2" cols="80"><?=$detail->doc_title_en;?></textarea>
                </div>
               </div>
                   <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Sənədin adı RU</label>
                <div class="col-sm-8 ">
                                      <textarea  name="title_ru" rows="2" cols="80"><?=$detail->doc_title_ru;?></textarea>
                </div>
               </div>
               <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Sənəd AZ</label>
                <div class="col-sm-8 ">
                                    <textarea id="editor1" name="body_az" rows="8" size="50"><?=$detail->doc_body_az;?></textarea>
                </div>
               </div>
               <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Sənəd EN</label>
                <div class="col-sm-8 ">
                                     <textarea id="editor2" name="body_en" rows="8" cols="50"><?=$detail->doc_body_en;?></textarea>
                </div>
                </div>
                <div class="form-group">
                    <label for="information" class="col-sm-2 control-label">Sənəd RU</label>
                    <div class="col-sm-8 ">
                                     <textarea id="editor3" name="body_ru" rows="8" cols="50"><?=$detail->doc_body_ru;?></textarea>
                </div>
                </div>
            </div>
	
		
	</div>
	<div class="box-footer ">
		<a href="<?php echo base_url('admin/documents'); ?>" class="btn btn-default">Geri</a>
		<button type="submit" class="btn btn-info pull-right">Dəyiş</button>
	</div>
	</form>
        
    </div>
</section>
