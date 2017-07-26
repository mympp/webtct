<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(<?php if($status=='3'){echo '2';}elseif($status=='2'){echo '3';}else{echo '4';} ?>);</script>
<div class="tt"><?php if($action=='add'){ ?>添加创意<?php }elseif($action=='edit'){ ?>修改创意<?php } ?></div>
<form action="?" method="post" onsubmit="return check()">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="submit" value="1" />
	<table cellpadding="2" cellspacing="1" class="tb">
	<tr>
		<th width="12"><input type="checkbox" name="" onclick="checkall(this.form)" /></th>
		<th>创意名称</th>
		<th>绑定图片</th>
		<th>客观评分</th>
		<th style="width:420px;">创意描述</th>
		<th>用户名</th>
		<th>提交时间</th>
		<th>操作</th>
	</tr>
	<?php foreach($lists as $k=>$v){ ?>
	<tr>
		<td align="center"><input type="checkbox" name="<?php echo 'post[ideaid][]'; ?>" value="<?php echo $v['ideaid']; ?>" /></td>
		<td align="center"><a href="<?php echo $v['url']; ?>" target="_blank"  style="text-decoration: underline;color:blue;"><?php echo $v['name']; ?></a></td>
		<td align="center">
			<?php if($v['thumb']){ ?>
			<span class="jt" onclick="_preview('<?php echo $v[thumb]; ?>')">[查看图片]</span>
			<?php } ?>
		</td>
		<td align="center">
			<?php if($status == 2){ ?>
			<input type="text" name="post[score][<?php echo $v['ideaid']; ?>]" value="<?php echo $v['score']; ?>" />
			<?php }else{ ?> 
				<?php echo $v['score']; ?>
			<?php } ?>
			</td>
		<td align="center"><?php echo $v['description']; ?></td>
		<td align="center">
		<?php $member=$db->get_one("select username from {$db->pre}member where userid = $v[userid]"); ?>
		<a href="javascript:_user('<?php echo $member['username']; ?>')" title="<?php echo $member['username'] ?>"><?php echo $member['username']; ?></a>
		</td>
		<td align="center"><?php echo date('Y-m-d',$v['addtime']); ?></td>
		<td align="center">
			<a href="?file=<?php echo $file;?>&action=edit&username=<?php echo $member['username']; ?>&itemid=<?php echo $v['ideaid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=delete&submit=1&itemid=<?php echo $v['ideaid'];?>" onclick="return confirm('确定删除该信息?删除后不可找回!');"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
		</td>
	</tr>
	<?php } ?>
</table>
<div class="pages"><?php echo $pages; ?></div>
<div class="btns">
<?php if($status==2){ ?>
<input type="submit" onclick="this.form.action='?action=check'" value="通过审核" class="btn" />&nbsp;&nbsp;
	<input type="submit" class="btn" value="拒绝" onclick="this.form.action='?action=revoke'" />&nbsp;&nbsp;
	<?php }elseif($status==3){ ?>
	<input type="submit" class="btn" value="撤下" onclick="this.form.action='?action=revoke'" />&nbsp;&nbsp;
	<?php }elseif($status == 4 || $status == 1){ ?>
	<input type="submit" onclick="this.form.action='?action=check'" value="通过审核" class="btn" />&nbsp;&nbsp;
	<?php } ?>
	<input type="submit" onclick="if(confirm('确定彻底删除信息?删除后信息不可找回')){this.form.action='?action=delete'}else{return false;}" class="btn" value="彻底删除" />
</div>
</form>
<script type="text/javascript">
	function check(){
		var l;
		var f;
		
		f='title';
		if(Dd(f).value==''){
			Dmsg('标题不能为空!',f);
			return false;
		}
		
		f='website';
		if(Dd(f).value==''){
			Dmsg('来源网站不可为空!',f);
			return false;
		}
		
		f="website_url";
		if(Dd(f).value==''){
			Dmsg('来源网站域名不可为空!',f);
			return false;
		}
		
		f='url';
		if(Dd(f).value==''){
			Dmsg('原始地址不能为空!',f);
			return false;
		}
		
		
		f = 'content';
		l = FCKLen();
		if(l < 5) {
			Dmsg('信息内容最少5字，当前已输入'+l+'字', f);
			return false;
		}
		
		return true;
	}
</script>
<?php include tpl('footer'); ?>