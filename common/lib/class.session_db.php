<?php

class SysSession implements SessionHandlerInterface {
    
    private $link;
   
    
    
    /**
     * 세션 오픈
     * {@inheritDoc}
     * @see SessionHandlerInterface::open()
     */
    public function open($savePath, $sessionName) {
        global $settings;
        $schema = 'gongje';
        $conn = oci_connect($settings[$schema . '_user'], $settings[$schema . '_pass'], $settings[$schema . '_host'] . '/' . $settings[$schema . '_sid'], $settings[$schema . '_charset']);
       
        if($conn) {
            $this->link = $conn;
            return true;
        } else {
            return false;
        }
    }

    /**
     * 세션 닫기
     * {@inheritDoc}
     * @see SessionHandlerInterface::close()
     */
    public function close() {
        
        oci_close($this->link);
        return true;
        
    }

    /**
     * 세션 정보 읽기
     * {@inheritDoc}
     * @see SessionHandlerInterface::read()
     */
    public function read($id) {
        
       
        global $settings;
        
        
        $date_str = date('Y-m-d H:i:s', time() - $settings['session_gc_maxlifetime']);
        $date_str = date('Y-m-d H:i:s', time());
        
        $query = "SELECT session_data FROM GONGJE_SYS_SESS WHERE session_id = :b1 AND session_expires > TO_DATE(:b2, 'YYYY-MM-DD HH24:MI:SS')";
        
        $stmt_read = oci_parse($this->link, $query);

        $bind = oci_bind_by_name($stmt_read, ':b1',  $id);
        $bind = oci_bind_by_name($stmt_read, ':b2',  $date_str);
                
        $execc1 = oci_execute($stmt_read);
        
        $row = oci_fetch_array($stmt_read, OCI_ASSOC + OCI_RETURN_NULLS);
        
        @oci_free_statement($stmt_read);
        
        
        if($row) {
            $this->rowSessionId = $id;
            return $row['SESSION_DATA'];
        } else {
            return "";
        }
        
        
    }

    /**
     * 세션에 정보 저장
     * {@inheritDoc}
     * @see SessionHandlerInterface::write()
     */
    public function write($id, $data) {
        
        global $settings;

        
        $dateTime = date('Y-m-d H:i:s');
        $dateTime = date('Y-m-d H:i:s', time() + $settings['session_gc_maxlifetime']);
        $login_sabun = $_SESSION['sabun_sess'];
        $login_ip = $_SERVER['REMOTE_ADDR'];
        
        
            
        $query = "
                MERGE INTO GONGJE_SYS_SESS A
                            USING DUAL
                            ON (A.SESSION_ID = :b1)
                            WHEN MATCHED THEN
                                      UPDATE SET
            
                                            SESSION_EXPIRES = TO_DATE(:b2, 'YYYY-MM-DD HH24:MI:SS'),
                                            SESSION_DATA = :b3,
                                            LOGIN_IP = :b4,
                                            LOGIN_SABUN = :b5
            
            
                            WHEN NOT MATCHED THEN
                                      INSERT (SESSION_ID, SESSION_EXPIRES, SESSION_DATA, LOGIN_IP, LOGIN_SABUN)
                                             VALUES (:b6, TO_DATE(:b7, 'YYYY-MM-DD HH24:MI:SS'), :b8, :b9, :b10)
            
                ";
        $stmt_rep = oci_parse($this->link, $query);
        
        
        $bind = oci_bind_by_name($stmt_rep, ':b1',  $id);
        $bind = oci_bind_by_name($stmt_rep, ':b2',  $dateTime);
        $bind = oci_bind_by_name($stmt_rep, ':b3',  $data);
        $bind = oci_bind_by_name($stmt_rep, ':b4',  $login_ip);
        $bind = oci_bind_by_name($stmt_rep, ':b5',  $login_sabun);
        $bind = oci_bind_by_name($stmt_rep, ':b6',  $id);
        $bind = oci_bind_by_name($stmt_rep, ':b7',  $dateTime);
        $bind = oci_bind_by_name($stmt_rep, ':b8',  $data);
        $bind = oci_bind_by_name($stmt_rep, ':b9',  $login_ip);
        $bind = oci_bind_by_name($stmt_rep, ':b10',  $login_sabun);


        
        $result = oci_execute($stmt_rep);

        
        @oci_free_statement($stmt_rep);
        

        if($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 세션 삭제
     * {@inheritDoc}
     * @see SessionHandlerInterface::destroy()
     */
    public function destroy($id) {
        

        
        $query = "DELETE FROM GONGJE_SYS_SESS WHERE session_id = :b1";
        $stmt_del = oci_parse($this->link, $query);
        
        
        $bind = oci_bind_by_name($stmt_del, ':b1',  $id);
        
        
        $result = oci_execute($stmt_del);
        
        
        @oci_free_statement($stmt_del);
        
        if($result){
            return true;   
        }else{
            return false;
        }
        
        

    }

    /**
     * 가비지 컬렉션
     * {@inheritDoc}
     * @see SessionHandlerInterface::gc()
     */
    public function gc($maxlifetime) {

        
        $endDate = date("Y-m-d H:i:s", time() - $maxlifetime);
        $query = "DELETE FROM GONGJE_SYS_SESS WHERE session_expires < TO_DATE(:b1, 'YYYY-MM-DD HH24:MI:SS')";
        
        $stmt_del = oci_parse($this->link, $query);
        

        
        $bind = oci_bind_by_name($stmt_del, ':b1',  $endDate);

        
        
        $result = oci_execute($stmt_del);

        
        @oci_free_statement($stmt_del);
        
        
  
        if($result) {
            return true;
        } else {
            return false;
        }
    }
}
?>