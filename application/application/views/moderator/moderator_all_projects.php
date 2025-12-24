<?php $l=curLang();?>
<head>
<link rel="stylesheet" href="<?php echo base_url('assets/back/'); ?>bower_components/Ionicons/css/ionicons.min.css">
 <link rel="stylesheet" href="<?php echo base_url('assets/back/'); ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Top tab Icon -->
</head>
<div class="container">
     <div class="clearfix margin_bottom4"></div>
		 	                   <section class="content">
                           <div class="row">
                            <div class="col-xs-12">
                            <div class="box">
                               <div class="box-header">
                               <h3 class="box-title"><?php echo $table_title ?></h3>
                                     </div>
                            <div class="box-body">
                           <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                            <th style="width: 20px;">№</th>
                            <th class="text-left"><?php echo translate('project_name');?></th>
                            <th class="text-left"><?php echo translate('add_date');?></th>
                            <th class="text-left"><?php echo translate('status');?></th>
                            <th style="width: 300px;"><?php echo translate('edit');?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $count = 1;
                                  if ($all_projects) {  
                                    foreach ($all_projects as $project) {

                              if ($project['isActive']==0) {
                                  $delete='Activate';
                                	$status='Deaktiv';
                                  $edit='Translate';
                                  $url='#';
                                  $url_translate_edit=base_url('moderator/translate_project/').''.$project['project_id'].'/'.$project['kat_id'];
                                 }
                               
                                            if($project['isActive']==1) {
                                            $delete='Delete';
                                            $status='Aktiv';
                                            $edit='Edit';
                                            $url=base_url('moderator/delete_project/').''.$project['project_id'];
                                            $url_translate_edit=base_url('moderator/edit_project/').''.$project['project_id'].'/'.$project['kat_id'];
                                            }

                                            if($project['isActive']==2) {
                                            $delete='Activate';
                                            $status='Deaktiv';
                                            $edit='Edit';
                                            $url='#';
                                            $url_translate_edit=base_url('moderator/edit_project/').''.$project['project_id'].'/'.$project['kat_id'];
                                            }
                                          
                                            if ($project['isActive']==3) {
                                            $delete='Activate';
                                            $status='Edited';
                                            $edit='Edit';
                                            $url_translate_edit=base_url('moderator/edit_project/').''.$project['project_id'].'/'.$project['kat_id'];
                                            $url='#';
                                            }
                              echo  '<tr>
                            <td>'.$count++.'</td>
                            <td class="text-left"> 
                            <a href="'.base_url('project/detail/').''.$project['project_id'].'">'.$project['project_title'].'</a> </td>
                            <td class="text-left">'.$project['add_date'].'</td>
                            <td class="text-left">'.$status.'</td>
                            <td class="text-left"><a onclick="myFunction()" href="'.$url.'" class="but_pencil iconsol"><i class="fa fa-times fa-lg"></i>&nbsp; '.$delete.'</a>  <a href="'.$url_translate_edit.'" class="but_wifi ml-2"><i class="fa fa-pencil fa-lg"></i>&nbsp;'.$edit.'</a></td>
                                           </tr>';
                                }
                      } ?>	
                      
                            </tbody>
                            </table>    
                            </div>  
                            </div> 
                           </div>  
                            </div> 

            </section>
        </div>
