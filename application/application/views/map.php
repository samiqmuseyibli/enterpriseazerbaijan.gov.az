<?php include('header.php'); ?>
<?php 
    $l = curLang(); 
    $_detail = get_site_settings();
?>
<script src="https://api-maps.yandex.ru/2.1/?lang=en_AZ&apikey=62b4a617-6fea-4847-a58a-c3bd7972b96d" type="text/javascript"></script>
<style>
    html, body, #map {
        width: 100%;
        height: 900px;
        padding: 0;
        margin: 0;
    }
</style>

<script type="text/javascript">
<?php if (empty($this->uri->segment(3))): ?>
    ymaps.ready(function () {
        var myMap = new ymaps.Map('map', {
                center: [40.4035268, 47.531714],
                zoom: 8
            }),

            myPlacemarkWithContent = new ymaps.Placemark([40.3724722, 49.8187421], {
                hintContent: '<?= translate('IITKM'); ?>',
                balloonContent: '<img style="float:left; margin-top:0px" src="<?= base_url('assets/front/images/GERB_Az-100.png'); ?>" alt="">' +
                                '<h5><?= translate('IITKM'); ?></h5><hr>' +
                                '<?= $_detail['tel1']; ?><br>' +
                                'info@ereforms.gov.az<br>' +
                                '<?= $_detail['adress_'.$l]; ?><br>' +
                                '<a target="_blank" style="color:#0088cc;" href="https://ereforms.gov.az/">www.ereforms.gov.az</a>'
            }, {
                iconLayout: 'default#imageWithContent',
                iconImageHref: '<?= base_url('assets/front/images/emblem_of_azerbaijan.png'); ?>',
                iconImageSize: [25, 30],
                iconImageOffset: [-30, -30],
                iconContentOffset: [15, 15]
            });

        myMap.geoObjects.add(myPlacemarkWithContent);
    });
<?php else: ?>
    ymaps.ready(init);
    function init() {
        var myMap = new ymaps.Map("map", {
            center: [40.4035268, 47.531714],
            zoom: 8,
            controls: ['zoomControl', 'typeSelector', 'fullscreenControl', 'searchControl']
        });

        <?php if (empty($have_map_icon) && $this->uri->segment(3) === 'setcategory'): ?>
            myMap.geoObjects
                .add(new ymaps.Placemark([40.3724722, 49.8187421], {}, {iconColor: '#834b9b'}))
                .add(new ymaps.Placemark([40.76678189168967, 47.05391428924742], {}, {iconColor: '#834b9b'}))
                .add(new ymaps.Placemark([40.597704532042776, 49.66254849315208], {}, {iconColor: '#834b9b'}));
        <?php else: ?>
            <?php foreach ($detail as $map): 
                $link = $map['geo_url']; 
                $link_icon = '&#128279; '; 
            ?>
                myMap.geoObjects.add(new ymaps.Placemark(
                    [<?= $map['geo_lng']; ?>, <?= $map['geo_lat']; ?>],
                    {
                        balloonContent: '<h5><?= $map['geo_name_'.$l]; ?></h5><hr>' +
                                        '<?= $map['geo_description_'.$l]; ?><br>' +
                                        <?php if (is_numeric($link)): ?>
                                            '<a target="_blank" style="color:#0088cc;" href="<?= base_url($l); ?>/project/detail/<?= $link; ?>"><?= translate('url'); ?></a>'
                                        <?php else: ?>
                                            <?php if ($link == '#'): ?>
                                                '<?= '&nbsp;' ?>'
                                            <?php else: ?>
                                                '<?= $link_icon.'<a href="'.$link.'" target="_blank" style="color:#0088cc;">'.translate('url').'</a>'; ?>'
                                            <?php endif; ?>
                                        <?php endif; ?>
                    },
                    {
                        iconColor: '#834b9b',
                        iconCaption: '<?= $map['geo_name_'.$l]; ?>',
                        iconCaptionMaxWidth: '70'
                    }
                ));
            <?php endforeach; ?>
        <?php endif; ?>
    }
<?php endif; ?>
</script>

<div id="map"></div>
<div class="accord">
    <div class="accordion" style="z-index: 9;">
        <div class="accordion-sectin">
            <span class="accordion-section-title" style="text-align:center;">
                <?= translate('Naviqasiya'); ?>
            </span>
        </div>
        <?php foreach($categories as $category): ?>
            <div class="accordion-section" style="display:block">
                <a class="accordion-section-title <?php if($cat_id && $cat_id==$category['geo_categories_id']) echo 'active'; ?>"
                   href="#accordion-<?= $category['geo_categories_id']; ?>">
                   <?= $category['geo_categories_name_'.$l]; ?>
                </a>
                <div id="accordion-<?= $category['geo_categories_id']; ?>"
                     class="accordion-section-content"
                     <?php if($cat_id && ($cat_id==$category['geo_categories_id'] || $cat_id=='set_cat')) echo ' style="display:block;"'; ?>>
                    <ul style="margin:0;">
                        <?php
                        $sub = $this->db->get_where('geo_subcategories',['geo_categories_id'=>$category['geo_categories_id']])->result_array();
                        if($category['geo_categories_id'] == 5){
                            $invest = $this->db->where('status', 1)->get('categories')->result_array();
                            foreach($invest as $inv): ?>
                                <li>
                                    <i class="fa fa-plus-circle"></i>
                                    <a href="<?= base_url($l); ?>/geomap/setcategory/<?= $inv['kat_id']; ?>"
                                       style="cursor:pointer;<?php if($cat_id==$category['geo_categories_id'] && $s_cat_id==$inv['kat_id']) echo 'font-weight:bold;'; ?>">
                                       <?= $inv['kat_adi_'.$l]; ?>
                                    </a>
                                </li>
                            <?php endforeach;
                        } elseif($category['geo_categories_id'] == 9) { ?>
                            <li>
                                <i class="fa fa-plus-circle"></i>
                                <a href="<?= base_url($l); ?>/geomap/setcompany" style="cursor:pointer;">
                                    <?= translate('Companies'); ?>
                                </a>
                            </li>
                        <?php } else {
                            foreach($sub as $sub_cat): ?>
                                <li>
                                    <i class="fa fa-plus-circle"></i>
                                    <a href="<?= base_url($l); ?>/geomap/set/<?= $category['geo_categories_id']; ?>/<?= $sub_cat['geo_subcategories_id']; ?>"
                                       style="cursor:pointer;<?php if($cat_id==$category['geo_categories_id'] && $s_cat_id==$sub_cat['geo_subcategories_id']) echo 'font-weight:bold;'; ?>">
                                       <?= $sub_cat['geo_subcategories_name_'.$l]; ?>
                                    </a>
                                </li>
                            <?php endforeach;
                        } ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php include('footer_map.php'); ?>
