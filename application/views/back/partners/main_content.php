<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Tərəfdaşlarımız</h3>
            <a href="<?php echo base_url('admin/partner_add'); ?> " class="btn btn-primary pull-right"><i class="fa fa-plus" type="button" style="padding-right: 4px;"></i><b>Əlavə et</b></a>
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th>Şəkil</th>
                <th>Web Sayt</th>
                <th>Tarix</th>
                <th >Status</th>
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
                <?php $count = 1; foreach ($details as $detail) { ?>
              <tr>
                <td><?php echo $count++ ?></td>
                <td><img style="max-height: 100px" src="<?php echo base_url('assets/front/images/');?><?php echo $detail['url_image'];?> "></td>
                <td><?php echo $detail['web_site']; ?></td>
                <td><?php echo $detail['date'];?></td>
                <td>   <input  class="toggle_check"
                       data-onstyle="success"
                       data-on="Aktiv"
                       data-offstyle="danger"
                       data-off="Passiv"
                       type="checkbox"
                       data-toggle="toggle"
                       dataID=  "<?php  echo $detail['id']; ?>"
                       dataURL="<?php  echo base_url('admin/partnersset?token='.createToken().'');   ?>"
                       <?php echo ($detail['status']==1) ? 'checked' : ''; ?>

                ></td>
                <td><a href="<?php echo base_url('admin/update_partner/'.$detail['id'].''); ?>"><button type="button" name="button" class="btn btn-primary">Dəyiş</button></a>
                    <a  onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_partner/'.$detail['id'].'?token='.createToken().''); ?>"><button type="button" name="button" class="btn btn-warning">Sil</button></a>
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
