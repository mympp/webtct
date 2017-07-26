<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">产地添加</div>
<form method="post" action="?" onsubmit="return Dcheck();">
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_hid">*</span> 产地名称</td>
<td>
	<textarea name="mfrs[mfrsname]"  id="mfrsname" style="width:200px;height:100px;overflow:visible;"></textarea><?php tips('允许批量添加，一行一个，点回车换行');?></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value="确 定" class="btn">&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value="重 置" class="btn"></div>
</form>
<script type="text/javascript">
function Dcheck() {
	if(Dd('mfrsname').value == '') {
		Dtip('请填写产地名称。允许批量添加，一行一个，点回车换行');
		Dd('mfrsname').focus();
		return false;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>