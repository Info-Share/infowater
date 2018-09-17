<?php
    
    /**
     * 메세지만 출력
     * @param unknown $msg
     */
    function alert($msg) {
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
    function alert_redirect($msg, $url, $script='') {
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
    function alert_redirect_html($msg, $url, $script='') {
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
    
    function alert_close($msg, $script = '') {
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
    function alert_close_parent($msg) {
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
    
 