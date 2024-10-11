<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Moderator extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Baku');
        $this->load->model('user_model');
        $this->load->model('email_model');
        $this->load->model('project_model');
        if (!$this->session->userdata('language')) {
            $lang = $this->db->get_where('general_settings', array('type' => 'site_language'))->row()->value;
            $this->session->set_userdata('language', $lang);
        }
    } 
    public function safety()
    {
        $enter = $this->session->userdata('is_moderator');
        if (!$enter) {
            redirect('moderator');
        }
    }
    public function ismoderator()
    {
        $id = $this->session->userdata('is_moderator');
        $check = $this->user_model->get_user_detail($id);
        if ($check['user_role'] != 'moderator') {
            redirect('user/login');
        }
    }

    public function index()
    {
        $enter = $this->session->userdata('is_moderator');
        if ($enter) {
            $page_data['title'] = translate('moderator_title');
            $page_data['all_projects'] = $this->project_model->get_not_accepted_projects();
            $page_data['table_title'] = 'Butun layiheler';
            $page_data['page_name'] = 'moderator_all_projects';
            $this->load->view('moderator/moderator_panel', $page_data);
        } else {
            redirect('user/login');
        }
    }

    public function all_projects()
    {
        $this->safety();
        $this->ismoderator();
        $page_data['title'] = translate('moderator_title');
        $page_data['all_projects'] = $this->project_model->get_all_projects_moderator();
        $page_data['page_name'] = 'moderator_all_projects';
        $page_data['table_title'] = 'Bütün layihələr';
        $this->load->view('moderator/moderator_panel', $page_data);

    }

    public function accepted_projects()
    {
        $this->safety();
        $this->ismoderator();
        $page_data['title'] = translate('moderator_title');
        $page_data['all_projects'] = $this->project_model->get_accepted_projects();
        $page_data['page_name'] = 'moderator_all_projects';
        $page_data['table_title'] = 'Təsdiq edilmiş layihələr';
        $this->load->view('moderator/moderator_panel', $page_data);
    }

    public function on_waiting_projects()
    {
        $this->safety();
        $this->ismoderator();
        $page_data['title'] = translate('moderator_title');
        $page_data['all_projects'] = $this->project_model->get_not_accepted_projects();
        $page_data['page_name'] = 'moderator_all_projects';
        $page_data['table_title'] = 'Gözləmədə olan layihələr';
        $this->load->view('moderator/moderator_panel', $page_data);
    }

    public function edited_projects()
    {
        $this->safety();
        $this->ismoderator();
        $page_data['title'] = translate('moderator_title');
        $page_data['all_projects'] = $this->project_model->get_edited_projects();
        $page_data['page_name'] = 'moderator_all_projects';
        $page_data['table_title'] = 'Düzəliş edilmiş layihələr';
        $this->load->view('moderator/moderator_panel', $page_data);
    }

    public function delete_project()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->uri->segment(3, 0));
        if ($project_id) {
            $this->project_model->delete_user_project($project_id);
            redirect('moderator/all_projects');
        }
        redirect('moderator/all_projects');
    }

    public function activate_project()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->uri->segment(3, 0));
        if ($project_id) {
            $this->project_model->activate_user_project($project_id);
            redirect('moderator/all_projects');
        }
        redirect('moderator/all_projects');
    }

    public function deleted_projects()
    {
        $this->safety();
        $this->ismoderator();
        $page_data['title'] = translate('moderator_title');
        $page_data['all_projects'] = $this->project_model->get_deleted_projects_moderator();
        $page_data['table_title'] = 'Silinmiş layihələr';
        $page_data['page_name'] = 'moderator_all_projects';
        $this->load->view('moderator/moderator_panel', $page_data);
    }
 
   public function deletefile($pid)
    {  
    $this->safety();
    $this->ismoderator();
    $pid=html_escape($pid);
    if ($pid != '') {
        $url=$this->db->get_where('files', array('files_id' => $pid))->row()->files_url;
        if ($url!='files/projectimages/noimage.jpg'){
            if ($this->project_model->deleteimage($pid)){
               echo 'done'; 
            }else{
                echo 'error';
            }
           
        } else {
            echo 'error';
        }
    }else{
        echo 'enter id';
    }
    }
    public function send_mail_after_translate($user_id, $project_id)
    {
        $this->safety();
        $this->ismoderator();
        $user_id=html_escape($user_id);
        $project_id=html_escape($project_id);
        $user = $this->user_model->get_user_detail($user_id);
        $project = $this->project_model->get_projects_detail_moderator($project_id);
        if($user!=''  && $project!=''){
        $message = "Sizin " . $project['project_title'] . " başlıqlı layihəniz moderator tərəfindən tərcümə olundu və dərc edildi. URL: <a href= " . base_url() . "project/detail/" . $project['project_id'] . '-' . $project['top'] . ">" . base_url() . "project/detail/" . $project['project_id'] . '-' . $project['top'] . "</a>";
        $to = $user['user_mail'];
        $subject = "Layihə Təsdiqi";
        $mail = $this->email_model->sendMail($to, $subject, $message);

        $subscribed_users=$this->db->get_where('users',array('sector_id' => $project['sector_id']))->result_array();
        if ($subscribed_users!=null) {
            foreach ($subscribed_users as $to) {
                
        $message = "Sizin marağ dairənizə uyğun yeni layihə əlavə edilmişdir.  <br> URL: <a href= " . base_url() . "project/detail/" . $project['project_id'] . '-' . $project['top'] . ">" . base_url() . "project/detail/" . $project['project_id'] . '-' . $project['top'] . "</a>";
        $subject = "Təklif";
        $mail = $this->email_model->sendMail($to['user_mail'], $subject, $message);  

        // echo $message.'<br><br><br>'.$subject.'<br><br>'.$to['user_mail'].'<br>';
        // echo "-----------------------------";

        }
        }
        $this->session->set_flashdata('succes_message', translate('project_is_translated'));
        redirect('moderator/on_waiting_projects');   
        }else{
            echo "error";
        }
       
    }

    /*.......................translate_projects................................*/
    public function translate_project()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->uri->segment(3, 0));
        $category_id = html_escape($this->uri->segment(4, 0));
        $page_data['title'] = translate('moderator_title');
        if ($category_id == 1) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            if ($page_data['detail']['isActive']==0) {
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_translate_startup';
            $this->load->view('moderator/moderator_panel', $page_data);
             }else{
            $this->session->set_flashdata('error_message', translate('this_project_is_translated_you_can edit_this'));
            redirect('moderator/on_waiting_projects');     
            }

        }
        elseif ($category_id == 2) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            if ($page_data['detail']['isActive']==0) {
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['usage_form'] = $this->project_model->get_usage_form();
            $page_data['property_type'] = $this->project_model->get_property_type();
            $page_data['appointment'] = $this->project_model->get_appointment();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_translate_land_sale';
            $this->load->view('moderator/moderator_panel', $page_data);
             }else{
            $this->session->set_flashdata('error_message', translate('this_project_is_translated_you_can edit_this'));
            redirect('moderator/on_waiting_projects');     
            }
        }
        elseif ($category_id == 3) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            if ($page_data['detail']['isActive']==0) {
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_translate_privatization';
            $this->load->view('moderator/moderator_panel', $page_data);
             }else{
            $this->session->set_flashdata('error_message', translate('this_project_is_translated_you_can edit_this'));
            redirect('moderator/on_waiting_projects');     
            }
        }
        elseif ($category_id == 4) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            if ($page_data['detail']['isActive']==0) {
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['property_type'] = $this->project_model->get_property_type();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_translate_business';
            $this->load->view('moderator/moderator_panel', $page_data);
             }else{
            $this->session->set_flashdata('error_message', translate('this_project_is_translated_you_can edit_this'));
            redirect('moderator/on_waiting_projects');     
            }
        }
        elseif ($category_id == 5) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            if ($page_data['detail']['isActive']==0) {
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_translate_idea';
            $this->load->view('moderator/moderator_panel', $page_data); 
            }else{
            $this->session->set_flashdata('error_message', translate('this_project_is_translated_you_can edit_this'));
            redirect('moderator/on_waiting_projects');     
            }
            
        }
        elseif ($category_id == 6) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            if ($page_data['detail']['isActive']==0) {
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_translate_stocks';
            $this->load->view('moderator/moderator_panel', $page_data);
             }else{
            $this->session->set_flashdata('error_message', translate('this_project_is_translated_you_can edit_this'));
            redirect('moderator/on_waiting_projects');     
            }
        }
        elseif ($category_id == 7) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            if ($page_data['detail']['isActive']==0) {
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['usage_form'] = $this->project_model->get_usage_form();
            $page_data['property_type'] = $this->project_model->get_property_type();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_translate_estate';
            $this->load->view('moderator/moderator_panel', $page_data);
             }else{
            $this->session->set_flashdata('error_message', translate('this_project_is_translated_you_can edit_this'));
            redirect('moderator/on_waiting_projects');     
            }
        }
        elseif ($category_id == 9) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            if ($page_data['detail']['isActive']==0) {
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_translate_investment';
            $this->load->view('moderator/moderator_panel', $page_data);
             }else{
            $this->session->set_flashdata('error_message', translate('this_project_is_translated_you_can edit_this'));
            redirect('moderator/on_waiting_projects');     
            }
        } else {
            $this->load->view('404');
        }
    }

    public function translate_privatization()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $user_id = html_escape($this->input->post('user_id'));
        $lang_code = html_escape($this->input->post('lang'));
        $translation_id = html_escape($this->input->post('translation_id'));
        $this->project_model->delete_translation($translation_id);

        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'region_id' => html_escape($this->input->post('region')),
            'charter_capital' => html_escape($this->input->post('charter_capital')),
            'number_of_issued_stocks' => html_escape($this->input->post('number_of_issued_stocks')),
            'nominal_value_of_one_stocks' => html_escape($this->input->post('nominal_value_of_one_stocks')),
            'volume_of_traded_stocks' => html_escape($this->input->post('volume_of_traded_stocks')),
            'project_author' => html_escape($this->input->post('author')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'author_email' => html_escape($this->input->post('email')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'accept_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'en',
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'adress' => html_escape($this->input->post('adress_en')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'az',
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'adress' => html_escape($this->input->post('adress_az')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'ru',
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
            );
            $this->project_model->add_translate($translation_data);
        }

        redirect('moderator/send_mail_after_translate/' . $user_id . '/' . $project_id . '');

    }

    public function translate_idea()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $user_id = html_escape($this->input->post('user_id'));
        $lang_code = html_escape($this->input->post('lang'));
        $translation_id = html_escape($this->input->post('translation_id'));
        $this->project_model->delete_translation($translation_id);

        $project_data = array(
            'region_id' => html_escape($this->input->post('region')),
            'invesment_volume' => html_escape($this->input->post('investment_volume')),
            'project_author' => html_escape($this->input->post('company')),
            'author_telephone' => html_escape($this->input->post('number')),
            'author_email' => html_escape($this->input->post('email')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'isActive' => 1,
            'accept_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'en',
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'az',
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'ru',
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
            );
            $this->project_model->add_translate($translation_data);
        }

        redirect('moderator/send_mail_after_translate/' . $user_id . '/' . $project_id . '');

    }

    public function translate_startup()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $user_id = html_escape($this->input->post('user_id'));
        $lang_code = html_escape($this->input->post('lang'));
        $translation_id = html_escape($this->input->post('translation_id'));
        $this->project_model->delete_translation($translation_id);

        $project_data = array(
            'region_id' => html_escape($this->input->post('region')),
            'sector_id' => html_escape($this->input->post('sector')),
            'invesment_volume' => html_escape($this->input->post('investment_volume')),
            'investor_percent' => html_escape($this->input->post('investor_percent')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'project_author' => html_escape($this->input->post('author')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'author_email' => html_escape($this->input->post('email')),
            'isActive' => 1,
            'accept_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'en',
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'adress' => html_escape($this->input->post('adress_en')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'az',
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'adress' => html_escape($this->input->post('adress_az')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'ru',
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
            );
            $this->project_model->add_translate($translation_data);
        }

        redirect('moderator/send_mail_after_translate/' . $user_id . '/' . $project_id . '');

    }

    public function translate_investment()
    {
        $this->safety();
        $this->ismoderator();
        $project_id =  html_escape($this->input->post('project_id'));
        $user_id = html_escape($this->input->post('user_id'));
        $lang_code = html_escape($this->input->post('lang'));
        $translation_id = html_escape($this->input->post('translation_id'));
        $this->project_model->delete_translation($translation_id);

        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'investor_percent' => html_escape($this->input->post('investment_percent')),
            'invesment_volume' => html_escape($this->input->post('investment_volume')),
            'region_id' => html_escape($this->input->post('region')),
            'project_author' => html_escape($this->input->post('author')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'author_email' => html_escape($this->input->post('email')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'accept_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'en',
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'adress' => html_escape($this->input->post('adress_en')),
                'main_advantages' => html_escape($this->input->post('main_advantages_en')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'az',
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'adress' => html_escape($this->input->post('adress_az')),
                'main_advantages' => html_escape($this->input->post('main_advantages_az')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $translation_data = array(
                'project_id' =>html_escape($this->input->post('project_id')),
                'lang_code' => 'ru',
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
                'main_advantages' => html_escape($this->input->post('main_advantages_ru')),
            );
            $this->project_model->add_translate($translation_data);
        }

        redirect('moderator/send_mail_after_translate/' . $user_id . '/' . $project_id . '');

    }

    public function translate_business()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $user_id = html_escape($this->input->post('user_id'));
        $lang_code = html_escape($this->input->post('lang'));
        $translation_id = html_escape($this->input->post('translation_id'));
        $this->project_model->delete_translation($translation_id);

        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'property_type_id' => html_escape($this->input->post('property')),
            'region_id' => html_escape($this->input->post('region')),
            'price' => html_escape($this->input->post('price')),
            'project_author' => html_escape($this->input->post('author')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'author_email' => html_escape($this->input->post('email')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'accept_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'en',
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'adress' => html_escape($this->input->post('adress_en')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'az',
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'adress' => html_escape($this->input->post('adress_az')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'ru',
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
            );
            $this->project_model->add_translate($translation_data);
        }

        redirect('moderator/send_mail_after_translate/' . $user_id . '/' . $project_id . '');

    }

    public function translate_land_sale()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $user_id = html_escape($this->input->post('user_id'));
        $lang_code = html_escape($this->input->post('lang'));
        $translation_id = html_escape($this->input->post('translation_id'));
        $this->project_model->delete_translation($translation_id);

        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'property_type_id' => html_escape($this->input->post('property')),
            'region_id' => html_escape($this->input->post('region')),
            'usage_form_id' => html_escape($this->input->post('usage_form')),
            'appointment_id' => html_escape($this->input->post('appointment')),
            'common_area' => html_escape($this->input->post('ha')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'price' => html_escape($this->input->post('price')),
            'project_author' => html_escape($this->input->post('author')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'author_email' => html_escape($this->input->post('email')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'accept_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'en',
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'adress' => html_escape($this->input->post('adress_en')),
                'infrastructure' => html_escape($this->input->post('infrastructure_en')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'az',
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'adress' => html_escape($this->input->post('adress_az')),
                'infrastructure' => html_escape($this->input->post('infrastructure_az')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'ru',
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
                'infrastructure' => html_escape($this->input->post('infrastructure_ru')),
            );
            $this->project_model->add_translate($translation_data);
        }

        redirect('moderator/send_mail_after_translate/' . $user_id . '/' . $project_id . '');

    }

    public function translate_estate()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $user_id = html_escape($this->input->post('user_id'));
        $lang_code = html_escape($this->input->post('lang'));
        $translation_id = html_escape($this->input->post('translation_id'));
        $this->project_model->delete_translation($translation_id);

        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'usage_form_id' => html_escape($this->input->post('usage_form')),
            'property_type_id' => html_escape($this->input->post('property')),
            'price' => html_escape($this->input->post('price')),
            'common_area' => html_escape($this->input->post('ha')),
            'region_id' => html_escape($this->input->post('region')),
            'project_author' => html_escape($this->input->post('author')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'author_email' => html_escape($this->input->post('email')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'accept_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'en',
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'adress' => html_escape($this->input->post('adress_en')),
                'infrastructure' =>html_escape($this->input->post('infrastructure_en')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'az',
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'adress' => html_escape($this->input->post('adress_az')),
                'infrastructure' => html_escape($this->input->post('infrastructure_az')),
            );
            $this->project_model->add_translate($translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $translation_data = array(
                'project_id' => html_escape($this->input->post('project_id')),
                'lang_code' => 'ru',
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
                'infrastructure' => html_escape($this->input->post('infrastructure_ru')),
            );
            $this->project_model->add_translate($translation_data);
        }

        redirect('moderator/send_mail_after_translate/' . $user_id . '/' . $project_id . '');

    }

    /*.......................edit_projects................................*/
    public function edit_project()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->uri->segment(3, 0));
        $category_id = html_escape($this->uri->segment(4, 0));
        $page_data['title'] = translate('moderator_title');
        if ($category_id == 1) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_edit_startup';
            $this->load->view('moderator/moderator_panel', $page_data);
        } elseif ($category_id == 2) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['usage_form'] = $this->project_model->get_usage_form();
            $page_data['property_type'] = $this->project_model->get_property_type();
            $page_data['appointment'] = $this->project_model->get_appointment();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_edit_land_sale';
            $this->load->view('moderator/moderator_panel', $page_data);
        } elseif ($category_id == 3) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_edit_privatization';
            $this->load->view('moderator/moderator_panel', $page_data);
        } elseif ($category_id == 4) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['property_type'] = $this->project_model->get_property_type();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_edit_business';
            $this->load->view('moderator/moderator_panel', $page_data);
        } elseif ($category_id == 5) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_edit_idea';
            $this->load->view('moderator/moderator_panel', $page_data);
        } elseif ($category_id == 6) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_edit_stocks';
            $this->load->view('moderator/moderator_panel', $page_data);
        } elseif ($category_id == 7) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['usage_form'] = $this->project_model->get_usage_form();
            $page_data['property_type'] = $this->project_model->get_property_type();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_edit_estate';
            $this->load->view('moderator/moderator_panel', $page_data);
        } elseif ($category_id == 9) {
            $page_data['detail'] = $this->project_model->get_project_detail_moderator($project_id);
            $page_data['regions'] = $this->project_model->get_regions();
            $page_data['sectors'] = $this->project_model->get_sectors();
            $page_data['translation'] = $this->project_model->get_project_translation($project_id);
            $page_data['page_name'] = 'moderator_edit_investment';
            $this->load->view('moderator/moderator_panel', $page_data);
        } else {
            $this->load->view('404');
        }
    }

    public function edit_privatization()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'region_id' => html_escape($this->input->post('region')),
            'charter_capital' => html_escape($this->input->post('charter_capital')),
            'number_of_issued_stocks' => html_escape($this->input->post('number_of_issued_stocks')),
            'nominal_value_of_one_stocks' => html_escape($this->input->post('nominal_value_of_one_stocks')),
            'volume_of_traded_stocks' => html_escape($this->input->post('volume_of_traded_stocks')),
            'project_author' => html_escape($this->input->post('author')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'author_email' => html_escape($this->input->post('email')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'update_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $this->project_model->upload_files('images', 'projectimages', $project_id);     
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $lang_code = 'en';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'adress' => html_escape($this->input->post('adress_en')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $lang_code = 'az';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'adress' => html_escape($this->input->post('adress_az')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $lang_code = 'ru';
            $translation_data = array(
                'project_title' =>html_escape($this->input->post('projectName_ru')),
                'project_description' =>html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $this->session->set_flashdata('succes_message', translate('Updated'));
        redirect('moderator/all_projects');

    }

    public function edit_idea()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $project_data = array(
            'region_id' => html_escape($this->input->post('region')),
            'invesment_volume' => html_escape($this->input->post('investment_volume')),
            'project_author' => html_escape($this->input->post('company')),
            'author_telephone' => html_escape($this->input->post('number')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'author_email' => html_escape($this->input->post('email')),
            'isActive' => 1,
            'update_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $this->project_model->upload_files('images', 'projectimages', $project_id);     
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $lang_code = 'en';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $lang_code = 'az';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $lang_code = 'ru';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' =>html_escape( $this->input->post('project_info_ru')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $this->session->set_flashdata('succes_message', translate('Updated'));
        redirect('moderator/all_projects');

    }

    public function edit_startup()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $project_data = array(
            'region_id' => html_escape($this->input->post('region')),
            'sector_id' => html_escape($this->input->post('sector')),
            'invesment_volume' => html_escape($this->input->post('investment_volume')),
            'investor_percent' => html_escape($this->input->post('investor_percent')),
            'project_author' => html_escape($this->input->post('author')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'author_email' => html_escape($this->input->post('email')),
            'isActive' => 1,
            'update_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $this->project_model->upload_files('images', 'projectimages', $project_id);     
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $lang_code = 'en';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'adress' => html_escape($this->input->post('adress_en')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $lang_code = 'az';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'adress' => html_escape($this->input->post('adress_az')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $lang_code = 'ru';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $this->session->set_flashdata('succes_message', translate('Updated'));
        redirect('moderator/all_projects');

    }

    public function edit_investment()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'investor_percent' => html_escape($this->input->post('investment_percent')),
            'invesment_volume' => html_escape($this->input->post('investment_volume')),
            'region_id' => html_escape($this->input->post('region')),
            'project_author' => html_escape($this->input->post('author')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'author_email' => html_escape($this->input->post('email')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'update_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $this->project_model->upload_files('images', 'projectimages', $project_id);     
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $lang_code = 'en';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'main_advantages' => html_escape($this->input->post('main_advantages_en')),
                'adress' => html_escape($this->input->post('adress_en')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $lang_code = 'az';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' =>html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'main_advantages' => html_escape($this->input->post('main_advantages_az')),
                'adress' => html_escape($this->input->post('adress_az')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $lang_code = 'ru';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'main_advantages' => html_escape($this->input->post('main_advantages_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $this->session->set_flashdata('succes_message', translate('Updated'));
        redirect('moderator/all_projects');

    }

    public function edit_business()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'property_type_id' => html_escape($this->input->post('property')),
            'region_id' => html_escape($this->input->post('region')),
            'price' => html_escape($this->input->post('price')),
            'project_author' => html_escape($this->input->post('author')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'author_email' => html_escape($this->input->post('email')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'update_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $this->project_model->upload_files('images', 'projectimages', $project_id);     
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $lang_code = 'en';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'adress' => html_escape($this->input->post('adress_en')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $lang_code = 'az';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'adress' => html_escape($this->input->post('adress_az')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $lang_code = 'ru';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $this->session->set_flashdata('succes_message', translate('Updated'));
        redirect('moderator/all_projects');

    }

    public function edit_land_sale()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'property_type_id' => html_escape($this->input->post('property')),
            'region_id' => html_escape($this->input->post('region')),
            'usage_form_id' => html_escape($this->input->post('usage_form')),
            'appointment_id' => html_escape($this->input->post('appointment')),
            'common_area' =>html_escape( $this->input->post('ha')),
            'price' => html_escape($this->input->post('price')),
            'project_author' =>html_escape( $this->input->post('author')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'author_email' => html_escape($this->input->post('email')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'update_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $this->project_model->upload_files('images', 'projectimages', $project_id);     
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $lang_code = 'en';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'infrastructure' => html_escape($this->input->post('infrastructure_en')),
                'adress' => html_escape($this->input->post('adress_en')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $lang_code = 'az';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'infrastructure' => html_escape($this->input->post('infrastructure_az')),
                'adress' => html_escape($this->input->post('adress_az')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $lang_code = 'ru';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'infrastructure' => html_escape($this->input->post('infrastructure_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $this->session->set_flashdata('succes_message', translate('Updated'));
        redirect('moderator/all_projects');

    }

    public function edit_estate()
    {
        $this->safety();
        $this->ismoderator();
        $project_id = html_escape($this->input->post('project_id'));
        $project_data = array(
            'sector_id' => html_escape($this->input->post('sector')),
            'usage_form_id' => html_escape($this->input->post('usage_form')),
            'property_type_id' => html_escape($this->input->post('property')),
            'price' => html_escape($this->input->post('price')),
            'common_area' => html_escape($this->input->post('ha')),
            'region_id' => html_escape($this->input->post('region')),
            'project_author' => html_escape($this->input->post('author')),
            'youtube_video_link' => html_escape($this->input->post('youtube_video_link')),
            'author_telephone' => html_escape($this->input->post('telephone')),
            'author_email' => html_escape($this->input->post('email')),
            'lng' => html_escape($this->input->post('lng')),
            'lat' => html_escape($this->input->post('lat')),
            'isActive' => 1,
            'update_date' => date('d-m-Y H:i:s'),
        );
        $this->project_model->update_project($project_id, $project_data);
        $this->project_model->upload_files('images', 'projectimages', $project_id);     
        $project_name_en = html_escape($this->input->post('projectName_en'));
        if ($project_name_en != null) {
            $lang_code = 'en';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_en')),
                'project_description' => html_escape($this->input->post('project_info_en')),
                'other_important_data' => html_escape($this->input->post('a_information_en')),
                'infrastructure' => html_escape($this->input->post('infrastructure_en')),
                'adress' => html_escape($this->input->post('adress_en')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_az = html_escape($this->input->post('projectName_az'));
        if ($project_name_az != null) {
            $lang_code = 'az';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_az')),
                'project_description' => html_escape($this->input->post('project_info_az')),
                'other_important_data' => html_escape($this->input->post('a_information_az')),
                'infrastructure' => html_escape($this->input->post('infrastructure_az')),
                'adress' => html_escape($this->input->post('adress_az')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $project_name_ru = html_escape($this->input->post('projectName_ru'));
        if ($project_name_ru != null) {
            $lang_code = 'ru';
            $translation_data = array(
                'project_title' => html_escape($this->input->post('projectName_ru')),
                'project_description' => html_escape($this->input->post('project_info_ru')),
                'other_important_data' => html_escape($this->input->post('a_information_ru')),
                'infrastructure' => html_escape($this->input->post('infrastructure_ru')),
                'adress' => html_escape($this->input->post('adress_ru')),
            );
            $this->project_model->update_translation_moderator($project_id, $lang_code, $translation_data);
        }
        $this->session->set_flashdata('succes_message', translate('Updated'));
        redirect('moderator/all_projects');

    }


    /*.....................logout........................*/
    public function logout()
    {
        $this->session->unset_userdata('is_moderator');
        $this->session->unset_userdata('user_role');
        redirect('user/login', 'refresh');
    }
}

?>