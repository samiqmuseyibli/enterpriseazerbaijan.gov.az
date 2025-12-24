  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Layihələr</h3>
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <h3 style="margin-left:10px;" class="card-title">Siyahı: <?=$result_count?></h3>
          <div class="box-body">
            <table  class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th>Layihə Adı</th>
                <th>Kateqoriyası</th>
                <th>Istifadəçi</th>
                <th>Status</th>
                <th>Tarix</th>   
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
                <?php foreach ($projects as $project) { ?>
              <tr>
                <td><?php echo $project['project_id']; ?></td>
                <td><a target="_blank" href="<?php  echo base_url('project/detail/').$project['project_id'];?>"><?php echo $project['project_title']; ?></a></td>
                <td><?php echo $project['kat_adi_az']; ?></td>
                <td><?php echo $project['user_name']." ".$project['user_surname'];?></td>
                <?php if( $project['isActive']== 1){ echo'   <td><span class="label label-success">Aktiv</span></td> '; }  ?>
                <?php if( $project['isActive']== 0){ echo'  <td><span class="label label-warning">Gözləmədə(tərcümə)</span></td> '; }  ?>
                <?php if( $project['isActive']== 2){ echo'   <td><span class="label label-danger">Silinib</span></td> '; }  ?>
                <?php if( $project['isActive']== 3){ echo'   <td><span class="label label-warning">Gözləmədə(təsdiq)</span></td> '; }  ?>
                <td><?php echo $project['add_date']; ?></td>   
                <td>
                    <a  onclick="return confirm('Silməyə əminsinizmi?');" href="<?php echo base_url('admin/delete_project/'.$project['project_id'].'?token='.createToken().''); ?>"><button type="button" name="button" class="btn btn-warning"><i class="fa fa-trash"> </i> Sil</button></a>
                </td>
              </tr>
            <?php }  ?>
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
