<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">用户应标管理中心</div>
<form method="post">
<style type="text/css">
	.tl{width:auto}
</style>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th class="tl" >我的应标内容</th>
<th class="tl" width="40">发起人</th>
<th class="tl" width="60">添加时间</th>
<th class="tl" width="40">是否中标</th>
<th class="tl" width="40">采购方式</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center">
<td> <a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=editshowsupply&itemid=<?php echo $v['itemid'];?>','<?php echo $v['title'];?>')"><?php echo $v['title'];?></a>
</td>
<td><a href="javascript:_user('<?php echo $v['touser'];?>')" class="t"><?php echo $v['touser'];?></a>&nbsp;</td>
<td><?php echo timetodate($v['addtime'], 5);?>&nbsp;</td>
<td>
<?php if ($v[itemid]==$v[bselitemid]){
	echo '<span style="color:red;"> 中标</span>';
}else{
	echo '落选';
 } ?>

</td>
<td>
<?php if ($v['puritemid']==0){
	 	echo'未采购';
	}else if ($v['puritemid']==1){
		echo'线上采购';
	}else if($v['puritemid']==2){
		echo'线下采购';
	}
?>
</td>
</tr>
<?php }?>
</table>
</form>
<br/>