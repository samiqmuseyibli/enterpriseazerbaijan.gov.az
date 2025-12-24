<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class All_model extends CI_Model {

	public function __construct() {
		parent::__construct();
	}

	public function upload_cover($post = '', $folder = '', $fullwidth = '', $fullheight = '', $tmbwidth = '', $tmbheight = '', $miniwidth = '', $miniheight = '', $slide_status = false, $slidewidth = '', $slideheight = '',$wmsource = false) {

		$imagetmb = '';
		$imagemini = '';
		$imagefull = '';
		$imageslide = '';

		if ($_FILES[$post]['name']) {
			$config['upload_path'] = FCPATH . 'files/' . $folder . '/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['max_size'] = 10000;
			$config['encrypt_name'] = true;
			$this->load->library('upload', $config);
			if ($this->upload->do_upload($post)) {
				$image1 = $this->upload->data();
				$imagepath = $image1['file_name'];

				$imagetmb = 'files/' . $folder . '/tmb/' . $imagepath . '';
				$imagemini = 'files/' . $folder . '/mini/' . $imagepath . '';
				$imagefull = 'files/' . $folder . '/full/' . $imagepath . '';
				if ($slide_status){
				$imageslide = 'files/' . $folder . '/slide/' . $imagepath . '';
			    }

				$source_image = 'files/' . $folder . '/' . $imagepath . '';
				if ($wmsource == true) {
					$wmsource = 'files/wm/wm.png';
				}
				//tmb
				$destination = 'files/' . $folder . '/tmb/' . $imagepath . '';
				$tn_w = $tmbwidth;
				$tn_h = $tmbheight;
				$quality = 70;
				$this->image_handler($source_image, $destination, $tn_w, $tn_h, $quality);

				//mini
				$destination = 'files/' . $folder . '/mini/' . $imagepath . '';
				$tn_w = $miniwidth;
				$tn_h = $miniheight;
				$quality = 95;
				$this->image_handler($source_image, $destination, $tn_w, $tn_h, $quality);

				//full
				copy('./files/' . $folder . '/' . $imagepath . '', './files/' . $folder . '/full/' . $imagepath);
			    $data_['full_path'] = 'files/' . $folder . '/full/' . $imagepath; 
				$this->thumb($data_, 1200, false);     
				// $destination = 'files/' . $folder . '/full/' . $imagepath . '';
				// $tn_w = $fullwidth;
				// $tn_h = $fullheight;
				// $quality = 99;
				// $this->image_handler($source_image, $destination, $tn_w, $tn_h, $quality);

				// if ($slide_status){
				// //slide
				// $destination = 'files/' . $folder . '/slide/' . $imagepath . '';
				// $tn_w = $slidewidth;
				// $tn_h = $slideheight;
				// $quality = 99;
				// $this->image_handler($source_image, $destination, $tn_w, $tn_h, $quality);	
				// $slide_image_url = array('image_slide' => $imageslide );
				// }

				$cover_images = array(
					'image_full' => $imagefull,
					'image_tmb' => $imagetmb,
					'image_mini' => $imagemini,
				);
				// if ($slide_status){
                //      $cover_images = array_merge($cover_images, $slide_image_url);
				// }
				if ($cover_images['image_full'] != '') {
					$original_image = './' . $source_image;
					if (file_exists($original_image)) {
						unlink($original_image);
					}
					return $cover_images;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}

	}
	public function image_handler($source_image, $destination, $tn_w = 100, $tn_h = 100, $quality = 80, $wmsource = false) {
		// The getimagesize functions provides an "imagetype" string contstant, which can be passed to the image_type_to_mime_type function for the corresponding mime type
		$info = getimagesize($source_image);
		$imgtype = image_type_to_mime_type($info[2]);
		// Then the mime type can be used to call the correct function to generate an image resource from the provided image
		switch ($imgtype) {
		case 'image/jpeg':
			$source = imagecreatefromjpeg($source_image);
			break;
		case 'image/gif':
			$source = imagecreatefromgif($source_image);
			break;
		case 'image/png':
			$source = imagecreatefrompng($source_image);
			break;
		default:
			die('Invalid image type.');
		}
		// Now, we can determine the dimensions of the provided image, and calculate the width/height ratio
		$exif = exif_read_data($source_image);
		if (!empty($exif['Orientation'])) {
			switch ($exif['Orientation']) {
			case 8:
				$source = imagerotate($source, 90, 0);
				break;
			case 3:
				$source = imagerotate($source, 180, 0);
				break;
			case 6:
				$source = imagerotate($source, -90, 0);
				break;
			}
		}
		$src_w = imagesx($source);
		$src_h = imagesy($source);
		$src_ratio = $src_w / $src_h;
		// Now we can use the power of math to determine whether the image needs to be cropped to fit the new dimensions, and if so then whether it should be cropped vertically or horizontally. We're just going to crop from the center to keep this simple.
		if ($tn_w / $tn_h > $src_ratio) {
			$new_h = $tn_w / $src_ratio;
			$new_w = $tn_w;
		} else {
			$new_w = $tn_h * $src_ratio;
			$new_h = $tn_h;
		}
		$x_mid = $new_w / 2;
		$y_mid = $new_h / 2;
		// Now actually apply the crop and resize!
		$newpic = imagecreatetruecolor(round($new_w), round($new_h));
		imagecopyresampled($newpic, $source, 0, 0, 0, 0, $new_w, $new_h, $src_w, $src_h);
		$final = imagecreatetruecolor($tn_w, $tn_h);
		imagecopyresampled($final, $newpic, 0, 0, ($x_mid - ($tn_w / 2)), ($y_mid - ($tn_h / 2)), $tn_w, $tn_h, $tn_w, $tn_h);

		// If a watermark source file is specified, get the information about the watermark as well. This is the same thing we did above for the source image.
		if ($wmsource) {
			$info = getimagesize($wmsource);
			$imgtype = image_type_to_mime_type($info[2]);
			switch ($imgtype) {
			case 'image/jpeg':
				$watermark = imagecreatefromjpeg($wmsource);
				break;
			case 'image/gif':
				$watermark = imagecreatefromgif($wmsource);
				break;
			case 'image/png':
				$watermark = imagecreatefrompng($wmsource);
				break;
			default:
				die('Invalid watermark type.');
			}
			// Determine the size of the watermark, because we're going to specify the placement from the top left corner of the watermark image, so the width and height of the watermark matter.
			$wm_w = imagesx($watermark);
			$wm_h = imagesy($watermark);
			// Now, figure out the values to place the watermark in the bottom right hand corner. You could set one or both of the variables to "0" to watermark the opposite corners, or do your own math to put it somewhere else.
			$wm_x = $tn_w - $wm_w;
			$wm_y = $tn_h - $wm_h;
			// Copy the watermark onto the original image
			// The last 4 arguments just mean to copy the entire watermark
			imagecopy($final, $watermark, $wm_x, $wm_y, 0, 0, $tn_w, $tn_h);
		}
		// Ok, save the output as a jpeg, to the specified destination path at the desired quality.
		// You could use imagepng or imagegif here if you wanted to output those file types instead.

		if (Imagejpeg($final, $destination, $quality)) {
			return true;
		}
		// If something went wrong
		return false;
	}
	public function upload_files($post = '', $folder = '', $id = '') {
		$can = true;
		$allowTypes = array('jpg', 'png', 'jpeg');
		foreach ($_FILES[$post]['name'] as $key => $val) {
			$fileName = basename($_FILES[$post]['name'][$key]);
			$targetFilePath = './files/' . $folder . '/' . $fileName;
			$fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
			if (!in_array($fileType, $allowTypes)) {
				$can = false;
			}
		}

		if ($can == true) {
			$i_sort = 0;
			foreach ($_FILES[$post]['name'] as $key => $val) {
				$i_sort++;
				$fileName = basename($_FILES[$post]['name'][$key]);
				$targetFilePath = './files/' . $folder . '/' . $fileName;
				$fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
				$new_image_name = substr(md5(sha1(time())), 12) . rand(1111, 9999) . '.' . $fileType;
				move_uploaded_file($_FILES[$post]["tmp_name"][$key], './files/' . $folder . '/' . $new_image_name);
				$data['files_url_full'] = 'files/' . $folder . '/full/' . $new_image_name;
				$data['files_url_tmb'] = 'files/' . $folder . '/tmb/' . $new_image_name;
				$data['files_url_mini'] = 'files/' . $folder . '/mini/' . $new_image_name;
				$data['files_type'] = $folder;
				$data['files_type_id'] = $id;
				$data['files_sort'] = $i_sort;
				$this->db->insert('files', $data);
				// tmb
				$source_image = 'files/' . $folder . '/' . $new_image_name;
				$destination = 'files/' . $folder . '/tmb/' . $new_image_name;
				$tn_w = 800;
				$tn_h = 550;
				$quality = 80;
				$this->image_handler($source_image, $destination, $tn_w, $tn_h, $quality);
				//mini
				$destination = 'files/' . $folder . '/mini/' . $new_image_name;
				$tn_w = 80;
				$tn_h = 80;
				$quality = 70;
				$this->image_handler($source_image, $destination, $tn_w, $tn_h, $quality);

				//full
				
				copy('./files/' . $folder . '/' . $new_image_name , './files/' . $folder . '/full/' . $new_image_name);

			      
				// $destination = 'files/' . $folder . '/full/' . $new_image_name;
				// $tn_w = 800;
				// $tn_h = 600;
				// $quality = 99;
				// $wmsource = 'files/wm/wm.png';
				// $this->image_handler($source_image, $destination, $tn_w, $tn_h, $quality);

				$original_image = './files/' . $folder . '/' . $new_image_name;
				if (file_exists($original_image)) {
					unlink($original_image);
				}

				$this->load->library('image_lib');

				$config_res['image_library']  = 'gd2';    
				$config_res['source_image']   = 'files/' . $folder . '/full/' . $new_image_name;      
				$config_res['create_thumb']   = false;    
				$config_res['maintain_ratio'] = TRUE;    
				$config_res['width']          = 1200;  

				$this->image_lib->initialize($config_res);
			    $this->image_lib->resize();
			    $this->image_lib->clear();  


			}
			return true;
		} else {
			return 'file_type_error';
		}
	}

	public function upload_image($post = '', $folder = '' , $width = '') {

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
		$this->load->library('image_lib');

		$config['image_library']  = 'gd2';    
		$config['source_image']   = $data['full_path'];      
		$config['create_thumb']   = $create_thumb;    
		$config['maintain_ratio'] = TRUE;    
		$config['width']          = $width;      
		$this->image_lib->initialize($config);
		$this->image_lib->resize();
		$this->image_lib->clear();  
	}     

	public function upload_file($post = '', $folder = '', $file_type = 'pdf|doc|docx', $file_size = '200000') {

		$config['upload_path'] = './' . $folder;
		$config['allowed_types'] = $file_type;
		$config['max_size'] = $file_size;
		$config['encrypt_name'] = true;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($this->upload->do_upload($post)) {
			$image = $this->upload->data();
			return $folder . '/' . $image['file_name'];
		} else {
            $response['status'] = '100';
			$response['message'] = $this->upload->display_errors();
			echo json_encode($response);
			exit();
		}
	}
	public function upload_file_for_te_review($post = '', $folder = '', $file_name = '', $file_type = 'pdf|doc|docx', $file_size = '200000') {

		$new_file_name  = $file_name. '_' .$post. '.' . pathinfo($_FILES[$post]['name'], PATHINFO_EXTENSION);

		$config['upload_path']   = './' . $folder;
		$config['allowed_types'] = $file_type;
		$config['max_size']      = $file_size;
		$config['file_name']     = $new_file_name;

		$this->load->library('upload', $config);
		$this->upload->initialize($config);

		if ($this->upload->do_upload($post)) {
			$image = $this->upload->data();
			return $folder . '/' . $image['file_name'];
		} else {
            $response['status'] = '100';
			$response['message'] = $this->upload->display_errors();
			echo json_encode($response);
			exit();
		}
	}

	public function mail_exists($email = '', $table = '') {
		$this->db->where($table . '_email', $email);
		$query = $this->db->get($table);
		if ($query->num_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function _delete($table = '', $id = '') {
		$this->db->where($table . '_id', $id);
		if ($this->db->delete($table)) {
			return true;
		}
	}
	public function delete($table = '', $row = '', $id = '') {
		$this->db->where($row, $id);
		if ($this->db->delete($table)) {
			return true;
		}
	}
	public function _update($table = '', $row = '', $id = '', $data = '') {

		$this->db->where($row, $id);
		if ($this->db->update($table, $data)) {
			return true;
		} else {
			return false;
		}
	}
	public function _add($table = '', $data = '') {
		if ($this->db->insert($table, $data)) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}


	public function getSearch($key){


    $ci = & get_instance();

    $lang  = $ci->session->userdata('lang');

    $sql = "SELECT `news`.`news_id` AS 'id',
                   `news`.`news_title_".$lang."` AS `title`,
                   `news`.`news_status` AS `file_url`,
                   `news`.`news_createdAt` AS 'date',
                   'news' AS 'type'
            FROM `news`

            WHERE  ( `news`.`news_title_".$lang."`  LIKE '%" . $ci->db->escape_like_str($key) . "%'
                                                                                    OR `news`.`news_body_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%') 
                                                                                    AND `news`.`news_status` = '1' 

            UNION

            SELECT `reviews`.`review_id` AS 'id',
                   `reviews`.`review_title_".$lang."` AS `title`,
                   `reviews`.`review_doc_".$lang."` AS `file_url`,
                   `reviews`.`review_createdAt` AS 'date',
                   'review' AS 'type'
            FROM `reviews`
       
            WHERE  ( `reviews`.`review_title_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%'
                                                                                OR `reviews`.`review_body_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%')
                                                                                        AND `reviews`.`review_status` = 'on'


            UNION

            SELECT `publications`.`p_id` AS 'id',
                   `publications`.`p_title_".$lang."` AS `title`,
                   `publications`.`p_doc_".$lang."` AS `file_url`,
                   `publications`.`p_createdAt` AS 'date',
                   'publications' AS 'type'
            FROM `publications`
       
            WHERE  ( `publications`.`p_title_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%'
                                                                                OR `publications`.`p_body_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%')
                                                                                
            UNION

            SELECT `trainings`.`t_id` AS 'id',
                   `trainings`.`t_title_".$lang."` AS `title`,
                   `trainings`.`t_title_".$lang."` AS `file_url`,
                   `trainings`.`t_createdAt` AS 'date',
                   'trainings' AS 'type'
            FROM `trainings`
       
            WHERE  ( `trainings`.`t_title_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%'
                                                                                OR `trainings`.`t_body_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%')

            UNION

            SELECT `te_reviews`.`review_id` AS 'id',
                   `te_reviews`.`review_title_".$lang."` AS `title`,
                   `te_reviews`.`review_doc_".$lang."` AS `file_url`,
                   `te_reviews`.`review_createdAt` AS 'date',
                   'te_reviews' AS 'type'
            FROM `te_reviews`
       
            WHERE  ( `te_reviews`.`review_title_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%')                                                                   

            UNION

            SELECT `article`.`article_id` AS 'id',
                   `article`.`article_title_".$lang."` AS `title`,
                   `article`.`article_slug` AS `file_url`,
                   `article`.`article_createdAt` AS 'date',
                   'article' AS 'type'
            FROM `article`
       
            WHERE  ( `article`.`article_title_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%'
                                                                                OR `article`.`article_body_".$lang."` LIKE '%" . $ci->db->escape_like_str($key) . "%')

                                                                                ORDER BY date DESC";

    $query = $ci->db->query($sql);
    $result = $query->result_array();

    return $result;
  }

	

}
