<!--

time:2015-5-7
who:陈韬
where：上传和下载csv文件
what:行194、198、200：修改批量导入按钮间隔，为按钮添加样式style="margin-left:15px;margin-top:5px;" 
管理数据库：

-->
<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">工程师搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="25" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $level_select;?>&nbsp;<input type="checkbox" name="level0" value=1 <?php echo $level0== 1 ? ' selected' : '';?> >0级别
<?php echo $order_select;?>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="window.location='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>';"/>
</td>
</tr>
<tr>
<td>
&nbsp;账号：<input type="text" size="15" name="username" value="<?php echo $username;?>"/>&nbsp;
<?php echo ajax_category_select('catid', '服务分类', $catid, $moduleid);?>&nbsp;
<select name="gender">
<?php
foreach($GENDER as $k=>$v) {
?>
<option value="<?php echo $k;?>" <?php echo $k == $gender ? ' selected' : '';?>><?php echo $v;?></option>
<?php
}
?>
</select>
&nbsp;
<select name="type">
<?php
foreach($TYPE as $k=>$v) {
?>
<option value="<?php echo $k;?>" <?php echo $k == $type ? ' selected' : '';?>><?php echo $v;?></option>
<?php
}
?>
</select>
&nbsp;
<select name="marriage">
<?php
foreach($MARRIAGE as $k=>$v) {
?>
<option value="<?php echo $k;?>" <?php echo $k == $marriage ? ' selected' : '';?>>
<?if($k!=0){
echo $v;}else{echo '形式';}?>
</option>
<?php
}
?>
</select>
&nbsp;
<select name="experience">
<option value="0">工作经验</option>
<?php for($i = 1; $i < 21; $i++) { ?>
<option value="<?php echo $i;?>" <?php echo $i == $experience ? ' selected' : '';?>><?php echo $i;?>年以上</option>
<?php
}
?>
</select>
&nbsp;
<select name="open">
<option value="0">公开状态</option>
<option value="1"<?php echo $open == 1 ? ' selected' : '';?>>关闭</option>
<option value="2"<?php echo $open == 2 ? ' selected' : '';?>>仅网站可见</option>
<option value="3"<?php echo $open == 3 ? ' selected' : '';?>>开放</option>
</select>
选定次数<select name="dengyu" onchange="if(this.value=='')Dd('talents').value='';"><option value="" <?php if($dengyu == '') echo 'selected';?>>默认</option><option value="<" <?php if($dengyu == '<') echo 'selected';?>>小于</option>	<option value=">" <?php if($dengyu == '>') echo 'selected';?>>大于</option>	<option value="=" <?php if($dengyu == '=') echo 'selected';?>>等于</option><option value="<>" <?php if($dengyu == '<>') echo 'selected';?>>不等于</option></select><input type="text" size="4" name="talent" value="<?php echo $talent;?>" id="talents"/>&nbsp;
&nbsp;
</td>
</tr>
<tr>
<td>
&nbsp;
<select name="datetype">
<option value="edittime" <?php if($datetype == 'edittime') echo 'selected';?>>更新日期</option>
<option value="addtime" <?php if($datetype == 'addtime') echo 'selected';?>>发布日期</option>
</select>&nbsp;
<?php echo dcalendar('fromdate', $fromdate, '');?> 至 <?php echo dcalendar('todate', $todate, '');?>&nbsp;
<?php echo ajax_area_select('areaid', '居住地点', $areaid);?>&nbsp;
&nbsp;
最低要求：
<span title="最低要求"><input name="minsalary" type="text" id="minsalary" size="5" value="<?php echo $minsalary;?>"/> 至 <input name="maxsalary" type="text" id="maxsalary" size="5" value="<?php echo $maxsalary;?>"/> <?php echo $DT['money_unit'];?>/月</span>
ID：<input type="text" size="4" name="itemid" value="<?php echo $itemid;?>"/>&nbsp;
<input type="checkbox" name="thumb" value="1"<?php echo $thumb ? ' checked' : '';?>/>LOGO&nbsp;
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt">工程师信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>

<th width="14"> </th>
<th>LOGO</th>
<th>账号</th>
<th width="220">服务标题</th>
<th>分类</th>
<th>电话</th>
<th>手机</th>
<th>居住地</th>
<th width="120"><?php echo $timetype == 'add' ? '添加' : '更新';?>时间</th>
<th>浏览</th>
<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>

