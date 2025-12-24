<?php
    if ( ! function_exists('createToken')){
	function createToken(){
		$CI = & get_instance();
		$ip = $CI->input->ip_address();
		$user_id=md5($CI->session->userdata('admin_id'));
		$time = time()-60;
		$tokendata=$CI->db->get_where('tokens',array('ip'=>$ip,'user_id'=>$user_id))->row_array();
		if ($tokendata && $tokendata['created']<$time){
			// $CI->db->where('id', $tokendata['id']);
			$CI->db->where('ip', $ip);
			$CI->db->where('user_id', $user_id);
		    $CI->db->delete('tokens');
		    $token = bin2hex(openssl_random_pseudo_bytes(30));
		    $data['token'] = $token;
		    $data['ip'] = $ip;
		    $data['user_id'] = $user_id;
		    $data['created'] = time();
		    $CI->db->insert('tokens',$data);

		}elseif(!$tokendata){
			$token = bin2hex(openssl_random_pseudo_bytes(30));
		    $data['token'] = $token;
		    $data['ip'] = $ip;
		    $data['user_id'] = $user_id;
		    $data['created'] = time();
		    $CI->db->insert('tokens',$data);
		}else{
		$token = $tokendata['token'];
		}		
	
		
		return $token;
	}
}
if ( ! function_exists('checkToken')){
	function checkToken($token){
		$token=html_escape($token);
		$CI = & get_instance();
		$ip = $CI->input->ip_address();
		$user_id=md5($CI->session->userdata('admin_id'));
		$time = time()-24*60*60;
		$CI->db->where('created <=', $time);
		$CI->db->delete('tokens');
		$num = $CI->db->get_where('tokens',array('token'=>$token,'ip'=>$ip,'user_id'=>$user_id))->row_array();
		$time = time()-10*60;
		if($num && $num['created']>$time){
			return true;
		}else{
			return false;
		}
	}
}
if (!function_exists('verifyDateFormat')) {
function verifyDateFormat($date)
{
    return (DateTime::createFromFormat('Y-m-d H:i:s', $date) !== false);
}
}
if (!function_exists('resultCountPagenation')) {
	function resultCountPagenation($page = '', $per_page = '', $total_rows = '', $data = '') {
		$start = $page + 1;
		if ($page + $per_page > $total_rows) {
			$end = $total_rows;
		} else {
			$end = $page + $per_page;
		}
		if (empty($data)) {
			$result_count = '0 nəticə';
		} else {
			$result_count = $total_rows . " nəticədən " . $start . " - " . $end . " aralığı göstərilir ";
		}
		return $result_count;
	}
}
 function generateVideoEmbedUrl($url){
    //This is a general function for generating an embed link of an FB/Vimeo/Youtube Video.
    $finalUrl = '';
    if(strpos($url, 'facebook.com/') !== false) {
        //it is FB video
        $finalUrl.='https://www.facebook.com/plugins/video.php?href='.rawurlencode($url).'&show_text=1&width=200';
    }else if(strpos($url, 'vimeo.com/') !== false) {
        //it is Vimeo video
        $videoId = explode("vimeo.com/",$url)[1];
        if(strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://player.vimeo.com/video/'.$videoId;
    }else if(strpos($url, 'youtube.com/') !== false) {
        //it is Youtube video
        $videoId = explode("v=",$url)[1];
        if(strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://www.youtube.com/embed/'.$videoId;
    }else if(strpos($url, 'youtu.be/') !== false){
        //it is Youtube video
        $videoId = explode("youtu.be/",$url)[1];
        if(strpos($videoId, '&') !== false){
            $videoId = explode("&",$videoId)[0];
        }
        $finalUrl.='https://www.youtube.com/embed/'.$videoId;
    }else{
        //Enter valid video URL
    }
    return $finalUrl;
}
	// Qiymet
	function number_for_view($costFromMysql)
	{

		$costFormatForView = number_format($costFromMysql, 0, ",", " ");
		return $costFormatForView;

	}

	// Tarix
	function date_for_view($datetimeFromMysql)
	{

		$time = strtotime($datetimeFromMysql);
		$myFormatForView = date("d.m.Y / H:i", $time);
		return $myFormatForView;

	}
	
	// Təmiz post
	function p($par)
	{
		return htmlspecialchars(strip_tags($par), ENT_QUOTES, 'UTF-8');
	}
	
	// Təmiz output
	function echoo($par)
	{
		return html_escape($par);
	}
	
   function getProjectImages($id='')
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from('files');
		$ci->db->where('files_type_id', $id);
		$ci->db->order_by('files_id',"ASC");
		$query = $ci->db->get();
		return $query->result_array();
	}
	
	function getSectors()
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from('sectors');
		$ci->db->where('status', '1');
		$query = $ci->db->get();
		return $query->result_array();
	}
	function getProjectImage($id='')
	{   
		$cover = "";
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('files_url');
		$ci->db->from('files');
		$ci->db->where('files_type_id', $id);
		$ci->db->order_by('files_id',"ASC");
		$ci->db->limit('1');
		$query = $ci->db->get()->row_array();
	    if (isset($query) && $query['files_url']!='') {
	    return $cover=base_url().$query['files_url'];
		}else{
	    return $cover=base_url('files/projectimages/noimage.jpg');
		}
	}

	// Təmiz mətn
	function textile_sanitize($string)
	{
		/**
		* Filter input based on a whitelist. This filter strips out all characters that
		* are NOT: 
		* - letters
		* - numbers
		* - Textile Markup special characters.
		* 
		* Textile markup special characters are:
		* _-.*#;:|!"+%{}@
		* 
		* This filter will also pass cyrillic characters, and characters like é and ë.
		* 
		* Typical usage:
		* $string = '_ - . * # ; : | ! " + % { } @ abcdefgABCDEFG12345 éüртхцчшщъыэюьЁуфҐ ' . "\nAnd another line!";
		* echo textile_sanitize($string);
		* 
		* @param string $string
		* @return string The sanitized string
		* @author Joost van Veen
		*/
	 
		$whitelist = '/[^a-zA-Z0-9ÜİÖĞƏÇŞüıöğəçşа-яА-ЯéртхцчшщъыэюьЁуфҐ \.\*\+\\n|#;:!"%@{} _-]/';
		return preg_replace($whitelist, '', $string);
	}

	// Qisalt
	function qisalt($metn, $uzunluq = 50)
	{

		if (strlen($metn) > $uzunluq) {

			if (function_exists("mb_substr")) {
				$metn = mb_substr($metn, 0, $uzunluq, "UTF-8") . " ...";
			} else {
				$metn = substr($metn, 0, $uzunluq) . " ...";
			}
		}
		return $metn;
		//$uzunYazi = "elgunkh - bu cox uzun yazı ve daha ne qeder uzadila biler bilmirem asdf asdf adsfads.";
		//echo qisalt($uzunYazi, 20);
	}

	function get_project_count_admin()
	{
		$ci =& get_instance();
		$result = $ci->db->select('*')->from('projects')->count_all_results();
		return $result;
	}
	function get_project_count_moderator($type='')
	{
		$ci =& get_instance();
		$result = $ci->db->select('*')->from('projects')->where('isActive',$type)->count_all_results();
		return $result;
	}

	function get_active_project_count_admin()
	{
		$ci =& get_instance();
		$result = $ci->db->select('*')->from('projects')->where('isActive', '1')->count_all_results();
		return $result;
	}

	function get_user_count_admin()
	{
		$ci =& get_instance();
		$result = $ci->db->select('*')->from('users')->where('user_status', '1')->count_all_results();
		return $result;
	}

	function get_user_count_admin_all()
	{
		$ci =& get_instance();
		$result = $ci->db->select('*')->from('users')->count_all_results();
		return $result;
	}

	function messagescount()
	{
		$ci =& get_instance();
		$result = $ci->db->select('*')->from('messages')->where('status', '0')->count_all_results();
		return $result;
	}

	function readedmessagescount()
	{
		$ci =& get_instance();
		$result = $ci->db->select('*')->from('messages')->where('status', '1')->count_all_results();
		return $result;
	}

	function getnewprojects()
	{
		$ci =& get_instance();
		$ci->db->select('projects.project_id');
		$ci->db->select('projects.isActive');
		$ci->db->select('projects.add_date');
		$ci->db->select('users.user_name');
		$ci->db->select('users.user_surname');
		$ci->db->select('project_translation.project_title');
		$ci->db->select('project_translation.project_description');
		$ci->db->select('categories.kat_adi_az');
		$ci->db->from('projects');

		$ci->db->join('project_translation', 'projects.project_id = project_translation.project_id');
		$ci->db->join('users', 'projects.user_id = users.id');
		$ci->db->join('categories', 'categories.kat_id = projects.kat_id');
		$ci->db->join('language', 'project_translation.lang_code = language.code');

		$ci->db->where('language.code', 'az');
		$ci->db->order_by('projects.project_id', 'desc');
		$ci->db->limit(15);
		$query = $ci->db->get();
		return $query->result_array();
	}

	function get_site_settings()
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from('site_settings');
		$query = $ci->db->get();
		return $query->row_array();
	}

	function get_partners()
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from('partners');
		$ci->db->where('status', 1);
		$query = $ci->db->get();
		return $query->result_array();
	}

	function get_cfcategories()
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from('cf_categories');
		$ci->db->where('status', 1);
		$query = $ci->db->get();
		return $query->result_array();
	}

	function get_recent_cfprojects()
	{
		$ci =& get_instance();
		$lang = $ci->session->userdata('language');
		if ($lang === 'Azerbaijan') {
			$l = 'az';
		}
		if ($lang === 'Russian') {
			$l = 'ru';
		}
		if ($lang === 'English') {
			$l = 'en';
		}

		$ci->load->database();
		$ci->db->select('cf_projects.*');
		$ci->db->select('cf_projects.id as project_id');
		$ci->db->select('cf_project_translation.*');

		$ci->db->from('cf_projects');

		$ci->db->join('cf_project_translation', 'cf_projects.id = cf_project_translation.project_id');
		$ci->db->join('language', 'cf_project_translation.lang_code = language.code');

		$ci->db->where('language.code', $l);
		$ci->db->where('cf_projects.status', 1);
		$ci->db->order_by('cf_projects.id', 'desc');
		$ci->db->limit('5');
		$query = $ci->db->get();
		return $query->result_array();
	}

	function cfproject_image($id = '')
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('image');
		$ci->db->from('cf_projects');
		$ci->db->where('id', $id);
		$query = $ci->db->get();
		return $query->row_array();
	}

	function get_cfproject_translations($id = '')
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from('cf_project_translation');
		$ci->db->where('project_id', $id);
		$query = $ci->db->get();
		return $query->result_array();
	}

	function get_regions()
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from('regions');
		$query = $ci->db->get();
		return $query->result_array();
	}

	function get_categories()
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from('categories');
		$ci->db->where('status','1');
		$query = $ci->db->get();
		return $query->result_array();
	}

	function get_doing_business_detail($id = '')
	{
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from('sliders');
		$ci->db->where('id', $id);
		$query = $ci->db->get();
		return $query->row_array();
	}

	function get_project_count($category_id = '')
	{
		if ($category_id) {
			$ci =& get_instance();
			$result = $ci->db->select('*')->from('projects')->where('isActive', '1')->where('kat_id', $category_id)->count_all_results();
			return $result;
		} else {
			$ci =& get_instance();
			$result = $ci->db->select('*')->from('projects')->join('categories', 'categories.kat_id = projects.kat_id')->where('isActive', '1')->where('categories.status', '1')->count_all_results();
			return $result;
		}

	}
    function media($file = ''){
		$url =  './'.$file;
		if(file_exists($url)){
			return base_url($file);
		}else{
		return base_url('files/projectimages/noimage.jpg');
	}
	}
	function seflink($str, $options = array())
	{
		$str = mb_convert_encoding((string)$str, 'UTF-8', mb_list_encodings());
		$defaults = array(
			'delimiter' => '-',
			'limit' => null,
			'lowercase' => true,
			'replacements' => array(),
			'transliterate' => true
		);
		$options = array_merge($defaults, $options);
		$char_map = array(
			// Latin
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
			'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
			'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
			'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
			'ß' => 'ss',
			'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
			'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
			'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
			'ÿ' => 'y', 'ə' => 'e', 'Ə' => 'e',
			// Latin symbols
			'©' => '(c)',
			// Greek
			'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
			'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
			'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
			'Ϋ' => 'Y',
			'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
			'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
			'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
			'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',
			// Turkish
			'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',
			// Russian
			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
			'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
			'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
			'Я' => 'Ya',
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
			'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
			'я' => 'ya',
			// Ukrainian
			'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
			'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',
			// Czech
			'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
			'Ž' => 'Z',
			'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
			'ž' => 'z',
			// Polish
			'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
			'Ż' => 'Z',
			'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
			'ż' => 'z',
			// Latvian
			'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
			'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
			'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
			'š' => 's', 'ū' => 'u', 'ž' => 'z'
		);
		$str = preg_replace(array_keys($options['replacements']), $options['replacements'], $str);
		if ($options['transliterate']) {
			$str = str_replace(array_keys($char_map), $char_map, $str);
		}
		$str = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $str);
		$str = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $str);
		$str = mb_substr($str, 0, ($options['limit'] ? $options['limit'] : mb_strlen($str, 'UTF-8')), 'UTF-8');
		$str = trim($str, $options['delimiter']);
		return $options['lowercase'] ? mb_strtolower($str, 'UTF-8') : $str;
	}

	if (!function_exists('findJavaScriptCodes')) {

	function findJavaScriptCodes($pdfFile) {
	    $pdfContent = file_get_contents($pdfFile);
	    $jsPattern = '/\/JS\s*\((.*?)\)/s';
	    preg_match_all($jsPattern, $pdfContent, $matches);
	    return !empty($matches[1]) ? $matches[1] : [];
	}

}

?>
