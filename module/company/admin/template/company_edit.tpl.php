<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">审核企业设置</div>
<form action="?">
<input type="hidden" name="action" id="action"  />
<input type="hidden" name="submit" value="1" />
<input type="hidden" name="file" value=<?php echo $file; ?> />
<input type="hidden" name="moduleid" value="<?php echo $moduleid; ?>" />
<input type="hidden" name="type" value="<?php echo $type; ?>" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th width="14"> </th>
<th>申请时间</th>
<th>用户名</th>
<th>申请内容</th>
</tr>
<?php while($v = $db->fetch_array($company_edit)){ ?>
<tr align="center">
	<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
	<td><input type="hidden" name="userid[]" value="<?php echo $v['userid']; ?>"</td>
	<td><?php echo date('Y-m-d H:i:s',$v['addtime']); ?></td>
	<td><a href="javascript:_user('<?php echo $v['editor']; ?>');" ><?php echo $v['editor']; ?></a></td>
	<td><a href="javascript:void(0);" onclick="Dwidget('?moduleid=4&file=company_edit&action=data&editid=<?php echo $v['itemid'];?>', '修改申请数据')">[查看内容]</a></td>
</tr>
<?php } ?>
</table>

<div class="btns">
<input type="submit" value=" 审核通过 " class="btn" onclick="if(confirm('确定要通过审核？')){Dd('action').value='check';}else{return false;}"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" value=" 拒绝申请 " class="btn" onclick="if(confirm('确定要拒绝申请？')){Dd('action').value='reject';}else{return false;}"/>&nbsp;&nbsp;&nbsp;&nbsp;
反馈信息：<input type="text" name="feedback" value="" style="width:220px;" />
</div>
<div class="pages"><?php echo $pages;?></div>
</form>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>