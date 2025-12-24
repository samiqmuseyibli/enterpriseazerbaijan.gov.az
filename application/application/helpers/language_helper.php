<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package        CodeIgniter
 * @author        ExpressionEngine Dev Team
 * @copyright    Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @license        http://codeigniter.com/user_guide/license.html
 * @link        http://codeigniter.com
 * @since        Version 1.0
 * @filesource
 */


if (!function_exists('recache')) {
    function recache()
    {
        $CI =& get_instance();
        $CI->benchmark->mark_time();
        $files = glob(APPPATH . 'cache/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file) && $file !== '.htaccess' && $file !== 'index.html') {
                unlink($file); // delete file
            }
        }
        //file_get_contents(base_url().'index.php/home/index');
    }
}

//GETTING LIMITING CHARECTER
if (!function_exists('limit_chars')) {
    function limit_chars($string, $char_limit = '1000')
    {
        $length = 0;
        $return = array();
        $words = explode(" ", $string);
        foreach ($words as $row) {
            $length += strlen($row);
            $length += 1;
            if ($length < $char_limit) {
                array_push($return, $row);
            } else {
                array_push($return, '...');
                break;
            }
        }

        return implode(" ", $return);
    }
}

//GET CURRENCY
if (!function_exists('recache')) {
    function recache()
    {
        $CI =& get_instance();
        $CI->benchmark->mark_time();
        $files = glob(APPPATH . 'cache/*'); // get all file names
        foreach ($files as $file) { // iterate files
            if (is_file($file) && $file !== '.htaccess' && $file !== 'index.html') {
                unlink($file); // delete file
            }
        }
        //file_get_contents('home/index');
    }
}

//return translation
if (!function_exists('lang_check_exists')) {
    function lang_check_exists($word)
    {
        $CI =& get_instance();
        $CI->load->database();
        $result = $CI->db->get_where('site_language', array('word' => $word));
        if ($result->num_rows() > 0) {
            return 1;
        } else {
            return 0;
        }
    }
}
//check and add to db
if (!function_exists('add_lang_word')) {
    function add_lang_word($word)
    {
        $CI =& get_instance();
        $CI->load->database();
        $data['word'] = $word;
        $data['English'] = ucwords(str_replace('_', ' ', $word));
        $CI->db->insert('site_language', $data);
    }
}


//add language
if (!function_exists('add_language')) {
    function add_language($language)
    {
        $CI =& get_instance();
        $CI->load->database();
        $CI->load->dbforge();
        $language = str_replace(' ', '_', $language);
        $fields = array(
            $language => array('type' => 'LONGTEXT', 'collation' => 'utf8_unicode_ci', 'null' => TRUE, 'default' => NULL)
        );
        $CI->dbforge->add_column('site_language', $fields);
    }
}

//insert language wise
if (!function_exists('add_translation')) {
    function add_translation($word, $language, $translation)
    {
        $CI =& get_instance();
        $CI->load->database();
        $data[$language] = $translation;
        $CI->db->where('word', $word);
        $CI->db->update('site_language', $data);
    }
}


//return translation
// function curLang(){
//         $CI =& get_instance();
//         $lang = $CI->session->userdata('language');
//         if ($lang === 'Azerbaijan') {
//            return $l = 'az';
//         }
//         if ($lang === 'Russian') {
//            return $l = 'ru';
//         }
//         if ($lang === 'English') {
//            return $l = 'en';
//         }else{
//            return $l = 'az'; 
//         }
// }
// function translate($word)
// {

//     $CI =& get_instance();
//     $CI->load->database();

//     if ($set_lang = $CI->session->userdata('language')) {
//     } else {
//         $set_lang = $CI->db->get_where('general_settings', array('type' => 'site_language'))->row()->value;
//     }
//     $result = $CI->db->get_where('site_language', array('word' => $word));
//     if ($result->num_rows() > 0) {
//         if ($result->row()->$set_lang !== NULL && $result->row()->$set_lang !== '') {
//             return $result->row()->$set_lang;
//             //return '-----------';
//         } else {
//             return $result->row()->English;
//             //return '-----------';
//         }
//     } else {
//         $data['word'] = $word;
//         $data['English'] = ucwords(str_replace('_', ' ', $word));
//         $CI->db->insert('site_language', $data);
//         return ucwords(str_replace('_', ' ', $word));
//         //return '-----------';
//     }
// }
	
function get_active_language() {
    $CI =& get_instance();
    $CI->load->database();

    $lang_code = $CI->uri->segment(1);
    $lang_map = ['az' => 'Azerbaijan', 'en' => 'English', 'ru' => 'Russian'];
    $default_lang = 'Azerbaijan';

    if (isset($lang_map[$lang_code])) {
        return $lang_map[$lang_code];
    }

    $row = $CI->db->get_where('general_settings', ['type' => 'site_language'])->row();
    return $row ? $row->value : $default_lang;
}

function translate($word) {
    $CI =& get_instance();
    $CI->load->database();

    $lang = get_active_language();

    $query = $CI->db->get_where('site_language', ['word' => $word]);
    if ($query->num_rows() > 0) {
        $row = $query->row();
        return !empty($row->$lang) ? $row->$lang : $row->English;
    } else {
        $text = ucwords(str_replace('_', ' ', $word));
        $CI->db->insert('site_language', ['word' => $word, 'English' => $text]);
        return $text;
    }
}

function curLang() {
    $CI =& get_instance();

    $supported_languages = ['az', 'en', 'ru'];
    $default_language = 'az';

    $lang = $CI->uri->segment(1);

    return in_array($lang, $supported_languages) ? $lang : $default_language;
}

if (!function_exists('lang_url')) {
    function lang_url($target_lang = 'az') {
        $CI =& get_instance();
        $supported_languages = ['az', 'en', 'ru'];

        if (!in_array($target_lang, $supported_languages)) {
            $target_lang = 'az';
        }

        // Layihənin kök qovluğunun yolu (məsələn "/entr")
        $base_path = parse_url(base_url(), PHP_URL_PATH);
        $base_path = trim($base_path, '/'); // 'entr'

        // İstifadəçinin gəldiyi tam URL-in path hissəsi
        $request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $request_uri = trim($request_uri, '/');

        // Əgər path `base_path` ilə başlayırsa, çıxarırıq
        if ($base_path !== '' && strpos($request_uri, $base_path) === 0) {
            $request_uri = substr($request_uri, strlen($base_path));
            $request_uri = ltrim($request_uri, '/');
        }

        // İndi request_uri-də artıq `entr` qovluğu yoxdur, sadəcə URL-in qalan hissəsi var
        $segments = explode('/', $request_uri);

        // Mövcud dil kodunu yoxlayırıq və dəyişirik və ya əlavə edirik
        if (in_array($segments[0] ?? '', $supported_languages)) {
            $segments[0] = $target_lang;
        } else {
            array_unshift($segments, $target_lang);
        }

        // Yeni URL qururuq: base_url + dil + qalan hissə
        $new_url = base_url($base_path . '/' . implode('/', $segments));
        return $new_url;
    }
}
