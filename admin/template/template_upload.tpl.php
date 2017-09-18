<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">上传模板文件</div>
<form method="post" action="?" enctype="multipart/form-data" >
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="type" value="template" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<td width="120px">说明</td>
	<td>模板文件只能上传到 /template/tc/homepage/ 内子目录</td>
</tr>
<tr>
	<td>上传位置</td>
	<td>
		<select id="templateDir" name="uploadDir" onchange="changeTemplateDir()">
			<option value="0">新增</option>
		<?php 
			foreach($templateDir as $k => $v){
				echo "<option value=\"$v\" >$v</option>";
			}
		?>
		</select>
		&nbsp;&nbsp;
		<input type="text" id="newTemplateDir" name="newDir" value="" />
	</td>
</tr>
<tr>
	<td>上传文件 </td>
	<td><input type="file" name="uploadFiles[]" multiple="multiple" /> (支持同时多文件上传,只允许上传htm格式文件)</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="上传" class="btn" name="doSubmit"/></td>
</tr>
</table>
</form>
<div class="tt">上传样式文件</div>
<form method="post" action="?" enctype="multipart/form-data" >
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="action" value="<?php echo $action; ?>" />
<input type="hidden" name="type" value="skin" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<td width="120px">说明</td>
	<td>模板文件只能上传到 /gongsi/skin/ 内子目录</td>
</tr>
<tr>
	<td>上传位置</td>
	<td>
		<select id="skinDir" name="uploadDir" onchange="changeSkinDir()">
			<option value="0">新增</option>
		<?php 
			foreach($skinDir as $k => $v){
				echo "<option value=\"$v\" >$v</option>";
			}
		?>
		</select>
		&nbsp;&nbsp;
		<input type="text" id="newSkinDir" name="newDir" value="" />
	</td>
</tr>
<tr>
	<td>上传文件 </td>
	<td><input type="file" name="uploadFiles[]" multiple="multiple" />  (支持同时多文件上传)</td>
</tr>
<tr>
	<td></td>
	<td><input type="submit" value="上传" class="btn"  name="doSubmit"/>
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
		$('#newTemplateDir').val('');
	}
}

function changeSkinDir(){
	selectedVal = $('#skinDir option:selected').val();
	if(selectedVal == 0){
		$('#newSkinDir').css('display','inherit');
	}else{
		$('#newSkinDir').css('display','none');
		$('#newSkinDir').val('');
	}
}
Menuon(5);
</script>
<?php include tpl('footer');?>