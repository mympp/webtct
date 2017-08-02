<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt">合作商网店导出</div>
<form action="?">
<input type="hidden" name="action" value="download" />
<input type="hidden" name="submit" value="1" />
<input type="hidden" name="moduleid" value="<?php echo $moduleid; ?>" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<td width="25"></td>
	<td width="50">时间:</td>
	<td width="300"><?php echo dcalendar('fromtime', $fromtime);?> 至 <?php echo dcalendar('totime', $totime);?><br/>
	(时间不选择，默认为导出最近30天注册的合作商信息)
	</td>
	<td width="25"></td>
	<td><input type="submit" class="btn" value="确定" /></td>
</tr>
</table>
</form>
<form action="?">
<div class="tt"><?php echo $MOD['name'];?>搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<?php echo $fields_select;?>&nbsp;
<input type="text" size="25" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $level_select;?>&nbsp;
<select name="vip">
<option value=""><?php echo VIP;?>级别</option>
<?php 
for($i = 0; $i < 11; $i++) {
	echo '<option value="'.$i.'"'.($i == $vip ? ' selected' : '').'>'.$i.' 级</option>';
}
?>
</select>&nbsp;
<?php echo $valid_select;?>&nbsp;
<?php echo $order_select;?>&nbsp;
<?php echo str_replace('服务结束','产品数',$order_select);?>&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
<tr>
<td>&nbsp;
<?php echo category_select('catid', '所属行业', $catid, $moduleid);?>&nbsp;
<?php echo ajax_area_select('areaid', '所在地区', $areaid);?>&nbsp;
<?php echo $mode_select;?>&nbsp;
<?php echo $type_select;?>&nbsp;
<?php echo $size_select;?>&nbsp;
<input type="checkbox" name="thumb" value="1"<?php if ($thumb==1) echo ' checked';?>/>有LOGO&nbsp;
<input type="checkbox" name="thumb" value="2"<?php if ($thumb==2) echo ' checked';?>/>无LOGO&nbsp;
<input type="checkbox" name="dzh" value="1"<?php if ($dzh==1) echo ' checked';?>/>没主营范围&nbsp;
<input type="checkbox" name="closeshop" value="1"<?php if ($closeshop==1) echo ' checked';?>/>关闭的&nbsp;
<input type="checkbox" name="nocatids" value="1"<?php if ($nocatids==1) echo ' checked';?>/>没行业&nbsp;
<input type="checkbox" name="noResultOrder" value="1" <?php if ($noResultOrder==1) echo 'cheched'; ?>/>人气降序&nbsp;
</td>
</tr>
<tr>
<td>&nbsp;
<select name="timetype">
<option value="totime" <?php if($timetype == 'totime') echo 'selected';?>>服务到期</option>
<option value="fromtime" <?php if($timetype == 'fromtime') echo 'selected';?>>服务开始</option>
<option value="validtime" <?php if($timetype == 'validtime') echo 'selected';?>>认证时间</option>
<option value="styletime" <?php if($timetype == 'styletime') echo 'selected';?>>模板到期</option>
</select>&nbsp;
<?php echo dcalendar('fromtime', $fromtime);?> 至 <?php echo dcalendar('totime', $totime);?>&nbsp;
注册资本：<input type="text" size="5" name="mincapital" value="<?php echo $mincapital;?>"/> ~ <input type="text" size="5" name="maxcapital" value="<?php echo $maxcapital;?>"/> 万&nbsp;
会员名：<input type="text" name="username" value="<?php echo $username;?>" size="10"/>&nbsp;
会员ID：<input type="text" name="uid" value="<?php echo $uid;?>" size="10"/>&nbsp;
</td>
</tr>
</table>
</form>
<!--V5.0版本 开始-->
<form method="post">
<div class="tt"><?php echo $MOD['name'];?>管理</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th width="14"> </th>
<th><?php echo $MOD['name'];?>名称</th>
<th>共享</th>
<th>所在地</th>
<th>会员账号</th>
<th>QQ|邮箱</th>
<th>手机|电话</th>
<th>人气</th>
<th width="100">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center" title="<?php echo $MOD['name'];?>类型:<?php echo $v['type'];?>&#10;<?php echo $MOD['name'];?>规模:<?php echo $v['size'];?>">
<td><input type="checkbox" name="userid[]" value="<?php echo $v['userid'];?>"/></td>
<td><?php if($v['level']) {?><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&level=<?php echo $v['level'];?>"><img src="admin/image/level_<?php echo $v['level'];?>.gif" title="<?php echo $v['level'];?>级" alt=""/></a><?php } ?></td>
<td align="left"><a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['company'];?></a><br><?php if($v['vip']) {?> <img src="<?php echo DT_SKIN;?>image/vip_<?php echo $v['vip'];?>.gif" title="<?php echo VIP;?>:<?php echo $v['vip'];?>" align="absmiddle"/><?php } ?><?php if($v['thumb']) {?> <a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="admin/image/img.gif" width="10" height="10" title="标题图,点击预览" alt=""/></a><?php }else{ ?>
 <a href="http://image.baidu.com/i?tn=baiduimage&ct=201326592&lm=-1&cl=2&nc=1&ie=utf-8&word=<?php echo $v['company'];?>" target="_blank" title="找相关图">图</a>
<?php }?>
<?php if($c['homepage']){?><a href="<?echo $c['homepage'];?>" target="_blank"  title="打开他官网">官</a><?php } ?>
<?php
$company=$v['company'];$userid=$v['userid'];
$r = $db->get_one("SELECT * FROM {$DT_PRE}brand_13 WHERE title='$company'");	
$m = $db->get_one("SELECT * FROM {$DT_PRE}member WHERE userid=$userid");	
if($r['itemid']){echo '<a href="?moduleid=13&itemid='.$r['itemid'].'" target="_blank" title="品牌里有他品牌">®</a> ';}
?>
<a href="http://www.baidu.com/baidu?tn=myie_dg&word=<?php echo $v['company']?>" target="_blank"  title="百度搜他资料">搜</a>
<?php if($v['closeshop']) {?><span title="列表不显示">X</span><?php } ?>
<img src="<?php echo DT_SKIN;?>image/vip_<?php echo $v['vip'];?>.gif"/>
|<?php echo $v['pnum']?>个产品
</td>
<td><a href="?moduleid=13&kw=<?echo $v['company'];?>" onclick="this.innerText='⌕ '" target='_blank'><img src="admin/image/view.png" width="16" height="16" title="查找厂商/品牌信息完善" alt=""/></a></td>
<td><?php echo area_pos($v['areaid'], '/');?></td>
<td><a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a></td>
<td><?php echo $m['qq'];?><br><?php echo $m['email'];?></td>
<td><?php echo $m['mobile'];?><br><?php echo $v['telephone'];?></td>
<td><?php echo $v['hits'];?></td>
<td><a href="?moduleid=2&action=edit&userid=<?php echo $v['userid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改会员[<?php echo $v['username'];?>]资料" alt=""/></a>&nbsp;
<a href="?moduleid=2&action=login&userid=<?php echo $v['userid'];?>" target="_blank"><img src="admin/image/set.png" width="16" height="16" title="进入会员商务中心" alt=""/></a>&nbsp;
<a href="?moduleid=2&action=delete&userid=<?php echo $v['userid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a></td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" value=" 删除公司 " class="btn" onclick="if(confirm('确定要删除选中会员吗？系统将删除选中用户所有信息，此操作将不可撤销')){this.form.action='?moduleid=2&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 禁止访问 " class="btn" onclick="if(confirm('确定要禁止选中会员访问吗？')){this.form.action='?moduleid=2&action=move&groupids=2'}else{return false;}"/>&nbsp;
<input type="submit" value=" 设置<?php echo VIP;?> " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=vip&action=add';"/>&nbsp;
<input type="submit" value=" 移动地区 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<input type="submit" value=" 更新公司 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=update';"/>&nbsp;
<input type="submit" value=" 移动至 " class="btn" onclick="if(Dd('mgroupid').value==0){alert('请选择会员组');Dd('mgroupid').focus();return false;}this.form.action='?moduleid=2&action=move';"/> <?php echo group_select('groupid', '会员组', 0, 'id="mgroupid"');?>&nbsp;
<?php echo level_select('level', '设置级别为</option><option value="0">取消', 0, 'onchange="this.form.action=\'?moduleid='.$moduleid.'&file='.$file.'&action=level\';this.form.submit();"');?>
</div>
</form>
<!--V5.0版本 结束-->

<div class="pages"><?php echo $pages;?></div>
<br/>

<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>