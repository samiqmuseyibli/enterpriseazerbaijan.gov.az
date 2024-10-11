<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Haqqımızda</h3>
            
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
               
                <th style="width: 20px;">Başlıq AZ</th>
               
                <th>Məksəd AZ</th>
               
                <th>Missiya AZ</th>
              
                <th>Hədəf AZ</th>
                
               
                <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
               
              <tr>
               
                <td><?php echo word_limiter($details['basliq_az'], 4) ; ?></td>
              
                <td><?php echo word_limiter($details['meksed_az'], 4) ; ?></td>
            
                <td><?php echo  word_limiter($details['missiya_az'], 4); ?></td>
                
                <td><?php echo word_limiter($details['hedef_az'], 4); ?></td>
               
               
                <td><a href="<?php echo base_url('admin/edit_about_content'); ?>"><button type="button" name="button" class="btn btn-primary">Dəyiş</button></a>
                  
                </td>
              </tr>
          
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
