<div class="feature_section3">
    <div class="container">
        <h1 class="caps "><?php echo translate('Projects'); ?></h1>
        <div class="linebg_12"></div>
        <div class="searchcou">
            <?php echo form_open(base_url('project/filter'), array('id' => "thisid", 'method' => "get")); ?>
            <select name="sector">
                <option value="0">- <?php echo translate('All_Sectors'); ?> -</option>
                <?php foreach ($sectors as $sector) {
                    echo '<option value="' . $sector['sek_id'] . '">' . $sector['sek_adi_' . $l . ''] . '</option>';
                } ?>
            </select>
            <select name="region">
                <option value="0">- <?php echo translate('All_Regions'); ?> -</option>
                <?php foreach ($regions as $region) {
                    echo '<option value="' . $region['reg_id'] . '">' . $region['reg_adi_' . $l . ''] . '</option>';
                } ?>
            </select>
            <select name="category">
                <option value="0">- <?php echo translate('All_Categories'); ?> -</option>
                <?php foreach ($categories as $cat) {
                    echo '<option value="' . $cat['kat_id'] . '">' . $cat['kat_adi_' . $l . ''] . '</option>';
                } ?>
            </select>
            <select name="cost_option">
                <option value="0-0">- <?php echo translate('Price'); ?> -</option>
                <option value="0-10000">0-10 <?php echo translate('thousand'); ?> </option>
                <option value="10000-100000">10 <?php echo translate('thousand'); ?>
                    -100 <?php echo translate('thousand'); ?></option>
                <option value="100000-1000000">100 <?php echo translate('thousand'); ?>
                    -1 <?php echo translate('milion'); ?></option>
                <option value="1000000-1000000000">1 <?php echo translate('milion'); ?>
                    -1 <?php echo translate('milliard'); ?></option>
            </select>
            <div class="clearfix"></div>
            <input type="submit" value="<?php echo translate('search'); ?> "/>
            </form>
            <div class="clearfix"></div>
        </div>
    </div>
</div>