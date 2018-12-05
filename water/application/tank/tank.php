<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');


$page = $_REQUEST['page'];

if($page == "" ) {
    $page = 1;
}

$line = 10;

$start_idx = Util::listIndex($page, $line);
$img_top = "<img src='/images/board/ico_first.gif' border='0' align='absmiddle' alt='처음'>";
$img_end = "<img src='/images/board/ico_last.gif' border='0' align='absmiddle' alt='끝'>";
$img_prev = "<img src='/images/board/ico_prev.gif' border='0' align='absmiddle' alt='이전'>";
$img_next = "<img src='/images/board/ico_next.gif' border='0' align='absmiddle' alt='다음'>";
$link = "";



$query = "select * from tank_tb order by tank_idx desc limit ?, ?";

$search_arr = array();
$search_arr[] = $start_idx;
$search_arr[] = $line;
$result = $water_db->select($query, $search_arr);

?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title>수질계측모니터링시스템</title>
<?php include "../common/header.php" ?>
<style>
.table_head{
	width:76px;
	text-align:center
}
.td{

}
</style>
<script>
function getdata(){

	$.ajax({
		url: "",
		type: "get",
		data: "",
		dataType: "json",
		success: function(data, status, xhr) {
			equip_list_print(data);
		},
		error: function(jqXHR, textStatus, errorThrown) {
			alert("데이터를 불러오는데 실패했습니다.");
		}
	});
	
	
}
</script>
</head>
<body>
<?php include "../common/top_menu.php" ?>


<div class="tbl_head01 tbl_wrap mT20">
  <table style="width:1200px; margin-top:50px; margin-right: auto; margin-left: auto;">
    <caption>수조테이블</caption>
    <colgroup>
      <col width="5%" />
      <col width="12%" />
      <col width="*%" />
      <col width="12%" />
    </colgroup>
    <thead>
      <tr>
        <th scope="col">번호</th>
        <th scope="col">수조분류</th>
        <th scope="col">수조이름</th>
        <th scope="col">수조상태</th>
      </tr>
    </thead>
<?php
	$query_total = "select count(*) as cnt from tank_tb";
	$result_total = $water_db->select($query_total, array());
	$row_total = mysqli_fetch_array($result_total);
	$total = $row_total['cnt'];

	while($row = mysqli_fetch_array($result)){

		$count ++;
		$bgcolor = ($count % 2 == 1) ? "#FFFFFF" : "#F3F5F5";
		$s_no = $total - ($start_idx + $count)+1;
	    echo "
		<tr height=23 bgcolor='{$bgcolor}' align=center>
		  <td style='color:#666666; text-align:center'>{$s_no}</td>
		  <td style='color:#666666; text-align:left'><a href='tank_view.php?tank_idx=".$row['tank_idx']."&page=".$page."'> {$row['tank_category']}</a></td>
		  <td style='color:#666666; text-align:left'><a href='tank_view.php?tank_idx=".$row['tank_idx']."&page=".$page."'> {$row['tag_name']}</a></td>
		  <td style='color:#666666; text-align:left'><a href='tank_view.php?tank_idx=".$row['tank_idx']."&page=".$page."'> {$row['tag_status']}</a></td>
		</tr>";
	}

if(! $count) {
    echo "<div class='center'> 자료가 없습니다.</div>";
}
?>
	<tr>
		<td colspan="4" style="border-bottom:0">
			<div class="center mT20">
			<?php
			Util::listPage("tank.php");
			?>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="4">
			<div class="btn_fR" >
				<a href="tank_write.php?page=<?php echo $page?>" class="btn_b01">글쓰기</a>
			</div>
		</td>
	</tr>
</table>
</div>

</body>
</html>