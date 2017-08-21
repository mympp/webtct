<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">上传模板文件</div>
<form metdod="post" action="?">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<td width="120px">说明</td>
	<td>模板文件只能上传到 /template/tc/homepage/ 内子目录</td>
</tr>
<tr>
	<td>上传位置</td>
	<td>
		<select id="templateDir" name="templateDir" onchange="changeTemplateDir()">
			<option value="0">新增</option>
		<?php 
			foreach($templateDir as $k => $v){
				echo "<option value=\"$v\" >$v</option>";
			}
		?>
		</select>
		&nbsp;&nbsp;
		<input type="text" id="newTemplateDir" name="newTemplateDir" vlaue="" />
	</td>
</tr>
<tr>
	<td>上传文件 </td>
	<td><input type="file" name="htm" multiple="multiple" /> (支持同时多文件上传,只允许上传htm格式文件)</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="上传" class="btn"/></td>
</tr>
</table>
</form>
<div class="tt">上传样式文件</div>
<form metdod="post" action="?">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<td width="120px">说明</td>
	<td>模板文件只能上传到 /gongsi/skin/ 内子目录</td>
</tr>
<tr>
	<td>上传位置</td>
	<td>
		<select id="skinDir" name="skinDir" onchange="changeSkinDir()">
			<option value="0">新增</option>
		<?php 
			foreach($skinDir as $k => $v){
				echo "<option value=\"$v\" >$v</option>";
			}
		?>
		</select>
		&nbsp;&nbsp;
		<input type="text" id="newSkinDir" name="newSkinDir" vlaue="" />
	</td>
</tr>
<tr>
	<td>上传文件 </td>
	<td><input type="file" name="htm" multiple="multiple" />  (支持同时多文件上传,只允许上传css格式文件)</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="上传" class="btn"/>
	</td>
</tr>
</table>
</form>
<script type="text/javascript">
function changeTemplateDir(){
	selectedVal = $('#templateDir option:selected').val();
	if(selectedVal == 0){
		$('#newTemplateDir').css('display','inherit');
	}else{
		$('#newTemplateDir').css('display','none');
	}
}

function changeSkinDir(){
	selectedVal = $('#skinDir option:selected').val();
	if(selectedVal == 0){
		$('#newSkinDir').css('display','inherit');
	}else{
		$('#newSkinDir').css('display','none');
	}
}
Menuon(5);
</script>
<?php include tpl('footer');?>