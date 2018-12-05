<?php
class MySQL_DB {
    private $conn; // 데이터베이스 연결
    private $strip; // stripslashes 적용 여부
    private $transaction; // 트랜잭션사용 여부
    private $error_count; // 에러 카운트
    public $dbname;

    /**
     * 생성자
     */
    public function __construct($connection, $dbname, $strip = false) {
        $this->conn = $connection;
        $this->strip = $strip;
        $this->transaction = false;
        $this->error_count = 0;
        $this->dbname = $dbname;
    }
    
    /**
     * 조회
     */
    public function select($query) {
       mysql_select_db($this->dbname);
       return mysql_query($query, $this->conn);
    }
    
    /**
     * 한건을 조회한다.
     */
    public function selectOne($query) {
        $result = $this->select($query);
        if(!result) {
            return false;
        }
        return mysql_fetch_assoc($result);
    }
    
    /**
     * 한건을 조회하는데 fetch_array 로 조회 한다.
     */
    public function selectOneFetchArray($query) {
        $result = $this->select($query);
        if(!$result) {
            return false;
        }
        return mysql_fetch_array($result);
    }
    
    /**
     * 한건을 조회하는데 fetch_row 로 조회 한다.
     */
    public function selectOneFetchRow($query) {
        $result = $this->select($query);
        if(!$result) {
            return false;
        }
        return mysql_fetch_row($result);
    }
    
    /**
     * 업데이트를 수행한다.
     */
    public function update($query) {
        return $this->maint($query);
    }
    
    /**
     * 삭제를 수행한다.
     */
    public function delete($query) {
        return $this->maint($query);
    }
    
    /**
     * 입력 작업을 수행한다.
     */
    public function insert($query) {
        return $this->maint($query);
    }
    
    /**
     * DDL 을 실행한다.
     */
    public function ddl($query) {
        return $this->maint($query);
    }
    
    /**
     * escape 문자열을 반환한다.
     */
    public function esc($str) {
        if($this->strip) {
            $str = stripslashes($str);
        }
        return mysql_real_escape_string($str, $this->conn);
    }
    
    /**
     * 마지막에 입력된 아이디를 반환한다.
     */
    public function getInsertedId() {
        return mysql_insert_id($this->conn);
    }
    
    /**
     * 한 행, 한 컬럼 값 가져오기.
     */
    public function resultOne($query) {
        $row = $this->selectOneFetchArray($query);
        if(!$row) {
            return false;
        }
        return $row[0];
    }
    
    /**
     * 입력, 수정, 삭제 작업을 수행한다.
     */
    private function maint($query) {
        mysql_select_db($this->dbname);
        $exec = mysql_query($query, $this->conn);
        return $exec;
    }
}
?>