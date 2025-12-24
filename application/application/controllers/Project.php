<?php
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Project extends CI_Controller{
		
		public function __construct(){
			parent::__construct();
			header('X-Frame-Options: SAMEORIGIN');
			date_default_timezone_set('Asia/Baku');
			$this->load->library('pagination');
			$this->load->model('user_model');
			$this->load->model('email_model');
			$this->load->model('project_model');
			$this->load->model('home_model');
			if (!$this->session->userdata('language')) {
				$lang = $this->db->get_where('general_settings', array(
					'type' => 'site_language'
				))->row()->value;
				$this->session->set_userdata('language', $lang);
			}
		}
		
		public function index(){

			$l = curLang();
			redirect($l.'/project/all');

		}
		
		public function all(){

			$l = curLang();
			
			$pagedata['title']           = translate('home_title_all_projects');
			$pagedata['regions']         = $this->project_model->get_regions();
			$pagedata['sectors']         = $this->project_model->get_sectors();
			$pagedata['categories']      = $this->project_model->get_categories();
			$config                      = array();
			$config["base_url"]          = base_url($l) . "/project/all";
			$config["total_rows"]        = $this->project_model->record_count_all_projects();
			$config["per_page"]          = 15;
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
			$pagedata['allprojects'] = $this->project_model->get_all_projects($config["per_page"], $page);
			$this->load->view('home_all_projects', $pagedata);
			
		}
		
		public function category(){		 
			
			// $id_string                   = $this->uri->segment(3, 0);
			// $filteredNumbers             = array_filter(preg_split("/\D+/", $id_string));
			// $category_id                 = html_escape(reset($filteredNumbers));

			$category_id = html_escape((int) $this->uri->segment(4, 0));

			$l = curLang();

			if (is_numeric($category_id) and $category_id !=0 ){			
				
				$pagedata['title']           = translate('home_title_category');
				$pagedata['regions']         = $this->project_model->get_regions();
				$pagedata['sectors']         = $this->project_model->get_sectors();
				$pagedata['categories']      = $this->project_model->get_categories();
				$config                      = array();
				$config["base_url"]          = base_url($l) . "/project/category/" . $this->uri->segment(3, 0);
				$config["total_rows"]        = $this->project_model->record_count_cat_projects($category_id);
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
				$pagedata['allprojects'] = $this->project_model->get_projects_by_category($category_id, $config["per_page"], $page);
				$this->load->view('home_all_projects', $pagedata);
				
			}else{
				redirect('project/all');
			}
		}
		
		public function filter(){
			
			$sector         = htmlspecialchars(addslashes(strip_tags(trim($this->input->get('sector')))), ENT_QUOTES);
			$category       = htmlspecialchars(addslashes(strip_tags(trim($this->input->get('category')))), ENT_QUOTES);
			$region         = htmlspecialchars(addslashes(strip_tags(trim($this->input->get('region')))), ENT_QUOTES);
			$cost_option    = htmlspecialchars(addslashes(strip_tags(trim($this->input->get('cost_option')))), ENT_QUOTES);
			$result_explode = explode('-', $cost_option);

			$l = curLang();
        
			$page_data['regions']        = $this->project_model->get_regions();
			$page_data['sectors']        = $this->project_model->get_sectors();
			$page_data['categories']     = $this->project_model->get_categories();
			$page_data['title']          = translate('home_title_filter');
			$config                      = array();
			$config["base_url"]          = base_url($l) . "/project/filter/?sector=" . $sector . "&region=" . $region . "&category=" . $category . "&cost_option=" . $cost_option . "";
			$config["total_rows"]        = $this->project_model->record_count_projects_filter($sector, $category, $region, $result_explode[0], $result_explode[1]);
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
			if ($sector == 0 and $category == 0 and $region == 0 and $result_explode[0] == 0 and $result_explode[1] == 0) {
				redirect($l.'/project/all');
			}else {
				$page_data['allprojects'] = $this->project_model->filter_projects($sector, $category, $region, $result_explode[0], $result_explode[1], $config["per_page"], $page);
				if ($page_data['allprojects']) {
					$this->load->view('home_all_projects', $page_data);
				} else {
					$this->load->view('home_all_projects', $page_data);
				}
			}
			
		}
		
		public function detail(){
			
			// $id_string       = $this->uri->segment(4, 0);
			// $filteredNumbers = array_filter(preg_split("/\D+/", $id_string));
			// $id              = html_escape(reset($filteredNumbers));

			$id = html_escape((int) $this->uri->segment(4, 0));

			$this->project_model->add_reytinq($id);
			$kat_id = $this->project_model->get_projects_category_id($id);

			$l = curLang();
			
			if ($kat_id) {
				//$page_data['view_count']       = $this->project_model->get_project_view_count($id);
				$page_data['category']         = $this->project_model->get_categories();
				$page_data['related_projects'] = $this->project_model->get_related_projects_by_kat_id($kat_id);
				$page_data['most_viewed']      = $this->project_model->get_most_viewed_projects();
				$page_data['title']            = translate('home_title_detail');
				if ($kat_id == 1) {
					$page_data['detail'] = $this->project_model->get_project_detail_startup($id);
					if ($page_data['detail']) {
						$page_data['page_name'] = 'home_detail';
						$this->load->view('index', $page_data);
					} else {
						$page_data['page_name'] = '404';
						$this->load->view('index', $page_data);
					}
				}
				if ($kat_id == 2) {
					$page_data['detail'] = $this->project_model->get_project_detail_land_sale($id);
					if ($page_data['detail']) {
						
						$page_data['page_name'] = 'home_detail';
						$this->load->view('index', $page_data);
					} else {
						$page_data['page_name'] = '404';
						$this->load->view('index', $page_data);
					}
				}
				if ($kat_id == 3) {
					$page_data['detail'] = $this->project_model->get_project_detail_stock($id);
					if ($page_data['detail']) {
						// print_r($page_data['project_detail']);
						$page_data['page_name'] = 'home_detail';
						$this->load->view('index', $page_data);
					} else {
						$page_data['page_name'] = '404';
						$this->load->view('index', $page_data);
					}
				}
				if ($kat_id == 4) {
					$page_data['detail'] = $this->project_model->get_project_detail_business($id);
					if ($page_data['detail']) {
						$page_data['page_name'] = 'home_detail';
						$this->load->view('index', $page_data);
					} else {
						$page_data['page_name'] = '404';
						$this->load->view('index', $page_data);
					}
				}
				if ($kat_id == 5) {
					$page_data['detail'] = $this->project_model->get_project_detail_idea($id);
					if ($page_data['detail']) {
						$page_data['page_name'] = 'home_detail';
						$this->load->view('index', $page_data);
					} else {
						$page_data['page_name'] = '404';
						$this->load->view('index', $page_data);
					}
				}
				if ($kat_id == 6) {
					$page_data['detail'] = $this->project_model->get_project_detail_stock($id);
					if ($page_data['detail']) {
						$page_data['page_name'] = 'home_detail';
						$this->load->view('index', $page_data);
					} else {
						$page_data['page_name'] = '404';
						$this->load->view('index', $page_data);
					}
				}
				if ($kat_id == 7) {
					$page_data['detail'] = $this->project_model->get_project_detail_estate($id);
					if ($page_data['detail']) {
						$page_data['page_name'] = 'home_detail';
						$this->load->view('index', $page_data);
					} else {
						$page_data['page_name'] = '404';
						$this->load->view('index', $page_data);
					}
				}
				if ($kat_id == 9) {
					$page_data['detail'] = $this->project_model->get_project_detail_investment($id);
					if ($page_data['detail']) {
						$page_data['page_name'] = 'home_detail';
						$this->load->view('index', $page_data);
					} else {
						$page_data['page_name'] = '404';
						$this->load->view('index', $page_data);
					}
				}
			} else {
				$page_data['title']            = translate('not_found');
				$page_data['page_name'] = '404';
				$this->load->view('index', $page_data);
			}
		}
	}
?>