<?php
/**********************************************************
 프로그램명 : class.esapi.php
 설명 : OWASP esapi 유틸
 작성자 : 양찬우
 소속 : (주)비전아이티
 일자 : 18.06.12
 프로그램설명
 OWASP esapi 유틸
 **프로그램이력**
 수정일          작업근거             유지보수담당
 '18.06.12       최초생성             양찬우
 **********************************************************/

require_once ($_SERVER ['DOCUMENT_ROOT'] . '/owasp/src/ESAPI.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/owasp/src/reference/DefaultValidator.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/owasp/src/codecs/MySQLCodec.php');
require_once ($_SERVER ['DOCUMENT_ROOT'] . '/owasp/src/codecs/OracleCodec.php');

class OWASP_Esapi {
    private $esapi = null;
    private $encoder = null;
    private $validator = null;
    private $purifier = null;
    private $mysqlcodec = null;
    private $oraclecodec = null;
    private $strip = null;
    
    // 생성자
    function __construct($strip = false) {
        $this->strip = $strip;
        $this->esapi = new ESAPI ( $_SERVER ['DOCUMENT_ROOT'] . "/../ESAPI.xml" );
        ESAPI::setEncoder ( new DefaultEncoder () );
        ESAPI::setValidator ( new DefaultValidator () );
        $this->encoder = ESAPI::getEncoder ();
        $this->validator = ESAPI::getValidator ();
        $this->mysqlcodec = new MySQLCodec();
        $this->oraclecodec = new OracleCodec();
        
        // HTMLPurifier 생성
        $f = file($_SERVER['DOCUMENT_ROOT'].'/common/plugin/htmlpurifier/safeiframe.txt');
        $domains = array();
        foreach($f as $domain){
            // 첫행이 # 이면 주석 처리
            if (!preg_match("/^#/", $domain)) {
                $domain = trim($domain);
                if ($domain)
                    array_push($domains, $domain);
            }
        }
        // 내 도메인도 추가
        array_push($domains, $_SERVER['HTTP_HOST'].'/');
        $safeiframe = implode('|', $domains);
        include_once($_SERVER['DOCUMENT_ROOT'].'/common/plugin/htmlpurifier/HTMLPurifier.standalone.php');
        $config = HTMLPurifier_Config::createDefault();
        // data/cache 디렉토리에 CSS, HTML, URI 디렉토리 등을 만든다.
        $config->set('Cache.SerializerPath', $_SERVER['DOCUMENT_ROOT'].'/data/cache');
        $config->set('HTML.SafeEmbed', false);
        $config->set('HTML.SafeObject', false);
        $config->set('Output.FlashCompat', false);
        $config->set('HTML.SafeIframe', true);
        $config->set('URI.SafeIframeRegexp','%^(https?:)?//('.$safeiframe.')%');
        $config->set('Attr.AllowedFrameTargets', array('_blank'));
        $this->purifier = new HTMLPurifier($config);
    }
    
    // canonicalize 함수
    function cano($input) {
        try {
            $input = $this->encoder->canonicalize ( $input );
        } catch ( IntrusionException $e ) {
            echo ($e->getUserMessage ());
            exit ();
        }
        return $input;
    }
    
    // HTML 출력용
    function html($input) {
        if($input == NULL || trim($input) == "") {
            return '';
        }
        //return $this->encoder->encodeForHTML ( $input );
        $table_begin_count = substr_count(strtolower($input), "<table");
        $table_end_count = substr_count(strtolower($input), "</table");
        for ($i = $table_end_count; $i < $table_begin_count; $i++) {
            $input .= "</table>";
        }
        return $this->purifier->purify($input);
    }
    
    // 자바스크립트 출력용
    function js($input) {
        $input = str_replace('"', '\"', $input);
        $input = str_replace('\'', '\\\'', $input);
        $input = str_replace('/', '\/', $input);
        return $input;
    }
    
    // 폼 속성 출력용
    function attr($input) {
        return $this->encoder->encodeForHTMLAttribute ( $input );
    }
    
    // URL 출력용
    function url($input) {
        return urlencode ( $input );
    }
    
    // Mysql 용 인코딩
    function sql($input) {
        return $this->encoder->encodeForSQL ( $this->mysqlcodec, $input );
    }
    
    // Oracle용 인코딩
    function sqlOracle($input) {
        return $this->encoder->encodeForSQL ( $this->oraclecodec, $input );
    }
    
