<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>Log in | Admin Panel | Enterprise Azerbijan</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link rel="stylesheet" href="<?php echo base_url('assets/back/'); ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url('assets/back/'); ?>bower_components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url('assets/back/'); ?>bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="<?php echo base_url('assets/back/'); ?>dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="<?php echo base_url('assets/back/'); ?>lugins/iCheck/square/blue.css">
		<link href="<?php echo base_url(); ?>assets/front/image/favicon.ico" rel="icon" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
	</head>
	    <style>
			 .captcha{width: 39%;line-height: 37px;float: left;}
			 .img-reload{cursor: pointer;float: left;width: 50px;padding: 9px;}
			 .img-captcha{float:left;margin-bottom: 15px;}
			 .cursor{cursor:pointer;}
		</style>
	<body class="hold-transition login-page">
		<div class="login-box">
			<div class="login-box-body">
				<div class="login-logo">
	              <a href="<?=base_url()?>"><img src="<?=base_url()?>assets/front/images/logo_new.png"></a>
	            </div>
				<p class="login-box-msg">İnzibatçı məlumatlarını daxil edin</p>
				<p><?php echo $this->session->flashdata('login_invalid'); ?></p> 
				<?php echo form_open(base_url('admin/login'),array('method'=>"post"));?>
				<input type="hidden" name="token" value="<?=createToken();?>">
					<div class="form-group has-feedback">
						<input type="text" name="login" class="form-control" placeholder="İstifadəçi adı" required />
						<span class="glyphicon glyphicon-envelope form-control-feedback"></span>
					</div>
					<div class="form-group has-feedback">
						<input type="password" name="password" autocomplete="off" class="form-control" placeholder="Şifrə" required />
						<span class="glyphicon glyphicon-lock form-control-feedback"></span>
					</div>
					 <div class="form-group">
										<img class="img-captcha" src="<?php echo base_url().'user/getCaptcha';?>"/>
										<img alt="Reload" onclick="return(reloadCaptcha());" class="img-reload" src="<?php echo base_url();?>assets/captcha/reload.png">
									</div>
						<div class="form-group">
							<input type="text" name="captchaCode" id="captcha" placeholder="<?php echo translate('enter');?>" required />
						</div>
					
					<div class="row">
						<div class="col-xs-12">
							<button type="submit" class="btn btn-primary btn-block btn-flat">Daxil ol</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<script src="<?php echo base_url('assets/back/');?>bower_components/jquery/dist/jquery.min.js"></script>
		<script src="<?php echo base_url('assets/back/');?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url('assets/back/');?>plugins/iCheck/icheck.min.js"></script>
		<script>
			$(function () {
				$('input').iCheck({
					checkboxClass: 'icheckbox_square-blue',
					radioClass: 'iradio_square-blue',
					increaseArea: '20%' // optional
				});
			});
		</script>
		<script>
			function reloadCaptcha(){
				//cap_input = '';
				$('.img-captcha').attr('src','<?php echo base_url().'user/getCaptcha?';?>'+$.now());
			}
		</script>
	</body>
</html>
