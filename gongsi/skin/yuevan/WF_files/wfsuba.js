/**
  *******************************************************************
  ************* ─────────────────── **************
  *************     WFPHP在线订单系统V9.0官方正式版    **************
  ************* ─────────────────── **************
  ************* 官方网站：http://www.wf1805.cn/        **************
  ************* 官方店铺：http://889889.taobao.com/    **************
  ************* 程序开发：WENFEI                       **************
  ************* 客户服务：[淘宝旺旺] yygynui613        **************
  ************* 技术支持：[腾讯QQ] 183712356           **************
  *******************************************************************
  *************   官方正版 *** 版权所有 *** 盗版必究   **************
  ******************************************************************* 
 */

window.onerror = function(){return true;} 
///////////////////////////////////////// price /////////////////////////////////////////
function pricea(){
	var wfproduct = document.wfform.wfproduct.value;
	for(var i=0;i<document.wfform.wfproduct.length;i++){
		if(document.wfform.wfproduct[i].checked==true){
			wfproduct = document.wfform.wfproduct[i].value;
			break;
		}
	}
	var spri=wfproduct.split('|');
	var pri=spri[1];
	if(document.wfform.wfmun.value=="" || document.wfform.wfmun.value==0){	
		var tmun=1;
	}
	else{
		var tmun=document.wfform.wfmun.value;
	}	
	var prit=pri*tmun;
	document.wfform.wfprice.value=prit;
	document.getElementById("showprit").innerHTML=prit;
}

///////////////////////////////////////// pay /////////////////////////////////////////
function changeItem(i){
    var k = 3;
	for(var j = 0;j < k;j++){
	    if(j == i){
		    document.getElementById("paydiv" + j).style.display = "block";
		}
		else{		
		    document.getElementById("paydiv" + j).style.display = "none";
		}
	}
}
function opay(){
	document.getElementById("wfform").target="_parent";
}
function opay2(){
    document.getElementById("wfform").target="_blank";
}

///////////////////////////////////////// ref /////////////////////////////////////////
var wfllref = '';
if (document.referrer.length > 0){
	wfllref = document.referrer;
}
try{
	if (wfllref.length == 0 && opener.location.href.length > 0){
    wfllref = opener.location.href;
	}
}
catch (e){}
document.cookie="WFLLURL=" + wfllref + ";path=/";
document.getElementById("wfddll").value = window.top.document.referrer;
pricea();

// WFPHPORDER