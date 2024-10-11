<?php 
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Contact extends CI_Controller {
		
		public function __construct(){
			
			parent::__construct();
			$this->load->model('user_model');
			$this->load->helper(array('captcha'));
			
			if(!$this->session->userdata('language')){
				$lang = $this->db->get_where('general_settings',array('type'=>'site_language'))->row()->value;
				$this->session->set_userdata('language', $lang);
			}
			
		} 
		
		public function index(){
			
			$l=curLang();
			
			$data['title']=translate('contact_title');
			$data['page_name']="contact"; 
			$this->load->view('index',$data);
		}
 
	}
 ?>