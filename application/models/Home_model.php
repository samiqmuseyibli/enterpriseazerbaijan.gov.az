<?php
	
	defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Home_model extends CI_Model{
		
		public function __construct(){
			parent ::__construct();
			$this->load->library('user_agent');
		}
		
		function record_count_all_news() {
		   $this->db->where('status',1);
		   $this->db->from('news');  
		   return $this->db->count_all_results();  
        }

        function get_slider_news($limit = ""){ 
			$l=curLang();
			$this->db->select('title_'.$l.'');
			$this->db->select('top_'.$l.'');
			$this->db->select('content_'.$l.'');
			$this->db->select('id');
			$this->db->select('url_image');
			$this->db->select('date');
			$this->db->select('readed');
			$this->db->from('news');
			$this->db->where('status',1);
			$this->db->order_by('date', 'desc');
			$this->db->limit($limit);
			$query = $this->db->get();
			return $query->result_array();  
		}
		
		function get_sliders(){ 
			$this->db->select('*');
			$this->db->from('sliders');
			$this->db->where('status',1);
			$query = $this->db->get();
			return $query->result_array();  
		}
		
		function get_slider($id){ 
			$this->db->select('*');
			$this->db->from('sliders');
			$this->db->where('status',1);
			$this->db->where('id',$id);
			$query = $this->db->get();
			return $query->row_array();  
		}
		
		function get_news($limit,$start){ 
			$l=curLang();
			$this->db->select('title_'.$l.'');
			$this->db->select('top_'.$l.'');
			$this->db->select('content_'.$l.'');
			$this->db->select('id');
			$this->db->select('url_image');
			$this->db->select('date');
			$this->db->select('readed');
			$this->db->from('news');
			$this->db->where('status',1);
			$this->db->limit($limit, $start);
			$this->db->order_by('date', 'desc');
			$query = $this->db->get();
			return $query->result_array();  
		}
		
		function get_related_news(){ 
			$l=curLang();
			$this->db->select('title_'.$l.'');
			$this->db->select('top_'.$l.'');
			$this->db->select('content_'.$l.'');
			$this->db->select('id');
			$this->db->select('url_image');
			$this->db->select('date');
			$this->db->select('readed');
			$this->db->from('news');
			$this->db->where('status',1);
			$this->db->order_by('date', 'desc');
			$this->db->limit(9);
			$query = $this->db->get();
			return $query->result_array();  
		}
		
		function get_news_by_id($id){
			$l=curLang();
			$this->db->set('readed', 'readed+1', FALSE);
			$this->db->where('id',$id);
			$this->db->update('news');  
			$this->db->select('title_'.$l.'');
			$this->db->select('content_'.$l.'');
			$this->db->select('id');
			$this->db->select('url_image');
			$this->db->select('date');
			$this->db->select('readed');
			$this->db->from('news');
			$this->db->where('status',1);
			$this->db->where('id',$id);   
			$query = $this->db->get();
			return $query->row_array(); 
		}
		
		function add_daily_reytinq(){
			$client_ip = $this->input->ip_address();         
			$browser = $this->agent->browser();
			$browserVersion = $this->agent->version();
			$platform = $this->agent->platform();
			
            $reytinq_data = array(
                'client_ip' => $client_ip,
                'borwser'=>$browser.' | '.$browserVersion.' | '. $platform,
                'date'=>date('d-m-Y'),
            );
			$this->db->insert('reytinq_daily', $reytinq_data);
        }  
        
		function get_termsofuse(){
			$l=curLang();
			$this->db->select('content_'.$l.' as content');  
			$this->db->from('terms_of_use'); 
			$query = $this->db->get();
			return $query->row_array();  
		}
		
		function get_privacy(){ 
			$l=curLang();
			$this->db->select('content_'.$l.' as content');  
			$this->db->from('privacy'); 
			$query = $this->db->get();
			return $query->row_array();  
		}
    
		// xidmətlərimiz bölməsi
		function get_services() { 
			$l=curLang();
			$this->db->select('content_'.$l.' as content');  
			$this->db->from('services'); 
			$query = $this->db->get();
			return $query->row_array();  
		}
	}

?>