<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');

$query = "select * from tank_tb";
$result = $water_db->select($query, array());

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
</script>
</head>
<body>
<?php include "../common/top_menu.php" ?>

<form name="form1" method="post" action="tank_proc.php">
  <input type="hidden" name="exec_type" value="ins">
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
          수조 분류<strong class="sound_only">필수</strong>
        </label>
      </th>
      <td class="pform">
        <input type="text" name="tank_category" id="tank_category" size="40" maxlength="255" style="width: 66%;" class="frm_input required">
      </td>
    </tr>
    <tr>
      <th scope="row" class="title1">
        <label for="tag_name">
          수조이름<strong class="sound_only">필수</strong>
        </label>
      </th>
      <td class="pform">
        <input type="text" name="tag_name" id="tag_name" size="25" maxlength="50" style="width: 66%;" class="frm_input required">
      </td>
	  </tr>
	  <tr>
      <th scope="row" class="title1">
        <label for="tag_status">
          수조상태<strong class="sound_only">필수</strong>
        </label>
      </th>
      <td width="290" class="pform">
        <input type="text" name="tag_status" id="tag_status" size="10" maxlength="5" style="width: 66%;" class="frm_input required">
        
      </td>
    </tr>

    </table>
    <div class="center mT30">
        <input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit">
        <a href="javascript:history.go(-1);" class="btn_b01">취소</a>
    </div>
</div>
</form>
</body>
</html>