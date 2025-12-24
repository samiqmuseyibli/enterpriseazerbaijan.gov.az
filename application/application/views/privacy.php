<div class="page_title2">
	<div class="container">
		<h1><?php echo translate('privacy_policy');?></h1>
		<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/ </i><?php echo translate('privacy_policy');?></div>
	</div>
</div>
<div class="clearfix"></div>
<div class="feature_section50">
	<div class="container">
		
	<?php if ($detail['content'] !='') {
		echo $detail['content'];
	}else{?>
		        <div class="row">
						<div class="infomes">
							<div class="message-box-wrap"><i class=""></i><?=translate('data_vl_add_msg')?></div>
						</div>
				</div>
	<?php } ?>
	</div>
</div>
 