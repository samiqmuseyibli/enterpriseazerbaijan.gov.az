  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Mesajlar</h3>
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <h3 style="margin-left:10px;" class="card-title">Siyahı: <?=$result_count?></h3>
          <div class="box-body">
            <table  class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th>Ad/Soyad</th>     
                <th>Mövzu</th>
                <th>Tarix</th>
                <th>Status</th>
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
                <?php  foreach ($details as $detail) { ?>
              <tr>
                <td><?php echo $detail['id']; ?></td>
                <td><a href="<?php echo base_url('admin/read_message/'.$detail['id'].''); ?>"><?php echo $detail['name']; ?></a></td>
                 <td><a href="<?php echo base_url('admin/read_message/'.$detail['id'].''); ?>"><?php echo $detail['subject']; ?></a></td>
                 <td><?php echo $detail['date']; ?></td>
                <td><?php if ($detail['status']==0) {
                 echo '<span class="label label-warning">Oxunmayib</span>';
                }else{
                  echo '<span class="label label-success">Oxunub</span>'; 
                } 
                ?></td>                
                <td><a href="<?php echo base_url('admin/read_message/'.$detail['id'].''); ?>"><button type="button" name="button" class="btn btn-primary"><i class="fa fa-eye"> </i> Oxu</button></a>
                    <a  onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_message/'.$detail['id'].'?token='.createToken().''); ?>"><button type="button" name="button" class="btn btn-warning"><i class="fa fa-trash"> </i> Sil</button></a>
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
