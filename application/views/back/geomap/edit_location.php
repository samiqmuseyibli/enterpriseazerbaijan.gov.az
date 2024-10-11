  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Yerlər</h3>
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <h3 style="margin-left:10px;" class="card-title">Siyahı: <?=$result_count?></h3>
          <div class="box-body">
            <table  class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th style="width: 100px;">Ad</th>
                <th style="width: 250px;">Məlumat</th>
		            <th style="width: 250px;">Websayt</th>
		            <th>Status</th>
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
                <?php  foreach ($all as $detail) { ?>
              <tr>
                <td><?php echo $detail['geo_id'] ?></td>
                <td><?php echo $detail['geo_name_az'];?></td>
                <td><?php echo $detail['geo_description_az']; ?></td>
                <td><?php echo $detail['geo_url'];?></td>
                 <td>   <input  class="toggle_check"
                       data-onstyle="success"
                       data-on="Aktiv"
                       data-offstyle="danger"
                       data-off="Passiv"
                       type="checkbox"
                       data-toggle="toggle"
                       dataID=  "<?php  echo $detail['geo_id']; ?>"
                       dataURL="<?php  echo base_url('admin/geoprojectsset?token='.createToken().'');   ?>"
                       <?php echo ($detail['geo_status']==1) ? 'checked' : ''; ?>

                /></td>
                <td><a href="<?php echo base_url('admin/update_location/'.$detail['geo_id'].''); ?>"><button type="button" name="button" class="btn btn-primary"><i class="fa fa-edit"> </i> Redaktə et</button></a>
                    <a  onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_location/'.$detail['geo_id'].'?token='.createToken().''); ?>"><button type="button" name="button" class="btn btn-warning"><i class="fa fa-trash"> </i> Sil</button></a>
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
