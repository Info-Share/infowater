<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/common/common.php');

$query = "select * from tb_sys_logprogramuse";
$result = $water_db->select($query, array());
while($row = mysqli_fetch_array($result)){
	//echo $row['extra_data']."<br>";
}

/*

	if($row_reg['sabun'] == '') {
        $query = "insert into tb_sys_passwordpolicy (sabun,last_change,err_count, pass_status ) values(?,now(),0,'d') ";
    }
    else {
        $query = "update tb_sys_passwordpolicy set last_change = now(), pass_status='d' where sabun = ?";
    }
    $exec = $wass_db->update($query, array($change_sabun));
    if(! $exec) {
        Util::error_back("수정에 실패했습니다.");
    }
    
    $query = "update wass_mast set passwd = sha2(?, 256) where sabun = ?";
    $exec = $wass_db->update($query, array($new_pass, $change_sabun));
    
    if(! $exec) {
        Util::error_back("수정에 실패했습니다.");
    }


*/
//WorkLogger::work("메인","메인페이지 호출", "test");
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

<table style="width:1900px; margin-top:50px" border="1">
<tr>
	<td class="table_head">종류</td>
	<td class="table_head">01번수조</td>
	<td class="table_head">02번수조</td>
	<td class="table_head">03번수조</td>
	<td class="table_head">04번수조</td>
	<td class="table_head">05번수조</td>
	<td class="table_head">06번수조</td>
	<td class="table_head">07번수조</td>
	<td class="table_head">08번수조</td>
	<td class="table_head">09번수조</td>
	<td class="table_head">10번수조</td>
	<td class="table_head">11번수조</td>
	<td class="table_head">12번수조</td>
	<td class="table_head">13번수조</td>
	<td class="table_head">14번수조</td>
	<td class="table_head">15번수조</td>
	<td class="table_head">16번수조</td>
	<td class="table_head">17번수조</td>
	<td class="table_head">18번수조</td>
	<td class="table_head">19번수조</td>
	<td class="table_head">20번수조</td>
	<td class="table_head">21번수조</td>
	<td class="table_head">22번수조</td>
	<td class="table_head">23번수조</td>
	<td class="table_head">24번수조</td>
	<td class="table_head">25번수조</td>
</tr>
<tr style="height:60px">
	<td>센서1</td>
	<td id="water_1_1">1</td>
	<td id="water_1_2">2</td>
	<td id="water_1_3">3</td>
	<td id="water_1_4">4</td>
	<td id="water_1_5">5</td>
	<td id="water_1_6">6</td>
	<td id="water_1_7">7</td>
	<td id="water_1_8">8</td>
	<td id="water_1_9">9</td>
	<td id="water_1_10">10</td>
	<td id="water_1_11">11</td>
	<td id="water_1_12">12</td>
	<td id="water_1_13">13</td>
	<td id="water_1_14">14</td>
	<td id="water_1_15">15</td>
	<td id="water_1_16">16</td>
	<td id="water_1_17">17</td>
	<td id="water_1_18">18</td>
	<td id="water_1_19">19</td>
	<td id="water_1_20">20</td>
	<td id="water_1_21">21</td>
	<td id="water_1_22">22</td>
	<td id="water_1_23">23</td>
	<td id="water_1_24">24</td>
	<td id="water_1_25">25</td>
</tr>
<tr style="height:60px">
	<td>센서2</td>
	<td id="water_2_1">26</td>
	<td id="water_2_2">27</td>
	<td id="water_2_3">28</td>
	<td id="water_2_4">29</td>
	<td id="water_2_5">30</td>
	<td id="water_2_6">31</td>
	<td id="water_2_7">32</td>
	<td id="water_2_8">33</td>
	<td id="water_2_9">34</td>
	<td id="water_2_10">35</td>
	<td id="water_2_11">36</td>
	<td id="water_2_12">37</td>
	<td id="water_2_13">38</td>
	<td id="water_2_14">39</td>
	<td id="water_2_15">40</td>
	<td id="water_2_16">41</td>
	<td id="water_2_17">42</td>
	<td id="water_2_18">43</td>
	<td id="water_2_19">44</td>
	<td id="water_2_20">45</td>
	<td id="water_2_21">46</td>
	<td id="water_2_22">47</td>
	<td id="water_2_23">48</td>
	<td id="water_2_24">49</td>
	<td id="water_2_25">50</td>
