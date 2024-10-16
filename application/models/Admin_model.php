<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model
{

    function control($login, $password)
    {

        $result = $this->db->select('*')->from('adminstrator')
            ->where('adminlogname', $login)->where('password', sha1(md5($password)))
            ->get()->row_array();//Result-a tapdığı row-u yazir

        return $result;
    }

    function lastlogin($id, $data = array())
    {

        $result = $this->db->where('id', $id)->update('adminstrator', $data);
        return $result;
    }

    function add_admin_logs($url = '')
    {

        $browser = $this->agent->browser();
        $browserVersion = $this->agent->version();
        $platform = $this->agent->platform();

        $data = array(
            'url' => $url,
            'ip' => $this->input->ip_address(),
            'browser' => $browser . ' | ' . $browserVersion . ' | ' . $platform
        );
        $this->db->insert('admin_logs', $data);
    }

    function add_admin_logins($username = '', $password = '')
    {

        $client_ip = $this->input->ip_address();
        $browser = $this->agent->browser();
        $browserVersion = $this->agent->version();
        $platform = $this->agent->platform();

        $data = array(
            'username' => $username,
            'password' => $password,
            'ip' => $client_ip,
            'browser' => $browser . ' | ' . $browserVersion . ' | ' . $platform
        );
        $this->db->insert('admin_logins', $data);
    }

    function update_password($password)
    {

        $id = $this->session->userdata('admin_user_id');
        $this->db->set('password', $password);
        $this->db->where('id', $id);
        $this->db->update('adminstrator');
    }

    function get_admin_details()
    {

        $id = $this->session->userdata('admin_user_id');
        $this->db->select('*');
        $this->db->from('adminstrator');
        $this->db->where('id', $id);

        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////
    function get_users()
    {

        $this->db->select('*');
        $this->db->from('users');
        $this->db->order_by('id', 'desc');

        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_all_projects($per_page = '', $page = '')
    {

        $this->db->select('projects.project_id');
        $this->db->select('projects.isActive');
        $this->db->select('projects.add_date');
        $this->db->select('users.user_name');
        $this->db->select('users.user_surname');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.project_description');
        $this->db->select('categories.kat_adi_az');
        $this->db->from('projects');

        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('users', 'projects.user_id = users.id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');

        $this->db->where('language.code', 'az');
        $this->db->order_by('projects.project_id', 'desc');
        $this->db->limit($per_page, $page);
        $query = $this->db->get();
        return $query->result_array();

    }

    function get_allcfwant_projects()
    {
        $this->db->select('projects.project_id');
        $this->db->select('projects.isActive');
        $this->db->select('projects.add_date');
        $this->db->select('users.user_name');
        $this->db->select('users.user_surname');
        $this->db->select('project_translation.project_title');
        $this->db->select('project_translation.project_description');
        $this->db->select('categories.kat_adi_az');
        $this->db->from('projects');

        $this->db->join('project_translation', 'projects.project_id = project_translation.project_id');
        $this->db->join('users', 'projects.user_id = users.id');
        $this->db->join('categories', 'categories.kat_id = projects.kat_id');
        $this->db->join('language', 'project_translation.lang_code = language.code');

        $this->db->where('language.code', 'az');
        $this->db->where('projects.cf_status', 1);
        $this->db->order_by('projects.project_id', 'desc');
        $query = $this->db->get();

        return $query->result_array();

    }

    function get_user_data($id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function update_user($user_id, $user_data)
    {
        $this->db->where('id', $user_id);
        $this->db->update('users', $user_data);
    }

    function delete_user($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('users');
    }

    /*................................about_content.......................................*/
    function get_about_contet()
    {
        $this->db->select('*');
        $this->db->from('about_us');
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function update_about_contet($data)
    {
        $this->db->update('about_us', $data);
    }

    /*................................subcribers.......................................*/
    function get_subcribers()
    {
        $this->db->select('*');
        $this->db->from('subcribers');
        $this->db->order_by('id', 'desc');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_subcribers_email()
    {
        $this->db->select('email');
        $this->db->from('subcribers');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function delete_subcriber($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('subcribers');
    }

    /*................................partners.......................................*/
    function get_partners()
    {
        $this->db->select('*');
        $this->db->from('partners');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_partner($id)
    {
        $this->db->select('*');
        $this->db->from('partners');
        $this->db->where('id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function add_partner($data)
    {
        $this->db->insert('partners', $data);
    }

    function delete_partner($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('partners');
    }

    function update_partner($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('partners', $data);
    }

    /*................................slider.......................................*/
    function get_sliders()
    {
        $this->db->select('*');
        $this->db->from('sliders');
        $this->db->order_by('id', 'desc');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_slider($id)
    {
        $this->db->select('*');
        $this->db->from('sliders');
        $this->db->where('id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function add_slider($data)
    {
        $this->db->insert('sliders', $data);
    }

    function delete_slider($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('sliders');
    }

    function update_slider($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('sliders', $data);
    }

    /*................................company.......................................*/
    function get_companies()
    {
        $this->db->select('*');
        $this->db->from('companies');
        $this->db->order_by('id', 'desc');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_company($id)
    {
        $this->db->select('*');
        $this->db->from('companies');
        $this->db->where('id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function add_company($data)
    {
        $this->db->insert('companies', $data);
    }

    function delete_company($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('companies');
    }

    function update_company($id, $data)
    {
        $this->db->where('id', $id);
        $this->db->update('companies', $data);
    }

    /*................................sector.......................................*/
    function get_sectors()
    {
        $this->db->select('*');
        $this->db->from('sectors');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_sector($id)
    {
        $this->db->select('*');
        $this->db->from('sectors');
        $this->db->where('sek_id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function add_sector($data)
    {
        $this->db->insert('sectors', $data);
    }

    function delete_sector($id)
    {
        $this->db->where('sek_id', $id);
        $this->db->delete('sectors');
    }

    function update_sector($id, $data)
    {
        $this->db->where('sek_id', $id);
        $this->db->update('sectors', $data);
    }

    /*................................site_settings.......................................*/
    function get_settings()
    {
        $this->db->select('*');
        $this->db->from('site_settings');
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function update_site_settings($data)
    {
        $this->db->update('site_settings', $data);
    }

    /*................................news.......................................*/
    function get_news()
    {
        $this->db->select('*');
        $this->db->from('news');
        $this->db->order_by('id', 'desc');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_news_id($id)
    {
        $this->db->select('*');
        $this->db->from('news');
        $this->db->where('id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function add_news($data)
    {
        $this->db->insert('news', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function delete_news($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('news');
    }

    function update_news($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('news', $data);
    }

     /*................................video.......................................*/
    function get_video()
    {
        $this->db->select('*');
        $this->db->from('video');
        $this->db->order_by('v_id', 'desc');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_video_id($id)
    {
        $this->db->select('*');
        $this->db->from('video');
        $this->db->where('v_id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function add_video($data)
    {
        $this->db->insert('video', $data);
        $insert_id = $this->db->insert_id();
        return  $insert_id;
    }

    function delete_video($id)
    {
        $this->db->where('v_id', $id);
        $this->db->delete('video');
    }

    function update_video($id, $data)
    {
        $this->db->where('v_id', $id);
        return $this->db->update('video', $data);
    }


    /*................................message.......................................*/
    function get_messages()
    {
        $this->db->select('*');
        $this->db->from('messages');
        $this->db->order_by('id', 'desc');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_message($id)
    {
        $this->db->set('status', 1, FALSE);
        $this->db->where('id', $id);
        $this->db->update('messages');

        $this->db->select('*');
        $this->db->from('messages');
        $this->db->where('id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function delete_message($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('messages');
    }

    /*................................site_translation.......................................*/
    function get_translate()
    {
        $this->db->select('*');
        $this->db->from('site_language');
        $this->db->order_by('word_id', 'desc');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function delete_site_translation($id)
    {
        $this->db->where('word_id', $id);
        $this->db->delete('site_language');
    }

    function get_translate_by_id($id)
    {
        $this->db->select('*');
        $this->db->from('site_language');
        $this->db->where('word_id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function update_site_translation($id, $data)
    {
        $this->db->where('word_id', $id);
        $this->db->update('site_language', $data);
    }

    /*................................categories.......................................*/
    function get_categories()
    {
        $this->db->select('*');
        $this->db->from('categories');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_category($id)
    {
        $this->db->select('*');
        $this->db->from('categories');
        $this->db->where('kat_id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function update_category($id, $data)
    {
        $this->db->where('kat_id', $id);
        $this->db->update('categories', $data);
    }

    /*................................uploads.......................................*/
    function uploadfiles($data)
    {
        $this->db->insert('uploads', $data);
    }

    function get_uploads()
    {
        $this->db->select('*');
        $this->db->from('uploads');
        $this->db->order_by('id', 'DESC');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }
	
	function get_uploaded_file_news($id)
    {
        $this->db->select('*');
        $this->db->from('uploads');
        $this->db->where('news_id', $id);
		$this->db->order_by('id', 'DESC');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_uploaded_file($id)
    {
        $this->db->select('*');
        $this->db->from('uploads');
        $this->db->where('id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function delete_file($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('uploads');
    }

    /*................................termsofuse.......................................*/
    function termsofuse()
    {
        $this->db->select('*');
        $this->db->from('terms_of_use');
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function updatetermsofuse($data)
    {
        $this->db->update('terms_of_use', $data);
    }

    /*................................Xidmətlər.......................................*/
    function services()
    {
        $this->db->select('*');
        $this->db->from('services');
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function updateservices($data)
    {
        $this->db->update('services', $data);
    }

    /*................................privacy.......................................*/
    function privacy()
    {
        $this->db->select('*');
        $this->db->from('privacy');
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function updateprivacy($data)
    {
        $this->db->update('privacy', $data);
    }

    /*................................cf_categories.......................................*/
    function get_cfcategories()
    {
        $this->db->select('*');
        $this->db->from('cf_categories');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function get_cfcategory($id = '')
    {
        $this->db->select('*');
        $this->db->from('cf_categories');
        $this->db->where('id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function add_cfcategory($data = '')
    {
        $this->db->insert('cf_categories', $data);
    }

    function delete_cfcategory($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('cf_categories');
    }

    function update_cfcategory($id = '', $data = '')
    {
        $this->db->where('id', $id);
        $this->db->update('cf_categories', $data);
    }

    /*................................cf_projects.......................................*/
    function get_cfprojects()
    {
        $this->db->select('cf_project_translation.title');
        $this->db->select('cf_projects.price');
        $this->db->select('cf_projects.id');
        $this->db->select('cf_projects.link');
        $this->db->select('cf_projects.status');
        $this->db->select('cf_categories.title_az');
        $this->db->select('cf_projects.end_time');
        $this->db->from('cf_projects');
        $this->db->join('cf_project_translation', 'cf_projects.id=cf_project_translation.project_id');
        $this->db->join('cf_categories', 'cf_projects.category_id=cf_categories.id');
        $this->db->where('cf_project_translation.lang_code', 'az');
        $this->db->order_by('cf_projects.id', 'DESC');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    function add_cfproject($project = '')
    {
        $this->db->insert('cf_projects', $project);
        return $id = $this->db->insert_id();
    }

    function add_cfproject_translation($data = '')
    {
        $this->db->insert('cf_project_translation', $data);
    }

    function get_cfproject($id = '')
    {
        $this->db->select('*');
        $this->db->from('cf_projects');
        $this->db->where('id', $id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function update_cfproject($id = '', $data = '')
    {
        $this->db->where('id', $id);
        $this->db->update('cf_projects', $data);
    }

    function delete_cfproject_translations($id = '')
    {
        $this->db->where('project_id', $id);
        $this->db->delete('cf_project_translation');
    }

    function delete_cfproject($id = '')
    {
        $this->db->where('id', $id);
        $this->db->delete('cf_projects');

        $this->db->where('project_id', $id);
        $this->db->delete('cf_project_translation');
    }

    /*................................logins.......................................*/
    function get_logins()
    {
        $this->db->select('*');
        $this->db->from('admin_logins');
        $this->db->order_by('id', 'desc');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /*................................logs.......................................*/
    function get_logs()
    {
        $this->db->select('*');
        $this->db->from('admin_logs');
        $this->db->order_by('id', 'desc');
        if ($query = $this->db->get()) {
            return $query->result_array();
        } else {
            return false;
        }
    }

    /*................................cf_about.......................................*/
    function get_cfabout()
    {
        $this->db->select('*');
        $this->db->from('cf_about');
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function update_cfabout($data)
    {
        $this->db->update('cf_about', $data);
    }
	
	/*................................ admin captcha.......................................*/
	public function captcha()
    {
        $myarray = array(
            'img_path' 		=> './captchaimages/',
            'img_url' 		=> base_url('./captchaimages/'),
            'img_width' 	=> '130',
            'img_height' 	=> 35,
            'font_size' 	=> 15,
            'word' 			=> rand(400, 40000),
			'expiration'    => 3600,
			
            'colors' => array(
                'background' => array(
                    255,
                    256,
                    555
                ),
                'border' => array(
                    252,
                    256,
                    535
                ),
                'text' => array(
                    115,
                    236,
                    445
                ),
                'grid' => array(
                    30,
                    50,
                    578
                )
            )
        );
        return $data['captcha'] = create_captcha($myarray);
    }

/*................................ image upload.......................................*/

    function upload_image($post = '', $folder = '' , $width = '') {

        $config['upload_path'] = './' . $folder;
        $config['allowed_types'] = 'gif|jpg|png|jpeg|ico';
        $config['max_size'] = 2000;
        $config['encrypt_name'] = true;

        $this->load->library('upload', $config);

        if ($this->upload->do_upload($post)) {
            $image = $this->upload->data();
            if ($width !== '') {
                $this->thumb($image,$width,false);       
            }
            return $folder . '/' . $image['file_name'];
        } else {
            echo $this->upload->display_errors();
            exit();
        }
    }

    function thumb($data,$width,$create_thumb)    
    {       
        $config['image_library'] = 'gd2';    
        $config['source_image'] =$data['full_path'];      
        $config['create_thumb'] = $create_thumb;    
        $config['maintain_ratio'] = TRUE;    
        $config['width'] = $width;      
        $this->load->library('image_lib', $config);    
        $this->image_lib->resize();    
    }

    /*................................ strategic-plan .......................................*/

    function get_strategic_plan()
    {
        $this->db->select('*');
        $this->db->from('strategic_plan');
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function update_strategic_plan($data)
    {
        $this->db->update('strategic_plan', $data);
    }
	
}
