<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript">Menuon(0);</script>
<div class="tt">sogex管理</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th>数据管理</th>
	<td>总数据：<a><?php echo $info_num3['c']; ?></a></td>
	<td>待审核：<a><?php echo $info_num2['c']; ?></a></td>
</tr>
<tr>
	<th>规则管理</th>
	<td></td>
</tr>
<tr>
	<th>推广排名</th>
	<td></td>
</tr>
<tr>
	<th>创意推广</th>
	<td></td>
</tr>
<tr>
	<th>来源网站管理</th>
	<td></td>
</tr>
<tr>
	<th>标签管理</th>
	<td></td>
</tr>
<tr>
	<th>搜索记录</th>
	<td></td>
</tr>
</table>
<?php include tpl('footer'); ?>