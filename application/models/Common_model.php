<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('PID', "M4000");
/**********************************************************
 프로그램명 : Common_model.php
 타입 : 모델
 용도 : 공통
 경로 : /models/Common_model.php
 작성자 : 양찬우
 소속 : (주)비전아이티
 일자 : 18.07.11
 프로그램설명
 공통
 **프로그램이력**
 수정일          작업근거             유지보수담당
 '18.07.14       최초생성             양찬우
 **********************************************************/
class Common_model extends CI_Model {
    
    
    public function getBuser(){
    
        $query = "SELECT m_orgeh, insa_jikje2 as sosil, m_orgtx FROM GATE_JIKJE 
                where 
                    INSA_JIKJE1_CODE='50011401' 
                    OR INSA_JIKJE1_CODE='50257174' 
                    OR INSA_JIKJE2_CODE='50003285' 
                ORDER BY insa_jikje1, insa_jikje2, insa_jikje3, insa_jikje4, insa_jikje5, insa_jikje6 ";
        $query = $this->db->query($query);
        return $query->result_array();
        
    }
    
    
    
    
    public function getName($buser){
        
        //$query = "SELECT INSA_SABUN, INSA_NAME, INSA_LEVEL FROM GATE_INSA_MAST WHERE M_ORGEH = ? ORDER BY INSA_LEVEL_CODE ASC";
        $query = "SELECT 
                        MEMBER_ID AS INSA_SABUN,
                        MEMBER_NAME AS INSA_NAME,
                        POSITION AS INSA_LEVEL
                  FROM
                        VW_INSA
                  WHERE
                        BU_CODE = ? 

                    ";
            
        $param = array();
        $param[] = $buser;
        $query = $this->db->query($query, $param);
        return $query->result_array();
        
    }
    
    
    public function getUsername($sabun){
        
        $sql = "SELECT MEMBER_NAME AS INSA_NAME FROM VW_INSA 
                WHERE
                    MEMBER_ID = ?
            ";
        $param = array();
        $param[] = $sabun;
        $result = $this->db->query($sql, $param);
        return $result->row();
        
    }
    
}