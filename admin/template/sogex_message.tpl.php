<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(2);</script>
<div class="tt">来源网站管理</div>
<form action="?" method="post">
<input type="hidden" value="1" name="submit" />
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th width="12"><input type="checkbox" name="" onclick="checkall(this.form)" /></th>
	<th>网站名</th>
	<th>网站域名</th>
	<th>客观评分</th>
	<th>添加时间</th>
	<th>操作</th>
</tr>
<?php foreach($lists as $k=>$v){ ?>
<tr>
	<td align="center"><input type="checkbox" name="<?php echo 'post[mid][]'; ?>" value="<?php echo $v['mid']; ?>" /></td>
	<td align="center"><?php echo $v['name']; ?></td>
	<td align="center"><?php echo $v['url']; ?></td>
	<td align="center"><?php echo $v['star']; ?></td>
	<td align="center"><?php echo date('Y-m-d',$v['addtime']); ?></td>
	<td align="center">
			<a href="?file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['mid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=delete&submit=1&itemid=<?php echo $v['mid'];?>" onclick="return confirm('确定删除该信息?删除后不可找回!');"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
	</td>
</tr>
<?php } ?>
</table>
<div class="pages"><?php echo $pages; ?></div>
<div class="btns">
<input type="submit" onclick="if(confirm('确定彻底删除信息?删除后信息不可找回')){this.form.action='?action=delete'}else{return false;}" class="btn" value="彻底删除" />
</div>
</form>
<?php include tpl('footer'); ?>