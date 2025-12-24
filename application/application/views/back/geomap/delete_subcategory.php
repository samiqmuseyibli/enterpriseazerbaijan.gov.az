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
<?php if($this->session->flashdata('delete') !='') {?>
<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        <?php echo $this->session->flashdata('delete');?> 
</div>
<?php  }?>
<h3 style="margin: 50px auto;width:250px;">Kateqoriya Sil</h3>

<div style="margin: 10px auto;width:500px;">
       <?php echo form_open(base_url('admin/delete_subcategory'),array('id' => "filter_form",'method'=>"post"));?>
	<div id="cat_del">
         <input type="hidden" name="token" value="<?=createToken();?>">
    <label for="fname">Kateqoriya Seçin</label>
    <select id="selectId" name="category_id">
	<?php foreach($categories as $category){?>
      <option value="<?php echo $category['geo_categories_id'];?>"><?php echo $category['geo_categories_name_az'];?></option>
	<?php }?>
    </select>
	
	 <select id="sub_category"  name="sub_category_id"></select>
	</div><br>
    <input type="submit" value="Sil">
  </form>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $("#selectId").change(function() {
			 $("#sub_category").css('display','block');
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

</body>
</html>
