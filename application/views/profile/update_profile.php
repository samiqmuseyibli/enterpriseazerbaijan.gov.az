<div class="container">
  <div class="col-md-2"></div>
    <div class="col-md-8">  <div id="pencere" class="logregform two">
        <div class="title">
         <h3><?php  echo translate('update_your_profile');?></h3>
        </div>
        <?php foreach($user_info as $row) {?>
        <div class="feildcont">
          <?php echo form_open(base_url('user/user_update_profile'),array('role' => "form",'method'=>"post"));?>  
              <form action="<?php echo base_url('user/user_update_profile'); ?>" method="post" role="form">
            
                 <label><i class="fa fa-male"></i> <?php  echo translate('your_name');?></label>
                <input type="text" name="name" id="upsw" value="<?php echo  $row['user_name'];?>" required />
                
                <div class="clearfix"></div>
              <div class="margin_bottom2"></div>
              <label><i class="fa fa-male"></i> <?php  echo translate('your_surname');?></label>
              <input type="text" name="surname" id="upsw" value="<?php echo $row['user_surname'];?>" required />

              <label><i class="fa fa-envelope"></i> <?php  echo translate('your_company');?></label>
              <input type="text" name="company" id="upsw" value="<?php echo  $row['company_name'];?>" required />
                
                <label><i class="fa fa-phone"></i> <?php  echo translate('your_home_numbwer');?></label>
              <input type="text" name="home_num" id="upsw" value="<?php echo  $row['work_number'];?>" required />
			  
			  <label><i class="fa fa-phone"></i> <?php  echo translate('your_phone_number');?></label>
              <input type="text" name="phone_num" id="upsw" value="<?php echo  $row['mobil_number'];?>" required />
                
                <button style="float:right;" type="submit" class="fbut"> <?php  echo translate('update_profile');?></button>
         
            </form>
        
        </div>
		<?php }?>       
  </div>
</div>
</div>




