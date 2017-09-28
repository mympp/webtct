<?php defined('IN_DESTOON') or exit('Access Denied');?>﻿<?php include template('header', 'member');?>
<script type="text/javascript">c(3);</script>
<div class="menu">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="tab" id="Tab0"><a href="home.php"><span>商铺设置</span></a></td>
<td class="tab_nav">&nbsp;</td>
<td class="tab" id="Tab1"><a href="style.php"><span>模板设置</span></a></td>
<td class="tab_nav">&nbsp;</td>
<td class="tab" id="Tab2"><a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $_username;?>&update=1" target="homepage"><span>更新主页</span></a></td>
</tr>
</table>
</div>
<?php if($_REQUEST['select']=='yes') { ?>
<script type="text/javascript">
Go('<?php echo DT_PATH;?>index.php?homepage=<?php echo $_username;?>&update=1');
</script>
<?php } ?>
<?php if($action == 'buy') { ?>
<form method="post" action="style.php" onsubmit="return check();">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellspacing="1" cellpadding="6" class="tb">
<td class="tl">模板预览：</td>
<td class="tr"><a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $_username;?>&preview=<?php echo $itemid;?>" target="_blank"><img src="<?php echo $thumb;?>" style="border:#EEEEEE 2px solid;padding:5px;margin:0 0 10px 0;" alt="预览"/></a></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 购买时长：</td>
<td class="tr f_gray">
<select name="month" id="month" onchange="CA();">
<?php if(is_array($months)) { foreach($months as $m) { ?><option value="<?php echo $m;?>"><?php echo $m;?>月</option><?php } } ?>
</select>
(注:按30天/月计算)
</td>
</tr>
<tr>
<td class="tl">模板价格：</td>
<td class="tr"><strong class="f_red"><?php echo $fee;?><?php echo $unit;?>/月</strong></td>
</tr>
<tr>
<td class="tl">应付总价：</td>
<td class="tr f_red f_b"><span id="payment"><?php echo $fee;?></span><?php echo $unit;?></td>
</tr>
<?php if($currency == 'money') { ?>
<tr>
<td class="tl"><?php echo $DT['money_name'];?>余额：</td>
<td class="tr"><span class="f_blue f_b"><?php echo $_money;?><?php echo $unit;?></span> <a href="<?php echo $MODULE['2']['linkurl'];?>charge.php?action=pay" target="_blank" class="t">[充值]</a></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 支付密码：</td>
<td class="tr"><?php include template('password', 'chip');?></td>
</tr>
<?php } else { ?>
<tr>
<td class="tl"><?php echo $DT['credit_name'];?>余额：</td>
<td class="tr"><span class="f_blue f_b"><?php echo $_credit;?><?php echo $unit;?></span> <a href="<?php echo $MODULE['2']['linkurl'];?>credit.php?action=buy" target="_blank" class="t">[购买]</a></td>
</tr>
<?php } ?>
<tr>
<td class="tl"> </td>
<td class="tr" height="50"><input type="submit" name="submit" value=" 确 定 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'" /></td>
</tr>
</table>
</form>
<script type="text/javascript">
function CA() {
Dd('payment').innerHTML = <?php echo $fee;?>*Dd('month').value;
}
function check() {
<?php if($currency == 'money') { ?>
if(<?php echo $fee;?>*Dd('month').value > <?php echo $_money;?>) {
alert('帐户余额不足，请先充值');
return false;
}
if(Dd('password').value.length < 6) {
alert('请填写支付密码');
Dd('password').focus();
return false;
}
<?php } else { ?>
if(<?php echo $fee;?>*Dd('month').value > <?php echo $_credit;?>) {
alert('您的<?php echo $DT['credit_name'];?>不足，请先购买');
return false;
}
<?php } ?>
return confirm('确定要购买'+Dd('month').value+'月吗？');
}
</script>
<?php } else { ?>
<form action="style.php">
<input type="hidden" name="all" id="all" value="<?php echo $all;?>"/>
<div class="tt">
&nbsp;<?php echo $fields_select;?>&nbsp;
<input type="text" size="12" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $type_select;?>&nbsp;
价格：<input type="text" size="3" name="minfee" value="<?php echo $minfee;?>"/>~
<input type="text" size="3" name="maxfee" value="<?php echo $maxfee;?>" />&nbsp;
<select name="currency">
<option value="">单位</option>
<option value="money"<?php if($currency == 'money') { ?> selected<?php } ?>
><?php echo $DT['money_name'];?></option>
<option value="credit"<?php if($currency == 'credit') { ?> selected<?php } ?>
><?php echo $DT['credit_name'];?></option>
<option value="free"<?php if($currency == 'free') { ?> selected<?php } ?>
>免费</option>
</select>&nbsp;
<?php echo $order_select;?>&nbsp; 
<input type="submit" value=" 搜 索 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'" />
<input type="button" value=" 重 置 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="window.location='style.php';"/>
<?php if($all) { ?>
<input type="submit" value=" 显示可用 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="Dd('all').value=0;"/>
<?php } else { ?>
<input type="submit" value=" 显示全部 " class="btn" onmouseover="this.className='btny'" onmouseout="this.className='btn'"  onclick="Dd('all').value=1;"/>
<?php } ?>
</div>
</form>
<table cellpadding="10" cellspacing="10" width="100%" bgcolor="#FFFFFF">
<?php $c = $db->get_one("select * FROM {$db->pre}member_group WHERE groupname like '%vip%' ");?>
<?php if($lists) { ?>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<?php if($k%4==0) { ?><tr><?php } ?>
<td width="25%" valign="top">
<table cellpadding="2" cellspacing="2" width="220" align="center"<?php if($c['skin'] == $v['skin']) { ?> bgcolor="#E7ECFF"<?php } ?>
>
<tr>
<td><a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $_username;?>&preview=<?php echo $v['itemid'];?>" target="_blank"><img src="<?php echo $v['thumb'];?>" style="border:#EEEEEE 2px solid;padding:5px;margin:0 0 10px 0;" title="点击预览"/></a></td>
</tr>
<tr align="center">
<td><?php echo $v['title'];?></td>
</tr>
<tr align="center">
<td><?php if($v['skin'] == 'default') { ?>默认<?php } else { ?>人气：<?php echo $v['hits'];?><?php } ?>
</td>
</tr>
<tr align="center">
<td>作者：<?php echo $v['author'];?></td>
</tr>
<tr align="center">
<td>价格：
<?php if($v['fee'] and $_groupid!=$c['groupid'] ) { ?>
<?php if($v['currency'] == 'money') { ?>
<span class="f_red"><?php echo $v['fee'];?><?php echo $DT['money_unit'];?>/月</span>
<?php } else { ?>
<span class="f_blue"><?php echo $v['fee'];?><?php echo $DT['credit_unit'];?>/月</span>
<?php } ?>
<?php } else { ?>
<span class="f_green">免费</span>
<?php } ?>
</td>
</tr>
<tr align="center">
<td>
<?php if($c['skin'] == $v['skin']) { ?>
<a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $_username;?>&update=1" target="_blank" class="t">我的主页</a> <span class="f_red">[<?php if($havedays) { ?><?php echo $havedays;?>天剩余<?php } else { ?>使用中<?php } ?>
]</span>
<?php } else { ?>
<?php if($v['fee'] and $_groupid!=$c['groupid']) { ?><a href="?action=buy&itemid=<?php echo $v['itemid'];?>" class="t"><input type="hidden" name="_groupid" value="<?php echo $_groupid;?>"/>购买</a><span style="red">(vip全免费使用)</span><?php } else { ?>
<a href="?itemid=<?php echo $v['itemid'];?>" class="t"<?php if($havedays) { ?> onclick="return confirm('确定要启用此模板吗？如果之前购买过模板，付费模板的有效期将被清空');"<?php } ?>
 target="_blank">启用</a><?php } ?>
&nbsp;|&nbsp;<a href="<?php echo DT_PATH;?>index.php?homepage=<?php echo $_username;?>&preview=<?php echo $v['itemid'];?>" target="_blank" class="t">预览</a>
<?php } ?>
</td>
</tr>
<tr align="center">
<td><?php echo $v['group'];?></td>
</tr>
</table>
</td>
<?php if($k%4==3) { ?></tr><?php } ?>
<?php } } ?>
<?php } else { ?>
<tr><td class="f_red">提示信息：未找到相关模板</td></tr>
<?php } ?>
</table>
<div class="pages"><?php echo $pages;?></div>
<?php } ?>
<script type="text/javascript">s('style');m('Tab1');</script>
<?php include template('footer', 'member');?>