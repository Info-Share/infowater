<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('PID', "M5000");
/**********************************************************
 프로그램명 : Approval_model.php
 타입 : 모델
 용도 : 결재
 경로 : /models/Approval_model.php
 작성자 : 양찬우
 소속 : (주)비전아이티
 일자 : 18.07.11
 프로그램설명
 결재
 **프로그램이력**
 수정일          작업근거             유지보수담당
 '18.07.14       최초생성             양찬우
 **********************************************************/
class Approval_model extends CI_Model {
    
    
    //결재자정보  
    public function get_approval($data){
        
        $j_num = $data['J_NUM'];
        $dept_code = $data['DEPT_CODE'];
        
        $sql = "SELECT * FROM (
                    SELECT 
                        IDX, J_NUM, SABUN, DEPT_CODE, APP_STEP, APP_STATUS, RETURN_REASON, TO_CHAR(APP_DATE, 'YYYY-MM-DD HH24:MI:SS') AS APP_DATE, APP_IP 
                    FROM 
                        TB_ANSWER_APP
                    WHERE 
                        J_NUM = ?
                        AND DEPT_CODE = ?
                    ORDER BY IDX
                )";
        $param = array();
        $param[] = $j_num;
        $param[] = $dept_code;
        $query = $this->db->query($sql, $param);
        return $query->result_array();
        
    }
    
    
    //결재승인
    public function app_sign($data){
        
        $j_num = $data['J_NUM'];
        $idx = $data['idx'];
        $app_id = $data['app_id'];
        $app_sabun = $data['app_sabun'];
        $app_action = $data['app_action'];
        $app_comment = $data['app_comment'];
        $app_step = $data['app_step'];
        $dept_code = $data['dept_code'];
        
        
        //1. 결재정보 업데이트
        $sql = "UPDATE TB_ANSWER_APP SET 
                    APP_STATUS = 2,
                    APP_DATE = SYSDATE,
                    APP_IP = ?
                WHERE
                    IDX = ?
            ";
        $param = array();
        $param[] = $this->input->ip_address();
        $param[] = $app_id;
        $this->db->query($sql, $param);
        
        
        

    }
    
    
    
    //결재 후 게시물 업데이트
    public function setAppstatus($data){
        
        
        $j_num = $data['j_num'];
        $idx = $data['idx'];
        $app_id = $data['app_id'];
        $app_sabun = $data['app_sabun'];
        $app_action = $data['app_action'];
        $app_comment = $data['app_comment'];
        $app_step = $data['app_step'];
        $dept_code = $data['dept_code'];
        
        
        //2. 게시물 정보업데이트
        $app_stat = "";
        if($app_step == "2"){
            $app_stat = "결재완료";
        }elseif($app_step == "1"){
            $app_stat = "결재중";
        }
        
        if($app_action == "return"){
           $app_stat = "반려"; 
        }
        
        $sql2 = "UPDATE TB_ANSWER_SUB SET
                    APP_STATUS = ?
            
                WHERE
                    J_NUM = ?
                    AND DEPT_CODE = ?
                ";
        $param2 = array();
        $param2[] = $app_stat;
        $param2[] = $j_num;
        $param2[] = $dept_code;
        
        $this->db->query($sql2, $param2);
        
    }
    
    
    //결재반려
    public function app_return($data){
        
        $j_num = $data['J_NUM'];
        $idx = $data['idx'];
        $app_id = $data['app_id'];
        $app_sabun = $data['app_sabun'];
        $app_action = $data['app_action'];
        $app_comment = $data['app_comment'];
        
        $sql = "UPDATE TB_ANSWER_APP SET 
                    APP_STATUS = 3,
                    APP_DATE = SYSDATE,
                    RETURN_REASON = ?,
                    APP_IP = ?
                WHERE
                    IDX = ?
            ";
        $param = array();
        $param[] = $app_comment;
        $param[] = $this->input->ip_address();
        $param[] = $app_id;
        $this->db->query($sql, $param);
        
    }
    
    
    //반려시 결재내역 초기화
    public function app_init($data){
        
        $j_num = $data['j_num'];
        $idx = $data['idx'];
        $app_id = $data['app_id'];
        $app_sabun = $data['app_sabun'];
        $app_action = $data['app_action'];
        $app_comment = $data['app_comment'];
        $app_step = $data['app_step'];
        
        $sql = "UPDATE TB_ANSWER_APP SET 
                    APP_STATUS = 0
       
                WHERE
                    J_NUM = ?
                    AND APP_STEP < ?
            ";
        $param = array();
        $param[] = $j_num;
        $param[] = $app_step;
        $this->db->query($sql, $param);
        
    }
    

    
    
    
    
    
    //작성자 사번
    public function getFirstAppInfo($data){
        
        $j_num = $data['j_num'];
        $dept_code = $data['dept_code'];
        
        $sql = "SELECT SABUN FROM TB_ANSWER_APP
                WHERE
                    J_NUM = ?
                    AND DEPT_CODE = ?
                    AND APP_STEP = 0
                ";
        $param = array();
        $param[] = $j_num;
        $param[] = $dept_code;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->SABUN;
        
    }
    
    //1차 결재자 사번
    public function getSecondAppInfo($data){
        
        $j_num = $data['j_num'];
        $dept_code = $data['dept_code'];
        
        $sql = "SELECT SABUN FROM TB_ANSWER_APP
                WHERE
                    J_NUM = ?
                    AND DEPT_CODE = ?
                    AND APP_STEP = 1
                ";
        $param = array();
        $param[] = $j_num;
        $param[] = $dept_code;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->SABUN;
    }
    
    
    //2차 결재자 사번
    public function getThirdAppInfo($data){
        
        $j_num = $data['j_num'];
        $dept_code = $data['dept_code'];
        
        $sql = "SELECT SABUN FROM TB_ANSWER_APP
                WHERE
                    J_NUM = ?
                    AND DEPT_CODE = ?
                    AND APP_STEP = 2
                ";
        $param = array();
        $param[] = $j_num;
        $param[] = $dept_code;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->SABUN;
    }
    
    
    

    
    
}