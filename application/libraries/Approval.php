<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Approval {
    
    public function Approval(){
        
        $this->CI =& get_instance();
        
        $this->CI->load->library('jikje');
        $this->CI->load->model(array('approval_model', 'jikje_model'));
    }
    
    
    
    //결재단계별 결재자 정보 모두 가져오기
    public function get_approval($param){
        
        $j_num = $param['j_num'];
        $dept_code = $param['dept_code'];
        
        $param = array(
            'J_NUM'=>$j_num, 
            'DEPT_CODE'=>$dept_code
            
        );
        
        $query = $this->CI->approval_model->get_approval($param);
        
        //$this->CI->db->order_by('APP_STEP', 'ASC');
        //$query = $this->CI->db->get_where('TB_ANSWER_APP', $param);        
        return $query;
       
        
    }
    

    public function approval_action_name($param){
        
        $app_sabun = $param['app_sabun'];
        $app_date = $param['app_date'];
        $app_comment = $param['app_comment'];
        
        unset($result);
        
        // 미결재
        if(! empty($app_sabun) && $app_date == "") {
            $result = "<span style=\"color:#00f\"><b>대기</b></span>";
        }
        
        // 결재 처리되면 날짜 출력
        if(! empty($app_sabun) && $app_date != "") {
            
            $param = array('sabun' => $app_sabun);
            $member_name = $this->CI->jikje->getName($param);
            
            $result = "<span style='color:#000; font-family:궁서; font-size:14px'>" . $member_name . "</span>";
        }
        
        // 반려된 결재 출력
        if(! empty($app_sabun) && $app_date != "" && ! empty($app_comment)) {
            $result = "<span style=\"color:#f00;\"><b>반려</b></span>";
        }
        
        return $result;
        
        
    }
    
    
    //현재 결재자 상태정보 출력
    public function approval_action($param){
        
        $j_num = $param['j_num'];
        $app_no = $param['app_no'];
        $app_step = $param['app_step'];
        $app_sabun = $param['app_sabun'];
        $app_date = $param['app_date'];
        $app_comment = $param['app_comment'];
        $app_comment_name = $param['app_comment_name'];
        $login_sabun = $param['login_sabun'];
        
        

        unset($result);
        // 미결재
        if(! empty($app_sabun) && $app_date == "" && $return_yn=="") {
            //echo "tset";
            if($app_sabun == $login_sabun ) {
                
                $result = "<a href=\"javascript:approval_action('sign','{$app_sabun}','{$app_no}','{$app_comment_name}', '{$app_step}');\" class=\"bbs_e\">결재</a>";
                
                // 1차 결재자는 반려 출력하지 않음
                if($app_step > 0 ) {
                    $result .= "&nbsp;<a  href=\"javascript:approval_action('return','{$app_sabun}','{$app_no}','{$app_comment_name}', '{$app_step}');\" class=\"bbs_d\">반려</a></td>\r\n</tr>\r\n<tr>\r\n    <td class=\"write_dot write_head\" align=\"center\">";
                    $result .= "<label for=\"{$app_comment_name}\">반려내용</label>";
                    $result .= "</td>\r\n    <td colspan=\"4\" class=\"write_dot\"><input type=\"text\" size=\"100\" name=\"{$app_comment_name}\" id=\"{$app_comment_name}\" maxlength='200' class=\"frm_input required\">\r\n";
                }
                
            }
        }
        
        // 결재 처리되면 날짜 출력
        if(! empty($app_sabun) && $app_date != "") {
            $result = $app_date;
        }
        
        // 반려된 결재 출력
        if(! empty($app_sabun) && $app_date != "" && ! empty($app_comment)) {
            $return_yn = "true";
            $result = "<span style='color:#f00;'>".$app_date ."</span></td>\r\n</tr>\r\n<tr>\r\n    <td class=\"write_dot write_head2\" align=\"center\">반려내용</td>\r\n    <td colspan=\"4\" class=\"write_dot write_head2 returntxt\">$app_comment\r\n";
        }
        return $result;
    }
    
}