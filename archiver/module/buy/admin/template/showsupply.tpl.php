<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<form method="post">
<h3 style="text-align:center"><?echo $title;?></h3>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="560">标 题</th>
<th width="110">发起人</th>
<th width="110">接受人</th>
<th width="130"><?php echo $timetype == 'add' ? '添加' : '更新';?>时间</th>
<th width="50">中标</th>
<th width="50">已读</th>
<th width="50">审核</th>
<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center">
<td align="left">&nbsp;<?php echo $v['title'];?>
</td>
<td> <a href="javascript:_user('<?php echo $v['fromuser'];?>')"><?php echo $v['fromuser'];?></a>&nbsp;</td>
<td> <a href="javascript:_user('<?php echo $v['touser'];?>')"><?php echo $v['touser'];?></a>&nbsp;</td>
<td class="px11" title="添加时间<?php echo timetodate($v['addtime'], 5);?>">
<?php echo timetodate($v['addtime'], 5);?>
</td>
<td class="px11">&nbsp;
<?php if($v['itemid']== $item['selitemid']){echo '√';};?>
</td>
<td class="px11">&nbsp;
<?php if($v['isread']== 1){echo '√';};?>
</td>
<td class="px11">&nbsp;
<?php if($v['agree']== 1){echo '√';};?>
</td>
<td>
<a href="?moduleid=6&file=index&action=editshowsupply&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
</td>
</tr>
<?php }?>
</table>

</form>
<br/>