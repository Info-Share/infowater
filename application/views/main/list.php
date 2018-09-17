<?php
defined('BASEPATH') OR exit('No direct script access allowed');
define('PID', "V0000");
require_once($_SERVER['DOCUMENT_ROOT'].'/common/lib/class.esapi.php');
$esapi = new OWASP_Esapi();
?>
	<script>
	
	$(document).ready(function(){

	});




	function action(){

		var frm = document.frm;
		
		var field = $("#field").val();
		var keyword = $("#keyword").val();

		url = "/index.php/welcome/list_collect/q/" + field + "-" + keyword + "/page/1";
		frm.action = url;
		frm.submit();
		
	}



	</script>


<div id="container">
	<h1>List</h1>

	<div id="body">
	
		<form name="frm" method="post" onsubmit="return action()">
		
		</form>
		
	</div>

</div>
