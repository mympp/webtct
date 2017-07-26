<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">请选择名义会员</div>
<table cellpadding="2" cellspacing="1" class="tb">
  <tr>
    <td colspan="6">
<form action="?">
	<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
	<input type="hidden" name="file" value="<?php echo $file;?>"/>
	<input type="hidden" name="action" value="<?php echo $action;?>"/>
	<?php echo $fields_select;?>&nbsp;
	<input type="text" size="25" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
	<?php echo $group_select; ?>
	<input type="submit" value="搜 索" class="btn"/>
</form>
	</td>
  </tr>
<form method="post">
  <tr>
    <th width="44" scope="col"><input type="checkbox" onclick="checkall(this.form);"/></th>
    <th width="82" scope="col">会员ID</th>
    <th width="110" scope="col">会员名称</th>
    <th width="240" scope="col">公司</th>
    <th width="56" scope="col">性别</th>
    <th width="147" scope="col">会员组</th>
  </tr>
<?php foreach($lists as $k=>$v) { ?>
  <tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
    <td align="center" valign="middle"><input type="checkbox" name="userid[]" value="<?php echo $v['userid'];?>,<?php echo $v['username']?>"/></td>
    <td align="center" valign="middle"><?php echo $v['userid']; ?></td>
    <td align="left" valign="middle"><?php echo $v['username']; ?></td>
    <td align="left" valign="middle"><?php echo $v['company']; ?></td>
    <td align="center" valign="middle"><?php echo gender($v['gender']);?></td>
    <td align="left" valign="middle"><?php echo $GROUP[$v['groupid']]['groupname'];?></td>
  </tr>
<?php }?>
  <tr height="25">
    <td  colspan="2" rowspan="3" align="center" valign="middle">
		<br/><input type="submit" value="确 定" class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=person_do_job&action=selected';"/><br/>
		<font style="color:red;">确定选定会员为名义会员</font>
	</td>
    <td rowspan="3"  align="left" valign="middle">
<?php echo "已选取了".$items."名“名义会员”"; if($items > 0){?>
	</td>
    <td height="25"  align="left" valign="middle">
		<input type="submit" value="直接跳转到 服务需求 升人气" onclick="this.form.action='?moduleid=9&file=person_do_job'" />（服务需求）
	</td>
    <td rowspan="3" align="center" valign="middle">
		<input type="submit" value="清空已选名义会员" onclick="if(confirm('确定要删除已选名义会员吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=person_do_job&action=delete'}else{return false;}"/>
	</td>
    <td rowspan="3" align="left" valign="middle">&nbsp;</td>
  </tr>
  <tr height="25">
    <td  align="left" valign="middle">
		<input type="submit" value="直接跳转到 产品中心 升人气" onclick="this.form.action='?moduleid=9&file=person_do_job&action=person_do_product'" />（产品中心）

	</td>
  </tr>
  <tr height="25">
    <td  align="left" valign="middle">
		<input type="submit" value="直接跳转到 技术供应 升人气" onclick="this.form.action='?moduleid=9&file=person_do_job&action=person_do_resume'" />（技术供应）
<?php }?>
	</td>
  </tr>
</form>
  <tr>
    <td colspan="6" align="center" valign="middle"><div class="pages"><?php echo $pages;?></div></td>
  </tr>
</table>

<?php include tpl('footer');?>