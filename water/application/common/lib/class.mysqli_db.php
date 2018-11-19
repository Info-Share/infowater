<?php
class MySQLI_DB {
    private $conn; // 데이터베이스 연결
    private $strip; // stripslashes 적용 여부
    private $transaction; // 트랜잭션사용 여부
    private $error_count; // 에러 카운트

    /**
     * 생성자
     * @param mysqli $connection
     */
    public function __construct($connection, $strip = false) {
        $this->conn = $connection;
        $this->strip = $strip;
        $this->transaction = false;
        $this->error_count = 0;
    }
    
    /**
     * 조회
     * @param unknown $query
     * @param unknown $args
     * @return unknown
     */
    public function select($query, $args = null) {
        if($args == null) {
            $result = mysqli_query($this->conn, $query);
            if(!$result) {
                $this->error_prepare();
            }
            return $result;
        } 
        else {
            $stmt = mysqli_prepare($this->conn, $query);
            if(!$stmt) {
                $this->error_prepare();
                return $stmt;
            }
            
            $bind = $this->bind_param($stmt, $args);
            if(!$bind) {
                $this->error_stmt($stmt);
                return $stmt;
            }
            
            $exec = mysqli_execute($stmt);
            if(!$exec) {
                $this->error_stmt($stmt);
                return $exec;
            }
            
            $result = mysqli_stmt_get_result($stmt);
            mysqli_stmt_close($stmt);
            return $result;
        }
    }
    
