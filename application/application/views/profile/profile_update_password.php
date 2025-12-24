<div class="container">
<div class="col-md-6">
<div class="logregform" id="pencere">
        <div class="title">      
      <h3><?php echo translate('update_password');?></h3>         
        </div>    
        <div class="feildcont"> 
          <?php echo form_open(base_url($l.'/user/user_update_password'),array('role' => "form",'method'=>"post"));?>      
                    <label><i class="fa fa-lock"></i> <?php echo translate('old_password');?></label>
                    <input type="password" name="oldpass" id="upsw" required />               
                <div class="clearfix"></div>
                    <div class="margin_bottom2"></div>
                <label><i class="fa fa-lock"></i> <?php echo translate('new_password');?></label>
              <input type="password" name="newpass1" id="upsw" required />

              <label><i class="fa fa-lock"></i> <?php echo translate('confirm_new_password');?></label>
              <input type="password" name="newpass2" id="upsw" required />           
                <button type="submit" class="fbut"><?php echo translate('send');?></button>
            </form> 
        </div>
</div>
</div>
</div>



