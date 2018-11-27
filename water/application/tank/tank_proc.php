<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');

// exec_type 받기
$exec_type = $_POST['exec_type'];
$page = $_REQUEST['page'];
if($exec_type=="ins"){
	$tank_category = $_POST['tank_category'];
	$tag_name = $_POST['tag_name'];
	$tag_status = $_POST['tag_status'];
	$query = "INSERT INTO tank_tb( tank_category, tag_name, tag_status ) VALUES (?, ?, ?)";

	$refs = array();
	$refs[] = $tank_category;
	$refs[] = $tag_name;
	$refs[] = $tag_status;

	$exec = $water_db->update($query, $refs);

	$tank_idx= $water_db->getInsertedId();
	if(! $exec) {
		Util::error_back("입력에 실패했습니다.");
	}

	WorkLogger::work("수조관리", "입력_".$tank_idx, "test");
	Util::gotoUrl("tank_view.php?page=".$page."&tank_idx=".$tank_idx);

} else if ($exec_type=="upd"){
	$tank_category = $_POST['tank_category'];
	$tag_name = $_POST['tag_name'];
	$tag_status = $_POST['tag_status'];
	$tank_idx = $_POST['tank_idx'];
	$query = " UPDATE tank_tb SET tank_category = ?, tag_name = ?, tag_status =?  WHERE tank_idx = ? ";

	$refs = array();
	$refs[] = $tank_category;
	$refs[] = $tag_name;
	$refs[] = $tag_status;
	$refs[] = $tank_idx;

	$exec = $water_db->update($query, $refs);

	if(! $exec) {
		Util::error_back("수정에 실패했습니다.");
	}


	WorkLogger::work("수조관리", "수정_".$tank_idx, "test");
	Util::alert_redirect("수정되었습니다.","tank_view.php?tank_idx=".$tank_idx."&page=".$page); 
} else if ($exec_type=="del"){
	$tank_idx = $_POST['tank_idx'];
	$exec = $water_db->delete(" DELETE FROM tank_tb WHERE tank_idx=?", array($tank_idx));
	
	if(! $exec) {
		Util::error_back("삭제에 실패했습니다.");
	}

	WorkLogger::work("수조관리", "삭제_".$tank_idx, "test");
	Util::alert_redirect("삭제되었습니다.","tank.php?page=".$page); 

}

?>