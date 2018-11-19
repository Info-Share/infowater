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

<table style="width:1900px;" border="1">
<tr>
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
	<td>1</td>
	<td>2</td>
	<td>3</td>
	<td>4</td>
	<td>5</td>
	<td>6</td>
	<td>7</td>
	<td>8</td>
	<td>9</td>
	<td>10</td>
	<td>11</td>
	<td>12</td>
	<td>13</td>
	<td>14</td>
	<td>15</td>
	<td>16</td>
	<td>17</td>
	<td>18</td>
	<td>19</td>
	<td>20</td>
	<td>21</td>
	<td>22</td>
	<td>23</td>
	<td>24</td>
	<td>25</td>
</tr>
<tr style="height:60px">
	<td>26</td>
	<td>27</td>
	<td>28</td>
	<td>29</td>
	<td>30</td>
	<td>31</td>
	<td>32</td>
	<td>33</td>
	<td>34</td>
	<td>35</td>
	<td>36</td>
	<td>37</td>
	<td>38</td>
	<td>39</td>
	<td>40</td>
	<td>41</td>
	<td>42</td>
	<td>43</td>
	<td>44</td>
	<td>45</td>
	<td>46</td>
	<td>47</td>
	<td>48</td>
	<td>49</td>
	<td>50</td>
</tr>
<tr style="height:60px">
	<td>51</td>
	<td>52</td>
	<td>53</td>
	<td>54</td>
	<td>55</td>
	<td>56</td>
	<td>57</td>
	<td>58</td>
	<td>59</td>
	<td>60</td>
	<td>61</td>
	<td>62</td>
	<td>63</td>
	<td>64</td>
	<td>65</td>
	<td>66</td>
	<td>67</td>
	<td>68</td>
	<td>69</td>
	<td>70</td>
	<td>71</td>
	<td>72</td>
	<td>73</td>
	<td>74</td>
	<td>75</td>
</tr>
<tr style="height:60px">
	<td>76</td>
	<td>77</td>
	<td>78</td>
	<td>79</td>
	<td>80</td>
	<td>81</td>
	<td>82</td>
	<td>83</td>
	<td>84</td>
	<td>85</td>
	<td>86</td>
	<td>87</td>
	<td>88</td>
	<td>89</td>
	<td>90</td>
	<td>91</td>
	<td>92</td>
	<td>93</td>
	<td>94</td>
	<td>95</td>
	<td>96</td>
	<td>97</td>
	<td>98</td>
	<td>99</td>
	<td>00</td>
</tr>
</table>
<br>
<table style="width:1900px;" border="1">
<tr>
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
	<td>26</td>
	<td>27</td>
	<td>28</td>
	<td>29</td>
	<td>30</td>
	<td>31</td>
	<td>32</td>
	<td>33</td>
	<td>34</td>
	<td>35</td>
	<td>36</td>
	<td>37</td>
	<td>38</td>
	<td>39</td>
	<td>40</td>
	<td>41</td>
	<td>42</td>
	<td>43</td>
	<td>44</td>
	<td>45</td>
	<td>46</td>
	<td>47</td>
	<td>48</td>
	<td>49</td>
	<td>50</td>
</tr>
<tr style="height:60px">
	<td>51</td>
	<td>52</td>
	<td>53</td>
	<td>54</td>
	<td>55</td>
	<td>56</td>
	<td>57</td>
	<td>58</td>
	<td>59</td>
	<td>60</td>
	<td>61</td>
	<td>62</td>
	<td>63</td>
	<td>64</td>
	<td>65</td>
	<td>66</td>
	<td>67</td>
	<td>68</td>
	<td>69</td>
	<td>70</td>
	<td>71</td>
	<td>72</td>
	<td>73</td>
	<td>74</td>
	<td>75</td>
</tr>
<tr style="height:60px">
	<td>76</td>
	<td>77</td>
	<td>78</td>
	<td>79</td>
	<td>80</td>
	<td>81</td>
	<td>82</td>
	<td>83</td>
	<td>84</td>
	<td>85</td>
	<td>86</td>
	<td>87</td>
	<td>88</td>
	<td>89</td>
	<td>90</td>
	<td>91</td>
	<td>92</td>
	<td>93</td>
	<td>94</td>
	<td>95</td>
	<td>96</td>
	<td>97</td>
	<td>98</td>
	<td>99</td>
	<td>00</td>
</tr>
<tr style="height:60px">
	<td>76</td>
	<td>77</td>
	<td>78</td>
	<td>79</td>
	<td>80</td>
	<td>81</td>
	<td>82</td>
	<td>83</td>
	<td>84</td>
	<td>85</td>
	<td>86</td>
	<td>87</td>
	<td>88</td>
	<td>89</td>
	<td>90</td>
	<td>91</td>
	<td>92</td>
	<td>93</td>
	<td>94</td>
	<td>95</td>
	<td>96</td>
	<td>97</td>
	<td>98</td>
	<td>99</td>
	<td>00</td>
</tr>
</table>

</body>
</html>