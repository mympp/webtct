<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">站内信件</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">标题</td>
<td class="f_b"><?php echo $title;?></td>
</tr>
<tr>
<td class="tl">发件人</td>
<td><a href="javascript:_user('<?php echo $fromuser;?>');"><?php echo $fromuser;?></a></td>
</tr>
<tr>
<td class="tl">收件人</td>
<td><a href="javascript:_user('<?php echo $touser;?>');"><?php echo $touser;?></a></td>
</tr>
<tr>
<td class="tl">发信时间</td>
<td><?php echo timetodate($addtime, 6);?></td>
</tr>
<tr>
<td class="tl">发信IP</td>
<td><?php echo $ip;?></td>
</tr>
<tr>
<td class="tl">内容</td>
<td class="content"><?php echo $content;?></td>
</tr>
</tbody>
</table>
<style type="text/css">
	.content dt{background:none;padding-left:0px;}
	.content dd{height:auto;padding-left:10px;background:none}
</style>
<div class="sbt">
<input type="button" value=" 删 除 " class="btn" onclick="if(confirm('确定要删除吗？此操作将不可撤销')) {Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $itemid;?>&forward=<?php echo urlencode($forward);?>');}"/>
&nbsp;&nbsp;
<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
&nbsp;&nbsp;
<?php  
if ($fromuser) {
	$sql = "SELECT userid FROM ".$db->pre."member WHERE username ='$touser' ";
	$res = $db->get_one($sql);
	?>
	<input type="button" class="btn" onclick="Go('?moduleid=2&action=login&userid={$res['userid']}&admin_re=true&msg_touser={$touser}&msg_title={$title'}" value=" 回 复 ">
<?php } ?>
</div>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>
