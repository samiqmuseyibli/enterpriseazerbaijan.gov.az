  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">İstifadəçilər</h3>   
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
            <h3 class="card-title">Siyahı: <?=$result_count?></h3>
            <table  class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th>Adı</th>
                <th>Soyadi</th>
                <th>Mail</th>
                <th>Vəzifə</th>
                <th>Nomre</th>
                <th >Status</th>
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
                <?php foreach ($users as $user) { ?>
              <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['user_name']; ?></td>
                <td><?php echo $user['user_surname']; ?></td>
                <td><?php echo $user['user_mail'];?></td>
                <td><?php echo $user['user_role'];?></td>
                <td><?php echo $user['mobil_number']; ?></td>
                <td>   <input  class="toggle_check"
                       data-onstyle="success"
                       data-on="Aktiv"
                       data-offstyle="danger"
                       data-off="Passiv"
                       type="checkbox"
                       data-toggle="toggle"
                       dataID=  "<?php  echo $user['id']; ?>"
                       dataURL="<?php  echo base_url('admin/usersset?token='.createToken().'');   ?>"
                       <?php echo ($user['user_status']==1) ? 'checked' : ''; ?>

                ></td>
                <td><a href="<?php echo base_url('admin/edit_user/'.$user['id'].''); ?>"><button type="button" name="button" class="btn btn-primary">Redaktə et</button></a>
                    <a  onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_user/'.$user['id'].'?token='.createToken().''); ?>"><button type="button" name="button" class="btn btn-warning">Sil</button></a>
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