    /**
     * 숫자 인지 확인한다.
     * @param 체크할 값 $input
     * @param 최소값 $minValue
     * @param 최대값 $maxValue
     * @param NULL 허용 $allowNull
     */
    function isValidNumber($input, $minValue, $maxValue, $allowNull = false) {
        return $this->validator->isValidNumber ( "", (string)$input, $minValue, $maxValue, $allowNull );
    }
    
    function isValidInt($input, $allowNull = false) {
        return $this->validator->isValidNumber ( "", (string)$input, 0, PHP_INT_MAX, $allowNull );
    }
    
    function isValidSmallInt($input, $allowNull = false) {
        return $this->validator->isValidNumber ( "", (string)$input, 0, 65535, $allowNull );
    }
    
    function isValidTinyInt($input, $allowNull = false) {
        return $this->validator->isValidNumber ( "", (string)$input, 0, 255, $allowNull );
    }
    
    function isValidDouble($input, $minValue, $maxValue, $allowNull = false) {
        return $this->validator->isValidDouble ( "", (string)$input, $minValue, $maxValue, $allowNull );
    }
    
    
    /**
     * 출력 가능한 문자인지 체크한다.
     * @param 입력값 $input
     * @param 최대길이 $maxLength
     * @param NULL 허용 $allowNull
     */
    function isValidPrintable($input, $maxLength, $allowNull = false) {
        if($this->strip) {
            if($input) {
                $input = stripslashes($input);
            }
        }
        return $this->validator->isValidPrintable("", (string)$input, $maxLength, $allowNull);
    }
    
    
    
    
    
    /**
     * 날짜 형식이 맞는지 확인한다.
     *
     * @param 입력값 $input
     * @param 날짜 포맷 $format
     * @param 널허용 $allowNull
     */
    function isValidDate($input, $format, $allowNull = false) {
        if($allowNull && ($input == NULL || trim($input) == '')) {
            return true;
        }
        if($format == 'Y') {
            return $this->validator->isValidDate("", $input.'-01', 'Y-m', $allowNull);
        } else if($format == 'Ym') {
            if(strlen($input) == 6) {
                $dateStr = substr($input, 0, 4).'-'.substr($input, 4, 2);
                return $this->validator->isValidDate("", $dateStr, 'Y-m', $allowNull);
            } else {
                return false;
            }
        } else {
            return $this->validator->isValidDate("", $input, $format, $allowNull);
        }
    }
    
    /**
     * 알파벳으로 시작하고, 알파벳, 숫자, _ 로만 이루어진 문자열인가?
     * @param unknown $input
     * @param string $allowNull
     * @return boolean
     */
    function isValidAlphaNumeric($input, $allowNull = false) {
        if($allowNull == false ) {
            if($input === null || $input == '') return false;
        } else {
            if($input === null || $input == '') return true;
        }
        if(!preg_match('/^[A-Za-z_]+[A-Za-z0-9_]*$/', $input)) {
            return false;
        }
        return true;
    }
    
    function isValidAlNumNoOrder($input, $allowNull = false) {
        if($allowNull == false ) {
            if($input === null || $input == '') return false;
        } else {
            if($input === null || $input == '') return true;
        }
        if(!preg_match('/[A-Za-z0-9_]*$/', $input)) {
            return false;
        }
        return true;
    }
    
    /**
     * IP 주소 형식을 체크한다.
     *
     * @param unknown $input
     * @param string $allowNull
     * @return boolean
     */
    function isValidIpAddress($input, $allowNull = false) {
        if($allowNull == false ) {
            if($input === null || $input == '') return false;
        } else {
            if($input === null || $input == '') return true;
        }
        if(!preg_match('/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/', $input)) {
            return false;
        }
        return true;
    }
    
    /**
     * 유효한 이메일인지 체크한다.
     *
     * @param unknown $input
     * @param string $allowNull
     * @return boolean
     */
    function isValidEmail($input, $allowNull = false) {
        if($allowNull == false ) {
            if($input === null || $input == '') return false;
        } else {
            if($input === null || $input == '') return true;
        }
        if(!preg_match('/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[a-zA-Z]{2,4}$/', $input)) {
            return false;
        }
        return true;
    }
    
    /**
     * 알파벳 또는 숫자 또는 _ 로만 이루어진 문자열인가?
     * @param unknown $input
     * @param string $allowNull
     * @return boolean
     */
    function isValidAlphaNumericUnderbar($input, $allowNull = false) {
        if($allowNull == false ) {
            if($input === null || $input == '') return false;
        } else {
            if($input === null || $input == '') return true;
        }
        if(!preg_match('/(^[a-zA-Z0-9\_]+$)/', $input)) {
            return false;
        }
        return true;
    }
    
    
}
?>