<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Cfprojects extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			date_default_timezone_set('Asia/Baku');
			$this->load->library('pagination');
			$this->load->model('cfprojects_model');
			if (!$this->session->userdata('language')) {
				$lang = $this->db->get_where('general_settings', array(
					'type' => 'site_language'
				))->row()->value;
				$this->session->set_userdata('language', $lang);
			}
		}
		
		public function index(){
			//redirect('cfprojects/all');
			redirect('home');
		}
		
		public function all(){

			redirect('home');
			
			$pagedata['title']           = translate('home_title_all_projects');
			$config                      = array();
			$config["base_url"]          = base_url() . "cfprojects/all";
			$config["total_rows"]        = $this->cfprojects_model->record_count_all_cfprojects();
			$config["per_page"]          = 9;
			$config["page_query_string"] = TRUE;
			$config['full_tag_open']     = '<ul class="pagination">';
			$config['full_tag_close']    = '</ul>';
			$config['first_link']        = translate('First');
			$config['first_tag_open']    = '<li>';
			$config['first_tag_close']   = '</li>';
			$config['last_link']         = translate('Last');
			$config['last_tag_open']     = '<li>';
			$config['last_tag_close']    = '</li>';
			$config['next_link']         = translate('next');
			$config['next_tag_open']     = '<li>';
			$config['next_tag_close']    = '</li>';
			$config['prev_link']         = translate('prev');
			$config['prev_tag_open']     = '<li>';
			$config['prev_tag_close']    = '</li>';
			$config['cur_tag_open']      = ' <li><a class="active" href="">';
			$config['cur_tag_close']     = '</a></li>';
			$config['num_tag_open']      = '<li>';
			$config['num_tag_close']     = '</li>';
			$this->pagination->initialize($config);
			$page                    = $this->input->get('page');
			$pagedata["links"]       = $this->pagination->create_links();
			$pagedata['allprojects'] = $this->cfprojects_model->get_all_cfprojects($config["per_page"], $page);

			$pagedata['page_name'] = 'cfprojects/all_projects';
			$this->load->view('index', $pagedata);
		}
		
		public function category(){

			redirect('home');
			
			$id_string                   = $this->uri->segment(3, 0);
			$filteredNumbers             = array_filter(preg_split("/\D+/", $id_string));
			$category_id                 = reset($filteredNumbers);
			$pagedata['title']           = translate('home_title_category');
      
			$config                      = array();
			$config["base_url"]          = base_url() . "cjprojects/category/" . $this->uri->segment(3, 0);
			$config["total_rows"]        = $this->cfprojects_model->record_count_cat_cfprojects($category_id);
			$config["per_page"]          = 9;
			$config["page_query_string"] = TRUE;
			$config['full_tag_open']     = '<ul class="pagination">';
			$config['full_tag_close']    = '</ul>';
			$config['first_link']        = translate('First');
			$config['first_tag_open']    = '<li>';
			$config['first_tag_close']   = '</li>';
			$config['last_link']         = translate('Last');
			$config['last_tag_open']     = '<li>';
			$config['last_tag_close']    = '</li>';
			$config['next_link']         = translate('next');
			$config['next_tag_open']     = '<li>';
			$config['next_tag_close']    = '</li>';
			$config['prev_link']         = translate('prev');
			$config['prev_tag_open']     = '<li>';
			$config['prev_tag_close']    = '</li>';
			$config['cur_tag_open']      = ' <li><a class="active" href="">';
			$config['cur_tag_close']     = '</a></li>';
			$config['num_tag_open']      = '<li>';
			$config['num_tag_close']     = '</li>';
			$this->pagination->initialize($config);
			$page                    = $this->input->get('page');
			$pagedata["links"]       = $this->pagination->create_links();
			$pagedata['allprojects'] = $this->cfprojects_model->get_cfprojects_by_category($category_id, $config["per_page"], $page);
			if($pagedata['allprojects']) {
				$pagedata['page_name'] = 'cfprojects/all_projects';
				$this->load->view('index', $pagedata);
			}else{
				$pagedata['page_name'] = 'cfprojects/all_projects';
				$this->load->view('index', $pagedata);
			}
		}
		
		public function filter(){

			redirect('home');
			
			$category       = htmlspecialchars(addslashes(strip_tags(trim($this->input->get('category')))), ENT_QUOTES);
			$region         = htmlspecialchars(addslashes(strip_tags(trim($this->input->get('region')))), ENT_QUOTES);
			$cost_option    = htmlspecialchars(addslashes(strip_tags(trim($this->input->get('cost_option')))), ENT_QUOTES);
			$result_explode = explode('-', $cost_option);
        
			$page_data['title']          = translate('home_title_filter');
			$config                      = array();
			$config["base_url"]          = base_url() . "cfprojects/filter/?region=" . $region . "&category=" . $category . "&cost_option=" . $cost_option . "";
			$config["total_rows"]        = $this->cfprojects_model->record_count_cfprojects_filter($category, $region, $result_explode[0], $result_explode[1]);
			$config["per_page"]          = 9;
			$config["page_query_string"] = TRUE;
			$config['full_tag_open']     = '<ul class="pagination">';
			$config['full_tag_close']    = '</ul>';
			$config['first_link']        = translate('First');
			$config['first_tag_open']    = '<li>';
			$config['first_tag_close']   = '</li>';
			$config['last_link']         = translate('Last');
			$config['last_tag_open']     = '<li>';
			$config['last_tag_close']    = '</li>';
			$config['next_link']         = translate('next');
			$config['next_tag_open']     = '<li>';
			$config['next_tag_close']    = '</li>';
			$config['prev_link']         = translate('prev');
			$config['prev_tag_open']     = '<li>';
			$config['prev_tag_close']    = '</li>';
			$config['cur_tag_open']      = ' <li><a class="active" href="">';
			$config['cur_tag_close']     = '</a></li>';
			$config['num_tag_open']      = '<li>';
			$config['num_tag_close']     = '</li>';
			$this->pagination->initialize($config);
			$page_data["links"] = $this->pagination->create_links();
			$page               = $this->input->get('page');
			if ($category == 0 and $region == 0 and $result_explode[0] == 0 and $result_explode[1] == 0) {
				redirect('cfprojects/all');
			} else {
				$page_data['allprojects'] = $this->cfprojects_model->filter_cfprojects($category, $region, $result_explode[0], $result_explode[1], $config["per_page"], $page);
				if ($page_data['allprojects']) {
						$page_data['page_name'] = 'cfprojects/all_projects';
						$this->load->view('index', $page_data);
				} else {
						 $page_data['page_name'] = 'cfprojects/all_projects';
						$this->load->view('index', $page_data);
				}
			}
		}
		
		public function detail(){

			redirect('home');
			
			$id_string       	= $this->uri->segment(3, 0);
			$filteredNumbers 	= array_filter(preg_split("/\D+/", $id_string));
			$id              	= reset($filteredNumbers);
       
			$page_data['detail']= $this->cfprojects_model->cfproject_detail($id);
			$page_data['title'] = $page_data['detail']['title'].' - Enterpriseazerbaijan.com';
			if ($page_data['detail']) {
				$page_data['page_name'] = 'cfprojects/detail';
				$this->load->view('index', $page_data);
			}
      
		}
		
		public function about(){

			redirect('home');
			
			$page_data['detail']=$this->cfprojects_model->get_about(); 
			$page_data['title']=translate('about_crowdfanding');
			$page_data['page_name']='cfprojects/about';
			$this->load->view('index',$page_data); 

		}
	}
?>