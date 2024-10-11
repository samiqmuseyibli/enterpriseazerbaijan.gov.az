<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Qanunvericilik</h3>
                    <a href="<?php echo base_url('admin/documents_add'); ?> " class="btn btn-primary pull-right"><i
                                class="fa fa-plus" type="button" style="padding-right: 4px;"></i><b>Əlavə et</b></a>
                </div>
                <?php echo $this->session->flashdata('update_datatable'); ?>
                 <h3 style="margin-left:10px;" class="card-title">Siyahı: <?=$result_count?></h3>
                 <div class="box-body">
                    <table  class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="width:20px;">№</th>
                            <th>Sənədin adı</th>
                            <th>Sənədin tipi</th>                           
                            <th>Tarix</th>
                            <th>Status</th>
                            <th>Əməliyyatlar</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($details as $detail) {
                            ?>
                            <tr>
                                <td><?php echo $detail['doc_id']; ?></td>
                                <td><?php echo word_limiter($detail['doc_title_az'], 6); ?></td>
                                <td><?php echo word_limiter($detail['dc_name_az'], 6); ?></td>
                                <td><?php echo $detail['doc_createdAt']; ?></td>
                                <td><input class="toggle_check" data-onstyle="success" data-on="Aktiv"
                                           data-offstyle="danger" data-off="Passiv" type="checkbox" data-toggle="toggle"
                                           dataID="<?php echo $detail['doc_id']; ?>"
                                           dataURL="<?php echo base_url('admin/docsset?token='.createToken()); ?>" <?php echo ($detail['doc_status'] == 1) ? 'checked' : ''; ?> />
                                </td>
                                <td>
                                    <a href="<?php echo base_url('admin/update_documents/' . $detail['doc_id'] . ''); ?>">
                                        <button type="button" name="button" class="btn btn-primary"><i class="fa fa-edit"> </i> Redaktə et</button>
                                    </a>
                                    <a onclick="return confirm('Silməyə əminsinizmi?');"
                                       href="<?php echo base_url('admin/delete_documents/' . $detail['doc_id'] . '?token='.createToken().''); ?>">
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
