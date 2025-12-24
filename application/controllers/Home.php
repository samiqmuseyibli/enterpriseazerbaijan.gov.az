<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {

        parent::__construct();
        header('X-Frame-Options: SAMEORIGIN');
        date_default_timezone_set('Asia/Baku');

        //$this->load->model('user_model');
        $this->load->model('home_model');
        $this->load->model('project_model');
        $this->load->model('email_model');
         $this->load->library('pagination');

        if (!$this->session->userdata('language')) {
            $lang = $this->db->get_where('general_settings', array('type' => 'site_language'))->row()->value;
            $this->session->set_userdata('language', $lang);
        }
    }

    public function index()
    {

        //$this->home_model->add_daily_reytinq();
        $page_data['sliders'] = $this->home_model->get_sliders();
        $page_data['regions'] = $this->project_model->get_regions();
        $page_data['sectors'] = $this->project_model->get_sectors();
        $page_data['categories'] = $this->project_model->get_categories();
        $page_data['news'] = $this->home_model->get_slider_news(8);
        $page_data['videos'] = $this->db->order_by('v_createdAt','desc')->limit(12)->where('v_status','1')->get('video')->result_array();
        $page_data['title'] = translate('home_title');
        $page_data['page_name'] = 'home_content';
        $this->load->view('index', $page_data);
    }

    public function doingbusiness()
    {
        $l = curLang();

        // $id_string = $this->uri->segment(4, 0);
        // $filteredNumbers = array_filter(preg_split("/\D+/", $id_string));
        // $id = reset($filteredNumbers);

        $id = html_escape((int) $this->uri->segment(4, 0));
        
        $page_data['items'] = $this->home_model->get_sliders();
        $page_data['detail'] = $this->home_model->get_slider($id);
        $page_data['title'] = $page_data['detail']['title_' . $l . ''] . '-' . translate('Why_Azerbaijan');
        if ($page_data['detail']) {
            $page_data['page_name'] = 'home_doingbusiness';
            $this->load->view('index', $page_data);
        } else {
            redirect('home');
        }
    }

    public function subscribe()
    {
         $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
         $parsed_url = parse_url($referrer);
         $allowed_host = 'enterpriseazerbaijan.gov.az'; 

         $l = curLang();

         $this->form_validation->set_rules('subscribeemail', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_message', translate('invalid_form_data'));
             redirect($l.'/contact#subscribe');
        } else {
            $mail = html_escape($this->input->post('subscribeemail'));
            $this->db->select('*');
            $this->db->from('subcribers');
            $this->db->where('email', $mail);
            $query = $this->db->get();
            if ($query->num_rows() >= 1) {
                $this->session->set_flashdata('error_message', translate('this_email_is_subscribed'));
                 redirect($l.'/contact#subscribe');
            } else {
                $email['email'] = $this->input->post('subscribeemail');
                $email['date'] = date('Y-m-d');
                $this->db->insert('subcribers', $email);
                $this->session->set_flashdata('succes_message', translate('subscribed'));
                 redirect($l.'/contact#subscribe');
            }
        }
    }

    public function message(){

         $referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
         $parsed_url = parse_url($referrer);
         $allowed_host = 'enterpriseazerbaijan.gov.az'; 

        $this->form_validation->set_rules('name', 			translate('your_name'), 'trim|required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('contactemail', 	translate('e-mail'), 	'trim|required|valid_email');
        $this->form_validation->set_rules('subject', 		translate('subject'), 	'trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('message',		translate('message'), 	'trim|required|min_length[3]|max_length[1500]');


        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_message', translate('invalid_form_data'));
            $this->session->set_flashdata('error_messages', validation_errors());
            if (isset($parsed_url['host']) && $parsed_url['host'] === $allowed_host) {
                                redirect($referrer);
                            } else {
                                redirect(base_url());
                            }

        } else {
			
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
            if (!$status['success']) {
				
                $this->session->set_flashdata('error_message', translate('invalid_gg_captcha_data'));
                 if (isset($parsed_url['host']) && $parsed_url['host'] === $allowed_host) {
                                redirect($referrer);
                            } else {
                                redirect(base_url());
                            }
				
            }else{
				
				$data['mail'] = 	html_escape($this->input->post('contactemail'));
				$data['name'] = 	html_escape($this->input->post('name'));
				$data['subject'] =  html_escape($this->input->post('subject'));
				$data['message'] =  html_escape($this->input->post('message'));

				$data['date'] = date('Y-m-d H:s');
				$this->db->insert('messages', $data);


				//send mail to info@enterpriseazerbaijan.com
				$mess = '<b>' . translate('your_name') . ' - </b>' . $data['name'] . '<br /><b>' . translate('e-mail') . ' - </b>' . $data['mail'] . '<br /><b>' . translate('subject') . ' -</b> ' . $data['subject'] . "<br /><b>" . translate('message') . ' -</b> ' . $data['message'];
				
				$to  = 'info@enterpriseazerbaijan.gov.az';
				//$to. = 'elgunkh@gmail.com';
				$sub = 'Əlaqə bölməsindən daxil olmuş müraciət - ' . $data['mail'];
				
				$mail = $this->email_model->sendMail($to, $sub, $mess);
				if ($mail) {
					$this->session->set_flashdata('succes_message', translate('message_is_sent'));
					 if (isset($parsed_url['host']) && $parsed_url['host'] === $allowed_host) {
                                redirect($referrer);
                            } else {
                                redirect(base_url());
                            }
				}else{
					$this->session->set_flashdata('error_message', translate('error'));
					 if (isset($parsed_url['host']) && $parsed_url['host'] === $allowed_host) {
                                redirect($referrer);
                            } else {
                                redirect(base_url());
                            }
				}
			}
        }

    }

    public function termsofuse()
    {

        $page_data['detail'] = $this->home_model->get_termsofuse();
        $page_data['title'] = translate('terms_of_use');
        $page_data['page_name'] = 'terms';
        $this->load->view('index', $page_data);

    }

     public function documents()
    {

        $page_data['rows'] = $this->db->where('doc_status','1')->get('documents')->result_array();
        $page_data['title'] = translate('doc_page_title');
        $page_data['page_name'] = 'documents_all';
        $this->load->view('index', $page_data);

    }

     public function doc_detail($id = '')
    {
        
        $id = html_escape($id);
        $l=curLang();
        $page_data['row'] = $this->db->where('doc_status','1')->where('doc_id',$id)->get('documents')->row_array();
        
        if (!empty($page_data['row'])) {
           $page_data['title'] = $page_data['row']['doc_title_'.$l].' | '.translate('doc_page_title');
           $page_data['page_name'] = 'documents_detail';
           $this->load->view('index', $page_data);
        } else {
           redirect('home');
        }
        
        

    }

    // xidmətlərimiz bölməsi
    public function services()
    {

        $page_data['detail'] = $this->home_model->get_services();
        $page_data['title'] = translate('our_services');
        $page_data['page_name'] = 'services';
        $this->load->view('index', $page_data);

    }

    public function privacypolicy()
    {

        $page_data['detail'] = $this->home_model->get_privacy();

        if ($page_data['detail']) {
            $page_data['title'] = translate('privacy_policy');
            $page_data['page_name'] = 'privacy';
            $this->load->view('index', $page_data);
        } else {
            redirect('home');
        }

    }

    function set_language($lang)
    {
        $this->session->set_userdata('language', $lang);
        $page_data['page_name'] = "index";
        recache();
        redirect(base_url() . 'user/', 'refresh');
    }

     // videolar bölməsi
    // public function videos()
    // {

    //     $page_data['rows'] = $this->db->order_by('v_createdAt','desc')->where('v_status','1')->get('video')->result_array();
    //     $page_data['title'] = translate('videos');
    //     $page_data['page_name'] = 'videos';
    //     $this->load->view('index', $page_data);

    // }
     public function videos()
    {
        $lang = curLang();

        $search   = html_escape($this->input->get('search'));
        $category = html_escape($this->input->get('category'));

        $query_str = ''; 
        if (!empty($search)) {
            $query_str .= '&search=' . urlencode($search);
        }
        if (!empty($category)) {
            $query_str .= '&category=' . urlencode($category);
        }

        $config["base_url"] = base_url($lang) . "/video?" . ltrim($query_str,'&');
        $config["per_page"] = 9;
        $config["page_query_string"] = TRUE;
        $config["query_string_segment"] = "page";


       


        $this->db->from('video');
        $this->db->join('video_category', 'video_category.vc_id = video.v_category', 'left');
        $this->db->where('video.v_status', '1');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like("video.v_title_" . $lang, $search);
            $this->db->group_end();
        }

        if (!empty($category)) {
            $this->db->where('video.v_category', $category);
        }

        $config["total_rows"] = $this->db->count_all_results();


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


        $page = html_escape($this->input->get('page')) ?? 0;

        $this->db->select('video.*, video_category.*');
        $this->db->from('video');
        $this->db->join('video_category', 'video_category.vc_id = video.v_category', 'left');
        $this->db->where('video.v_status', '1');

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like("video.v_title_" . $lang, $search);
            $this->db->group_end();
        }

        if (!empty($category)) {
            $this->db->where('video.v_category', $category);
        }

        $this->db->order_by('video.v_createdAt', 'desc');
        $this->db->limit($config["per_page"], $page);
        $query = $this->db->get();
        $page_data['rows'] = $query->result_array();

        $page_data['categories'] = $this->db->where('vc_status','1')->get('video_category')->result_array();

        $page_data['rows'] = $this->db->order_by('v_createdAt','desc')->where('v_status','1')->get('video')->result_array();
        $page_data['title'] = translate('videos');
        $page_data['page_name'] = 'videos';
        $page_data["links"] = $this->pagination->create_links();

        $this->load->view('index', $page_data);
    }

    public function videoDetail($id = '')
    {
        
        $id = (int) html_escape($id);
        $l = curLang();
        $page_data['row'] = $this->db->order_by('v_createdAt','asc')->where('v_status','1')->where('v_id',$id)->get('video')->row_array();
        
        if (!empty($page_data['row'])) {
           $page_data['l'] =  $l; 
           $page_data['rows'] = $this->db->limit('8')->order_by('v_createdAt','asc')->where('v_status','1')->where('v_id !=',$id)->get('video')->result_array();
           $page_data['title'] = $page_data['row']['v_title_'.$l].' | '.translate('videos').' | EnterpriseAzerbaijan';
           $page_data['page_name'] = 'video_detail';
           $this->load->view('index', $page_data);
        } else {
           redirect($l);
        }
        
        

    }

}

?>