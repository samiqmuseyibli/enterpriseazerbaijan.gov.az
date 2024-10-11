<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Kateqoriyalar</h3>
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th>Ad</th>
                <th>Tarix</th>
                <th>Status</th>
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
                <?php $count = 1; foreach ($details as $detail) { ?>
              <tr>
                <td><?php echo $count++ ?></td>
                <td><?php echo $detail['kat_adi_az']; ?></td>
                <td><?php echo $detail['kat_tarix'];?></td>
                <td>   <input  class="toggle_check"
                       data-onstyle="success"
                       data-on="Aktiv"
                       data-offstyle="danger"
                       data-off="Passiv"
                       type="checkbox"
                       data-toggle="toggle"
                       dataID=  "<?php  echo $detail['kat_id']; ?>"
                       dataURL="<?php  echo base_url('admin/project_categoryset?token='.createToken().'');   ?>"
                       <?php echo ($detail['status']==1) ? 'checked' : ''; ?>

                ></td>
                <td><a href="<?php echo base_url('admin/update_project_category/'.$detail['kat_id'].''); ?>"><button type="button" name="button" class="btn btn-primary">Dəyiş</button></a>
                </td>
              </tr>
            <?php } ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
