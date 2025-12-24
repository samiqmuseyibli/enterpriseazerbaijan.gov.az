<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Geomap extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('language')) {
            $lang = $this->db->get_where('general_settings', array('type' => 'site_language'))->row()->value;
            $this->session->set_userdata('language', $lang);
        }
    }

    public function index()
    {
        $categories = $this->db->get('geo_categories');
        $page_data['categories'] = $categories->result_array();
        $page_data['page_name'] = 'map';
        $page_data['detail'] = $this->db->get_where('geomap', array('geo_kat' => 1, 'geo_subkat' => 1))->result_array();
        $this->load->view('map', $page_data);
    }

    public function set($id = '', $id_ = '')
    {
        $page_data['page_name'] = 'map';
        $page_data['detail'] = $this->db->get_where('geomap', array('geo_kat' => $id, 'geo_subkat' => $id_))->result_array();
        $categories = $this->db->get('geo_categories');
        $page_data['categories'] = $categories->result_array();
        $this->load->view('map', $page_data);
    }
}

?>