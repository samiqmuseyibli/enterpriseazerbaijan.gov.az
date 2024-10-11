<div class="clearfix"></div>
<div class="page_title2 sty2">
	<div class="container">
		<h1><?php echo translate('contact');?></h1>
		<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/ </i><?php echo translate('contact');?></div>
	</div>
</div><!-- end page title -->
<div class="clearfix"></div>
<div class="content_fullwidth less2">
	<div class="container">
		<div class="one_half">
			<div class="cforms_sty3">
                <?php if($this->session->flashdata('error_messages')){ ?>
					<div class="row">
						<div class="col-md-12 ">
							<div class="errormes">
								<div class="message-box-wrap">
									<?php echo $this->session->flashdata('error_messages'); ?>
								</div>
							</div>
						</div>
					</div>
					<br>
					<br>
					<?php }; ?>
				<div id="form_status"></div>
				<?php echo form_open(base_url('home/message'),array('id' => "gsr-contact",'method'=>"post",'onSubmit'=>"return valid_datas( this );" ));?>
					<label class="label"><?php echo translate('your_name');?> <em>*</em></label>
					<label class="input">
						<input type="text" name="name" id="name"  />
					</label>
					
					<div class="clearfix"></div>
					<label class="label"><?php echo translate('e-mail');?> <em>*</em></label>
					<label class="input">
						<input type="email" name="contactemail" id="contactemail"  />
					</label>
					
					<div class="clearfix"></div>
					<label class="label"><?php echo translate('subject');?> <em>*</em></label>
					<label class="input">
						<input type="text" name="subject" id="subject"  />
					</label>
					
					<div class="clearfix"></div>
					<label class="label"><?php echo translate('message');?> <em>*</em></label>
					<label class="textarea">
						<textarea rows="5" name="message" id="message"  ></textarea>
					</label>
					
					<div class="clearfix"></div>
					<div class="one_half">
						<div class="g-recaptcha"  data-sitekey="<?=$this->config->item('google_key')?>"></div>  
					</div>                      
					<div class="clearfix"></div>
					<div class="one_half">
						<button type="submit" class="button"><?php echo translate('send_message');?></button>
					</div>
					
					<div class="one_half last">
						<label style="margin-top:35px;"><a style="color:#2ecc71" href=""><?php echo translate('required');?></a></label>
					</div>
					
				</form>
			</div>
		</div>
		<div class="one_half last">
			<div class="address_info">
				<h4> <strong><?php echo translate('İİTKM');?></strong></h4>
				<ul>
					<li> 
						<strong><?php echo translate('Enterprise_Azerbaijan');?></strong><br />
						<?php echo $settings['adress_'.$l.'']?><br />
						<?php echo translate('Telephone');?>: <?php echo $settings['tel1']?><br />
						<?php echo translate('FAX');?>: <?php echo $settings['tel2']?><br />
						<?php echo translate('email');?>: <a href="mailto:<?php echo $settings['mail']?>"><?php echo $settings['mail']?></a><br />
					</li>
				</ul>
			</div>
			<div class="clearfix"></div>
			<h4><?php echo translate('find_the_address');?></h4>
			<iframe class="google-map" width="600" height="450" style="border:0" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d12158.548089818709!2d49.8187602!3d40.3725721!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x54b2bb4b673e35e8!2sCenter+for+Analysis+of+Economic+Reforms+(%C4%B0qtisadi+%C4%B0slahatlar%C4%B1n+T%C9%99hlili+v%C9%99+Kommunikasiya+M%C9%99rk%C9%99zi)!5e0!3m2!1sen!2s!4v1522410995772" ></iframe>
			<br />
		</div>
	</div>
</div><!-- end content area -->
<div class="clearfix divider_line9 lessm"></div>
<div class="clearfix"></div>
