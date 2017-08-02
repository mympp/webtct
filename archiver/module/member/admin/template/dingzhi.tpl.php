<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>

<?php if($action=="memberlist"){ ?>
<!--  定制会员管理-------- -->
<form>
<div class="tt">定制会员列表</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th>会员名</th>
<th>权限</th>
<th>是否子帐号</th>
<th>父帐号</th>
<th width="120">添加时间</th>
<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<td align="center"><a href="javascript:_user('<?php echo $v['username'] ?>')"><?php echo $v['username']; ?></a></td>
<td align="center"><?php echo $v['action']; ?></td>
<td align="center"><?php echo $v['ischild']=='1'?'是':'否'; ?></td>
<td align="center"><?php echo $v['parentname'] ?></td>
<td align="center"><?php echo date('Y-m-d',$v['addtime']); ?></td>
<td align="center">
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=editmember&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=deletemember&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
</form>

<form action="?" method="post">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="moduleid" value="<?php echo $moduleid; ?>" />
<input type="hidden" name="action" value="addmember" />
	<div class="tt">添加定制会员</div>
	<table cellpadding="2" cellspacing="1" class="tb">
		<tr>
			<td class="tl">
				会员名
			</td>
			<td>
				<input type="text" name="username" />
			</td>
		</tr>
		<tr>
			<td class="tl">
				权限
			</td>
			<td>
				<?php foreach($functionlists as $k=>$v) { ?>
					 <input type="checkbox" name="power[]" value="<?php echo $v['name']; ?>" /><?php echo $v['title'].'('.$v['name'].')'; ?>&nbsp;&nbsp;
				<?php } ?>
			</td>
		</tr>
	</table>
	<input type="submit" value="提交"/>
</form>	

<!--  ----定制会员管理 -->
<?php }else if($action=='functionlist') {?>
<!--  定制功能管理-----   -->
<form>
<div class="tt">定制功能列表</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th>功能名</th>
<th>权限名</th>
<th>简介</th>
<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<td align="center"><?php echo $v['title']; ?></td>
<td align="center"><?php echo $v['name']; ?></td>
<td align="center"><?php echo $v['introduce'];?></td>
<td align="center">
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=editfunction&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=deletefunction&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
</form>
<form action="?" method="post">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="moduleid" value="<?php echo $moduleid; ?>" />
<input type="hidden" name="action" value="addfunction" />
<div class="tt">添加定制功能</div>
	<table cellpadding="2" cellspacing="1" class="tb" style="width:320px;">
		<tr>
			<td class="tl">功能名</td>
			<td><input type="text" name="title" /> </td>
		</tr>
		<tr>
			<td class="tl">权限名</td>
			<td><input type="text" name="name" /></td>
		</tr>
		<tr>
			<td class="tl">简介</td>
			<td><textarea name="introduce"></textarea></td>
		</tr>
	</table>
	<input type="submit" value="提交" class="btn" />
</form>
<!--   ----定制功能管理 -->
<?php } ?>

