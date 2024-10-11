<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Baku');
        $this->load->model('admin_model');
        $this->load->library('pagination');
        $this->load->model('email_model');
        $this->load->model('project_model');
        $this->load->library('user_agent');
		$this->load->helper(array('captcha'));
    }

    public function safety($url = '')
    {
        $url=html_escape($url);
        $enter = $this->session->userdata('admin_user_id');
        $this->admin_model->add_admin_logs($url);
        if (!$enter) {
            redirect('admin');
        }
    }

    public function index()
    {

        $enter = $this->session->userdata('admin_user_id');

        //admin panel ip control $allowedip = array("85.132.44.122");
        // $allowedip = array("::1");
        // if (!in_array($_SERVER['REMOTE_ADDR'], $allowedip)) {
        //     redirect(base_url());
        //     exit();
        // }
        //echo $_SERVER['REMOTE_ADDR'];
        //ip control

        if ($enter) {
            redirect('admin/home');
        } else {
            $this->load->view('back/login');
        }
    }

    public function login()
    {
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
		//#########
		$this->form_validation->set_rules('login', 	   'Login',     'trim|required|exact_length[5]|in_list[admin]');
        $this->form_validation->set_rules('password',  'Password',  'trim|required');
        $this->form_validation->set_rules('captchaCode',  'Captcha',  'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
			$this->session->set_flashdata(
				'login_invalid', 
				'<div class="alert alert-danger text-center alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-ban"></i> Xəta!</h4>
					Bütün məlumatları düzgün daxil edin. 
				</div>'
			);
			redirect('admin');

        } else {
			
			$login = html_escape($this->input->post('login'));
			$password = html_escape($this->input->post('password'));
			
			 if (!$this->captcha_model->check($this->input->post('captchaCode'))) {

				$this->session->set_flashdata(
					'login_invalid', 
					'<div class="alert alert-danger text-center alert-dismissible">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						<h4><i class="icon fa fa-ban"></i> Xəta!</h4>
						Təhlükəsizlik kodu yanlışdır.
					</div>'
				);
				redirect('admin');

            }else{
				
				$this->admin_model->add_admin_logins($login, sha1($password));
				$control = $this->admin_model->control($login, $password);
				
				if ($control) {
					
					$this->session->set_userdata('admin_user_id', $control['id']);
					$this->session->set_userdata('last_login', $control['last_login']);
					$this->session->set_userdata('last_ip', $control['last_ip']);
					$data = array('last_login' => date('d-m-Y H:i:s'), 'last_ip' => $this->input->ip_address());
					$this->admin_model->lastlogin($control['id'], $data);
					redirect('admin/home');
					
				} else {
					$this->session->set_flashdata(
						'login_invalid', 
						'<div class="alert alert-danger text-center alert-dismissible">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							<h4><i class="icon fa fa-ban"></i> Xəta!</h4>
							İstifadəçi adı, şifrə və ya təhlükəsizlik kodu yanlışdır. 
						</div>'
					);
					redirect('admin');
				}
			
			}
			
		}
    }else{
        echo 'error';
    }
    }

    public function update_password()
    {
        $this->safety('/update_password');
        $this->load->view('back/password/home');
    }

    public function updating_password()
    {
        $this->safety('/updating_password');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {


        $this->form_validation->set_rules('old_password',  ' old Password',  'trim|required');
        $this->form_validation->set_rules('password_1',  ' new Password',  'trim|required');  
        $this->form_validation->set_rules('password_2',  'conf Password',  'trim|required');   
         if ($this->form_validation->run() == FALSE) {
           $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Xəta!</h4>
               Bütün Xanalar doldurulmalıdır! </div>');
            redirect('admin/update_password');  
         }else{
        $old_password = sha1(md5(html_escape($this->input->post('old_password'))));
        $password_1 = html_escape($this->input->post('password_1'));
        $password_2 = html_escape($this->input->post('password_2'));
        if ($password_1 === $password_2) {
            $admin_data = $this->admin_model->get_admin_details();
            if ($admin_data['password'] == $old_password){
                $password = sha1(md5(html_escape($this->input->post('password_1'))));
                $this->admin_model->update_password($password);
                $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
					Şifrə uğurla yeniləndi. </div>');
                redirect('admin/logout');
            } else {
                $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
					<h4><i class="icon fa fa-check"></i> Xəta!</h4>
					Şifrə düzgün deyil! </div>');
                redirect('admin/update_password');
            }

        } else {
            $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
				<h4><i class="icon fa fa-check"></i> Xəta!</h4>
				Şifrələr Uygun deyil! </div>');
            redirect('admin/update_password');
        }
    }
    }else{
        echo "error";
    }
    }

    public function users()
    {
            $this->safety('/users');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 12;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/users';
            $config['total_rows'] = $this->db->count_all_results('users');
            $data['users']       = $this->db->order_by('id', 'desc')->get('users', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['users']);
            $this->load->view('back/users/home', $data);
    }

    public function projects()
    {
            $this->safety('/projects');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 10;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/projects';
            $config['total_rows'] = $this->db->count_all_results('projects');
            $data['projects'] = $this->admin_model->get_all_projects($config['per_page'], $page);
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['projects']);
            $this->load->view('back/projects/home', $data);
    }

    public function delete_project()
    {
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $project_id = html_escape($this->uri->segment(3, 0));
        $this->safety('/delete_project/' . $project_id);
        if ($project_id){
            $images=$this->db->get_where('files',array('files_type_id' => $project_id ))->result_array();
            if ($images){
               foreach ($images as $image) {
                $url='./' . $image['files_url'];
                unlink($url); 
            }
            }
            $this->db->where('files_type_id', $project_id);
            $this->db->delete('files');
            $this->db->where('project_id', $project_id);
            $this->db->delete('project_translation');
            $this->db->where('project_id', $project_id);
            $this->db->delete('projects');

            
            redirect('admin/projects');
        }
        redirect('admin/projects');
    }else{
        echo "error";
    }
    }

    public function projectsset()
    {
        $this->safety('/projectsset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('project_id', $id)->update('projects', array('isActive' => $status));
    }else{
        echo "error";
    }
    }

    public function usersset()
    {
        $this->safety('/usersset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
          $id = html_escape($this->input->post('id'));
          $status = ($this->input->post('status') == 'true') ? 1 : 2;
          $this->db->where('id', $id)->update('users', array('user_status' => $status)); 
        }else{
            echo "error";
        }
        
    }

    public function geoprojectsset()
    {
        $this->safety('/geoprojectsset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('geo_id', $id)->update('geomap', array('geo_status' => $status));
    }else{
        echo "error";
    }}

    public function home()
    {
        $this->safety('/home');
        $this->load->view('back/home');
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin');
    }

    /*...................................geomap.................................*/
    public function add_category()
    {
        $this->safety('/add_category');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $category_name_az = html_escape($this->input->post('category_name_az'));
        $category_name_en = html_escape($this->input->post('category_name_en'));
        $category_name_ru = html_escape($this->input->post('category_name_ru'));
        $data['geo_categories_name_az'] = $category_name_az;
        $data['geo_categories_name_en'] = $category_name_en;
        $data['geo_categories_name_ru'] = $category_name_ru;

        $this->db->insert('geo_categories', $data);
        $this->session->set_flashdata('add', 'uğurla əlavə edildi');
        redirect(base_url() . 'admin/category/add');
    }else{
        echo "error";
    }
    }

    public function delete_category()
    {
        $this->safety('/delete_category');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $category_id = html_escape($this->input->post('category_id'));
        $this->db->where('geo_categories_id', $category_id);
        $this->db->delete('geo_categories');
        $this->session->set_flashdata('delete', 'uğurla silindi');
        redirect(base_url() . 'admin/category/delete');
    }else{
        echo "error";
    }
    }

    public function delete_subcategory()
    {
        $this->safety('/delete_subcategory');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $category_id = html_escape($this->input->post('category_id'));
        $sub_category_id = html_escape($this->input->post('sub_category_id'));
        $this->db->where(array('geo_categories_id' => $category_id, 'geo_subcategories_id' => $sub_category_id));
        $this->db->delete('geo_subcategories');
        $this->session->set_flashdata('delete', 'uğurla silindi');
        redirect(base_url() . 'admin/category/delete_sub');
    }else{
        echo "error";
    }
    }

    public function update_category()
    {
        $this->safety('/update_category');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $category_name_az = html_escape($this->input->post('category_name_az'));
        $category_name_en = html_escape($this->input->post('category_name_en'));
        $category_name_ru = html_escape($this->input->post('category_name_ru'));
        $category_id      = html_escape($this->input->post('category_id'));
        $data['geo_categories_name_az'] = $category_name_az;
        $data['geo_categories_name_en'] = $category_name_en;
        $data['geo_categories_name_ru'] = $category_name_ru;
        $data['update_time'] = date('Y-m-d H:i:s');
        $this->db->where('geo_categories_id', $category_id);
        $this->db->update('geo_categories', $data);
        $this->session->set_flashdata('update', 'uğurla yeniləndi');
        redirect(base_url() . 'admin/category/update');
    }else{
        echo "error";
    }
    }

    public function update_subcategory()
    {
        $this->safety('/update_subcategory');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $subcategory_name_az = html_escape($this->input->post('sub_category_name_az'));
        $subcategory_name_en = html_escape($this->input->post('sub_category_name_en'));
        $subcategory_name_ru = html_escape($this->input->post('sub_category_name_ru'));
        $category_id         = html_escape($this->input->post('cat_name_ajax'));
        $subcategory_id      = html_escape($this->input->post('sub_cat_name_ajax'));
        $data['geo_subcategories_name_az'] = $subcategory_name_az;
        $data['geo_subcategories_name_en'] = $subcategory_name_en;
        $data['geo_subcategories_name_ru'] = $subcategory_name_ru;
        $data['update_time'] = date('Y-m-d H:i:s');
        $this->db->where('geo_categories_id', $category_id);
        $this->db->where('geo_subcategories_id', $subcategory_id);
        $this->db->update('geo_subcategories', $data);
        $this->session->set_flashdata('update', 'uğurla yeniləndi');
        redirect(base_url() . 'admin/category/update_sub');
            }else{
                echo "error";
            }
    }

    function add_subcategory()
    {
        $this->safety('/add_subcategory');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id          = html_escape($this->input->post('category_id'));
        $sub_name_az = html_escape($this->input->post('sub_category_name_az'));
        $sub_name_en = html_escape($this->input->post('sub_category_name_en'));
        $sub_name_ru = html_escape($this->input->post('sub_category_name_ru'));
        $this->db->select_max('geo_subcategories_id');
        $max_id = $this->db->get_where('geo_subcategories', array('geo_categories_id' => $id))->row()->geo_subcategories_id;
        //echo $max_id;exit();
        $data['geo_subcategories_name_az'] = $sub_name_az;
        $data['geo_subcategories_name_en'] = $sub_name_en;
        $data['geo_subcategories_name_ru'] = $sub_name_ru;
        $data['geo_categories_id'] = $id;
        $data['geo_subcategories_id'] = $max_id + 1;
        $this->db->insert('geo_subcategories', $data);
        $this->session->set_flashdata('add', 'uğurla əlavə edildi');
        redirect(base_url() . 'admin/category/add_sub');
    }else{
        echo "error";
    }
    }

    function edit_location()
    {
            $this->safety('/edit_location');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 12;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/edit_location';
            $config['total_rows'] = $this->db->count_all_results('geomap');
            $data['all']       = $this->db->order_by('geo_id','desc')->get('geomap', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['all']);
            $data['page_name'] = 'edit_location';
            $this->load->view('back/geomap/home', $data);
    }

    function update_location($para = '')
    {
        $this->safety('/update_location');
        $data['categories'] = $this->db->get('geo_categories')->result_array();
        $data['categori_id'] = $this->db->get_where('geomap', array('geo_id' => $para))->row()->geo_kat;
        $data['subkat'] = $this->db->get_where('geomap', array('geo_id' => $para))->row()->geo_subkat;
        $data['geo_all'] = $this->db->get_where('geomap', array('geo_id' => $para))->result_array();
        $data['page_name'] = 'update_location';
        $data['all_id'] = $para;
        $this->load->view('back/geomap/home', $data);
    }

    function up_location()
    {
        $this->safety('/up_location');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $cat_id = html_escape($this->input->post('category_id'));
        $subcat_id = html_escape($this->input->post('sub_category_id'));
        $url = html_escape($this->input->post('geo_url'));
        $name_az = html_escape($this->input->post('geo_name_az'));
        $description_az = html_escape($this->input->post('geo_description_az'));
        $name_en = html_escape($this->input->post('geo_name_en'));
        $description_en = html_escape($this->input->post('geo_description_en'));
        $name_ru = html_escape($this->input->post('geo_name_ru'));
        $description_ru = html_escape($this->input->post('geo_description_ru'));
        $lat = html_escape($this->input->post('lat'));
        $lng = html_escape($this->input->post('lng'));
        $geo_id = html_escape($this->input->post('geo_id'));

        if ($lat == '' || $lng == '') {
            $this->session->set_flashdata('failed_location', 'yer seçin');
            redirect(base_url() . 'admin/category/add_location');
        }

        if ($name_az == '' || $name_en == '' || $name_ru == '' || $description_az == '' || $description_en == '' || $description_ru == '' || $url == '') {
            $this->session->set_flashdata('empty', 'xəta');
            redirect(base_url() . 'admin/update_location/' . $geo_id);
        }

        $data['geo_name_az'] = $name_az;
        $data['geo_description_az'] = $description_az;
        $data['geo_name_en'] = $name_en;
        $data['geo_description_en'] = $description_en;
        $data['geo_name_ru'] = $name_ru;
        $data['geo_description_ru'] = $description_ru;
        $data['geo_url'] = $url;
        $data['geo_lat'] = $lat;
        $data['geo_subkat'] = $subcat_id;
        $data['geo_kat'] = $cat_id;
        $data['geo_lng'] = $lng;
        $data['update_time'] = date('Y-m-d H:i:s');
        $this->db->where('geo_id', $geo_id);
        $this->db->update('geomap', $data);
        $this->session->set_flashdata('update', 'uğurla yeniləndi');
        redirect(base_url() . 'admin/update_location/' . $geo_id);
            }else{
                echo "error";
            }

    }

    public function delete_location($para = '')
    {  
        $para=html_escape($para);
        $this->safety('/delete_location');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $this->db->where('geo_id', $para);
        $this->db->delete('geomap');
        $this->session->set_flashdata('delete', 'uğurla silindi');
        redirect(base_url() . 'admin/edit_location');
    }else{
        echo "error";
    }
    }

    function add_new_location()
    {
        $this->safety('/add_new_location');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $cat_id    = html_escape($this->input->post('category_id'));
        $subcat_id = html_escape($this->input->post('sub_category_id'));
        $url       = html_escape($this->input->post('geo_url'));
        $name_az   = html_escape($this->input->post('geo_name_az'));
        $description_az = html_escape($this->input->post('geo_description_az'));
        $name_en   = html_escape($this->input->post('geo_name_en'));
        $description_en = html_escape($this->input->post('geo_description_en'));
        $name_ru   = html_escape($this->input->post('geo_name_ru'));
        $description_ru = html_escape($this->input->post('geo_description_ru'));
        $lat       = html_escape($this->input->post('lat'));
        $lng       = html_escape($this->input->post('lng'));
        if ($lat == '' || $lng == '') {
            $this->session->set_flashdata('failed_location', 'Yer Seçin');
            redirect(base_url() . 'admin/category/add_location');
        }
        if ($name_az == '' || $name_en == '' || $name_ru == '' || $description_az == '' || $description_en == '' || $description_ru == '' || $url == '') {
            $this->session->set_flashdata('empty', 'Xəta');
            redirect(base_url() . 'admin/category/add_location');
        }
        $data['geo_name_az'] = $name_az;
        $data['geo_description_az'] = $description_az;
        $data['geo_name_en'] = $name_en;
        $data['geo_description_en'] = $description_en;
        $data['geo_name_ru'] = $name_ru;
        $data['geo_description_ru'] = $description_ru;
        $data['geo_url'] = $url;
        $data['geo_lat'] = $lat;
        $data['geo_lng'] = $lng;
        $data['geo_subkat'] = $subcat_id;
        $data['geo_kat'] = $cat_id;
        $this->db->insert('geomap', $data);
        $this->session->set_flashdata('add', 'uğurla əlavə edildi');
        redirect(base_url() . 'admin/category/add_location');
    }else{
        echo "error";
    }
    }

    function get_category_name()
    {
        $this->safety('/get_category_name');
        $id = html_escape($this->input->post('id'));
        $name_az = $this->db->get_where('geo_categories', array('geo_categories_id' => $id))->row()->geo_categories_name_az;
        $name_en = $this->db->get_where('geo_categories', array('geo_categories_id' => $id))->row()->geo_categories_name_en;
        $name_ru = $this->db->get_where('geo_categories', array('geo_categories_id' => $id))->row()->geo_categories_name_ru;
        echo '
    <p style="font-size:21px;color:blue;margin-left:25%">kateqoriya adın yenilə..</p>
    <div><label for="fname" style="line-height: 70px;">Az</label>
    <input name="category_name_az" type="text" style="    float: right;    width: 75%;" value="' . $name_az . '"></div>
    <div><label for="fname" style="line-height: 70px;">En</label>
    <input name="category_name_en" type="text" style="    float: right;    width: 75%;" value="' . $name_en . '"></div>
    <div><label for="fname" style="line-height: 70px;">Ru</label>
    <input name="category_name_ru" type="text" style="    float: right;    width: 75%;" value="' . $name_ru . '"></div>';
    }

    function get_subcategory_name($para = '')
    {
        $this->safety('/get_subcategory_name');
        $cat_id = html_escape($para);
        $sub_id = html_escape($this->input->post('id'));
        $name_az = $this->db->get_where('geo_subcategories', array('geo_categories_id' => $cat_id, 'geo_subcategories_id' => $sub_id))->row()->geo_subcategories_name_az;
        $name_en = $this->db->get_where('geo_subcategories', array('geo_categories_id' => $cat_id, 'geo_subcategories_id' => $sub_id))->row()->geo_subcategories_name_en;
        $name_ru = $this->db->get_where('geo_subcategories', array('geo_categories_id' => $cat_id, 'geo_subcategories_id' => $sub_id))->row()->geo_subcategories_name_ru;
        echo '
    <p style="font-size:21px;color:blue;margin-left:25%">alt kateqoriya adın yenilə..</p>
    <div><label for="fname" style="line-height: 70px;">Az</label>
    <input name="sub_category_name_az" type="text" style="    float: right;    width: 75%;" value="' . $name_az . '"></div>
    <div><label for="fname" style="line-height: 70px;">En</label>
    <input name="sub_category_name_en" type="text" style="    float: right;    width: 75%;" value="' . $name_en . '"></div>
    <div><label for="fname" style="line-height: 70px;">Ru</label>
    <input name="sub_category_name_ru" type="text" style="    float: right;    width: 75%;" value="' . $name_ru . '"></div>';

    }

    public function category($para1 = '')
    {
        $this->safety('/category');
        if ($para1 == 'add') {
            $page_data['page_name'] = 'add_category';
            $this->load->view('back/geomap/home', $page_data);
        }
        if ($para1 == 'delete') {
            $page_data['page_name'] = 'delete_category';
            $page_data['categories'] = $this->db->get('geo_categories')->result_array();
            $this->load->view('back/geomap/home', $page_data);
        }
        if ($para1 == 'delete_sub') {
            $page_data['page_name'] = 'delete_subcategory';
            $page_data['categories'] = $this->db->get('geo_categories')->result_array();
            $this->load->view('back/geomap/home', $page_data);
        }
        if ($para1 == 'update') {
            $page_data['categories'] = $this->db->get('geo_categories')->result_array();
            $page_data['page_name'] = 'update_category';
            $this->load->view('back/geomap/home', $page_data);
        }
        if ($para1 == 'update_sub') {
            $page_data['categories'] = $this->db->get('geo_categories')->result_array();
            $page_data['page_name'] = 'update_subcategory';
            $this->load->view('back/geomap/home', $page_data);
        }
        if ($para1 == 'add_sub') {
            $page_data['categories'] = $this->db->get('geo_categories')->result_array();
            $page_data['page_name'] = 'add_subcategory';
            $this->load->view('back/geomap/home', $page_data);
        }
        if ($para1 == 'add_location') {
            $page_data['categories'] = $this->db->get('geo_categories')->result_array();
            $page_data['page_name'] = 'add_location';
            $this->load->view('back/geomap/home', $page_data);
        }
    }

    function get_subcategory()
    {
        $this->safety('/get_subcategory');
        $para1 = html_escape($this->input->post('id'));
        $s_cat = $this->db->get_where('geo_subcategories', array('geo_categories_id' => $para1))->result_array();
        foreach ($s_cat as $cat) {
            echo '<option value="' . $cat['geo_subcategories_id'] . '"  >' . $cat['geo_subcategories_name_az'] . '</option>';
        }
    }

    function get_subcategory_add($para1 = '', $para = '')
    {
        $this->safety('/get_subcategory');
        $para1 = html_escape($para1);
        $para  = html_escape($para);
        $s_cat = $this->db->get_where('geo_subcategories', array('geo_categories_id' => $para1))->result_array();
        foreach ($s_cat as $cat) {
            $sel = '';
            if ($cat['geo_subcategories_id'] == $para) {
                $sel = 'selected';
            }
            echo '<option value="' . $cat['geo_subcategories_id'] . '"  >' . $cat['geo_subcategories_name_az'] . '</option>';
        }
    }

    public function sub_category($para1 = '')
    {
        $para1 = html_escape($para1);
        $this->safety('/sub_category');
        if ($para1 == 'add') {

        } else {
            $this->load->view('back/geomap/add_sub_category.php');
        }
    }

    public function location($para1 = '')
    {
        $this->safety('/location');
        if ($para1 == 'add') {

        } else {

            $this->load->view('back/geomap/add_location.php');
        }
    }

    public function edit_user($id = '')
    {
        $this->safety('/edit_user/' . $id);
        $id = html_escape($id);
        if ($id != null) {
            $data['user'] = $this->admin_model->get_user_data($id);
            $this->load->view('back/users/edit/home', $data);
        }
    }

    public function update_user_data()
    {
        $this->safety('/update_user_data');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $user['company_name'] = html_escape($this->input->post('company_name'));
        $user['user_name'] = html_escape($this->input->post('user_name'));
        $user['user_surname'] = html_escape($this->input->post('user_surname'));
        $user['work_number'] = html_escape($this->input->post('work_number'));
        $user['mobil_number'] = html_escape($this->input->post('mobil_number'));
        $user['user_role'] = html_escape($this->input->post('user_role'));
        $user['update_time'] = date('Y-m-d H:i:s');;
        $id = $this->input->post('id');
        $this->admin_model->update_user($id, $user);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Dəyişdirildi!</h4>
                        Redaktə əməliyyatı uğurla icra olundu. </div>');
        redirect('admin/users');
    }else{
        echo "error";
    }
    }

    public function delete_user($id = '')
    {
        $this->safety('/delete_user/' . $id);
        $id=html_escape($id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $this->admin_model->delete_user($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Istifadəçinin silinməsi uğurla icra olundu. </div>');
        redirect('admin/users');
    }else{
        echo "error";
    }
    }

    /*................................about_us.......................................*/
    public function about_content()
    {
        $this->safety('/about_content');
        $data['details'] = $this->admin_model->get_about_contet();
        $this->load->view('back/about/home', $data);
    }

    public function edit_about_content()
    {
        $this->safety('/edit_about_content');
        $data['details'] = $this->admin_model->get_about_contet();
        $this->load->view('back/about/edit/home', $data);
    }

    public function update_about_content()
    {
        $this->safety('/update_about_content');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data['basliq_az'] = $this->input->post('basliq_az');
        $data['basliq_en'] = $this->input->post('basliq_en');
        $data['basliq_ru'] = $this->input->post('basliq_ru');

        $data['meksed_az'] = $this->input->post('meksed_az');
        $data['meksed_en'] = $this->input->post('meksed_en');
        $data['meksed_ru'] = $this->input->post('meksed_ru');

        $data['hedef_az'] = $this->input->post('hedef_az');
        $data['hedef_en'] = $this->input->post('hedef_en');
        $data['hedef_ru'] = $this->input->post('hedef_ru');

        $data['missiya_az'] = $this->input->post('missiya_az');
        $data['missiya_en'] = $this->input->post('missiya_en');
        $data['missiya_ru'] = $this->input->post('missiya_ru');

        $data['content_az'] = $this->input->post('content_az');
        $data['content_en'] = $this->input->post('content_en');
        $data['content_ru'] = $this->input->post('content_ru');

        $data['update_date'] = date('Y-m-d H:i:s');

        $this->admin_model->update_about_contet($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Dəyişdirildi!</h4>
                        Redaktə əməliyyatı uğurla icra olundu. </div>');
        redirect('admin/about_content');
    }else{
        echo "error";
    }
    }

    /*................................get_subcribers.......................................*/
    public function get_subcribers()
    {
            $this->safety('/get_subcribers');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 12;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/get_subcribers';
            $config['total_rows'] = $this->db->count_all_results('subcribers');
            $data['details']       = $this->db->order_by('id','desc')->get('subcribers', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['details']);
            $this->load->view('back/subcribers/home', $data);
    }

    public function mail_subcribers()
    {
        $this->safety('/mail_subcribers');
        $this->load->view('back/subcribers/send/home');
    }

    public function mailto_subcribers()
    {
        $this->safety('/mailto_subcribers');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $subcribers = $this->admin_model->get_subcribers();
        $message = $this->input->post('message');
        $subject = $this->input->post('subject');
        foreach ($subcribers as $key) {
            $this->email_model->sendMail($message, $key['email'], $subject);
        }
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Göndərildi!</h4>
                       email bütün izləyicilərə uğurla Göndərildi. </div>');
        redirect('admin/get_subcribers');
    }else
    {
        echo "error";
    }
    }

    public function delete_subcriber($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_subcriber/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $this->admin_model->delete_subcriber($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Izləyicinin silinməsi uğurla icra olundu. </div>');
        redirect('admin/get_subcribers');
    }else{
        echo "error";
    }
    }

    /*................................get_partners.......................................*/
    public function partners()
    {
        $this->safety('/partners');
        $data['details'] = $this->admin_model->get_partners();
        $this->load->view('back/partners/home', $data);
    }

    public function partner_add()
    {
        $this->safety('/partner_add');
        $this->load->view('back/partners/add/home');
    }

    public function partner_adding()
    {
        $this->safety('/partner_adding');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $new_image_name = time() . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['image']['name']);
        $config['upload_path'] = './assets/front/images/';
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['max_size'] = 10000;
        $config['file_name'] = $new_image_name;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('image')) {
            $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                        Səkil yükləndiyi zaman xəta baş verdi </div>');
            redirect('admin/partners');
        }

        $data = array(
            'web_site' => html_escape($this->input->post('web_site')),
            'title' => html_escape($this->input->post('title')),
            'url_image' => $new_image_name,
            'date' => date('Y-m-d H:i:s'),
        );
        $this->admin_model->add_partner($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        Tərəfdaş uğurla əlavə olundu. </div>');
        redirect('admin/partners');
    }else{
        echo "error";
    }
    }

    public function partnersset()
    {
        $this->safety('/partnersset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('id', $id)->update('partners', array('status' => $status));
    }else{
        echo "error";
    }
    }

    public function delete_partner($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_partner/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $image = $this->admin_model->get_partner($id);
        $fileurl = './assets/front/images/' . $image['url_image'];
        unlink($fileurl);  
        $this->admin_model->delete_partner($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Tərəfdaşın silinməsi uğurla icra olundu. </div>');
        redirect('admin/partners');
    }else{
        echo "error";
    }
    }

    public function update_partner($id = '')
    {
        $id=html_escape($id);
        $this->safety('/update_partner/' . $id);
        $data['detail'] = $this->admin_model->get_partner($id);
        $this->load->view('back/partners/edit/home', $data);
    }

    public function updating_partner()
    {
        $this->safety('/updating_partner');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        if (empty($_FILES['image']['name'])) {
            $new_image_name = $this->input->post('image_url');
        } else {

            $new_image_name = time() . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['image']['name']);
            $config['upload_path'] = './assets/front/images/';
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = 10000;
            $config['file_name'] = $new_image_name;
            $config['max_width'] = 1024;
            $config['max_height'] = 768;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $oldimage = $this->input->post('image_url');
                unlink(base_url('assets/front/images/' . $oldimage));
                $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                        Səkil yükləndiyi zaman xəta baş verdi </div>');
                redirect('admin/partners');
            }
        }

        $data = array(
            'web_site' => html_escape($this->input->post('web_site')),
            'title' => html_escape($this->input->post('title')),
            'url_image' => $new_image_name,
            'update_time' => date('Y-m-d H:i:s'),
        );
        $fileurl = './assets/front/images/' . $this->input->post('image_url');
        unlink($fileurl);  
        $id = html_escape($this->input->post('id'));
        $this->admin_model->update_partner($id, $data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        Tərəfdaş uğurla Yeniləndi. </div>');
        redirect('admin/partners');
    }else{
        echo "error";
    }
    }

    /*................................get_slider.......................................*/
    public function sliders()
    {
        $this->safety('/sliders');
        $data['details'] = $this->admin_model->get_sliders();
        $this->load->view('back/slider/home', $data);
    }

    public function slider_add()
    {
        $this->safety('/slider_add');
        $this->load->view('back/slider/add/home');
    }

    public function slider_adding()
    {
        $this->safety('/slider_adding');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'title_az' => html_escape($this->input->post('title_az')),
            'title_en' => html_escape($this->input->post('title_en')),
            'title_ru' => html_escape($this->input->post('title_ru')),
            'url_image_az' => html_escape($this->input->post('url_image_az')),
            'url_image_en' => html_escape($this->input->post('url_image_en')),
            'url_image_ru' => html_escape($this->input->post('url_image_ru')),
            'top' => seflink(html_escape($this->input->post('title_az'))),
            'date' => date('d-m-Y H:i'),
        );
        $this->admin_model->add_slider($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        Slider uğurla əlavə olundu. </div>');
        redirect('admin/sliders');
    }else{
        echo "error";
    }
    }

    public function sliderset()
    {
        $this->safety('/sliderset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('id', $id)->update('sliders', array('status' => $status));
    }else{
        echo "error";
    }
    }

    public function delete_slider($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_slider/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $this->admin_model->delete_slider($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Sliderin silinməsi uğurla icra olundu. </div>');
        redirect('admin/sliders');
    }else{
        echo "error";
    }
    }

    public function update_slider($id = '')
    {
        $id=html_escape($id);
        $this->safety('/update_slider/' . $id);
        $data['detail'] = $this->admin_model->get_slider($id);
        $this->load->view('back/slider/edit/home', $data);
    }

    public function updating_slider()
    {
        $this->safety('/updating_slider');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {

        $data = array(
            'title_az' => html_escape($this->input->post('title_az')),
            'title_en' => html_escape($this->input->post('title_en')),
            'title_ru' => html_escape($this->input->post('title_ru')),
            'url_image_az' => html_escape($this->input->post('url_image_az')),
            'url_image_en' => html_escape($this->input->post('url_image_en')),
            'url_image_ru' => html_escape($this->input->post('url_image_ru')),
            'top' => seflink(html_escape($this->input->post('title_az'))),
            'update_time' => date('Y-m-d H:i:s'),
        );
        $id = html_escape($this->input->post('id'));
        $this->admin_model->update_slider($id, $data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        Slider uğurla Yeniləndi. </div>');
        redirect('admin/sliders');
    }else{
        echo "error";
    }
    }

    /*................................get_SETTİNGS.......................................*/
    public function get_settings()
    {
        $this->safety('/get_settings');
        $data['detail'] = $this->admin_model->get_settings();
        $this->load->view('back/settings/home', $data);
    }

    public function update_settings()
    {
        $this->safety('/update_settings');
        $data['detail'] = $this->admin_model->get_settings();
        $this->load->view('back/settings/edit/home', $data);
    }

    public function updating_settings()
    {
        $this->safety('/updating_settings');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        if (empty($_FILES['image']['name'])) {
            $new_image_name = $this->input->post('logo_url');
        } else {

            $new_image_name = time() . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['image']['name']);
            $config['upload_path'] = './assets/front/images/';
            $config['allowed_types'] = 'jpeg|jpg|png';
            $config['max_size'] = 10000;
            $config['file_name'] = $new_image_name;
            $this->load->library('upload', $config);
            if (!$this->upload->do_upload('image')) {
                $oldimage = $this->input->post('logo_url');
                unlink(base_url('assets/front/images/' . $oldimage));
                $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                        Səkil yükləndiyi zaman xəta baş verdi </div>');
                redirect('admin/get_settings');
            }
        }

        $data = array(
            'adress_az' => html_escape($this->input->post('adress_az')),
            'adress_en' => html_escape($this->input->post('adress_en')),
            'adress_ru' => html_escape($this->input->post('adress_ru')),
            'tel1' => html_escape($this->input->post('tel1')),
            'tel2' => html_escape($this->input->post('tel2')),
            'logo_url' => $new_image_name,
            'mail' => html_escape($this->input->post('mail')),
            'update_time' => date('Y-m-d H:i:s'),

        );

        $this->admin_model->update_site_settings($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        Tənzimləmələr uğurla Yeniləndi. </div>');
        redirect('admin/get_settings');
    }else{
        echo "error";
    }
    }

    /*................................get_news.......................................*/
    public function news()
    {
            $this->safety('/news');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 10;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/news';
            $config['total_rows'] = $this->db->count_all_results('news');
            $data['details']       = $this->db->order_by('id', 'desc')->get('news', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['details']);
            $this->load->view('back/news/home', $data);
    }

    public function news_add()
    {
        $this->safety('/news_add');
        $this->load->view('back/news/add/home');
    }

    public function news_adding()
    {
        $this->safety('/news_adding');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $new_image_name = substr(md5(sha1(time())), 12) . rand(1111, 9999) . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['image']['name']);
        $config['upload_path'] = './assets/front/images/news/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 100000;
        $config['file_name'] = $new_image_name;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image'))
         {
          $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                        Səkil yükləndiyi zaman xəta baş verdi </div>');
            redirect('admin/news'); 
          }
        else
        {
            $image_data =   $this->upload->data();
            $configer =  array(
                    'image_library'   => 'gd2',
                    'source_image'    =>  $image_data['full_path'],
                    'maintain_ratio'  =>  TRUE,
                    'quality'         => '95%', 
                    'width'           =>  688,
                    'height'          =>  459,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
      }

              $add_date      = html_escape($this->input->post('add_date'));
                if (!empty($add_date)) {
                   if (verifyDateFormat($add_date) !== false) {
                       $add_date_  =  $add_date;
                   } else {
                     $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Xəta!</h4>
                         Əlavə olunma tarixi düzgün formatda qeyd edilməyib. </div>');
                      redirect('admin/news');
                   }
                   
                } else {
                   $add_date_ = date("Y-m-d H:i:s");
                }
       

        $data = array(
            'title_az' => html_escape($this->input->post('title_az')),
            'title_en' => html_escape($this->input->post('title_en')),
            'title_ru' => html_escape($this->input->post('title_ru')),
            'top_az' => seflink(html_escape($this->input->post('title_az'))),
            'top_en' => seflink(html_escape($this->input->post('title_en'))),
            'top_ru' => seflink(html_escape($this->input->post('title_ru'))),
            'content_az' => $this->input->post('content_az'),
            'content_en' => $this->input->post('content_en'),
            'content_ru' => $this->input->post('content_ru'),
            'url_image' => $new_image_name,
            'date' => $add_date_,
        );
        $this->admin_model->add_news($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        Xəbər uğurla əlavə olundu. </div>');
        redirect('admin/news');
    }else{
        echo "error";
    }
    }

    public function newsset()
    {
        $this->safety('/newsset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('id', $id)->update('news', array('status' => $status));
    }else{
        echo "error";
    }
    }

    public function delete_news($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_news/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $image = $this->admin_model->get_news_id($id);
        $fileurl = './assets/front/images/news/' . $image['url_image'];
        unlink($fileurl);  
        $this->admin_model->delete_news($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Xəbərin silinməsi uğurla icra olundu. </div>');
        redirect('admin/news');
    }else{
        echo "error";
    }
    }

    public function update_news($id = '')
    {
        $id=html_escape($id);
        $this->safety('/update_news/' . $id);
        $data['detail'] = $this->admin_model->get_news_id($id);
		$data['details'] = $this->admin_model->get_uploaded_file_news($id);
        $this->load->view('back/news/edit/home', $data);
    }

    public function updating_news()
    {
        $this->safety('/updating_news');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        if (empty($_FILES['image']['name'])) {
            $new_image_name = $this->input->post('image_url');
        } else {

        $new_image_name = substr(md5(sha1(time())), 12) . rand(1111, 9999) . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['image']['name']);
        $config['upload_path'] = './assets/front/images/news/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 100000;
        $config['file_name'] = $new_image_name;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image'))
         {
          $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                        Səkil yükləndiyi zaman xəta baş verdi </div>');
            redirect('admin/news'); 
          }
        else
        {
            $fileurl = './assets/front/images/news/' . $this->input->post('image_url');
            unlink($fileurl);  
            $image_data =   $this->upload->data();
            $configer =  array(
                    'image_library'   => 'gd2',
                    'source_image'    =>  $image_data['full_path'],
                    'maintain_ratio'  =>  TRUE,
                    'quality'         => '95%', 
                    'width'           =>  688,
                    'height'          =>  459,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
      }
       
        }
        $add_date      = html_escape($this->input->post('add_date'));
                if (!empty($add_date)) {
                   if (verifyDateFormat($add_date) !== false) {
                       $add_date_  =  $add_date;
                   } else {
                     $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Xəta!</h4>
                         Əlavə olunma tarixi düzgün formatda qeyd edilməyib. </div>');
                      redirect('admin/news');
                   }
                   
                } else {
                   $add_date_ = date("Y-m-d H:i:s");
                }

        $data = array(
            'title_az' => html_escape($this->input->post('title_az')),
            'title_en' => html_escape($this->input->post('title_en')),
            'title_ru' => html_escape($this->input->post('title_ru')),
            'top_az' => seflink(html_escape($this->input->post('title_az'))),
            'top_en' => seflink(html_escape($this->input->post('title_en'))),
            'top_ru' => seflink(html_escape($this->input->post('title_ru'))),
            'content_az' => $this->input->post('content_az'),
            'content_en' => $this->input->post('content_en'),
            'content_ru' => $this->input->post('content_ru'),
            'url_image' => $new_image_name,
            'date' => $add_date_,
            'update_time' => date('Y-m-d H:i:s'),
        );
        $id = html_escape($this->input->post('id'));
        $this->admin_model->update_news($id, $data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        Xəbər uğurla Yeniləndi. </div>');
        redirect('admin/news');
    }else{
        echo "error";
    }
    }

     /*................................Documents.......................................*/
    public function documents()
    {
            $this->safety('/documents');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 10;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/documents';
            $config['total_rows'] = $this->db->count_all_results('documents');
            $data['details']       = $this->db->join('document_categories','documents.doc_category = document_categories.dc_id')->order_by('doc_sort', 'desc')->get('documents', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['details']);
            $this->load->view('back/docs/home', $data);
    }

    public function documents_add()
    {
        $this->safety('/documents_add');
        $data['categories']  = $this->db->where('dc_status','1')->get('document_categories')->result();
        $this->load->view('back/docs/add/home', $data);
    }

    public function documents_adding()
    {
        $this->safety('/documents_adding');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {

       

        $data = array(
            'doc_title_az' => html_escape($this->input->post('title_az')),
            'doc_title_en' => html_escape($this->input->post('title_en')),
            'doc_title_ru' => html_escape($this->input->post('title_ru')),
            'doc_body_az' => $this->input->post('body_az'),
            'doc_body_en' => $this->input->post('body_en'),
            'doc_body_ru' => $this->input->post('body_ru'),
            'doc_status' => 1,
            'doc_category' => html_escape($this->input->post('doc_category')),
            'doc_sort' => html_escape($this->input->post('doc_sort')),
            'doc_createdAt' => date('Y-m-d H:i:s')
        );
        $this->db->insert('documents',$data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        Məlumat uğurla əlavə olundu. </div>');
        redirect('admin/documents');
        

       }else{
        echo "error";
      }
    }

    public function docsset()
    {
        $this->safety('/docsset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('doc_id', $id)->update('documents', array('doc_status' => $status));
    }else{
        echo "error";
    }
    }

    public function delete_documents($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_documents/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $this->db->where('doc_id', $id);
        if ($this->db->delete('documents')) {
           $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Məlumat silinməsi uğurla icra olundu. </div>');
           redirect('admin/documents');
        }
    }else{
        echo "error";
    }
    }

    public function update_documents($id = '')
    {
        $id=html_escape($id);
        $this->safety('/update_documents/' . $id);
        $data['detail'] = $this->db->where('doc_id',$id)->get('documents')->row();
        $data['categories']  = $this->db->where('dc_status','1')->get('document_categories')->result();
        $this->load->view('back/docs/edit/home', $data);
    }

    public function updating_documents()
    {
        $this->safety('/updating_documents');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {


        $data = array(
            'doc_title_az' => html_escape($this->input->post('title_az')),
            'doc_title_en' => html_escape($this->input->post('title_en')),
            'doc_title_ru' => html_escape($this->input->post('title_ru')),
            'doc_body_az' => $this->input->post('body_az'),
            'doc_body_en' => $this->input->post('body_en'),
            'doc_body_ru' => $this->input->post('body_ru'),
            'doc_category' => html_escape($this->input->post('doc_category')),
            'doc_sort' => html_escape($this->input->post('doc_sort')),
        );
        $id = html_escape($this->input->post('id'));
        $this->db->where('doc_id', $id);
        if ($this->db->update('documents', $data)) {
           $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        Məlumat uğurla yeniləndi. </div>');
            redirect('admin/documents');
        }
        
    }else{
        echo "error";
    }
    }

    /*................................get_messages.......................................*/
    public function messages()
    {
            $this->safety('/messages');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 12;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/messages';
            $config['total_rows'] = $this->db->count_all_results('messages');
            $data['details']       = $this->db->order_by('id','desc')->get('messages', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['details']);
            $this->load->view('back/message/home', $data);
    }

    public function delete_message($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_message/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $this->admin_model->delete_message($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Mesajin silinməsi uğurla icra olundu. </div>');
        redirect('admin/messages');
    }else{
        echo "error";
    }
    }

    public function read_message($id = '')
    {
        $id=html_escape($id);
        $this->safety('/read_message/' . $id);
        $data['detail'] = $this->admin_model->get_message($id);
        $this->load->view('back/message/read/home', $data);
    }

    /*................................site_translation.......................................*/
    public function site_translation()
    {
            $this->safety('/site_translation');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 10;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/site_translation';
            $config['total_rows'] = $this->db->count_all_results('site_language');
            $data['details']       = $this->db->order_by('word_id', 'desc')->get('site_language', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['details']);
            $this->load->view('back/translate/home', $data);
    }

    public function update_site_translation($id = '')
    {
        $id=html_escape($id);
        $this->safety('/update_site_translation/' . $id);
        if ($id) {
            $data['detail'] = $this->admin_model->get_translate_by_id($id);
            $this->load->view('back/translate/edit/home', $data);
        } else {

            redirect('admin/site_translation');
        }

    }

    public function delete_site_translation($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_site_translation/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        if ($id) {
            $this->admin_model->delete_site_translation($id);
            $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Tərcümənin silinməsi uğurla icra olundu. </div>');
            redirect('admin/site_translation');
        } else {

            redirect('admin/site_translation');
        }
     }else{
    echo "error";
       }
    }

    public function updating_site_translation()
    {
        $this->safety('/updating_site_translation');
         $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'Azerbaijan' => html_escape($this->input->post('az')),
            'English' => html_escape($this->input->post('en')),
            'Russian' => html_escape($this->input->post('ru')),
            'updated_at' => date('Y-m-d H:i:s'),

        );
        $id = html_escape($this->input->post('id'));
        $this->admin_model->update_site_translation($id, $data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        Tərcümə uğurla Yeniləndi. </div>');
        redirect('admin/site_translation');
    }else
    {
        echo "error";
    }
    }

    /*................................get_categories.......................................*/
    public function project_categories()
    {
        $this->safety('/project_categories');
        $data['details'] = $this->admin_model->get_categories();
        $this->load->view('back/categories/home', $data);
    }

    public function update_project_category($id = '')
    {
        $id=html_escape($id);
        $this->safety('/update_project_category/' . $id);
        $data['detail'] = $this->admin_model->get_category($id);
        $this->load->view('back/categories/edit/home', $data);
    }

    public function updating_project_category()
    {
        $this->safety('/updating_project_category');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'kat_adi_az' => html_escape($this->input->post('kat_adi_az')),
            'kat_adi_en' => html_escape($this->input->post('kat_adi_en')),
            'kat_adi_ru' => html_escape($this->input->post('kat_adi_ru')),
            'update_time' => date('Y-m-d H:i:s'),

        );
        $id = html_escape($this->input->post('kat_id'));
        $this->admin_model->update_category($id, $data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        Kateqoriya uğurla Yeniləndi. </div>');
        redirect('admin/project_categories');
    }else{
        echo "error";
    }
    }

    public function project_categoryset()
    {
        $this->safety('/project_categoryset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('kat_id', $id)->update('categories', array('status' => $status));
    }else{
        echo "error";
    }
    }

    ///////////////////////////////////////////////uploads////////////////////////////////////////////////
    public function uploadedfiles()
    {
            $this->safety('/uploadedfiles');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 12;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/uploadedfiles';
            $config['total_rows'] = $this->db->count_all_results('news');
            $data['details']       = $this->db->order_by('id', 'desc')->get('uploads', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['details']);
            $this->load->view('back/uploads/home', $data);
    }

    public function uploadfile()
    {
        $this->safety('/uploadfile');
        $this->load->view('back/uploads/add/home');
    }

    public function delete_file($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_file/' . $id);
         $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $file = $this->admin_model->get_uploaded_file($id);
        
        $fileurl = './assets/front/images/uploads/' . $file['file_url'];
        unlink($fileurl);  
        $this->admin_model->delete_file($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Fayl uğurla Silindi. </div>');
        redirect('admin/uploadedfiles');
    }else{
        echo "error";
    }
    }

    public function doupload()
    {
        $this->safety('/doupload');
		$token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $new_file_name = time() . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['file']['name']);
        $config['upload_path'] = './assets/front/images/uploads/';
        $config['allowed_types'] = 'jpeg|jpg|png|pdf|zip|doc|docx|xls|xlsx';
        $config['max_size'] = 10000000;
        $config['file_name'] = $new_file_name;
		
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('file')) {
            $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                        Fayl yükləndiyi zaman xəta baş verdi </div>');
            redirect('admin/uploadedfiles');
        }
        $data = array(

            'file_url' => $new_file_name,
            'date' => date('d-m-Y H:i'),
        );
        $this->admin_model->uploadfiles($data);
		
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        Fayl uğurla əlavə olundu. </div>');
        redirect('admin/uploadedfiles');
    }else{
        echo "error";
    }
    }
	
	// ######## - Xəbərlər üçün şəkillərin əlavə olunması - ########
	public function upload_news_image($id = '')
    {
        $id=html_escape($id);
        $this->safety('/upload_news_image/' . $id);
        $data['detail'] = $this->admin_model->get_news_id($id);
		$data['details'] = $this->admin_model->get_uploaded_file_news($id);
        $this->load->view('back/news/add_images/home', $data);
    }
	
	public function uploading_news_image()
    {
		$this->safety('/uploading_news_image');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
		$news_id = html_escape($this->input->post('news_id'));
		$new_file_name = substr(md5(sha1(time())), 12) . rand(1111, 9999) . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['file']['name']);
        $config['upload_path'] = './assets/front/images/news/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 100000;
        $config['file_name'] = $new_file_name;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('file'))
         {
          $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                        Səkil yükləndiyi zaman xəta baş verdi </div>');
            redirect('admin/news'); 
          }
        else
        {
            $image_data =   $this->upload->data();
            $configer =  array(
                    'image_library'   => 'gd2',
                    'source_image'    =>  $image_data['full_path'],
                    'maintain_ratio'  =>  TRUE,
                    'quality'         => '95%', 
                    'width'           =>  688,
                    'height'          =>  459,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
            $data = array(
                "news_id" => $news_id,
                "file_url" => $new_file_name,
                'date' => date('d-m-Y H:i'),
            );
            $insert = $this->db->insert("uploads", $data);
            //redirect('admin/upload_news_image'.$news_id);
      }
  }else{
    echo "error";
  }
		
    }
	
	public function delete_news_image($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_news_image/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $file = $this->admin_model->get_uploaded_file($id);
        $filepath = './assets/front/images/news/'.$file['file_url'];
        unlink($filepath);
        $this->admin_model->delete_file($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Fayl uğurla silindi. </div>');
        redirect('admin/upload_news_image/'.$file['news_id']);
    }else{
        echo "error";
    }
    }

    /*................................get_companies.......................................*/
    public function companies()
    {
            $this->safety('/companies');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 12;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/companies';
            $config['total_rows'] = $this->db->count_all_results('companies');
            $data['details']       = $this->db->order_by('id', 'desc')->get('companies', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['details']);
            $this->load->view('back/company/home', $data);
    }

    public function company_add()
    {
        $this->safety('/company_add');
        $this->load->view('back/company/add/home');
    }

    public function company_adding()
    {
        $this->safety('/company_adding');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'name' => html_escape($this->input->post('name')),
            'link_id' => html_escape($this->input->post('link_id')),
            'address' => html_escape($this->input->post('address')),
            'lat' => html_escape($this->input->post('lat')),
            'lng' => html_escape($this->input->post('lng'))
        );
        $this->admin_model->add_company($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        uğurla əlavə olundu. </div>');
        redirect('admin/companies');
    }else{
        echo "error";
    }
    }

    public function delete_company($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_company/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $this->admin_model->delete_company($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        uğurla icra olundu. </div>');
        redirect('admin/companies');
    }else{
        echo "error";
    }
    }

    public function companyset()
    {
        $this->safety('/companyset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('id', $id)->update('companies', array('status' => $status));
    }else{
        echo "error";
    }
    }

    public function update_company($id = '')
    {
        $id=html_escape($id);
        $this->safety('/update_company/' . $id);
        $data['detail'] = $this->admin_model->get_company($id);
        $this->load->view('back/company/edit/home', $data);
    }

    public function updating_company()
    {
        $this->safety('/updating_company');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'name' => html_escape($this->input->post('name')),
            'link_id' => html_escape($this->input->post('link_id')),
            'address' => html_escape($this->input->post('address')),
            'lat' => html_escape($this->input->post('lat')),
            'update_time' => date('Y-m-d H:i:s'),
            'lng' => html_escape($this->input->post('lng'))
        );
        $id = html_escape($this->input->post('id'));
        $this->admin_model->update_company($id, $data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                         uğurla Yeniləndi. </div>');
        redirect('admin/companies');
    }else{
        echo "error";
    }
    }

    /*................................get_sectors.......................................*/
    public function sectors()
    {
        $this->safety('/sectors');
        $data['details'] = $this->admin_model->get_sectors();
        $this->load->view('back/sectors/home', $data);
    }

    public function sector_add()
    {
        $this->safety('/sector_add');
        $this->load->view('back/sectors/add/home');
    }

    public function sector_adding()
    {
        $this->safety('/sector_adding');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'sek_adi_az' => html_escape($this->input->post('sek_adi_az')),
            'sek_adi_en' => html_escape($this->input->post('sek_adi_en')),
            'sek_adi_ru' => html_escape($this->input->post('sek_adi_ru')),
            'sek_link' => seflink(html_escape($this->input->post('sek_adi_az')))
        );
        $this->admin_model->add_sector($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        uğurla əlavə olundu. </div>');
        redirect('admin/sectors');
    }else{
        echo "error";
    }
    }

    public function delete_sector($id = '')
    {
        $id=html_escape($id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $this->safety('/delete_sector/' . $id);
        $this->admin_model->delete_sector($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        uğurla icra olundu. </div>');
        redirect('admin/sectors');
    }else
    {
        echo "error";
    }
    }

    public function update_sector($id = '')
    {
        $id=html_escape($id);
        $this->safety('/update_sector/' . $id);
        $data['detail'] = $this->admin_model->get_sector($id);
        $this->load->view('back/sectors/edit/home', $data);
    }

    public function updating_sector()
    {
        $this->safety('/updating_sector');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'sek_adi_az' => html_escape($this->input->post('sek_adi_az')),
            'sek_adi_en' => html_escape($this->input->post('sek_adi_en')),
            'sek_adi_ru' => html_escape($this->input->post('sek_adi_ru')),
            'sek_link' => seflink(html_escape($this->input->post('sek_adi_az'))),
            'update_time' => date('Y-m-d H:i:s')
        );
        $id = html_escape($this->input->post('id'));
        $this->admin_model->update_sector($id, $data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                         uğurla Yeniləndi. </div>');
        redirect('admin/sectors');
    }else{
        echo "error";
    }
    }

    public function sectorset()
    {
        $this->safety('/sectorset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('sek_id', $id)->update('sectors', array('status' => $status));
    }else{
        echo "error";
    }
    }

    /*...............................terms_of_use..............................*/
    public function updatetermsofuse()
    {
        $this->safety('/updatetermsofuse');
        $data['detail'] = $this->admin_model->termsofuse();
        $this->load->view('back/termsofuse/home', $data);
    }

    public function updatingtermsofuse()
    {
        $this->safety('/updatingtermsofuse');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'content_az' => $this->input->post('content_az'),
            'content_en' => $this->input->post('content_en'),
            'content_ru' => $this->input->post('content_ru'),
            'update_time' => date('Y-m-d H:i:s')
        );
        $this->admin_model->updatetermsofuse($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                         uğurla Yeniləndi. </div>');
        redirect('admin/updatetermsofuse');
    }else{
        echo "error";
    }
    }

    /*...............................Xidmətlər..............................*/
    public function updateservices()
    {
        $this->safety('/updateservices');
        $data['detail'] = $this->admin_model->services();
        $this->load->view('back/services/home', $data);
    }

    public function updateingservices()
    {
        $this->safety('/updateingservices');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'content_az' => $this->input->post('content_az'),
            'content_en' => $this->input->post('content_en'),
            'content_ru' => $this->input->post('content_ru'),
            'update_time' => date('Y-m-d H:i:s')
        );
        $this->admin_model->updateservices($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                         uğurla Yeniləndi. </div>');
        redirect('admin/updateservices');
    }else{
        echo "error";
    }
    }

    /*...............................privacy..............................*/
    public function updateprivacy()
    {
        $this->safety('/updateprivacy');
        $data['detail'] = $this->admin_model->privacy();
        $this->load->view('back/privacy/home', $data);
    }

    public function updatingprivacy()
    {
        $this->safety('/updatingprivacy');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'content_az' => $this->input->post('content_az'),
            'content_en' => $this->input->post('content_en'),
            'content_ru' => $this->input->post('content_ru'),
            'update_time' => date('Y-m-d H:i:s')
        );
        $this->admin_model->updateprivacy($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                         uğurla Yeniləndi. </div>');
        redirect('admin/updateprivacy');
    }else{
        echo "error";
    }
    }


     /*................................get_video.......................................*/
    public function video()
    {
            $this->safety('/video');
            $page       = html_escape($this->input->get('page'));
            $rowperpage = 12;
            if ($page != 0) {
                $page = ($page - 1) * $rowperpage;
            }
            $config['per_page']   = $rowperpage;
            $config['base_url']   = base_url() . 'admin/video';
            $config['total_rows'] = $this->db->count_all_results('video');
            $data['rows']       = $this->db->order_by('v_id', 'desc')->get('video', $config['per_page'], $page)->result_array();
            
            $config['use_page_numbers']  = true;
            $config["page_query_string"] = true;
            $config['full_tag_open']     = '<ul class="pagination mg-b-0 page-0 ">';
            $config['full_tag_close']    = '</ul>';
            $config['first_link']        = '<<';
            $config['first_tag_open']    = '<li class="page-item">';
            $config['first_tag_close']   = '</li>';
            $config['last_link']         = '>>';
            $config['last_tag_open']     = '<li class="page-item">';
            $config['last_tag_close']    = '</li>';
            $config['next_link']         = '>';
            $config['next_tag_open']     = '<li class="page-item">';
            $config['next_tag_close']    = '</li>';
            $config['prev_link']         = '<';
            $config['prev_tag_open']     = '<li class="page-item">';
            $config['prev_tag_close']    = '</li>';
            $config['cur_tag_open']      = '<li class="page-item active"><a class="page-link">';
            $config['cur_tag_close']     = '</a></li>';
            $config['num_tag_open']      = '<li class="page-item">';
            $config['num_tag_close']     = '</li>';
            $this->pagination->initialize($config);
            $data['pagination']   = $this->pagination->create_links();
            $data['result_count'] = resultCountPagenation($page, $config['per_page'], $config['total_rows'], $data['rows']);
            $this->load->view('back/video/home', $data);
    }


    public function video_add()
    {
        $this->safety('/video_add');
        $this->load->view('back/video/add/home');
    }

    public function video_adding()
    {
        $this->safety('/video_adding');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $cover = $this->admin_model->upload_image('file','assets/front/images/video','800');
        if (!$cover)
          {
              $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                            Səkil yükləndiyi zaman xəta baş verdi </div>');
                redirect('admin/video'); 
          }

               $add_date      = html_escape($this->input->post('add_date'));
                if (!empty($add_date)) {
                   if (verifyDateFormat($add_date) !== false) {
                       $add_date_  =  $add_date;
                   } else {
                     $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Xəta!</h4>
                         Əlavə olunma tarixi düzgün formatda qeyd edilməyib. </div>');
                      redirect('admin/video');
                   }
                   
                } else {
                   $add_date_ = date("Y-m-d H:i:s");
                }
       

        $data = array(
            'v_title_az'  => html_escape($this->input->post('title_az')),
            'v_title_en'  => html_escape($this->input->post('title_en')),
            'v_title_ru'  => html_escape($this->input->post('title_ru')),
            'v_video_url' => generateVideoEmbedUrl(html_escape($this->input->post('video_url'))),
            'v_cover'     => $cover,
            'v_createdAt' => $add_date_,
        );

        $this->admin_model->add_video($data);

        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        Xəbər uğurla əlavə olundu. </div>');

        redirect('admin/video');

      }else{
          echo "error";
      }
    }

    public function videoset()
    {
        $this->safety('/videoset');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('v_id', $id)->update('video', array('v_status' => $status));
    }else{
        echo "error";
    }
    }

    public function delete_video($id = '')
    {
        $id=html_escape($id);
        $this->safety('/delete_video/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $video = $this->admin_model->get_video_id($id);
        $fileurl = './' . $video['v_cover'];
        if (file_exists($fileurl)) {
             unlink($fileurl);  
        }
        $this->admin_model->delete_video($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        Videonun silinməsi uğurla icra olundu. </div>');
        redirect('admin/video');
    }else{
        echo "Token error";
        exit();
    }
    }

    public function update_video($id = '')
    {
        $id=html_escape($id);
        $this->safety('/update_video/' . $id);
        $data['detail'] = $this->admin_model->get_video_id($id);
        $this->load->view('back/video/edit/home', $data);
    }

    public function updating_video($id = '')
    {
        $this->safety('/updating_video');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = (int) $id;
        $video_data = $this->db->where('v_id', html_escape($id))->get('video')->row();

        if (!empty($video_data)) {

        $vb_url = html_escape($this->input->post('video_url'));
        if (empty($vb_url)) {
            $vb_url = $video_data->v_video_url;
         } else {
            $vb_url = generateVideoEmbedUrl(html_escape($this->input->post('video_url')));
        }

        $add_date = html_escape($this->input->post('add_date'));
         if (!empty($add_date)) {
             if (verifyDateFormat($add_date) !== false) {
                $add_date_  =  $add_date;
             } else {
                $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Tarix formatı düzgün deyil!</h4></div>');
                redirect('admin/update_video/'.$id);
            }
                       
        } else {
             $add_date_ = date("Y-m-d H:i:s");
        }
        
        if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
           $cover = $this->admin_model->upload_image('file','assets/front/images/video','800');
           if (!$cover){
                $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                                Səkil yükləndiyi zaman xəta baş verdi </div>');
                redirect('admin/update_video/'.$id);
            }

           if (file_exists('./'.$video_data->v_cover)) {
                   unlink('./'.$video_data->v_cover);
            }
        }else{

            $cover = $video_data->v_cover;

        }

       $db_data = array(
            'v_title_az'  => html_escape($this->input->post('title_az')),
            'v_title_en'  => html_escape($this->input->post('title_en')),
            'v_title_ru'  => html_escape($this->input->post('title_ru')),
            'v_video_url' => $vb_url,
            'v_cover'     => $cover,
            'v_createdAt' => $add_date_,
            'v_updatedAt' => date('Y-m-d H:i:s'),
        );
        $this->admin_model->update_video($id, $db_data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        Video uğurla yeniləndi. </div>');
        redirect('admin/update_video/'.$id);
           
        } else {
           $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Tapılmadı!</h4>
                        Məlumatlar Tapılmadı. </div>');
           redirect('admin/video');
        }           
        
       }else{
        echo "Token error";
        exit();
       }
    }

   /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
    /*...............................crowdfounding..............................*/
    /*...............................cf_categories..............................*/
    public function cfcategories()
    {
        $this->safety('/cfcategories');
        $data['details'] = $this->admin_model->get_cfcategories();
        $this->load->view('back/cfcategory/home', $data);
    }

    public function addcfcategory()
    {
        $this->safety('/addcfcategory');
        $this->load->view('back/cfcategory/add/home');
    }

    public function addingcfcategory()
    {
        $this->safety('/addingcfcategory');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'title_az' => html_escape($this->input->post('title_az')),
            'title_en' => html_escape($this->input->post('title_en')),
            'title_ru' => html_escape($this->input->post('title_ru')),
            'link' => seflink(html_escape($this->input->post('title_az')))
        );
        $this->admin_model->add_cfcategory($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        uğurla əlavə olundu. </div>');
        redirect('admin/cfcategories');
    }else{
        echo "error";
    }
    }

    public function deletecfcategory($id = '')
    {
        $id=html_escape($id);
        $this->safety('/deletecfcategory/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $this->admin_model->delete_cfcategory($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        uğurla icra olundu. </div>');
        redirect('admin/cfcategories');
    }else{
        echo "error";
    }
    }

    public function updatecfcategory($id = '')
    {
        $id=html_escape($id);
        $this->safety('/updatecfcategory/' . $id);
        $data['detail'] = $this->admin_model->get_cfcategory($id);
        $this->load->view('back/cfcategory/edit/home', $data);
    }

    public function updatingcfcategory()
    {
        $this->safety('/updatingcfcategory');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'title_az' => html_escape($this->input->post('title_az')),
            'title_en' => html_escape($this->input->post('title_en')),
            'title_ru' => html_escape($this->input->post('title_ru')),
            'update_time' => date('Y-m-d H:i:s'),
            'link' => seflink(html_escape($this->input->post('title_az')))
        );
        $id = html_escape($this->input->post('id'));
        $this->admin_model->update_cfcategory($id, $data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                         uğurla Yeniləndi. </div>');
        redirect('admin/cfcategories');
    }else{
        echo "error";
    }
    }

    public function setcfcategory()
    {
        $this->safety('/setcfcategory');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('id', $id)->update('cf_categories', array('status' => $status));
    }else{
        echo "error";
    }
    }

    /*...............................cf_projects.............................*/
    public function cfprojects()
    {
        $this->safety('/cfprojects');
        $data['details'] = $this->admin_model->get_cfprojects();
        $this->load->view('back/cfproject/home', $data);
    }

    public function setcfproject()
    {
        $this->safety('/setcfproject');
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $id = html_escape($this->input->post('id'));
        $status = ($this->input->post('status') == 'true') ? 1 : 0;
        $this->db->where('id', $id)->update('cf_projects', array('status' => $status));
    }else{
        echo "error";
    }
    }

    public function addcfproject()
    {
        $this->safety('/addcfproject');
        $this->load->view('back/cfproject/add/home');
    }

    public function addingcfproject()
    {
        $this->safety('/addingcfproject');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        if (empty($_FILES['image']['name'])) {
            $new_image_name = 'noimage.jpg';
        } else {

         $new_image_name = substr(md5(sha1(time())), 12) . rand(1111, 9999) . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['image']['name']);
        $config['upload_path'] = './cf_images/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 100000;
        $config['file_name'] = $new_image_name;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image'))
         {
          $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                        Səkil yükləndiyi zaman xəta baş verdi </div>');
            redirect('admin/addcfproject'); 
          }
        else
        {
            $image_data =   $this->upload->data();
            $configer =  array(
                    'image_library'   => 'gd2',
                    'source_image'    =>  $image_data['full_path'],
                    'maintain_ratio'  =>  TRUE,
                    'quality'         => '95%', 
                    'width'           =>  688,
                    'height'          =>  459,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
      }
  }
        
        $project = array(
            'price' => html_escape($this->input->post('price')),
            'image' => $new_image_name,
            'region_id' => html_escape($this->input->post('region_id')),
            'category_id' => html_escape($this->input->post('category_id')),
            'end_time' => html_escape($this->input->post('end_time')),
            'create_time' => date('Y-m-d'),
            'link' => seflink(html_escape($this->input->post('title_az')))
        );
        $projectid = $this->admin_model->add_cfproject($project);
        $project_translation_az = array(
            'project_id' => $projectid,
            'title' => $this->input->post('title_az'),
            'about' => $this->input->post('about_az'),
            'description' => $this->input->post('description_az'),
            'address' => $this->input->post('address_az'),
            'lang_code' => 'az'
        );
        $this->admin_model->add_cfproject_translation($project_translation_az);
        $project_translation_en = array(
            'project_id' => $projectid,
            'title' => $this->input->post('title_en'),
            'about' => $this->input->post('about_en'),
            'description' => $this->input->post('description_en'),
            'address' => $this->input->post('address_en'),
            'lang_code' => 'en'
        );
        $this->admin_model->add_cfproject_translation($project_translation_en);
        $project_translation_ru = array(
            'project_id' => $projectid,
            'title' => $this->input->post('title_ru'),
            'about' => $this->input->post('about_ru'),
            'description' => $this->input->post('description_ru'),
            'address' => $this->input->post('address_ru'),
            'lang_code' => 'ru'
        );
        $this->admin_model->add_cfproject_translation($project_translation_ru);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Əlavə Edildi!</h4>
                        uğurla əlavə olundu. </div>');
        redirect('admin/cfprojects');
    }else{
        echo "error";
    }
    }

    public function updatecfproject($id = '')
    {
        $id=html_escape($id);
        $this->safety('/updatecfproject/' . $id);
        $data['detail'] = $this->admin_model->get_cfproject($id);
        $this->load->view('back/cfproject/edit/home', $data);
    }

    public function updatingcfproject()
    {
        $this->safety('/updatingcfproject');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $project_id = $this->input->post('project_id');
        if (empty($_FILES['image']['name'])) {
            $new_image_name = $this->input->post('current_image');
        } else {
            if ($this->input->post('current_image') !== 'noimage.jpg') {
                $filepath = './cf_images/' . $this->input->post('current_image');
                unlink($filepath);
            }

        $new_image_name = substr(md5(sha1(time())), 12) . rand(1111, 9999) . str_replace(str_split(' ()\\/,:*?"<>|'), '', $_FILES['image']['name']);
        $config['upload_path'] = './cf_images/';
        $config['allowed_types'] = 'gif|jpg|jpeg|png';
        $config['max_size'] = 100000;
        $config['file_name'] = $new_image_name;
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('image'))
         {
          $this->session->set_flashdata('update_datatable', '<div class="alert alert-danger text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-ban"></i> Xəta!</h4>
                        Səkil yükləndiyi zaman xəta baş verdi </div>');
            redirect('admin/addcfproject'); 
          }
        else
        {
            $image_data =   $this->upload->data();
            $configer =  array(
                    'image_library'   => 'gd2',
                    'source_image'    =>  $image_data['full_path'],
                    'maintain_ratio'  =>  TRUE,
                    'quality'         => '95%', 
                    'width'           =>  688,
                    'height'          =>  459,
            );
            $this->image_lib->clear();
            $this->image_lib->initialize($configer);
            $this->image_lib->resize();
      }
        }
        $project = array(
            'price' => html_escape($this->input->post('price')),
            'image' => $new_image_name,
            'region_id' => html_escape($this->input->post('region_id')),
            'category_id' => html_escape($this->input->post('category_id')),
            'end_time' => html_escape($this->input->post('end_time')),
            'update_time' => date('Y-m-d H:i:s'),
            'link' => seflink(html_escape($this->input->post('title_az')))
        );
        $this->admin_model->update_cfproject($project_id, $project);
        $this->admin_model->delete_cfproject_translations($project_id);
        $project_translation_az = array(
            'project_id' => $project_id,
            'title' => $this->input->post('title_az'),
            'about' => $this->input->post('about_az'),
            'description' => $this->input->post('description_az'),
            'address' => $this->input->post('address_az'),
            'lang_code' => 'az'
        );
        $this->admin_model->add_cfproject_translation($project_translation_az);
        $project_translation_en = array(
            'project_id' => $project_id,
            'title' => $this->input->post('title_en'),
            'about' => $this->input->post('about_en'),
            'description' => $this->input->post('description_en'),
            'address' => $this->input->post('address_en'),
            'lang_code' => 'en'
        );
        $this->admin_model->add_cfproject_translation($project_translation_en);
        $project_translation_ru = array(
            'project_id' => $project_id,
            'title' => $this->input->post('title_ru'),
            'about' => $this->input->post('about_ru'),
            'description' => $this->input->post('description_ru'),
            'address' => $this->input->post('address_ru'),
            'lang_code' => 'ru'
        );
        $this->admin_model->add_cfproject_translation($project_translation_ru);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                        uğurla yeniləndi. </div>');
        redirect('admin/cfprojects');
    }else{
        echo "error";
    }
    }

    public function deletecfproject($id = '')
    {
        $id=html_escape($id);
        $this->safety('/deletecfproject/' . $id);
        $token=html_escape($this->input->get('token'));
        if ($token && $token!='' && checkToken($token)) {
        $image = cfproject_image($id);
        $filepath = './cf_images/' . $image['image'];
        unlink($filepath);
        $this->admin_model->delete_cfproject($id);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Silindi!</h4>
                        uğurla silindi. </div>');
        redirect('admin/cfprojects');
    }else{
        echo "error";
    }
    }

    /*...............................logins.............................*/
    public function getlogins()
    {
        $this->safety('/getlogins');
        $data['details'] = $this->admin_model->get_logins();
        $this->load->view('back/logins/home', $data);
    }

    /*...............................logs.............................*/
    public function getlogs()
    {
        $this->safety('/getlogs');
        $data['details'] = $this->admin_model->get_logs();
        $this->load->view('back/logs/home', $data);
    }

    /*...............................cf_about..............................*/

    public function updatecfabout()
    {
        $this->safety('/updatecfabout');
        $data['detail'] = $this->admin_model->get_cfabout();
        $this->load->view('back/cfabout/edit/home', $data);
    }

    public function updatingcfabout()
    {
        $this->safety('/updatingcfabout');
        $token=html_escape($this->input->post('token'));
        if ($token && $token!='' && checkToken($token)) {
        $data = array(
            'content_az' => $this->input->post('content_az'),
            'content_en' => $this->input->post('content_en'),
            'content_ru' => $this->input->post('content_ru'),
            'update_time' => date('Y-m-d H:i:s')

        );

        $this->admin_model->update_cfabout($data);
        $this->session->set_flashdata('update_datatable', '<div class="alert alert-success text-center alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-check"></i> Yeniləndi!</h4>
                         uğurla Yeniləndi. </div>');
        redirect('admin/updatecfabout');
    }else{
        echo "error";
    }
    }

}         

