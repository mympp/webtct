<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">服务需求评语模板</div>
<table cellpadding="2" cellspacing="1" class="tb">
  <tr>
    <th width="80" scope="col">评语所属</th>
    <th width="300" scope="col">标题</th>
    <th scope="col">内容</th>
    <th width="50" scope="col">操作</th>
  </tr>
<?php foreach($comtem_lists as $k=>$v){?>
  <tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
    <td><b><?php switch($v['tem_class']){case '1':echo "服务需求";break;case '2': echo "产品中心评语";break;case '3': echo "技术供应";break;case '4': echo "产品中心评价";}?></b></td>
    <td><?php echo $v['title'];?></td>
    <td><?php echo $v['content'];?></td>
    <td>
		
		<!--<a href="?moduleid=<?php echo $moduleid;?>&file=person_do_cemtem_add"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>-->&nbsp;
		<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&com_id=<?php echo $v['com_id'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
		
	</td>
  </tr>
<?php }?>
  <tr>
	<td>&nbsp;</td>
    <td colspan="3"></td>
  </tr>
  <tr>
    <td colspan="4" align="center" valign="middle"><div class="pages"><?php echo $pages;?></div></td>
  </tr>
</table>
<?php include tpl('footer');?>