<td><?php if($v['level']) {?><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&level=<?php echo $v['level'];?>"><img src="admin/image/level_<?php echo $v['level'];?>.gif" title="<?php echo $v['level'];?>级" alt=""/></a><?php } ?></td>
<td><a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="<?php echo $v['thumb'] ? $v['thumb'] : DT_SKIN.'image/nopic60.gif';?>" width="60" style="padding:5px;"/></a><br><a href="<?php echo $MOD[linkurl].'select.php?resumeid='.$v['itemid']?>"><?php echo $v['truename'];?>(<?php echo $v['gender'] == 1 ? '男' : '女';?>)</a></td>
<td align="left"><?php if($v['username']) { ?>
<a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?>@<?echo $v['talent'];?></a>
<?php } else { ?>
	<a href="javascript:_ip('<?php echo $v['ip'];?>');" title="游客"><?php echo $v['ip'];?></a>
<?php } ?></td>
<td align='left'><a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['title'];?></a></td>
<td><a href="<?php echo $MOD['linkurl'].rewrite('search.php?action=resume&catid='. $v['parentid']);?>" target="_blank"><?php echo $CATEGORY[$v['parentid']]['catname'];?></a></td>
<td title="<?php echo $v['telephone'];?>"><?php echo $v['telephone'];?></td>
<td><?php echo $v['mobile'];?></td>
<td><?php echo $AREA[$v['areaid']]['areaname'];?></td>

<td class="px11" title="添加时间<?php echo timetodate($v['addtime'], 5);?>"><?php echo timetodate($v['edittime'], 5);?></td>
<td class="px11"><?php echo $v['hits'];?></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
<?php include tpl('notice_chip');?>
<div class="btns">

<?php if($action == 'check') { ?>

<input type="submit" value=" 通过审核 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=check';"/>&nbsp;
<input type="submit" value=" 拒 绝 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reject';"/>&nbsp;
<input type="submit" value=" 移动分类 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中服务需求吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'reject') { ?>


<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中服务需求吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'recycle') { ?>

<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中服务需求吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 还 原 " class="btn" onclick="if(confirm('确定要还原选中<?php echo $MOD['name'];?>吗？状态将被设置为已通过')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=restore'}else{return false;}"/>&nbsp;
<input type="submit" value=" 清 空 " class="btn" onclick="if(confirm('确定要清空回收站吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=clear';}else{return false;}"/>

<?php } else { ?>

<input type="submit" value="刷新信息" class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=refresh';" title="刷新时间为最新"/>&nbsp;
<input type="submit" value=" 更新信息 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=update&resume=1';"/>&nbsp;
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中简历吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 移动分类 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<input type="submit" value=" 更新所有 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=html&action=update_resume';" title="更新该模块所有信息地址等项目"/>&nbsp;
<?php echo level_select('level', '设置级别为</option><option value="0">取消', 0, 'onchange="this.form.action=\'?moduleid='.$moduleid.'&file='.$file.'&action=level\';this.form.submit();"');?>

<?php } ?>

</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<!--批量导入技术供应-->
<?php if($action==''){ ?>
<div>
<form action="?" method="post"   >
<div class="tt">批量上传技术供应</div>
<input type="hidden" value="<?php echo $moduleid; ?>" name="moduleid" />
<input type="hidden" value="download" name="action" />
<input type="hidden" value="jishu" name="file_name" />
<input type="submit" value="下载模板" name="download" id="download" class="btn" onclick="" style="margin-left:15px;margin-top:5px;" />
</form>
<form action="?" method="post">
<input type="hidden" value="<?php echo $moduleid; ?>" name="moduleid" />
<input type="hidden" value="download" name="action" />
<input type="hidden" value="jishu-example" name="file_name" />
<input type="submit" value="下载实例" name="download" id="download" class="btn" onclick=""   style="margin-left:15px;margin-top:5px;"  />
</form>
<form action="<?php echo "?moduleid=$moduleid&file=upload"; ?>" method="post" enctype="multipart/form-data"  style="margin-left:15px;margin-top:5px;">
<input type="hidden" name="upload_type" value="jishu" />
<input type="file" name="upload_csv"  />&nbsp;&nbsp;&nbsp;<input type="submit" name="send" id="send" value="上传" class="btn"/>
</form>
</div>
<?php } ?>
<br/>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>

