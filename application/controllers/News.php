<?php 
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	class News extends CI_Controller { 
		
		public function __construct(){
			parent::__construct();
			$this->load->model('home_model');
			$this->load->model('admin_model');
			$this->load->library('pagination');
			
			if(!$this->session->userdata('language')){
				$lang = $this->db->get_where('general_settings',array('type'=>'site_language'))->row()->value;
				$this->session->set_userdata('language', $lang);
			}
		} 
		
		public function index(){
			//redirect('home');
			$pagedata['title']=translate('home_title_news');
			$config = array();
			$config["base_url"] = base_url() . "news/index";
			$config["total_rows"] = $this->home_model->record_count_all_news();
			$config["per_page"] = 9;  
			$config["page_query_string"] = TRUE;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['first_link'] = translate('First');
			$config['first_tag_open'] = '<li>';
			$config['first_tag_close'] = '</li>';
			$config['last_link'] = translate('Last');
			$config['last_tag_open'] = '<li>';
			$config['last_tag_close'] = '</li>';
			$config['next_link'] = translate('next');
			$config['next_tag_open'] = '<li>';
			$config['next_tag_close'] = '</li>';
			$config['prev_link'] =  translate('prev');
			$config['prev_tag_open'] = '<li>';
			$config['prev_tag_close'] = '</li>';
			$config['cur_tag_open'] = ' <li><a class="active" href="">';
			$config['cur_tag_close'] ='</a></li>';
			$config['num_tag_open'] = '<li>';
			$config['num_tag_close'] = '</li>';
			$this->pagination->initialize($config);    
			$page = $this->input->get('page');
			$pagedata["links"] = $this->pagination->create_links();  
			$pagedata['news']=$this->home_model->get_news($config["per_page"],$page);
			$this->load->view('news',$pagedata);
		} 
		
		public function detail($id=''){  
			$l=curLang();
			
			if ($id) {
				$data['related'] = $this->home_model->get_related_news();
				$data['detail']  = $this->home_model->get_news_by_id($id);
				$data['details'] = $this->admin_model->get_uploaded_file_news($id);

				$data['title']=$data['detail']['title_'.$l.''];
				if ($data['detail']) {
					$data['page_name']="news_detail"; 
					$this->load->view('index',$data);
				}else{
					redirect('news'); 
				}
				
			}else{
				redirect('news');
			}   
		}
	}
 ?>