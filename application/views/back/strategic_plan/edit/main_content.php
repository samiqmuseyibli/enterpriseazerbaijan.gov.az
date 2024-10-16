<section class="content">

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Redaktə Formu</h3>
        </div>

        <?php echo form_open(base_url('admin/update_strategic_plan'), array('class' => "form-horizontal  container", 'method' => "post")); ?>

        <div class="box-body">
            <!-- Input -->
            <input type="hidden" name="token" value="<?= createToken(); ?>">

            <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Başlıq AZ</label>
                <div class="col-sm-10 ">
                    <textarea id="editor1" name="title_az" rows="8"
                              cols="80"><?php echo $details['title_az']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Başlıq EN</label>
                <div class="col-sm-10 ">
                    <textarea id="editor2" name="title_en" rows="8"
                              cols="80"><?php echo $details['title_en']; ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="information" class="col-sm-2 control-label">Başlıq RU</label>
                <div class="col-sm-10 ">
                    <textarea id="editor3" name="title_ru" rows="8"
                              cols="80"><?php echo $details['title_ru']; ?></textarea>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="information" class="col-sm-2 control-label">Mətn AZ</label>
            <div class="col-sm-10 ">
                <textarea id="editor4" name="description_az" rows="8"
                          cols="80"><?php echo $details['description_az']; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="information" class="col-sm-2 control-label">Mətn EN</label>
            <div class="col-sm-10 ">
                <textarea id="editor5" name="description_en" rows="8"
                          cols="80"><?php echo $details['description_en']; ?></textarea>
            </div>
        </div>

        <div class="form-group">
            <label for="information" class="col-sm-2 control-label">Mətn RU</label>
            <div class="col-sm-10 ">
                <textarea id="editor6" name="description_ru" rows="8"
                          cols="80"><?php echo $details['description_ru']; ?></textarea>
            </div>
        </div>

    </div>

    <div class="box-footer ">


        <a href="<?php echo base_url('admin/about_content'); ?>" class="btn btn-default">Ləğv et</a>
        <button type="submit" class="btn btn-info pull-right">Dəyiş</button>


    </div>

    </form>
    </div>
</section>
