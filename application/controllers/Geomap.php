<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geomap extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('project_model');
        if (!$this->session->userdata('language')) {
            $lang = $this->db->get_where('general_settings', array('type' => 'site_language'))->row()->value;
            $this->session->set_userdata('language', $lang);
        }
    }

    function index()
    {
        $page_data['cat_id'] = '';
        $page_data['s_cat_id'] = '';
        $page_data['title'] = translate('geomap_title');
        $categories = $this->db->get('geo_categories');
        $page_data['categories'] = $categories->result_array();
        $page_data['page_name'] = 'map';
        $page_data['detail'] = $this->db->get_where('geomap', array('geo_status' => '1', 'geo_kat' => 0, 'geo_subkat' => 0))->result_array();
        $this->load->view('map', $page_data);
    }

    public function set($id = '', $id_ = '')
    {
        $id =html_escape($id);
        $id_=html_escape($id_);
        $page_data['cat_id'] = $id;
        $page_data['s_cat_id'] = $id_;
        $page_data['title'] = translate('geomap_title');
        $page_data['page_name'] = 'map';
        $page_data['detail'] = $this->db->get_where('geomap', array('geo_status' => '1', 'geo_kat' => $id, 'geo_subkat' => $id_))->result_array();
        $categories = $this->db->get('geo_categories');
        $page_data['categories'] = $categories->result_array();
        $this->load->view('map', $page_data);
    }

    public function setcategory($id = '')
    {
        $id=html_escape($id);
        $cat_data = $this->db->get_where('categories',array('kat_id' => $id,'map_status' => 1, 'status' => 1))->row();
        if (!empty($cat_data)) {
            $page_data['have_map_icon'] = 1;
        } 
        $page_data['cat_id'] = '5';
        $page_data['s_cat_id'] = $id;
        $page_data['title'] = translate('geomap_title');
        $page_data['page_name'] = 'map';
        $page_data['detail'] = $this->project_model->get_geomap_projects($id);
        $categories = $this->db->get('geo_categories');
        $page_data['categories'] = $categories->result_array();
        $this->load->view('map', $page_data);
        // print_r($page_data['detail']);
    }

    public function setcompany()
    {
        $page_data['cat_id'] = '9';
        $page_data['s_cat_id'] = '';
        $page_data['title'] = translate('geomap_title');
        $page_data['page_name'] = 'map';
        $page_data['detail'] = $this->project_model->get_geomap_companies();
        $categories = $this->db->get('geo_categories');
        $page_data['categories'] = $categories->result_array();
        $this->load->view('map', $page_data);
        // print_r($page_data['detail']);
    }

}

?>
