<?php

	defined('BASEPATH') OR exit('No direct script access allowed');

	class User extends CI_Controller{

		public function __construct(){

			parent::__construct();
			date_default_timezone_set('Asia/Baku');

			$this->load->model('user_model');
			$this->load->model('project_model');
			$this->load->model('email_model');
			$this->load->helper(array('captcha'));

			if(!$this->session->userdata('language')) {
				$lang = $this->db->get_where('general_settings', array('type' => 'site_language'))->row()->value;
				$this->session->set_userdata('language', $lang);
			}
			$this->session->unset_userdata('lng');
			$this->session->unset_userdata('lat');
		}

    /*............................set_language..............................*/
    function changelanguage()
    {

        $lang = $this->input->get('lang');
        if ($lang) {
            if ($lang !== 'Azerbaijan' && $lang !== 'English' && $lang !== 'Russian') {
                if (isset($_SERVER['HTTP_REFERER'])) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect('home');
                }

            } else {

                $this->session->set_userdata('language', $lang);
                if (isset($_SERVER['HTTP_REFERER'])) {
                    redirect($_SERVER['HTTP_REFERER']);
                } else {
                    redirect('home');
                }

            }

        } else {
            redirect('home');
        }
    }

    public function safety()
    {
        $enter = $this->session->userdata('user_id');
        if (!$enter) {
            redirect('user');
        }
    }

    public function index()
    {
        $enter = $this->session->userdata('user_id');
        if ($enter) {
            redirect('user/profile');
        } else {
            redirect('user/login');
        }
    }

    /*............................register_view..............................*/
    public function register()
    {
        $page_data['title'] = translate('register_title');
        $page_data['captcha'] = $this->user_model->captcha();
        $page_data['page_name'] = "register";
        $this->load->view("index", $page_data);
    }
     /*...................show_sectors_in_registration........................*/
    public function showSectors(){ 
        echo $this->user_model->showSectorsM();
    }
    /*............................register_back..............................*/
    public function register_user()
    {
        $this->form_validation->set_rules('user_type', 'User Type', 'required');
        $this->form_validation->set_rules('mobil_number', 'Mobil Number', 'trim|required');
        $this->form_validation->set_rules('name', 'First Name', 'trim|required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('surname', 'Last Name', 'trim|required|min_length[2]|max_length[32]');
        $this->form_validation->set_rules('mail', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('pass', 'Password', 'trim|required');
        $this->form_validation->set_rules('pass2', 'Password2', 'trim|required|matches[pass]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error_message', translate('invalid_form_data'));
            redirect('user/register');
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
                
           $this->session->set_flashdata('error_message', translate('invalid_captcha_data_google'));
           redirect($_SERVER['HTTP_REFERER']);

           }else{

            $user = array(
                'user_type' => html_escape($this->input->post('user_type')),
                'sector_id' => html_escape($this->input->post('sector')),
                'company_name' => html_escape($this->input->post('company_name')),
                'user_name' => html_escape($this->input->post('name')),
                'user_surname' => html_escape($this->input->post('surname')),
                'user_mail' => html_escape($this->input->post('mail')),
                'work_number' => html_escape($this->input->post('work_number')),
                'mobil_number' => html_escape($this->input->post('mobil_number')),
                'reg_time' => date('Y-m-d H:i:s'),
                'accept_hash' => md5(uniqid(rand(), TRUE)),
                'user_pass' => md5($this->input->post('pass'))
            );

            $pass1 = $this->input->post('pass');
            $pass2 = $this->input->post('pass2');
            

         

            if ($pass1 != $pass2) {
                $this->session->set_flashdata('error_message', translate('invalid_password_data'));
                redirect('user/register');
            }

            $email_check = $this->user_model->email_check($user['user_mail']);
            if ($email_check) {
                $this->session->set_flashdata('error_message', translate('invalid_email_data'));
                redirect('user/register');
            } else {
                $this->user_model->register_user($user);
                $message = "Aktivasiya Linki: <a href=" . base_url() . "user/activateaccount?hash=" . $user['accept_hash'] . ">" . base_url() . "user/activateaccount?hash=" . $user['accept_hash'] . "</a>";
                $to = $user['user_mail'];
                $subject = "Hesabın Aktiv Edilməsi";
                $mail = $this->email_model->sendMail($to, $subject, $message);
                if ($mail) {
                    $this->session->set_flashdata('succes_message', translate('succes_registration'));
                    redirect('user/login');
                } else {
                    $this->session->set_flashdata('error_message', translate('error'));
                    redirect('user/register');
                }
            }

        }
      }

    }

    /*............................login_view..............................*/
    public function login()
    {

        if ($this->input->get('return')) {
            $redirect_url = html_escape($this->input->get('return'));
        } else {
            $redirect_url = '';
        }

        $page_data['title'] = translate('login_title');
        $this->session->unset_userdata('is_moderator');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_role');
        $page_data['page_name'] = "login";
        $page_data['redirect_url'] = $redirect_url;
		$page_data['captcha'] = $this->user_model->captcha();
        $this->load->view("index", $page_data);
    }
	
    public function getCaptcha()
    {
        $this->captcha_model->createCaptcha();
    }
    /*............................login_back..............................*/
    public function login_user()
    {
        //#########
		$this->form_validation->set_rules('user_email',		'Email',     'trim|required|valid_email');
        $this->form_validation->set_rules('user_password',  'Password',  'trim|required');

		//Layihə əlavə et düyməsindən gələn sorğunun emal edilməsi
		if ($this->input->post('redirect_url')) {
			$this->form_validation->set_rules('redirect_url', 'redirectUrl', 'exact_length[15]|in_list[user/categories]');
		}
		//#########
		
        if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error_message', translate('invalid_form_data'));
            redirect('user/login');
        } else {
			
			$redirect_url 	= $this->input->post('redirect_url');
			
			
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
				
				$this->session->set_flashdata('error_message', translate('invalid_captcha_data_google'));
                redirect($_SERVER['HTTP_REFERER']);

                }else{
				
				$user_login = array(
					'user_email' => html_escape($this->input->post('user_email')),
					'user_password' => md5(html_escape($this->input->post('user_password')))
				);
				
				$data = $this->user_model->login_user($user_login['user_email'], $user_login['user_password']);
				
				if ($data) {
					
					if ($data['user_status'] == 0) {
						$this->session->set_flashdata('error_message', translate('user_is_not_activated'));
						redirect('user/login');
					}
					if ($data['user_status'] == 2) {
						$this->session->set_flashdata('error_message', translate('user_is_deactivated_by_admin'));
						redirect('user/login');
					}
					if ($data['user_role'] === 'moderator') {
						$this->session->set_userdata('user_role', $data['user_role']);
						$this->session->set_userdata('is_moderator', $data['id']);
						redirect('moderator/on_waiting_projects');
					}
					if ($data['user_role'] === 'user') {
						$this->session->set_userdata('user_role', $data['user_role']);
						$this->session->set_userdata('user_id', $data['id']);
						if ($redirect_url) {
							redirect($redirect_url);
						} else {
							redirect('user/profile');
						}
					}

				} else {
					$this->session->set_flashdata('error_message', translate('incorrect_email_or_password'));
					redirect($_SERVER['HTTP_REFERER']);
				}
			}
            

        }

    }

    /*............................pass_reset_view..............................*/
    public function password_reset()
    {
        $page_data['title'] = translate('resetpass_title');
        $page_data['page_name'] = "resetpass";
		$page_data['captcha'] = $this->user_model->captcha();
        $this->load->view("index", $page_data);

    }

    /*............................pass_reset_send_mail..............................*/
    public function reset_password()
    {
		
		//#########
		$this->form_validation->set_rules('user_mail',		'Email',     'trim|required|valid_email');
        $this->form_validation->set_rules('captchaCode',  		'Captcha',  'trim|required');
       
		//########	
		
        if($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error_message', translate('invalid_form_data'));
            redirect($_SERVER['HTTP_REFERER']);
        
		} else {			
				
			if (!$this->captcha_model->check(html_escape($this->input->post('captchaCode')))) {
				
				$this->session->set_flashdata('error_message', translate('invalid_captcha_data'));
                redirect($_SERVER['HTTP_REFERER']);

            }else{
				
				$email = html_escape($this->input->post('user_mail'));
				$email_check = $this->user_model->email_check($email);
				
				if ($email_check) {
					$password_hash = md5(uniqid(rand(), TRUE));
					$this->user_model->set_resethash_user($password_hash, $email);
					$message = "Bərpa Linki: <a href= " . base_url() . "user/passwordreset?resetkey=" . $password_hash . ">" . base_url() . "user/passwordreset?resetkey=" . $password_hash . "</a>";
					$to = $email_check['user_mail'];
					$subject = "Şifrənin Bərpası";
					$mail = $this->email_model->sendMail($to, $subject, $message);
					if ($mail) {
						$this->session->set_flashdata('succes_message', translate('recovery_link_sent_to_mail'));
						redirect('user/login');
					} else {
						$this->session->set_flashdata('error_message', translate('error'));
						redirect('user/password_reset');
					}
				} else {
					$this->session->set_flashdata('error_message', translate('this_email_is_not_exsists'));
					redirect('user/register');
				}
				
			}
			
		}        
		
    }

    /*............................pass_get_reset_key..............................*/
    public function passwordreset()
    {
        $page_data['title'] = translate('newpass_title');
        $resetkey = html_escape($this->input->get('resetkey'));
        $user = $this->user_model->check_reset_hash($resetkey);
        if ($user){
            $page_data['mail'] = $user['user_mail'];
            $page_data['resethash'] = $user['reset_hash'];
            $page_data['page_name'] = "newpassword";
            $this->load->view('index', $page_data);
        } else {
            $this->session->set_flashdata('error_message', translate('invalid_link_is_not_work'));
            redirect('user/login');
        }
    }

    /*.....................set_new_pass_back........................*/
    public function updatepassword()
    {
		//#########
		$this->form_validation->set_rules('mail',		'Email',     'trim|required|valid_email');
		$this->form_validation->set_rules('resetkey',	'ResetKey',  'trim|required');
		$this->form_validation->set_rules('pass1',		'Pass1',     'trim|required');
		$this->form_validation->set_rules('pass2',		'Pass2',     'trim|required|matches[pass1]');
        $this->form_validation->set_rules('captchaCode',  	'Captcha',  'trim|required');
		//########	
		
		if ($this->form_validation->run() == FALSE) {
            $errors = validation_errors();
            $this->session->set_flashdata('error_message', translate('invalid_form_data'));
            redirect($_SERVER['HTTP_REFERER']);
        
		} else {
			
			
			$user_pass 		= md5(html_escape($this->input->post('pass1')));
			$user_pass2 	= md5(html_escape($this->input->post('pass2')));
			$user_mail		= html_escape($this->input->post('mail'));
			$reset_key 		= html_escape($this->input->post('resetkey'));
		if (!$this->captcha_model->check(html_escape($this->input->post('captchaCode')))) {	
				$this->session->set_flashdata('error_message', translate('invalid_captcha_data'));
                redirect($_SERVER['HTTP_REFERER']);
            }elseif($user_pass != $user_pass2) {
				
				$this->session->set_flashdata('error_message', translate('passwords_not_compare'));
                redirect($_SERVER['HTTP_REFERER']);
				
			}else{
				
				$new_hash = md5(uniqid(rand(), TRUE));
				$user = $this->user_model->check_reset_hash_for_user($reset_key, $user_mail);
				if ($user) {
					$this->user_model->update_user_pass($new_hash, $user_pass, $user_mail);
					$this->session->set_flashdata('succes_message', translate('password_is_updated'));
					redirect('user/login');
				} else {
					$this->session->set_flashdata('error_message', translate('password_is_not_updated'));
					redirect('user/login');
				}
				
			}
			
		}
		
    }

    /*.....................update_profile_view........................*/
    public function update_profile()
    {
        $this->safety();
        $data['title'] = translate('update_profile');
        $data['page_name'] = 'update_profile';
        $data['page_title'] = translate('update_your_profile');
        $id = $this->session->userdata('user_id');
        $data['user_info'] = $this->db->get_where('users', array('id' => $id))->result_array();
        $this->load->view("profile/profile", $data);
    }

    /*.....................update_profile_back........................*/
    public function user_update_profile()
    {
        $this->safety();
        $user['company_name'] = html_escape($this->input->post('company'));
        $user['user_name'] = html_escape($this->input->post('name'));
        $user['user_surname'] = html_escape($this->input->post('surname'));
        $user['work_number'] = html_escape($this->input->post('home_num'));
        $user['mobil_number'] = html_escape($this->input->post('phone_num'));
        $user['update_time'] = time();
        $id = $this->session->userdata('user_id'); 
        $this->db->where('id', $id);
        $this->db->update('users', $user);
        $this->session->set_flashdata('succes_message', translate('profile_is_updated'));
        redirect('user/profile');
    }


    /*.....................update_pass_view........................*/
    public function password_update()
    {
        $this->safety();
        $page_data['title'] = translate('updatepass_title');
        $page_data['page_name'] = 'profile_update_password';
        $this->load->view("profile/profile", $page_data);
    }

    /*.....................update_pass_back........................*/
    public function user_update_password()
    {
        $this->safety();
        $data = $this->user_model->get_my_details();
        $new_hash = md5(uniqid(rand(), TRUE));
        $old_pass = md5(html_escape($this->input->post('oldpass')));
        $newpass1 = md5(html_escape($this->input->post('newpass1')));
        $newpass2 = md5(html_escape($this->input->post('newpass2')));
        $user_mail = $data['user_mail'];
        if ($newpass1 === $newpass2) {
            if ($data['user_pass'] === $old_pass) {
                $this->user_model->update_user_pass($new_hash, $newpass1, $user_mail);
                $this->session->set_flashdata('succes_message', translate('password_is_updated'));
                redirect('user/login');
            } else {
                $this->session->set_flashdata('error_message', translate('incorrect_password'));
                redirect('user/password_update');
            }
        } else {
            $this->session->set_flashdata('error_message', translate('invalid_password_data'));
            redirect('user/password_update');


        }


    }

    /*.....................activate user accout after registeration........................*/
    public function activateaccount()
    {
        $hash = html_escape($this->input->get('hash'));
        $data = $this->user_model->get_user_hash($hash);
        if ($data) {
            if ($data['user_status'] != 0) {
                $this->session->set_flashdata('error_message', translate('this_link_is_not_work'));
                redirect('user/login');
            } else {
                $this->user_model->activate_user($hash);
                $this->session->set_flashdata('succes_message', translate('accout_is_activated'));
                redirect('user/login');
            }
        } else {
            $this->session->set_flashdata('error_message', translate('this_link_is_not_exsists'));
            redirect('user/login');
        }
    }

    /*.....................user profil view........................*/
    public function profile()
    {
        $this->safety();
        $page_data['title'] = translate('profile');
        $user_id = $this->session->userdata('user_id');
        $page_data['user_details'] = $this->db->get_where('users', array('id' => html_escape($user_id)))->result_array();
        $page_data['page_name'] = 'profile_content';
        $this->load->view("profile/profile", $page_data);
    }

    /*.....................logout........................*/
    public function logout()
    {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('user_role');
        redirect('user/login');
    }

    /*.................User Project Functions.................*/
    public function projects()
    {
        $this->safety();
        $page_data['title'] = translate('projects');
        $page_data['categories'] = $this->project_model->get_categories();
        $page_data['user_projects'] = $this->project_model->get_user_projects();
        $page_data['page_name'] = 'profile_projects';
        $this->load->view("profile/profile", $page_data);
    }


                         
                        
    /*...................delete_user_project........................*/
    public function deleteproject($project_id = '')
    {    
        $project_id=html_escape($project_id);
        $this->safety();
        $user_id = $this->session->userdata('user_id');
        $data = $this->project_model->project_check($project_id);
        if ($data && $data['user_id'] == $user_id) {
            $this->project_model->delete_user_project($project_id);
            $this->session->set_flashdata('succes_message', translate('deleted'));
            redirect('user/projects');
        } else {

        echo "you can not delete this! this is not your project... <br>"."<a href=".base_url()."> Home</a>";
        }

    }

    /*...................project_categories........................*/
    public function categories()
    {
        $this->safety();
        $page_data['title'] = translate('categories');
        $page_data['page_name'] = 'profile_project_categories';
        $this->load->view("profile/profile", $page_data);
    }
   
    // public function CheckValidationAfterUpload($project_id='')
    // {
    //             $this->safety();
    //             $this->project_model->upload_files('images', 'projectimages', $project_id);
    //             foreach($_FILES["images"]["tmp_name"] as $key=>$tmp_name){
    //                $temp = $_FILES["images"]["tmp_name"][$key];

    //             if(empty($temp)){
    //             $filesdata = array(
    //             'files_type_id' => $project_id,
    //             'files_url' => 'files/projectimages/noimage.jpg',
    //             'files_type' => 'projectimages'         
    //             );          
    //             $this->db->insert('files', $filesdata);
           
    //             }
    //         }
        
    // }
    /*..................idea_project...................*/
   
    public function addidea($parametr='')
    {
        $this->safety();
        if ($parametr=='doadd') {
        $l=curLang();
        
        //#########
        $this->form_validation->set_rules('projectName',        'Project name',         'required|strip_tags|trim');
        $this->form_validation->set_rules('project_info',       translate('qisa_melumat'), 'required|strip_tags|trim|min_length[300]');
        $this->form_validation->set_rules('investment_volume',  'Investment volume',    'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('company',            'Company',              'required|strip_tags|trim');
        $this->form_validation->set_rules('number',             translate('telefon_nomresi'),     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
        $this->form_validation->set_rules('email',              'Author e-mail',        'strip_tags|trim|valid_email');
        $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
        $this->form_validation->set_rules('cf_status',          'Cf status',            'strip_tags|trim');
        //#########

        if ($this->form_validation->run() == FALSE) {
            
            $errors = validation_errors();
            $this->session->set_flashdata('error_message', $errors);
            
            $page_data['error_message'] =  $errors;
            $page_data['title'] = translate('profile');
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['page_name'] = 'profile_add_idea';
            $this->load->view("profile/profile", $page_data);
        
        } else {
            
            // form parameters
            $project_name       = html_escape($this->input->post('projectName'));   
            $project_info       = html_escape($this->input->post('project_info'));  
            $investment_volume  = html_escape($this->input->post('investment_volume')); 
            $region             = html_escape($this->input->post('region'));
            $company            = html_escape($this->input->post('company')); 
            $number             = html_escape($this->input->post('number')); 
            $youtube_video_link = html_escape(generateVideoEmbedUrl($this->input->post('youtube_video_link'))); 
            $author_email       = html_escape($this->input->post('email')); 
            //$cf_status          = html_escape($this->input->post('cf_status'));
            $cf_status          = 0;  
           // $accept             = html_escape($this->input->post('accept'));    
           
            //image upload if exsist
            if (isset($_FILES['images']['name'])) {
                $say = count($_FILES['images']['name']);
                if($say>=6){
                    echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
                    redirect('user/addidea');exit();
                }
            }
            $project = array(
                'cf_status' => $cf_status,
                'user_id'   => $this->session->userdata('user_id'),
                'kat_id'    => 5,
                'region_id' => $region,
                'top'       => seflink($project_name),
                'invesment_volume' => $investment_volume,
                'url_image' => 'n',
                'project_author' => $company,
                'youtube_video_link' => $youtube_video_link,
                'author_telephone' => $number,
                'author_email' => $author_email,
                'add_date' => date('Y-m-d H:i:s'),
            );
             $project_id =$this->project_model->add_project($project);
              if($project_id){
             $this->project_model->upload_files('images', 'projectimages', $project_id);
             $translate = array(
                'project_id' => $project_id,
                'lang_code' => $l,
                'project_title' => $project_name,
                'project_description' => $project_info,
              );
            $this->project_model->add_translate($translate);
            $this->session->set_flashdata('succes_message', translate('project_is_uploaded'));            
            redirect('user/projects');  
              } else{
                echo $this->session->set_flashdata('error_message', translate('error'));
                    redirect('user/addidea');exit();
              }
        } 
        }else{
        $page_data['title'] = translate('profile');
        $page_data['regions'] = $this->project_model->get_regions();
        $page_data['page_name'] = 'profile_add_idea';
        $this->load->view("profile/profile", $page_data); 
        }
        
    }

    

    /*..................land_sale_project...................*/

    // public function addlandsale($parametr='')
    // {
    //     $this->safety();
    //     if ($parametr=='doadd') {
    //     $l=curLang();
        
    //     //#########
    //     $this->form_validation->set_rules('projectName',        'Project name',         'required|strip_tags|trim');
    //     $this->form_validation->set_rules('project_info',       'Project info',         'required|strip_tags|trim');
    //     $this->form_validation->set_rules('sector',             'Sector',               'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('property',           'Property',             'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('usage_form',         'Usage form',           'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('appointment',        'Appointment',          'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('ha',                 'ha',                   'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('price',              'Price',                'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('infrastructure',     'Infrastructure',       'strip_tags|trim');
    //     $this->form_validation->set_rules('a_information',      'Project other info',   'strip_tags|trim');
    //     $this->form_validation->set_rules('adress',             'Address',              'required|strip_tags|trim');
    //     $this->form_validation->set_rules('author',             'Author',               'required|strip_tags|trim');
    //     $this->form_validation->set_rules('telephone',          'Author telephone',     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
    //     $this->form_validation->set_rules('email',              'Author e-mail',        'strip_tags|trim|valid_email');
    //     $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
    //     $this->form_validation->set_rules('cf_status',          'Cf status',            'strip_tags|trim');
    //     $this->form_validation->set_rules('lng',                'lng',                  'strip_tags|trim');
    //     $this->form_validation->set_rules('lat',                'lat',                  'strip_tags|trim');
    //     //#########
        
    //     if ($this->form_validation->run() == FALSE) {
            
    //         $errors = validation_errors();
    //         $this->session->set_flashdata('error_message', translate('invalid_form_data'));
            
    //         $page_data['error_message'] =  $errors;
    //         $page_data['title'] = translate('profile');
    //         $page_data['regions'] = $this->project_model->get_regions();
    //         $page_data['sectors'] = $this->project_model->get_sectors();
    //         $page_data['usage_form'] = $this->project_model->get_usage_form();
    //         $page_data['property_type'] = $this->project_model->get_property_type();
    //         $page_data['appointment'] = $this->project_model->get_appointment();
    //         $page_data['page_name'] = 'profile_add_land_sale';
    //         $this->load->view("profile/profile", $page_data);
        
    //     } else {
            
    //         // form parameters
    //         $project_name       = html_escape($this->input->post('projectName'));   
    //         $project_info       = html_escape($this->input->post('project_info'));  
    //         $sector             = html_escape($this->input->post('sector')); 
    //         $property           = html_escape($this->input->post('property')); 
    //         $region             = html_escape($this->input->post('region')); 
    //         $usage_form         = html_escape($this->input->post('usage_form')); 
    //         $appointment        = html_escape($this->input->post('appointment')); 
    //         $ha                 = html_escape($this->input->post('ha')); 
    //         $price              = html_escape($this->input->post('price'));         
    //         $infrastructure     = html_escape($this->input->post('infrastructure'));            
    //         $a_information      = html_escape($this->input->post('a_information')); 
    //         $address            = html_escape($this->input->post('adress'));
    //         $author             = html_escape($this->input->post('author'));            
    //         $author_telephone   = html_escape($this->input->post('telephone'));
    //         $youtube_video_link = html_escape(generateVideoEmbedUrl($this->input->post('youtube_video_link'))); 
    //         $author_email       = html_escape($this->input->post('email')); 
    //         $cf_status          = html_escape($this->input->post('cf_status')); 
    //         //$accept             = html_escape($this->input->post('accept'));    
    //         $lng                = html_escape($this->input->post('lng'));   
    //         $lat                = html_escape($this->input->post('lat'));   
            
    //         //image upload if exsist
    //         if (isset($_FILES['images']['name'])) {
    //             $say = count($_FILES['images']['name']);
    //             if($say>=6){
    //                 echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
    //                 redirect('user/addlandsale');exit();
    //             }
    //         }$project = array(
    //             'cf_status' => $cf_status,
    //             'user_id' => $this->session->userdata('user_id'),
    //             'sector_id' => $sector,
    //             'kat_id' => 2,
    //             'url_image' => 'n',
    //             'property_type_id' => $property,
    //             'region_id' => $region,
    //             'usage_form_id' => $usage_form,
    //             'appointment_id' => $appointment,
    //             'top' => seflink($project_name),
    //             'common_area' => $ha,
    //             'price' => $price,
    //             'youtube_video_link' => $youtube_video_link,
    //             'project_author' => $author,
    //             'author_telephone' => $author_telephone,
    //             'author_email' => $author_email,
    //             'lng' => $lng,
    //             'lat' => $lat,
    //             'add_date' => date('Y-m-d H:i:s'),

    //         );
    //         $project_id = $this->project_model->add_project($project);
    //         if ($project_id) {
    //           $translate = array(
    //             'project_id' => $project_id,
    //             'lang_code' => $l,
    //             'project_title' => $project_name,
    //             'project_description' => $project_info,
    //             'infrastructure' => $infrastructure,
    //             'other_important_data' => $a_information,
    //             'adress' => $address,

    //         ); 
    //         $this->project_model->add_translate($translate);
    //         $this->project_model->upload_files('images', 'projectimages', $project_id);
    //         $this->session->set_flashdata('succes_message', translate('project_is_uploaded'));
    //         redirect('user/projects');
    //         }

            
            
    //     } 
    //     }else{
    //     $page_data['title'] = translate('profile');
    //     $page_data['regions'] = $this->project_model->get_regions();
    //     $page_data['sectors'] = $this->project_model->get_sectors();
    //     $page_data['usage_form'] = $this->project_model->get_usage_form();
    //     $page_data['property_type'] = $this->project_model->get_property_type();
    //     $page_data['appointment'] = $this->project_model->get_appointment();
    //     $page_data['page_name'] = 'profile_add_land_sale';
    //     $this->load->view("profile/profile", $page_data);
    //     }
       
    // }

   
    /*..................startap_project_view...................*/

    public function addstartap($parametr='')
    {
        $this->safety();
        if ($parametr=='doadd') {
        $l=curLang();
        
        //#########
        $this->form_validation->set_rules('projectName',        'Project name',         'required|strip_tags|trim');
        $this->form_validation->set_rules('project_info',       translate('qisa_melumat'),         'required|strip_tags|trim|min_length[300]');
        $this->form_validation->set_rules('sector',             'Sector',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('investment_volume',  'Investment volume',    'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('investor_percent',   'Investor percent',     'strip_tags|trim|integer');
        $this->form_validation->set_rules('a_information',      'Project other info',   'strip_tags|trim');
        $this->form_validation->set_rules('adress',             'Address',              'required|strip_tags|trim');
        $this->form_validation->set_rules('author',             'Author',               'required|strip_tags|trim');
        $this->form_validation->set_rules('telephone',          translate('telefon_nomresi'),     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
        $this->form_validation->set_rules('email',              'Author e-mail',        'strip_tags|trim|valid_email');
        $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
        $this->form_validation->set_rules('cf_status',          'Cf status',            'strip_tags|trim');

        //#########
        
        if ($this->form_validation->run() == FALSE) {
            
            $errors = validation_errors();
            $this->session->set_flashdata('error_message', $errors);
            $page_data['error_message'] =  $errors;
            
            $page_data['title'] = translate('profile');
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['page_name'] = 'profile_add_startap';
            $this->load->view("profile/profile", $page_data);
        
        } else {
            
            // form parameters
            $project_name       = html_escape($this->input->post('projectName'));   
            $project_info       = html_escape($this->input->post('project_info'));  
            $sector             = html_escape($this->input->post('sector')); 
            $region             = html_escape($this->input->post('region')); 
            $investment_volume  = html_escape($this->input->post('investment_volume')); 
            $investor_percent   = html_escape($this->input->post('investor_percent'));
            $a_information      = html_escape($this->input->post('a_information')); 
            $address            = html_escape($this->input->post('adress'));
            $author             = html_escape($this->input->post('author'));   
            $youtube_video_link = html_escape(generateVideoEmbedUrl($this->input->post('youtube_video_link'))); 
            $author_telephone   = html_escape($this->input->post('telephone'));
            $author_email       = html_escape($this->input->post('email')); 
            $cover_image        = html_escape($this->input->post('image'));
             //$cf_status          = html_escape($this->input->post('cf_status'));
            $cf_status          = 0;  
            //$accept             = html_escape($this->input->post('accept'));    
        
            //image upload if exsist
            if (isset($_FILES['images']['name'])) {
                $say = count($_FILES['images']['name']);
                if($say>=6){
                    echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
                    redirect('user/addstartap');exit();
                }
            }
            $project = array(
                'cf_status' => $cf_status,
                'user_id' => $this->session->userdata('user_id'),
                'sector_id' => $sector,
                'kat_id' => 1,
                'url_image' => 'n',
                'region_id' => $region,
                'top' => seflink($project_name),
                'invesment_volume' => $investment_volume,
                'investor_percent' => $investor_percent,
                'project_author' => $author,
                'youtube_video_link' => $youtube_video_link,
                'author_telephone' => $author_telephone,
                'author_email' => $author_email,
                'add_date' => date('Y-m-d H:i:s'),

            );
            $project_id = $this->project_model->add_project($project);
            if ($project_id) {
              $translate = array(
                'project_id' => $project_id,
                'lang_code' => $l,
                'project_title' => $project_name,
                'project_description' => $project_info,
                'other_important_data' => $a_information,
                'adress' => $address,

            );
            $this->project_model->upload_files('images', 'projectimages', $project_id);
            $this->project_model->add_translate($translate);
            $this->session->set_flashdata('succes_message', translate('project_is_uploaded'));
            redirect('user/projects');
            }
            
        }  
        }else{
        $page_data['title'] = translate('profile');
        $page_data['regions'] = $this->project_model->get_regions();
        $page_data['sectors'] = $this->project_model->get_sectors();
        $page_data['page_name'] = 'profile_add_startap';
        $this->load->view("profile/profile", $page_data);  
        }
        
    }

   

    /*..................stocks_project...................*/

    // public function addstocks($parametr='')
    // {
    //     $this->safety();
    //     if ($parametr=='doadd') {
    //     $l=curLang();
        
    //     //#########
    //     $this->form_validation->set_rules('projectName',                    'Project name',                 'required|strip_tags|trim');
    //     $this->form_validation->set_rules('project_info',                   'Project info',                 'required|strip_tags|trim');
    //     $this->form_validation->set_rules('sector',                         'Sector',                       'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('region',                         'Region',                       'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('charter_capital',                'Charter capital volume',       'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('number_of_issued_stocks',        'Number of issued stocks',      'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('nominal_value_of_one_stocks',    'Nominal value of one stocks',  'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('volume_of_traded_stocks',        'Volume of traded stocks',      'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('a_information',                  'Project other info',           'strip_tags|trim');
    //     $this->form_validation->set_rules('adress',                         'Address',                      'required|strip_tags|trim');
    //     $this->form_validation->set_rules('author',                         'Author',                       'required|strip_tags|trim');
    //     $this->form_validation->set_rules('telephone',                      'Author telephone',             'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
    //     $this->form_validation->set_rules('email',                          'Author e-mail',                'strip_tags|trim|valid_email');
    //     $this->form_validation->set_rules('images',                         'Document',                     'strip_tags|trim');
    //     $this->form_validation->set_rules('cf_status',                      'Cf status',                    'strip_tags|trim');
    //     $this->form_validation->set_rules('lng',                            'lng',                          'strip_tags|trim');
    //     $this->form_validation->set_rules('lat',                            'lat',                          'strip_tags|trim'); 
    //     //#########
        
    //     if ($this->form_validation->run() == FALSE) {
            
    //         $errors = validation_errors();
    //         $this->session->set_flashdata('error_message', translate('invalid_form_data'));
    //         $page_data['error_message'] =  $errors;
            
    //         $page_data['title'] = translate('profile');
    //         $page_data['regions'] = $this->project_model->get_regions();
    //         $page_data['sectors'] = $this->project_model->get_sectors();
    //         $page_data['page_name'] = 'profile_add_stock';
    //         $this->load->view("profile/profile", $page_data);
        
    //     } else {
            
    //         // form parameters
    //         $project_name                   = html_escape($this->input->post('projectName'));   
    //         $project_info                   = html_escape($this->input->post('project_info'));  
    //         $sector                         = html_escape($this->input->post('sector')); 
    //         $region                         = html_escape($this->input->post('region')); 
    //         $charter_capital                = html_escape($this->input->post('charter_capital')); 
    //         $number_of_issued_stocks        = html_escape($this->input->post('number_of_issued_stocks'));
    //         $nominal_value_of_one_stocks    = html_escape($this->input->post('nominal_value_of_one_stocks')); 
    //         $volume_of_traded_stocks        = html_escape($this->input->post('volume_of_traded_stocks')); 
    //         $a_information                  = html_escape($this->input->post('a_information')); 
    //         $address                        = html_escape($this->input->post('adress'));
    //         $author                         = html_escape($this->input->post('author'));            
    //         $author_telephone               = html_escape($this->input->post('telephone'));
    //         $youtube_video_link             = html_escape(generateVideoEmbedUrl($this->input->post('youtube_video_link')));   
    //         $author_email                   = html_escape($this->input->post('email')); 
    //         $cover_image                    = html_escape($this->input->post('image'));
    //         $cf_status                      = html_escape($this->input->post('cf_status')); 
    //        // $accept                         = html_escape($this->input->post('accept'));    
    //         $lng                            = html_escape($this->input->post('lng'));   
    //         $lat                            = html_escape($this->input->post('lat'));   
        
    //         //image upload if exsist
    //         if (isset($_FILES['images']['name'])) {
    //             $say = count($_FILES['images']['name']);
    //             if($say>=6){
    //                 echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
    //                 redirect('user/addstocks');exit();
    //             }
    //         }
    //         $project = array(
    //             'cf_status' => $cf_status,
    //             'user_id' => $this->session->userdata('user_id'),
    //             'sector_id' => $sector,
    //             'kat_id' => 6,
    //             'url_image' => 'n',
    //             'top' => seflink($project_name),
    //             'region_id' => $region,
    //             'charter_capital' => $charter_capital,
    //             'number_of_issued_stocks' => $number_of_issued_stocks,
    //             'nominal_value_of_one_stocks' => $nominal_value_of_one_stocks,
    //             'volume_of_traded_stocks' => $volume_of_traded_stocks,
    //             'project_author' => $author,
    //             'youtube_video_link' => $youtube_video_link,
    //             'author_telephone' => $author_telephone,
    //             'author_email' => $author_email,
    //             'lng' => $lng,
    //             'lat' => $lat,
    //             'add_date' => date('Y-m-d H:i:s'),

    //         );
    //         $project_id = $this->project_model->add_project($project);
    //         if ($project_id) {
    //         $translate = array(
    //             'project_id' => $project_id,
    //             'lang_code' => $l,
    //             'project_title' => $project_name,
    //             'project_description' => $project_info,
    //             'other_important_data' => $a_information,
    //             'adress' => $address,
    //         );
    //         $this->project_model->upload_files('images', 'projectimages', $project_id);
    //         $this->project_model->add_translate($translate);
    //         $this->session->set_flashdata('succes_message', translate('project_is_uploaded'));
    //         redirect('user/projects');
    //         }
            
    //     }     
    //     }else{
    //     $page_data['title'] = translate('profile');
    //     $page_data['regions'] = $this->project_model->get_regions();
    //     $page_data['sectors'] = $this->project_model->get_sectors();
    //     $page_data['page_name'] = 'profile_add_stock';
    //     $this->load->view("profile/profile", $page_data);   
    //     }
        
    // }

    
    /*..................business_project...................*/

    // public function addbusiness($parametr='')
    // {
    //     $this->safety();
    //     if ($parametr=='doadd') {
    //     $l=curLang();
        
    //     //#########
    //     $this->form_validation->set_rules('projectName',        'Project name',         'required|strip_tags|trim');
    //     $this->form_validation->set_rules('project_info',       'Project info',         'required|strip_tags|trim');
    //     $this->form_validation->set_rules('sector',             'Sector',               'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('property',           'Property',             'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('price',              'Price',                'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('a_information',      'Project other info',   'strip_tags|trim');
    //     $this->form_validation->set_rules('adress',             'Address',              'required|strip_tags|trim');
    //     $this->form_validation->set_rules('author',             'Author',               'required|strip_tags|trim');
    //     $this->form_validation->set_rules('telephone',          'Author telephone',     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
    //     $this->form_validation->set_rules('email',              'Author e-mail',        'strip_tags|trim|valid_email');
    //     $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
    //     $this->form_validation->set_rules('cf_status',          'Cf status',            'strip_tags|trim');
    //    // $this->form_validation->set_rules('accept',             'Accept',               'required|strip_tags|trim');
    //     $this->form_validation->set_rules('lng',                'lng',                  'strip_tags|trim');
    //     $this->form_validation->set_rules('lat',                'lat',                  'strip_tags|trim');
    //     //#########
        
    //     if ($this->form_validation->run() == FALSE) {
            
    //         $errors = validation_errors();
    //         $this->session->set_flashdata('error_message', translate('invalid_form_data'));
            
    //         $page_data['error_message'] =  $errors;
    //         $page_data['title'] = translate('profile');
    //         $page_data['regions'] = $this->project_model->get_regions();
    //         $page_data['sectors'] = $this->project_model->get_sectors();
    //         $page_data['property_type'] = $this->project_model->get_property_type();
    //         $page_data['page_name'] = 'profile_add_business';
    //         $this->load->view("profile/profile", $page_data);
        
    //     } else {
            
    //         // form parameters
    //         $project_name       = html_escape($this->input->post('projectName'));   
    //         $project_info       = html_escape($this->input->post('project_info'));  
    //         $sector             = html_escape($this->input->post('sector'));        
    //         $region             = html_escape($this->input->post('region')); 
    //         $property           = html_escape($this->input->post('property')); 
    //         $price              = html_escape($this->input->post('price'));         
    //         $a_information      = html_escape($this->input->post('a_information')); 
    //         $address            = html_escape($this->input->post('adress'));
    //         $author             = html_escape($this->input->post('author'));            
    //         $author_telephone   = html_escape($this->input->post('telephone'));
    //         $author_email       = html_escape($this->input->post('email')); 
    //         $cover_image        = html_escape($this->input->post('image')); 
    //         $youtube_video_link = html_escape(generateVideoEmbedUrl($this->input->post('youtube_video_link')));       
    //         $cf_status          = html_escape($this->input->post('cf_status')); 
    //         //$accept             = html_escape($this->input->post('accept'));    
    //         $lng                = html_escape($this->input->post('lng'));   
    //         $lat                = html_escape($this->input->post('lat'));   
            
    //         //image upload if exsist
    //         if (isset($_FILES['images']['name'])) {
    //             $say = count($_FILES['images']['name']);
    //             if($say>=6){
    //                 echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
    //                 redirect('user/addbusiness');exit();
    //             }
    //         }
    //         $project = array(
            
    //             'cf_status' => $cf_status,
    //             'user_id' => $this->session->userdata('user_id'),
    //             'sector_id' => $sector,
    //             'kat_id' => 4,
    //             'url_image' => 'n',
    //             'property_type_id' => $property,
    //             'region_id' => $region,
    //             'price' => $price,
    //             'top' => seflink($project_name),
    //             'project_author' => $author,
    //             'youtube_video_link' => $youtube_video_link,
    //             'author_telephone' => $author_telephone,
    //             'author_email' => $author_email,
    //             'lng' => $lng,
    //             'lat' => $lat,
    //             'add_date' => date('Y-m-d H:i:s'),

    //         );
            
    //         $project_id = $this->project_model->add_project($project);
    //         if ($project_id) {
    //         $translate = array(
    //             'project_id' => $project_id,
    //             'lang_code' => $l,
    //             'project_title' => $project_name,
    //             'project_description' => $project_info,
    //             'other_important_data' => $a_information,
    //             'adress' => $address,
    //         );
    //         $this->project_model->upload_files('images', 'projectimages', $project_id);
    //         $this->project_model->add_translate($translate);
    //         $this->session->set_flashdata('succes_message', translate('project_is_uploaded'));
    //         redirect('user/projects');
    //         }
            
    //     }  
    //     }else{
    //     $page_data['title'] = translate('profile');
    //     $page_data['regions'] = $this->project_model->get_regions();
    //     $page_data['sectors'] = $this->project_model->get_sectors();
    //     $page_data['property_type'] = $this->project_model->get_property_type();
    //     $page_data['page_name'] = 'profile_add_business';
    //     $this->load->view("profile/profile", $page_data);   
    //     }
        
    // }

   

    /*  ---------------Estate_project------------- */
    // public function addestate($parametr='')
    // {
    //     $this->safety();
    //     if ($parametr=='doadd') {
    //     $l=curLang();
        
    //     //#########
    //     $this->form_validation->set_rules('project_name',        'Project name',        'required|strip_tags|trim');
    //     $this->form_validation->set_rules('project_description', 'Project info',        'required|strip_tags|trim');
    //     $this->form_validation->set_rules('sector',              'Sector',              'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('property',            'Property',            'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('region',              'Region',              'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('usage_form',          'Usage form',          'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('price',               'Price',               'strip_tags|trim|integer');
    //     $this->form_validation->set_rules('ha',                  'ha',                  'strip_tags|trim|integer');
    //     $this->form_validation->set_rules('infrastructure',      'Infrastructure',      'strip_tags|trim');
    //     $this->form_validation->set_rules('project_other_info',  'Project other info',  'strip_tags|trim');
    //     $this->form_validation->set_rules('address',             'Address',             'required|strip_tags|trim');
    //     $this->form_validation->set_rules('author',              'Author',              'required|strip_tags|trim');
    //     $this->form_validation->set_rules('author_telephone',    'Author telephone',    'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
    //     $this->form_validation->set_rules('author_email',        'Author e-mail',       'strip_tags|trim|valid_email');
    //     $this->form_validation->set_rules('images',              'Document',            'strip_tags|trim');
    //     $this->form_validation->set_rules('cf_status',           'Cf status',           'strip_tags|trim');
    //     //$this->form_validation->set_rules('accept',              'Accept',              'required|strip_tags|trim');
    //     $this->form_validation->set_rules('lng',                 'lng',                 'strip_tags|trim');
    //     $this->form_validation->set_rules('lat',                 'lat',                 'strip_tags|trim');
    //     //#########
        
    //     if ($this->form_validation->run() == FALSE) {
            
    //         $errors = validation_errors();
    //         $this->session->set_flashdata('error_message', translate('invalid_form_data'));
            
    //         $page_data['error_message'] =  $errors;
    //         $page_data['title'] = translate('profile');
    //         $page_data['sectors'] = $this->project_model->get_sectors();
    //         $page_data['regions'] = $this->project_model->get_regions();
    //         $page_data['property_type'] = $this->project_model->get_property_type();
    //         $page_data['usage_form'] = $this->project_model->get_usage_form();
    //         $page_data['page_name'] = 'profile_add_estate';
    //         $this->load->view("profile/profile", $page_data);
        
    //     } else {
            
    //         // form parameters
    //         $project_name           = html_escape($this->input->post('project_name'));  
    //         $project_description    = html_escape($this->input->post('project_description'));   
    //         $sector                 = html_escape($this->input->post('sector')); 
    //         $property               = html_escape($this->input->post('property')); 
    //         $region                 = html_escape($this->input->post('region')); 
    //         $usage_form             = html_escape($this->input->post('usage_form')); 
    //         $price                  = html_escape($this->input->post('price'));         
    //         $ha                     = html_escape($this->input->post('ha')); 
    //         $infrastructure         = html_escape($this->input->post('infrastructure')); 
    //         $project_other_info     = html_escape($this->input->post('project_other_info')); 
    //         $address                = html_escape($this->input->post('address'));
    //         $author                 = html_escape($this->input->post('author'));            
    //         $author_telephone       = html_escape($this->input->post('author_telephone'));
    //         $youtube_video_link     = html_escape(generateVideoEmbedUrl($this->input->post('youtube_video_link'))); 
    //         $author_email           = html_escape($this->input->post('author_email'));  
    //         $cover_image            = html_escape($this->input->post('image')); 
    //         $cf_status              = html_escape($this->input->post('cf_status')); 
    //         //$accept                 = html_escape($this->input->post('accept'));    
    //         $lng                    = html_escape($this->input->post('lng'));   
    //         $lat                    = html_escape($this->input->post('lat'));   
            
        
    //         //image upload if exsist
    //         if (isset($_FILES['images']['name'])) {
    //             $say = count($_FILES['images']['name']);
    //             if($say>=6){
    //                 echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
    //                 redirect('user/addestate');exit();
    //             }
    //         }
    //         $project = array(
    //             'cf_status' => $cf_status,
    //             'user_id' => $this->session->userdata('user_id'),
    //             'sector_id' => $sector,
    //             'kat_id' => 7,
    //             'url_image' => 'n',
    //             'usage_form_id' => $usage_form,
    //             'property_type_id' => $property,
    //             'price' => $price,
    //             'common_area' => $ha,
    //             'top' => seflink($project_name),
    //             'region_id' => $region,
    //             'project_author' => $author,
    //             'youtube_video_link' => $youtube_video_link,
    //             'author_telephone' => $author_telephone,
    //             'author_email' => $author_email,
    //             'lng' => $lng,
    //             'lat' => $lat,
    //             'add_date' => date('Y-m-d H:i:s'),
    //         );
    //         $project_id = $this->project_model->add_project($project);
    //         if ($project_id) {
    //           $translate = array(
    //             'project_id' => $project_id,
    //             'lang_code' => $l,
    //             'project_title' => $project_name,
    //             'project_description' => $project_description,
    //             'other_important_data' => $project_other_info,
    //             'infrastructure' => $infrastructure,
    //             'adress' => $address,
    //         );
    //         $this->project_model->upload_files('images', 'projectimages', $project_id);
    //         $this->project_model->add_translate($translate);
    //         $this->session->set_flashdata('succes_message', translate('project_is_uploaded'));
    //         redirect('user/projects');
    //         }
            
    //     }  
    //     }else{
    //     $page_data['title'] = translate('profile');
    //     $page_data['sectors'] = $this->project_model->get_sectors();
    //     $page_data['regions'] = $this->project_model->get_regions();
    //     $page_data['property_type'] = $this->project_model->get_property_type();
    //     $page_data['usage_form'] = $this->project_model->get_usage_form();
    //     $page_data['page_name'] = 'profile_add_estate';
    //     $this->load->view("profile/profile", $page_data);   
    //     }
        
    // }

   

    /*..................investment_project...................*/

    public function addinvestment($parametr='')
    {
        $this->safety();
        if ($parametr=='doadd') {
        $l=curLang();
        
        //#########
        $this->form_validation->set_rules('project_name',       'Project Name',         'required|strip_tags|trim');
        $this->form_validation->set_rules('project_info',       translate('qisa_melumat'),         'required|strip_tags|trim|min_length[300]');
        $this->form_validation->set_rules('sector',             'Sector',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('investment_volume',  'Investment Volume',    'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('investment_percent', 'Investment Percent',   'strip_tags|trim|integer');
        $this->form_validation->set_rules('main_advantages',    'Main Advantages',      'strip_tags|trim');
        $this->form_validation->set_rules('project_other_info', 'Project Other Info',   'strip_tags|trim');
        $this->form_validation->set_rules('address',            'Address',              'required|strip_tags|trim');
        $this->form_validation->set_rules('author',             'Author',               'required|strip_tags|trim');
        $this->form_validation->set_rules('author_telephone',   translate('telefon_nomresi'),     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
        $this->form_validation->set_rules('author_email',       'Author E-mail',        'strip_tags|trim|valid_email');
        $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
        $this->form_validation->set_rules('cf_status',          'Cf status',            'strip_tags|trim');
        //$this->form_validation->set_rules('accept',             'Accept',               'required|strip_tags|trim');
        $this->form_validation->set_rules('lng',                'lng',                  'strip_tags|trim');
        $this->form_validation->set_rules('lat',                'lat',                  'strip_tags|trim');
        //#########
        
        if ($this->form_validation->run() == FALSE) {
            
            $errors = validation_errors();
            $this->session->set_flashdata('error_message', $errors);
            
            $page_data['error_message'] =  $errors;
            $page_data['title'] = translate('profile');
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['page_name'] = 'profile_add_investment';
            $this->load->view("profile/profile", $page_data);
            
        } else {
            
            // form parameters
            $project_name       = html_escape($this->input->post('project_name'));  
            $project_info       = html_escape($this->input->post('project_info'));  
            $sector             = html_escape($this->input->post('sector'));        
            $region             = html_escape($this->input->post('region'));                
            $investment_volume  = html_escape($this->input->post('investment_volume'));     
            $investment_percent = html_escape($this->input->post('investment_percent')); 
            $main_advantages    = html_escape($this->input->post('main_advantages'));
            $project_other_info = html_escape($this->input->post('project_other_info'));
            $address            = html_escape($this->input->post('address'));       
            $author             = html_escape($this->input->post('author'));            
            $author_telephone   = html_escape($this->input->post('author_telephone'));
            $youtube_video_link = html_escape(generateVideoEmbedUrl($this->input->post('youtube_video_link'))); 
            $author_email       = html_escape($this->input->post('author_email'));  
            $cover_image        = html_escape($this->input->post('image')); 
             //$cf_status          = html_escape($this->input->post('cf_status'));
            $cf_status          = 0;  
            //$accept             = html_escape($this->input->post('accept'));    
            $lng                = html_escape($this->input->post('lng'));   
            $lat                = html_escape($this->input->post('lat'));   
            
            //image upload if exsist
            if (isset($_FILES['images']['name'])) {
                $say = count($_FILES['images']['name']);
                if($say>=6){
                    echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
                    redirect('user/addinvestment');exit();
                }
            }
            $project = array(
                'cf_status' => $cf_status,
                'user_id' => $this->session->userdata('user_id'),
                'sector_id' => $sector,
                'kat_id' => 9,
                'url_image' => 'n',
                'investor_percent' => $investment_percent,
                'invesment_volume' => $investment_volume,
                'region_id' => $region,
                'project_author' => $author,
                'youtube_video_link' => $youtube_video_link,
                'top' => seflink($project_name),
                'author_telephone' => $author_telephone,
                'author_email' => $author_email,
                'lng' => $lng,
                'lat' => $lat,
                'add_date' => date('Y-m-d H:i:s'),
            );
            $project_id = $this->project_model->add_project($project);
            if ($project_id) {
               $translate = array(
                'project_id' => $project_id,
                'lang_code' => $l,
                'project_title' => $project_name,
                'project_description' => $project_info,
                'other_important_data' => $project_other_info,
                'main_advantages' => $main_advantages,
                'adress' => $address,
            );
            $this->project_model->upload_files('images', 'projectimages', $project_id);
            $this->project_model->add_translate($translate);
            $this->session->set_flashdata('succes_message', translate('project_is_uploaded'));
            redirect('user/projects');
            }
            
            
        }  
        }else{
        $page_data['title'] = translate('profile');
        $page_data['regions'] = $this->project_model->get_regions();
        $page_data['sectors'] = $this->project_model->get_sectors();
        $page_data['page_name'] = 'profile_add_investment';
        $this->load->view("profile/profile", $page_data);  
        }
        
    }

   

    /*..................privatization_project...................*/
    // public function addprivatization($parametr='')
    // {
    //     $this->safety();
    //     if ($parametr=='doadd') {
    //     $l=curLang();
        
    //     //#########
    //     $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
    //     $this->form_validation->set_rules('projectName',                 'Project Name',                 'required|strip_tags|trim');
    //     $this->form_validation->set_rules('project_info',                'Project Info',                 'required|strip_tags|trim');
    //     $this->form_validation->set_rules('sector',                      'Sector',                       'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('region',                      'Region',                       'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('charter_capital',             'Charter Capital',              'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('number_of_issued_stocks',     'Number of issued stocks',      'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('nominal_value_of_one_stocks', 'Nominal value of one stocks',  'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('volume_of_traded_stocks',     'Volume of traded stocks',      'required|strip_tags|trim|integer');
    //     $this->form_validation->set_rules('a_information',               'Information',                  'strip_tags|trim');
    //     $this->form_validation->set_rules('adress',                      'Adress',                       'required|strip_tags|trim');
    //     $this->form_validation->set_rules('author',                      'Author',                       'required|strip_tags|trim');
    //     $this->form_validation->set_rules('telephone',                   'Author Telephone',             'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
    //     $this->form_validation->set_rules('email',                       'Author E-mail',                'strip_tags|trim|valid_email');
    //     $this->form_validation->set_rules('cf_status',                   'cf_status',                    'strip_tags|trim');
    //     //$this->form_validation->set_rules('accept',                      'Accept',                       'required|strip_tags|trim');
    //     $this->form_validation->set_rules('lng',                         'lng',                          'strip_tags|trim');
    //     $this->form_validation->set_rules('lat',                         'lat',                          'strip_tags|trim');
    //     //#########
    //     if ($this->form_validation->run() == FALSE) {
            
    //         $errors = validation_errors();
    //         $this->session->set_flashdata('error_message', translate('invalid_form_data'));
            
    //         $page_data['error_message'] =  $errors;
    //         $page_data['title'] = translate('profile');
    //         $page_data['regions'] = $this->project_model->get_regions();
    //         $page_data['sectors'] = $this->project_model->get_sectors();
    //         $page_data['page_name'] = 'profile_add_privatization';
    //         $this->load->view("profile/profile", $page_data);
            
    //     } else {
            
    //         // form parameters
    //         $project_name                   = html_escape($this->input->post('projectName')); 
    //         $project_info                   = html_escape($this->input->post('project_info'));      
    //         $sector                         = html_escape($this->input->post('sector'));        
    //         $region                         = html_escape($this->input->post('region'));                
    //         $charter_capital                = html_escape($this->input->post('charter_capital'));   
    //         $number_of_issued_stocks        = html_escape($this->input->post('number_of_issued_stocks')); 
    //         $nominal_value_of_one_stocks    = html_escape($this->input->post('nominal_value_of_one_stocks'));
    //         $volume_of_traded_stocks        = html_escape($this->input->post('volume_of_traded_stocks'));
    //         $a_information                  = html_escape($this->input->post('a_information'));     
    //         $adress                         = html_escape($this->input->post('adress'));            
    //         $author                         = html_escape($this->input->post('author'));
    //         $telephone                      = html_escape($this->input->post('telephone')); 
    //         $youtube_video_link             = html_escape(generateVideoEmbedUrl($this->input->post('youtube_video_link')));     
    //         $email                          = html_escape($this->input->post('email')); 
    //         //$agree                          = html_escape($this->input->post('accept'));    
    //         $cf_status                      = html_escape($this->input->post('cf_status'));
    //         $lng                            = html_escape($this->input->post('lng'));   
    //         $lat                            = html_escape($this->input->post('lat'));               
            
    //         //image upload if exsist
    //         if (isset($_FILES['images']['name'])) {
    //             $say = count($_FILES['images']['name']);
    //             if($say>=6){
    //                 echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
    //                 redirect('user/addprivatization');exit();
    //             }
    //         }
    //         $project = array(
    //             'cf_status' => $cf_status,
    //             'user_id' => $this->session->userdata('user_id'),
    //             'sector_id' => $sector,
    //             'kat_id' => 3,
    //             'url_image' => 'n',
    //             'region_id' => $region,
    //             'top' => seflink($project_name),
    //             'charter_capital' => $charter_capital,
    //             'number_of_issued_stocks' => $number_of_issued_stocks,
    //             'nominal_value_of_one_stocks' => $nominal_value_of_one_stocks,
    //             'volume_of_traded_stocks' => $volume_of_traded_stocks,
    //             'project_author' => $author,
    //             'youtube_video_link' => $youtube_video_link,
    //             'author_telephone' => $telephone,
    //             'author_email' => $email,
    //             'lng' => $lng,
    //             'lat' => $lat,
    //             'add_date' => date('Y-m-d H:i:s'),
    //         );
    //         $project_id = $this->project_model->add_project($project);
    //         if ($project_id) {
    //         $translate = array(
    //             'project_id' => $project_id,
    //             'lang_code' => $l,
    //             'project_title' => $project_name,
    //             'project_description' => $project_info,
    //             'other_important_data' => $a_information,
    //             'adress' => $adress,
    //         );
    //         $this->project_model->upload_files('images', 'projectimages', $project_id);
    //         $this->project_model->add_translate($translate);
    //         $this->session->set_flashdata('succes_message', translate('project_is_uploaded'));
    //         redirect('user/projects');
    //         }
            
    //     }  
    //     }else{
    //     $page_data['title'] = translate('profile');
    //     $page_data['regions'] = $this->project_model->get_regions();
    //     $page_data['sectors'] = $this->project_model->get_sectors();
    //     $page_data['page_name'] = 'profile_add_privatization';
    //     $this->load->view("profile/profile", $page_data);   
    //     }
        
    // }

   

////////////////////////////////////////////////////Update_Projects/////////////////////////////////////////////////////  
    public function deletefile($pid)
    {  
    $this->safety(); 
    $pid=html_escape($pid);
    $user = $this->session->userdata('user_id');
    if ($pid != '' && $user!='') {
       $datauser=$this->project_model->getProjectUserId($pid);
       if ($datauser['user_id']==$user && $datauser['files_url']!='files/projectimages/noimage.jpg') {
           if ($this->project_model->deleteimage($pid)) {
            echo 'done';
        } else {
            echo 'error';
        }
        }else{
           echo "this is not your picture... <br>"."<a href=".base_url()."> Home</a>";
        } 
        
    }
    }
    public function editproject()
    {
        $this->safety();
        $page_data['title'] = translate('profile');
        $user_id = $this->session->userdata('user_id');
        $project_id = html_escape($this->uri->segment(3, 0));
        $category_id = html_escape($this->uri->segment(4, 0));
        if ($category_id and $category_id == 5) {
            $detail = $this->project_model->get_project_detail_idea($project_id);
            if ($detail) {
               
                    if ($detail['user_id'] == $user_id and $detail['kat_id'] == $category_id) {
                        $page_data['detail'] =$detail;
                        $page_data['regions'] = $this->project_model->get_regions();
                        $page_data['page_name'] = 'profile_update_idea';
                        $this->load->view("profile/profile", $page_data);
                    } else {
                        $page_data['page_name'] = '404';
                        $this->load->view("profile/profile", $page_data);
                    }
                
            } else {
                $page_data['page_name'] = '404';
                $this->load->view("profile/profile", $page_data);
            }
        } elseif ($category_id and $category_id == 1) {
            $detail = $this->project_model->get_project_detail_startup($project_id);
            if ($detail) {
                    if ($detail['user_id'] == $user_id and $detail['kat_id'] == $category_id) {
                        $page_data['detail'] = $detail;
                        $page_data['regions'] = $this->project_model->get_regions();
                        $page_data['sectors'] = $this->project_model->get_sectors();
                        $page_data['page_name'] = 'profile_update_startup';
                        $this->load->view("profile/profile", $page_data);

                    } else {
                        $page_data['page_name'] = '404';
                        $this->load->view("profile/profile", $page_data);
                    }
                
            } else {
                $page_data['page_name'] = '404';
                $this->load->view("profile/profile", $page_data);
            }
        } elseif ($category_id and $category_id == 2) {
            // $detail = $this->project_model->get_project_detail_land_sale($project_id);
            // if ($detail) {
               
            //         if ($detail['user_id'] == $user_id and $detail['kat_id'] == $category_id) {
            //             $page_data['detail'] = $detail;
            //             $page_data['regions'] = $this->project_model->get_regions();
            //             $page_data['sectors'] = $this->project_model->get_sectors();
            //             $page_data['usage_form'] = $this->project_model->get_usage_form();
            //             $page_data['property_type'] = $this->project_model->get_property_type();
            //             $page_data['appointment'] = $this->project_model->get_appointment();
            //             $page_data['page_name'] = 'profile_update_land_sale';
            //             $this->load->view("profile/profile", $page_data);

            //         } else {
            //             $page_data['page_name'] = '404';
            //             $this->load->view("profile/profile", $page_data);
            //         }
                
            // } else {
            //     $page_data['page_name'] = '404';
            //     $this->load->view("profile/profile", $page_data);
            // }
        } elseif ($category_id and $category_id == 4) {
            // $detail = $this->project_model->get_project_detail_business($project_id);
            // if ($detail) {
               
            //         if ($detail['user_id'] == $user_id and $detail['kat_id'] == $category_id) {
            //             $page_data['detail'] = $detail;
            //             $page_data['regions'] = $this->project_model->get_regions();
            //             $page_data['sectors'] = $this->project_model->get_sectors();
            //             $page_data['property_type'] = $this->project_model->get_property_type();
            //             $page_data['page_name'] = 'profile_update_business';
            //             $this->load->view("profile/profile", $page_data);

            //         } else {
            //             $page_data['page_name'] = '404';
            //             $this->load->view("profile/profile", $page_data);
            //         }
                
            // } else {
            //     $page_data['page_name'] = '404';
            //     $this->load->view("profile/profile", $page_data);
            // }
        } elseif ($category_id and $category_id == 6) {
            // $detail = $this->project_model->get_project_detail_stock($project_id);
            // if ($detail) {
                
            //         if ($detail['user_id'] == $user_id and $detail['kat_id'] == $category_id) {
            //             $page_data['detail'] = $detail;
            //             $page_data['regions'] = $this->project_model->get_regions();
            //             $page_data['sectors'] = $this->project_model->get_sectors();
            //             $page_data['property_type'] = $this->project_model->get_property_type();
            //             $page_data['page_name'] = 'profile_update_stock';
            //             $this->load->view("profile/profile", $page_data);

            //         } else {
            //             $page_data['page_name'] = '404';
            //             $this->load->view("profile/profile", $page_data);
            //         }
                
            // } else {
            //     $page_data['page_name'] = '404';
            //     $this->load->view("profile/profile", $page_data);
            // }
			
        } elseif ($category_id and $category_id == 7) {
			// #################### Əmlak Satışı = 7 
            // $detail = $this->project_model->get_project_detail_estate($project_id);
            // if ($detail) {
                
            //         if ($detail['user_id'] == $user_id and $detail['kat_id'] == $category_id) {
            //             $page_data['detail'] = $detail;
            //             $page_data['regions'] = $this->project_model->get_regions();
            //             $page_data['sectors'] = $this->project_model->get_sectors();
            //             $page_data['usage_form'] = $this->project_model->get_usage_form();
            //             $page_data['property_type'] = $this->project_model->get_property_type();
            //             $page_data['page_name'] = 'profile_update_estate';
            //             $this->load->view("profile/profile", $page_data);

            //         } else {
            //             $page_data['page_name'] = '404';
            //             $this->load->view("profile/profile", $page_data);
            //         }
                
            // } else {
            //     $page_data['page_name'] = '404';
            //     $this->load->view("profile/profile", $page_data);
            // }
        } elseif ($category_id and $category_id == 9) {
            $detail = $this->project_model->get_project_detail_investment($project_id);
            if ($detail) {
              
                    if ($detail['user_id'] == $user_id and $detail['kat_id'] == $category_id) {
                        $page_data['detail'] = $detail;
                        $page_data['regions'] = $this->project_model->get_regions();
                        $page_data['sectors'] = $this->project_model->get_sectors();
                        $page_data['page_name'] = 'profile_update_investment';
                        $this->load->view("profile/profile", $page_data);

                    } else {
                        $page_data['page_name'] = '404';
                        $this->load->view("profile/profile", $page_data);
                    }
               
            } else {
                $page_data['page_name'] = '404';
                $this->load->view("profile/profile", $page_data);
            }
        } elseif ($category_id and $category_id == 3) {
            // $detail = $this->project_model->get_project_detail_stock($project_id);
            // if ($detail) {
                
            //         if ($detail['user_id'] == $user_id and $detail['kat_id'] == $category_id) {
            //             $page_data['detail'] = $detail;
            //             $page_data['regions'] = $this->project_model->get_regions();
            //             $page_data['sectors'] = $this->project_model->get_sectors();
            //             $page_data['page_name'] = 'profile_update_privatization';
            //             $this->load->view("profile/profile", $page_data);

            //         } else {
            //             $page_data['page_name'] = '404';
            //             $this->load->view("profile/profile", $page_data);
            //         }
                
            // } else {
            //     $page_data['page_name'] = '404';
            //     $this->load->view("profile/profile", $page_data);
            // }
        } else {
            $page_data['page_name'] = '404';
            $this->load->view("profile/profile", $page_data);
        }
    }

    /*..................update_idea_project_back...................*/
    public function update_idea()
    {
        $this->safety();
        $project_id = html_escape($this->input->post('project_id',TRUE));
        $lang_code = html_escape($this->input->post('lang',TRUE));
        $translation_id = html_escape($this->input->post('translation_id',TRUE));
        if ($project_id!='' && $lang_code!='' && $translation_id!='') {
           $projects_data=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
           $translation_data=$this->db->get_where('project_translation',array('translation_id'=>$translation_id))->row_array();
           if ($projects_data!='' && $translation_data!='' && $this->session->userdata('user_id')==$projects_data['user_id']
                 &&  $translation_data['project_id']==$project_id) {
        $kat=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();       
         //#########
        $this->form_validation->set_rules('projectName',        'Project name',         'required|strip_tags|trim');
        $this->form_validation->set_rules('project_info',       'Project info',         'required|strip_tags|trim');
        $this->form_validation->set_rules('investment_volume',  'Investment volume',    'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('company',            'Company',              'required|strip_tags|trim');
        $this->form_validation->set_rules('number',             'Author telephone',     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
        $this->form_validation->set_rules('email',              'Author e-mail',        'strip_tags|trim|valid_email');
        $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
        //#########

        if ($this->form_validation->run() == FALSE) {
                echo $this->session->set_flashdata('error_message', translate('invalid_form_data'));
                redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
        }else{
        $countimg=$this->db->get_where('files',array('files_type_id'=>$project_id))->num_rows();
		$say = count($_FILES['images']['name']);
        
	        if(($say+$countimg)>=7){
				echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
                redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
				
			}
		    
        $this->project_model->upload_files('images', 'projectimages', $project_id);     
        $project_data = array(
            'region_id' => html_escape($this->input->post('region',TRUE)),
            'url_image' => 'u',
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'invesment_volume' => html_escape($this->input->post('investment_volume',TRUE)),
            'top' => seflink(html_escape($this->input->post('projectName',TRUE))),
            'project_author' => html_escape($this->input->post('company',TRUE)),
            'author_telephone' => html_escape($this->input->post('number',TRUE)),
            'author_email' => html_escape($this->input->post('email',TRUE)),
            'isActive' => 3,
            'update_date' => date('Y-m-d H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);

        $translation_data = array(
            'project_title' => html_escape($this->input->post('projectName',TRUE)),
            'project_description' => html_escape($this->input->post('project_info',TRUE)),
        );
        $this->project_model->update_translation($translation_id, $lang_code, $translation_data);
        $this->session->set_flashdata('succes_message', translate('project_is_updated'));
        redirect('user/projects');
    }
    }else{
        echo "incorrect id... <br>"."<a href=".base_url()."> Home</a>";
    }  
  }else{
     echo "this is not your project... <br>"."<a href=".base_url()."> Home</a>";
  }

}

    /*..................update_startup_project...................*/
    public function update_startup()
    {
        $this->safety();
        $project_id = html_escape($this->input->post('project_id',TRUE));
        $lang_code = html_escape($this->input->post('lang',TRUE));
        $translation_id = html_escape($this->input->post('translation_id',TRUE));
        if ($project_id!='' && $lang_code!='' && $translation_id!='') {
           $projects_data=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
           $translation_data=$this->db->get_where('project_translation',array('translation_id'=>$translation_id))->row_array();
           if ($projects_data!='' && $translation_data!='' && $this->session->userdata('user_id')==$projects_data['user_id']
                 &&  $translation_data['project_id']==$project_id) {
        $kat=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
         //#########
        $this->form_validation->set_rules('projectName',        'Project name',         'required|strip_tags|trim');
        $this->form_validation->set_rules('project_info',       'Project info',         'required|strip_tags|trim');
        $this->form_validation->set_rules('sector',             'Sector',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('investment_volume',  'Investment volume',    'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('investor_percent',   'Investor percent',     'strip_tags|trim|integer');
        $this->form_validation->set_rules('a_information',      'Project other info',   'strip_tags|trim');
        $this->form_validation->set_rules('adress',             'Address',              'required|strip_tags|trim');
        $this->form_validation->set_rules('author',             'Author',               'required|strip_tags|trim');
        $this->form_validation->set_rules('telephone',          'Author telephone',     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
        $this->form_validation->set_rules('email',              'Author e-mail',        'strip_tags|trim|valid_email');
        $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
        //#########
        
        if ($this->form_validation->run() == FALSE) {
                echo $this->session->set_flashdata('error_message', translate('invalid_form_data'));
                redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
        }else{
        $countimg=$this->db->get_where('files',array('files_type_id'=>$project_id))->num_rows();
        $say = count($_FILES['images']['name']);
            if(($say+$countimg)>=7){
                echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));           
                redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
                
            }
        
       
        $this->project_model->upload_files('images', 'projectimages', $project_id);  
		
        
        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector',TRUE)),
            'url_image' => 'u',
            'region_id' => html_escape($this->input->post('region',TRUE)),
            'invesment_volume' => html_escape($this->input->post('investment_volume',TRUE)),
            'investor_percent' => html_escape($this->input->post('investor_percent',TRUE)),
            'top' => seflink(html_escape($this->input->post('projectName',TRUE))),
            'project_author' => html_escape($this->input->post('author',TRUE)),
            'author_telephone' => html_escape($this->input->post('telephone',TRUE)),
           'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'author_email' => html_escape($this->input->post('email',TRUE)),
            'isActive' => 3,
            'update_date' => date('Y-m-d H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $translation_data = array(
            'project_title' => html_escape($this->input->post('projectName',TRUE)),
            'project_description' => html_escape($this->input->post('project_info',TRUE)),
            'other_important_data' => html_escape($this->input->post('a_information',TRUE)),
            'adress' => html_escape($this->input->post('adress',TRUE)),
        );
        $this->project_model->update_translation($translation_id, $lang_code, $translation_data);
        $this->session->set_flashdata('succes_message', translate('project_is_updated'));
        redirect('user/projects');
    }
        }else{
        echo "incorrect id... <br>"."<a href=".base_url()."> Home</a>";
    }  
  }else{
     echo "this is not your project... <br>"."<a href=".base_url()."> Home</a>";
  }
    }

    /*..................update_land_sale_project...................*/
  //   public function update_land_sale()
  //   {
  //       $this->safety();
  //       $project_id = html_escape($this->input->post('project_id',TRUE));
  //       $lang_code = html_escape($this->input->post('lang',TRUE));
  //       $translation_id = html_escape($this->input->post('translation_id',TRUE));

  //       if ($project_id!='' && $lang_code!='' && $translation_id!='') {
  //          $projects_data=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
  //          $translation_data=$this->db->get_where('project_translation',array('translation_id'=>$translation_id))->row_array();
  //          if ($projects_data!='' && $translation_data!='' && $this->session->userdata('user_id')==$projects_data['user_id']
  //                &&  $translation_data['project_id']==$project_id) {
  //       $kat=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
  //        //#########
  //       $this->form_validation->set_rules('projectName',        'Project name',         'required|strip_tags|trim');
  //       $this->form_validation->set_rules('project_info',       'Project info',         'required|strip_tags|trim');
  //       $this->form_validation->set_rules('sector',             'Sector',               'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('property',           'Property',             'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('usage_form',         'Usage form',           'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('appointment',        'Appointment',          'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('ha',                 'ha',                   'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('price',              'Price',                'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('infrastructure',     'Infrastructure',       'strip_tags|trim');
  //       $this->form_validation->set_rules('a_information',      'Project other info',   'strip_tags|trim');
  //       $this->form_validation->set_rules('adress',             'Address',              'required|strip_tags|trim');
  //       $this->form_validation->set_rules('author',             'Author',               'required|strip_tags|trim');
  //       $this->form_validation->set_rules('telephone',          'Author telephone',     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
  //       $this->form_validation->set_rules('email',              'Author e-mail',        'strip_tags|trim|valid_email');
  //       $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
  //       $this->form_validation->set_rules('lng',                'lng',                  'strip_tags|trim');
  //       $this->form_validation->set_rules('lat',                'lat',                  'strip_tags|trim');
  //       //#########
        
  //       if ($this->form_validation->run() == FALSE) {
  //               echo $this->session->set_flashdata('error_message', translate('invalid_form_data'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
  //       }else{
  //       $countimg=$this->db->get_where('files',array('files_type_id'=>$project_id))->num_rows();
  //       $say = count($_FILES['images']['name']);
  //           if(($say+$countimg)>=7){
  //               echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
                
  //           }
        
       
  //       $this->project_model->upload_files('images', 'projectimages', $project_id);  
  //       $project_data = array(
  //           'sector_id' => html_escape($this->input->post('sector',TRUE)),
  //           'url_image' => 'u',
  //           'property_type_id' => html_escape($this->input->post('property',TRUE)),
  //           'region_id' => html_escape($this->input->post('region',TRUE)),
  //           'usage_form_id' => html_escape($this->input->post('usage_form',TRUE)),
  //           'appointment_id' => html_escape($this->input->post('appointment',TRUE)),
  //           'top' => seflink(html_escape($this->input->post('projectName',TRUE))),
  //           'common_area' => html_escape($this->input->post('ha',TRUE)),
  //           'price' => html_escape($this->input->post('price',TRUE)),
  //           'project_author' => html_escape($this->input->post('author',TRUE)),
  //           'author_telephone' => html_escape($this->input->post('telephone',TRUE)),
  //          'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
  //           'author_email' => html_escape($this->input->post('email',TRUE)),
  //           'lng' => html_escape($this->input->post('lng',TRUE)),
  //           'lat' => html_escape($this->input->post('lat',TRUE)),
  //           'isActive' => 3,
  //           'update_date' => date('Y-m-d H:i:s'),
  //       );
  //       $this->project_model->update_project($project_id, $project_data);
  //       $translation_data = array(
  //           'project_title' => html_escape($this->input->post('projectName',TRUE)),
  //           'project_description' => html_escape($this->input->post('project_info',TRUE)),
  //           'infrastructure' => html_escape($this->input->post('infrastructure',TRUE)),
  //           'other_important_data' => html_escape($this->input->post('a_information',TRUE)),
  //           'adress' => html_escape($this->input->post('adress',TRUE)),
  //       );
  //       $this->project_model->update_translation($translation_id, $lang_code, $translation_data);
  //       $this->session->set_flashdata('succes_message', translate('project_is_updated'));
  //       redirect('user/projects');
  //   }
  //        }else{
  //       echo "incorrect id... <br>"."<a href=".base_url()."> Home</a>";
  //   }  
  // }else{
  //    echo "this is not your project... <br>"."<a href=".base_url()."> Home</a>";
  // }
  //   }

    /*..................update_estate_project...................*/
  //   public function update_estate()
  //   {
  //       $this->safety();
  //       $project_id = html_escape($this->input->post('project_id',TRUE));
  //       $lang_code = html_escape($this->input->post('lang',TRUE));
  //       $translation_id = html_escape($this->input->post('translation_id',TRUE));

  //       if ($project_id!='' && $lang_code!='' && $translation_id!='') {
  //          $projects_data=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
  //          $translation_data=$this->db->get_where('project_translation',array('translation_id'=>$translation_id))->row_array();
  //          if ($projects_data!='' && $translation_data!='' && $this->session->userdata('user_id')==$projects_data['user_id']
  //                &&  $translation_data['project_id']==$project_id) {
  //       $kat=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();    
  //        //#########
  //       $this->form_validation->set_rules('project_name',        'Project name',        'required|strip_tags|trim');
  //       $this->form_validation->set_rules('project_description', 'Project info',        'required|strip_tags|trim');
  //       $this->form_validation->set_rules('sector',              'Sector',              'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('property',            'Property',            'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('region',              'Region',              'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('usage_form',          'Usage form',          'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('price',               'Price',               'strip_tags|trim|integer');
  //       $this->form_validation->set_rules('ha',                  'ha',                  'strip_tags|trim|integer');
  //       $this->form_validation->set_rules('infrastructure',      'Infrastructure',      'strip_tags|trim');
  //       $this->form_validation->set_rules('project_other_info',  'Project other info',  'strip_tags|trim');
  //       $this->form_validation->set_rules('adress',             'Address',             'required|strip_tags|trim');
  //       $this->form_validation->set_rules('author',              'Author',              'required|strip_tags|trim');
  //       $this->form_validation->set_rules('telephone',    'Author telephone',    'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
  //       $this->form_validation->set_rules('email',        'Author e-mail',       'strip_tags|trim|valid_email');
  //       $this->form_validation->set_rules('images',              'Document',            'strip_tags|trim');
  //       $this->form_validation->set_rules('lng',                 'lng',                 'strip_tags|trim');
  //       $this->form_validation->set_rules('lat',                 'lat',                 'strip_tags|trim');
  //       //#########
        
  //       if ($this->form_validation->run() == FALSE) {
  //               echo $this->session->set_flashdata('error_message', translate('invalid_form_data'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
  //       }else{
  //       $countimg=$this->db->get_where('files',array('files_type_id'=>$project_id))->num_rows();
  //       $say = count($_FILES['images']['name']);
  //           if(($say+$countimg)>=7){
  //               echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
                
  //           }
        
       
  //       $this->project_model->upload_files('images', 'projectimages', $project_id);  
  //       $project_data = array(
  //           'sector_id' => html_escape($this->input->post('sector',TRUE)),
  //           'url_image' => 'u',
  //           'usage_form_id' => html_escape($this->input->post('usage_form',TRUE)),
  //           'property_type_id' => html_escape($this->input->post('property',TRUE)),
  //           'price' => html_escape($this->input->post('price',TRUE)),
  //           'common_area' => html_escape($this->input->post('ha',TRUE)),
  //           'top' => seflink(html_escape($this->input->post('project_name',TRUE))),
  //           'region_id' => html_escape($this->input->post('region',TRUE)),
  //           'project_author' => html_escape($this->input->post('author',TRUE)),
  //           'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
  //           'author_telephone' => html_escape($this->input->post('telephone',TRUE)),
  //           'author_email' => html_escape($this->input->post('email',TRUE)),
  //           'lng' => html_escape($this->input->post('lng',TRUE)),
  //           'lat' => html_escape($this->input->post('lat',TRUE)),
  //           'isActive' => 3,
  //           'update_date' => date('Y-m-d H:i:s'),
  //       );
  //       $this->project_model->update_project($project_id, $project_data);

  //       $translation_data = array(
  //           'project_title' => html_escape($this->input->post('project_name',TRUE)),
  //           'project_description' => html_escape($this->input->post('project_description',TRUE)),
  //           'other_important_data' => html_escape($this->input->post('project_other_info',TRUE)),
  //           'infrastructure' =>html_escape($this->input->post('infrastructure',TRUE)),
  //           'adress' => html_escape($this->input->post('adress',TRUE)),
  //       );
  //       $this->project_model->update_translation($translation_id, $lang_code, $translation_data);
  //       $this->session->set_flashdata('succes_message', translate('project_is_updated'));
  //       redirect('user/projects');
  //   }
  //        }else{
  //       echo "incorrect id... <br>"."<a href=".base_url()."> Home</a>";
  //   }  
  // }else{
  //    echo "this is not your project... <br>"."<a href=".base_url()."> Home</a>";
  // }
  //   }

    /*..................update_business_project...................*/
  //   public function update_business()
  //   {
  //       $this->safety();
  //       $project_id = html_escape($this->input->post('project_id',TRUE));
  //       $lang_code = html_escape($this->input->post('lang',TRUE));
  //       $translation_id = html_escape($this->input->post('translation_id',TRUE));

  //        if ($project_id!='' && $lang_code!='' && $translation_id!='') {
  //          $projects_data=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
  //          $translation_data=$this->db->get_where('project_translation',array('translation_id'=>$translation_id))->row_array();
  //          if ($projects_data!='' && $translation_data!='' && $this->session->userdata('user_id')==$projects_data['user_id']
  //                &&  $translation_data['project_id']==$project_id) {
  //       $kat=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
  //       //#########
  //       $this->form_validation->set_rules('projectName',        'Project name',         'required|strip_tags|trim');
  //       $this->form_validation->set_rules('project_info',       'Project info',         'required|strip_tags|trim');
  //       $this->form_validation->set_rules('sector',             'Sector',               'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('property',           'Property',             'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('price',              'Price',                'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('a_information',      'Project other info',   'strip_tags|trim');
  //       $this->form_validation->set_rules('adress',             'Address',              'required|strip_tags|trim');
  //       $this->form_validation->set_rules('author',             'Author',               'required|strip_tags|trim');
  //       $this->form_validation->set_rules('telephone',          'Author telephone',     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
  //       $this->form_validation->set_rules('email',              'Author e-mail',        'strip_tags|trim|valid_email');
  //       $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
  //       $this->form_validation->set_rules('lng',                'lng',                  'strip_tags|trim');
  //       $this->form_validation->set_rules('lat',                'lat',                  'strip_tags|trim');
  //       //#########
        
  //       if ($this->form_validation->run() == FALSE) {
  //               echo $this->session->set_flashdata('error_message', translate('invalid_form_data'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
  //       }else{
  //       $countimg=$this->db->get_where('files',array('files_type_id'=>$project_id))->num_rows();
  //       $say = count($_FILES['images']['name']);
  //           if(($say+$countimg)>=7){
  //               echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
                
  //           }
        
       
  //       $this->project_model->upload_files('images', 'projectimages', $project_id);  
  //       $project_data = array(
  //           'sector_id' => html_escape($this->input->post('sector',true)),
  //           'url_image' => 'u',
  //           'property_type_id' => html_escape($this->input->post('property',true)),
  //           'region_id' => html_escape($this->input->post('region',true)),
  //           'top' => seflink(html_escape($this->input->post('projectName',true))),
  //           'price' => html_escape($this->input->post('price',true)),
  //           'project_author' => html_escape($this->input->post('author',true)),
  //          'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
  //           'author_telephone' => html_escape($this->input->post('telephone',true)),
  //           'author_email' => html_escape($this->input->post('email',true)),
  //           'lng' => html_escape($this->input->post('lng',true)),
  //           'lat' => html_escape($this->input->post('lat',true)),
  //           'isActive' => 3,
  //           'update_date' => date('Y-m-d H:i:s'),
  //       );
  //       $this->project_model->update_project($project_id, $project_data);
  //       $translation_data = array(

  //           'project_title' => html_escape($this->input->post('projectName',TRUE)),
  //           'project_description' => html_escape($this->input->post('project_info',TRUE)),
  //           'other_important_data' => html_escape($this->input->post('a_information',TRUE)),
  //           'adress' => html_escape($this->input->post('adress',TRUE)),
  //       );
  //       $this->project_model->update_translation($translation_id, $lang_code, $translation_data);
  //       $this->session->set_flashdata('succes_message', translate('project_is_updated'));
  //       redirect('user/projects');
  //   }
  //        }else{
  //       echo "incorrect id... <br>"."<a href=".base_url()."> Home</a>";
  //   }  
  // }else{
  //    echo "this is not your project... <br>"."<a href=".base_url()."> Home</a>";
  // }
  //   }

    /*..................update_investment_project...................*/
    public function update_investment()
    {
       $this->safety();
        $project_id = html_escape($this->input->post('project_id',TRUE));
        $lang_code = html_escape($this->input->post('lang',TRUE));
        $translation_id = html_escape($this->input->post('translation_id',TRUE));

         if ($project_id!='' && $lang_code!='' && $translation_id!='') {
           $projects_data=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
           $translation_data=$this->db->get_where('project_translation',array('translation_id'=>$translation_id))->row_array();
           if ($projects_data!='' && $translation_data!='' && $this->session->userdata('user_id')==$projects_data['user_id']
                 &&  $translation_data['project_id']==$project_id) {
        $kat=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();     
         //#########
        $this->form_validation->set_rules('project_name',       'Project Name',         'required|strip_tags|trim');
        $this->form_validation->set_rules('project_info',       'Project Info',         'required|strip_tags|trim');
        $this->form_validation->set_rules('sector',             'Sector',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('region',             'Region',               'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('investment_volume',  'Investment Volume',    'required|strip_tags|trim|integer');
        $this->form_validation->set_rules('investment_percent', 'Investment Percent',   'strip_tags|trim|integer');
        $this->form_validation->set_rules('main_advantages',    'Main Advantages',      'strip_tags|trim');
        $this->form_validation->set_rules('project_other_info', 'Project Other Info',   'strip_tags|trim');
        $this->form_validation->set_rules('address',            'Address',              'required|strip_tags|trim');
        $this->form_validation->set_rules('author',             'Author',               'required|strip_tags|trim');
        $this->form_validation->set_rules('telephone',   'Author telephone',     'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
        $this->form_validation->set_rules('email',       'Author E-mail',        'strip_tags|trim|valid_email');
        $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
        $this->form_validation->set_rules('lng',                'lng',                  'strip_tags|trim');
        $this->form_validation->set_rules('lat',                'lat',                  'strip_tags|trim');
        //#########
        
        if ($this->form_validation->run() == FALSE) {
          echo $this->session->set_flashdata('error_message', translate('invalid_form_data'));
          redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
        }else{ 
        $countimg=$this->db->get_where('files',array('files_type_id'=>$project_id))->num_rows();
        $say = count($_FILES['images']['name']);
            if(($say+$countimg)>=7){
                echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
                redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
                
            }
        
       
        $this->project_model->upload_files('images', 'projectimages', $project_id);  
        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector',true)),
            'url_image' => 'u',
            'investor_percent' => html_escape($this->input->post('investment_percent',true)),
            'invesment_volume' => html_escape($this->input->post('investment_volume',true)),
            'region_id' => html_escape($this->input->post('region',true)),
            'top' => seflink(html_escape($this->input->post('project_name',true))),
            'project_author' => html_escape($this->input->post('author',true)),
            'author_telephone' => html_escape($this->input->post('telephone',true)),
           'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'author_email' => html_escape($this->input->post('email',true)),
            'lng' => html_escape($this->input->post('lng',true)),
            'lat' => html_escape($this->input->post('lat',true)),
            'isActive' => 3,
            'update_date' => date('Y-m-d H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $translation_data = array(
            'project_title' => html_escape($this->input->post('project_name',true)),
            'project_description' => html_escape($this->input->post('project_info',true)),
            'other_important_data' => html_escape($this->input->post('project_other_info',true)),
            'main_advantages' => html_escape($this->input->post('main_advantages',true)),
            'adress' => html_escape($this->input->post('address',true)),
        );
        $this->project_model->update_translation($translation_id, $lang_code, $translation_data);
        $this->session->set_flashdata('succes_message', translate('project_is_updated'));
        redirect('user/projects');
    }
         }else{
        echo "incorrect id... <br>"."<a href=".base_url()."> Home</a>";
    }  
  }else{
     echo "this is not your project... <br>"."<a href=".base_url()."> Home</a>";
  }
    }

    /*..................update_privatization_project...................*/
  //   public function update_privatization()
  //   {
  //       $this->safety();
  //       $project_id = html_escape($this->input->post('project_id',TRUE));
  //       $lang_code = html_escape($this->input->post('lang',TRUE));
  //       $translation_id = html_escape($this->input->post('translation_id',TRUE));

  //       if ($project_id!='' && $lang_code!='' && $translation_id!='') {
  //          $projects_data=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
  //          $translation_data=$this->db->get_where('project_translation',array('translation_id'=>$translation_id))->row_array();
  //          if ($projects_data!='' && $translation_data!='' && $this->session->userdata('user_id')==$projects_data['user_id']
  //                &&  $translation_data['project_id']==$project_id) {
  //       $kat=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();     
  //       //#########
  //       $this->form_validation->set_rules('images',             'Document',             'strip_tags|trim');
  //       $this->form_validation->set_rules('projectName',                 'Project Name',                 'required|strip_tags|trim');
  //       $this->form_validation->set_rules('project_info',                'Project Info',                 'required|strip_tags|trim');
  //       $this->form_validation->set_rules('sector',                      'Sector',                       'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('region',                      'Region',                       'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('charter_capital',             'Charter Capital',              'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('number_of_issued_stocks',     'Number of issued stocks',      'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('nominal_value_of_one_stocks', 'Nominal value of one stocks',  'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('volume_of_traded_stocks',     'Volume of traded stocks',      'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('a_information',               'Information',                  'strip_tags|trim');
  //       $this->form_validation->set_rules('adress',                      'Adress',                       'required|strip_tags|trim');
  //       $this->form_validation->set_rules('author',                      'Author',                       'required|strip_tags|trim');
  //       $this->form_validation->set_rules('telephone',                   'Author Telephone',             'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
  //       $this->form_validation->set_rules('email',                       'Author E-mail',                'strip_tags|trim|valid_email');
  //       $this->form_validation->set_rules('lng',                         'lng',                          'strip_tags|trim');
  //       $this->form_validation->set_rules('lat',                         'lat',                          'strip_tags|trim');
  //       //#########
  //       if ($this->form_validation->run() == FALSE) {
  //               echo $this->session->set_flashdata('error_message', translate('invalid_form_data'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
  //       }else{
  //       $countimg=$this->db->get_where('files',array('files_type_id'=>$project_id))->num_rows();
  //       $say = count($_FILES['images']['name']);
  //           if(($say+$countimg)>=7){
  //               echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
                
  //           }
        
       
  //       $this->project_model->upload_files('images', 'projectimages', $project_id);  
  //       $project_data = array(
  //           'sector_id' => html_escape($this->input->post('sector',true)),
  //           'url_image' => 'u',
  //           'region_id' => html_escape($this->input->post('region',true)),
  //           'charter_capital' => html_escape($this->input->post('charter_capital',true)),
  //           'number_of_issued_stocks' =>html_escape($this->input->post('number_of_issued_stocks',true)),
  //           'nominal_value_of_one_stocks' => html_escape($this->input->post('nominal_value_of_one_stocks',true)),
  //           'volume_of_traded_stocks' => html_escape($this->input->post('volume_of_traded_stocks',true)),
  //           'project_author' => html_escape($this->input->post('author',true)),
  //           'top' => seflink(html_escape($this->input->post('projectName',true))),
  //          'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
  //           'author_telephone' => html_escape($this->input->post('telephone',true)),
  //           'author_email' => html_escape($this->input->post('email',true)),
  //           'lng' => html_escape($this->input->post('lng')),
  //           'lat' => html_escape($this->input->post('lat')),
  //           'isActive' => 3,
  //           'update_date' => date('Y-m-d H:i:s'),
  //       );
  //       $this->project_model->update_project($project_id, $project_data);
  //       $translation_data = array(
  //           'project_title' => html_escape($this->input->post('projectName',true)),
  //           'project_description' => html_escape($this->input->post('project_info',true)),
  //           'other_important_data' => html_escape($this->input->post('a_information',true)),
  //           'adress' => html_escape($this->input->post('adress',true)),
  //       );
  //       $this->project_model->update_translation($translation_id, $lang_code, $translation_data);
  //       $this->session->set_flashdata('succes_message', translate('project_is_updated'));
  //       redirect('user/projects');
  //   }
  //        }else{
  //       echo "incorrect id... <br>"."<a href=".base_url()."> Home</a>";
  //   }  
  // }else{
  //    echo "this is not your project... <br>"."<a href=".base_url()."> Home</a>";
  // }
  //   }  /*..................update_stocks_project...................*/
  //   public function update_stocks()
  //   {
  //       $this->safety();
  //       $project_id = html_escape($this->input->post('project_id',TRUE));
  //       $lang_code = html_escape($this->input->post('lang',TRUE));
  //       $translation_id = html_escape($this->input->post('translation_id',TRUE));

  //       if ($project_id!='' && $lang_code!='' && $translation_id!='') {
  //          $projects_data=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
  //          $translation_data=$this->db->get_where('project_translation',array('translation_id'=>$translation_id))->row_array();
  //          if ($projects_data!='' && $translation_data!='' && $this->session->userdata('user_id')==$projects_data['user_id']
  //                &&  $translation_data['project_id']==$project_id) {
  //       $kat=$this->db->get_where('projects',array('project_id'=>$project_id))->row_array();
  //         //#########
  //       $this->form_validation->set_rules('projectName',                    'Project name',                 'required|strip_tags|trim');
  //       $this->form_validation->set_rules('project_info',                   'Project info',                 'required|strip_tags|trim');
  //       $this->form_validation->set_rules('sector',                         'Sector',                       'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('region',                         'Region',                       'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('charter_capital',                'Charter capital volume',       'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('number_of_issued_stocks',        'Number of issued stocks',      'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('nominal_value_of_one_stocks',    'Nominal value of one stocks',  'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('volume_of_traded_stocks',        'Volume of traded stocks',      'required|strip_tags|trim|integer');
  //       $this->form_validation->set_rules('a_information',                  'Project other info',           'strip_tags|trim');
  //       $this->form_validation->set_rules('adress',                         'Address',                      'required|strip_tags|trim');
  //       $this->form_validation->set_rules('author',                         'Author',                       'required|strip_tags|trim');
  //       $this->form_validation->set_rules('telephone',                      'Author telephone',             'required|strip_tags|trim|numeric|regex_match[/^[+][0-9]{10,15}$/]');
  //       $this->form_validation->set_rules('email',                          'Author e-mail',                'strip_tags|trim|valid_email');
  //       $this->form_validation->set_rules('images',                         'Document',                     'strip_tags|trim');
  //       $this->form_validation->set_rules('lng',                            'lng',                          'strip_tags|trim');
  //       $this->form_validation->set_rules('lat',                            'lat',                          'strip_tags|trim'); 
  //       //#########
        
  //       if ($this->form_validation->run() == FALSE) {
  //               echo $this->session->set_flashdata('error_message', translate('invalid_form_data'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
  //       }else{
  //       $countimg=$this->db->get_where('files',array('files_type_id'=>$project_id))->num_rows();
  //       $say = count($_FILES['images']['name']);
  //           if(($say+$countimg)>=7){
  //               echo $this->session->set_flashdata('error_message', translate('you_can_download_maximum_5_picture'));
  //               redirect(base_url().'user/editproject/'.$project_id.'/'.$kat['kat_id']);
                
  //           }
        
       
  //       $this->project_model->upload_files('images', 'projectimages', $project_id);  
  //       $project_data = array(
  //           'sector_id' => html_escape($this->input->post('sector',true)),
  //           'url_image' => 'u',
  //           'region_id' => html_escape($this->input->post('region',true)),
  //           'charter_capital' => html_escape($this->input->post('charter_capital',true)),
  //           'number_of_issued_stocks' => html_escape($this->input->post('number_of_issued_stocks',true)),
  //           'nominal_value_of_one_stocks' => html_escape($this->input->post('nominal_value_of_one_stocks',true)),
  //           'volume_of_traded_stocks' => html_escape($this->input->post('volume_of_traded_stocks',true)),
  //           'project_author' => html_escape($this->input->post('author',true)),
  //           'top' => seflink(html_escape($this->input->post('projectName',true))),
  //           'author_telephone' => html_escape($this->input->post('telephone',true)),
  //          'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
  //           'author_email' => html_escape($this->input->post('email',true)),
  //           'lng' => html_escape($this->input->post('lng',true)),
  //           'lat' => html_escape($this->input->post('lat',true)),
  //           'isActive' => 3,
  //           'update_date' => date('Y-m-d H:i:s'),
  //       );
  //       $this->project_model->update_project($project_id, $project_data);
  //       $translation_data = array(
  //           'project_title' => html_escape($this->input->post('projectName',true)),
  //           'project_description' => html_escape($this->input->post('project_info',true)),
  //           'other_important_data' => html_escape($this->input->post('a_information',true)),
  //           'adress' => html_escape($this->input->post('adress',true)),
  //       );
  //       $this->project_model->update_translation($translation_id, $lang_code, $translation_data);
  //       $this->session->set_flashdata('succes_message', translate('project_is_updated'));
  //       redirect('user/projects');
  //   }
  //       }else{
  //       echo "incorrect id... <br>"."<a href=".base_url()."> Home</a>";
  //   }  
  // }else{
  //    echo "this is not your project... <br>"."<a href=".base_url()."> Home</a>";
  // }
  //   }
}

?>
