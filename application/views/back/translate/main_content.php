  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Saytın Tərcüməsi</h3>
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <h3 style="margin-left:10px;" class="card-title">Siyahı: <?=$result_count?></h3>
          <div class="box-body">
            <table class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th>Açar söz</th>
                <th>Azərbaycan</th>
                <th>İngilis</th>
                <th>Rus</th>
                <th>Əməliyatlar</th>
              </tr>
              </thead>
              <tbody>
                <?php foreach ($details as $detail) { ?>
              <tr>
                <td><?php echo $detail['word_id']; ?></td>
                <td><?php echo $detail['word']; ?></td>
                <td><?php echo  word_limiter($detail['Azerbaijan'], 2);?></td>
                <td><?php echo word_limiter($detail['English'], 2);?></td>
                <td><?php echo word_limiter($detail['Russian'], 2);?></td>
              
                <td><a href="<?php echo base_url('admin/update_site_translation/'.$detail['word_id'].''); ?>"><button type="button" name="button" class="btn btn-primary"><i class="fa fa-edit"> </i> Redaktə et</button></a>
                    <a  onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_site_translation/'.$detail['word_id'].'?token='.createToken().''); ?>"><button type="button" name="button" class="btn btn-warning"><i class="fa fa-trash"> </i> Sil</button></a>
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
