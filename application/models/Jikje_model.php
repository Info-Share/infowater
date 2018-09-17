<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**********************************************************
 프로그램명 : Jikje_model.php
 타입 : 모델
 용도 : 직제
 경로 : /models/Jikje_model.php
 작성자 : 양찬우
 소속 : (주)비전아이티
 일자 : 18.07.11
 프로그램설명
 직제
 **프로그램이력**
 수정일          작업근거             유지보수담당
 '18.07.14       최초생성             양찬우
 **********************************************************/
class Jikje_model extends CI_Model {
    
    
    
    //부서목록
    public function getBuser(){
        
        $query = "SELECT m_orgeh, insa_jikje2 as sosil, m_orgtx FROM GATE_JIKJE
                where
                    INSA_JIKJE1_CODE='50011401'
                    OR INSA_JIKJE1_CODE='50257174'
                    OR INSA_JIKJE2_CODE='50003285'
                ORDER BY insa_jikje1, insa_jikje2, insa_jikje3, insa_jikje4, insa_jikje5, insa_jikje6 ";
        
        $query = "SELECT CODE, NAME AS SOSIL FROM VW_UPDEPT2 ORDER BY CODE";
        
        $query = $this->db->query($query);
        return $query->result_array();
        
    }
    
    
    public function getName($data){
        
        $sabun = $data['sabun'];
        
        $sql = "SELECT INSA_NAME FROM (
                    SELECT 
                        MEMBER_NAME AS INSA_NAME
                    FROM 
                        VW_INSA
                    WHERE 
                        MEMBER_ID = ?
                )";
        $param = array();
        $param[] = $sabun;
        $query = $this->db->query($sql, $param);
        return $query->row();
        
    }
    
      
    public function get_buserAndName($data){
        
        $sabun = $data['sabun'];
        
        $sql = "SELECT POSITION, MEMBER_NAME, B.NAME  
                FROM VW_INSA A 
                INNER JOIN VW_UPDEPT2 B ON A.BU_CODE = B.CODE 
                WHERE MEMBER_ID = ?
                ";
        $param = array();
        $param[] = $sabun;
        $query = $this->db->query($sql, $param);
        return $query->row();
        
    }
    
    
    
    public function getTeamCode($data){
        
        $sabun = $data['sabun'];
        
        $sql = "SELECT BU_CODE FROM VW_INSA WHERE MEMBER_ID = ?";
        $param = array();
        $param[] = $sabun;
        $query = $this->db->query($sql, $param);
        return $query->row();
        
    }
    
    
    
    public function getTeamName($data){
        
        $code = $data['code'];
        
        $sql = "SELECT NAME FROM VW_UPDEPT2 WHERE CODE = ?";
        $param = array();
        $param[] = $code;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->NAME;
        
    }
    
    
    
    
    
    
}