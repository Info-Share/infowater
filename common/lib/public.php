<?php 
//문자열에 '' 붙여준다.
// function addstr($str){
// 	return "'" . $str . "'";
// }


//문자열 구간 자르는 함수
//특정 구분자의 사이의 문자열을 가져옵니다.
//$str - 문자열값, $start - 시작 구분자 ,$end - 끝 구분자
function strselect($str,$start,$end){

   # 문자(*)가 있는 위치를 알아낸다
   $po = strpos($str, $start);

   # 첫번째 문자(*) 다음부터 추출하기 위해 $po를 1증가

   $po += 1;

     # 마지막 문자(*) 를 만나면 while 구문을 끝낸다
      while($po){

        # 참고 문자열도 배열처럼 사용할수 있음

       if ($str[$po] == $end) { break; }

       $strend .= $str[$po];
       $po++;

     }

	return $strend;
}
//크로스사이트스크립팅 취약점 대응방안 추가 2015.04.13
function replaceXSS($str) {
	$str = str_replace( "&", "&#38;", $str );
	$str = str_replace( "<", "&lt", $str );
	$str = str_replace( ">", "&gt", $str );
	//$str = str_replace( "(", "&#40;", $str );
	//$str = str_replace( ")", "&#41;", $str );
	$str = str_replace( "#", "&#35;", $str );
	$str = str_replace( "'", "&#39;", $str );
	//$str = str_replace(chr(34), "&quot;", $str);	//큰따움표
	
	$str = addslashes($str);
	
	return $str;
}
if($_SERVER['REMOTE_ADDR'] == "10.135.40.219"){
/*
//삽입(injection) 취약점 대응방안 추가 2015.07.14
function replaceInjection($str) {
	$str = str_replace( "&", "&#38;", $str );
	$str = str_replace( "<", "&lt", $str );
	$str = str_replace( ">", "&gt", $str );
	$str = str_replace( "(", "&#40;", $str );
	$str = str_replace( ")", "&#41;", $str );
	$str = str_replace( "#", "&#35;", $str );
	
	return $str;
}
*/

/*
"",""""""""""""""""


foreach($_GET as $key => $value){

	$$key =$value;
	if (!is_array($$key)){
		${$key}  =  replaceInjection(${$key});
		$_GET[$key] =  replaceInjection(${$key});
	}else{
		for($a=0;$a <sizeof($$key);$a++)
		echo $key."[".$a."]"."<br>";
	}
}

foreach($_POST as $key => $value){

	$$key =$value;
	if (!is_array($$key)){
		${$key}   =  "2";
		$_POST[a] =  "2";
	}else {
		for($a=0;$a <sizeof($$key);$a++)
		echo $key."[".$a."]"."<br>";
	}
}

*/
}

/////날짜 검색시 날짜 포맷 변환 함수
function changeDate($date1,$date2){
	$sdate   = explode("-",$date1);
	$edate   = explode("-",$date2);

	$syear   = (int)$sdate[0];
	$smonth  = (int)$sdate[1];
	$sday    = (int)$sdate[2];

	$eyear	 = (int)$edate[0];
	$emonth  = (int)$edate[1];
	$eday	 = (int)$edate[2];

	$sdate = mktime(0,0,1,$smonth,$sday,$syear);
	$edate = mktime(23,59,59,$emonth,$eday,$eyear);

	return array($sdate,$edate);
}




# 페이징 함수
#####################################################################################################################################
//$page_num : 현재 페이지 수
//$totalpage : 전체 페이지 수
//$search : 검색 조건
//$searchword : 검색어
//$page : 현재 페이지
function getpaging($page_num,$totalpage,$search,$flag,$page,$etc=""){
	$boardpage = 10;//페이징 영역
	$pagelist = ceil($page_num/$boardpage);
	$totallist = ceil($totalpage/$boardpage);
	$prev_page = ($pagelist-"1")*$boardpage;
	$next_page=(($pagelist+"1")*$boardpage)-9;
	if($totalpage<$next_page)
		$next_page=$totalpage;

	$i = 1;
    $html = "";
	
	if(($pagelist - 1) == 0) {
		$html .= "";
	}else{
		$html .= "<a href='$page?page_num=1&search=$search&flag=$flag$etc'  class='pg_page pg_start'>[처음]</a>";
		$html .= "<a href='$page?page_num=$prev_page&search=$search&flag=$flag$etc' class='pg_page pg_prev'>[이전]</a>";
	}

	while($i <= $totalpage) {
		if (($i > ($pagelist - 1) * $boardpage) && ($i <= $pagelist * $boardpage)) {
			if($i == $page_num)
				$html .= "<strong class='pg_current'>$i</strong>";
			else
				$html .= "<a href='$page?page_num=$i&search=$search&flag=$flag$etc'  class='pg_page'>$i</a>";
		}
		$i++;
	}

	if($totallist == 0 || $totallist == $pagelist) {
		$html .= "";
	}else{
		$html .= "<a href='$page?page_num=$next_page&search=$search&flag=$flag$etc' class='pg_page pg_next'>[다음]</a>";
		$html .= "<a href='$page?page_num=$totalpage&search=$search&flag=$flag$etc' class='pg_page pg_end'>[맨끝]</a>";
	}

	if ($html){
	    return "<nav class=\"pg_wrap\"><span class=\"pg\">{$html}</span></nav>";
	}else{
	    return "";
	}
}


function session_register($name){
    if(isset($GLOBALS[$name])) $_SESSION[$name] = $GLOBALS[$name];
    $GLOBALS[$name] = $_SESSION[$name];
}

function session_unregister($name){
    unset($_SESSION[$name]);
}

//한글 자르기
function cut_str($str, $len, $suffix="")
{
    $arr_str = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
    $str_len = count($arr_str);
    
    if ($str_len >= $len) {
        $slice_str = array_slice($arr_str, 0, $len);
        $str = join("", $slice_str);
        
        return $str . ($str_len > $len ? $suffix : '');
    } else {
        $str = join("", $arr_str);
        return $str;
    }
}


//셀렉트박스 선택
function get_selected($field, $value)
{
    return ($field==$value) ? ' selected="selected"' : '';
}

//hash 패스워드 비교
function hash_compare($a, $b) {
    if (!is_string($a) || !is_string($b)) {
        return false;
    }
    
    $len = strlen($a);
    if ($len !== strlen($b)) {
        return false;
    }
    
    $status = 0;
    for ($i = 0; $i < $len; $i++) {
        $status |= ord($a[$i]) ^ ord($b[$i]);
    }
    return $status === 0;
} 

//crypt 패스워드 비교
function validate_pw($password, $hash){
    /* Regenerating the with an available hash as the options parameter should
     * produce the same hash if the same password is passed.
     */
    return crypt($password, $hash)==$hash;
}
?>