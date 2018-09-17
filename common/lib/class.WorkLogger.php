<?php

class WorkLogger {
    
    /**
     * 로그인 로그를 남긴다.
     * @param unknown $sabun
     * @param unknown $success
     */
    static function login($sabun, $success) {
        global $oradb;

        $remote_ip = $_SERVER['REMOTE_ADDR'];

        $query = "INSERT INTO GONGJE_SYS_LOGINLOG (LOG_IDX, SABUN, LOGIN_DT, LOGIN_SU, LOGIN_IP) VALUES (GLOG_IDX_SEQ.NEXTVAL, ?, SYSDATE, ?, ?)";
        $param = array();
        $param[] = $sabun;
        $param[] = $success;
        $param[] = $remote_ip;
        $oradb->setBind($param);
        $oradb->executeDML($query);
        

    }
    
    /**
     * 파일 다운로드 로그를 조회한다.
     * 
     * @param unknown $sabun
     * @param unknown $prgm_id
     * @param unknown $category_id
     * @param unknown $down_data
     * @param unknown $filename
     */
    static function down($PID, $file_name, $real_name) {
        global $oradb;
        
        $data = array();
        $data[] = $PID;
        $data[] = $file_name;
        $data[] = $real_name;
        $data[] = $_SERVER['REMOTE_ADDR'];
        $data[] = $_SESSION['sabun_sess'];
        $data[] = $_SERVER['HTTP_REFERER'];

        $query = "INSERT INTO GONGJE_SYS_LOGFILE (FILE_IDX, FILE_TIME, PID, FILE_NAME, REAL_NAME, FILE_IP, USER_ID, REFERER) VALUES (GFILE_IDX_SEQ.NEXTVAL, SYSDATE, ?, ?, ?, ?, ?, ?)";
        $oradb->setBind($data);
        $exec = $oradb->executeDML($query);
       
        
    }
    
    /**
     * 프로그램 사용 로그를 남긴다.
     * 
     * @param unknown $site_id
     * @param unknown $prgm_id
     * @param unknown $sabun
     * @param unknown $use_job
     * @param unknown $extra_data
     */
    static function work($PID, $bigo, $sabun = '') {
        global $oradb;
        

        
        $query = "INSERT INTO GONGJE_SYS_LOGWORK 
                    (
                        WORK_IDX, 
                        PID, 
                        URI, 
                        USER_ID, 
                        WORK_IP, 
                        BIGO,
                        WORK_TIME
                    ) VALUES (
                        GWORK_IDX_SEQ.NEXTVAL, 
                        ?,
                        ?,
                        ?,
                        ?,
                        ?,
                        SYSDATE
                    )";
        $data = array();
        $data[] = $PID;
        $data[] = $_SERVER['HTTP_REFERER'];
        $data[] = $sabun?$sabun:$_SESSION['sabun_sess'];
        $data[] = $_SERVER['REMOTE_ADDR'];
        $data[] = $bigo;

        $oradb->setBind($data);
        $exec = $oradb->executeDML($query);
    }
}
?>