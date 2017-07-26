$(document).ready(function(){
	if($("input[name='keyword']").val().length > 0){
		$(".ipt_del").show();
	}
	//显示清除input按钮
	$("input[name='keyword']").keydown(function(){
		if($("input[name='keyword']").val().length > 0){
			$(".ipt_del").show();
		}else{
			$(".ipt_del").hide();
		}
	});
	//清楚文本框该内容
	$(".ipt_del").click(function(){
		$("input[name='keyword']").val("").focus();
	});

	$("input[name='keyword']").focusout(function() {
		/* Act on the event */
		if($("input[name='keyword']").val().length > 0){
			$(".ipt_del").show();
		}else{
			$(".ipt_del").hide();
		}
	});
	//鼠标移入
	$(".ipt_del").mouseover(function(){
		$(this).css('background-position','-22px 0px');
	});
	//移除鼠标
	$(".ipt_del").mouseout(function(){
		$(this).css('background-position','0px 0px');
	});
});

//自动切换tab
function setTab(name,cursel,n){
	for(i=0;i<=n;i++){
		var menu=document.getElementById(name+i);
		var con=document.getElementById("con_"+name+"_"+i);
		menu.className=i==cursel?"hover":"";
		con.style.display=i==cursel?"block":"none";
	}
}
