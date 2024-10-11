<?php
	if (!defined('BASEPATH'))exit('No direct script access allowed');
	
	class Email_model extends CI_Model{
		
		function __construct(){
			parent::__construct();
			$this->load->library('email');
		}
		
		
		
		
		
		function sendMail($to, $subject, $message){
			
			$from       = 'no-reply@enterpriseazerbaijan.gov.az';
			$from_name  = 'Enterprise Azerbaijan';

			$config = array(

				'smtp_keepalive'  => true,
				'protocol'     	  => 'smtp',
				'smtp_host'    	  => 'www.mail.gov.az',
				'smtp_port'    	  =>  587,
				'smtp_user'    	  => 'no-reply@enterpriseazerbaijan.gov.az',
				'smtp_pass'    	  => '-PNE65#m21*h@23sd',
				'mailtype'     	  => 'html',
				'charset'      	  => 'utf-8',
				'smtp_crypto'  	  => 'tls',
				'priority'     	  => '3',
				'smtp_timeout' 	  => '7',
				'validation'   	  =>  true,
				'newline'      	  => "\r\n",
				'wordwrap'     	  =>  true,
				'MIME-Version' 	  => '1.0',   
				//'header'		  => 'MIME-Version: 1.0',
				//'header' 		  => 'Content-type:html;charset=UTF-8'
			);
      
			$this->email->initialize($config);
			$this->email->set_mailtype("html");
			$this->email->from($from, $from_name);
			$this->email->to($to); 
			$this->email->subject($subject);

			$this->email->message($message);			
			if($this->email->send()){
				return true;
			}else{
				return $this->email->print_debugger(array('headers'));
			}
		}
	}
?>