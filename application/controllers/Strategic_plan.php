<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Strategic_plan extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        header('X-Frame-Options: SAMEORIGIN');
        if (!$this->session->userdata('language')) {
            $lang = $this->db->get_where('general_settings', array('type' => 'site_language'))->row()->value;
            $this->session->set_userdata('language', $lang);
        }

    }

    public function index()
    {

        $l = curLang();
        $data['title'] = translate('strategic_plan');
        $this->db->select('title_' . $l . '');
        $this->db->select('description_' . $l . '');
        $this->db->from('strategic_plan');
        $query = $this->db->get();
        $data['detail'] = $query->row_array();
        $data['page_name'] = "strategic_plan";
        $this->load->view('index', $data);
    }

}

?>