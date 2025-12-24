<head>
<link rel="stylesheet" href="<?php echo base_url('assets/back/'); ?>bower_components/Ionicons/css/ionicons.min.css">
 <link rel="stylesheet" href="<?php echo base_url('assets/back/'); ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
  <!-- Top tab Icon -->
</head>
<div class="container">
    <div class="clearfix margin_bottom4"></div>
	<div id="myprojects-table" style="width: 100%;" >
		<div class="table-title">
			<center><h3><?php echo translate('my_projects');?></h3></center> 
		</div>
		<table class="table-fill text-center" >
			<thead>
				<tr>
					<th class="text-left"><?php echo translate('project_name');?></th>
					<th class="text-left"><?php echo translate('add_date');?></th>
					<th class="text-left"><?php echo translate('status');?></th>
					<th class="text-left" style="width: 320px;"><?php echo translate('edit');?></th>
				</tr>
			</thead>
			<tbody class="table-hover">
				<?php 
				if ($user_projects) {  
					foreach ($user_projects as $project) {
						if ($project['isActive']==0) {
							$status=translate('on_waiting');
							$url="#";
							$urldelete="#";
							$urledit="#";
						}elseif($project['isActive']==3){
							$status=translate('edited');
							$url="#";
							$urldelete="#";
							$urledit="#";
						}else{
							$status=translate('aktiv');
							$url=base_url('project/detail/').''.$project['project_id'];
							$urldelete=base_url($l.'/user/deleteproject/').''.$project['project_id'];
							$urledit=base_url($l.'/user/editproject/').''.$project['project_id'].'/'.$project['kat_id'];
						}		
						echo '
							<tr>
								<td class="text-left"><a href="'.$url.'" target="_blank">'.$project['project_title'].'</a> </td>
								<td class="text-left">'.$project['add_date'].'</td>
								<td class="text-left">'.$status.'</td>
								<td class="text-left"><a href="'.$urldelete.'" class="but_pencil iconsol"><i class="fa fa-times fa-lg"></i>&nbsp;  '.translate('delete').'</a>  <a href="'.$urledit.'" class="but_wifi ml-2"><i class="fa fa-pencil fa-lg"></i>&nbsp; '.translate('edit').'</a></td>
							</tr>
						';
					}
				}else{
					echo translate('you_have_not_project');
				}
				?>	
			</tbody>
		</table>                         
	</div>
</div>
<div class="clearfix margin_bottom3"></div>