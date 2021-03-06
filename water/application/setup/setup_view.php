<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');

$tank_idx = $_GET['tank_idx'];
$page = $_GET['page'];
$query = "select * from tank_tb where tank_idx=?";
$result = $water_db->select($query, array($tank_idx));
$row = mysqli_fetch_array($result);

WorkLogger::work("수조관리", "보기", "test");

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
function go_write(){
	window.location="tank_write.php";
}
function fn_del(){
	if(confirm("삭제하시겠습니까?")){
		document.form1.submit();
	}
}
</script>
</head>
<body>
<?php include "../common/top_menu.php" ?>

<form name="form1" method="post" action="tank_proc.php">
  <input type="hidden" name="exec_type" value="del">
  <input type="hidden" name="tank_idx" value="<?php echo $tank_idx?>">
</form>

  <div class="tbl_head01 tbl_wrap">
   <table style="width:700px; margin-top:50px; margin-right: auto; margin-left: auto;"  >
        <caption>수조 등록</caption>
        <colgroup>
        <col width="13%" />
        <col width="*" />
        <col width="15%" /> 
        <col width="15%" />                 
        </colgroup>
    <tr>
      <th scope="row">
        <label for="tank_category">
          수조 분류
        </label>
      </th>
      <td class="pform">
		<?php echo $row['tank_category']?>
      </td>
    </tr>
    <tr>
      <th scope="row" class="title1">
        <label for="tag_name">
          수조이름
        </label>
      </th>
      <td class="pform">
	  	<?php echo $row['tag_name']?>
      </td>
	  </tr>
	  <tr>
      <th scope="row" class="title1">
        <label for="tag_status">
          수조상태
        </label>
      </th>
      <td width="290" class="pform">
		 <?php echo $row['tag_status']?>
      </td>
    </tr>

    </table>
    <div class="center mT30">
		<a href="javascript:fn_del()" class="btn_b01">삭제</a>
		<a href="tank_edit.php?page=<?php echo $page?>&tank_idx=<?php echo $tank_idx?>" class="btn_b01">수정</a>
		<a href="tank.php?page=<?php echo $page?>" class="btn_b01">목록</a>
    </div>
</div>
</body>
</html>