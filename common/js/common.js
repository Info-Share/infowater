/**
 * 
 */

//bpopup 띄우기
function openDiv(id){
	
	$("#"+id).bPopup({
		zIndex: 20
	});
	
}

function closeDiv(id){
	
	$("#"+id).bPopup().close({
		zIndex: 0	
	});
	
}

