<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_model
{
    public function register_user($user)
    {
        $this->db->insert('users', $user);
    }

    public function login_user($email, $pass)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_mail', $email);
        $this->db->where('user_pass', $pass);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function email_check($email)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('user_mail', $email);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function get_user_detail($user_id)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function get_user_hash($hash)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('accept_hash', $hash);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    function activate_user($hash)
    {
        $this->db->set('user_status', '1', FALSE);
        $this->db->where('accept_hash', $hash);
        $this->db->update('users');
    }
    
	public function showSectorsM(){ 
        $l=curLang();
        $sectors=$this->db->get_where('sectors',array('status' => 1 ))->result_array();
    
        $ret = "";
        $ret .= '<div class="one_half last">';
        $ret .= '<label>'.translate('choose_sector').' </label>';
        $ret .= '<select  name="sector">';
        $ret .= '<option value="">- '.translate('choose_from_list').' -</option>';
        foreach ($sectors as $sector) {       
            $ret .= ' <option value="'.$sector['sek_id'].'">'.$sector['sek_adi_'.$l.''].'</option>';
        }
        $ret .= '</select>';
        $ret .= '</div>';
        return $ret;
    }
	
    public function set_resethash_user($hash, $email)
    {
        $this->db->set('reset_hash', $hash);
        $this->db->where('user_mail', $email);
        $this->db->update('users');
    }

    public function update_user_pass($new_hash, $user_pass, $user_mail)
    {
        $this->db->set('reset_hash', $new_hash);
        $this->db->set('user_pass', $user_pass);
        $this->db->where('user_mail', $user_mail);
        $this->db->update('users');
    }

    public function check_reset_hash_for_user($resetkey, $user_mail)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('reset_hash', $resetkey);
        $this->db->where('user_mail', $user_mail);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function check_reset_hash($resetkey)
    {
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('reset_hash', $resetkey);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    public function captcha()
    {
        $myarray = array(
            'img_path' => './captchaimages/',
            'img_url' => base_url('captchaimages/'),
            'img_width' => 130,
            'img_height' => 40,
            'font_size' => 15,
            'word' => rand(400, 40000),
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

    public function get_my_details()
    {
        $user_id = $this->session->userdata('user_id');
        $this->db->select('*');
        $this->db->from('users');
        $this->db->where('id', $user_id);
        if ($query = $this->db->get()) {
            return $query->row_array();
        } else {
            return false;
        }
    }
	public function insert_image($data)
    {
        $this->db->insert('uploads', $data);
    }

}


?>
