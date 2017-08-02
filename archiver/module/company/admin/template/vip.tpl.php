<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt"><?php echo VIP;?>搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<?php echo $fields_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $group_select;?>&nbsp;
<?php echo $order_select;?>
&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>');"/>
</td>
</tr>
<tr>
<td>&nbsp;
<select name="timetype">
<option value="fromtime" <?php if($timetype == 'fromtime') echo 'selected';?>>开通时间</option>
<option value="totime" <?php if($timetype == 'totime') echo 'selected';?>>到期时间</option>
</select>&nbsp;
<?php echo dcalendar('dfromtime', $dfromtime);?> 至 <?php echo dcalendar('dtotime', $dtotime);?>&nbsp;

<select name="vip">
<option value="0"><?php echo VIP;?>指数</option>
<?php 
for($i = 1; $i < 11; $i++) {
	echo '<option value="'.$i.'"'.($i == $vip ? ' selected' : '').'>'.$i.' 级</option>';
}
?>
</select>&nbsp;
理论值：<input type="text" name="vipt" value="<?php echo $vipt;?>" size="2"/>&nbsp;
修正值：<input type="text" name="vipr" value="<?php echo $vipr;?>" size="2"/>&nbsp;
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt"><?php echo VIP;?>管理</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>UserID</th>
<th>公司名称</th>
<th>会员名</th>
<th>会员组</th>
<th>产品(订单)数</th>
<th><?php echo VIP;?>(理论+修正)</th>
<th>站内信(未读)</th>
<th>最后跟进</th>
<th>服务到期</th>
<th>管理</th>
</tr>
<?php foreach($companys as $k=>$v) {
$sendtime=1279992761;
$username=$v['username'];	
$sql="";
$sql="SELECT count(*) as num FROM {$DT_PRE}mall_order WHERE seller ='$username'";
$p=$db->get_one($sql);
$sql="SELECT count(*) as num FROM {$DT_PRE}message WHERE touser ='$username'";
$m=$db->get_one($sql);
$sql="SELECT count(*) as num FROM {$DT_PRE}message WHERE isread=0 and touser ='$username'";
$mn=$db->get_one($sql);

?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="userid[]" value="<?php echo $v['userid'];?>"/></td>
<td><?php echo $v['userid'];?></td>
<td align="left">&nbsp;<a href="<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['company'];?></a></td>
<td><a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a></td>
<td><?php echo $GROUP[$v['groupid']]['groupname'];?></td>
<td class="px11"><?php echo $v['pnum'];?>(<?php echo $p['num'];?>)</td>
<td><img src="<?php echo DT_SKIN;?>image/vip_<?php echo $v['vip'];?>.gif"/>(<?php echo $v['vipt'];?>+<?php echo $v['vipr'];?>)</td>
<td>
<a href="javascript:Dwidget('?moduleid=2&file=message&touser=<?php echo $v['username'];?>')"><?php echo $m['num'];?></a>(<a href="javascript:Dwidget('?moduleid=2&read=0&file=message&touser=<?php echo $v['username'];?>')"><span<?php if($mn['num'])echo " style='color:red'";?>><?php echo $mn['num'];?></span></a>)
</td>

<td class="px11">
<a href="javascript:Dwidget('?moduleid=2&file=alert&action=send&tpl=alert-2&alertcount=<?php echo $al['num'];?>&username=<?php echo $v['username'];?>','<?php echo $v['company'];?>',800,500)">
<?php 
	if($sendtime&&$sendtime!=1279992761){
			$ldtime=$sendtime+32200;
			if($ldtime<$DT_TIME&&$al['num']){
				   echo "<span style='color:Red'>".timetodate($sendtime, 6)."</span>";
				}
			else{
					echo timetodate($sendtime, 6);
				}
	}else{
	echo "<span style='color:red'>从未</span>";
	}
	?></a>
	</td>
<td class="px11"><?php echo timetodate($v['totime'], 3);?></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&userid=<?php echo $v['userid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=2&action=show&username=<?php echo $v['username'];?>"><img src="admin/image/view.png" width="16" height="16" title="会员[<?php echo $v['username'];?>]详细资料" alt=""/></a>&nbsp;
<a href="?moduleid=2&action=login&userid=<?php echo $v['userid'];?>" target="_blank"><img src="admin/image/set.png" width="16" height="16" title="进入会员商务中心" alt=""/></a>
</td>
</tr>

<?php $keyword='';$al['num']='';
}?>
</table>
<div class="btns">
<input type="submit" value=" 更新指数 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=update';"/>&nbsp;
<input type="submit" value=" 撤销<?php echo VIP;?> " class="btn" onclick="if(confirm('确定要撤销选中公司<?php echo VIP;?>资格吗吗？')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 更新所有 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=html&action=show&update=1';"/>&nbsp;
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<div class="tt">名词解释</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><?php echo VIP;?>指数</td>
<td class="f_gray"><?php echo VIP;?>指数，是对<?php echo VIP;?>会员的综合评分的一组1-10的数字，是理论值和修正值之和。指数越大，会员的级别、实力、可信度等越高，信息排名越靠前</td>
</tr>
<tr>
<td class="tl">理论值</td>
<td class="f_gray">理论值是由系统根据管理员设置的评分标准计算出的<?php echo VIP;?>指数值</td>
</tr>
<tr>
<td class="tl">修正值</td>
<td class="f_gray">为了消除理论值与会员实际综合实力的误差，由管理员进行人工干预的数值，可为正数，也可为负数</td>
</tr>
</table>
<script type="text/javascript">Menuon(1);</script>
<?php
include tpl('footer');?>