<?php

/*
*
*time: 2014-03-24
*who: tcdahe
*修改：
*	添加 name 为 tokeshi 的form表单，用到 include\post.func.php function ajax_category_select()
*
*关联文件：
*	\module\mall\admin\index.inc.php -> case move_keshis
*
*/

defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?">
<script type="text/javascript" src="/file/script/member.js"></script>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<div class="tt"><?php echo $menus[$menuid][0];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr class="on">
<td>
<input type="radio" name="fromtype" value="catid" <?php echo $itemid ? '' : 'checked';?> id="f_1"/><label for="f_1">从指定分类ID</label>&nbsp;&nbsp;
<input type="radio" name="fromtype" value="itemid" <?php echo $itemid ? 'checked' : '';?> id="f_2"/><label for="f_2">从指定<?php echo $MOD['name'];?>ID</label>
</td>
<td></td>
<td>&nbsp;目标分类</td>
</tr>
<tr>
<td width="220" align="center">
<font color="red">多个ID用,分开 结尾和开头不能有,</font><br/>
<textarea style="height:300px;width:200px;" name="fromids"><?php echo $itemid;?></textarea>
</td>
<td width="60" align="center"><strong>&rarr;</strong></td>
<td><script type="text/javascript" src="/file/script/profile.js"></script><div id="catesch"></div><?php echo category_select('tocatid', '', 0, $moduleid, 'size="2" style="height:300px;width:150px;"');?>
</td>
</tr>
<tr>
<td>
&nbsp;&nbsp;&nbsp;<a href="?file=category&mid=<?php echo $moduleid;?>" target="_blank" class="f_b t">分类ID查询</a></td>
<td> </td>
<td><input type="button" value="搜索分类" onclick="schcate(16);" class="btn" />&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value=" 移 动 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></td>
</tr>
</table>
</div>
</form>
<br/>
<br/>
<form method="post" action="?" name="tokeshi">
<script type="text/javascript" src="/file/script/member.js"></script>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="move_keshi"/>
<div class="tt">批量对产品分科室</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr class="on">
<td>
<input type="radio" name="fromtype" value="catid" checked id="f_1"/><label for="f_1">从指定分类ID</label>&nbsp;&nbsp;
</td>
<td></td>
<td>&nbsp;目标分类</td>
</tr>
<tr>
<td width="220" align="center" title="">
<font color="red">多个ID用,分开 结尾和开头不能有,</font><br/>
<textarea style="height:300px;width:200px;" name="fromids"><?php echo $itemid;?></textarea>
</td>
<td width="60" align="center"><strong>&rarr;</strong></td>
<td>
<input type="radio" name="xingshi" value="addto" checked id="f_1"/><label for="f_1">追加</label>&nbsp;&nbsp;
<input type="radio" name="xingshi" value="replace"  id="f_2"/><label for="f_2">替换</label>
<script type="text/javascript" src="/file/script/profile.js"></script><div id="catesch"></div><?php echo ajax_category_select('tokeshi', '', 0, 12, 'size="2" style="height:300px;width:150px;"');?>
</td>
</tr>
<tr>
<td>
&nbsp;&nbsp;&nbsp;<a href="?file=category&mid=12" target="_blank" class="f_b t">分类ID查询</a></td>
<td> </td>
<td><input type="submit" name="submit" value=" 移 动 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></td>
</tr>
</table>
</div>
<br/>
<br/>
</form>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>