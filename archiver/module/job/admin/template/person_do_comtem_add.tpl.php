<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">服务需求评语添加</div>
<form action="?" method="post">
	<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>" />
	<input type="hidden" name="file" value="<?php echo $file;?>" />
	<input type="hidden" name="action" value="<?php echo $action;?>" />
<table cellpadding="2" cellspacing="1" class="tb">
	<tr>
	<td class="tl"><span class="f_red">*</span> 模板所属</td>
	<td>
		<select name="post[tem_class]">
			<option value="1">服务需求</option>
			<option value="2">产品中心评语</option>
			<option value="4">产品中心评价</option>
			<option value="3">技术供应</option>
			<option value="5">文章评论</option>
			<option value="6">其他评论</option>
		</select>
	</td>
	</tr>
	<tr>
	<td class="tl"><span class="f_red">*</span> 评语标题</td>
	<td><input name="post[title]" type="text" id="title" size="60" value="<?php echo $title;?>"/></td>
	</tr>
	<tr>
	<td class="tl"><span class="f_red">*</span> 评语内容</td>
	<td><textarea name="post[content]" value="<?php echo $content;?>" cols="59" rows="6"></textarea></td>
	</tr>
	<tr>
	<td class="tl"></td>
	<td><input type="submit" name="submit" value=" 确 定 " />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit_keep" value=" 确定并继续添加 " />&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 "  /></td>
	</tr>
</table>
</form>
<?php include tpl('footer');?>