</tr>
<tr style="height:60px">
	<td>센서3</td>
	<td id="water_3_1">51</td>
	<td id="water_3_2">52</td>
	<td id="water_3_3">53</td>
	<td id="water_3_4">54</td>
	<td id="water_3_5">55</td>
	<td id="water_3_6">56</td>
	<td id="water_3_7">57</td>
	<td id="water_3_8">58</td>
	<td id="water_3_9">59</td>
	<td id="water_3_10">60</td>
	<td id="water_3_11">61</td>
	<td id="water_3_12">62</td>
	<td id="water_3_13">63</td>
	<td id="water_3_14">64</td>
	<td id="water_3_15">65</td>
	<td id="water_3_16">66</td>
	<td id="water_3_17">67</td>
	<td id="water_3_18">68</td>
	<td id="water_3_19">69</td>
	<td id="water_3_20">70</td>
	<td id="water_3_21">71</td>
	<td id="water_3_22">72</td>
	<td id="water_3_23">73</td>
	<td id="water_3_24">74</td>
	<td id="water_3_25">75</td>
</tr>
<tr style="height:60px">
	<td>센서4</td>
	<td id="water_4_1">76</td>
	<td id="water_4_2">77</td>
	<td id="water_4_3">78</td>
	<td id="water_4_4">79</td>
	<td id="water_4_5">80</td>
	<td id="water_4_6">81</td>
	<td id="water_4_7">82</td>
	<td id="water_4_8">83</td>
	<td id="water_4_9">84</td>
	<td id="water_4_10">85</td>
	<td id="water_4_11">86</td>
	<td id="water_4_12">87</td>
	<td id="water_4_13">88</td>
	<td id="water_4_14">89</td>
	<td id="water_4_15">90</td>
	<td id="water_4_16">91</td>
	<td id="water_4_17">92</td>
	<td id="water_4_18">93</td>
	<td id="water_4_19">94</td>
	<td id="water_4_20">95</td>
	<td id="water_4_21">96</td>
	<td id="water_4_22">97</td>
	<td id="water_4_23">98</td>
	<td id="water_4_24">99</td>
	<td id="water_4_25">00</td>
</tr>
</table>
<br>
<table style="width:1900px;" border="1">
<tr>
	<td class="table_head">종류</td>
	<td class="table_head">26번수조</td>
	<td class="table_head">27번수조</td>
	<td class="table_head">28번수조</td>
	<td class="table_head">29번수조</td>
	<td class="table_head">30번수조</td>
	<td class="table_head">31번수조</td>
	<td class="table_head">32번수조</td>
	<td class="table_head">33번수조</td>
	<td class="table_head">34번수조</td>
	<td class="table_head">35번수조</td>
	<td class="table_head">36번수조</td>
	<td class="table_head">37번수조</td>
	<td class="table_head">38번수조</td>
	<td class="table_head">39번수조</td>
	<td class="table_head">40번수조</td>
	<td class="table_head">41번수조</td>
	<td class="table_head">42번수조</td>
	<td class="table_head">43번수조</td>
	<td class="table_head">44번수조</td>
	<td class="table_head">45번수조</td>
	<td class="table_head">46번수조</td>
	<td class="table_head">47번수조</td>
	<td class="table_head">&nbsp;</td>
	<td class="table_head">&nbsp;</td>
	<td class="table_head">&nbsp;</td>
