<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Layihələr</h3>
            
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th style="width: 20px;">№</th>
                <th>Layihə Adı</th>
                <th>Kateqoriyası</th>
                <th>Istifadəçi</th>
                <th>Status</th>
                <th>Tarix</th>   
               <!--  <th>Əməliyyatlar</th> -->
              </tr>
              </thead>
              <tbody>
                <?php $count = 1;  foreach ($projects as $project) { ?>
              <tr>
                <td><?php echo $count++ ?></td>
                <td><a target="_blank" href="<?php  echo base_url('project/detail/').$project['project_id'];?>"><?php echo $project['project_title']; ?></a></td>
                <td><?php echo $project['kat_adi_az']; ?></td>
                <td><?php echo $project['user_name']." ".$project['user_surname'];?></td>
                <?php if( $project['isActive']== 1){ echo'   <td><span class="label label-success">Aktiv</span></td> '; }  ?>
                <?php if( $project['isActive']== 0){ echo'   <td><span class="label label-primary">Deaktiv</span></td> '; }  ?>
                 <?php if( $project['isActive']== 2){ echo'   <td><span class="label label-danger">Silinib</span></td> '; }  ?>
                  <?php if( $project['isActive']== 3){ echo'   <td><span class="label label-warning">Gozləmədə</span></td> '; }  ?>
                <td><?php echo $project['add_date']; ?></td>   
               
              </tr>
            <?php }  ?>
            </tbody>
            </table>
         
          </div>
        </div>
      </div>
    </div>
  </section>
