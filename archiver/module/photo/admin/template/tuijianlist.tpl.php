<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt"><?php echo $MOD['name'];?>搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $level_select;?>&nbsp;
<?php echo $order_select;?>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
<tr>
<td>
&nbsp;<select name="datetype">
<option value="edittime" <?php if($datetype == 'edittime') echo 'selected';?>>更新日期</option>
<option value="addtime" <?php if($datetype == 'addtime') echo 'selected';?>>发布日期</option>
</select>&nbsp;
<?php echo dcalendar('fromdate', $fromdate, '');?> 至 <?php echo dcalendar('todate', $todate, '');?>&nbsp;
<?php echo $_admin == 1 ? category_select('catid', '不限分类', $catid, $moduleid) : ajax_category_select('catid', '不限分类', $catid, $moduleid);?>&nbsp;
<?php echo $DT['city'] ? ajax_area_select('areaid', '不限地区', $areaid).'&nbsp;' : '';?>
<select name="open">
<option value="0">公开状态</option>
<option value="3"<?php echo $open == 3 ? ' selected' : '';?>>开放</option>
<option value="2"<?php echo $open == 2 ? ' selected' : '';?>>密码验证</option>
<option value="1"<?php echo $open == 1 ? ' selected' : '';?>>问题验证</option>
</select>&nbsp;
ID：<input type="text" size="4" name="itemid" value="<?php echo $itemid;?>"/>&nbsp;
<input type="checkbox" name="guest" value="1"<?php echo $guest ? ' checked' : '';?>/>游客&nbsp;
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt"><?php echo $menus[$menuid][0];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>分类id</th>
<th>分类名称</th>
<th width="14"> </th>
<th>标 题</th>
<th>200床位</th>
<th>400床位</th>
<th width="130"><?php echo $timetype == '' ? '添加' : '更新';?>时间</th>
<th width="100">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><a href="<?php echo $v['caturl'];?>" target="_blank"><?php echo $v['catid'];?></a></td>
<td><a href="<?php echo $v['caturl'];?>" target="_blank"><?php echo $v['catname'];?></a></td>
<td><?php if($v['level']) {?><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&level=<?php echo $v['level'];?>"><img src="admin/image/level_<?php echo $v['level'];?>.gif" title="<?php echo $v['level'];?>级" alt=""/></a><?php } ?></td>

<td align="left">&nbsp;<a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['title'];?></a>
<?php if($v['open']<3) {?><img src="admin/image/lock.gif"/><?php } ?></td>
<td><a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['num2'];?></a></td>
<td><?php echo $v['num4'];?></td>
<?php if($timetype == 'add') {?>
<td class="px11" title="更新时间<?php echo $v['editdate'];?>"><?php echo $v['addtime'];?></td>
<?php } else { ?>
<td class="px11" title="添加时间<?php echo $v['addtime'];?>"><?php echo timetodate($v['addtime'], 6);?></td>
<?php } ?>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edituijian&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=deltuijian&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>

</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<?php if(isset($id) && isset($tm) && $id && $tm > $DT_TIME) { ?>
<script type="text/javascript">Dwidget('?moduleid=<?php echo $moduleid;?>&action=item&itemid=<?php echo $id;?>', '请上传图片');</script>
<?php } ?>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>