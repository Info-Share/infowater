<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('PID', "M1000");
/**********************************************************
 프로그램명 : Jaryor_model.php
 타입 : 모델
 용도 : 자료취합요청
 경로 : /models/Jaryor_model.php
 작성자 : 양찬우
 소속 : (주)비전아이티
 일자 : 18.07.11
 프로그램설명
 자료취합요청
 **프로그램이력**
 수정일          작업근거             유지보수담당
 '18.07.14       최초생성             양찬우
 **********************************************************/
class Jaryor_model extends CI_Model {
    
    
    //정보수정
    public function writeok($data){
        
        
        $j_num = $data['j_num'];
        $j_title = $data['j_title'];
        $sabun = $data['sabun'];
        $content = $data['content'];
        $sdate = $data['sdate'];
        $ddate = $data['ddate'];
        $j_cfm = $data['j_cfm'];
        $j_end = $data['j_end'];
        

        $sql = "INSERT INTO TB_JARYO (IDX, J_TITLE, SABUN, J_NUM, SDATE, DDATE, RDATE, CONTENT, J_CFM, J_END) 
                VALUES 
                    (TB_JARYO_SEQ.NEXTVAL, ?, ?, ?, TO_DATE(?, 'YYYY-MM-DD'), TO_DATE(?, 'YYYY-MM-DD'), SYSDATE, ?, ?, ?)";
      
        $param = array();
        $param[] = $j_title;
        $param[] = $sabun;
        $param[] = $j_num;
        $param[] = $sdate;
        $param[] = $ddate;
        $param[] = $content;
        $param[] = $j_cfm;
        $param[] = $j_end;
        
        $this->db->query($sql, $param);
        
    }
    
    
    //아이템 등록
    public function writeitemok($data){
        
        
        $j_num = $data['j_num'];
        $i_name = $data['i_name'];
        $i_type = $data['i_type'];
        $i_required = $data['i_required'];
        $i_content = $data['i_content'];

        

        $sql = "INSERT INTO TB_JARYO_ITEMS (IDX, J_NUM, I_NAME, I_TYPE, I_REQUIRED, I_CONTENT) 
                VALUES 
                    (TB_JARYO_ITEMS_SEQ.NEXTVAL, ?, ?, ?, ?, ?)";
      
        $param = array();
        $param[] = $j_num;
        $param[] = $i_name;
        $param[] = $i_type;
        $param[] = $i_required;
        $param[] = $i_content;

        $this->db->query($sql, $param);
        
        $sql = "SELECT TB_JARYO_ITEMS_SEQ.CURRVAL AS IDX FROM DUAL";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->IDX;
        
        
    }
    
    
    
    //아이템 수정
    public function modifyitemok($data){
        
        
        $j_num = $data['j_num'];
        $i_name = $data['i_name'];
        $i_type = $data['i_type'];
        $i_required = $data['i_required'];
        $i_content = $data['i_content'];
        $i_idx = $data['i_idx'];
        $oriitemid = $data['oriitemid'];

        $oriitemidarr = explode(",", $oriitemid);
        if($i_idx){
            
            if(in_array($i_idx, $oriitemidarr)){
                
            
                $sql = "UPDATE TB_JARYO_ITEMS 
                        
                        SET
                        I_NAME = ?,
                        I_TYPE = ?,
                        I_REQUIRED = ?,
                        I_CONTENT = ?
                        WHERE
                        IDX = ? AND J_NUM = ?

                        ";
                
                $param = array();
        
                $param[] = $i_name;
                $param[] = $i_type;
                $param[] = $i_required;
                $param[] = $i_content;
                $param[] = $i_idx;
                $param[] = $j_num;
                
                $this->db->query($sql, $param);
                return $i_idx;
                
            }else{
                $sql = "DELETE FROM TB_JARYO_ITEMS
                        WHERE
                        IDX = ? AND J_NUM = ?
                ";
                $param = array();
                $param[] = $i_idx;
                $param[] = $j_num;
                
                $this->db->query($sql, $param);
                return $i_idx;
                
                
            }
        
        }else{
            $sql = "INSERT INTO TB_JARYO_ITEMS (IDX, J_NUM, I_NAME, I_TYPE, I_REQUIRED, I_CONTENT) 
                    VALUES 
                        (TB_JARYO_ITEMS_SEQ.NEXTVAL, ?, ?, ?, ?, ?)";
            
            $param = array();
            
            $param[] = $j_num;
            $param[] = $i_name;
            $param[] = $i_type;
            $param[] = $i_required;
            $param[] = $i_content;
            
            
            $this->db->query($sql, $param);
            
            $sql = "SELECT TB_JARYO_ITEMS_SEQ.CURRVAL AS IDX FROM DUAL";
            $query = $this->db->query($sql);
            $result = $query->row();
            return $result->IDX;
            
        
        }
        

        
    }
    
    
    
    
    
    
    //체크 아이템 항목 입력
    public function writechklist($chklistitem){
        
        $i_idx = $chklistitem['I_IDX'];
        $title = $chklistitem['TITLE'];
        $j_num = $chklistitem['J_NUM'];
        
        
        
        $sql = "INSERT INTO TB_JARYO_ITEMS_LIST (I_IDX, TITLE, J_NUM) VALUES (?, ?, ?)";
        
        $param = array();
        $param[] = $i_idx;
        $param[] = $title;
        $param[] = $j_num;
        $this->db->query($sql, $param);
        
        
    }
    
    
    
    

    
    
    
    public function modifyok($data){
        
        
        $j_num      = $data['j_num'];
        $j_title    = $data['j_title'];
        $sabun      = $data['sabun'];
        $content    = $data['content'];
        $sdate = $data['sdate'];
        $ddate = $data['ddate'];
        $j_cfm = $data['j_cfm'];
        $j_end = $data['j_end'];
        $idx = $data['idx'];
        
        
        $sql = "UPDATE TB_JARYO SET 
                    J_TITLE = ?, 
                    SDATE   = ?, 
                    DDATE   = ?, 
                    CONTENT = ?, 
                    J_CFM   = ?,
                    J_END   = ?
                WHERE 
                    IDX = ?
            ";
        
        $param = array();
        $param[] = $j_title;
        $param[] = $sdate;
        $param[] = $ddate;
        $param[] = $content;
        $param[] = $j_cfm;
        $param[] = $j_end;
        $param[] = $idx;
        
        $this->db->query($sql, $param);
        
    }
    
    
    
    
    public function deletej($data){
        
        $j_num = $data['J_NUM'];
        
        $sql = "DELETE FROM TB_JARYO WHERE J_NUM = ?";
        
        $param = array();
        $param[] = $j_num;
        $this->db->query($sql, $param);
        
    }
    
    
    
