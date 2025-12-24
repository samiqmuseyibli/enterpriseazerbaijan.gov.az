<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Creativespark extends CI_Controller{

		public function __construct(){
			parent::__construct(); 
			header('X-Frame-Options: SAMEORIGIN');
			date_default_timezone_set( 'Asia/Baku' ); 	
			$this->load->model('email_model');			
		}

		public function index(){
		    //redirect('index'); 
            
			$data['title'] = "Creative Spark Pitch Competition yarışması";
			$data['page_name'] = "creativespark";
			$this->load->view('index', $data);
			
			
		}

		public function register(){
		  
			$this->form_validation->set_rules('project_name',            'project_name',            'required|strip_tags|trim');
			$this->form_validation->set_rules('project_category',        'project_category',        'required|strip_tags|trim|in_list[digital_technology,social_impact,creative]');
			$this->form_validation->set_rules('about_problem',           'about_problem',        	'required|strip_tags|trim');
			$this->form_validation->set_rules('about_solution',          'about_solution',        	'required|strip_tags|trim');
			$this->form_validation->set_rules('about_customer',          'about_customer',        	'required|strip_tags|trim');
			$this->form_validation->set_rules('about_money',          	 'about_money',        	    'required|strip_tags|trim');
			$this->form_validation->set_rules('about_add_info',          'about_add_info',        	'strip_tags|trim');
			$this->form_validation->set_rules('about_institution',       'about_institution',       'required|strip_tags|trim|in_list[CAERC,UNEC,BEU,ASAU]');
			$this->form_validation->set_rules('name_surname',            'name_surname',            'required|strip_tags|trim');
			$this->form_validation->set_rules('applying_as',             'applying_as',        	    'required|strip_tags|trim|in_list[individual,team_leader]');
			$this->form_validation->set_rules('gender',             	 'gender',        	    	'required|strip_tags|trim|in_list[male,female]');
			$this->form_validation->set_rules('age',             	 	 'age',        	    		'required|strip_tags|trim|greater_than_equal_to[18]|less_than_equal_to[35]');
			$this->form_validation->set_rules('e_mail',                  'e_mail',                  'required|strip_tags|trim|valid_email');
			$this->form_validation->set_rules('phone',                   'phone',                	'required|strip_tags|trim|numeric');

			if ($this->form_validation->run() == FALSE) {

				$errors = validation_errors();
				$this->session->set_flashdata('error_message', translate('invalid_form_data'));
		  
				$page_data['error_message'] =  $errors;
				$page_data['title'] = "Creative Spark Pitch Competition yarışması";
			  
				$page_data['page_name'] = 'creativespark';
				$this->load->view('index', $page_data);
			
			}else{
              
                $recaptchaResponse = trim($this->input->post('g-recaptcha-response'));
                $userIp            = $this->input->ip_address();
                $secret            = $this->config->item('google_secret');
                $url               = "https://www.google.com/recaptcha/api/siteverify?secret=" . $secret . "&response=" . $recaptchaResponse . "&remoteip=" . $userIp;
                $ch                = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                $output = curl_exec($ch);
                curl_close($ch);
                $status   = json_decode($output, true);
                if ($status['success']) {

				$data_M = array(
				
					'name_your_idea'        	=> html_escape($this->input->post('project_name')),
					'category'       			=> html_escape($this->input->post('project_category')),
					'problem'          			=> html_escape($this->input->post('about_problem')),
					'solution'        			=> html_escape($this->input->post('about_solution')),
					'customers'         		=> html_escape($this->input->post('about_customer')),
					'money'        	 			=> html_escape($this->input->post('about_money')),
					'additional_information'    => html_escape($this->input->post('about_add_info')),
					'institution'      			=> html_escape($this->input->post('about_institution')),
					'name'           			=> html_escape($this->input->post('name_surname')),
					'etype'      		 		=> html_escape($this->input->post('applying_as')),
					'gender'      		 	 	=> html_escape($this->input->post('gender')),
					'age'      		 		 	=> html_escape($this->input->post('age')),
					'email'                 	=> html_escape($this->input->post('e_mail')),
					'phone'                  	=> html_escape($this->input->post('phone')),
					'create_time'               => date('Y-m-d H:s'),
				);
					
				$this->db->insert('spark3',$data_M);  
			
				// send mail to info@enterpriseazerbaijan.com
				$message = '
				    <h3>New idea</h3>
					<b>Project name:</b> '.$data_M['name_your_idea'].'<br />
					<b>Name / Surname:</b> '.$data_M['name'].'<br />
					<b>E-mail:</b> '.$data_M['email'].'<br />
					<b>Telephone:</b> '.$data_M['phone'].'<br> <br> 
					More: <a href="http://enterpriseazerbaijan.gov.az/creativespark/login" traget="_blank" >http://enterpriseazerbaijan.gov.az/creativespark/login</a>';
					
				//$to = 'info@enterpriseazerbaijan.com';
				$to = 'elnur370@gmail.com';
				$subject = 'Creative Spark Pitch Competition - '.$data_M['email'];
				$mail = $this->email_model->sendMail($to, $subject, $message);
				if($mail){
					$this->session->set_flashdata('succes_message', "Thank you");
					redirect('creativespark');
				}else{
					$this->session->set_flashdata('error_message',translate('error'));
					redirect($_SERVER['HTTP_REFERER']);
				} 

			    } else {

                     $this->session->set_flashdata('error_message', 'Robot olmadığınızı təsdiq edin | Confirm that you are not a robot');
				     $page_data['title'] = "Creative Spark Pitch Competition yarışması";
				     $page_data['page_name'] = 'creativespark';
				     $this->load->view('index', $page_data);

                }
				
			}

		}
		
		public function login($p=''){
			
			if ($p=='do') {
				
				if ($this->input->post('password') && $this->input->post('password')==='CeSkPhCn_!@#2022') {
					$this->session->set_userdata('view_spark_list','yes');
					redirect('creativespark/login/list');
				}else{
					$page_data['title'] = "Creative Spark Pitch Competition yarışması - Daxil ol";
					$this->session->set_flashdata('error_message', "Şifrə düzgün deyil");
					$page_data['page_name'] = 'spark_login';
					$this->load->view('index', $page_data); 
				}
			}
			
			if($p==='list'  && $this->session->userdata('view_spark_list')==='yes'){
					$page_data['users'] = $this->db->order_by('id','desc')->get('spark3')->result_array();
					$page_data['title'] = "Creative Spark Pitch Competition yarışması - List";
					$page_data['page_name'] = 'spark_list';
					$this->load->view('index', $page_data); 
			}else{
				$this->session->unset_userdata('view_spark_list');
				$page_data['title'] = "Creative Spark Pitch Competition yarışması -Daxil ol";
				$page_data['page_name'] = 'spark_login';
				$this->load->view('index', $page_data);
			}

		}

	}

?>