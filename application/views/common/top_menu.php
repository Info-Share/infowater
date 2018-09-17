<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<script>
function LogOut(){

	if(confirm('로그아웃하시겠습니까?')){

		$.ajax({
			type: 'POST',
			url: '/index.php/welcome/logout',
			data: {
				
				csrf_test_name : $("#csrf_test_name").val()
			},
			success: function(html){

				alert('로그아웃되었습니다.');
    			window.close();
				
			},

			error: function(request, status, error){
				//alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}

			
		});
		
	}

	
}
</script>
<!-- header -->
<div id="header">



	<div class="topmenu">
	<?php 
	if(@$this->session->userdata('ssabun')){
	?>
	<p><span class="log_info"><?php echo $this->session->userdata('ssname')?>(<?php echo $this->session->userdata('sosok')?>)님 반갑습니다. </span><a href="#" onclick="LogOut();" class="btn_admin btn3">로그아웃</a>&nbsp;</p>
	<?php }else{?>
	<p><a href="javascript:Login()">로그인</a></p>
	<?php }?>
	</div>			
	
	
	<div id="gnbDiv">
		<h1 id="logo"><a href="/index.php">로고</a></h1>
		<div class="gnbDiv" style="height:80px;">
			<div class="gnbWrap">			
			<div id="gnb">
			<ul>
				<li class="one <?php if(strpos(base_url(uri_string()), 'welcome') !== false){?>on<?php }?>"><a href="/"  class="oneDep ">메인</a></li>
			</ul>
			</div>
			</div>
		</div>
	</div>
</div>	