</tr>
<tr style="height:60px">
	<td>센서1</td>
	<td id="water_1_26">26</td>
	<td id="water_1_27">27</td>
	<td id="water_1_28">28</td>
	<td id="water_1_29">29</td>
	<td id="water_1_30">30</td>
	<td id="water_1_31">31</td>
	<td id="water_1_32">32</td>
	<td id="water_1_33">33</td>
	<td id="water_1_34">34</td>
	<td id="water_1_35">35</td>
	<td id="water_1_36">36</td>
	<td id="water_1_37">37</td>
	<td id="water_1_38">38</td>
	<td id="water_1_39">39</td>
	<td id="water_1_40">40</td>
	<td id="water_1_41">41</td>
	<td id="water_1_42">42</td>
	<td id="water_1_43">43</td>
	<td id="water_1_44">44</td>
	<td id="water_1_45">45</td>
	<td id="water_1_46">46</td>
	<td id="water_1_47">47</td>
	<td id="water_1_48">48</td>
	<td id="water_1_49">49</td>
	<td id="water_1_50">50</td>
</tr>
<tr style="height:60px">
	<td>센서2</td>
	<td id="water_2_26">51</td>
	<td id="water_2_27">52</td>
	<td id="water_2_28">53</td>
	<td id="water_2_29">54</td>
	<td id="water_2_30">55</td>
	<td id="water_2_31">56</td>
	<td id="water_2_32">57</td>
	<td id="water_2_33">58</td>
	<td id="water_2_34">59</td>
	<td id="water_2_35">60</td>
	<td id="water_2_36">61</td>
	<td id="water_2_37">62</td>
	<td id="water_2_38">63</td>
	<td id="water_2_39">64</td>
	<td id="water_2_40">65</td>
	<td id="water_2_41">66</td>
	<td id="water_2_42">67</td>
	<td id="water_2_43">68</td>
	<td id="water_2_44">69</td>
	<td id="water_2_45">70</td>
	<td id="water_2_46">71</td>
	<td id="water_2_47">72</td>
	<td id="water_2_48">73</td>
	<td id="water_2_49">74</td>
	<td id="water_2_50">75</td>
</tr>
<tr style="height:60px">
	<td>센서3</td>
	<td id="water_3_26">76</td>
	<td id="water_3_27">77</td>
	<td id="water_3_28">78</td>
	<td id="water_3_29">79</td>
	<td id="water_3_30">80</td>
	<td id="water_3_31">81</td>
	<td id="water_3_32">82</td>
	<td id="water_3_33">83</td>
	<td id="water_3_34">84</td>
	<td id="water_3_35">85</td>
	<td id="water_3_36">86</td>
	<td id="water_3_37">87</td>
	<td id="water_3_38">88</td>
	<td id="water_3_39">89</td>
	<td id="water_3_40">90</td>
	<td id="water_3_41">91</td>
	<td id="water_3_42">92</td>
	<td id="water_3_43">93</td>
	<td id="water_3_44">94</td>
	<td id="water_3_45">95</td>
	<td id="water_3_46">96</td>
	<td id="water_3_47">97</td>
	<td id="water_3_48">98</td>
	<td id="water_3_49">99</td>
	<td id="water_3_50">00</td>
</tr>
<tr style="height:60px">
	<td>센서4</td>
	<td id="water_3_26">76</td>
	<td id="water_3_27">77</td>
	<td id="water_3_28">78</td>
	<td id="water_3_29">79</td>
	<td id="water_3_30">80</td>
	<td id="water_3_31">81</td>
	<td id="water_3_32">82</td>
	<td id="water_3_33">83</td>
	<td id="water_3_34">84</td>
	<td id="water_3_35">85</td>
	<td id="water_3_36">86</td>
	<td id="water_3_37">87</td>
	<td id="water_3_38">88</td>
	<td id="water_3_39">89</td>
	<td id="water_3_40">90</td>
	<td id="water_3_41">91</td>
	<td id="water_3_42">92</td>
	<td id="water_3_43">93</td>
	<td id="water_3_44">94</td>
	<td id="water_3_45">95</td>
	<td id="water_3_46">96</td>
	<td id="water_3_47">97</td>
	<td id="water_3_48">98</td>
	<td id="water_3_49">99</td>
	<td id="water_3_50">00</td>
</tr>
</table>

</body>
</html>