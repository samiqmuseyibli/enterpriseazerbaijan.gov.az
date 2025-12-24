<section class="content">

        <div class="box box-info" >
          <div class="box-header with-border">
            <h3 class="box-title">İstifadəçi Redaktə Formu</h3>
          </div>

  <?php echo form_open(base_url('admin/update_user_data'),array('class' => "form-horizontal  container",'method'=>"post"));?>
            <div class="box-body">
              <!-- Input -->
              <input type="hidden" name="token" value="<?=createToken();?>">
              <div class="form-group">
                <label for="title" class="col-sm-2 control-label">Ad</label>
                <div class="col-sm-4 ">
                  <input type="text" name="user_name" value="<?php echo $user['user_name']; ?>" class="form-control" id="title">
                  <input type="hidden" name="id" value="<?php echo $user['id']; ?>" class="form-control" >
                  <input type="hidden" name="status" value="<?php echo $user['user_status']; ?>" class="form-control" >
                </div> 
              </div>
              <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Soyad</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="user_surname" value="<?php echo $user['user_surname']; ?>" class="form-control" id="price">
                   </div>         
               </div>  
               <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Mail</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="user_mail" value="<?php echo $user['user_mail']; ?>" class="form-control" id="price">
                   </div>         
               </div>  
               <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Mobil Nömrə</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="mobil_number" value="<?php echo $user['mobil_number']; ?>" class="form-control" id="price">
                   </div>         
               </div>  
               <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">İş Nömrəsi</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="work_number" value="<?php echo $user['work_number']; ?>" class="form-control" id="price">
                   </div>         
               </div>  
               <div class="form-group">
                   <label for="price" class="col-sm-2 control-label">Şirkət</label>
                   <div class="col-sm-4 ">
                     <input type="text" name="company_name" value="<?php echo $user['company_name']; ?>" class="form-control" id="price">
                   </div>         
               </div>  
                 <!-- Input -->
                 <div class="form-group">   
                   <label for="date" class="col-sm-2 control-label">Qeyd olunduğu Tarix</label>
                   <div class="col-sm-4 ">
                       <input type="text" name="reg_time" value="<?php echo $user['reg_time']; ?>" class="form-control" id="date">
                   </div>
                 </div>


                 <div class="form-group">   
                   <label for="date" class="col-sm-2 control-label">Vəzifə</label>
                   <div class="col-sm-4 ">
                       <select class="select" name="user_role">
                        <?php if ($user['user_role']==='user') {
                           $user="selected";
                          $moderator="";
                        }if ($user['user_role']==='moderator') {
                            $moderator="selected";
                            $user="";
                        }?>
                         <option <?php echo $moderator;?> value="moderator">Moderator</option>
                         <option <?php echo $user;?> value="user">User</option>

                       </select>
                   </div>
                 </div>

                  
            </div>

            <div class="box-footer ">


              <a href="<?php echo base_url('admin/users'); ?>"  class="btn btn-default">Ləğv et</a>
              <button  type="submit" class="btn btn-info pull-right">Dəyiş</button>


            </div>

          </form>
        </div>
</section>
