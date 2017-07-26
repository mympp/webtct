<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">字帐号管理</div>
<form method="post">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="140">用户id</th>
<th width="140">用户名</th>
<th>真实姓名</th>
<th>联系方式</th>
<th width="150">操作</th>
</tr>
<!--{tag("table=member_child&condition=userid=<?php echo $v['userid'];?>")}-->
<!--{php $tags=tag("table=member_child c&prefix=&condition=m.userid=c.userid and c.groupid=17&pagesize=10&template=null");}-->  
<?php foreach($child as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td>&nbsp;<?php echo $v['itemid'];?></td>
<td>&nbsp;<?php echo $v['username'];?></td>
<td><?php echo $v['truename'];?></td>
<td><?php echo $v['mobile'];?></td>
<td>
<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>&userid=<?php echo $v['userid'];?>')"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>

&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>"  onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
&nbsp;&nbsp;&nbsp;&nbsp;
</td>
</tr>
<?php }?>
</table>
</form>
<script type="text/javascript">Menuon(1);</script>
<br/>
<?php include tpl('footer');?>