<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('PID', "C0000");
class Welcome extends CI_Controller {

    public function __construct(){
        
        parent::__construct();
        
        $this->load->model(array('welcome_model'));
        
        $this->load->helper('url');
        $this->load->helper('form');
        //$this->load->library('excelxml');
        // PHPExcel 라이브러리 로드 
        $this->load->library('excel');
        
        $this->load->helper('url');
        //$this->load->helper('alert');

        
        $this->load->library('util');
        $this->load->library('jikje');
        

        
    }
    
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
	    
	    
	    
	    $sabun = $this->input->get('sabun');
	    $sabun = base64_decode($sabun);
	    
	    if($this->session->userdata('ssabun')){
	    
	        Util::gotoUrl('/index.php/welcome/list_collect');
	        
	    }else{
	        
    	    
    	    if($sabun){
        	    
        	    //세션등록
        	    $data = array(
        	        'ssabun' => $sabun,
        	        'ssname' => $ssname,
        	        'sosok' => $sosok,
        	        'isLogin' => TRUE,
        	        'isLevel' => $isLevel,
        	        'CS_BU_CODE' => $cs_bu_code
        	        
        	    );
        	    
        	    $this->session->set_userdata($data);
        	    Util::gotoUrl('/index.php/welcome/list_collect');
        	    
    	    
    	    }else{
    	       
    	    }
	    }
	    
	    
	}
	
	
	public function list_collect(){
	    
	    //검색어
	    $field = $this->input->post('field');
	    $keyword = $this->input->post('keyword');
	    
	    
	    
	    
	    
	    $search_word = $page_url = "";
	    $uri_segment = 4;//
	    
	    $uri_array = $this->segment_explode($this->uri->uri_string());
	    
	    
	    if(in_array("q", $uri_array)){
	        
	        $search_word = urldecode($this->url_explode($uri_array, 'q'));  //keyword1|keyword2
	        
	        
	        
	        $searcharr = explode("-", $search_word);
	        
	        $field = $searcharr[0];
	        $keyword = $searcharr[1];
	        
	        
	        $page_url = "/q/" . $field . "-" . $keyword;
	        
	        $uri_segment = 6;       //검색어가 있는 부분
	        
	    }
	    
	    
	    $data['field'] = $field;
	    $data['keyword'] = $keyword;
	    
	    //검색어 모델로 넘기기
	    $param = array();
	    $param['field'] = $field;
	    $param['keyword'] = $keyword;
	    
	    //echo $this->db->count_all('TB_JARYO');
	    
	    $data['total_rows'] = $this->jaryor_model->countAll($param);
	    
	    if($data['total_rows']){
	        
	        
	        $this->load->library('pagination');
	        $baseurl = "/index.php/welcome/list_collect/";
	        
	        //$uri_segment = 6;//
	        
	        $config['base_url'] = $baseurl . $page_url . "/page/";
	        $config['total_rows'] = $data['total_rows'];
	        $config['per_page'] = 10;
	        $config['num_links'] = 5;
	        $config['url_segment'] = $uri_segment;
	        $config['first_link'] = "처음";
	        $config['next_link'] = "다음";
	        $config['prev_link'] = "이전";
	        $config['last_link'] = "마지막";
	        //$config['page_query_string'] = TRUE;
	        
	        
	        
	        $data['per_page'] = $config['per_page'];
	        
	        $this->pagination->initialize($config);
	        $data['page_links'] = $this->pagination->create_links();
	        
	        $page = $this->uri->segment($uri_segment,1);
	        
	        
	        
	        if($page > 1){
	            $start = ($page/$config['per_page']) * $config['per_page'];
	        }else{
	            $start = ($page - 1) * $config['per_page'];
	        }
	        
	        
	        $data['page'] = $page;
	        
	        $limit = $config['per_page'];
	        $data['result'] = $this->jaryor_model->getLimit($param, $start, $limit);
	        
	    }else{
	        $data['result'] = null;
	    }
	    
	    
	    //로그인한 사용자가 작성한 자료
	    $mywrite = $this->welcome_model->getMywrite();
	    
	    $data['mywrite'] = $mywrite;
	    
	    
	    //로그인한 사용자가 결재요청한 게시물
	    $myapp = $this->welcome_model->getLoginAns();
	        
	    $data['myapp'] = $myapp;
	        
	    
	    
	    
	    
	    $this->load->view('common/header');
	    $this->load->view('common/top_menu');
	    
	    $this->load->view('main/list', $data);
	    $this->load->view('common/footer');
	    
	    
	    
	    
	    
	    
	    
	}
	
	
	public function logout(){
	    
	    
	    //$this->session->unset_userdata('ssabun');
	    $this->session->sess_destroy();
	    
	    //alert_redirect("로그아웃되었습니다.", "/index.php/");
	}
	
	
	
	function url_explode($url, $key){
	    
	    $cnt = count($url);
	    
	    for($i=0; $i<$cnt; $i++){
	        
	        if($url[$i]==$key){
	            $k = $i+1;
	            return $url[$k];
	            
	        }
	    }
	}
	
	
	function segment_explode($seg){
	    
	    $len = strlen($seg);
	    if(substr($seg, 0, 1)=='/'){
	        $seg = substr($seg, 0, $len);
	    }
	    
	    $len = strlen($seg);
	    if(substr($seg, -1)=='/'){
	        $seg = substr($seg, 0, $len-1);
	    }
	    
	    $seg_exp = explode('/', $seg);
	    return $seg_exp;
	}
	
	
	
}
