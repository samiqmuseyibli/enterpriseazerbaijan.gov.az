	<div class="clearfix"></div>
	<div class="page_title2 sty2">
		<div class="container">
			<h1>Müsabiqə</h1>
			<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/</i></div> 
		</div>
	</div><!-- end page title -->

	<div class="clearfix"></div>

	<div class="content_fullwidth less2">
		<div class="container">
			<div class="logregform two">
				<div class="title">
					<h3><?php echo translate('Müsabiqə');?></h3>

				</div>
				<div class="feildcont">
             <div class="melumat">
             	<style >
             		p,li{
             		color: black;	
             		}
             		ul {
  list-style: none;
}

.melumat ul li::before {
  content: "\2022";
  color: red;
  font-weight: bold;
  display: inline-block; 
  width: 1em;
  margin-left: -1em;
}
</style>
             	
<p style="text-align: center;">“CROWDFUNDING” müsabiqəsi</p>
<p><br></p>
<p style="text-align: center; ">MƏLUMAT<br></p>
<p><br></p>
<p><ul>
<li>“Crowdfunding” müsabiqəsi, İqtisadi İslahatların Təhlili və Kommunikasiya Mərkəzi (İİTKM) və Azərbaycan</li>
<li>Beynəlxalq Bankının (ABB) birgə təşəbbüsü ilə həyata keçirilir. Müsabiqədə startapçılar və innovativ məhsul sahibləri</li>
<li>iştirak edə bilər.</li>
<li>Enterprise Azerbaijan portalı xarici bazarlardan alıcı və investisiya cəlb etmək üçün qaliblərin layihələrini</li>
<li>KİCKSTARTER platformasına yerləşdirəcək. Beləliklə müsabiqənin qalibləri öz məhsullarına əvvəlcədən sifariş almaq və</li>
<li>yaxud məhsulunu kütləvi istehsal etmək üçün investisiya əldə etmək imkanı qazanacaqlar. Seçilmiş layihələrə</li>
<li>professional təqdimatın hazırlanması, marketinq və biznes dəstəyi göstəriləcək.</li>
<li>Yarışmanın ilkin seçim mərhələsində iştirak etmək üçün aşağıda qeydiyyatdan keçin.</li>
<li>*Qeydiyyatdan əvvəl aşağıdakı qaydalarla tanış olun.</li>
</ul>
</p>
<p><br></p>
<p style="text-align: center; ">QAYDALAR</p>
<p><br></p>
<p><ul>
<li>&nbsp;Hörmətli iştirakçı, qeydiyyatdan keçərkən məlumatların səlist, qısa və dəqiq olmasına diqqət yetirin.</li>
<li>Məlumatlar Azərbaycan dilində daxil edilməlidir.</li>
<li>&nbsp;Müsabiqədə iştirak üçün komanda üzvlərinin sayı minimum 3 olmalıdır. Hər komandadan yalnız bir nəfər qrup</li>
<li>rəhbəri qismində qeydiyyatdan keçməlidir.</li>
<li>&nbsp;Nəşriyyat, musiqi, oyunlar və film kateqoriyalarına uyğun gələn layihələrin açıqlaması, aidiyyatı materialları və</li>
<li>icrası yalnız ingilis dilində olmalıdır.</li>
<li>&nbsp;Dizayn, texnologiya, qida, sənətkarlıq, əl işi, komiks (Comics), illustrasiya, incəsənət və rəssamlıq</li>
<li>kateqoriyalarına uyğun gələn layihələrin real prototipi olmalıdır</li>
<li>&nbsp;Müsabiqə “KİCKSTARTER” platformasının <a target="_blank" href="https://www.kickstarter.com/rules">“OUR RULES”</a> bölməsində qeyd olunan bütün qaydalara istinad edir.</li>
<li>&nbsp;“Əlavələr” bölməsindən başqa bütün xanaların doldurulması mütləqdir. “Əlavələr” bölməsində əlavə etmək</li>
<li>istədiyiniz məlumatları daxil edə bilərsiz.</li>
<li>Qeydiyyat üçün son tarix : Bazar, 20 Oktyabr 2019 23:59</li>
</ul>
</p>
</div>
				
					
					<?php echo form_open(base_url('competition/register'),array('role' => "form",'method'=>"post"));?> 
						
						
							
						<label for="fname"> Ad və soyad <em>*</em></label>
						<input type="text" name="name" id="name" required <?php echo form_error('name') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('name'); ?>"/>
						
						
						<!-- # user email # -->
						<label for="uemail"> Layihənin adı <em>*</em></label>
						<input type="text" name="project_name" id="project_name" required <?php echo form_error('project_name') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('project_name'); ?>" />
						
						<div class="one_half">
							<label for="upsw"> Layihə haqqında qısa məlumat <em>*</em></label>
							<textarea name="about_project" rows="7" cols="70" required <?php echo form_error('about_project') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> ><?php echo set_value('about_project'); ?></textarea>
						</div>
                     
	                    <div class="clearfix"></div>
						<div class="one_half">
							<label for="upsw"> Layihənin həll etdiyi problemlər <em>*</em></label>
							<textarea name="slovedproblems" rows="5" cols="70" required <?php echo form_error('slovedproblems') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> ><?php echo set_value('slovedproblems'); ?></textarea>
						</div>
						
						
						<label for="fname"> Layihənin icra müddəti <em>*</em></label>
						<input type="text" name="implementation_period" id="implementation_period" required <?php echo form_error('implementation_period') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('implementation_period'); ?>"/>

						<label for="fname"> Minimal ələb olunan vəsait (AZN)<em>*</em></label>
						<input type="number" name="minimum_required_funds" id="minimum_required_funds" required <?php echo form_error('minimum_required_funds') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('minimum_required_funds'); ?>"/>

						<label for="fname"> Komanda üzvlərinin sayı (ən azı 3 nəfər)<em>*</em></label>
						<input type="number" name="number_of_team_members" id="number_of_team_members" required <?php echo form_error('number_of_team_members') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('number_of_team_members'); ?>"/>

						<label for="fname"> Telefon <em>*</em></label>
						<input type="number" name="telephone" id="telephone" required <?php echo form_error('telephone') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('telephone'); ?>"/>

						<label for="fname"> E-poçt <em>*</em></label>
						<input type="email" name="email" id="email" required <?php echo form_error('email') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?> value="<?php echo set_value('email'); ?>"/>
						
						
						<div class="one_half">
							<label for="upsw"> Əlavələr</label>
							<textarea name="other" rows="5" cols="70" required <?php echo form_error('other') != "" ? 'style="border: 1px solid #eb3535;"' : null; ?>  ><?php echo set_value('other'); ?></textarea>
						</div>
                     
	                    <div class="clearfix"></div>
						
						
						<div class="one_half">
							<button type="submit" class="fbut">Göndər</button>
						</div>
						
						<div class="one_half last">
							<label style="margin-top:20px;"><a style="color:#2ecc71" href=""><?php echo translate('required');?></a></label>
						</div>
						
					</form>			
				</div>
			</div>
		</div>
	</div><!-- end content area -->
	<div class="clearfix divider_line9 lessm"></div>
	<div class="clearfix"></div>
	

