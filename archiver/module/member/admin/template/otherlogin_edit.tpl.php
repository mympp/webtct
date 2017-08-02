<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
load('profile.js');
?>
<style>
	.three{
		width:85px;
	}
</style>
<div class="tt">第三方修改</div>
<form method="post" action="?" onsubmit="return Dcheck();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="clientid" value="<?php echo $members[0]['client_id'];?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl three"><span class="f_red">*</span> 网站名称</td>
<td><input type="text" size="60" name="webname" id="webname" value="<?php echo $members[0]['client_name']?>" onblur="validator('username');"/>&nbsp;<span id="dwebname" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl three"><span class="f_red">*</span> 网址</td>
	<td><input type="text" size="60" name="weburl" value="<?php echo $members[0]['client_url']?>" id="weburl"/>&nbsp;<span id="dweburl" class="f_red"></span></td>
</tr>
<tr>
	<td class="tl three"><span class="f_red">*</span> 回调地址</td>
	<td><input type="text" size="60" name="callback" value="<?php echo $members[0]['redirect_uri']?>" id="callback"/>&nbsp;<span id="dcallback" class="f_red"></span></td>
<td>
</tr>
<tr>
	<td class="tl three"><span class="f_red">*</span> 分配权限</td>
	<td>
		<input type="checkbox"  name="scope[]" value="get_user_info" checked="checked" disabled="disabled"/><label>获取用户昵称、头像</label>
		<input type="checkbox"  name="scope[]" value="validate" <?php if(strpos($members[0]['scope'],'validate') !== false){echo 'checked="checked"';}?>/><label>获取用户的认证状态</label>
	</td>
	<td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<script type="text/javascript">
var vid = '';
function validator(id) {
	if(!Dd(id).value) return false;
	vid = id;
	makeRequest('moduleid=<?php echo $moduleid;?>&action=member&job='+id+'&value='+Dd(id).value, AJPath, '_validator');
}

function _validator() {
	if(xmlHttp.readyState==4 && xmlHttp.status==200) {
		Dd('d'+vid).innerHTML = xmlHttp.responseText ? '<img src="'+SKPath+'image/check_error.gif" align="absmiddle"/> '+xmlHttp.responseText : '';
	}
}

function reg(type) {
	if(type) {
		Ds('company_detail');
	} else {
		Dh('company_detail');
	}
}
function Dcheck() {
	var webname = $("#webname").val();
	if(webname == '') {
		$("#dwebname").html('请填写网站名称');
		return false;
	}else{
		webname = trimStr(webname);
		if(webname == ''){
			$("#dwebname").html('请填写网站名称');
			return false;
		}else{
			$("#dwebname").html('');
		}
	}
	var weburl = $("#weburl").val();
	if(weburl == '') {
		$("#dweburl").html('请填写网站地址');
		return false;
	}else{
		weburl = trimStr(weburl);
		var reg=/^((http|https|ftp):\/\/)?(\w(\:\w)?@)?([0-9a-z_-]+\.)*?([a-z0-9-]+\.[a-z]{2,6}(\.[a-z]{2})?(\:[0-9]{2,6})?)((\/[^?#<>\/\\*":]*)+(\?[^#]*)?(#.*)?)?$/i;
		if(!reg.test(weburl)){
			$("#dweburl").html('请填写正确的网站地址');
			return false;
		}else{
			$("#dweburl").html('');
		}
	}
	var callback = $("#callback").val();
	if(callback == '') {
		$("#dcallback").html('请填写回调地址');
		return false;
	}else{
		callback = trimStr(callback);
		var reg=/^((http|https|ftp):\/\/)?(\w(\:\w)?@)?([0-9a-z_-]+\.)*?([a-z0-9-]+\.[a-z]{2,6}(\.[a-z]{2})?(\:[0-9]{2,6})?)((\/[^?#<>\/\\*":]*)+(\?[^#]*)?(#.*)?)?$/i;
		if(!reg.test(callback)){
			$("#dcallback").html('请填写正确的回调地址');
			return false;
		}else{
			$("#dcallback").html('');
			if(!confirm('修改回调地址会导致该用户不能使用第三方登录，确定修改？')){
				return false;
			}
		}
	}
	return true;
}
function trimStr(str){
	return str.replace(/(^\s*)|(\s*$)/g,"");
}
</script>
<script type="text/javascript">Menuon(3);</script>
<?php include tpl('footer');?>