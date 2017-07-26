<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">采购搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
	<table cellpadding="2" cellspacing="1" class="tb">
	<tr>
	<td>&nbsp;
	<?php echo $fields_select;?>&nbsp;
	<input type="text" size="40" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;&nbsp;
	<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
	<input type="submit" value="搜 索" class="btn"/>&nbsp;
	<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&action=<?php echo $action?>');"/>
	</td>
	</tr>
	</table>
</form>
<div class="tt">采购管理中心</div>
<form method="post">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th>用户名称</th>
<th>企业名称</th>
<th>参与采购总数</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr>
<td align="left">&nbsp;<a href="javascript:_user('<?php echo $v['username'];?>')" class="t"><?php echo $v['username'];?></a>
</td>
<td> <?php echo $v['company'];?>&nbsp;</td>
<td> 
<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=showpurchase&username=<?php echo $v['username'];?>','采购总数统计')">有<?php echo $v['point'];?>个进入采购</a>&nbsp;</td>
</tr>
<?php }?>
</table>
<div class="pages"><?php echo $pages;?></div>
</form>
<br/>
