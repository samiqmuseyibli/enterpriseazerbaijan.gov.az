<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Tənzimləmələr</h3>
           
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th >Logo </th>
                <th>Ünvan</th>
                <th>Telefon</th>
                <th>Telefon</th>
                <th >Email</th>
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
               
              <tr>
                <td><img style="max-height: 100px" src="<?php echo base_url('assets/front/images/');?><?php echo $detail['logo_url'];?> "></td>
               
                <td><?php echo $detail['adress_az']; ?></td>
                <td><?php echo $detail['tel1'];?></td>
                <td><?php echo $detail['tel2'];?></td>
                <td><?php echo $detail['mail'];?></td>
               
                <td><a href="<?php echo base_url('admin/update_settings'); ?>"><button type="button" name="button" class="btn btn-primary">Dəyiş</button></a>
                </td>
              </tr>
          
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
