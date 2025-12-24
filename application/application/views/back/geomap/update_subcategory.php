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
<?php if($this->session->flashdata('update') !='') {?>
<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        <?php echo $this->session->flashdata('update');?> 
</div>
<?php  }?>
<h3 style="margin: 50px auto;width:250px;">Alt Kateqoriya Yenilə</h3>

<div style="margin: 10px auto;width:500px;">
      <?php echo form_open(base_url('admin/update_subcategory'),array('id' => "filter_form",'method'=>"post"));?>
	<div id="cat_del">
         <input type="hidden" name="token" value="<?=createToken();?>">
    <label for="fname">Kateqoriyanı seçin</label>
    <select id="selectId" name="category_id">
	<?php foreach($categories as $category){?>
      <option value="<?php echo $category['geo_categories_id'];?>"><?php echo $category['geo_categories_name_az'];?></option>
	<?php }?>
    </select>
	 <select id="sub_category"  name="sub_category_id"></select>
	<div id="cat_name">	</div>
	</div>
	<input id="cat_name_ajax"  name="cat_name_ajax" type="hidden" >
	<input id="sub_cat_name_ajax" name="sub_cat_name_ajax" type="hidden" >
    <input type="submit" value="Yenilə">
  </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#selectId").change(function() {
            var id = $(this).val();
			
			$("#cat_name_ajax").val(id);
            var dataString='id='+id;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/get_subcategory",
                data: dataString,
                cache: false,
                success: function(html) {
					add_input(id);
                    $("#sub_category").html(html);
                }
            });
        });
    });
	
	function s_filter(page){
            var dataString='id='+page;
			$("#cat_name_ajax").val(page);
            $.ajax({
                type: "POST",
                url: '<?php echo base_url();?>admin/get_subcategory',
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#sub_category").html(html);
                }
            });
        }
		$(document).ready(function() {
			s_filter('1');
		});
		</script>
		<script>
		function add_input(id){
			var cat_id = id;
            var dataString = 'id=1';
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/get_subcategory_name/"+cat_id,
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#cat_name").html(html);
                }
            });
        }
	</script>
		
<script> 
    $(document).ready(function() {
        $("#sub_category").change(function() {
            var idd = $(this).val();
			var cat_id = $("#cat_name_ajax").val();
			$("#sub_cat_name_ajax").val(idd);
            var dataString = 'id='+idd;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/get_subcategory_name/"+cat_id,
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#cat_name").html(html);
                }
            });
        });
    });
	
	function filter(page){
            var dataString='id='+page;
			var cat_id = $("#cat_name_ajax").val();
			$("#sub_cat_name_ajax").val(page);
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/get_subcategory_name/"+cat_id,
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#cat_name").html(html);
                }
            });
        }
		$(document).ready(function() {
			filter('1');
		});
	
</script> 

</body>
</html>
