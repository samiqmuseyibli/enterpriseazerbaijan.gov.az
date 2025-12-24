<div class="content_right">
    <?php 
	foreach($user_details as $row) {
		?>
		<h3><strong><?php echo translate('welcome!');?></strong> <?php echo translate('dear');?> <?php echo  $row['user_name'];?></h3>
        <div id="user-profile-card" class="card">
            <img src="<?php echo base_url();?>assets/front/images/user-logo.png" alt="<?php echo  $row['user_name'];?>" style="width:70%">
            <h1><?php echo $row['user_name']," ".$row['user_surname'];?></h1>
            <p class="title"><?php echo  $row['company_name'];?></p>
            <p><?php echo  $row['user_mail'];?></p>
            <p><?php echo  $row['mobil_number'];?></p>
            <p><?php echo  $row['work_number'];?></p>
           <p><a style="cursor:pointer;" href="<?php echo base_url($l);?>/user/update_profile"><?php echo translate('update_your_profile');?> </a></p>
        </div>
        <div class="clearfix margin_top3"></div>
       <?php 
	}
	?>
</div>