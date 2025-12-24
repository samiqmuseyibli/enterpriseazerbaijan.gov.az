<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Competition extends CI_Controller
{

    public function __construct()
    {
    parent::__construct();    
    header('X-Frame-Options: SAMEORIGIN');
    }

    public function index()
    {

        $data['title'] = "Müsabiqə";
        $data['page_name'] = "competition";
        $this->load->view('index', $data);
    }

      public function register(){
        $this->form_validation->set_rules('name',                    'name  ',               'required|strip_tags|trim');
        $this->form_validation->set_rules('project_name',            'project_name',         'required|strip_tags|trim');
        $this->form_validation->set_rules('about_project',           'about_project',        'required|strip_tags|trim');
        $this->form_validation->set_rules('slovedproblems',          'slovedproblems',       'required|strip_tags|trim');
        $this->form_validation->set_rules('implementation_period',   'implementation_period', 'required|strip_tags|trim');
        $this->form_validation->set_rules('telephone',               'telephone',              'required|strip_tags|trim|numeric');
        $this->form_validation->set_rules('email',                   'email',                  'required|strip_tags|trim|valid_email');
        $this->form_validation->set_rules('minimum_required_funds',  'minimum_required_funds', 'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('number_of_team_members',  'number_of_team_members', 'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('other',                   'other',                        'strip_tags|trim');
   
        if ($this->form_validation->run() == FALSE) {

            $errors = validation_errors();
            $this->session->set_flashdata('error_message', translate('invalid_form_data'));
      
            $page_data['error_message'] =  $errors;
            $page_data['title'] = "Müsabiqə";
          
            $page_data['page_name'] = 'competition';
            $this->load->view('index', $page_data);
        
        }else{
            
           $data_M = array(
                'name'                   => html_escape($this->input->post('name')),
                'project_name'           => html_escape($this->input->post('project_name')),
                'about_project'          => html_escape($this->input->post('about_project')),
                'slovedproblems'         => html_escape($this->input->post('slovedproblems')),
                'implementation_period'  => html_escape($this->input->post('implementation_period')),
                'telephone'              => html_escape($this->input->post('telephone')),
                'email'                  => html_escape($this->input->post('email')),
                'minimum_required_funds' => html_escape($this->input->post('minimum_required_funds')),
                'number_of_team_members' => html_escape($this->input->post('number_of_team_members')),
                'other'                  => html_escape($this->input->post('other'))
               
            );

         $this->db->insert('competition',$data_M);  
         $this->session->set_flashdata('succes_message', 'Göndərildi!');
         redirect('competition');
}

}
 public function login($p=''){
         if ($p=='do') {
        if ($this->input->post('password') && $this->input->post('password')==='passforcrowdfunding') {
            $this->session->set_userdata('view_competition_list','yes');
            redirect('competition/login/list');


        }else{
            $page_data['title'] = "Müsabiqə-Daxil ol";
            $this->session->set_flashdata('error_message', "Şifrə düzgün deyil");
            $page_data['page_name'] = 'competition_login';
            $this->load->view('index', $page_data); 
        }
        }if($p==='list'  && $this->session->userdata('view_competition_list')==='yes'){
            $page_data['users'] = $this->db->get('competition')->result_array();
            $page_data['title'] = "Müsabiqə-List";
            $page_data['page_name'] = 'competition_list';
            $this->load->view('index', $page_data); 


        
      
           }else{

            $this->session->unset_userdata('view_competition_list');
            $page_data['title'] = "Müsabiqə-Daxil ol";
            $page_data['page_name'] = 'competition_login';
            $this->load->view('index', $page_data);
        
        }


}


}

?>