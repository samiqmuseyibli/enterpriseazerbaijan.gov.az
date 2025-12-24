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

.video-filter-field{
    max-width:1143px;
    margin:0 auto;
    margin-bottom:70px;
}
.videos-filter-header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    width: 100%;
    .search-container {
        flex:2;
            position: relative;
            max-width: 720px;
        }

        .search-input {
            width: 100%;
            padding: 12px 16px 12px 45px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
            background-color: white;
            outline: none;
            transition: border-color 0.2s ease;
            box-sizing: border-box;
        }

        .search-input:focus {
            border-color: #007bff;
        }

        .search-input::placeholder {
            color: #999;
            font-size: 16px;
        }

        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
            pointer-events: none;
        }

        /* Alternative using SVG icon */
        .search-icon-svg {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            opacity: 0.6;
            cursor: pointer;
        }
        .videos-filter-header {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 1300px;
    max-width: 100%;
    margin: 0 auto;
    gap: 20px;
    padding: 20px 0;
}


.category-filter-container {
    flex: 1;
    position: relative;
    max-width: 380px;
}

.category-select {
    width: 100%;
    padding: 12px 40px 12px 16px;
    border: 2px solid #834b9b;
    border-radius: 8px;
    font-size: 16px;
    background-color: white;
    outline: none;
    transition: border-color 0.2s ease;
    box-sizing: border-box;
    font-family: 'Montserrat', sans-serif;
    color: #834b9b;
    font-weight: 500;
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    cursor: pointer;
}

.category-select:focus {
    border-color: #6a3d7a;
}

.category-filter-container::after {
    content: "";
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    width: 0;
    height: 0;
    border-left: 6px solid transparent;
    border-right: 6px solid transparent;
    border-top: 8px solid #834b9b;
    pointer-events: none;
}
}

@media screen and (max-width:1143px) {
    .search-container{
        max-width:420px !important;
    }
    .category-filter-container{
        max-width:280px !important;
    }
    .videos-filter-header{
        gap:50px !important;
        justify-content:center !important;
    }
    .video-filter-field{
        margin-bottom:50px !important;
    }
}
@media screen and (max-width:747px) {
    .search-container{
        max-width:320px !important;
        .search-input{
            font-size:14px !important;
        }
    }
    .category-filter-container{
        max-width:180px !important;
        font-size:12px !important;
        .category-select{
            font-size:14px !important;
        }
    }
    .videos-filter-header{
        gap:30px !important;
    }
    .video-filter-field{
        margin-bottom:30px !important;
    }
}
@media screen and (max-width:535px) {
    .search-container{
        max-width:220px !important;
    }
    .category-filter-container{
        max-width:180px !important;
        font-size:12px !important;
    }
    .videos-filter-header{
        flex-direction:column !important;
        gap:10px !important;
    }
    .video-filter-field{
        margin-bottom:20px !important;
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
                <div class="video-filter-field">
                    <div class="videos-filter-header">
    <div class="search-container">
    <form id="searchForm" class="search-form" method="GET" action="<?php echo current_url(); ?>">
        <div style="position: relative;">
            <svg class="search-icon-svg clickable-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"  onclick="submitSearchForm()">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input type="text" class="search-input" placeholder="<?php echo translate('search_video');?>" name="search" id="search">
        </div>
        </form>
    </div>
    
    <div class="category-filter-container">
    <form id="categoryForm" class="category-form" method="GET" action="<?php echo current_url(); ?>">
        <select class="category-select" name="category" id="category">
         <option value=""><?php echo translate('all_video');?></option>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['vc_id']; ?>" 
                        <?= (isset($_GET['category']) && $_GET['category'] == $cat['vc_id']) ? 'selected' : ''; ?>>
                        <?= $cat['vc_name_'.$l]; ?>
                    </option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
        </form>
    </div>
</div>
                </div>
            <div class="container-yn">
                 <div class="videos-layer-yn">
                    
                    <?php 
                    if ($rows) {    
                        foreach ($rows as $row) {?>  
                            
                                 <div class="videos-element-yn">
                                    <a href="<?=base_url($l);?>/video/detail/<?=$row['v_id']?>">
                                    <div class="video-thumbnail">
                                        <img class="photo-yn" src="<?=base_url().$row['v_cover'];?>" alt="<?=$row['v_title_'.$l.'']?>">
                                     </div>
                                    </a>
                                        <div class="videos-text-yn">
                                            <p class="text-yn"><a href="<?=base_url($l);?>/video/detail/<?=$row['v_id']?>"><?=qisalt($row['v_title_'.$l.''], 130); ?></a></p>
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


    <script>
document.addEventListener('DOMContentLoaded', function() {
    // Search form submission
    const searchForm = document.getElementById('searchForm');
    const searchInput = document.getElementById('search');
    
    // Function to submit search form
    window.submitSearchForm = function() {
        const searchTerm = searchInput.value.trim();
        if (searchTerm) {
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('search', searchTerm);
            currentUrl.searchParams.delete('category');
            window.location.href = currentUrl.toString();
        }
    };
    
    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        submitSearchForm();
    });
    
    // Submit form when Enter is pressed in search input
    searchInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            submitSearchForm();
        }
    });
    
    // Category form submission
    const categoryForm = document.getElementById('categoryForm');
    const categorySelect = document.getElementById('category');
    
    categoryForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const selectedCategory = categorySelect.value;
        const currentUrl = new URL(window.location.href);
        if (selectedCategory) {
            currentUrl.searchParams.set('category', selectedCategory);
        } else {
            currentUrl.searchParams.delete('category');
        }
        currentUrl.searchParams.delete('search');
        window.location.href = currentUrl.toString();
    });
    
    // Auto-submit on category change
    categorySelect.addEventListener('change', function() {
        categoryForm.dispatchEvent(new Event('submit'));
    });
    
    // Set current values from URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const currentSearch = urlParams.get('search');
    const currentCategory = urlParams.get('category');
    
    if (currentSearch) {
        searchInput.value = currentSearch;
    }
    
    if (currentCategory) {
        categorySelect.value = currentCategory;
    }
});
</script>
    