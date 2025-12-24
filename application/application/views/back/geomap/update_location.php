<!DOCTYPE html>
<html>
	<head>
		<script type="text/javascript" src="<?=base_url()?>assets/back/js/jquery.1.4.2.min.js"></script>
	</head>
	<style>
	input[type=text], select {
		width: 100%;
		padding: 12px 20px;
		margin: 8px 0;
		display: inline-block;
		border: 1px solid #ccc;
		border-radius: 4px;
		box-sizing: border-box;
	}

	input[type=submit] {
		width: 100%;
		background-color: #4CAF50;
		color: white;
		padding: 14px 20px;
		margin: 8px 0;
		border: none;
		border-radius: 4px;
		cursor: pointer;
	}

	input[type=submit]:hover {
		background-color: #45a049;
	}

	</style>
	<body>
		<?php if($this->session->flashdata('update') !='') {
			?>
			<div class="alert alert-success text-center alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
				<?php echo $this->session->flashdata('update');?>
			</div>
			<?php  
		}?>
	
		<?php if($this->session->flashdata('failed_location') !='') {
			?>
			<div class="alert alert-error text-center alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-wrong"></i> Xəta!</h4>
				<?php echo $this->session->flashdata('failed_location');?>
			</div>
			<?php  
		}?>
	
		<?php if($this->session->flashdata('empty') !='') {
			?>
			<div class="alert alert-error text-center alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-wrong"></i> Məlumatları düzgün daxil edin!</h4>
				<?php echo $this->session->flashdata('empty');?>
			</div>
			<?php  
		}?>

		<h3 style="margin: 50px auto;width:250px;">Yeri yenilə</h3>
		<div style="margin: 10px auto;width:500px;">
			<?php echo form_open(base_url('admin/up_location'),array('id' => "filter_form",'method'=>"post",'style'=>"padding-bottom:100px;"));?>
			 <input type="hidden" name="token" value="<?=createToken();?>">
				<?php foreach ($geo_all as $row) {
					?>
					<div id="cat_del">
						<label for="fname">Kateqoriya seçin</label>
						<select id="selectId" style="margin-top: 0px;" name="category_id" required>
							<?php foreach($categories as $category){
								?>
								<option value="<?php echo $category['geo_categories_id'];?>" <?php if($category['geo_categories_id'] == $categori_id){echo 'selected';}?>><?php echo $category['geo_categories_name_az'];?></option>
								<?php 
							}?>
						</select>
						<?php if($categori_id !='5'){
							?> 
							<label for="fname" >Alt kateqoriya seçin</label>
							<select required id="sub_category" style="margin-top: 0px;display:none;" name="sub_category_id" >		
    								<option style="display:none;" value="<?php echo $subkat;?>" >1</option>
							</select>
							<select id="selectId__" style="margin-top: 0px;" name="sub_category_id" required>
							<?php  
							$s_cat = $this->db->get_where('geo_subcategories',array('geo_categories_id'=>$categori_id))->result_array();
							 foreach($s_cat as $cat){
							 $sel='';
							 if($cat['geo_subcategories_id'] ==$subkat){$sel = 'selected';}
								?>
								<option value="<?php echo $cat['geo_subcategories_id'];?>" <?php echo $sel;?>><?php echo $cat['geo_subcategories_name_az'];?></option>;
								<?php 
							}?>
						</select>
							<?php 
						}?>
						<div id="cat_name"></div>
					</div>
					<label style="margin-top: 10px !important;font-size: 20px;color:  blue;margin-left: 50%;" for="fname">AZ</label>
					<div>
						<label for="" style="line-height: 70px;">Başlıq</label>
						<input name="geo_name_az" type="text" style="width: 75%;float:right;" value="<?php echo htmlspecialchars ($row['geo_name_az']);?>">
					</div>
					<div>
						<label for="fname" style="line-height: 70px;">Məlumat</label>
						<input name="geo_description_az" type="text" style="    width: 75%;    float:  right;" value="<?php echo htmlspecialchars ($row['geo_description_az']);?>">
					</div>
					<label style="margin-top: 10px !important;font-size: 20px;color:  blue;margin-left: 50%;"  for="fname">EN</label>
					<div>
						<label for="" style="line-height: 70px;">Başlıq</label>
						<input name="geo_name_en" type="text" style="    width: 75%;    float:  right;" value="<?php echo htmlspecialchars ($row['geo_name_en']);?>">
					</div>
					<div>
						<label for="fname" style="line-height: 70px;">Məlumat</label>
						<input name="geo_description_en" type="text" style=" width: 75%; float:  right;" value="<?php echo htmlspecialchars ($row['geo_description_en']);?>">
					</div>
					<label style="margin-top: 10px !important;font-size: 20px;color:  blue;margin-left: 50%;"  for="fname">RU</label>
					<div>
						<label for="" style="line-height: 70px;">Başlıq</label>
						<input name="geo_name_ru" type="text" style="    width: 75%;    float:  right;" value="<?php echo htmlspecialchars ($row['geo_name_ru']);?>">
					</div>
					<div>
						<label for="fname" style="line-height: 70px;">Məlumat</label>
						<input name="geo_description_ru" type="text" style="    width: 75%;    float:  right;" value="<?php echo htmlspecialchars ($row['geo_description_ru']);?>">
					</div>
					<div>
						<label for="fname" style="line-height: 70px;">URL</label>
						<input name="geo_url" type="text" style="    float: right;    width: 75%;" value="<?php echo $row['geo_url'];?>">
					</div>
					<div id="map" style="position: relative;height: 350px;overflow: hidden;"></div>
					<?php
					$lat = $row['geo_lat'];
					$lng = $row['geo_lng'];?>
					<input id="latbox" type="hidden" name="lat" value="<?php echo $lat;?>">
					<input id="lngbox" type="hidden" name="lng" value="<?php echo $lng;?>">
					<input type="hidden" name="geo_id" value="<?php echo $all_id;?>">
					<input type="submit" style="max-width:250px;float:right;" value="Yenilə">
					<?php 
				}?>
			</form>
		</div>
		<script type="text/javascript">
			$(document).ready(function() {
			
				$("#selectId").change(function() {
					$("#selectId__").remove();
					$("#sub_category").css('display','block');
					var id = $(this).val();
					var dataString='id='+id;
					if(id != '5'){
					$.ajax({
						type: "POST",
						url: "<?php echo base_url();?>admin/get_subcategory",
						data: dataString,
						cache: false,
						success: function(html) {
							$("#sub_category").html(html);
						}
					}); 
					}
				});
			});

			
		</script>
		<script>
			function initMap() {
				var latlng = new google.maps.LatLng(<?php if($lng != ''){echo $lng;}else{?>40.4975941<?php }?>, <?php if($lat != ''){echo $lat;}else{?>49.0803232<?php }?>);
				var map = new google.maps.Map(document.getElementById("map"), {
					center: latlng,
					zoom: 8,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});
				var marker = new google.maps.Marker({
					position: latlng,
					map: map,
					title: "Set lat/lon values for this property",
					draggable: true
				});

				google.maps.event.addListener(marker, "dragend", function (event) {
					document.getElementById("latbox").value = this.getPosition().lng();
					document.getElementById("lngbox").value = this.getPosition().lat();
				});
			}
		</script>
		<script async defer
			src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA3pPOJFYvDgiNhHWY7GwWpndYUZ8bm8iE&callback=initMap">
		</script>
	</body>
</html>
