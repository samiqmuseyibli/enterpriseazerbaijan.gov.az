<section class="content">
        <div class="row">
                 <div class=" col-md-4  col-xs-6">
                    <div class="small-box bg-aqua">
                      <div class="inner">
                        <h3><?php echo $usercount = get_project_count_admin(); ?></h3>
                         <p>Layihə</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-lightbulb-o"></i>
                      </div>
                      <a href="<?php echo base_url('admin/projects'); ?>" class="small-box-footer">Layihələr <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class=" col-md-4  col-xs-6">
                    <div class="small-box bg-red">
                      <div class="inner">
                        <h3><?php echo $usercount = messagescount(); ?></h3>
                        <p>Baxılmamış müraciət</p>
                      </div>
                      <div class="icon">
                        <i class="fa fa-envelope"></i>
                      </div>
                      <a href="<?php echo base_url('admin/messages'); ?>" class="small-box-footer">Müraciətlər <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class=" col-md-4  col-xs-6">
                    <div class="small-box bg-yellow">
                      <div class="inner">
                        <h3><?php echo $usercount = get_user_count_admin_all(); ?></h3>
                        <p>Ümumi istifadəçi</p>
                       </div>
                       <div class="icon">
                         <i class="fa fa-user"></i>
                       </div>
                     <a href="<?php echo base_url('admin/users'); ?>" class="small-box-footer"> İstifadəçilər <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                  <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-lightbulb-o"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Dərc edilmiş layihə sayı</span>
                      <span class="info-box-number"><?php echo $usercount = get_active_project_count_admin();?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                  <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-envelope"></i></span>
                    <div class="info-box-content">
                      <span class="info-box-text">Baxılmış müraciət sayı</span>
                      <span class="info-box-number"><?php echo $usercount = readedmessagescount();?></span>
                    </div>
                  </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box">
                      <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">Aktiv istifadəçi sayı</span>
                        <span class="info-box-number"><?php echo $usercount = get_user_count_admin(); ?></span>
                      </div>
                    </div>
                </div>
        </div>
</section>