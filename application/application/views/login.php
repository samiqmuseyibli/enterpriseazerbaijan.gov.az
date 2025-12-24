	<div class="clearfix"></div>

	<div class="page_title2 sty2">
		<div class="container"> 
			<h1><?php echo translate('login');?></h1>
			<div class="pagenation">&nbsp;<a href="<?php echo base_url($l);?>"><?php echo translate('home_page');?></a> <i>/</i> <?php echo translate('login');?></div>    
		</div>
	</div><!-- end page title -->
	
	<div class="clearfix"></div>
	<div class="content_fullwidth less2">
		<div class="container">
			<div class="logregform">
				<div class="title">
					<h3><?php echo translate('sign_in');?></h3>
					<p><?php echo translate('do_you_not_account');?> &nbsp;<a style="color:#cf000f" href="<?php echo base_url($l.'/user/register'); ?>"><?php echo translate('okey_register_now');?></a></p>
				</div>
				<div class="feildcont"> 
					<?php echo form_open(base_url($l.'/user/login_user'),array('role' => "form",'method'=>"post"));?>            
						
						<label><i class="fa fa-user"></i> <?php echo translate('email');?></label>
						<input type="email" name="user_email" id="uemail"/> 
						
						<label><i class="fa fa-lock"></i> <?php echo translate('password');?></label>
						<input type="password" name="user_password" id="upsw" autocomplete="off" />  
						
					    <div class="one_half" style="margin-bottom:15px;">
						   <div class="g-recaptcha"  data-sitekey="<?=$this->config->item('google_key')?>"></div>  
					    </div> 
						
						<input type="hidden" name="redirect_url" value="<?php echo $redirect_url;?>"  />
						
						<label><a style="color:#cf000f; font-size: 16px;" href="<?php echo base_url($l.'/user'); ?>/password_reset"><?php echo translate('forget_password');?></a></label>
						<button type="submit" class="fbut"><i class="fa fa-sign-in"> </i> <?php echo translate('login');?></button>
					</form>
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div><!-- end content area -->
	<div class="clearfix divider_line9 lessm"></div>
	<div class="clearfix"></div>
