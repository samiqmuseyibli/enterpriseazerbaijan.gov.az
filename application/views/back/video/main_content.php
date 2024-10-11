<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Videolar</h3>
                    <a href="<?php echo base_url('admin/video_add'); ?> " class="btn btn-primary pull-right"><i class="fa fa-plus" type="button" style="padding-right: 4px;"></i><b>Əlavə et</b></a>
                </div>
                <?php echo $this->session->flashdata('update_datatable'); ?>
                 <h3 style="margin-left:10px;" class="card-title">Siyahı: <?=$result_count?></h3>
                 <div class="box-body">
                    <table  class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="width:20px;">№</th>
                            <th>Şəkil</th>
                            <th>Başlıq</th>
                            <th>Tarix</th>
                            <th>Status</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($rows as $row) {
                            ?>
                            <tr>
                                <td><?php echo $row['v_id']; ?></td>
                                <td><img style="height:60px; width: 80px;"
                                         src="<?=base_url($row['v_cover'])?> ">
                                </td>
                                <td><?=word_limiter($row['v_title_az'], 10); ?></td>
                                <td><?=$row['v_createdAt']; ?></td>
                                <td><input class="toggle_check" data-onstyle="success" data-on="Aktiv"
                                           data-offstyle="danger" data-off="Passiv" type="checkbox" data-toggle="toggle"
                                           dataID="<?php echo $row['v_id']; ?>"
                                           dataURL="<?php echo base_url('admin/videoset?token='.createToken().''); ?>" <?=($row['v_status'] == 1) ? 'checked' : ''; ?> />
                                </td>
                                <td>
                                    <a href="<?php echo base_url('admin/update_video/' . $row['v_id'] . ''); ?>">
                                        <button type="button" name="button" class="btn btn-primary"><i class="fa fa-edit"> </i> Redaktə et</button>
                                    </a>
                                    <a onclick="return confirm('Silməyə əminsinizmi?');"
                                       href="<?php echo base_url('admin/delete_video/' . $row['v_id'] . '?token='.createToken().''); ?>">
                                        <button type="button" name="button" class="btn btn-warning"><i class="fa fa-trash"> </i> Sil</button>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                    <?php if (isset($pagination)): ?>
                        <?php if (!empty($pagination)): ?>
                        <div class="card-footer">
                          <nav aria-label="Contacts Page Navigation">
                            <?=$pagination?>
                          </nav>
                        </div>
                        <?php endif ?>
                     <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>
