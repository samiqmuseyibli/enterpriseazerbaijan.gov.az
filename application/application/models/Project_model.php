<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Project_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
    }
    function record_count_all_projects()
    {
        $this->db->where('isActive', 1);
        $this->db->from('projects');
        return $this->db->count_all_results();
    }

    function record_count_cat_projects($id)
    {
        $this->db->where('isActive', 1);
        $this->db->where('kat_id', $id);
        $this->db->from('projects');
        return $this->db->count_all_results();
    }
    function record_count_projects_filter($sector, $category, $region, $min, $max)
    {
        $this->db->where('isActive', 1);
        if ($category != 0) {
            $this->db->where('projects.kat_id', $category);
        }
        if ($sector != 0) {
            $this->db->where('sector_id', $sector);
        }
        if ($region != 0) {
            $this->db->where('region_id', $region);
        }
        if ($max != 0) {
            $this->db->where('invesment_volume <=', $max);
        }
        if ($min != 0) {
            $this->db->where('invesment_volume >=', $min);
        } 
        $this->db->from('projects');
        $this->db->join('categories','categories.kat_id = projects.kat_id');
        $this->db->where('categories.status','1');
        return $this->db->count_all_results();
    }
    public function get_categories()
    {
        $l=curLang();
        $this->db->select('kat_id');
        $this->db->select('kat_link');
        $this->db->select('kat_adi_' . $l . '');
        $this->db->from('categories');
        $this->db->where('status','1');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    public function get_regions()
    {
        $l=curLang();
        $this->db->select('reg_id');
        $this->db->select('reg_adi_' . $l . '');
        $this->db->from('regions');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function get_sectors()
    {
        $l=curLang();
        $this->db->select('sek_id');
        $this->db->select('sek_adi_' . $l . '');
        $this->db->from('sectors');
        $this->db->where('sectors.status','1');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function get_property_type()
    {
        $l=curLang();
        $this->db->select('property_type_id');
        $this->db->select('property_name_' . $l . '');
        $this->db->from('property_type');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function get_usage_form()
    {
        $l=curLang();
        $this->db->select('usage_form_id');
        $this->db->select('usage_form_name_' . $l . '');
        $this->db->from('usage_form');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    
    public function get_appointment()
    {
        $l=curLang();
        $this->db->select('appointment_id');
        $this->db->select('appointment_name_' . $l . '');
        $this->db->from('appointment');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
    
    public function get_geomap_projects($id)
    {
        $l=curLang();
        $this->db->select('project_translation.project_title as geo_name_' . $l . '');
        $this->db->select('projects.project_id as geo_url');
        $this->db->select('project_translation.project_description as geo_description_' . $l . '');
        $this->db->select('projects.lat as geo_lng');
        $this->db->select('projects.lng as geo_lat');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('projects.kat_id', $id);
        $this->db->where('projects.lng !=', '');
        $this->db->where('projects.lat !=', '');
        $this->db->where('projects.isActive', 1);
        $this->db->where('categories.status', 1);
        $this->db->where('language.code', $l);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_geomap_companies()
    {
        $l=curLang();
        $this->db->select('name as geo_name_' . $l . '');
        $this->db->select('link_id as geo_url');
        $this->db->select('address as geo_description_' . $l . '');
        $this->db->select('lat as geo_lng');
        $this->db->select('lng as geo_lat');
        $this->db->from('companies');
        $this->db->where('status', 1);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_user_projects()
    {
        
        $id   = $this->session->userdata('user_id');
        $l=curLang();
        $this->db->select('projects.project_id');
        $this->db->select('projects.kat_id');
        $this->db->select('projects.isActive');
        $this->db->select('projects.add_date');
        $this->db->select('project_translation.project_title');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->where('projects.user_id', $id);
        $this->db->where('language.code', $l);
        $this->db->where('categories.status', 1);
        $this->db->where("(projects.isActive='0' OR projects.isActive='1' OR projects.isActive='3')", NULL, FALSE);
        $this->db->order_by('projects.project_id', 'desc');
        // $where='projects.user_id = '.$id.' AND language.code='.$l.' AND ( projects.isActive=0 OR projects.isActive=1)';
        // $this->db->where($where);
        $query = $this->db->get();
        return $query->result_array();
        
        
    }
    public function get_projects_category_id($project_id)
    {
        
        $this->db->select('kat_id');
        $this->db->from('projects');
        $this->db->where('project_id', $project_id);
        $query = $this->db->get();
        $ret   = $query->row();
        if ($ret) {
            return $ret->kat_id;
        } else {
            
            return false;
        }
        
    }

    public function getProjectUserId($id)
    {
        
        $this->db->select('projects.user_id');
        $this->db->select('files.files_url');
        $this->db->from('projects');
        $this->db->join('files', 'projects.project_id = files.files_type_id');
        $this->db->where('files.files_id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    
    public function get_projects_detail_moderator($project_id)
    {
        $this->db->select('projects.project_id');
        $this->db->select('projects.top');
        $this->db->select('projects.sector_id');
        $this->db->select('project_translation.project_title');
        
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->where('projects.project_id', $project_id);
        $this->db->where('project_translation.lang_code', 'az');
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_project_detail_idea($project_id)
    {
        $l=curLang();
        $this->db->select('projects.project_id');
        $this->db->select('projects.youtube_video_link');
        $this->db->select('projects.kat_id');
        $this->db->select('projects.user_id');
        $this->db->select('projects.region_id');
        $this->db->select('projects.invesment_volume');
        $this->db->select('projects.project_author');
        $this->db->select('projects.url_image');
        $this->db->select('projects.lat');
        $this->db->select('projects.lng');
        $this->db->select('projects.author_telephone');
        $this->db->select('projects.author_email');
        $this->db->select('projects.add_date');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.translation_id');
        $this->db->select('project_translation.adress');
        $this->db->select('project_translation.project_description');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        
        
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->where('projects.project_id', $project_id);
        $this->db->where('language.code', $l);
        $this->db->where('projects.isActive', 1);
        $query = $this->db->get();
        return $query->row_array();
        
        
    }
    public function get_project_detail_startup($project_id)
    {
        $l=curLang();
        $this->db->select('projects.kat_id');
        $this->db->select('projects.project_id');
        $this->db->select('projects.youtube_video_link');
        $this->db->select('projects.user_id');
        $this->db->select('projects.region_id');
        $this->db->select('projects.sector_id');
        $this->db->select('projects.invesment_volume');
        $this->db->select('projects.investor_percent');
        $this->db->select('projects.url_image');
        $this->db->select('projects.lat');
        $this->db->select('projects.lng');
        $this->db->select('projects.project_author');
        $this->db->select('projects.author_telephone');
        $this->db->select('projects.author_email');
        $this->db->select('projects.add_date');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.translation_id');
        $this->db->select('project_translation.project_description');
        $this->db->select('project_translation.other_important_data');
        $this->db->select('project_translation.adress');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('sectors.sek_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->join('sectors', 'sectors.sek_id = projects.sector_id');
        $this->db->where('projects.project_id', $project_id);
        $this->db->where('language.code', $l);
        $this->db->where('projects.isActive', 1);
        $query = $this->db->get();
        return $query->row_array();
        
    }
    
    public function get_project_detail_land_sale($project_id)
    {
        $l=curLang();
        $this->db->select('projects.*');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.project_description');
        $this->db->select('project_translation.translation_id');
        $this->db->select('project_translation.infrastructure');
        $this->db->select('project_translation.other_important_data');
        $this->db->select('project_translation.adress');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('sectors.sek_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        $this->db->select('property_type.property_name_' . $l . '');
        $this->db->select('usage_form.usage_form_name_' . $l . '');
        $this->db->select('appointment.appointment_name_' . $l . '');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->join('sectors', 'sectors.sek_id = projects.sector_id');
        $this->db->join('property_type', 'property_type.property_type_id = projects.property_type_id');
        $this->db->join('usage_form', 'usage_form.usage_form_id = projects.usage_form_id');
        $this->db->join('appointment', 'appointment.appointment_id = projects.appointment_id');
        $this->db->where('projects.project_id', $project_id);
        $this->db->where('language.code', $l);
        $this->db->where('projects.isActive', 1);
        $query = $this->db->get();
        return $query->row_array();
        
        
    }
    
    public function get_project_detail_investment($project_id)
    {
        $l=curLang();
        $this->db->select('projects.kat_id');
        $this->db->select('projects.user_id');
        $this->db->select('projects.project_id');
        $this->db->select('projects.region_id');
        $this->db->select('projects.sector_id');
        $this->db->select('projects.youtube_video_link');
        $this->db->select('projects.price');
        $this->db->select('projects.url_image');
        $this->db->select('projects.invesment_volume');
        $this->db->select('projects.investor_percent');
        $this->db->select('projects.project_author');
        $this->db->select('projects.author_telephone');
        $this->db->select('projects.author_email');
        $this->db->select('projects.add_date');
        $this->db->select('projects.lat');
        $this->db->select('projects.lng');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.translation_id');
        $this->db->select('project_translation.project_description');
        $this->db->select('project_translation.main_advantages');
        $this->db->select('project_translation.other_important_data');
        $this->db->select('project_translation.adress');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('sectors.sek_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->join('sectors', 'sectors.sek_id = projects.sector_id');
        
        $this->db->where('projects.project_id', $project_id);
        $this->db->where('language.code', $l);
        $this->db->where('projects.isActive', 1);
        $query = $this->db->get();
        return $query->row_array();
        
        
    }
    public function get_project_detail_estate($project_id)
    {
        $l=curLang();
        $this->db->select('projects.kat_id');
        $this->db->select('projects.user_id');
        $this->db->select('projects.project_id');
        $this->db->select('projects.region_id');
        $this->db->select('projects.sector_id');
        $this->db->select('projects.usage_form_id');
        $this->db->select('projects.price');
        $this->db->select('projects.youtube_video_link');
        $this->db->select('projects.property_type_id');
        $this->db->select('projects.url_image');
        $this->db->select('projects.project_author');
        $this->db->select('projects.author_telephone');
        $this->db->select('projects.author_email');
        $this->db->select('projects.add_date');
        $this->db->select('projects.common_area');
        $this->db->select('projects.lat');
        $this->db->select('projects.lng');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.translation_id');
        $this->db->select('project_translation.project_description');
        $this->db->select('project_translation.infrastructure');
        $this->db->select('project_translation.other_important_data');
        $this->db->select('project_translation.adress');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('sectors.sek_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        $this->db->select('property_type.property_name_' . $l . '');
        $this->db->select('usage_form.usage_form_name_' . $l . '');
        
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->join('sectors', 'sectors.sek_id = projects.sector_id');
        $this->db->join('property_type', 'property_type.property_type_id = projects.property_type_id');
        $this->db->join('usage_form', 'usage_form.usage_form_id = projects.usage_form_id');
        
        $this->db->where('projects.project_id', $project_id);
        $this->db->where('language.code', $l);
        $this->db->where('projects.isActive', 1);
        $query = $this->db->get();
        return $query->row_array();
        
        
    }
    public function get_project_detail_stock($project_id)
    {
        $l=curLang();
        $this->db->select('projects.kat_id');
        $this->db->select('projects.user_id');
        $this->db->select('projects.region_id');
        $this->db->select('projects.sector_id');
        $this->db->select('projects.project_id');
        $this->db->select('projects.charter_capital');
        $this->db->select('projects.number_of_issued_stocks');
        $this->db->select('projects.nominal_value_of_one_stocks');
        $this->db->select('projects.volume_of_traded_stocks');
        $this->db->select('projects.url_image');
        $this->db->select('projects.project_author');
        $this->db->select('projects.youtube_video_link');
        $this->db->select('projects.author_telephone');
        $this->db->select('projects.author_email');
        $this->db->select('projects.add_date');
        $this->db->select('projects.common_area');
        $this->db->select('projects.lat');
        $this->db->select('projects.lng');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.translation_id');
        $this->db->select('project_translation.project_description');
        $this->db->select('project_translation.infrastructure');
        $this->db->select('project_translation.other_important_data');
        $this->db->select('project_translation.adress');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('sectors.sek_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->join('sectors', 'sectors.sek_id = projects.sector_id');
        $this->db->where('projects.project_id', $project_id);
        $this->db->where('language.code', $l);
        $this->db->where('projects.isActive', 1);
        $query = $this->db->get();
        return $query->row_array();
        
        
    }
    public function get_project_detail_business($project_id)
    {
        $l=curLang();
        $this->db->select('projects.kat_id');
        $this->db->select('projects.project_id');
        $this->db->select('projects.user_id');
        $this->db->select('projects.region_id');
        $this->db->select('projects.sector_id');
        $this->db->select('projects.property_type_id');
        $this->db->select('projects.price');
        $this->db->select('projects.youtube_video_link');
        $this->db->select('projects.url_image');
        $this->db->select('projects.project_author');
        $this->db->select('projects.author_telephone');
        $this->db->select('projects.author_email');
        $this->db->select('projects.add_date');
        
        $this->db->select('projects.lat');
        $this->db->select('projects.lng');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.translation_id');
        $this->db->select('project_translation.project_description');
        $this->db->select('project_translation.other_important_data');
        $this->db->select('project_translation.adress');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('sectors.sek_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        $this->db->select('property_type.property_name_' . $l . '');
        
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->join('sectors', 'sectors.sek_id = projects.sector_id');
        $this->db->join('property_type', 'property_type.property_type_id = projects.property_type_id');
        $this->db->where('projects.project_id', $project_id);
        $this->db->where('language.code', $l);
        $this->db->where('projects.isActive', 1);
        $query = $this->db->get();
        return $query->row_array();
        
        
    }
    
    public function get_related_projects_by_kat_id($kat_id)
    {
        $l=curLang();
        $this->db->select('projects.project_id');
        $this->db->select('projects.url_image');
        $this->db->select('projects.top');
        $this->db->select('projects.add_date');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.project_description');
        
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->limit(5);
        $this->db->where('projects.isActive', 1);
        $this->db->where('language.code', $l);
        $this->db->where('categories.status', 1);
        $this->db->where('projects.kat_id', $kat_id);
        $this->db->order_by('RAND()');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function record_count()
    {
        $this->db->where('projects.isActive', 1);
        $this->db->from('projects');
        return $this->db->count_all_results();
        
    }
    
    public function record_count_cat_id($id)
    {
        $this->db->where('projects.isActive', 1);
        $this->db->where('projects.kat_id', $id);
        $this->db->from('projects');
        return $this->db->count_all_results();
        
    }
    
    
    public function get_all_projects($limit, $start)
    {
        $l=curLang();
        
        $this->db->select('projects.*');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.project_description');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('projects.isActive', 1);
        $this->db->where('categories.status', 1);
        $this->db->where('language.code', $l);
        $this->db->order_by('projects.project_id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_projects_by_category($cat_id, $limit, $start)
    {
        $l=curLang();
        
        $this->db->select('projects.*');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.project_description');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('projects.isActive', 1);
        $this->db->where('language.code', $l);
        $this->db->order_by('projects.project_id', 'desc');
        $this->db->where('projects.kat_id', $cat_id);
        $this->db->where('categories.status', 1);
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function filter_projects($sector, $category, $region, $min, $max, $limit, $start)
    {
        $l=curLang();
        
        $this->db->select('projects.*');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.project_description');
        $this->db->select('categories.kat_adi_' . $l . '');
        $this->db->select('regions.reg_adi_' . $l . '');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = projects.region_id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('projects.isActive', 1);
        $this->db->where('categories.status', 1);
        $this->db->where('language.code', $l);
        $this->db->order_by('projects.project_id', 'desc');
        if ($category != 0) {
            $this->db->where('projects.kat_id', $category);
        }
        if ($sector != 0) {
            $this->db->where('projects.sector_id', $sector);
        }
        if ($region != 0) {
            $this->db->where('projects.region_id', $region);
        }
        if ($max != 0) {
            $this->db->where('invesment_volume <=', $max);
        }
        if ($min != 0) {
            $this->db->where('invesment_volume >=', $min);
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    
    
    public function project_check($project_id)
    {
        $this->db->select('user_id');
        $this->db->from('projects');
        $this->db->where('project_id', $project_id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }
    public function delete_user_project($project_id)
    {
        $this->db->set('isActive', 2);
        $this->db->where('project_id', $project_id);
        $this->db->update('projects');
    }
    public function activate_user_project($project_id)
    {
        $this->db->set('isActive', 1);
        $this->db->where('project_id', $project_id);
        $this->db->update('projects');
    }
    public function delete_translation($translate_id)
    {
        $this->db->where('translation_id', $translate_id);
        $this->db->delete('project_translation');
    }
    
    
  public function deleteimage($pid = '')
    {
        if ($pid != '') {
            $fileurl = './' . $this->db->get_where('files', array('files_id' => $pid))->row()->files_url;
            $this->db->where('files_id', $pid);
            $this->db->delete('files');
            if (file_exists($fileurl)) {
                unlink($fileurl);
            }
            return true;
        }
    }
    public function add_project($project)
    {
        $this->db->insert('projects', $project);
        return $id = $this->db->insert_id();
    }
    public function add_translate($translate)
    {
        $this->db->insert('project_translation', $translate);
    }
    
    public function update_project($project_id, $project_data)
    {
        $this->db->where('project_id', $project_id);
        $this->db->update('projects', $project_data);
    }
    
    public function update_translation($translation_id, $lang_code, $translation_data)
    {
        $this->db->where('translation_id', $translation_id);
        $this->db->where('lang_code', $lang_code);
        $this->db->update('project_translation', $translation_data);
    }
    public function update_translation_moderator($project_id, $lang_code, $translation_data)
    {
        $this->db->where('project_id', $project_id);
        $this->db->where('lang_code', $lang_code);
        $this->db->update('project_translation', $translation_data);
    }
    public function add_reytinq($project_id)
    {
        $client_ip = $this->input->ip_address();
        $this->db->select('*');
        $this->db->from('reytinq');
        $this->db->where('project_id', $project_id);
        $this->db->where('client_ip', $client_ip);
        $query = $this->db->get();
        if (!$query->num_rows()) {
            $reytinq_data = array(
                'client_ip' => $client_ip,
                'project_id' => $project_id,
                'date' => date('d-m-Y')
            );
            $this->db->insert('reytinq', $reytinq_data);
        }
    }
    function upload_files($post = '', $folder = '', $id = '')
    {
        $can = true;
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        foreach ($_FILES[$post]['name'] as $key => $val) {
            $fileName = basename($_FILES[$post]['name'][$key]);
            $targetFilePath =  './files/' . $folder . '/' . $fileName;
            $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
            if (!in_array($fileType, $allowTypes)) {
                $can = false;
            }
        }

        if ($can) {
            foreach ($_FILES[$post]['name'] as $key => $val) {
                $fileName = basename($_FILES[$post]['name'][$key]);
                $targetFilePath =  './files/' . $folder . '/' . $fileName;
                $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
                $new_image_name = substr(md5(sha1(mt_rand()*mt_rand())), 12) . rand(1111, 9999) . '.' . $fileType;
                move_uploaded_file($_FILES[$post]["tmp_name"][$key], './files/' . $folder . '/' . $new_image_name);
                $data['files_url'] = 'files/' . $folder . '/' . $new_image_name;
                $data['files_type'] = $folder;
                $data['files_type_id'] = $id;
                $this->db->insert('files', $data);
                   $configer =  array(
                    'image_library'   => 'gd2',
                    'source_image'    =>  'files/' . $folder . '/' . $new_image_name,
                    'maintain_ratio'  =>  TRUE,
                    'quality'         => '95%', 
                    'width'           =>  787,
                    'height'          =>  571,
                         );
                   $this->image_lib->clear();
                   $this->image_lib->initialize($configer);
                   $this->image_lib->resize();
            }
            return true;
        } else {
            return 'file_type_error';
        }
    }
    public function get_project_view_count($project_id)
    {
        $sql   = 'SELECT COUNT(id) as count from reytinq WHERE project_id=' . $project_id . ' GROUP BY(project_id) ';
        $query = $this->db->query($sql);
        $ret   = $query->row();
        if ($ret) {
            return $ret->count;
        } else {
            return false;
        }
    }
    
    public function get_most_viewed_projects()
    {
        $l=curLang();
        $this->db->select('projects.project_id ');
        $this->db->select('projects.top ');
        $this->db->select('projects.url_image');
        $this->db->select('projects.add_date');
        $this->db->select('COUNT(reytinq.id) as total');
        $this->db->select('project_translation.project_title');
        
        $this->db->from('reytinq');
        $this->db->query('SET SESSION sql_mode =REPLACE(REPLACE(REPLACE(@@sql_mode,"ONLY_FULL_GROUP_BY,", ""),",ONLY_FULL_GROUP_BY", ""),"ONLY_FULL_GROUP_BY", "")');
        $this->db->join('projects', 'reytinq.project_id=projects.project_id');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->group_by('reytinq.project_id');
        $this->db->limit(5);
        $this->db->where('projects.isActive', 1);
        $this->db->where('language.code', $l);
        $this->db->where('categories.status', 1);
        $this->db->order_by('total', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_all_projects_moderator()
    {
        $l=curLang();
        $this->db->select('projects.project_id');
        $this->db->select('projects.isActive');
        $this->db->select('projects.add_date');
        $this->db->select('projects.kat_id');
        $this->db->select('project_translation.project_title');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('categories.status', 1);
        $this->db->where('project_translation.lang_code', $l);
        $this->db->order_by('projects.project_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_deleted_projects_moderator()
    {
        $l=curLang();
        $this->db->select('projects.project_id');
        $this->db->select('projects.isActive');
        $this->db->select('projects.add_date');
        $this->db->select('projects.kat_id');
        $this->db->select('project_translation.project_title');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('categories.status', 1);
        $this->db->where('project_translation.lang_code', $l);
        $this->db->where('projects.isActive', 2);
        $this->db->order_by('projects.project_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_not_accepted_projects()
    {
        $this->db->select('projects.project_id');
        $this->db->select('projects.isActive');
        $this->db->select('projects.add_date');
        $this->db->select('projects.kat_id');
        $this->db->select('project_translation.project_title');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('categories.status', 1);
        $this->db->where('projects.isActive', 0);
        $this->db->order_by('projects.project_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_edited_projects()
    {
        $l=curLang();
        $this->db->select('projects.project_id');
        $this->db->select('projects.isActive');
        $this->db->select('projects.add_date');
        $this->db->select('projects.kat_id');
        $this->db->select('project_translation.project_title');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('categories.status', 1);
        $this->db->where('project_translation.lang_code', $l);
        $this->db->where('projects.isActive', 3);
        $this->db->order_by('projects.project_id', 'desc');
        $query = $this->db->get();
        return $query->result_array();
    }
    
    
    public function get_accepted_projects()
    {
        $l=curLang();
        
        $this->db->select('projects.project_id');
        $this->db->select('projects.isActive');
        $this->db->select('projects.add_date');
        $this->db->select('projects.kat_id');
        $this->db->select('project_translation.project_title');
        $this->db->from('projects');
        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('categories.status', 1);
        $this->db->where('projects.isActive', 1);
        $this->db->order_by('projects.project_id', 'desc');
        $this->db->where('project_translation.lang_code', $l);
        $query = $this->db->get();
        return $query->result_array();
    }
    
    public function get_project_detail_moderator($project_id)
    {
        $this->db->select('projects.*');
        $this->db->from('projects');
        $this->db->where('projects.project_id', $project_id);
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->where('categories.status', 1);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function get_project_translation($project_id)
    {
        $this->db->select('project_translation.*');
        $this->db->from('project_translation');
        $this->db->where('project_translation.project_id', $project_id);
        $query = $this->db->get();
        return $query->result_array();
        
    }
    
}

?>
