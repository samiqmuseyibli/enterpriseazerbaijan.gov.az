<?php $l=curLang();?>
<style type="text/css">
	.doc_item {
    box-shadow: 0 1px 1px 0 rgb(60 64 67 / 8%), 0 1px 3px 1px rgb(60 64 67 / 16%);
    transition: box-shadow 135ms cubic-bezier(.4,0,.2,1);
    padding: 10px!important;
    margin: 10px!important;
    border-radius: 5px;
    margin-bottom: 20px!important;
    }

    .doc_item:hover {
    -webkit-box-shadow: 0 0 26px 5px rgb(0 0 0 / 20%);
    -moz-box-shadow: 0 0 26px 5px rgba(0,0,0,.2);
    box-shadow: 0 0 26px 5px rgb(0 0 0 / 20%);
    z-index: 600;
    position: relative;
    border-radius: 5px;
   }

   .item_title_{
     font-size: 18px;
     color: gray;
   }

   .item_title{
     margin: 10px;
     margin-bottom: 0!important;
     padding: 10px;
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
	<div id="sektorbase">      
		<div class="feature_section2" id="investbase">
			<div class="container">
				<?php 
					if ($rows) {    
						foreach ($rows as $item) {?>  
							<a href="<?php echo base_url();?>home/doc_detail/<?php echo $item['doc_id'];?>">
								<div class="row">
									<div class="doc_item">
										<div class="item_title"> <h3 class="item_title_"><?=$item['doc_title_'.$l]?></h3></div>
									</div>
								</div>
							</a>
							<?php } }else{ ?>
								<div class="successmes">
									<div class="message-box-wrap"><i class=""></i><?php echo translate('no_data_found');?></div>
								</div>
						    <?php } ?>

			
			</div>
			<div class="clearfix margin_top4"></div>
			<div class="pagenation center">
				<?php echo $links;?>   
			</div>
			<div class="clearfix margin_top4"></div>
		</div>
	</div> 
    