<!DOCTYPE html>
<html>
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
<h3 style="margin: 50px auto;width:250px;">Kateqoriya Əlavə Et</h3>

<div style="margin: 10px auto;width:500px;">
    <?php echo form_open(base_url('admin/add_category'),array('method'=>"post" ));?>
      <input type="hidden" name="token" value="<?=createToken();?>">
    <div id="cat_del">
    <div><label for="fname" style="line-height: 70px;">Az</label>
    <input name="category_name_az" type="text" style="    float: right;    width: 75%;" value=""></div>
    <div><label for="fname" style="line-height: 70px;">En</label>
    <input name="category_name_en" type="text" style="    float: right;    width: 75%;" value=""></div>
    <div><label for="fname" style="line-height: 70px;">Ru</label>
    <input name="category_name_ru" type="text" style="    float: right;    width: 75%;" value=""></div>
    </div>
<input type="submit" value="Əlavə Et">
  </form>
</div>

</body>
</html>
