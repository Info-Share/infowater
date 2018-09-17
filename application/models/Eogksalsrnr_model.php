<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('PID', "M3000");
/**********************************************************
 프로그램명 : Eogksalsrnr_model.php
 타입 : 모델
 용도 : 시스템관리
 경로 : /models/Eogksalsrnr_model.php
 작성자 : 양찬우
 소속 : (주)비전아이티
 일자 : 18.07.11
 프로그램설명
 시스템관리
 **프로그램이력**
 수정일          작업근거             유지보수담당
 '18.07.14       최초생성             양찬우
 **********************************************************/
class Eogksalsrnr_model extends CI_Model {
    
    public function getList(){
        
        $sql = "SELECT * FROM (
                    SELECT SABUN, ROLE, DEPT_CODE, TO_CHAR(RDATE, 'YYYY-MM-DD') AS RDATE 
                    FROM   
                        TB_ADMIN
            ) ORDER BY SABUN";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
        
    }
    
    
    public function memChk($sabun){
        
        $sql = "SELECT COUNT(*) AS CNT FROM TB_ADMIN WHERE SABUN = ?";
        $param = array();
        $param[] = $sabun;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->CNT;
    }
    
    
    public function writeok($data){
        
        $buser = $data['buser'];
        $sabun = $data['sabun'];
        $role = $data['role'];
        
        
        $sql = "INSERT INTO TB_ADMIN 
                (SABUN, ROLE, DEPT_CODE, RDATE) 
                VALUES 
                (?, ?, ?, SYSDATE)
            ";
        $param = array();
        $param[] = $sabun;
        $param[] = $role;
        $param[] = $buser;
        $res = $query = $this->db->query($sql, $param);
        return $res;
        
    }
    
    public function delete($data){
        
        $sabun = $data['sabun'];
        
        
        $sql = "DELETE FROM TB_ADMIN
                WHERE
                SABUN = ?
            ";
        $param = array();
        $param[] = $sabun;
        $res = $query = $this->db->query($sql, $param);
        return res;
        
    }
    
}