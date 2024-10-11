<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cfprojects_model extends CI_model
{
    public function __construct()
    {
        parent::__construct();
    }

    function record_count_all_cfprojects()
    {
        $this->db->where('status', 1);
        $this->db->from('cf_projects');
        return $this->db->count_all_results();
    }

    function record_count_cat_cfprojects($id = '')
    {
        $this->db->where('status', 1);
        $this->db->where('category_id', $id);
        $this->db->from('cf_projects');
        return $this->db->count_all_results();
    }

    function record_count_cfprojects_filter($category = '', $region = '', $min = '', $max = '')
    {
        $this->db->where('status', 1);
        if ($category != 0) {
            $this->db->where('category_id', $category);
        }
        if ($region != 0) {
            $this->db->where('region_id', $region);
        }
        if ($max != 0) {
            $this->db->where('price <=', $max);
        }
        if ($min != 0) {
            $this->db->where('price >=', $min);
        }
        $this->db->from('cf_projects');
        return $this->db->count_all_results();
    }

    public function get_all_cfprojects($limit = '', $start = '')
    {
        $l=curLang();

        $this->db->select('cf_projects.id');
        $this->db->select('cf_projects.price');
        $this->db->select('cf_projects.image');
        $this->db->select('cf_projects.link');
        // $this->db->select('cf_projects.id');
        // $this->db->select('cf_projects.id');

        $this->db->select('cf_project_translation.id');
        $this->db->select('cf_project_translation.project_id');
        $this->db->select('cf_project_translation.title');
        $this->db->select('cf_project_translation.about');
        $this->db->select('cf_project_translation.description');
        $this->db->select('cf_project_translation.address');
        $this->db->select('cf_project_translation.author');
        $this->db->select('cf_project_translation.lang_code');

        $this->db->select('cf_categories.title_' . $l . ' as category_name');
        $this->db->select('regions.reg_adi_' . $l . '  as region_name');
        $this->db->select('SUM(cf_transactions.cost) as total_price');
        $this->db->from('cf_projects');
        $this->db->join('cf_transactions', 'cf_transactions.project_id = cf_projects.id','right');
        $this->db->join('cf_project_translation', 'cf_projects.id = cf_project_translation.project_id');
        $this->db->join('language', 'cf_project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = cf_projects.region_id');
        $this->db->join('cf_categories', 'cf_categories.id = cf_projects.category_id');
        $this->db->group_by('cf_transactions.project_id,cf_projects.id,cf_projects.price,cf_projects.image,cf_projects.link,cf_project_translation.id,cf_project_translation.project_id,cf_project_translation.title,cf_project_translation.about,cf_project_translation.description,cf_project_translation.address,cf_project_translation.author,cf_project_translation.lang_code');
        $this->db->where('cf_projects.status', 1);
        $this->db->where('language.code', $l);
        $this->db->order_by('cf_projects.id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function filter_cfprojects($category = '', $region = '', $min = '', $max = '', $limit = '', $start = '')
    {
        $l=curLang();
        $this->db->select('cf_projects.id');
        $this->db->select('cf_projects.price');
        $this->db->select('cf_projects.image');
        $this->db->select('cf_projects.link');
        // $this->db->select('cf_projects.id');
        // $this->db->select('cf_projects.id');

        $this->db->select('cf_project_translation.id');
        $this->db->select('cf_project_translation.project_id');
        $this->db->select('cf_project_translation.title');
        $this->db->select('cf_project_translation.about');
        $this->db->select('cf_project_translation.description');
        $this->db->select('cf_project_translation.address');
        $this->db->select('cf_project_translation.author');
        $this->db->select('cf_project_translation.lang_code');

        $this->db->select('SUM(cf_transactions.cost) as total_price');
        $this->db->select('cf_categories.title_' . $l . ' as category_name');
        $this->db->select('regions.reg_adi_' . $l . '      as region_name');
        $this->db->from('cf_projects');
        $this->db->join('cf_project_translation', 'cf_projects.id = cf_project_translation.project_id');
        $this->db->join('language', 'cf_project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = cf_projects.region_id');
        $this->db->join('cf_categories', 'cf_categories.id = cf_projects.category_id');
        $this->db->join('cf_transactions', 'cf_transactions.project_id = cf_projects.id');
        $this->db->group_by('cf_transactions.project_id,cf_projects.id,cf_projects.price,cf_projects.image,cf_projects.link,cf_project_translation.id,cf_project_translation.project_id,cf_project_translation.title,cf_project_translation.about,cf_project_translation.description,cf_project_translation.address,cf_project_translation.author,cf_project_translation.lang_code');
        $this->db->where('cf_projects.status', 1);
        $this->db->where('language.code', $l);
        $this->db->order_by('cf_projects.id', 'desc');
        if ($category != 0) {
            $this->db->where('cf_projects.category_id', $category);
        }
        if ($region != 0) {
            $this->db->where('cf_projects.region_id', $region);
        }
        if ($max != 0) {
            $this->db->where('cf_projects.price <=', $max);
        }
        if ($min != 0) {
            $this->db->where('cf_projects.price >=', $min);
        }
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function cfproject_detail($id = '')
    {
        $id=html_escape($id);
        $l=curLang();
        $this->db->select('cf_projects.id');
        $this->db->select('cf_projects.price');
        $this->db->select('cf_projects.image');
        $this->db->select('cf_projects.link');
        // $this->db->select('cf_projects.id');
        // $this->db->select('cf_projects.id');

        $this->db->select('cf_project_translation.id');
        $this->db->select('cf_project_translation.project_id');
        $this->db->select('cf_project_translation.title');
        $this->db->select('cf_project_translation.about');
        $this->db->select('cf_project_translation.description');
        $this->db->select('cf_project_translation.address');
        $this->db->select('cf_project_translation.author');
        $this->db->select('cf_project_translation.lang_code');

        $this->db->select('SUM(cf_transactions.cost) as total_price');
        $this->db->select('cf_categories.title_' . $l . ' as category_name');
        $this->db->select('cf_categories.id as category_id');
        $this->db->select('cf_categories.link as category_link');
        $this->db->select('regions.reg_adi_' . $l . '      as region_name');
        $this->db->from('cf_projects');
        $this->db->join('cf_project_translation', 'cf_projects.id = cf_project_translation.project_id');
        $this->db->join('language', 'cf_project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = cf_projects.region_id');
        $this->db->join('cf_categories', 'cf_categories.id = cf_projects.category_id');
        $this->db->join('cf_transactions', 'cf_transactions.project_id = cf_projects.id');
        $this->db->group_by('cf_transactions.project_id,cf_projects.id,cf_projects.price,cf_projects.image,cf_projects.link,cf_project_translation.id,cf_project_translation.project_id,cf_project_translation.title,cf_project_translation.about,cf_project_translation.description,cf_project_translation.address,cf_project_translation.author,cf_project_translation.lang_code');
        $this->db->where('cf_projects.status', 1);
        $this->db->where('language.code', $l);
        $this->db->where('cf_projects.id', $id);

        $query = $this->db->get();
        return $query->row_array();
    }

    public function get_cfprojects_by_category($category_id = '', $limit = '', $start = '')
    {
        $l=curLang();
       $this->db->select('cf_projects.id');
        $this->db->select('cf_projects.price');
        $this->db->select('cf_projects.image');
        $this->db->select('cf_projects.link');
        // $this->db->select('cf_projects.id');
        // $this->db->select('cf_projects.id');

        $this->db->select('cf_project_translation.id');
        $this->db->select('cf_project_translation.project_id');
        $this->db->select('cf_project_translation.title');
        $this->db->select('cf_project_translation.about');
        $this->db->select('cf_project_translation.description');
        $this->db->select('cf_project_translation.address');
        $this->db->select('cf_project_translation.author');
        $this->db->select('cf_project_translation.lang_code');
        
        $this->db->select('SUM(cf_transactions.cost) as total_price');
        $this->db->select('cf_categories.title_' . $l . ' as category_name');
        $this->db->select('regions.reg_adi_' . $l . '      as region_name');
        $this->db->from('cf_projects');
        $this->db->join('cf_transactions', 'cf_transactions.project_id = cf_projects.id');
        $this->db->join('cf_project_translation', 'cf_projects.id = cf_project_translation.project_id');
        $this->db->join('language', 'cf_project_translation.lang_code = language.code');
        $this->db->join('regions', 'regions.reg_id = cf_projects.region_id');
        $this->db->join('cf_categories', 'cf_categories.id = cf_projects.category_id');
        $this->db->group_by('cf_transactions.project_id,cf_projects.id,cf_projects.price,cf_projects.image,cf_projects.link,cf_project_translation.id,cf_project_translation.project_id,cf_project_translation.title,cf_project_translation.about,cf_project_translation.description,cf_project_translation.address,cf_project_translation.author,cf_project_translation.lang_code');
        $this->db->where('cf_projects.status', 1);
        $this->db->where('cf_projects.category_id', $category_id);
        $this->db->where('language.code', $l);
        $this->db->order_by('cf_projects.id', 'desc');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_about()
    {
        $l=curLang();
        $this->db->select('cf_about.content_' . $l . ' as content');

        $this->db->from('cf_about');

        $this->db->where('cf_about.status', 1);

        $query = $this->db->get();
        return $query->row_array();
    }

}

?>
