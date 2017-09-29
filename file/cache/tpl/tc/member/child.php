<?php defined('IN_DESTOON') or exit('Access Denied');?><?php if($action == 'my') { ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo DT_CHARSET;?>"/>
<title><?php if($head_title) { ?><?php echo $head_title;?><?php echo $DT['seo_delimiter'];?><?php } ?>
<?php echo $DT['sitename'];?></title>
<link rel="stylesheet" type="text/css" href="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/style.css" />
<script type="text/javascript" src="<?php echo DT_STATIC;?>lang/<?php echo DT_LANG;?>/lang.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/config.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/jquery.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/common.js"></script>
<script type="text/javascript" src="<?php echo DT_STATIC;?>file/script/admin.js"></script>
</head>
<body style="background:#EBF0F6;">
<?php if($lists) { ?>
<div class="ls">
<table cellpadding="0" cellspacing="0" class="tb">
<tr>
<th width="26"></th>
<th>公司</th>
<th>姓名</th>
<th><?php if($from=='sms') { ?>手机<?php } else { ?>会员<?php } ?>
</th>
<?php if($DT['im_web']) { ?><th>在线</th><?php } ?>
<th><input type="checkbox" id="c_0" onclick="_check();"/></th>
</tr>
<?php if($lists) { ?>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<tr  align="center" title="<?php echo $v['note'];?>">
<td><img src="<?php echo useravatar($v['username'], 'small');?>" width="20"/></td>
<td align="left">&nbsp;<a href="<?php echo userurl($v['username']);?>" target="_blank" class="t"><?php echo $v['company'];?></a></td>
<td><?php echo $v['truename'];?></td>
<td id="v_<?php echo $v['itemid'];?>"><?php if($from=='sms') { ?><?php echo $v['mobile'];?><?php } else { ?><?php echo $v['username'];?><?php } ?>
</td>
<?php if($DT['im_web']) { ?><td><?php echo im_web($v['username']);?></td><?php } ?>
<td><input type="checkbox" id="c_<?php echo $v['itemid'];?>" onclick="_send(<?php echo $v['itemid'];?>);"/></td>
</tr>
<?php } } ?>
<?php } else { ?>
<tr  align="center" >
<td colspan=5>..暂无任何数据..
</td>
</tr>
<?php } ?>
</table>
</div>
<?php if($page) { ?><div class="pages"><?php echo $pages;?></div><?php } ?>
<div style="text-align:center;">
<input type="button" value=" 确 定 " class="btn" onclick="window.parent.cDialog();"/>&nbsp;&nbsp;
<input type="button" value=" 关 闭 " class="btn" onclick="window.parent.cDialog();"/>
</div>
<?php } ?>
</body>
</html>
<?php } else { ?>
<?php include template('header', $module);?>
<div class="menu">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="tab" id="add"><a href="child.php?action=add"><span>添加账号</span></a></td>
<td class="tab_nav">&nbsp;</td>
<td class="tab" id="home"><a href="child.php"><span>我的子账号</span></a></td>
<td class="tab_nav">&nbsp;</td>
</tr>
</table>
</div>
<?php if($action == 'add'||$action == 'edit') { ?>
<form method="post" action="child.php" onsubmit="return check();">
<input type="hidden" name="action" value="<?php echo $action;?>">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<?php if($itemid) { ?><input type="hidden" name="itemid" value="<?php echo $itemid;?>"><?php } ?>
<table cellpadding="5" cellspacing="1" class="tb">
<tr>
<td class="tl">上级账号</td>
<td class="tr">
<input type="text" size="20" name="" id="username" value="<?php echo $_username; ?>" readonly="true" disabled="true"/> 
<!--<select name="post[parentusername]">
<option value="0" <?php if($parentusername==0||$parentusername=='') { ?>selected<?php } ?>
>默认级别</option>
<?php $tags = tag("table=member_child&condition=userid=$_userid&pagesize=20&order=itemid desc&template=null&debug=0&showcat=0")?>
<?php if(is_array($tags)) { foreach($tags as $k => $v) { ?>
<option value="<?php echo $v['username'];?>" <?php if($parentusername==$v['username']) { ?>selected<?php } ?>
><?php echo $v['username'];?></option>
<?php } } ?>
</select>-->
</td>
</tr>
<tr>
<td class="tl">子账号</td>
<td class="tr"><input type="text" size="20" name="post[username]" id="username" value="<?php echo $username;?>"/> </td>
</tr>
<?php if(check_dingzhi_member($_childusername!=''?$_childusername:$_username,'child')) { ?>
<tr>
<td class="tl">管理区域</td>
<td class="tr">
<select name="post[partid]">
<option value="0">全国</option>
<?php $part_tags=tag("table=area_partition&fields=partname,partid&template=null");?>
<?php if(is_array($part_tags)) { foreach($part_tags as $k => $v) { ?>
<option value="<?php echo $v['partid'];?>" <?php if($partid==$v['partid']) { ?>selected="selected"<?php } ?>
><?php echo $v['partname'];?></option>
<?php } } ?>
</select>
</td>
</tr>
<?php } ?>
<tr>
<td class="tl">真实姓名</td>
<td class="tr"><input type="text" size="20" name="post[truename]" id="truename" value="<?php echo $truename;?>"/> </td>
</tr>
<tr>
<td class="tl">子账号密码</td>
<td class="tr"><input type="password" size="20" name="post[password]" id="password" value=""/></td>
</tr>
<tr>
<td class="tl">确定密码</td>
<td class="tr"><input type="password" size="20" name="cpassword" id="cpassword" value=""  /></td>
</tr>
<tr>
<td class="tl">联系手机</td>
<td class="tr"><input type="text" size="20" name="post[mobile]" id="mobile" value="<?php echo $mobile;?>"/></td>
</tr>
<tr>
<td class="tl">限制的功能</td>
<td class="tr">
<input type="text" size="70" name="post[systems]" id="systems" value="<?php echo $systems;?>" style="display:none"/><br>
<input type="checkbox" id="mmessage" value="message" onclick="systemt('mmessage');">站内信&nbsp;&nbsp;
<input type="checkbox" id="medit" value="edit" onclick="systemt('medit');">会员资料
<input type="checkbox" id="mfriend" value="friend" onclick="systemt('mfriend');">商友管理
<input type="checkbox" id="mchild" value="child" onclick="systemt('mchild');">子账号管理
<input type="checkbox" id="mgrade" value="grade" onclick="systemt('mgrade');">会员升级
<input type="checkbox" id="mcredit" value="credit" onclick="systemt('mcredit');">积分管理
<input type="checkbox" id="mcharge" value="charge" onclick="systemt('mcharge');">充值管理
<input type="checkbox" id="mtrade" value="trade" onclick="systemt('mtrade');">订单管理
<input type="checkbox" id="mrecord" value="record" onclick="systemt('mrecord');"><?php echo $DT['money_name'];?>管理
<input type="checkbox" id="mcash" value="cash" onclick="systemt('mcash');">提现管理
<br>
<font color="#336600" style="font-size:12px;">不打钩默认开放给该账号</font>
<script type="text/javascript">
var cc='c:<?php echo $systems;?>';
if(cc.indexOf(';message;')>0){Dd('mmessage').checked=true;}
if(cc.indexOf(';edit;')>0){Dd('medit').checked=true;}
if(cc.indexOf(';grade;')>0){Dd('mgrade').checked=true;}
if(cc.indexOf(';trade;')>0){Dd('mtrade').checked=true;}
if(cc.indexOf(';credit;')>0){Dd('mcredit').checked=true;}
if(cc.indexOf(';record;')>0){Dd('mrecord').checked=true;}
if(cc.indexOf(';friend;')>0){Dd('mfriend').checked=true;}
if(cc.indexOf(';charge;')>0){Dd('mcharge').checked=true;}
if(cc.indexOf(';child;')>0){Dd('mchild').checked=true;}
if(cc.indexOf(';cash;')>0){Dd('mcash').checked=true;}
</script>
</td>
</tr>
<?php if(check_dingzhi_member($_childusername!=''?$_childusername:$_username,'child')) { ?>
<?php include template('dingzhi_child_dingzhi_function','chip');?>
<?php } ?>
<tr>
<td class="tl">开放的模块</td>
<td class="tr"><input type="text" size="70" name="post[modules]" id="modules" value="<?php echo $modules;?>" style="display:none"/>
<script type="text/javascript">var mm='@<?php echo $modules;?>';</script>
<script>
function delinput(){
var div1 = document.getElementById("selects"); 
var inputs = div1.getElementsByTagName("INPUT"); 
for(i=0;i<inputs.length;i++) {  
inputs[i].checked=false;
} 
}
</script>
<ul id="selects">
<?php if(is_array($MENUMODS2)) { foreach($MENUMODS2 as $k => $v) { ?>
<li style="float:none;width:100%;height:26px;"><div style="float:left;margin-left:10px;width:110px;"><input type="checkbox" id="module<?php echo $v;?>" name="module" value="<?php echo $v;?>" onclick="modulet('module<?php echo $v;?>');">
<?php if($v==-9) { ?>技术工程师<?php } else if($v==-28) { ?>求职简历<?php } else { ?><?php echo $MODULE[$v]['name'];?><?php } ?>
</div>
<div style="float:left;margin-left:10px;width:260px;display:none" id="module<?php echo $v;?>m"><input type="checkbox" id="m<?php echo $v;?>actionsread" name="actionsread" value="read" onclick="actiont('m<?php echo $v;?>actionsread',<?php echo $v;?>);">应用
<input type="checkbox" id="m<?php echo $v;?>actionsadd" name="actionsadd" value="add" onclick="actiont('m<?php echo $v;?>actionsadd',<?php echo $v;?>);">添加
<input type="checkbox" id="m<?php echo $v;?>actionsedit" name="actionsedit" value="edit" onclick="actiont('m<?php echo $v;?>actionsedit',<?php echo $v;?>);">修改
<input type="checkbox" id="m<?php echo $v;?>actionsdel" name="actionsdel" value="delete" onclick="actiont('m<?php echo $v;?>actionsdel',<?php echo $v;?>);">删除
</div>
<script type="text/javascript">
if(mm.indexOf('<?php echo $v;?>:')>0){Dd('module<?php echo $v;?>').checked=true;Dd('module<?php echo $v;?>m').style.display='';
var maction;
maction=';'+cutstr('<?php echo $modules;?>','[<?php echo $v;?>:',']');
if(maction!='@'){
if(maction.indexOf('read,')>0){Dd('m'+<?php echo $v;?>+'actionsread').checked=true;}
if(maction.indexOf('add,')>0){Dd('m'+<?php echo $v;?>+'actionsadd').checked=true;}
if(maction.indexOf('edit,')>0){Dd('m'+<?php echo $v;?>+'actionsedit').checked=true;}
if(maction.indexOf('delete,')>0){Dd('m'+<?php echo $v;?>+'actionsdel').checked=true;}
}
}

</script>
</li>
<?php } } ?>
</ul>
<input type="button" value="清空所有权限，重新设置" onclick="Dd('modules').value='';delinput();" id="btnSubmit">
</td>
</tr>
<script type="text/javascript">
function systemt(id){
if(Dd('systems').value.indexOf(';')=='-1'){Dd('systems').value=';'+Dd('systems').value;}
if(Dd(id).checked==true){
Dd('systems').value=Dd('systems').value+Dd(id).value+';';
}
else
{
Dd('systems').value=Dd('systems').value.replace(Dd(id).value+';','');
}
}
function actiont(id,mids){
var ak='';var str=Dd('modules').value;
if(Dd('m'+mids+'actionsread').checked==true){ak=ak+'read,'}
if(Dd('m'+mids+'actionsadd').checked==true){ak=ak+'add,'}
if(Dd('m'+mids+'actionsedit').checked==true){ak=ak+'edit,'}
if(Dd('m'+mids+'actionsdel').checked==true){ak=ak+'delete,'}
str=cutstr(str,'['+mids+':',']');
Dd('modules').value=Dd('modules').value.replace('m:['+mids+':'+str+'];','m:['+mids+':'+ak+'];');
}
function modulet(id){
if(Dd(id).checked==true){
Dd('modules').value=Dd('modules').value+'m:['+Dd(id).value+':];';
Dd(id+'m').style.display='';
}
else
{
Dd('modules').value=Dd('modules').value.replace('m:['+Dd(id).value+':];','');
Dd(id+'m').style.display='none';
}
}
</script>
<tr>
<td class="tl">&nbsp;</td>
<td class="tr" height="50"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></td>
</tr>
</table>
</form>
<script type="text/javascript">s('child');m('add');</script>
<?php } else { ?>
<table cellpadding="5" cellspacing="1" width="100%" bgcolor="#9CB8CC">
<?php if($lists) { ?>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<?php if($k%2==0) { ?><tr><?php } ?>
<td valign="top"  bgcolor="#FFFFFF" onmouseover="this.style.backgroundColor='#F2F6FB';" onmouseout="this.style.backgroundColor='#FFFFFF';" title="<?php echo $v['note'];?>">
<?php if($v) { ?>
<table cellpadding="2" cellspacing="2" width="96%" align="center">
<tr>
<td height="40">
<span class="f_r" title="添加时间 <?php echo $v['adddate'];?>">
<a href="child.php?action=edit&itemid=<?php echo $v['itemid'];?>" class="t">[修改资料]</a>&nbsp;
<a href="child.php?action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return confirm('确定要删除吗？此操作将不可撤销');" class="t">[删除账号]</a>&nbsp;
</span>
<p style="font-size:16px;line-height:18px;font-weight:bold"><?php echo $v['username'];?>:<?php if($v['parentusername']) { ?>上级账号：<?php echo $v['parentusername'];?>-<?php } ?>
<?php echo $v['truename'];?>&nbsp;&nbsp;(手机：<?php echo $v['mobile'];?>)</p>
</td>
</tr>
<tr>
<td height="20">
<b>模块操作：</b>
<?php if(is_array($MENUMODS2)) { foreach($MENUMODS2 as $k => $z) { ?>
<?php if(strpos('m:'.$v['modules'],$z)) { ?><span><?php if($z==-9) { ?>技术工程师<?php } else { ?><?php echo $MODULE[$z]['name'];?><?php } ?>
&nbsp;&nbsp;</span><?php } ?>
<?php } } ?>
<script type="text/javascript">
var kk='a:<?php echo $v['actions'];?>';
if(kk.indexOf('read')>0){Dd('actionsread{k}').style.display='block';}
if(kk.indexOf('add')>0){Dd('actionsadd{k}').style.display='block';}
if(kk.indexOf('edit')>0){Dd('actionsedit{k}').style.display='block';}
if(kk.indexOf('del')>0){Dd('actionsdel{k}').style.display='block';}
</script>
</td>
</tr>
</table>
<?php } else { ?>
&nbsp;
<?php } ?>
</td>
<?php if($k%2==1) { ?></tr><?php } ?>
<?php } } ?>
<?php } else { ?>
<tr><td bgcolor="white" align="center">暂无任何数据</td></tr>
<?php } ?>
</table>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">s('child');m('home');</script>
<?php } ?>
<script type="text/javascript">
function check() {
<?php if($action=='add') { ?>
if(Dd('password').value.length > <?php echo $MOD['maxpassword'];?> || Dd('password').value.length < <?php echo $MOD['minpassword'];?>) {
alert('密码长度应为<?php echo $MOD['minpassword'];?>-<?php echo $MOD['maxpassword'];?>字符');
return false;
}
if(Dd('password').value != Dd('cpassword').value) {
alert('两次输入的密码不一致');
return false;
}
 <?php } ?>
if(Dd('username').value=='') {
alert('账号不能为空');
return false;
}
if(Dd('truename').value=='') {
alert('真实姓名不能为空');
return false;
}
return true;
}
</script>
<?php include template('footer', $module);?>
<?php } ?>
