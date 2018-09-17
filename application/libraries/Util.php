<?php 

class Util {
    /**
     * UTF-8 문자열을 EUC-KR 문자열로 변환한다.
     * @param unknown $input
     * @return string
     */
    static function utf8ToEuckr($input) {
        if($input == null) return '';
        return iconv('utf-8', 'euc-kr', $input);
    }
    
    /**
     * EUC-KR 문자열을 UTF-8 문자열로 변환한다.
     * @param unknown $input
     * @return string
     */
    static function euckrToUtf8($input) {
        if($input == null) return '';
        return iconv('euc-kr', 'utf-8', $input);
    }

    /**
     * CSRF용 토큰을 생성한다.
     * @return string
     */
    
    static function createCSRFToken() {
        return base64_encode(openssl_random_pseudo_bytes(32));
    }
    
    /**
     * 세션의 CSRF 토큰을 가져온다.
     * @return string
     */
    static function getCSRFToken() {
        $_SESSION['_CSRF_TOKEN_'] = Util::createCSRFToken();
        return $_SESSION['_CSRF_TOKEN_'];
    }
    
    /**
     * 세션에 CSRF Token 을 설정한다.
     */
    static function setCSRFToken() {
        $_SESSION['_CSRF_TOKEN_'] = Util::createCSRFToken();
    }
    
    /**
     * CSRF 토큰을 체크한다.
     * @param unknown $token
     */
    static function checkCSRFToken($token) {
         if(!isset($_SESSION['_CSRF_TOKEN_']) || !$_SESSION['_CSRF_TOKEN_']) {
             return false;
         }
         
         if($_SESSION['_CSRF_TOKEN_'] == $token) {
             return true;
         }
         
         return false;
    }
    
    /**
     * 에러 메세지를 출력하고 history back 한다.
     * 
     * @param unknown $msg
     */
    static function error_back($msg, $back = 1) {
        $msg = str_replace("\"", "&quot;", $msg);
        echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
history.go(-$back);
//]]>
</script>
END;
        exit;
    }
    
    static function error_back2($msg, $back) {
        $msg = str_replace("\"", "&quot;", $msg);
        echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
history.go(-$back);
//]]>
</script>
END;
        exit;
    }
    
    /**
     * 전체 html 페이지 생성
     * @param unknown $msg
     * @param number $back
     */
    static function error_back_html($msg, $back = 1) {
        $msg = str_replace("\"", "&quot;", $msg);
        echo <<<END
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>ERROR</title>
<script type="text/javascript">
//<![CDATA[
alert("$msg");
history.go(-$back);
//]]>
</script>
</head>
<body>
</body>
</html>
END;
        exit;
    }
    
    /**
     * 메세지만 출력
     * @param unknown $msg
     */
    static function alert($msg) {
        $msg = str_replace("\"", "&quot;", $msg);
        echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
//]]>
</script>
END;
    }
    
    /**
     * 메세지 팝업후 리다이렉트 한다.
     * @param unknown $msg
     * @param unknown $url
     */
    static function alert_redirect($msg, $url, $script='') {
        $msg = str_replace("\"", "&quot;", $msg);
        echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
$script
window.location.href = "$url";
//]]>
</script>
END;
        exit;
    }
    
    /**
     * 전체 페이지 구조를 가진다.
     * @param unknown $msg
     * @param unknown $url
     * @param string $script
     */
    static function alert_redirect_html($msg, $url, $script='') {
        $msg = str_replace("\"", "&quot;", $msg);
        echo <<<END
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<title>REDIRECT</title>
<script type="text/javascript">
//<![CDATA[
alert("$msg");
$script
window.location.href = "$url";
//]]>
</script>
</head>
<body>
</body>
</html>
END;
        exit;
    }
    
    static function alert_close($msg, $script = '') {
        $msg = str_replace("\"", "&quot;", $msg);
        echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
$script
self.close();
//]]>
</script>
END;
        exit;
    }

    
    /**
     * 메세지 팝업후 부모창을 새로고침한다. 
     * @param unknown $msg
     */
    static function alert_close_parent($msg) {
        $msg = str_replace("\"", "&quot;", $msg);
        echo <<<END
<script type="text/javascript">
//<![CDATA[
alert("$msg");
if(window.opener && !window.opener.closed){
        opener.parent.window.location.reload();
}
self.close();
//]]>
</script>
END;
        exit;
    }
    
