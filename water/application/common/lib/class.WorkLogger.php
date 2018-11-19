<?php
/**
 * 로그인, 작업, 다운로드 로그를 남긴다.
 */
class WorkLogger {
    
    /**
     * 로그인 로그를 남긴다.
     * @param unknown $sabun
     * @param unknown $success
     */
    static function login($sabun, $success) {
        global $water_db;
        
        $data = array();
        $data[] = $sabun;
        $data[] = $success;
        $data[] = $_SERVER['REMOTE_ADDR'];

        $query = "INSERT INTO tb_sys_loglogin (login_id, login_datetime, login_success, login_ip) VALUES (?, now(), ?, ?)";
        $exec = $water_db->insert($query, $data);
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
    static function down($site_id, $prgm_id, $category_id, $down_data, $filename) {
        global $water_db;
        
        $data = array();
        $data[] = $_SESSION['sabun_sess'];
        $data[] = $site_id;
        $data[] = $prgm_id;
        $data[] = $category_id;
        $data[] = $down_data;
        $data[] = $filename;
        $data[] = $_SERVER['REMOTE_ADDR'];
        
        $query = "INSERT INTO tb_sys_logfiledown(login_id, down_data, filename, down_time, down_ip) VALUES (?,?,?,now(),?)";
        $exec = $water_db->insert($query, $data);
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
    static function work($use_job, $extra_data, $login_id='') {
        global $water_db;
        
        $data = array();
        $data[] = $login_id?$login_id:$_SESSION['login_id'];
        $data[] = $use_job;
        $data[] = $_SERVER['REMOTE_ADDR'];
        $data[] = $extra_data;
        
        $query = "INSERT INTO tb_sys_logprogramuse(login_id, use_job, use_ip, extra_data, use_datetime) VALUES (?,?,?,?,now())";
        $exec = $water_db->insert($query, $data);
    }
}
?>