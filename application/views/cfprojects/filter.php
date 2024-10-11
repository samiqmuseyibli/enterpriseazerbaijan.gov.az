	<div class="feature_section3">
		<div class="container">
		    <div class="arrow_box">
		        <h2 class="white less9">
		            <a href="<?php echo base_url('cfprojects/about'); ?>"><?php echo translate('about_crowdfanding');?></a>
				</h2>
				<p class="mediumfont less10"><a href="<?php echo base_url('cfprojects/about'); ?>"><?php echo translate('what_is_crawdfanding');?></a></p>
			</div>
			<!--<h2 class="caps "><?php echo translate('Projects');?></h2>-->
			<div class="searchcou">
				<?php echo form_open(base_url('cfprojects/filter'),array('id' => "thisid",'method'=>"get"));?>  
					<div class="row">
						<div class="col-md-4">
							<select name="region" style="width: 100%">
								<option value="0">- <?php echo translate('All_Regions');?>  -</option>
								<?php $regions=get_regions(); foreach($regions as $region) {
									echo'<option value="'.$region['reg_id'].'">'.$region['reg_adi_'.$l.''].'</option>';
								}?>
							</select>
						</div>
						<div class="col-md-4">
							<select name="category" style="width: 100%" >
								<option value="0">- <?php echo translate('All_Categories');?> -</option>
								<?php $categories=get_cfcategories(); foreach($categories as $cat) {
									echo'<option value="'.$cat['id'].'">'.$cat['title_'.$l.''].'</option>';
								}?>
							</select>
						</div>
						<div class="col-md-4">
							<select name="cost_option" style="width: 100%" >
								<option value="0-0">- <?php echo translate('Price');?> -</option> 
								<option value="0-10000">0-10 <?php echo translate('thousand');?> </option>  
								<option value="10000-100000">10 <?php echo translate('thousand');?>-100 <?php echo translate('thousand');?></option>  
								<option value="100000-1000000">100 <?php echo translate('thousand');?>-1 <?php echo translate('milion');?></option>  
								<option value="1000000-1000000000">1 <?php echo translate('milion');?>-1 <?php echo translate('milliard');?></option>
							</select>
						</div>
					</div>
					<div class="clearfix"></div>
					<input type="submit" value="<?php echo translate('search');?> " />           
				</form>
				<div class="clearfix"></div>     
			</div> 
		</div>
	</div>