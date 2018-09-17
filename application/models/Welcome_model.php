<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('PID', "M0000");
/**********************************************************
 프로그램명 : Welcome_model.php
 타입 : 모델
 용도 : 메인
 경로 : /models/Welcome_model.php
 작성자 : 양찬우
 소속 : (주)비전아이티
 일자 : 18.07.11
 프로그램설명
 메인
 **프로그램이력**
 수정일          작업근거             유지보수담당
 '18.07.14       최초생성             양찬우
 **********************************************************/
class Welcome_model extends CI_Model {
    
    //로그인한 사용자가 결재요청한 물건 불러오기
    public function getLoginAns(){
        
        $sql = "SELECT * FROM (
                    SELECT A.J_NUM, B.SABUN, TO_CHAR(B.DDATE, 'YYYY-MM-DD') AS DDATE, A.APP_STATUS, B.J_TITLE
                    FROM
                        TB_ANSWER_SUB A
                        LEFT OUTER JOIN TB_JARYO B
                        ON A.J_NUM=B.J_NUM
                    WHERE A.SABUN = ?
            ) ORDER BY DDATE DESC
            ";
        $param = array();
        $param[] = $this->session->userdata('ssabun');
        $query = $this->db->query($sql, $param);
        $result = $query->result_array();
        return $result;
        
    }
    
    
    //로그인한 사용자가 작성한 물건 불러오기
    public function getMywrite(){
        
        $sql = "SELECT J_NUM, J_TITLE, DDATE, RSABUN, J_END FROM (
                    SELECT A.J_NUM, B.J_TITLE, TO_CHAR(B.DDATE, 'YYYY-MM-DD') DDATE, B.SABUN AS RSABUN, B.J_END FROM TB_ANSWER A
                    LEFT OUTER JOIN TB_JARYO B ON A.J_NUM=B.J_NUM
                    
                    WHERE A.SABUN = ?
                    
                ) GROUP BY J_NUM, J_TITLE, DDATE, RSABUN, J_END
                 ORDER BY DDATE DESC
            ";
        $param = array();
        $param[] = $this->session->userdata('ssabun');
        $query = $this->db->query($sql, $param);
        $result = $query->result_array();
        return $result;
        
    }
    
    
    //인사정보조회
    public function chkInsa($sabun){
        
        $sql = "SELECT * FROM (
                    SELECT A.MEMBER_ID AS INSA_SABUN, A.MEMBER_NAME AS INSA_NAME, A.BU_CODE, B.NAME AS SOSOK 
                    FROM
                        VW_INSA A
                        LEFT OUTER JOIN VW_UPDEPT2 B ON A.BU_CODE=B.CODE
                )
                WHERE INSA_SABUN = ?

           ";
        $param = array();
        $param[] = $sabun;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result;
        
    }
    
    
    //관리자인지 조회
    public function chkAdmin($sabun){
        
        $sql = "SELECT SABUN, ROLE FROM TB_ADMIN 
                WHERE SABUN = ?
            ";
        $param = array();
        $param[] = $sabun;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->ROLE;
        
    }
    
    
}