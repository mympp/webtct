<?php $dreload=1;?>
<?php require '../common.inc.php';
if($_COOKIE['memberpath']){?>
var memberpath='<?echo $_COOKIE['memberpath'];?>';
<?}else{?>
var memberpath='member';
<?}?>
setTimeout("userstatus()",3000) 
function userstatus(){
var s=Dd('joinusto');var m=Dd('mstatus');
if(s.innerText==''){
s.innerHTML='<a href='+memberpath+'my.php  id="joinus">立即发布信息<\/a>';
}

<?if($_username==''){?>
m.innerHTML='<li><a href=\/'+memberpath+'\/register.php >注册</a>&nbsp;\/&nbsp;<a href=\/'+memberpath+'\/login.php>登录</a></li>';
<?
}
elseif($_groupid==5||$_groupid==8||$_groupid==1){?>
m.innerHTML="<li><a title=\"会员中心\" href=\"/"+memberpath+"/my.php\">&nbsp; 会员中心<\/a><\/li>";
<?
}
else
{?>
m.innerHTML="<li><a title=\"我的企业网\" href=\"<?echo userurl($_username)?>\">&nbsp; 我的企业网<\/a><\/li>";
<?}?>
}
