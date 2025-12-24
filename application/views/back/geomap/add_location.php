<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yer Əlavə Et</title>
    <script type="text/javascript" src="<?=base_url()?>assets/back/js/jquery.1.4.2.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #1e3a5f 0%, #2d5a87 100%);
            padding: 30px;
            text-align: center;
        }

        .card-header h1 {
            color: #ffffff;
            font-size: 28px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .card-header h1::before {
            content: '';
            width: 40px;
            height: 40px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z'/%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M15 11a3 3 0 11-6 0 3 3 0 016 0z'/%3E%3C/svg%3E") no-repeat center;
            background-size: contain;
        }

        .card-body {
            padding: 40px;
        }

        /* Alerts */
        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left: 4px solid #28a745;
            color: #155724;
        }

        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
            border-left: 4px solid #dc3545;
            color: #721c24;
        }

        .alert .close {
            margin-left: auto;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.5;
            transition: opacity 0.2s;
        }

        .alert .close:hover {
            opacity: 1;
        }

        /* Form Groups */
        .form-section {
            margin-bottom: 32px;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            padding-bottom: 12px;
            border-bottom: 2px solid #e9ecef;
        }

        .section-title h3 {
            font-size: 18px;
            font-weight: 600;
            color: #1e3a5f;
        }

        .lang-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            color: #fff;
        }

        .lang-badge.az { background: linear-gradient(135deg, #00b09b, #96c93d); }
        .lang-badge.en { background: linear-gradient(135deg, #667eea, #764ba2); }
        .lang-badge.ru { background: linear-gradient(135deg, #f093fb, #f5576c); }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 500;
            color: #4a5568;
        }

        .form-group label .required {
            color: #e53e3e;
            margin-left: 2px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            font-size: 15px;
            font-family: inherit;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            transition: all 0.2s ease;
            outline: none;
        }

        .form-control:hover {
            border-color: #cbd5e0;
        }

        .form-control:focus {
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        select.form-control {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%234a5568'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 20px;
            padding-right: 48px;
        }

        /* Map Section */
        .map-section {
            margin-top: 32px;
        }

        .map-section .section-title h3::before {
            content: '';
            display: inline-block;
            width: 24px;
            height: 24px;
            margin-right: 8px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%231e3a5f'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7'/%3E%3C/svg%3E") no-repeat center;
            background-size: contain;
        }

        .search-box {
            position: relative;
            margin-bottom: 16px;
        }

        .search-box input {
            width: 100%;
            padding: 16px 20px 16px 50px;
            font-size: 15px;
            font-family: inherit;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
            transition: all 0.2s ease;
            outline: none;
        }

        .search-box input:focus {
            border-color: #667eea;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .search-box::before {
            content: '';
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239ca3af'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") no-repeat center;
            background-size: contain;
        }

        #map {
            height: 400px;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .pac-container {
            z-index: 10000 !important;
            border-radius: 12px;
            margin-top: 4px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: none;
            font-family: 'Inter', sans-serif;
        }

        .pac-item {
            padding: 12px 16px;
            cursor: pointer;
        }

        .pac-item:hover {
            background: #f3f4f6;
        }

        /* Submit Button */
        .submit-section {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            gap: 16px;
        }

        .btn {
            padding: 16px 32px;
            font-size: 16px;
            font-weight: 600;
            font-family: inherit;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #ffffff;
            box-shadow: 0 4px 14px 0 rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px 0 rgba(102, 126, 234, 0.5);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Language Tabs */
        .lang-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 24px;
            background: #f1f5f9;
            padding: 6px;
            border-radius: 12px;
        }

        .lang-tab {
            flex: 1;
            padding: 12px 20px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            color: #64748b;
            background: transparent;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .lang-tab:hover {
            color: #1e3a5f;
        }

        .lang-tab.active {
            background: #ffffff;
            color: #1e3a5f;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .lang-content {
            display: none;
            animation: fadeIn 0.3s ease;
        }

        .lang-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        /* Responsive */
        @media (max-width: 768px) {
            body {
                padding: 20px 16px;
            }

            .card-body {
                padding: 24px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .card-header h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>Yer Əlavə Et</h1>
            </div>
            <div class="card-body">
                <?php if($this->session->flashdata('add') !='') {?>
                <div class="alert alert-success">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><strong>Əlavə Edildi!</strong> <?php echo $this->session->flashdata('add');?></span>
                    <button type="button" class="close" onclick="this.parentElement.remove()">&times;</button>
                </div>
                <?php }?>

                <?php if($this->session->flashdata('failed_location') !='') {?>
                <div class="alert alert-error">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><strong>Xəta!</strong> <?php echo $this->session->flashdata('failed_location');?></span>
                    <button type="button" class="close" onclick="this.parentElement.remove()">&times;</button>
                </div>
                <?php }?>

                <?php if($this->session->flashdata('empty') !='') {?>
                <div class="alert alert-error">
                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span><strong>Məlumat Daxil Edilməyib!</strong> <?php echo $this->session->flashdata('empty');?></span>
                    <button type="button" class="close" onclick="this.parentElement.remove()">&times;</button>
                </div>
                <?php }?>

                <?php echo form_open(base_url('admin/add_new_location'), array('id' => 'filter_form', 'method' => 'post'));?>
                <input type="hidden" name="token" value="<?=createToken();?>">

                <!-- Category Section -->
                <div class="form-section">
                    <div class="section-title">
                        <h3>Kateqoriya Seçimi</h3>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Kateqoriya <span class="required">*</span></label>
                            <select id="selectId" name="category_id" class="form-control" required>
                                <?php foreach($categories as $category){?>
                                <option value="<?php echo $category['geo_categories_id'];?>"><?php echo $category['geo_categories_name_az'];?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Alt Kateqoriya <span class="required">*</span></label>
                            <select id="sub_category" name="sub_category_id" class="form-control" required></select>
                        </div>
                    </div>
                </div>

                <!-- Language Tabs -->
                <div class="form-section">
                    <div class="section-title">
                        <h3>Məlumatlar</h3>
                    </div>

                    <div class="lang-tabs">
                        <button type="button" class="lang-tab active" data-lang="az">Azərbaycan</button>
                        <button type="button" class="lang-tab" data-lang="en">English</button>
                        <button type="button" class="lang-tab" data-lang="ru">Русский</button>
                    </div>

                    <!-- AZ Content -->
                    <div class="lang-content active" data-lang="az">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Başlıq (AZ) <span class="required">*</span></label>
                                <input type="text" name="geo_name_az" class="form-control" placeholder="Başlıq daxil edin" required>
                            </div>
                            <div class="form-group">
                                <label>Məlumat (AZ) <span class="required">*</span></label>
                                <input type="text" name="geo_description_az" class="form-control" placeholder="Təsvir daxil edin" required>
                            </div>
                        </div>
                    </div>

                    <!-- EN Content -->
                    <div class="lang-content" data-lang="en">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Title (EN) <span class="required">*</span></label>
                                <input type="text" name="geo_name_en" class="form-control" placeholder="Enter title" required>
                            </div>
                            <div class="form-group">
                                <label>Description (EN) <span class="required">*</span></label>
                                <input type="text" name="geo_description_en" class="form-control" placeholder="Enter description" required>
                            </div>
                        </div>
                    </div>

                    <!-- RU Content -->
                    <div class="lang-content" data-lang="ru">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Заголовок (RU) <span class="required">*</span></label>
                                <input type="text" name="geo_name_ru" class="form-control" placeholder="Введите заголовок" required>
                            </div>
                            <div class="form-group">
                                <label>Описание (RU) <span class="required">*</span></label>
                                <input type="text" name="geo_description_ru" class="form-control" placeholder="Введите описание" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- URL Section -->
                <div class="form-section">
                    <div class="form-group">
                        <label>URL <span class="required">*</span></label>
                        <input type="text" name="geo_url" class="form-control" placeholder="https://example.com" required>
                    </div>
                </div>

                <!-- Map Section -->
                <div class="form-section map-section">
                    <div class="section-title">
                        <h3>Xəritədə Yer Seçin</h3>
                    </div>
                    <div class="search-box">
                        <input id="location-search" type="text" placeholder="Ünvan və ya yer adı axtarın...">
                    </div>
                    <div id="map"></div>
                    <input id="latbox" type="hidden" name="lat" value="">
                    <input id="lngbox" type="hidden" name="lng" value="">
                </div>

                <!-- Submit -->
                <div class="submit-section">
                    <button type="submit" class="btn btn-primary">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Əlavə Et
                    </button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Language tabs
        document.querySelectorAll('.lang-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const lang = this.dataset.lang;

                document.querySelectorAll('.lang-tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.lang-content').forEach(c => c.classList.remove('active'));

                this.classList.add('active');
                document.querySelector(`.lang-content[data-lang="${lang}"]`).classList.add('active');
            });
        });

        // Subcategory AJAX
        $(document).ready(function() {
            $("#selectId").change(function() {
                var id = $(this).val();
                var dataString = 'id=' + id;
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url();?>admin/get_subcategory",
                    data: dataString,
                    cache: false,
                    success: function(html) {
                        $("#sub_category").html(html);
                    }
                });
            });
        });

        function filter(page) {
            var dataString = 'id=' + page;
            $.ajax({
                type: "POST",
                url: "<?php echo base_url();?>admin/get_subcategory",
                data: dataString,
                cache: false,
                success: function(html) {
                    $("#sub_category").html(html);
                }
            });
        }

        $(document).ready(function() {
            filter('1');
        });
    </script>

    <script>
        function initMap() {
            var latlng = new google.maps.LatLng(40.4975941, 49.0803232);
            var map = new google.maps.Map(document.getElementById("map"), {
                center: latlng,
                zoom: 8,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                styles: [
                    {
                        "featureType": "administrative",
                        "elementType": "labels.text.fill",
                        "stylers": [{"color": "#444444"}]
                    },
                    {
                        "featureType": "landscape",
                        "elementType": "all",
                        "stylers": [{"color": "#f2f2f2"}]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "all",
                        "stylers": [{"visibility": "off"}]
                    },
                    {
                        "featureType": "road",
                        "elementType": "all",
                        "stylers": [{"saturation": -100}, {"lightness": 45}]
                    },
                    {
                        "featureType": "road.highway",
                        "elementType": "all",
                        "stylers": [{"visibility": "simplified"}]
                    },
                    {
                        "featureType": "water",
                        "elementType": "all",
                        "stylers": [{"color": "#667eea"}, {"visibility": "on"}]
                    }
                ]
            });

            var marker = new google.maps.Marker({
                position: latlng,
                map: map,
                title: "Yeri seçmək üçün sürükləyin",
                draggable: true,
                animation: google.maps.Animation.DROP
            });

            google.maps.event.addListener(marker, "dragend", function(event) {
                document.getElementById("latbox").value = this.getPosition().lng();
                document.getElementById("lngbox").value = this.getPosition().lat();
            });

            // Places Autocomplete Search
            var searchInput = document.getElementById("location-search");
            var autocomplete = new google.maps.places.Autocomplete(searchInput, {
                types: ['geocode', 'establishment'],
                componentRestrictions: { country: 'az' }
            });

            autocomplete.bindTo('bounds', map);

            autocomplete.addListener('place_changed', function() {
                var place = autocomplete.getPlace();

                if (!place.geometry || !place.geometry.location) {
                    alert("Seçilən yer üçün məlumat tapılmadı.");
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(15);
                }

                marker.setPosition(place.geometry.location);
                marker.setAnimation(google.maps.Animation.DROP);

                document.getElementById("latbox").value = place.geometry.location.lng();
                document.getElementById("lngbox").value = place.geometry.location.lat();
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?=env('MAP_API_KEY')?>&libraries=places&callback=initMap"></script>
</body>
</html>
