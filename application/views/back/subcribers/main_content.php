<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">İzləyicilər</h3>
             <a href="<?php echo base_url('admin/mail_subcribers'); ?> " class="btn btn-primary pull-right"><i class="fa fa-envelope" type="button" style="padding-right: 4px;"></i><b>Izləyicilərə Mesaj Göndər</b></a>
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <h3 style="margin-left:10px;" class="card-title">Siyahı: <?=$result_count?></h3>
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th>E-mail</th>
                <th>Tarix</th>
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
                <?php foreach ($details as $detail) { ?>
              <tr>
                <td><?php echo $detail['id']; ?></td>
                <td><?php echo $detail['email']; ?></td>
                <td><?php echo $detail['date']; ?></td>
                <td>
                    <a  onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_subcriber/'.$detail['id'].'?token='.createToken().''); ?>"><button type="button" name="button" class="btn btn-warning"><i class="fa fa-trash"> </i> Sil</button></a>
                </td>
              </tr>
            <?php } ?>
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
