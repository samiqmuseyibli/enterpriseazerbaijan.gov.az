<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Şirkətlər</h3>
            <a href="<?php echo base_url('admin/company_add'); ?> " class="btn btn-primary pull-right"><i class="fa fa-plus" type="button" style="padding-right: 4px;"></i><b>Əlavə et</b></a>
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <h3 style="margin-left:10px;" class="card-title">Siyahı: <?=$result_count?></h3>
          <div class="box-body">
            <table  class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th>Ad</th>  
                  <th>Ünvan</th>  
                 <th>lng</th>
                  <th>lat</th>
                  <th>Status</th>  
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
                <?php foreach ($details as $detail) { ?>
              <tr>
                <td><?php echo $detail['id']; ?></td>
               <td><?php echo $detail['name']; ?></td>
                  <td><?php echo $detail['address']; ?></td>
                <td><?php echo $detail['lng']; ?></td>
                 <td><?php echo $detail['lat']; ?></td>
                 <td>   <input  class="toggle_check"
                       data-onstyle="success"
                       data-on="Aktiv"
                       data-offstyle="danger"
                       data-off="Passiv"
                       type="checkbox"
                       data-toggle="toggle"
                       dataID=  "<?php  echo $detail['id']; ?>"
                       dataURL="<?php  echo base_url('admin/companyset?token='.createToken().'');   ?>"
                       <?php echo ($detail['status']==1) ? 'checked' : ''; ?>

                /></td>
               
                <td><a href="<?php echo base_url('admin/update_company/'.$detail['id'].''); ?>"><button type="button" name="button" class="btn btn-primary"><i class="fa fa-edit"> </i> Redaktə et</button></a>
                    <a  onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_company/'.$detail['id'].'?token='.createToken().''); ?>"><button type="button" name="button" class="btn btn-warning"><i class="fa fa-trash"> </i> Sil</button></a>
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
