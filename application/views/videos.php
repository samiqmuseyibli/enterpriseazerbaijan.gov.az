<?php 
	$l=curLang();
?>
<style type="text/css">
	@import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@700&display=swap');
*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.container-yn{
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100%;
    padding-top: 10px;
}
.videos-layer-yn{
    display: flex;
    gap: 45px;
    flex-wrap: wrap;
    justify-content: center;
    width: 1300px;
}
.videos-element-yn{
    width: 351px;
    box-shadow: 1px 3px 15px 12px #e5e5e5;
    border-radius: 17px 17px 17px 17px;
}
.photo-yn{
    width: 351px;
    height: 200px;
    border-radius: 17px 17px 0px 0px;
}
.videos-text-yn{
    display: flex;
    flex-direction: column;
    padding: 11px 14px 17px 13px;
    height: 120px;
    justify-content: space-between;
    border-radius: 0px 0px 17px 17px;
}
.text-yn{
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    font-size: 15px;
    line-height: 20px;
}
.date-sign-yn{
    display: flex;
    align-items: center;
}
.date-yn{
    font-family: 'Montserrat', sans-serif;
    font-weight: 700;
    font-size: 13px;
    color: rgba(0, 0, 0, 0.5);
}

@media screen and (min-width:250px) and (max-width: 300px) {
    .videos-layer-yn{
        gap: 45px;
        flex-wrap: wrap;
    }
    .videos-element-yn{
        width: 200px;
    }
    .photo-yn{
        width: 200px;
        height: 144px;
    }
    .videos-text-yn{
        height: 170px;
    }
    .text-yn{
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        font-size: 14px;
        color: #000000;
    }
    .date-sign-yn{
        display: flex;
        align-items: center;
    }
    .date-yn{
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 13px;
        color: rgba(0, 0, 0, 0.5);
    }
    
}

.video-thumbnail {
  position: relative;
  display: inline-block;
  cursor: pointer;

  &:before {
    position:absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    content: "\f01d";
    font-family: FontAwesome;
    font-size: 100px;
    color: #fff;
    opacity: .8;
    text-shadow: 0px 0px 30px rgba(0, 0, 0, 0.5);
  }
  &:hover:before {
    color: #eee;
  }
}
</style>
	<div class="clearfix"></div>
	<div class="page_title2 sty2">
		<div class="container">
			<h1><?php echo translate('videos');?></h1>
			<div class="pagenation">&nbsp;<a href="<?php echo base_url();?>"><?php echo translate('home_page');?></a> <i>/</i> <a href="<?php echo base_url();?>video"><?php echo translate('videos');?></a></div>   
		</div>
	</div>
	<div class="clearfix"></div>
	<div id="videos">      
		<div class="feature_section2">
			<div class="container-yn">
				 <div class="videos-layer-yn">
				    <?php 
					if ($rows) {    
						foreach ($rows as $row) {?>  
							
							     <div class="videos-element-yn">
							     	<a href="<?=base_url();?>video/detail/<?=$row['v_id']?>">
							     	<div class="video-thumbnail">
                                        <img class="photo-yn" src="<?=base_url().$row['v_cover'];?>" alt="<?=$row['v_title_'.$l.'']?>">
                                     </div>
                                    </a>
                                        <div class="videos-text-yn">
                                            <p class="text-yn"><a href="<?=base_url();?>video/detail/<?=$row['v_id']?>"><?=qisalt($row['v_title_'.$l.''], 130); ?></a></p>
                                            <div class="date-sign-yn">
                                                <i style="margin: 5px; color: #834b9b;" class="fa fa-calendar"> </i>
                                                <p class="date-yn"><?=date_for_view($row['v_createdAt'])?></p>
                                            </div>
                                        </div>
                                    </div>
							<?php } }else{ ?>
								<div class="successmes">
									<div class="message-box-wrap"><i class=""></i><?php echo translate('no_video_found');?></div>
								</div>
						   <?php } ?>
				 </div>
			</div>
			<div class="clearfix margin_top4"></div>
			<div class="pagenation center">
				<?php echo $links;?>   
			</div>
			<div class="clearfix margin_top4"></div>
		</div>
	</div>

    