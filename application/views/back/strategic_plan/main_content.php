<!-- Main content -->
  <section class="content">
    <div class="row">
      <div class="col-xs-12">

        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Strateji Plan</h3>
            
          </div>
          <?php echo $this->session->flashdata('update_datatable'); ?>
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
               
                <th style="width: 20px;">Başlıq AZ</th>
               
                <th>Məlumat AZ</th>

                  <th>Status</th>



                  <th>Əməliyyatlar</th>
              </tr>
              </thead>
              <tbody>
               
              <tr>
               
                <td><?php echo word_limiter($details['title_az'], 4) ; ?></td>
              
                <td><?php echo word_limiter($details['description_az'], 4) ; ?></td>

                  <td><input class="toggle_check" data-onstyle="success" data-on="Aktiv"
                             data-offstyle="danger" data-off="Passiv" type="checkbox" data-toggle="toggle"
                             dataID="<?php echo $details['id']; ?>"
                             dataURL="<?php echo base_url('admin/strategic_plan_set?token='.createToken().''); ?>" <?php echo ($details['status'] == 1) ? 'checked' : ''; ?> />
                  </td>

               
                <td><a href="<?php echo base_url('admin/edit_strategic_plan'); ?>"><button type="button" name="button" class="btn btn-primary">Dəyiş</button></a>
                  
                </td>
              </tr>
          
            </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </section>
