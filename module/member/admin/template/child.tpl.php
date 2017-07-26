<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">会员搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
	<table cellpadding="2" cellspacing="1" class="tb">
	<tr>
	<td>&nbsp;
	<?php echo $fields_select;?>&nbsp;
	<input type="text" size="40" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;&nbsp;
	<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
	<input type="submit" value="搜 索" class="btn"/>&nbsp;
	<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>');"/>
	</td>
	</tr>
	</table>
</form>
<div class="tt">字帐号管理</div>
<form method="post">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="140">用户id</th>
<th width="140">用户名</th>
<th width="140">下级用户</th>
<th>公司&&姓名</th>
<th width="150">操作</th>
</tr>
<!--{tag("table=member_child&condition=userid=<?php echo $v['userid'];?>")}-->
<!--{php $tags=tag("table=member_child c&prefix=&condition=m.userid=c.userid and c.groupid=17&pagesize=10&template=null");}--> 

<?php foreach($child as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td>&nbsp;<?php echo $v['userid'];?></td>
<td>&nbsp;<?php echo $v['username'];?></td>
<td>&nbsp;
<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=list&userid=<?php echo $v['userid'];?>')"><?php echo $v['point'];?>
</a>
</td>
<td><?php echo $v['company'];?></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&action=edit&userid=<?php echo $v['userid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&userid=<?php echo $v['userid'];?>&itemid=<?php echo $v['itemid'];?>"  onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<?php }?>
</table>
<div class="pages"><?php echo $pages;?></div>
</form>
<script type="text/javascript">Menuon(1);</script>
<br/>
<?php include tpl('footer');?>