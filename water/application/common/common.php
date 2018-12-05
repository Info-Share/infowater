<?php
error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING );

// 보안설정이나 프레임이 달라도 쿠키가 통하도록 설정
header('P3P: CP="ALL CURa ADMa DEVa TAIa OUR BUS IND PHY ONL UNI PUR FIN COM NAV INT DEM CNT STA POL HEA PRE LOC OTC"');

// include 페이지 개별 로딩 금지
define('_SAEUL_', true);

//==============================================================================
// 공통
//------------------------------------------------------------------------------
date_default_timezone_set("Asia/Seoul");

require_once($_SERVER['DOCUMENT_ROOT'].'/common/lib/class.WorkLogger.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/lib/class.utility.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/../settings.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/lib/class.mysqli_db.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/common/lib/class.mysql_db.php');

// $connect_db = sql_connect(G5_MYSQL_HOST, G5_MYSQL_USER, G5_MYSQL_PASSWORD) or die('MySQL Connect Error!!!');
//    $select_db  = sql_select_db(G5_MYSQL_DB, $connect_db) or die('MySQL DB Error!!!');


$water_conn = @mysqli_connect($settings['water_host'], $settings['water_user'], $settings['water_pass'], $settings['water_name']);
if (!$water_conn) {
    Util::redirectErrorPage();
}
mysqli_set_charset($water_conn, $settings['water_charset']);

$water_db = new MySQLI_DB($water_conn);


//==============================================================================
// SESSION 설정
//------------------------------------------------------------------------------
@ini_set("session.use_trans_sid", 0); // PHPSESSID를 자동으로 넘기지 않음
@ini_set("url_rewriter.tags", ""); // 링크에 PHPSESSID가 따라다니는것을 무력화함 

//세션 저장 폴더
session_save_path($_SERVER['DOCUMENT_ROOT'].'/data/session');
ini_set('session.gc_probability', 1);

//include_once($_SERVER['DOCUMENT_ROOT'].'/common/lib/class.session_db.php');
//session_set_save_handler(new SysSession(), true);

ini_set("session.cache_expire", 180); // 세션 캐쉬 보관시간 (분)
ini_set("session.gc_maxlifetime", $settings['session_gc_maxlifetime']); // session data의 garbage collection 존재 기간을 지정 (초)
ini_set("session.gc_probability", 1); // session.gc_probability는 session.gc_divisor와 연계하여 gc(쓰레기 수거) 루틴의 시작 확률을 관리합니다. 기본값은 1입니다. 자세한 내용은 session.gc_divisor를 참고하십시오.
ini_set("session.gc_divisor", 100); // session.gc_divisor는 session.gc_probability와 결합하여 각 세션 초기화 시에 gc(쓰레기 수거) 프로세스를 시작할 확률을 정의합니다. 확률은 gc_probability/gc_divisor를 사용하여 계산합니다. 즉, 1/100은 각 요청시에 GC 프로세스를 시작할 확률이 1%입니다. session.gc_divisor의 기본값은 100입니다.

session_set_cookie_params(0, '/');
ini_set("session.cookie_domain", '');

@session_start();


// ==============================================================================
// 공용 함수 지정
// ------------------------------------------------------------------------------
// multi-dimensional array에 사용자지정 함수적용


?>