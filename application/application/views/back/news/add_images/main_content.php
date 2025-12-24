<section class="content">
    <div class="box box-info" >
        <div class="box-header with-border">
            <h3 class="box-title">Xəbərə şəkil əlavə et</h3>
        </div>
		<div class="box-body">
			<div class="form-group">
				<div class="col-sm-12 ">
					<b><?php echo $detail['id'].'-'.$detail['title_az']; ?></b>
				</div>
			</div>
			<br />
			<div class="form-group">
				<?php echo form_open(base_url('admin/uploading_news_image/'), array('class' => "dropzone", 'id'=>"dropzone_id", 'enctype'=>"multipart/form-data"));?>
					<input type="hidden" name="news_id" value="<?php echo $detail['id']; ?>" class="form-control" >
					 <input type="hidden" name="token" value="<?=createToken();?>">
				</form>
				<h5><strong>Şəkil formatı:</strong> <span style="color:red"> jpg, jpeg, png və həcmi 1Mb-a qədər olmalıdır. </span></h5>
			</div>
			<div class="box-footer ">
				<a onclick="return confirm('Şəkillər uğurla yüklənmişdir');" href="<?php echo base_url('admin/upload_news_image/').$detail['id']; ?>"  class="btn btn-default pull-right">Yenilə</a>
			</div>
			<div class="form-group">
					<table id="example1" class="table table-bordered table-striped">
                    <thead>
						<th style="width: 20px;">#</th>
                        <th style="width: 80px;">Rəsm</th>
                        <th>Rəsmin adı</th>
                        <th>Əməliyyat</th>
                    </thead>
                    <tbody>
						<?php $count = 1; foreach ($details as $detail) {
							?>
							<tr>
								<td><?php echo $count++ ?></td>
								<td style="text-align:center"><img style="max-width: 60px" src="<?php echo base_url('assets/front/images/news/'); ?><?php echo $detail['file_url']; ?>" /></td>
								<td><?php echo $detail['file_url']; ?></td>
			<td><a onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_news_image/').$detail['id'].'?token='.createToken();?>"><button type="button" name="button" class="btn btn-warning">Sil</button></a></td>
							</tr>
							<?php
						}?>
                        
                    </tbody>
                </table>
			</div>
		</div>
		
	</div>
</section>
