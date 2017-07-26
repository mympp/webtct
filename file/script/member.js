/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
function m(i) { try { Dd(i).className = 'tab_on'; } catch(e) {} }
function s(i) { try { Dd(i).className = 'side_b'; } catch(e) {} }
function v(i) { if(Dd(i).className == 'side_a') Dd(i).className = 'side_c'; }
function t(i) { if(Dd(i).className == 'side_c') Dd(i).className = 'side_a'; }
function c(i) {
	if(!$('#menu_0')[0]) return;
	for(var j = 0; j < 4; j++) {
		if(j == i) {
			Dd('menu_'+j).className = 'menu_1';
			Ds('sub_'+j);
		} else {
			Dd('menu_'+j).className = 'menu_2';
			Dh('sub_'+j);
		}
	}
	window.scrollTo(0,0);
}
function oh(o) {
	if(o.className == 'side_h') {
		Dh('side');o.className = 'side_s';
		set_local('m_side', 'Y');
	} else {
		Ds('side');o.className = 'side_h';
		set_local('m_side', 'N');
	}
}
function sh(c) {
	if(Dd('head_kw').value == L['keyword_value'] || Dd('head_kw').value.length < 1) {
		alert(L['keyword_message']);
		Dd('head_kw').focus();
		return false;
	}
	if(c) Dd('head_sh').submit();
}
function msgtip(title,content){
	$.dialog({
    lock: true,
	title:title,
    content: content,
    icon: 'face-smile.png'
});
}
function seteditor(EditorName, ContentStr,zj) { 
	zj=parseInt(zj);
    var oEditor = FCKeditorAPI.GetInstance(EditorName) ; 
	 var yhtml=oEditor.GetXHTML(true);
	 if(zj>1){
	 Dd('content___Frame').height=parseInt(zj+100)+'px';
	 }
	 else{Dd('content___Frame').height='400px';}
    oEditor.SetHTML(ContentStr) ; 
}

function mored(k){
	k=parseInt(k);
	var x;
	if(Dd('mores0').checked==true){x='';}else{x='dsn';}
	for(var i=1;i<=k;i++){
       Dd('mores'+i).className=x;  }
		}


function addmorecat(val,id,cates){
Dd(id).value='';
var s='';var t='';
$("[id^="+val+"]").each(function() {if(this.checked==true){s=s+this.value+',';t=t+this.title+',';};});
Dd(id).value=','+s;
if (cates){Dd(cates).value=','+t;}
}

 function divbox(id,wd,title,href){
				$.dialog({
				id: id,
				fixed: true, 
				drag: true, 
				resize:true, 
				height:350,
				width:wd,
				title:title,
				focus:true,
				max: false, 
				min: false,
				content:'url:'+href+''
				});
				 }
function closebox(id){$.dialog({id: id,close: true});}
function strcount(str1,str2)
{str1 = str1.split(str2);str1=str1.length-1;return str1;}

function cutstr(text,start,end){//两个字符串之间的截取；
	var s = text.indexOf(start)
	if(s>-1){
	var text2 = text.substr(s+start.length);
	var s2 = text2.indexOf(end);
	if(s2>-1){
	result = text2.substr(0,s2);
	}else result = '';
	}else result = '';
	return result;
}