<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
define('PID', "C4000");

class Common extends CI_Controller {
    
    
    public function __construct() {
        
        
        parent::__construct();
        
        $this->load->model(array('common_model'));
        
        
        if(!$this->session->userdata('ssabun')){
            Util::alert_redirect("로그인 정보가 없습니다.", '/index.php/');
            
        }
        
    }
    
    
    

    
    
    public function option_name() {

    }
    
    
    
   

    
    
    
}