    /**
     * URL 이동
     * @param unknown $url
     */
    static function gotoUrl($url) {
        $url = str_replace ( "&amp;", "&", $url );
        $url = str_ireplace(array("%0D%0A", "%0D", "%0A"),'',$url);
        $url = str_replace(array("\r\n", "\r", "\n"),'',$url);
        $url = str_ireplace("trinitysoftinjected",'',$url);
        if (! headers_sent ()) {
            header ( 'Location: ' . $url );
        } else {
            echo '<script>';
            echo 'location.replace("' . $url . '");';
            echo '</script>';
        }
        exit ();
    }
    
    /**
     * 알파벳,숫자,_ 이외의 문자를 필터링 
     * @param string $input
     * @return string|mixed
     */
    static function onlyAlphaNumUnderbar($input) {
        if($input === null || $input == '') return '';
    
        $input = preg_replace('/[^a-z0-9_]/i', '', trim($input));
    
        return $input;
    }
    
    /**
     * 알파벳,숫자 이외의 문자를 필터링
     * @param string $input
     * @return string|mixed
     */
    static function onlyAlphaNum($input) {
        if($input === null || $input == '') return '';
    
        $input = preg_replace('/[^a-z0-9]/i', '', trim($input));
    
        return $input;
    }
    
    
    /**
     * 글 내용을 잘라서 표시한다. 
     * @param unknown $key
     * @param unknown $val
     */
    static function cut_content($content, $len){
        $contents = strip_tags($content);
        $contents = html_entity_decode($contents);
        $contents = preg_replace("/[\r\n\"']/","",$contents); // 모든 공백 제거
        $contents = mb_substr($contents,0,$len).""; // 내용 자르기
        
        return $contents;
    }
    

    


    
    /**
     * 연관 배열의 내용으로 객체의 값을 채운다.
     * 
     * @param unknown $model
     * @param unknown $data
     * @return unknown
     */
    static function feed($model, $data) {
        $class = new ReflectionClass(get_class($model));
        $methods = $class->getMethods();
        
        foreach($data as $key => $val) {
            $m_name = 'set'.ucfirst($key);
            for($i = 0; $i < count($methods); $i++) {
                if($methods[$i]->name == $m_name) {
                    $reflectionMethod = new ReflectionMethod(get_class($model), $m_name);
                    $reflectionMethod->invoke($model, $val);
                }
            }
        }
        
        return $model;
    }
    
    /**
     * 객체가 가진 값의 유효성을 체크한다.
     * @param unknown $model
     */
    static function validate($model) {
        global $esapi;
        
        $class = new ReflectionClass(get_class($model));
        $properties = $class->getProperties();
        
        foreach($properties as $property) {
            $value = $class->getProperty($property->name)->getValue($model);
            
            $doccomment = $property->getDocComment();
            preg_match_all('#@(.*?)\n#s', $doccomment, $annotations);
            
            $name = '';
            $type = '';
            $minval = 0;
            $maxval = 0;
            $maxlength = 0;
            $require = false;
            foreach($annotations[1] as $key => $val) {
                $annotation = trim($val);
                if($annotation == 'required') {
                    $required = true;
                }
                else if(strpos($annotation, 'name ') === 0) {
                    $name = trim(str_replace('name ', '', $annotation));
                }
                else if(strpos($annotation, 'type ') === 0) {
                    $type = trim(str_replace('type ', '', $annotation));
                }
                else if(strpos($annotation, 'minval') === 0) {
                    $minval = trim(str_replace('minval ', '', $annotation));
                }
                else if(strpos($annotation, 'maxval') === 0) {
                    $maxval = trim(str_replace('maxval ', '', $annotation));
                }
                else if(strpos($annotation, 'maxlength') === 0) {
                    $maxlength = trim(str_replace('maxlength ', '', $annotation));
                }
            }
            
            // 유효성 체크
            switch($type) {
                case 'alnum_' :
                    if(!$esapi->isValidAlphaNumeric($value, !$required)) Util::error_back($name . "은(는) 영문자, 숫자, _ 로 만으로 구성되어야 합니다.");
                    break;
                case 'string' :
                    if(!$esapi->isValidPrintable($value, $maxlength, !$required)) Util::error_back($name . "은(는) 문자열이어야 합니다.");
                    break;
                case 'number' :
                    if(!$esapi->isValidNumber($value, $minval, $maxval, !$required)) Util::error_back($name . "은(는) 숫자이어야 합니다.");
                    break;
                case 'yesorno' :
                    if($value != 'Y' && $value != 'N') Util::error_back($name . "은(는) Y or N 이어야 합니다.");
                    break;
                case 'datedash' :
                    if(!$esapi->isValidDate($value, 'Y-m-d', !$required)) Util::error_back($name . "은(는) 올바른 날짜 형식이 아닙니다.");
                    break;
                case 'dateslash' :
                    if(!$esapi->isValidDate($value, 'Y/m/d', !$required)) Util::error_back($name . "은(는) 올바른 날짜 형식이 아닙니다.");
                    break;
                case 'datenosep' :
                    if(!$esapi->isValidDate($value, 'Ymd', !$required)) Util::error_back($name . "은(는) 올바른 날짜 형식이 아닙니다.");
                    break;
            }
        }
    }
    
 
    
