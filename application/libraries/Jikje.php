<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jikje {
    
    public function Jikje(){
        
        $this->CI =& get_instance();
        $this->CI->load->model(array('jikje_model'));
        
    }

    
    //사번으로 이름 가져오기
    public function getName($sabun){
        
        $param = array(
            'sabun' => $sabun
        );
        
        $data = $this->CI->jikje_model->getName($param);
        return $data->INSA_NAME;
        


    }
    
    
    //소속 > 부서 > [직위]성명 조회
    public function get_buserAndName($sabun){
        
        $param = array(
            'sabun' => $sabun
        );
        
        $data = $this->CI->jikje_model->get_buserAndName($param);
        
        

        
        $sosil = $data->NAME;
        $res['buser'] = $sosil;
        $res['name'] = $data->POSITION . " " . $data->MEMBER_NAME;
        
        return $res;
                
    }
    
    
    //사번으로 팀코드 조회
    public function getTeamCode($sabun){
        
        $param = array('sabun' => $sabun);
        
        $data = $this->CI->jikje_model->getTeamCode($param);
        
        return $data->TEAM;
        
    }
    
    //부서코드로 부서명 조회
    public function getTeamName($dept_code){
        
        $param = array('code' => $dept_code);
        
        $data = $this->CI->jikje_model->getTeamName($param);
        
        return $data;
        
    }
    

    
    public function option_name() {
        
        $buser = $this->input->post('bucode');
        $name = $this->input->post('sabun');
        
        
        
        $data = $this->common_model->getName($buser);
        
        $option_name = "";
        if(! empty($buser)) {
            unset($option_name);
            foreach($data as $item){
                $user = trim($item['INSA_LEVEL']) . " " . trim($item['INSA_NAME']);
                $sabun = trim($item['INSA_SABUN']);
                
                if($name == $sabun) {
                    $option_name .= "<option value='" . $item['INSA_SABUN'] . "' selected>" . $user . "</option>";
                }
                else {
                    $option_name .= "<option value='" . $item['INSA_SABUN'] . "'>" . $user . "</option>";
                }
            }
            
            echo $option_name;
        }
        else {
            return;
        }
    }
    
    
    
    
}