<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" >
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<div class="tt"><?php echo $tname;?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 所属分类</td>
<td><?php echo $_admin == 1 ? category_select('catid', '选择分类', $catid, $moduleid) : ajax_category_select('catid', '选择分类', $catid, $moduleid);?> <span id="dcatid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>产品名称</td>
<td><input name="title" type="text" id="title" size="60" value="<?php echo $title;?>"/><span id="dtitle" class="f_red">推荐的产品</span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>数量</td>
<td><input name="num2" type="text" id="title" size="20" value="<?php echo $num2;?>"/><span id="dtitle" class="f_red">200床位时</span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>数量</td>
<td><input name="num4" type="text" id="title" size="20" value="<?php echo $num4;?>"/><span id="dtitle" class="f_red">400床位以上时</span></td>
</tr>

</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php include tpl('footer');?>
