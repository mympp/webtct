<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">用户采购管理中心</div>
<form method="post">
<style type="text/css">
	.tl{width:auto}
</style>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th class="tl" >我的采购内容</th>
<th class="tl" width="20">卖家</th>
<th class="tl" width="20">供应方</th>
<th class="tl" width="20">数量</th>
<th class="tl" width="40">总额</th>
<th class="tl" width="60">下单时间</th>
<th class="tl" width="20">状态</th>
<th class="tl" width="60">更新时间</th>
<th class="tl" width="60">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr align="center">
<td><?php echo $v['title'];?></td>
<td><a href="javascript:_user('<?php echo $v['touser'];?>')" class="t"><?php echo $v['touser'];?></a>&nbsp;</td>
<td><?php echo $v['company'];?>&nbsp;</td>
<td><?php echo $v['amount'];?></td>
<td><?php echo $v['price'];?></td>
<td><?php echo timetodate($v['send_time'], 5);?>&nbsp;</td>
<td>
<?php if ($v['status']==-1){
	 	echo'中标方退回';
	}else if ($v['status']==1){
		echo'发起人采购';
	}else if($v['status']==2){
		echo'中标方已读';
	}else if($v['status']==3){
		echo'中标方已发货';
	}else if($v['status']==4){
		echo'采购完毕';
	}
?>
</td>
<td><?php echo timetodate($v['updatetime'], 5);?>&nbsp;</td>
<td><a href="?moduleid=6&file=index&action=editpurchase&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
</td>
</tr>
<?php }?>
</table>
</form>
<br/>