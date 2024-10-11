<?php $l=curLang();?>
<style type="text/css">
	.doc_item {
    box-shadow: 0 1px 1px 0 rgb(60 64 67 / 8%), 0 1px 3px 1px rgb(60 64 67 / 16%);
    padding: 30px!important;
    margin: 10px!important;
    border-radius: 5px;
    }


</style>
	<div class="clearfix"></div>
	<div class="page_title2 sty2">
		<div class="container">
			<h1><?php echo translate('doc_header');?></h1>
			<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/</i> <a href="<?php echo base_url();?>home/documents"><?php echo translate('doc_header');?></a></div>   
		</div>
	</div>
	<div class="clearfix"></div>
	<div>      
		<div style="margin-top: 15px;">
			<div class="container">
	        
					<div class="doc_item">
              <h1 style="color: black; font-size: 30px; text-align: center; margin-top: 10px;"><?=$row['doc_title_'.$l]?></h1>
					
						<?=html_entity_decode($row['doc_body_'.$l])?>
							
						</div>
			
			</div>
			<div class="clearfix margin_top4"></div>
		</div>
	</div> 
    