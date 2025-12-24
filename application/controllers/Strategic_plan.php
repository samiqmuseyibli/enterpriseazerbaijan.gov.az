<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Strategic_plan extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
<<<<<<< HEAD
        header('X-Frame-Options: SAMEORIGIN');
=======
>>>>>>> 4cc5aa09946e2d7d90543c375f38a44cdd79c424
        if (!$this->session->userdata('language')) {
            $lang = $this->db->get_where('general_settings', array('type' => 'site_language'))->row()->value;
            $this->session->set_userdata('language', $lang);
        }

    }

    public function index()
    {

<<<<<<< HEAD
        $l = curLang();
=======
        $l=curLang();

>>>>>>> 4cc5aa09946e2d7d90543c375f38a44cdd79c424
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