    public function deletei($data){
        
        $j_num = $data['J_NUM'];
        
        $sql = "DELETE FROM TB_JARYO_ITEMS WHERE J_NUM = ?";
        
        $param = array();
        $param[] = $j_num;
        $this->db->query($sql, $param);
        
    }
    
    
    public function deletec($data){
        
        $j_num = $data['J_NUM'];
        
        $sql = "DELETE FROM TB_JARYO_ITEMS_LIST WHERE J_NUM = ?";
        
        $param = array();
        $param[] = $j_num;
        $this->db->query($sql, $param);
        
    }
    
    
    public function jclose($data){
        
        $idx = $data['IDX'];
        
        $sql = "UPDATE TB_JARYO SET J_END = 'Y' WHERE IDX = ?";
        
        $param = array();
        $param[] = $idx;
        $this->db->query($sql, $param);
        
    }
    
    
    
    public function jrelease($data){
        
        $idx = $data['IDX'];
        
        $sql = "UPDATE TB_JARYO SET J_END = 'N' WHERE IDX = ?";
        
        $param = array();
        $param[] = $idx;
        $this->db->query($sql, $param);
        
    }
    
    
    
    
    
    public function getContent($data){
        
        $idx = $data['idx'];
        
        $sql = "SELECT * FROM (
                SELECT 
                    IDX, 
                    J_TITLE, 
                    SABUN, 
                    J_NUM, 
                    TO_CHAR(SDATE, 'YYYY-MM-DD') AS SDATE, 
                    TO_CHAR(DDATE, 'YYYY-MM-DD') AS DDATE,
                    J_CFM,
                    CONTENT,
                    J_END 
                FROM 
                    TB_JARYO    
            ) WHERE IDX = ?";
        $param = array();
        $param[] = $idx;
        $query = $this->db->query($sql, $param);
        return $query->row();
        
    }
    
    
    
    
    public function getItems($data){
        
        $j_num = $data['j_num'];
        
        $sql = "SELECT * FROM (
                SELECT 
                    IDX, 
                    J_NUM, 
                    I_NAME, 
                    I_TYPE,
                    I_REQUIRED,
                    I_CONTENT,
                    (SELECT COUNT(*) FROM TB_JARYO_ITEMS_LIST WHERE I_IDX = A.IDX) AS CNT
                FROM 
                    TB_JARYO_ITEMS A

            ) WHERE J_NUM = ?
            ORDER BY IDX
        ";
        $param = array();
        $param[] = $j_num;
        $query = $this->db->query($sql, $param);
        
        return $query->result_array();
        
    }
    
    
    public function getCheckList($i_idx){
        
        $sql = "SELECT I_IDX, TITLE FROM TB_JARYO_ITEMS_LIST WHERE I_IDX = ?";
        $param = array();
        $param[] = $i_idx;
        $query = $this->db->query($sql, $param);
        
        return $query->result_array();
    }
    
    
    
    
    
    public function getList(){
        
        $sql = "SELECT IDX, NAME, TITLE, REGDATE from TB_BOARD order by REGDATE DESC";
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    
    
    public function getView($idx){
        
        
        $sql = "SELECT IDX, NAME, TITLE, CONTENT, REGDATE from TB_BOARD WHERE IDX = ?";
        $param = array();
        $param[] = $idx;
        $query = $this->db->query($sql, $param);
        return $query->row();
    }
    
    public function getMem($data){
        
        $userid = $data['userid'];
        $passwd = $data['passwd'];
        
        $sql = "SELECT USER_ID, USER_NAME FROM TB_MEMBER WHERE USER_ID = ? AND PASSWORD = ? ";
        $param = array();
        $param[] = $userid;
        $param[] = $passwd;
        $query = $this->db->query($sql, $param);
        if($query->num_rows() > 0){
            return $query->row();
        }else{
            return FALSE;
        }
        
    }
    
    
    
    public function getZipList($keyword){
        
        $sql = "SELECT ZIPCODE, SIDO, GUGUN, UPMN, DORO, BLDG1, BLDG2 FROM GN WHERE DORO LIKE ?";
        
        $param = array();
        $param[] = $keyword;
        $query = $this->db->query($sql, $param);
        return $query->result_array();
    }
    
    
    public function countAll($param){
        
        $field = $param['field'];
        $keyword = $param['keyword'];
        
        $sql = "SELECT COUNT(*) AS CNT FROM TB_JARYO WHERE 1=1 ";
        
        
        $param = array();
        
        if($keyword){
            $param[] = $keyword;
            
            $sql .= " AND $field LIKE '%' || ? || '%' ";
        }
        
  
        
        
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->CNT;
    }
    
    
    public function getLimit($param, $limit, $offset){
        
        
        $field = $param['field'];
        $keyword = $param['keyword'];
        
        $sql = "SELECT * FROM (

                    SELECT ROWNUM AS RNUM, IDX, J_TITLE, SABUN, J_NUM, SDATE, DDATE, RDATE, J_CFM, J_END, CNT FROM (

                        SELECT A.IDX, A.J_TITLE, A.SABUN, A.J_NUM, 
                            TO_CHAR(A.SDATE, 'YYYY-MM-DD') AS SDATE, 
                            TO_CHAR(A.DDATE, 'YYYY-MM-DD') AS DDATE, 
                            TO_CHAR(A.RDATE, 'YYYY-MM-DD') AS RDATE,
                            A.J_CFM,
                            A.J_END,
                            
                            CASE  
                            WHEN A.J_CFM = 'Y' THEN
                            (SELECT COUNT(*) FROM TB_ANSWER_SUB WHERE J_NUM=A.J_NUM AND APP_STATUS = '결재완료')
                            WHEN A.J_CFM = 'N' THEN
                            (SELECT COUNT(*) FROM TB_ANSWER_SUB WHERE J_NUM=A.J_NUM )

                            END
                            AS CNT 
                        FROM
                            TB_JARYO A
                            WHERE 1=1 
                ";
        
        $param = array();
        
        if($keyword){
            $param[] = $keyword;
            
            $sql .= " AND $field LIKE '%' || ? || '%' ";
        }
        
  
        
        
        $sql .= "
                        ORDER BY IDX DESC
                    )
                )
                WHERE RNUM > $limit AND RNUM <= ($limit + $offset)
        

            ";
        
                        
                        
       $query = $this->db->query($sql, $param);
       
       if($query->num_rows() > 0){
           return $query->result_array();
       }else{
           return FALSE;
           
       }
                       
                        
        
    }
    
    
    
    
    public function getItemIdx(){
        
        $sql = "SELECT TB_JARYO_ITEMS_SEQ.CURRVAL AS IDX FROM DUAL";
        $query = $this->db->query($sql);
        $result = $query->row();
        return $result->IDX;
        
    }
    
    
    
    public function getAnsRegistList($data){
        
        $j_num = $data['j_num'];
        $j_cfm = $data['j_cfm'];
        
        $sql = "SELECT * FROM (
                    SELECT IDX, J_NUM, SABUN, CNT, TO_CHAR(RDATE, 'YYYY-MM-DD HH24:MI:SS') AS RDATE, DEPT_CODE FROM TB_ANSWER_SUB
                    WHERE 
                        J_NUM = ?
                ";
        
        $param = array();
        $param[] = $j_num;
        
        if($j_cfm == "Y"){
            $sql .= " AND APP_STATUS = '결재완료'";
        }
        $sql .= " )";
        
    
        $query = $this->db->query($sql, $param);
        return $query->result_array();
        
        
    }
    
    
    
    
    public function getAnsRegistListNoApp($data){
        
        $j_num = $data['j_num'];
        
        $sql = "SELECT * FROM (
                    SELECT IDX, J_NUM, SABUN, CNT, TO_CHAR(RDATE, 'YYYY-MM-DD HH24:MI:SS') AS RDATE, DEPT_CODE FROM TB_ANSWER_SUB
                    WHERE 
                        J_NUM = ?
                        
                )";
        $param = array();
        $param[] = $j_num;
        $query = $this->db->query($sql, $param);
        return $query->result_array();
        
        
    }
    
}