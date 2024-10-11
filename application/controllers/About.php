<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class About extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        if (!$this->session->userdata('language')) {
            $lang = $this->db->get_where('general_settings', array('type' => 'site_language'))->row()->value;
            $this->session->set_userdata('language', $lang);
        }

    }

    public function index()
    {

        $l=curLang();

        $data['title'] = translate('about_title');
        $this->db->select('basliq_' . $l . '');
        $this->db->select('hedef_' . $l . '');
        $this->db->select('missiya_' . $l . '');
        $this->db->select('meksed_' . $l . '');
        $this->db->select('content_' . $l . '');
        $this->db->from('about_us');
        $query = $this->db->get();
        $data['detail'] = $query->row_array();
        $data['page_name'] = "about";
        $this->load->view('index', $data);
    }

}

?>