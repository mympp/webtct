<!--
time:2015-5-7
who:陈韬
where：上传和下载csv文件
what:行219、223、225 ：修改批量导入按钮间隔，为按钮添加样式style="margin-left:15px;margin-top:5px;"
relation:
管理数据库：
-->
<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript" src="/file/script/jquery.js"></script>
<script type="text/javascript" src="/file/script/lhgdialog.js?skin=idialog"></script>
<script type="text/javascript" src="/file/script/jsfunction.js"></script>
<form action="?">
<div class="tt">服务需求搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;
<?php echo $fields_select;?>&nbsp;
<input type="text" size="25" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $level_select;?>&nbsp;
<?php echo $order_select;?>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
<tr>
<td>
&nbsp;
账号：<input type="text" size="15" name="username" value="<?php echo $username;?>"/>&nbsp;
<select name="step">
<?php $steps=fieldsarray(54,'*');
for($i=0;$i<=count($steps);$i++){
	if($step==$i){$sele="selected";}else{$sele="";}
if($steps[$i])echo "	<option value='".$i."' ".$sele.">".$steps[$i]."</option>";
}
?>
</select>
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
<option value="<?php echo $k;?>" <?php echo $k == $marriage ? ' selected' : '';?>><?php echo $v;?></option>
<?php
}
?>
</select>
&nbsp;
<select name="education">
<?php
foreach($EDUCATION as $k=>$v) {
?>
<option value="<?php echo $k;?>" <?php echo $k == $education ? ' selected' : '';?>><?php echo $v;?></option>
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
</td>
</tr>
<tr>
<td>
&nbsp;
<select name="datetype">
<option value="edittime" <?php if($datetype == 'edittime') echo 'selected';?>>更新日期</option>
<option value="addtime" <?php if($datetype == 'addtime') echo 'selected';?>>发布日期</option>
<option value="totime" <?php if($datetype == 'totime') echo 'selected';?>>到期日期</option>
</select>&nbsp;
<?php echo dcalendar('fromdate', $fromdate, '');?> 至 <?php echo dcalendar('todate', $todate, '');?>&nbsp;
<?php echo ajax_area_select('areaid', '工作地点', $areaid);?>&nbsp;
&nbsp;悬赏：
<span><input name="minsalary" type="text" id="minsalary" size="5" value="<?php echo $minsalary;?>"/> 至 <input name="maxsalary" type="text" id="maxsalary" size="5" value="<?php echo $maxsalary;?>"/> <?php echo $DT['money_unit'];?>/月</span>
ID：<input type="text" size="4" name="itemid" value="<?php echo $itemid;?>"/>&nbsp;
报名次数<select name="dengyu" onchange="if(this.value=='')Dd('applys').value='';"><option value="" <?php if($dengyu == '') echo 'selected';?>>默认</option><option value="<" <?php if($dengyu == '<') echo 'selected';?>>小于</option>	<option value=">" <?php if($dengyu == '>') echo 'selected';?>>大于</option>	<option value="=" <?php if($dengyu == '=') echo 'selected';?>>等于</option><option value="<>" <?php if($dengyu == '<>') echo 'selected';?>>不等于</option></select>
<input type="text" size="4" name="apply" value="<?php echo $apply;?>" id="applys"/>&nbsp;
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt"><?php echo $menus[$menuid][0];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th width="14"> </th>
<th>信息标题</th>
<th>类型</th>
<th>是否验证</th>
<th>医院</th>
<th>状态</th>
<th>会员</th>
<th width="130"><?php echo $timetype == 'add' ? '添加' : '更新';?>时间</th>
<th width="120">报名人数</th>
<th>浏览</th>
<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>


<td><?php if($v['level']) {?><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&level=<?php echo $v['level'];?>"><img src="admin/image/level_<?php echo $v['level'];?>.gif" title="<?php echo $v['level'];?>级" alt=""/></a><?php } ?></td>
<td align="left">&nbsp;<a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['title'];?></a><?php if($v['vip']) {?> <img src="<?php echo DT_SKIN;?>image/vip.gif" title="<?php echo VIP;?>:<?php echo $v['vip'];?>"/><?php } ?></td>

<td><a href="<?php echo $MOD['linkurl'].rewrite('search.php?action=job&catid='. $v['catid']);?>" target="_blank"><?php echo $CATEGORY[$v['catid']]['catname'];?></a></td>

<td><?php if($v['validated']) { ?>
已验证
<?php } else { ?>
--
<?php } ?></td>

<td><?php echo $v['department'];?></td>
<td class="px11">

<?php echo $v['step']+1;?>.<a  href="javascript:Dwidget('<?php echo $MOD[linkurl].'apply.php?itemid='.$v['itemid'];?>');"><?php echo $steps[$v['step']];?>▼</a>
<?php if ($v['step']>1){
$r = $db->get_one("SELECT * FROM {$DT_PRE}job_apply WHERE status=3 and jobid=".$v['itemid']);
echo '-<a href="javascript:Dwidget(\'?moduleid=9&file=resume&action=edit&itemid='.$r['resumeid'].'\');">'.$r['apply_username']."</a>";
}
?>
</td>
<td>
<?php if($v['username']) { ?>
<a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a>
<?php } else { ?>
	<a href="javascript:_ip('<?php echo $v['ip'];?>');" title="游客"><?php echo $v['ip'];?></a>
<?php } ?>
</td>
<?php if($timetype == 'add') {?>
<td class="px11" title="更新时间<?php echo timetodate($v['edittime'], 5);?>"><?php echo timetodate($v['addtime'], 5);?></td>
<?php } else { ?>
<td class="px11" title="添加时间<?php echo timetodate($v['addtime'], 5);?>"><?php echo timetodate($v['edittime'], 5);?></td>
<?php } ?>
<td>
<a href="javascript:Dwidget('<?php echo $MOD[linkurl].'apply.php?xd=yes&itemid='.$v['itemid'];?>');"><?php echo $v['apply'];?>人报名</a>
</td>
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

<?php } else if($action == 'expire') { ?>

<span class="f_red f_r">
批量延长过期时间 <input type="text" size="3" name="days" id="days" value="30"/> 
天 <input type="submit" value=" 确 定 " class="btn" onclick="if(Dd('days').value==''){alert('请填写天数');return false;}if(confirm('确定要延长'+Dd('days').value+'天吗？')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=expire&refresh=1&extend=1'}else{return false;}"/>
</span>

<input type="submit" value="刷新过期" class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=expire&refresh=1';"/>&nbsp;
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中服务需求吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'reject') { ?>

<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中服务需求吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'recycle') { ?>

<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中服务需求吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 还 原 " class="btn" onclick="if(confirm('确定要还原选中<?php echo $MOD['name'];?>吗？状态将被设置为已通过')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=restore'}else{return false;}"/>&nbsp;
<input type="submit" value=" 清 空 " class="btn" onclick="if(confirm('确定要清空回收站吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=clear';}else{return false;}"/>&nbsp;

<?php } else { ?>

<input type="submit" value="刷新信息" class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=refresh';" title="刷新时间为最新"/>&nbsp;
<input type="submit" value=" 更新信息 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=update';"/>&nbsp;
<?php if($MOD['show_html']) { ?><input type="submit" value=" 生成网页 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=tohtml';"/>&nbsp; <?php } ?>
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中服务需求吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 移动分类 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<?php echo level_select('level', '设置级别为</option><option value="0">取消', 0, 'onchange="this.form.action=\'?moduleid='.$moduleid.'&file='.$file.'&action=level\';this.form.submit();"');?>&nbsp;

<?php } ?>

</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<?php if($action==''){ ?>
	<!--批量导入服务需求-->
<div>
<form action="?" method="post" >
<div class="tt">批量上传服务需求</div>
<input type="hidden" value="<?php echo $moduleid; ?>" name="moduleid" />
<input type="hidden" value="download" name="action" />
<input type="hidden" value="fuwu" name="file_name" />
<input type="submit" value="下载模板" name="download" class="btn" onclick=""  style="margin-left:15px;margin-top:5px;" />
</form>
<form action="?" method="post" >
<input type="hidden" value="<?php echo $moduleid; ?>" name="moduleid" />
<input type="hidden" value="download" name="action" />
<input type="hidden" value="fuwu-example" name="file_name" />
<input type="submit" value="下载事例" name="download" class="btn" onclick=""  style="margin-left:15px;margin-top:5px;" />
</form>
<form action="<?php echo "?moduleid=$moduleid&file=upload"; ?>" method="post" enctype="multipart/form-data"  style="margin-left:15px;margin-top:5px;">
<input type="hidden" name="upload_type" value="fuwu" />
<input type="file" name="upload_csv"  />&nbsp;&nbsp;&nbsp;<input type="submit" name="send" id="send" value="上传" class="btn"/>
</form>
</div>
<?php } ?>
<br/>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>