    /**
     * 한건을 조회한다.
     * 
     * @param unknown $query
     * @param unknown $args
     */
    public function selectOne($query, $args = null) {
        $result = $this->select($query, $args);
        if(!result) {
            return false;
        }
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * 한건을 조회하는데 fetch_array 로 조회 한다.
     * @param unknown $query
     * @param unknown $args
     */
    public function selectOneFetchArray($query, $args = null) {
        $result = $this->select($query, $args);
        if(!$result) {
            return false;
        }
        return mysqli_fetch_array($result);
    }
    
    /**
     * 한건을 조회하는데 fetch_array 로 조회 한다.
     * @param unknown $query
     * @param unknown $args
     */
    public function selectOneFetchRow($query, $args = null) {
        $result = $this->select($query, $args);
        if(!$result) {
            return false;
        }
        return mysqli_fetch_row($result);
    }
    
    /**
     * 업데이트를 수행한다.
     * @param unknown $query
     * @param unknown $args
     */
    public function update($query, $args = null) {
        return $this->maint($query, $args);
    }
    
    /**
     * 삭제를 수행한다.
     * @param unknown $query
     * @param unknown $args
     * @return unknown
     */
    public function delete($query, $args = null) {
        return $this->maint($query, $args);
    }
    
    /**
     * 입력 작업을 수행한다.
     * @param unknown $query
     * @param unknown $args
     */
    public function insert($query, $args = null) {
        return $this->maint($query, $args);
    }
    
    /**
     * DDL 을 실행한다.
     * 
     * @param unknown $query
     * @param unknown $args
     */
    public function ddl($query, $args = null) {
        return $this->maint($query, $args);
    }
    
    /**
     * escape 문자열을 반환한다.
     * @param unknown $str
     */
    public function esc($str) {
        if($this->strip) {
            $str = stripslashes($str);
        }
        return mysqli_real_escape_string($this->conn, $str);
    }
    
    /**
     * 마지막에 입력된 아이디를 반환한다.
     */
    public function getInsertedId() {
        return mysqli_insert_id($this->conn);
    }
    
    /**
     * 한 행, 한 컬럼 값 가져오기.
     * @param unknown $query
     * @param unknown $args
     */
    public function resultOne($query, $args = null) {
        $row = $this->selectOneFetchArray($query, $args);
        if(!$row) {
            return false;
        }
        return $row[0];
    }
    
    /**
     * 입력된 배열에 대한 타입 문자열을 반환한다.
     * @param array $row
     * @return string
     */
    public function getRowType(array $row) {
        $types = '';
        foreach($row as $val) {
            $types .= $this->determineType($val);
        }
        return $types;
    }
    
    /**
     * 에러 문자열을 반환한다.
     */
    public function error() {
        return mysqli_error($this->conn);
    }
    
    /**
     * 트랜잭션을 시작한다.
     */
    public function begin_transaction() {
        $this->transaction = true;
        $this->error_count = 0;
        return mysqli_begin_transaction($this->conn, MYSQLI_TRANS_START_READ_WRITE);
    }
    
    /**
     * 에러 발생 횟수를 반환한다.
     * @return number
     */
    public function getErrorCount() {
        return $this->error_count;
    }
    
    /**
     * 트랜잭션을 커밋한다.
     */
    public function commit() {
        $this->transaction = false;
        $this->error_count = 0;
        mysqli_commit($this->conn);
    }
    
    /**
     * 트랜잭션을 롤백한다.
     */
    public function rollback() {
        $this->transaction = false;
        $this->error_count = 0;
        mysqli_rollback($this->conn);
    }
    
    /**
     * 입력, 수정, 삭제 작업을 수행한다.
     * @param unknown $query
     * @param unknown $args
     * @return unknown
     */
    private function maint($query, $args = null) {
        if($args == null) {
            $stmt = mysqli_prepare($this->conn, $query);
            if(!$stmt) {
                $this->error_prepare();
                return $stmt;
            }
            
            $exec = mysqli_stmt_execute($stmt);
            if(!$exec) {
                $this->error_stmt($stmt);
                return $exec;
            }
            
            mysqli_stmt_close($stmt);
            return $exec;
        }
        else {
            $stmt = mysqli_prepare($this->conn, $query);
            if(!$stmt) {
                $this->error_prepare();
                return $stmt;
            }
            
            $bind = $this->bind_param($stmt, $args);
            if(!$bind) {
                $this->error_stmt($stmt);
                return $bind;
            }
            
            $exec = mysqli_stmt_execute($stmt);
            if(!$exec) {
                $this->error_stmt($stmt);
            }
            mysqli_stmt_close($stmt);
            return $exec;
        }
    }
    
    /**
     * 쿼리 prepare 시 발생오류
     */
    private function error_prepare() {
        $this->log(mysqli_error($this->conn));
    }
    
    /**
     * statement 정상 생성후 발생 오류 보고
     * @param unknown $stmt
     */
    private function error_stmt($stmt) {
        $this->log(mysqli_stmt_error($stmt));
    }
    
    /**
     * 에러를 로깅한다. 에러 카운터를 증가 시킨다.
     * @param unknown $msg
     */
    private function log($msg) {
        global $logger;
        if($this->transaction) {
            $this->error_count++;
        }
        $error_msg = 'MySQLI_DB ===============> ' . $msg . '<br />';
        //echo($error_msg);
        $logger->debug($error_msg);
    }
    
    /**
     * statement 에 값들을 바인딩 한다.
     * 
     * @param unknown $stmt
     * @param unknown $vars
     */
    private function bind_param($stmt, $vars) {
        $types = '';
        foreach($vars as $key => $val) {
            if($this->strip) {
                $vars[$key] = stripslashes($val);
            }
            $types .= $this->determineType($val);
        }
        
        $refs = array();
        $idx = 0;
        $refs[$idx++] = $stmt;
        $refs[$idx++] = $types;
        foreach($vars as $key => $val) {
            $refs[$idx++] = &$vars[$key];
        }
        return call_user_func_array('mysqli_stmt_bind_param', $refs);
    }
    
    /**
     * 변수 타입을 반환한다.
     * @param unknown $item
     */
    private function determineType($item) {
        $type = '';
        switch(gettype($item)) {
            case 'NULL':
            case 'string':
                $type = 's';
                break;
            case 'boolean':
            case 'integer':
                $type = 'i';
                break;
            case 'blob':
                $type = 'b';
                break;
            case 'double':
                $type = 'd';
                break;
            default:
                $type = 's';
                break;
        }
        return $type;
    }
}
?>