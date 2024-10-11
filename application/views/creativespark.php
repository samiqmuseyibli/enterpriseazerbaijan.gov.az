	<style>
		.captcha{width: 39%;line-height: 37px;float: left;}
		.img-reload{cursor: pointer;float: left;width: 50px;padding: 9px;}
		.img-captcha{float:left;margin-bottom: 15px;}
		.cursor{cursor:pointer;}
		.mySlides {display:none}
		.w3-left, .w3-right, .w3-badge {cursor:pointer}
		.w3-badge {height:13px;width:13px;padding:0}

	</style>
	<div class="clearfix"></div>
	<div class="page_title2 sty2">
		<div class="container">
			<h1>“Creative Spark Pitch Competition” yarışması</h1>
			<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/</i></div> 
		</div>
	</div><!-- end page title -->

	<div class="clearfix"></div>

	<div class="content_fullwidth less2">
	
		<div class="container">
			<div class="one_third ">
				<h2 class="less9">Information (*Məlumat*)</h2>
				<p></p>
			</div>
			
			<div class="one_third ">
				<h5 class="caps">AZE</h5>
				<p></p><p style="text-align:justify; line-height:21px">“Big Idea Pitch Competition” yarışması, Britaniya şurasının təşəbbüsü ilə, İqtisadi İslahatların Təhlili və Kommunikasiya Mərkəzi və Birləşmiş krallığın Newcastle universiteti ilə birgə əməkdaşlıq çərçivəsində aparılan “Creative Spark” layihəsinin bir parçasıdır. Yarışmada tələbələr, gənclər, startaplar, idea sahibləri və gənc müəssisə sahibləri iştirak edə bilər. Qeydiyyatdan əvvəl aşağıdakı qaydalarla tanış olun.</p>
				<p></p>
			</div>
			
			<!-- end section -->
			<div class="one_third last ">
				<h5 class="caps">ENG</h5>
				<p></p><p style="text-align:justify; line-height:21px">”Big Idea Pitch Competition” is part of the Creative Spark Project implemented by the British Council withnin the framework of partnership between the Center for Analysis of Economic Reforms of the Republic of Azerbaijan and The Newcastle University of the United Kingdom. The competition is open for students, start-ups, ideas and young entrepreneurs. Please see the registration guidelines before you start your application.</p>
				<p></p>
			</div>
			<div class="clearfix divider_line9 lessm"></div>
			<div class="one_half">
				<div class="title">
					<h3>Application Form (*Qeydiyyat*)</h3>
				</div>
				<h4>AZE</h4>
				<p style="text-align:justify; line-height:21px">Hörmətli iştirakçı, qeydiyyatdan keçərkən məlumatların qısa və dəqiq olmasına diqqət yetirin. Məlumatlar yalnız <b>ingilis dilində</b> daxil edilməlidir, əks halda müraciətinizə baxılmayacaq. Yalnız “Əlavələr” (Additonal Information) bölməsində əlavə etmək istədiyiniz məlumatları və yaxud layihə haqqında qısa məlumatı hər iki dildə (Azərbaycan və yaxud İngilis dilində) daxil edə bilərsiz.  Əgər siz komanda şəklində müraciət edirsinizsə, o zaman hər komandadan yalnız bir nəfər qeydiyyatdan keçməlidir (Nəzərinizdə saxlayın ki, komanda üzvlərinin sayı 4 nəfərdən çox olmamalıdır). </p>
				<br>
				<p style="text-align:justify; line-height:21px">Əgər sizin universitet və yaxud təşkilat, verilən siyahıda yoxdursa, siz “EnterpriseAzerbaijan.com” portalının istifadəçisi kimi qatıla bilərsiz. Bu halda siz “Center for Analysis of Economic Reforms and Communication – Enterprise Azerbaijan portal” seçimini etməlisiz. Bunun üçün sizin ideanızın və ya startapınızın yarışmada iştirakla yanaşı, həm də portalın əsas bazasına (Ana Səhifə + Layihə əlavə et bölməsi) təfərrüatlı şəkildə (Qeyd: layihə barədə məlumat qısa lakin dolğun olmalıdır) yerləşdirilməsi zəruridir, əks halda müraciətiniz aktivliyini itirəcək. </p>
				<br>
				<p style="text-align:justify; line-height:21px">Bütün xanaların doldurulması mütləqdir. Yaş həddi : 18-35 arası. <br>Qeydiyyat üçün son tarix : <strong>14 MART 2022 | 23:59 </strong></p>
				<div class="clearfix"></div>
				<br>
				<h4>ENG</h4>
				<p style="text-align:justify; line-height:21px">Dear participant! Make sure all the details you provide are brief, correct and up to date. The information must be provided in English language. If you would like to provide additional information about your idea or any information in Azerbaijani language, please use the <b>“Additional Information”</b> section. If the applicant is a team, only one team member should fill the application as a team leader (Keep in mind, only maximum of 4 members per team is allowed). </p>
				<br>
				<p style="text-align:justify; line-height:21px">If you are not a member of one of three direct participating universities, you may still apply as a user of “EnterpriseAzerbaijan.com” portal (Choose Center for Analysis of Economic Reforms and Communication – Enterprise Azerbaijan portal). In this case, your idea or start-up must be added to the main database (Home Page + Add Project) of the Enterprise Azerbaijan portal in addition to your registration for the competition. If this required condition is not met, your application may not be considered.</p>
				<br>
				<p style="text-align:justify; line-height:21px">All sections of this application form must be filled. The participants must be at least 18 and no older than 35 years of age. <br>Deadline for application submission: <strong>14 MARCH, 2022 | 23:59 </strong></p>
				<br>
			</div>
			
			<div class="one_half last">
				<div class="cforms_sty3">
					<div class="title">
						<h3>Describe your IDEA:</h3>
					</div>
					<div class="feildcont">
						<?php echo form_open(base_url('creativespark/register'),array('role' => "form",'method'=>"post"));?> 
							
							<div class="one_half">
								<label class="label" for="project_name">Name your idea <em>*</em></label>
								<label class="input"><input type="text" name="project_name" id="project_name" required <?php echo form_error('project_name') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('project_name'); ?>" /></label>
							</div>
							<div class="one_half last">
								<label class="label" for="project_category">Category <em>*</em></label>
								<label class="select">
									<select class="form-control" name="project_category" id="project_category" required="" <?php echo form_error('project_category') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> >
										<option value=""> Choose one </option>
										<option <?php echo set_value('project_category') == "digital_technology" ? 'selected' : null; ?> value="digital_technology">Digital Technology</option>
										<option <?php echo set_value('project_category') == "social_impact" 	 ? 'selected' : null; ?> value="social_impact">Social Impact</option>
										<option <?php echo set_value('project_category') == "creative" 			 ? 'selected' : null; ?> value="creative">Creative</option>
									</select>
								</label>
							</div>
							<div class="clearfix"></div>
							
							<div class="title">
								<h3>Describe your idea according to the guidelines below:</h3>
							</div>
							<div class="one_half">
								<label class="label" for="about_problem"> <strong>Problem:</strong> <em>*</em><br>
									think about how you can showcase the problem to your audience. You can use
									a personal story to describe the problem or base it on statistical data to describe how big
									the problem is. 
									<br>
									<br>
								</label>
								<label class="textarea"><textarea name="about_problem" rows="3" required <?php echo form_error('about_problem') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> ><?php echo set_value('about_problem'); ?></textarea></label>
							</div>
							<div class="one_half last">
								<label class="label" for="about_solution">
									<strong>Solution:</strong> <em>*</em><br>
									explain how your idea addresses the problem identified before in a clear and
									interesting way. If you have any competition, you could explain how your idea is different
									from what they are offering. 
								</label>
								<label class="textarea"><textarea name="about_solution" id="about_solution" rows="3" required <?php echo form_error('about_solution') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> ><?php echo set_value('about_solution'); ?></textarea></label>
							</div>
							<div class="clearfix"></div>
							
							<div class="one_half">
								<label class="label" for="about_customer">
									<strong>Customers:</strong> <em>*</em><br>
									try to describe who will use your product or service and how big the opportunity is. 	
									<br>									
									<br>									
									<br>									
								</label>
								<label class="textarea"><textarea name="about_customer" id="about_customer" rows="3" required <?php echo form_error('about_customer') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> ><?php echo set_value('about_customer'); ?></textarea></label>
							</div>
							<div class="one_half last">
								<label class="label" for="about_money">
									<strong>Money:</strong> <em>*</em><br>
									describe how your business will make money; even if your idea is a social or 
									creative project, you should think about how you will generate some revenue.
								</label>
								<label class="textarea"><textarea name="about_money" id="about_money" rows="3" required <?php echo form_error('about_money') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> ><?php echo set_value('about_money'); ?></textarea></label>
							</div>
							<div class="clearfix"></div>
							
							<label class="label" for="about_add_info">
								<strong>Additional Information:</strong> <br>
									Additional Information (provide any additional information you would like to add to your application. 
									This may include a brief description of your idea in English or in Azerbaijani languages, or any other information in Azerbaijani language that you would like to be considered as part of your application)
								  <em>*</em>
							</label>
							<label class="textarea"><textarea name="about_add_info" rows="3" id="about_add_info" <?php echo form_error('about_add_info') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> ><?php echo set_value('about_add_info'); ?></textarea></label>
							<div class="clearfix"></div>
							
							<div class="title">
								<h3>Personal Details:</h3>
							</div>
							<div class="clearfix"></div>
							
							<label for="about_institution">Which institution are you applying from?  <em>*</em></label>
							<label class="select">
								<select class="form-control" name="about_institution" id="about_institution" required="" <?php echo form_error('about_institution') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> >
									<option value=""> Choose one </option>
									<option <?php echo set_value('about_institution') == "CAERC" ? 'selected' : null; ?> value="CAERC">Centre for Analysis of Economic Reforms and Communication - Enterprise Azerbaijan portal</option>
									<option <?php echo set_value('about_institution') == "UNEC"  ? 'selected' : null; ?> value="UNEC">UNEC</option>
									<option <?php echo set_value('about_institution') == "BEU"   ? 'selected' : null; ?> value="BEU">Baku Engineering University</option>
									<option <?php echo set_value('about_institution') == "ASAU"  ? 'selected' : null; ?> value="ASAU">Azerbaijan State Agrarian University</option>
								</select>
							</label>
							<div class="clearfix"></div>
							
							<div class="one_half">
								<label class="label" for="name_surname">Name / Surname <em>*</em></label>
								<label class="input"><input type="text" name="name_surname" id="name_surname" required <?php echo form_error('name_surname') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('name_surname'); ?>" /></label>
							</div>
							<div class="one_half last">
								<label class="label" for="applying_as">Are you applying as ... <em>*</em></label>
								<label class="select"> 
									<select class="form-control" name="applying_as" id="applying_as" required="" <?php echo form_error('applying_as') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> > 
										<option value="">Choose one </option>
										<option <?php echo set_value('applying_as') == "individual"  ? 'selected' : null; ?> value="individual"> an INDIVIDUAL?</option>
										<option <?php echo set_value('applying_as') == "team_leader" ? 'selected' : null; ?> value="team_leader"> a TEAM LEADER?</option>
									</select>
								</label>
							</div>
							<div class="clearfix"></div>
							
							<div class="one_half">
								<label class="label" for="name">Gender <em>*</em></label>
								<label class="select">
									<select class="form-control" name="gender" id="gender" required="" <?php echo form_error('gender') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?>> 
										<option value="">Choose one </option>
										<option <?php echo set_value('gender') == "male"   ? 'selected' : null; ?> value="male">Male </option>
										<option <?php echo set_value('gender') == "female" ? 'selected' : null; ?> value="female">Female</option>
									</select>
								</label>
								
							</div>
							<div class="one_half last">
								<label class="label" for="age">Age <em>*</em> (18-35) </label>
								<label class="input"><input type="number" name="age" id="age" min="18" max="35" required <?php echo form_error('age') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('age'); ?>" /></label>
							</div>
							<div class="clearfix"></div>
							
							<div class="one_half">
								<label class="label" for="e_mail">E-mail  <em>*</em></label>
								<label class="input"><input type="email" name="e_mail" id="e_mail" required <?php echo form_error('e_mail') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('e_mail'); ?>" /></label>
							</div>
							<div class="one_half last">
								<label class="label" for="phone">Telephone <em>*</em></label>
								<label class="input"><input type="number" name="phone" id="phone" min="0" required <?php echo form_error('phone') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('phone'); ?>" /></label>
							</div>
							<div class="clearfix"></div>
                            <br>
							<div class="one_half">
								<div class="g-recaptcha"  data-sitekey="<?=$this->config->item('google_key')?>"></div>  
							</div>                      
							<div class="clearfix"></div>
							<br>
							
							<div class="one_half">
								<button type="submit" class="button">SEND</button>
							</div>
							<div class="one_half last">
								<label style="margin-top:20px;"><a style="color:#2ecc71" href=""><?php echo translate('required');?></a></label>
							</div>
						</form>			
					</div>
				</div>
			</div>
			
			<div class="clearfix margin_bottom6"></div>
			
		</div>
		
	</div><!-- end content area -->
	<div class="clearfix divider_line9 lessm"></div>
	<div class="clearfix"></div>
	

