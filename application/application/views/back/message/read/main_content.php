<!-- Main content -->
    <section class="content">
      <div class="row">
        
        <!-- /.col -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Mesaj</h3>

            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <div class="mailbox-read-info">
                <h3><?php echo $detail['subject'];?></h3>
                <h5>Kimdən: <?php echo $detail['name'];?>
                <h5>email: <?php echo $detail['mail'];?>
                  <span class="mailbox-read-time pull-right"><?php echo $detail['date'];?></span></h5>
              </div>
           
              <div class="mailbox-read-message">
                <?php echo $detail['message'];?>
              </div>
              <!-- /.mailbox-read-message -->
            </div>
           
            <!-- /.box-footer -->
            <div class="box-footer">
             <a href="<?php echo base_url('admin/messages');?>"  class="btn btn-default"><i class="fa fa-angle-left"></i> Geri</a>
             <a href="<?php echo base_url('admin/delete_message/'.$detail['id'].''); ?>"  class="btn btn-default"><i class="fa fa-trash-o"></i> Sil</a>
              <button type="button" class="btn btn-default"><i class="fa fa-print"></i> Çap et</button>
            </div>
            <!-- /.box-footer -->
          </div>
          <!-- /. box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>