    /**
     * 참조배열을 이용하여 option 태그를 생성한다.
     * @param array $arr :option으로 변환할 참조배열
     * @param string $strSelected : selected value
     */
    static function arrToSelectOption($arr, $strSelected = ""){
        global $esapi;
        $rtnValue = "";
        foreach ($arr as $key => $value) {
            $rtnValue .= "<option value=\"{$esapi->attr($key)}\" ". ($key == $strSelected ? " selected=\"selected\"" : "" ) .">{$esapi->attr($value)}</option>";
        }
        return $rtnValue;
    }
    

    
    /**
     * 에러 페이지로 리다이렉트 한다.
     */
    static function redirectErrorPage() {
        global $settings;
        header("location: ".$settings['error_page']);
        exit;
    }
    
    static function checkSQLInjection($input) {
        $temp = preg_replace("/(and|or).*(union|select|insert|update|delete|from|where|limit|create|drop|1=1|\"1\"=\"1|'1'='1|\"1\"=\"2|'1'='2|1=2).*/i", '', $input);
        if($temp != $input) {
            return true;
        }
        return false;
    }
    
    
    /**
     * 비밀번호 초기화
     */
    static function initPW(){
        
        
        //초기화 비밀번호 생성
        //대문자3개 + 소문자 3개 + 숫자 2개 + 특수문자 2개
        $uppers = str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
        $lowers = str_shuffle('abcdefghijklmnopqrstuvwxyz');
        $numbers = str_shuffle('1234567890');
        $specials = str_shuffle('!@#$%^&*()');
        
        $complex_password = substr($uppers,-3).substr($lowers,-3).substr($numbers,-2).substr($specials,-2);
        $more_complex_password = str_shuffle($complex_password);
        //$newpasshash = password_hash($more_complex_password, PASSWORD_DEFAULT);
        
        return $more_complex_password;
        
    }
    
    
    /**
     * 입력받은 자리수 만큼의 랜덤 숫자 만들기
     * @param int $digit
     */
    static function getRandomNumber($digit) {
        $number = "";
        for($i=0; $i<$digit; $i++) {
            $min = ($i == 0) ? 1:0;
            $number .= mt_rand($min,9);
        }
        
        return $number;
    }
    
    
    
    //확장자 필요없이 그냥 읽을경우
    static function reading_file_html($file_dir){
        
        if(!file_exists($file_dir)){
            Util::gotoUrl($settings["http_url"] ."/services/error/error.php");
            
        }else{
            $fp=fopen($file_dir,"r");
            $file_contents=fread($fp,filesize($file_dir));
            if(!$file_contents){
                Util::gotoUrl($settings["http_url"] ."/services/error/error.php");
                fclose($fp);
                exit;
                
            }
            fclose($fp);
        }
        return $file_contents;
    }
}
?>