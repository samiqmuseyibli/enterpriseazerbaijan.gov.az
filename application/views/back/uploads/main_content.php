<section class="content">
    <div class="row">
		<div class="col-xs-12">
			<div class="box">
				<div class="box-header">
					<h3 class="box-title">Fayllar</h3>
					<a href="<?php echo base_url('admin/uploadfile'); ?> " class="btn btn-primary pull-right"><i class="fa fa-plus" type="button" style="padding-right: 4px;"></i><b>Əlavə et</b></a>
				</div>
				<?php echo $this->session->flashdata('update_datatable'); ?>
				<h3 style="margin-left:10px;" class="card-title">Siyahı: <?=$result_count?></h3>
				<div class="box-body">
					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th style="width: 20px;">№</th>
								<th>Təsvir</th>
								<th>Fayl Linki</th>
								<th>Tarix</th>
								<th>Əməliyyatlar</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($details as $detail) {
								?>
								<tr>
									<td><?php echo $detail['id']; ?></td>
									<?php
										if($detail['news_id'] !=0){
											?>
											<td style="max-width: 80px; text-align:center"><img style="max-width: 60px;" src="<?php echo base_url('assets/front/images/news/').$detail['file_url']; ?>"></td>
											<?php
										}else{
											
											if(substr($detail['file_url'], -4) == '.pdf'){
												?>
												<td style="max-width: 80px; text-align:center"><img style="max-width: 60px;" src="<?php echo base_url('assets/front/images/uploads/1543656712pdf-icon.png');?>" alt="" /></td>
												<?php
											}else{
												?>
												<td style="max-width: 80px; text-align:center"><img style="max-width: 60px;" src="<?php echo base_url('assets/front/images/uploads/').$detail['file_url']; ?>"></td>
												<?php
											}
										}
									?>
									<?php
										if($detail['news_id'] !=0){
											?>
											<td><a target="_blank" href="<?php echo base_url('assets/front/images/news/').$detail['file_url']; ?>"><?php echo base_url('assets/front/images/news/').$detail['file_url']; ?></a></td>
											<?php
										}else{
											?>
											<td><a target="_blank" href="<?php echo base_url('assets/front/images/uploads/').$detail['file_url']; ?>"><?php echo base_url('assets/front/images/uploads/').$detail['file_url']; ?></a></td>
											<?php
										}
									?>
									<td><?php echo $detail['date'];?></td>  
									<td><a onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_file/'.$detail['id'].'?token='.createToken().''); ?>"><button type="button" name="button" class="btn btn-warning"><i class="fa fa-trash"> </i> Sil</button></a></td>
								</tr>
								<?php 
							}?>
						</tbody>
					</table>
					<?php if (isset($pagination)): ?>
                        <?php if (!empty($pagination)): ?>
                        <div class="card-footer">
                          <nav aria-label="Contacts Page Navigation">
                            <?=$pagination?>
                          </nav>
                        </div>
                        <?php endif ?>
                    <?php endif ?>
				</div>
			</div>
		</div>
    </div>
</section>
