<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header', $module);?>
<?php if($action == 'login') { ?>
<div class="bd">
<table cellpadding="1" cellspacing="0" class="tb">
<tr>
<th width="200">时间</th>
<th>IP</th>
<th>地区</th>
<th>结果</th>
</tr>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<tr  align="center">
<td height="30"><?php echo $v['logintime'];?></td>
<td><?php echo $v['loginip'];?></td>
<td><?php echo $v['area'];?></td>
<td><?php echo $v['message'];?></td>
</tr>
<?php } } ?>
</table>
<?php } else { ?>
<script type="text/javascript">c(2);</script>
<div class="menu">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="tab" id="action"><a href="record.php"><span><?php echo $DT['money_name'];?>流水</span></a></td>
<td class="tab_nav">&nbsp;</td>
<td class="tab" id="action_pay"><a href="record.php?action=pay"><span>信息付费</span></a></td>
</tr>
</table>
</div>
<?php if($action == 'pay') { ?>
<form action="?">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<div class="tt">
<?php echo $module_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<select name="currency">
<option value="">支付</option>
<option value="money" <?php if($currency=='money') { ?>selected<?php } ?>
><?php echo $DT['money_name'];?></option>
<option value="credit" <?php if($currency=='credit') { ?>selected<?php } ?>
><?php echo $DT['credit_name'];?></option>
</select>
&nbsp;
<?php echo dcalendar('fromtime', $fromtime);?> 至 <?php echo dcalendar('totime', $totime);?>
&nbsp;
<input type="submit" value=" 搜 索 " class="btn"/>&nbsp;
<input type="button" value=" 重 置 " class="btn" onclick="Go('?action=<?php echo $action;?>');"/>
</div>
</form>
<div class="bd">
<table cellpadding="1" cellspacing="0" class="tb">
<tr>
<th>流水号</th>
<th>支出</th>
<th>单位</th>
<th>模块</th>
<th>标题</th>
<th width="130">支付时间</th>
</tr>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<tr  align="center">
<td height="30" class="px11"><?php echo $v['pid'];?></td>
<td class="px11 f_red"><?php echo $v['fee'];?></td>
<td><?php if($v['currency'] == 'money') { ?><?php echo $DT['money_unit'];?><?php } else { ?><?php echo $DT['credit_unit'];?><?php } ?>
</td>
<td><a href="<?php echo $MODULE[$v['moduleid']]['linkurl'];?>" target="_blank"><?php echo $MODULE[$v['moduleid']]['name'];?></a></td>
<td><a href="<?php echo $MODULE['3']['linkurl'];?>redirect.php?mid=<?php echo $v['moduleid'];?>&itemid=<?php echo $v['itemid'];?>" target="_blank" class="t"><?php echo $v['title'];?></a></td>
<td class="px11 f_gray"><?php echo $v['paytime'];?></td>
</tr>
<?php } } ?>
<tr align="center">
<td height="35"><strong>小计</strong></td>
<td class="px11 f_blue"><?php echo $fee;?></td>
<td colspan="5">&nbsp;</td>
</tr>
</table>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">s('record');m('action_pay');</script>
<?php } else { ?>
<form action="?">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<div class="tt">
<?php echo $fields_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<select name="type">
<option value="0">类型</option>
<option value="1" <?php if($type==1) { ?>selected<?php } ?>
>收入</option>
<option value="2" <?php if($type==2) { ?>selected<?php } ?>
>支出</option>
</select>
&nbsp;
<?php echo dcalendar('fromtime', $fromtime);?> 至 <?php echo dcalendar('totime', $totime);?>
&nbsp;
<input type="submit" value=" 搜 索 " class="btn"/>&nbsp;
<input type="button" value=" 重 置 " class="btn" onclick="Go('?action=<?php echo $action;?>');"/>
</div>
</form>
<div class="bd">
<table cellpadding="1" cellspacing="0" class="tb">
<tr>
<th>流水号</th>
<th>收入</th>
<th>支出</th>
<th>余额</th>
<th>银行</th>
<th width="130">发生时间</th>
<th width="150">事由</th>
<th width="150">备注</th>
</tr>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<tr  align="center">
<td height="30" class="px11"><?php echo $v['itemid'];?></td>
<td class="px11 f_blue"><?php if($v['amount'] > 0) { ?><?php echo $v['amount'];?><?php } else { ?>&nbsp;<?php } ?>
</td>
<td class="px11 f_red"><?php if($v['amount'] < 0) { ?><?php echo $v['amount'];?><?php } else { ?>&nbsp;<?php } ?>
</td>
<td class="px11"><?php if($v['balance']) { ?><?php echo $v['balance'];?><?php } else { ?>&nbsp;<?php } ?>
</td>
<td><?php echo $v['bank'];?></td>
<td class="px11 f_gray"><?php echo $v['addtime'];?></td>
<td title="<?php echo $v['reason'];?>"><input type="text" size="20" value="<?php echo $v['reason'];?>"/></td>
<td title="<?php echo $v['note'];?>"><input type="text" size="20" value="<?php echo $v['note'];?>"/></td>
</tr>
<?php } } ?>
<tr align="center">
<td height="35"><strong>小计</strong></td>
<td class="px11 f_blue"><?php echo $income;?></td>
<td class="px11 f_red"><?php echo $expense;?></td>
<td colspan="5">&nbsp;</td>
</tr>
</table>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">s('record');m('action');</script>
<?php } ?>
<?php } ?>
<?php include template('footer', $module);?>