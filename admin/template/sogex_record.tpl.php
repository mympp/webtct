<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(1);</script>
<div class="tt">查看搜索记录</div>
<form action="?">
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
搜索类型：<?php echo select_info_type('type','',$type); ?>&nbsp;&nbsp;
搜索时间：<?php echo dcalendar('fromdate', $fromdate, '');?> 至 <?php echo dcalendar('todate', $todate, '');?>&nbsp;&nbsp;
用户名：<input type="text" name="username" value="<?php echo $username; ?>" />&nbsp;&nbsp;
搜索结果数目：<input type="text" name="fromtotal" value="<?php echo $fromtotal; ?>" />至<input type="text" name="tototal" value="<?php echo $tototal; ?>" />&nbsp;&nbsp;
<select name="order">
	<option value="addtime desc">按搜索时间倒序</option>
	<option value="addtime asc">按搜索时间升序</option>
	<option value="total desc">按搜索结果数目降序</option>
	<option value="total asc">按搜索结果数目升序</option>
</select>&nbsp;&nbsp;
<input type="reset" value="重置" class="btn" />&nbsp;<input type="submit" value="搜索" class="btn" />
</td>
</tr>
</table>
</form>
<form action="?">
<input type="hidden" value="1" name="submit" />
<input type="hidden" value="<?php echo $file; ?>" name="file" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th width="12"><input type="checkbox" name="" onclick="checkall(this.form)" /></th>
	<th>搜索词</th>
	<th>结果数目</th>
	<th>搜索用户</th>
	<th>用户ip</th>
	<th>搜索类型</th>
	<th>搜索时间</th>
</tr>
<?php foreach($lists as $k => $v){ ?>
<tr align="center">
	<td><input type="checkbox" name="<?php echo 'post[itemid][]'; ?>" value="<?php echo $v['itemid']; ?>" /></td>
	<td><?php echo $v['word']; ?></td>
	<td><?php echo $v['total']; ?></td>
	<td><?php echo $v['username']; ?></td>
	<td><?php echo $v['ip']; ?></td>
	<td><?php if($v['type']){ echo $info_type[$v['type']]['name'];}else{ echo '全网';} ?></td>
	<td><?php echo date('Y-m-d H:i:s',$v['addtime']); ?></td>
</tr>
<?php } ?>
</table>
<div class="pages"><?php echo $pages; ?></div>
<div class="btns">
<input type="submit" onclick="if(confirm('确定彻底删除信息?删除后信息不可找回')){this.form.action='?action=delete'}else{return false;}" class="btn" value="彻底删除" />
</div>
</form>
<?php include tpl('footer'); ?>