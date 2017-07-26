<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<?php $show[3]=2;
	$show[2]=3;
	$show[4]=4;
 ?>
<script type="text/javascript">Menuon(<?php echo $show[$status];?>);</script>
<div class="tt">查找信息</div>
<form action="?" method="post" onsubmit="">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="action" value="search" />
<input type="hidden" name="submit" value="1" />
<input type="hidden" name="status" value="<?php echo $status; ?>" />
	<table cellpadding="2" cellspacing="1" class="tb">
	<tr>
	<td>&nbsp;
	<select name="type">
	<option value="0">分类</option>
	<?php foreach($info_type as $v) { ?>
		 <option value="<?php echo $v['catid']; ?>"><?php echo $v['name']; ?></option>
	<?php } ?>
	</select>&nbsp;
	<input type="text" size="30" name="keyword" value="<?php echo $keyword; ?>" />&nbsp;
	<?php echo $order_select;?>
	&nbsp;
	<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>&nbsp;
	<input type="submit" value="搜 索" class="btn"/>&nbsp;
	<input type="button" value="重 置" class="btn" onclick="Go('?file=<?php echo $file;?>&status=<?php echo $status;?>');"/>
	</td>
	</tr>
	</table>
</form>
<div class="tt">已启用信息列表</div>
<form action="?" method="post">
	<input type="hidden" name="submit" value="1" />
	<input type="hidden" name="file" value="<?php echo $file; ?>" />
	<table cellpadding="2" cellspacing="1" class="tb">
	<tr>
		<th width="12"><input type="checkbox" name="" onclick="checkall(this.form)" /></th>
		<th>级别</th>
		<th>标题</th>
		<th>来源网站</th>
		<th>类型</th>
		<th>客观评级</th>
		<th>标签</th>
		<th>录入时间</th>
		<th>操作</th>
	</tr>
	<?php foreach($lists as $k=>$v){ ?>
	<tr>
		<td align="center"><input type="checkbox" name="<?php echo 'post[infoid][]'; ?>" value="<?php echo $v['infoid']; ?>" /></td>
		<td align="center"><?php if($v['level']){ ?><img alt="" src="admin/image/level_<?php echo $v['level']; ?>.gif" /><?php } ?></td>
		<td align="center"><?php echo $v['title']; ?>&nbsp;<?php if($v['thumb']){ ?><a href="javascript:_preview('<?php echo $v['thumb']; ?>')"><img src="admin/image/img.gif" width="10" height="10" title="点击查看图片"/></a> <?php } ?></td>
		<td align="center"><?php echo $v['website']; ?></td>
		<td align="center"><?php echo $info_type[$v['type']]['name']; ?></td>
		<td align="center"><?php if($v['level']){ ?><img alt="" src="admin/image/level_<?php echo $v['level']; ?>.gif" /><?php } ?></td>
		<td align="center"><?php echo $v['tags']; ?></td>
		<td align="center"><?php echo date('Y-m-d',$v['addtime']); ?></td>
		<td align="center">
			<a href="?file=<?php echo $file;?>&action=edit&infoid=<?php echo $v['infoid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?file=<?php echo $file;?>&action=delete&infoid=<?php echo $v['infoid'];?>" onclick="return confirm('确定删除该信息?删除后不可找回!');"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
		</td>
	</tr>
	<?php } ?>
	</table>
	<div class="pages"><?php echo $pages; ?></div>
	<div class="btns">
	<?php if($status==2){ ?>
	<script>
	function tiepic(){
		if(Dd('downpic').checked){
			alert('开启图片下载后，如果审核通过的信息有外部图片，会将外部图片下载到本服务器，可能影响审核速度！');
		}
	}
	</script>
	<input type="checkbox" id="downpic" name="downpic" onchange="tiepic()" />下载图片&nbsp;&nbsp; 
	<input type="submit" onclick="this.form.action='?action=check'" value="通过审核" class="btn" />&nbsp;&nbsp;
	<input type="submit" class="btn" value="拒绝" />&nbsp;&nbsp;
	<?php }elseif($status==3){ ?>
	<input type="submit" class="btn" value="撤下" onclick="this.form.action='?action=revoke'" />&nbsp;&nbsp;
	<?php }elseif($status == 4 || $status == 1){ ?>
	<input type="submit" onclick="this.form.action='?action=check'" value="通过审核" class="btn" />&nbsp;&nbsp;
	<?php } ?>
	<input type="submit" onclick="if(confirm('确定彻底删除信息?删除后信息不可找回')){this.form.action='?action=delete'}else{return false;}" class="btn" value="彻底删除" />
	</div>
</form>
<?php if($status=='2'){ ?>
<script>
function check_batch_check(){
	if(isNaN(Dd('echo_num').value())){
		Dmsg('输入必须为数字');	
		return false;
	}
	
	if(isNaN(Dd('time_interval').value())){
		Dmsg('输入必须为数字');
		return false;
	}
	return true;
}
</script>
<div class="tt">批量审核通过</div>
<div style="padding:12px 8px;">
<form action="?" method="post" onsubmit="return check_batch_check()">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="submit" value="1" />
<input type="hidden" name="action" value="batch_check" />
每次审核数目：<input type="text" id="echo_num" name="each_num" value="" />&nbsp;条&nbsp;&nbsp;&nbsp;
审核时间间隔：<input type="text" id="time_interval" name="time_interval" value="" />&nbsp;秒&nbsp;&nbsp;&nbsp;
<input type="checkbox" name="downpic" />下载图片&nbsp;&nbsp;
<input type="submit" value="确定" class="btn" />
<br/>
说明--<br/>
&nbsp;&nbsp;1.该功能会根据填写到每次处理数目和时间间隔将所有待审核信息通过;不填写默认处理数目为100，时间间隔为60秒;最少处理数目为100，最少时间间隔为60秒。<br/>
&nbsp;&nbsp;2.审核过程中，会自动将<span style="color:red;">标题或内容为空到信息放到回收站</span><br/>
&nbsp;&nbsp;3.如果选择下载图片，会将信息上的外部图片下载到服务器，可能影响审核速度
</form>
</div>
<?php } ?>
<?php include tpl('footer'); ?>
