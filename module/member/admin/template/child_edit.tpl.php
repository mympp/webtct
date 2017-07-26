<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');

?>
<div class="tt">字账号组添加</div>
<form method="post" >
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="groupid" value="<?php echo $groupid;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">上级账号</td>
<?php  if ($action=="add") {
?>

<td class="tr">
<input type="text" size="20" name="post[kw]" />

</td>
<?php }else{ ?>
<td class="tr">
<select name="post[parentusername]">
<option value="0"{if $parentusername==0||$parentusername==''}selected{/if}>默认级别</option>
<?php foreach($child as $k=>$v) {?>
<option value="<?php echo $v[itemid]?>" 
{if $parentusername==$v[username]}selected{/if}><?php echo $v['username'];?></option>
<?php }?>
</select>
</td>
<?php } ?>

</tr>
<tr>
<td class="tl">子账号</td>
<td class="tr"><input type="text" size="20" name="post[username]" id="username" value="<?php echo "$r[username]";?>"/> </td>
</tr>
<tr>
<td class="tl">真实姓名</td>
<td class="tr"><input type="text" size="20" name="post[truename]" id="truename" value="<?php echo "$r[truename]";?>"/> </td>
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
<td class="tr"><input type="text" size="20" name="post[mobile]" id="mobile" value="<?php echo "$r[mobile]";?>"/></td>
</tr>
</table>
<div class="tt">会员权限</div>
<table cellpadding="2" cellspacing="1" class="tb">

<tr>
<td class="tl">限制的功能</td>
<td class="tr">
<input type="text" size="70" name="post[systems]" id="systems" value="<?php echo "$r[systems]";?>" style="display:none"/><br>
<input type="checkbox" id="mmessage" value="message" onclick="systemt('mmessage');">站内信&nbsp;&nbsp;
<input type="checkbox" id="medit" value="edit" onclick="systemt('medit');">会员资料
<input type="checkbox" id="mfriend" value="friend" onclick="systemt('mfriend');">商友管理
<input type="checkbox" id="mchild" value="child" onclick="systemt('mchild');">子账号管理
<input type="checkbox" id="mgrade" value="grade" onclick="systemt('mgrade');">会员升级
<input type="checkbox" id="mcredit" value="credit" onclick="systemt('mcredit');">积分管理
<input type="checkbox" id="mcharge" value="charge" onclick="systemt('mcharge');">充值管理
<input type="checkbox" id="mtrade" value="trade" onclick="systemt('mtrade');">订单管理
<input type="checkbox" id="mrecord" value="record" onclick="systemt('mrecord');"><?php echo "$DT[money_name]";?>管理
<input type="checkbox" id="mcash" value="cash" onclick="systemt('mcash');">提现管理
<br>
<font color="#336600" style="font-size:12px;">不打钩默认开放给该账号</font>
<script type="text/javascript">
var cc='<?php echo "$r[systems]";?>';
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
<tr>
<td class="tl">可用菜单</td>
<td class="tr"><input type="text" size="70" name="post[modules]" id="modules" value="<?php echo ''.$r['modules'].'';?>" style="display:none"/>
<script type="text/javascript">var mm='@<?php echo ''.$r['modules'].'';?>';</script>
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
<?php
	$moduleids = explode(',', $moduleids);
	foreach($MODULE as $m) {
?>	

<?php
		if($m['moduleid'] > 4 && is_file(DT_ROOT.'/module/'.$m['module'].'/my.inc.php')) {
			if($m['moduleid'] == 9) {?>
			<li style="float:none;width:100%;height:26px;">
			<div style="float:left;margin-left:10px;width:110px;">
			<input type="checkbox" id="module<?php echo ''.$m['moduleid'].'';?>" name="module<?php echo ''.$m['moduleid'].'';?>" value="<?php echo ''.$m['moduleid'].'';?>" onclick="modulet('module<?php echo ''.$m['moduleid'].'';?>');">
				设备技术服务
			</div>	
			<?php }
			else if($m['moduleid'] == 12){
			}
			else { ?>

				<li style="float:none;width:100%;height:26px;"><div style="float:left;margin-left:10px;width:110px;">
				 <input type="checkbox" id="module<?php echo ''.$m['moduleid'].'';?>" name="module<?php echo ''.$m['moduleid'].'';?>" value="<?php echo ''.$m['moduleid'].'';?>" onclick="modulet('module<?php echo ''.$m['moduleid'].'';?>');">
				<?php echo ''.$m['name'].'';?>
				</div>
			<?php } ?>
		<div style="float:left;margin-left:10px;width:260px;display:none" id="module<?php echo ''.$m['moduleid'].'';?>m"><input type="checkbox" id="m<?php echo ''.$m['moduleid'].'';?>actionsread" name="actionsread" value="read" onclick="actiont('m<?php echo ''.$m['moduleid'].'';?>actionsread',<?php echo ''.$m['moduleid'].'';?>);">应用
			<input type="checkbox" id="m<?php echo ''.$m['moduleid'].'';?>actionsadd" name="actionsadd" value="add" onclick="actiont('m<?php echo ''.$m['moduleid'].'';?>actionsadd',<?php echo ''.$m['moduleid'].'';?>);">添加
			<input type="checkbox" id="m<?php echo ''.$m['moduleid'].'';?>actionsedit" name="actionsedit" value="edit" onclick="actiont('m<?php echo ''.$m['moduleid'].'';?>actionsedit',<?php echo ''.$m['moduleid'].'';?>);">修改
			<input type="checkbox" id="m<?php echo ''.$m['moduleid'].'';?>actionsdel" name="actionsdel" value="delete" onclick="actiont('m<?php echo ''.$m['moduleid'].'';?>actionsdel',<?php echo ''.$m['moduleid'].'';?>);">删除
		</div>
	<script type="text/javascript">
			if(mm.indexOf('<?php echo ''.$m['moduleid'].'';?>:')>0){
				Dd('module<?php echo ''.$m['moduleid'].'';?>').checked=true;Dd('module<?php echo ''.$m['moduleid'].'';?>m').style.display='';
			var maction;
			maction=';'+cutstr('{$modules}','[<?php echo ''.$m['moduleid'].'';?>:',']');
				if(maction!='@'){
					if(maction.indexOf('read,')>0){Dd('m'+<?php echo ''.$m['moduleid'].'';?>+'actionsread').checked=true;}
					if(maction.indexOf('add,')>0){Dd('m'+<?php echo ''.$m['moduleid'].'';?>+'actionsadd').checked=true;}
					if(maction.indexOf('edit,')>0){Dd('m'+<?php echo ''.$m['moduleid'].'';?>+'actionsedit').checked=true;}
					if(maction.indexOf('delete,')>0){Dd('m'+<?php echo ''.$m['moduleid'].'';?>+'actionsdel').checked=true;}
				}
			}
	</script>
	</li>
	<?php }
	}
?>
</ul>
<input type="button" value="清空所有权限，重新设置" onclick="Dd('modules').value='';delinput();" id="btnSubmit">
</td>
</tr>
</table>
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
<script type="text/javascript">
function check() {
{if $action=='add'}
	if(Dd('password').value.length > {$MOD[maxpassword]} || Dd('password').value.length < {$MOD[minpassword]}) {
		alert('密码长度应为{$MOD[minpassword]}-{$MOD[maxpassword]}字符');
		return false;
	}
	if(Dd('password').value != Dd('cpassword').value) {
		alert('两次输入的密码不一致');
		return false;
	}
 {/if}
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
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn">&nbsp;&nbsp;&nbsp;&nbsp;</div>
</form>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>