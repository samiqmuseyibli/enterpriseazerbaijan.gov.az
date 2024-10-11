	<div class="clearfix"></div>

	
	
	<div class="clearfix"></div>
	<div class="content_fullwidth less2">
		<div class="container">
			<div class="logregform">
				<div class="title">
					<h3><?php echo translate('sign_in');?></h3>
					
				</div>
				<div class="feildcont"> 
					<?php echo form_open(base_url('competition/login/do'),array('role' => "form",'method'=>"post"));?>            
						
						
						
						<label><i class="fa fa-lock"></i> <?php echo translate('password');?></label>
						<input type="password" name="password" id="upsw" autocomplete="off" required />  
						
						           
		
						
			
						<button type="submit" class="fbut"><?php echo translate('login');?></button>
					</form>
				</div>
			</div>
			<div class="col-md-3"></div>
		</div>
	</div><!-- end content area -->
	<div class="clearfix divider_line9 lessm"></div>
	<div class="clearfix"></div>
