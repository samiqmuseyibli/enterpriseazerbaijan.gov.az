	<div class="clearfix"></div>
	<div class="page_title2 sty2">
		<div class="container">  
			<h1><?php echo translate('recovery_form');?></h1>
			<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/</i> <?php echo translate('recovery_form');?></div> 
		</div>
	</div>
	<!-- end page title -->
	
	<div class="clearfix"></div>
	<div class="content_fullwidth less2">
		<div class="container">
			<div class="logregform">
				<div class="title">
					<h3><?php echo translate('password_recovery');?></h3>
				</div>
				<div class="feildcont"> 
					<?php echo form_open(base_url('user/reset_password'),array('role' => "form",'method'=>"post"));?>               
						
						<label><i class="fa fa-user"></i> <?php echo translate('email');?></label>
						<input type="email" name="user_mail" id="uemail" required />
						
						<div style="float:left">
							<img class="img-captcha" src="<?php echo base_url().'user/getCaptcha';?>"/>
										<img alt="Reload" onclick="return(reloadCaptcha());" class="img-reload" src="<?php echo base_url();?>assets/captcha/reload.png">
										<div style="width:180px">
							<input type="text" name="captchaCode" id="captcha" placeholder="<?php echo translate('enter');?>" required />
						</div>
						</div>
						
						
						<button type="submit" class="fbut"><?php echo translate('send');?></button>
					</form>
					
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div><!-- end content area -->
	<div class="clearfix divider_line9 lessm"></div>
	<div class="clearfix"></div>
	
	
