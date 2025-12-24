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
<?php if($this->session->flashdata('add') !='') {?>
<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i>Əlavə Edildi!</h4>
                        <?php echo $this->session->flashdata('add');?>
</div>
<?php  }?>
<?php if($this->session->flashdata('failed_location') !='') {?>
<div class="alert alert-error text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-wrong"></i> Xəta!</h4>
                        <?php echo $this->session->flashdata('failed_location');?>
</div>
<?php  }?>
<?php if($this->session->flashdata('empty') !='') {?>
<div class="alert alert-error text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-wrong"></i> Məlumat Süzgen Deyil!</h4>
                        <?php echo $this->session->flashdata('empty');?>
</div>
<?php  }?>

<h3 style="margin: 50px auto;width:250px;">Yer Əlavə Et</h3>

<div style="margin: 10px auto;width:500px;">
	   <?php echo form_open(base_url('admin/add_new_location'),array('id' => "filter_form",'method'=>"post" ,'style'=>"padding-bottom:100px;"));?>
    <input type="hidden" name="token" value="<?=createToken();?>">
	<div id="cat_del">
    <label for="fname">Kateqoriya Seçin</label>
    <select id="selectId" style="margin-top: 0px;" name="category_id" required>
	<?php foreach($categories as $category){?>
      <option value="<?php echo $category['geo_categories_id'];?>"><?php echo $category['geo_categories_name_az'];?></option>
	<?php }?>
    </select>
	 <label for="fname" >Alt Kateqoriya Seçin</label>
	 <select required id="sub_category" style="margin-top: 0px;" name="sub_category_id"></select>
	<div id="cat_name">	</div>
	</div>
	<label style="margin-top: 10px !important;font-size: 20px;color:  blue;margin-left: 50%;" for="fname">AZ</label>
	<div>
	<label for="" style="line-height: 70px;">Başlıq</label>
	<input required name="geo_name_az" type="text" style="    width: 75%;    float:  right;">
    </div>

	<div>
		<label for="fname" style="line-height: 70px;">Məlumat</label>
		<input required name="geo_description_az" type="text" style="    width: 75%;    float:  right;">
	</div>
	<label style="margin-top: 10px !important;font-size: 20px;color:  blue;margin-left: 50%;"  for="fname">EN</label>
	<div>

	<label for="" style="line-height: 70px;">Başlıq</label>
	<input required name="geo_name_en" type="text" style="    width: 75%;    float:  right;">
    </div>

	<div>
		<label for="fname" style="line-height: 70px;">Məlumat</label>
		<input required name="geo_description_en" type="text" style="    width: 75%;    float:  right;">
	</div>
	<label style="margin-top: 10px !important;font-size: 20px;color:  blue;margin-left: 50%;"  for="fname">RU</label>
	<div>
	<label for="" style="line-height: 70px;">Başlıq</label>
	<input required name="geo_name_ru" type="text" style="    width: 75%;    float:  right;">
    </div>

	<div>
		<label for="fname" style="line-height: 70px;">Məlumat</label>
		<input required name="geo_description_ru" type="text" style="    width: 75%;    float:  right;">
	</div>

	<div><label for="fname" style="line-height: 70px;">URL</label>
	<input required name="geo_url" type="text" style="    float: right;    width: 75%;"></div>
	<div id="map" style="position: relative;height: 350px;overflow: hidden;"></div>
	<input id="latbox" type="hidden" name="lat" value="">
	<input id="lngbox" type="hidden" name="lng" value="">
    <input type="submit" style="max-width:250px;float:right;" value="Əlavə Et">
  </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#selectId").change(function() {
            var id = $(this).val();
            var dataString='id='+id;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/get_subcategory",
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#sub_category").html(html);
                }
            });
        });
    });

	function filter(page){
            var dataString='id='+page;

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
		$(document).ready(function() {
			filter('1');
		});


</script>
<script>
   function initMap() {
		var latlng = new google.maps.LatLng(40.4975941, 49.0803232);
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
