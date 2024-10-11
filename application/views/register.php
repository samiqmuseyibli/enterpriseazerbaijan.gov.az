	<div class="clearfix"></div>
	<div class="page_title2 sty2">
		<div class="container">
			<h1><?php echo translate('register');?></h1>
			<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/</i> <?php echo translate('register');?></div> 
		</div>
	</div><!-- end page title -->

	<div class="clearfix"></div>

	<div class="content_fullwidth less2">
		<div class="container">
			<div class="logregform two">
				<div class="title">
					<h3><?php echo translate('register');?></h3>
					<p><?php echo translate('do_you_have_account');?> &nbsp;<a style="color:#cf000f" href="<?php echo base_url('user/login'); ?>"><?php echo translate('okey_login_now');?></a></p>
				</div>
				<div class="feildcont">
					<?=form_open(base_url('user/register_user'),array('role' => "form",'method'=>"post"));?> 
						
						<div class="one_half" style="padding-bottom: 15px;">
							<label><?php echo translate('Status');?> <em>*</em></label>
							<select onchange="setUserType(this.value);" required name="user_type">
								<option  value="">- <?php echo translate('choose_from_list');?> -</option>
								<option  value="1"> <?php echo translate('investor');?></option>
								<option  value="2">  <?php echo translate('sahibkar_subyekti');?></option>
							</select>
						</div>
							
						<div id="showsec">
							
						</div>

						<div >
						    <label for="company_name"> <?php echo translate('company_name');?></label>
						    <input type="text" name="company_name" id="company_name" value=""  />
						</div>
						<!-- # user first name # -->
						<div class="one_half">
							<label for="fname"> <?php echo translate('name');?> <em>*</em></label>
							<input type="text" name="name" id="fname" required />
						</div>
						
						<!-- # user last name # -->
						<div class="one_half last">
							<label for="lname"> <?php echo translate('surname');?> <em>*</em></label>
							<input type="text" name="surname" id="lname" required />
						</div>
						
						<!-- # user email # -->
						<label for="uemail"> <?php echo translate('email');?> <em>*</em></label>
						<input type="email" name="mail" id="uemail" required />
						
						<div class="one_half">
							<label for="upsw"> <?php echo translate('password');?> <em>*</em></label>
							<input type="password" autocomplete="off" name="pass" id="upsw" required />
						</div>
						
						<div class="one_half last">
							<label for="pass2"> <?php echo translate('confirm_password');?> <em>*</em></label>
							<input type="password" autocomplete="off" name="pass2" id="pass2" required />
						</div>
						
						<div class="clearfix"></div>
						<div class="margin_bottom2"></div>
						
						<div class="one_half">
							<label for="work_number"> <?php echo translate('Telephone');?> (<?php echo translate('work');?>:)</label>
							<input type="text" name="work_number" id="work_number" />
						</div>
						
						<div class="one_half last">
							<label for="mobil_number"> <?php echo translate('Telephone');?> (<?php echo translate('mobile');?>:) <em>*</em></label>
							<input type="text" name="mobil_number" id="mobil_number" required />
						</div>
                        <div class="one_half" style="margin-bottom:15px;">
						   <div class="g-recaptcha"  data-sitekey="<?=$this->config->item('google_key')?>"></div>  
					    </div> 
					    <br> 
			
						<label for="agree"><span style="font-size: 15px;"><?php echo translate('I accept terms and');?></span><a style="color:#cf000f; font-size: 15px;" href="<?php echo base_url('home/termsofuse');?>"><?php echo translate('conditions');?></a></label>
						
						<div class="one_half">
							<button type="submit" class="fbut"> <i class="fa fa-sign-in"> </i> <?php echo translate('create_account');?></button>
						</div>
						
						<div class="one_half last">
							<label style="margin-top:35px;"><a style="color:#2ecc71" href=""><?php echo translate('required');?></a></label>
						</div>
						
					 <?=form_close()?>
				</div>
			</div>
		</div>
	</div><!-- end content area -->
	<div class="clearfix divider_line9 lessm"></div>
	<div class="clearfix"></div>
	<script>
		function setUserType(varr) {
			if (varr == "1") {
				$.ajax({ 
					url: "<?php echo base_url();?>" + "user/showSectors",
					success: function(data) {
						$('#showsec').html(data);
					},
					error: function(e) {
						console.log(e)
					}
				});
			}else{
				$.ajax({ 
					success: function(data) {
						$('#showsec').hide();
					},
					error: function(e) {
						console.log(e)
					}
				});
			}
			
			setTimeout(function() {
				setSwitchery();
			}, 100);
		}
	</script>

