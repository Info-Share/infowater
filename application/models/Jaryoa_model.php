<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('PID', "M2000");
/**********************************************************
 프로그램명 : Jaryoa_model.php
 타입 : 모델
 용도 : 요청자료입력
 경로 : /models/Jaryoa_model.php
 작성자 : 양찬우
 소속 : (주)비전아이티
 일자 : 18.07.11
 프로그램설명
 요청자료입력
 **프로그램이력**
 수정일          작업근거             유지보수담당
 '18.07.14       최초생성             양찬우
 **********************************************************/
class Jaryoa_model extends CI_Model {
    
    
    public function cntAns($data){
        
        $j_num = $data['j_num'];
        $dept_code = $data['dept_code'];
        
        
        //등록된 제출 갯수 확인
        $sql = "SELECT ROWNUM, CNT FROM (

                    SELECT COUNT(*) AS CNT FROM TB_ANSWER
            
                    WHERE
                        J_NUM = ?
                        AND DEPT_CODE = ?
                    GROUP BY I_IDX
                ) 
                WHERE
                    ROWNUM > 0 AND ROWNUM <= 1
                ";
        $param1 = array();
        $param1[] = $j_num;
        $param1[] = $dept_code;
        
        $query = $this->db->query($sql, $param1);
        $result = $query->row();
        return $result->CNT;
        
        
        
    }
    
    
    
    public function insertAns($data){
        
        
        //var_dump($param);
        $j_num = $data['j_num'];
        $i_idx = $data['i_idx'];
        $sabun = $data['sabun'];
        $deptcode = $data['deptcode'];
        $is_req = $data['is_req'];
       


        foreach($data['ans'] as $item){
            
            $param = array();
            $param[] = $j_num;
            $param[] = $i_idx;
            $param[] = $item;
            $param[] = $sabun;
            $param[] = $deptcode;

        
                
            $sql = "INSERT INTO TB_ANSWER (IDX, J_NUM, I_IDX, I_ANSWER, SABUN, RDATE, DEPT_CODE) VALUES (TB_ANSWER_SEQ.NEXTVAL, ?, ?, ?, ?, SYSDATE, ?) ";
            $this->db->query($sql, $param);
                
            
            

        }//foreach
        
        
        
    }
    
    
    
   
    public function insertAnsSub($data){
        
        
        $j_num = $data['j_num'];
        $sabun = $data['sabun'];
        $dept_code = $data['dept_code'];
       
        
        $sql = "SELECT ROWNUM, CNT FROM (

                    SELECT COUNT(*) AS CNT FROM TB_ANSWER 

                    WHERE
                        J_NUM = ?
                        AND DEPT_CODE = ? 
                    GROUP BY I_IDX  
                )
                WHERE
                    ROWNUM > 0 AND ROWNUM <= 1  
                ";
        $param1 = array();
        $param1[] = $j_num;
        $param1[] = $dept_code;
        
        $query = $this->db->query($sql, $param1);
        $result = $query->row();
        $cnt = $result->CNT;
        
        
        
        $sql2 = "MERGE INTO TB_ANSWER_SUB A
                USING DUAL
                ON (A.DEPT_CODE = ? AND A.J_NUM = ?)
                WHEN MATCHED THEN
                UPDATE SET
                CNT = ?,
                SABUN = ?,
                RDATE = SYSDATE
                
                
                WHEN NOT MATCHED THEN
                INSERT (IDX, J_NUM, SABUN, CNT, DEPT_CODE, RDATE)
                VALUES (TB_ANSWER_SUB_SEQ.NEXTVAL, ?, ?, ?, ?, SYSDATE)
                ";
        
        $param = array();
        $param[] = $dept_code;
        $param[] = $j_num;
        $param[] = $cnt;
        $param[] = $sabun;
        
        $param[] = $j_num;
        $param[] = $sabun;
        $param[] = $cnt;
        $param[] = $dept_code;

        $this->db->query($sql2, $param);
            
        
        
    }
    
    
    public function writeapp($data){
        
        
        $j_num = $data['j_num'];
        $sabun1 = $data['sabun1'];
        $sabun2 = $data['sabun2'];
        $sabun3 = $data['sabun3'];
        $dept_code = $data['dept_code'];
        $cnt = $data['cnt'];
        $app_status = $data['app_status'];
        
        

        
        
        if($app_status == "반려"){
            
            
            //제출정보 갱신
            $sql2 = "MERGE INTO TB_ANSWER_SUB A
                USING DUAL
                ON (A.DEPT_CODE = ? AND A.J_NUM = ?)
                WHEN MATCHED THEN
                UPDATE SET
                CNT = ?,
                SABUN = ?,
                APP_STATUS = ?,
                RDATE = SYSDATE
                
                
                WHEN NOT MATCHED THEN
                INSERT (IDX, J_NUM, SABUN, CNT, DEPT_CODE, APP_STATUS, RDATE)
                VALUES (TB_ANSWER_SUB_SEQ.NEXTVAL, ?, ?, ?, ?, ?, SYSDATE)
                ";
            
            
            $param = array();
            $param[] = $dept_code;
            $param[] = $j_num;
            $param[] = $cnt;
            $param[] = $this->session->userdata('ssabun');
            $param[] = '결재중';
            
            $param[] = $j_num;
            $param[] = $this->session->userdata('ssabun');
            $param[] = $cnt;
            $param[] = $dept_code;
            $param[] = '결재중';
            
            $this->db->query($sql2, $param);
        
            
            
            //재결재
            //1차 결재자 결재완료 처리
            $sql1 = "UPDATE TB_ANSWER_APP 
                    SET
                    APP_STATUS = 2,
                    APP_DATE = SYSDATE,
                    APP_IP = ?
                    WHERE
                        J_NUM = ?
                        AND DEPT_CODE = ?
                        AND APP_STEP = 0
                    
                ";
            $param1 = array();
            $param1[] = $this->input->ip_address();
            $param1[] = $j_num;
            $param1[] = $dept_code;
            $this->db->query($sql1, $param1);
            
            
            
            //2차 결재자 결재정보 초기화
            $sql2 = "UPDATE TB_ANSWER_APP 
                    SET
                        APP_STATUS = 0,
                        APP_IP = ?,
                        RETURN_REASON = '',
                        APP_DATE = ''
                    WHERE
                        J_NUM = ?
                        AND DEPT_CODE = ?
                        AND APP_STEP = 1
                    
                ";
            $param2 = array();
            $param2[] = $this->input->ip_address();
            $param2[] = $j_num;
            $param2[] = $dept_code;
            $this->db->query($sql2, $param2);
            
            
            
            //3차 결재자 결재정보 초기화
            $sql3 = "UPDATE TB_ANSWER_APP 
                    SET
                    APP_STATUS = 0,
                    APP_IP = ?,
                    RETURN_REASON = '',
                    APP_DATE = ''


                    WHERE
                        J_NUM = ?
                        AND DEPT_CODE = ?
                        AND APP_STEP = 2
                    
                ";
            $param3 = array();
            $param3[] = $this->input->ip_address();
            $param3[] = $j_num;
            $param3[] = $dept_code;
            $this->db->query($sql3, $param3);
            
            
            
            
        }else{
            
            
            //최초 결재 요청
            
            //제출정보 갱신
            $sql2 = "MERGE INTO TB_ANSWER_SUB A
                USING DUAL
                ON (A.DEPT_CODE = ? AND A.J_NUM = ?)
                WHEN MATCHED THEN
                UPDATE SET
                CNT = ?,
                SABUN = ?,
                APP_STATUS = ?,
                RDATE = SYSDATE
                
                
                WHEN NOT MATCHED THEN
                INSERT (IDX, J_NUM, SABUN, CNT, DEPT_CODE, APP_STATUS, RDATE)
                VALUES (TB_ANSWER_SUB_SEQ.NEXTVAL, ?, ?, ?, ?, ?, SYSDATE)
                ";
            
            
            $param = array();
            $param[] = $dept_code;
            $param[] = $j_num;
            $param[] = $cnt;
            $param[] = $sabun1;
            $param[] = '결재중';
            
            $param[] = $j_num;
            $param[] = $sabun1;
            $param[] = $cnt;
            $param[] = $dept_code;
            $param[] = '결재중';
            
            $this->db->query($sql2, $param);
            
            
            
            //1차 결재자 등록
            $sql3 = "INSERT INTO TB_ANSWER_APP (IDX, J_NUM, SABUN, DEPT_CODE, APP_STEP, APP_STATUS, APP_DATE, APP_IP) 
                     VALUES 
                    (TB_ANSWER_APP_SEQ.NEXTVAL, ?, ?, ?, 0, 2, SYSDATE, ?)";
            $param3 = array();
            $param3[] = $j_num;
            $param3[] = $sabun1;
            $param3[] = $dept_code;
            $param3[] = $this->input->ip_address();
            $query = $this->db->query($sql3, $param3);
            
            
            //2차 결재자 등록
            $sql3 = "INSERT INTO TB_ANSWER_APP (IDX, J_NUM, SABUN, DEPT_CODE, APP_STEP, APP_STATUS) 
                     VALUES 
                    (TB_ANSWER_APP_SEQ.NEXTVAL, ?, ?, ?, 1, 0)";
            $param3 = array();
            $param3[] = $j_num;
            $param3[] = $sabun2;
            $param3[] = $dept_code;
            $query = $this->db->query($sql3, $param3);
            
            
            //3차 결재자 등록
            $sql3 = "INSERT INTO TB_ANSWER_APP (IDX, J_NUM, SABUN, DEPT_CODE, APP_STEP, APP_STATUS) 
                     VALUES 
                    (TB_ANSWER_APP_SEQ.NEXTVAL, ?, ?, ?, 2, 0)";
            $param3 = array();
            $param3[] = $j_num;
            $param3[] = $sabun3;
            $param3[] = $dept_code;
            $query = $this->db->query($sql3, $param3);
        }
                
    }
    
    
    //답변 삭제
    public function deletea($data){
        
        $j_num = $data['J_NUM'];
        $sabun = $data['SABUN'];
        $dept_code = $data['DEPT_CODE'];
        $i_idxs = $data['I_IDXS'];
        

//         $sql = "DELETE FROM TB_ANSWER WHERE 
//                 J_NUM = ?
//                 AND SABUN = ?
//                 AND I_IDX IN ($i_idxs)
//                 ";

        $sql = "DELETE FROM TB_ANSWER WHERE 
                J_NUM = ?
                AND DEPT_CODE = ?
                ";
        
        $param = array();
        $param[] = $j_num;
        $param[] = $dept_code;

        $this->db->query($sql, $param);
        
    }
    
    
    //답변목록 : 화면출력
    public function getAnsList($data){
        
        $sql = "";
        $param = array();
        foreach($data as $item){
            
            
            $sql .= " SELECT REPLACE(LISTAGG(NVL(I_ANSWER, '#'), '#') WITHIN GROUP (ORDER BY IDX), '###', '##') AS I_ANSWER
                FROM TB_ANSWER WHERE I_IDX = ? AND DEPT_CODE = ?
                UNION ALL";
            $param[] = $item;
            $param[] = $this->session->userdata('CS_BU_CODE');

        }
        $sql = substr($sql, 0, -9);
        $query = $this->db->query($sql, $param);
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return FALSE;
            
        }
    
    
    }
    
    
    //답변목록 : 엑셀저장용
    public function getAnsListXls($data){
        
        $sql = "";
  
        $dept_code = end($data);
        array_pop($data);
        $param = array();
        foreach($data as $item){
            
            $sql .= " SELECT REPLACE(LISTAGG(NVL(I_ANSWER, '#'), '#') WITHIN GROUP (ORDER BY IDX), '###', '##') AS I_ANSWER
                FROM TB_ANSWER WHERE I_IDX = ? AND DEPT_CODE = ?
                UNION ALL";
            $param[] = $item;
            $param[] = $dept_code;

        }
        $sql = substr($sql, 0, -9);
        $query = $this->db->query($sql, $param);
        if($query->num_rows() > 0){
            return $query->result_array();
        }else{
            return FALSE;
            
        }
    
    
    }
    
    
    
    //로그인한 사람이 현재 답변글과 같은 부서인지 확인
    public function ansdeptcode($data){
        
        $i_idxs = $data['i_idxs'];
        
        $sql = "SELECT * FROM (
                SELECT ROWNUM AS RNUM, SABUN, B.BU_CODE FROM (
                    SELECT DISTINCT SABUN FROM TB_ANSWER WHERE I_IDX IN ( $i_idxs ) AND DEPT_CODE = ?
                 ) A
                 LEFT OUTER JOIN VW_INSA B
                 ON A.SABUN=B.MEMBER_ID
                 
                 )
                 WHERE RNUM > 0 AND RNUM <= 1
        ";
        $param = array();
        $param[] = $this->session->userdata('CS_BU_CODE');
        $query = $this->db->query($sql, $param);
        return $query->row();
        
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
        $dept_code = $param['dept_code'];
        
        $sql = "SELECT * FROM (
            
                    SELECT ROWNUM AS RNUM, IDX, J_TITLE, SABUN, J_NUM, SDATE, DDATE, RDATE, J_CFM, J_END, APP_STATUS, MYAPPCNT FROM (
            
                        SELECT IDX, J_TITLE, SABUN, J_NUM,
                            TO_CHAR(SDATE, 'YYYY-MM-DD') AS SDATE,
                            TO_CHAR(DDATE, 'YYYY-MM-DD') AS DDATE,
                            TO_CHAR(RDATE, 'YYYY-MM-DD') AS RDATE,
                            J_CFM,
                            J_END,
                            (SELECT APP_STATUS FROM TB_ANSWER_SUB WHERE J_NUM = A.J_NUM AND DEPT_CODE = ?) AS APP_STATUS,
                            (SELECT COUNT(*) FROM TB_ANSWER_APP WHERE J_NUM = A.J_NUM AND DEPT_CODE = ? AND SABUN = ? AND APP_STATUS = 0) AS MYAPPCNT
                        FROM
                            TB_JARYO A
                            WHERE 1=1
                ";
        
        $param = array();
        $param[] = $dept_code;
        $param[] = $dept_code;
        $param[] = $this->session->userdata('ssabun');
        
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
    
    
    
    public function check1stapp($data){
        
        $j_num = $data['j_num'];
        $dept_code = $data['dept_code'];
        
        $sql = "SELECT COUNT(*) AS CNT FROM TB_ANSWER_APP 
                WHERE
                    J_NUM = ?
                    AND DEPT_CODE = ?
                ";
        $param = array();
        $param[] = $j_num;
        $param[] = $dept_code;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->CNT;
    }
    
    
    
    public function checkAppstatus($data){
        
        $j_num = $data['j_num'];
        $dept_code = $data['dept_code'];
        
        $sql = "SELECT APP_STATUS FROM TB_ANSWER_SUB 
                WHERE
                    J_NUM = ?
                    AND DEPT_CODE = ?
                ";
        $param = array();
        $param[] = $j_num;
        $param[] = $dept_code;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->APP_STATUS;
    }
    
    
    
    
    
    //반려상태가 있는지 조회
    public function getAppStatus($data){
        
        $j_num = $data['j_num'];
        $dept_code = $data['dept_code'];
        
        $sql = "SELECT COUNT(*) AS CNT FROM TB_ANSWER_SUB
                WHERE
                    J_NUM = ?
                    AND DEPT_CODE = ?
                    AND APP_STATUS = '반려'
                ";
        $param = array();
        $param[] = $j_num;
        $param[] = $dept_code;
        
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->CNT;
        
    }
    
    
    //필수입력항목여부 체크
    public function chkRequired($idx){
        
        $sql = "SELECT I_REQUIRED FROM TB_JARYO_ITEMS WHERE IDX = ?";
        $param = array();
        $param[] = $idx;
        $query = $this->db->query($sql, $param);
        $result = $query->row();
        return $result->I_REQUIRED;
        
    }
    
    
}