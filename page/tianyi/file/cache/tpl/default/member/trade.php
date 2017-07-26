<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header', $module);?>
<script type="text/javascript">c(2);var errimg = '<?php echo DT_SKIN;?>image/nopic60.gif';</script>
<div class="menu">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="tab" id="action"><a href="?action=index"><span>收到的订单(我是卖家)</span></a></td>
<td class="tab" id="action_order"><a href="?action=order"><span>买到的商品(我是买家)</span></a></td>
<td class="tab" id="action_express"><a href="?action=express"><span>我的快递</span></a></td>
<?php if($DT['trade']) { ?>
<td class="tab" id="action_bind"><a href="?action=bind"><span>绑定<?php echo $DT['trade_nm'];?>帐号</span></a></td>
<?php } ?>
</tr>
</table>
</div>
<?php if($action == 'bind') { ?>
<?php if($member['vtrade']) { ?>
<table cellpadding="10" cellspacing="1" class="tb">
<tr>
<td class="tl"><?php echo $DT['trade_nm'];?>帐号</td>
<td class="tr"><strong><?php echo $member['trade'];?></strong></td>
</tr>
<tr>
<td class="tl">绑定状态</td>
<td class="tr f_green">已验证</td>
</tr>
<tr>
<td class="tl"><?php echo $DT['trade_nm'];?></td>
<td class="tr"><a href="<?php echo $DT['trade_hm'];?>" target="_blank" class="l">交易管理</a></td>
</tr>
</table>
<?php } else { ?>
<form method="post" action="?">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<table cellpadding="10" cellspacing="1" class="tb">
<tr>
<td class="tl"><?php echo $DT['trade_nm'];?>网站</td>
<td class="tr">
还没有 <img src="<?php echo DT_PATH;?>api/trade/<?php echo $DT['trade'];?>/logo.gif" alt="<?php echo $DT['trade_nm'];?>" align="absmiddle"/> 会员帐号？ <a href="<?php echo $DT['trade_hm'];?>" target="_blank" class="l">点击了解和注册</a>
</td>
</tr>
<tr>
<td class="tl"><?php echo $DT['trade_nm'];?>帐号</td>
<td class="tr"><input type="text" size="30" name="trade" id="trade" value="<?php echo $member['trade'];?>"/> <input type="submit" name="submit" value="<?php if($member['trade']) { ?>更 新<?php } else { ?>绑 定<?php } ?>
" class="btn_g"/></td>
</tr>
<tr>
<td class="tl">绑定状态</td>
<td class="tr f_red">未验证</td>
</tr>
<tr>
<td class="tl">验证方法</td>
<td class="tr f_gray">通过<?php echo $DT['trade_nm'];?>成功交易后系统自动验证</td>
</tr>
<tr>
<td class="tl">绑定说明</td>
<td class="tr f_gray">卖家必须绑定<?php echo $DT['trade_nm'];?>帐号用于收款，买家无须绑定</td>
</tr>
</table>
</form>
<?php } ?>
<script type="text/javascript">s('trade');m('action_bind');</script>
<?php } else if($action == 'update') { ?>
<?php if($step == 'edit_price') { ?>
<form method="post" action="?" onsubmit="return check();" id="dform">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">当前操作</td>
<td class="tr f_red f_b">修改订单</td>
</tr>
<tr>
<td class="tl">订单单号</td>
<td class="tr"><?php echo $td['itemid'];?></td>
</tr>
<tr>
<td class="tl">商品名称</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank" class="t"><?php echo $td['title'];?></a></td>
</tr>
<tr>
<td class="tl">商品图片</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank"><img src="<?php if($td['thumb']) { ?><?php echo $td['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>
" width="60" height="60"/></a></td>
</tr>
<?php if($td['par']) { ?>
<tr>
<td class="tl">规格参数</td>
<td class="tr"><?php echo $td['par'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">买家 </td>
<td class="tr"><?php if($DT['im_web']) { ?><?php echo im_web($td['buyer']);?>&nbsp;<?php } ?>
<a href="<?php echo userurl($td['buyer'], 'file=contact');?>" target="_blank" class="t"><?php echo $td['buyer'];?></a></td>
</tr>
<tr>
<td class="tl">买家留言</td>
<td class="tr"><?php echo $td['note'];?></td>
</tr>
<tr>
<td class="tl">下单时间</td>
<td class="tr"><?php echo $td['adddate'];?></td>
</tr>
<tr>
<td class="tl">商品单价</td>
<td class="tr"><?php echo $DT['money_sign'];?><?php echo $td['price'];?></td>
</tr>
<tr>
<td class="tl">购买数量</td>
<td class="tr"><?php echo $td['number'];?></td>
</tr>
<tr>
<td class="tl">订单金额</td>
<td class="tr f_red"><?php echo $DT['money_sign'];?><?php echo $td['amount'];?></td>
</tr>
<tr>
<td class="tl">附加名称</td>
<td class="tr f_gray"><input type="text" size="10" name="fee_name" id="fee_name" value="<?php echo $td['fee_name'];?>"/> 例如运费、退款、优惠等&nbsp;<span id="dfee_name" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">附加金额</td>
<td class="tr f_gray"><input type="text" size="5" name="fee" id="fee" value="<?php echo $td['fee'];?>"/>  <?php echo $DT['money_unit'];?> 可以为负值&nbsp;<span id="dfee" class="f_red"></span></td>
</tr>
<?php if($td['status'] < 1) { ?>
<tr>
<td class="tl"></td>
<td class="tr"><input type="checkbox" name="confirm_order" value="1"<?php if($confirm) { ?> checked<?php } ?>
/> 同时确认订单</td>
</tr>
<?php } ?>
<?php if($td['cod'] < 1) { ?>
<tr>
<td class="tl"></td>
<td class="tr"><input type="checkbox" name="edit_cod" value="1"/> 改为货到付款</td>
</tr>
<?php } ?>
<?php if($_userid && $DT['sms']) { ?>
<tr>
<td class="tl"></td>
<td class="tr"><input type="checkbox" name="sendsms" value="1"/> 短信通知买家 (<a href="sms.php" target="_blank" class="t">我的可用短信 <strong class="f_blue"><?php echo $_sms;?></strong> 条</a>)</td>
</tr>
<?php } ?>
<tr>
<td class="tl"> </td>
<td class="tr">
<input type="submit" name="submit" value=" 确 定 " class="btn_g"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
function check() {
if(Dd('fee').value < 0 && Dd('fee').value < -<?php echo $td['amount'];?>) {
Dmsg('附加金额不能小于-<?php echo $td['amount'];?>', 'fee');
return false;
}
return true;
}
</script>
<script type="text/javascript">s('trade');m('action');</script>
<?php } else if($step == 'detail') { ?>
<?php if(!in_array($td['status'], array(8, 9))) { ?>
<table cellpadding="0" cellspacing="0" align="center">
<tr align="center" class="f_gray">
<td>买家下单</td>
<td id="pay_n">买家付款</td>
<td>卖家发货</td>
<?php if($td['status'] == 5 || $td['status'] == 6) { ?>
<td>申请退款</td>
<td>退款成功</td>
<?php } else { ?>
<td>交易成功</td>
<td>双方互评</td>
<?php } ?>
</tr>
<tr height="60">
<td><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/state_2.gif" id="state_1"/></td>
<td id="pay_s"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/state_1.gif" id="state_2"/></td>
<td><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/state_1.gif" id="state_3"/></td>
<td><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/state_1.gif" id="state_4"/></td>
<td><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/state_1.gif" id="state_5"/></td>
</tr>
</table>
</div>
<script type="text/javascript">
var s1 = Dd('state_2').src;
var s2 = Dd('state_1').src;
function Dstate(n) {
for(var i = 2; i <= n; i++) {
Dd('state_'+i).src = s2;
}
}
<?php if($td['status'] == 2) { ?>
Dstate(2);
<?php } else if($td['status'] == 3) { ?>
Dstate(3);
<?php } else if($td['status'] == 4) { ?>
<?php if($td['buyer_star'] && $td['seller_star']) { ?>
Dstate(5);
<?php } else { ?>
Dstate(4);
<?php } ?>
<?php } else if($td['status'] == 5) { ?>
Dstate(4);
<?php } else if($td['status'] == 6) { ?>
Dstate(5);
<?php } ?>
<?php if($td['status'] == 5 || $td['status'] == 6) { ?>
<?php if(!$td['send_time']) { ?>Dd('state_3').src = s1;<?php } ?>
<?php } ?>
<?php if($td['cod']) { ?>Dh('pay_n');Dh('pay_s');<?php } ?>
</script>
<?php } ?>
<div class="t2">商品信息</div>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">订单单号</td>
<td class="tr">
<?php echo $td['itemid'];?>
<?php if($DT['trade']) { ?>(<?php echo $DT['trade_nm'];?>&nbsp;&nbsp;&nbsp;&nbsp;订单单号:<a href="https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo=<?php echo $td['trade_no'];?>" target="_blank" class="t"><?php echo $td['trade_no'];?></a>)<?php } ?>
<?php if($td['seller'] == $_username) { ?>&nbsp;&nbsp;&nbsp;&nbsp;<a href="?action=update&step=print&itemid=<?php echo $itemid;?>" target="_blank" class="t">[打印订单]</a><?php } ?>
</td>
</tr>
<tr>
<td class="tl">商品名称</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank" class="t"><?php echo $td['title'];?></a></td>
</tr>
<tr>
<td class="tl">商品图片</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank"><img src="<?php if($td['thumb']) { ?><?php echo $td['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>
" width="60" height="60"/></a></td>
</tr>
<?php if($td['par']) { ?>
<tr>
<td class="tl">规格参数</td>
<td class="tr"><?php echo $td['par'];?></td>
</tr>
<?php } ?>
<?php if($td['seller'] == $_username) { ?>
<tr>
<td class="tl">买家 </td>
<td class="tr"><?php if($DT['im_web']) { ?><?php echo im_web($td['buyer']);?>&nbsp;<?php } ?>
<a href="message.php?action=send&touser=<?php echo $td['buyer'];?>"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/ico_message.gif" title="发送站内信" align="absmiddle"/></a> <a href="<?php echo userurl($td['buyer'], 'file=contact');?>" target="_blank" class="t"><?php echo $td['buyer'];?></a></td>
</tr>
<?php } else if($td['buyer'] == $_username) { ?>
<tr>
<td class="tl">卖家</td>
<td class="tr"><?php if($DT['im_web']) { ?><?php echo im_web($td['seller']);?>&nbsp;<?php } ?>
<a href="message.php?action=send&touser=<?php echo $td['seller'];?>"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/ico_message.gif" title="发送站内信" align="absmiddle"/></a> <a href="<?php echo userurl($td['seller'], 'file=contact');?>" target="_blank" class="t"><?php echo $td['seller'];?></a></td>
</tr>
<?php } ?>
</table>
<div class="t2">快递信息</div>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">邮编</td>
<td class="tr"><?php echo $td['buyer_postcode'];?></td>
</tr>
<tr>
<td class="tl">地址</td>
<td class="tr"><?php echo $td['buyer_address'];?></td>
</tr>
<tr>
<td class="tl">姓名</td>
<td class="tr"><?php echo $td['buyer_name'];?></td>
</tr>
<tr>
<td class="tl">手机</td>
<td class="tr"><?php echo $td['buyer_mobile'];?> <?php if($DT['sms']) { ?>&nbsp;&nbsp;<a href="sms.php?action=add&auth=<?php echo encrypt($td['buyer_mobile'], DT_KEY.'SMS');?>" target="_blank"><img src="<?php echo DT_SKIN;?>image/sendsms.gif" align="absmiddle" title="发送短信" alt=""/></a><?php } ?>
</td>
</tr>
<tr>
<td class="tl">电话</td>
<td class="tr"><?php echo $td['buyer_phone'];?></td>
</tr>
<tr>
<td class="tl">买家留言</td>
<td class="tr"><?php if($td['note']) { ?><?php echo $td['note'];?><?php } else { ?>无<?php } ?>
</td>
</tr>
<?php if($td['send_time']) { ?>
<tr>
<td class="tl">发货日期</td>
<td class="tr"><?php echo $td['send_time'];?></td>
</tr>
<tr>
<td class="tl">快递类型</td>
<td class="tr"><?php echo $td['send_type'];?></td>
</tr>
<tr>
<td class="tl">快递单号</td>
<td class="tr"><?php echo $td['send_no'];?><?php if($td['send_type'] && $td['send_no']) { ?> &nbsp;<a href="###" class="t" onclick="Ds('express_t');$('#express').load(AJPath+'?action=express&moduleid=2&auth=<?php echo $auth;?>');">[快递追踪]</a><?php } ?>
</td>
</tr>
<tr id="express_t" style="display:none;">
<td class="tl">追踪结果</td>
<td class="tr" style="line-height:200%;"><div id="express">正在查询...</div></td>
</tr>
<tr>
<td class="tl">快递状态</td>
<td class="tr"><?php echo $_send_status[$td['send_status']];?></td>
</tr>
<?php } ?>
</table>
<div class="t2">价格信息</div>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">商品单价</td>
<td class="tr"><?php echo $DT['money_sign'];?><?php echo $td['price'];?></td>
</tr>
<tr>
<td class="tl">购买数量</td>
<td class="tr"><?php echo $td['number'];?></td>
</tr>
<?php if($td['fee_name'] && $td['fee']) { ?>
<tr>
<td class="tl"><?php echo $td['fee_name'];?></td>
<td class="tr"><?php echo $DT['money_sign'];?><?php echo $td['fee'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">订单总额</td>
<td class="tr f_red"><?php echo $DT['money_sign'];?><?php echo $td['total'];?></td>
</tr>
</table>
<div class="t2">订单状态</div>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">下单时间</td>
<td class="tr"><?php echo $td['adddate'];?></td>
</tr>
<tr>
<td class="tl">最后更新</td>
<td class="tr"><?php echo $td['updatedate'];?></td>
</tr>
<?php if($td['send_time']) { ?>
<tr>
<td class="tl">发货时间</td>
<td class="tr"><?php echo $td['send_time'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">订单状态</td>
<td class="tr"><?php echo $_status[$td['status']];?></td>
</tr>
<?php if($td['buyer_reason']) { ?>
<tr>
<td class="tl">退款理由</td>
<td class="tr"><?php echo $td['buyer_reason'];?></td>
</tr>
<?php } ?>
<?php if($td['refund_reason']) { ?>
<tr>
<td class="tl">操作原因</td>
<td class="tr"><?php echo $td['refund_reason'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl"> </td>
<td class="tr">
<?php if($td['seller'] == $_username) { ?>
<?php if($td['status'] == 0) { ?>
<input type="button" value=" 确 认 " class="btn_g" onclick="Go('?itemid=<?php echo $td['itemid'];?>&action=update&step=edit_price&confirm=1');"/> &nbsp;
<?php } else if($td['status'] == 2) { ?>
<input type="button" value=" 发 货 " class="btn_g" onclick="Go('?itemid=<?php echo $td['itemid'];?>&action=update&step=send_goods');"/> &nbsp;
<?php } ?>
<?php } else { ?>
<?php if($td['status'] == 1) { ?>
<input type="button" value=" 付 款 " class="btn_g" onclick="Go('?itemid=<?php echo $td['itemid'];?>&action=update&step=pay');"/> &nbsp;
<?php } ?>
<?php } ?>
<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
<script type="text/javascript">s('trade');m('<?php echo $nav;?>');</script>
<?php } else if($step == 'express') { ?>
<div class="t2">快递信息</div>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">商品名称</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank" class="t"><?php echo $td['title'];?></a></td>
</tr>
<tr>
<td class="tl">发货日期</td>
<td class="tr"><?php echo $td['send_time'];?></td>
</tr>
<tr>
<td class="tl">快递类型</td>
<td class="tr"><?php echo $td['send_type'];?></td>
</tr>
<tr>
<td class="tl">快递单号</td>
<td class="tr"><?php echo $td['send_no'];?></td>
</tr>
<tr>
<td class="tl">追踪结果</td>
<td class="tr" style="line-height:200%;"><div id="express">正在查询...</div></td>
</tr>
<tr>
<td class="tl">快递状态</td>
<td class="tr"><?php echo $_send_status[$td['send_status']];?></td>
</tr>
<tr>
<td class="tl"> </td>
<td class="tr"><input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
<script type="text/javascript">
$(document).ready(function(){
$('#express').load(AJPath+'?action=express&moduleid=2&auth=<?php echo $auth;?>');
});
</script>
<script type="text/javascript">s('trade');m('<?php echo $nav;?>');</script>
<?php } else if($step == 'pay') { ?>
<form method="post" action="?" onsubmit="return check();" id="dform">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">当前操作</td>
<td class="tr f_red f_b">订单支付</td>
</tr>
<tr>
<td class="tl">订单单号</td>
<td class="tr"><?php echo $td['itemid'];?><?php if($DT['trade']) { ?>&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $DT['trade_nm'];?>订单单号:<?php echo $td['trade_no'];?>)<?php } ?>
</td>
</tr>
<tr>
<td class="tl">商品名称</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank" class="t"><?php echo $td['title'];?></a></td>
</tr>
<tr>
<td class="tl">商品图片</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank"><img src="<?php if($td['thumb']) { ?><?php echo $td['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>
" width="60" height="60"/></a></td>
</tr>
<?php if($td['par']) { ?>
<tr>
<td class="tl">规格参数</td>
<td class="tr"><?php echo $td['par'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">卖家</td>
<td class="tr"><?php if($DT['im_web']) { ?><?php echo im_web($td['seller']);?>&nbsp;<?php } ?>
<a href="<?php echo userurl($td['seller'], 'file=contact');?>" target="_blank" class="t"><?php echo $td['seller'];?></a></td>
</tr>
<tr>
<td class="tl">下单时间</td>
<td class="tr"><?php echo $td['adddate'];?></td>
</tr>
<tr>
<td class="tl">我的备注</td>
<td class="tr"><?php echo $td['note'];?></td>
</tr>
<tr>
<td class="tl">商品单价</td>
<td class="tr"><?php echo $DT['money_sign'];?><?php echo $td['price'];?></td>
</tr>
<tr>
<td class="tl">购买数量</td>
<td class="tr"><?php echo $td['number'];?></td>
</tr>
<?php if($td['fee']>0.1) { ?>
<tr>
<td class="tl"><?php echo $td['fee_name'];?></td>
<td class="tr"><?php echo $DT['money_sign'];?><?php echo $td['fee'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">实付金额</td>
<td class="tr f_red"><?php echo $DT['money_sign'];?><?php echo number_format($money, 2, '.', '');?></td>
</tr>
<tr>
<td class="tl">帐户余额</td>
<td class="tr f_blue"><?php echo $DT['money_sign'];?><?php echo $_money;?></td>
</tr>
<tr id="payword" style="display:none;">
<td class="tl"><span class="f_red">*</span> 支付密码</td>
<td class="tr"><?php include template('password', 'chip');?>&nbsp;<span id="dpassword" class="f_red"></span></td>
</tr>
<?php if($DT['sms']) { ?>
<tr>
<td class="tl"></td>
<td class="tr"><input type="checkbox" name="sendsms" value="1"/> 短信通知卖家发货 (<a href="sms.php" target="_blank" class="t">我的可用短信 <strong class="f_blue"><?php echo $_sms;?></strong> 条</a>)</td>
</tr>
<?php } ?>
<tr>
<td class="tl"> </td>
<td class="tr">
<input type="submit" name="submit" value=" 立即支付 " class="btn_g"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
var total = <?php echo $money;?>;
function check() {
if(total > <?php echo $_money;?>) {
Go('charge.php?action=pay&reason=trade|<?php echo $itemid;?>&amount='+(total-<?php echo $_money;?>));
return false;
}
if(Dd('password').value.length < 6) {
Dmsg('请填写支付密码', 'password');
return false;
}
return confirm('您确认此订单，并立即支付吗？');
}
window.setInterval(
function() {
total > <?php echo $_money;?> ? Dh('payword') : Ds('payword');
},
500);
</script>
<script type="text/javascript">s('trade');m('action_order');</script>
<?php } else if($step == 'send_goods') { ?>
<form method="post" action="?" onsubmit="return check();" id="dform">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellspacing="1" cellpadding="6" class="tb">
<tr>
<td class="tl">当前操作</td>
<td class="tr f_red f_b">确认发货</td>
</tr>
<tr>
<td class="tl">快递类型</td>
<td class="tr f_gray">
<select name="send_type" id="send_type">
<option value="">请选择</option>
<?php if(is_array($send_types)) { foreach($send_types as $v) { ?>
<option value="<?php echo $v;?>"><?php echo $v;?></option>
<?php } } ?>
</select>
</td>
</tr>
<tr>
<td class="tl">快递单号</td>
<td class="tr f_gray"><input type="text" size="30" name="send_no" id="send_no"/></td>
</tr>
<tr>
<td class="tl">发货时间</td>
<td class="tr f_gray"><?php echo dcalendar('send_time', $send_time);?></td>
</tr>
<?php if($_userid && $DT['sms']) { ?>
<tr>
<td class="tl"></td>
<td class="tr"><input type="checkbox" name="sendsms" value="1"/> 短信通知买家已发货 (<a href="sms.php" target="_blank" class="t">我的可用短信 <strong class="f_blue"><?php echo $_sms;?></strong> 条</a>)</td>
</tr>
<?php } ?>
<tr>
<td class="tl"> </td>
<td class="tr">
<input type="submit" name="submit" value=" 确 定 " class="btn_g"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
function check() {
return confirm('您确认货物已经发出，并且以上信息填写无误吗？\n\n此操作将不可撤销');
}
</script>
<script type="text/javascript">s('trade');m('action');</script>
<?php } else if($step == 'add_time') { ?>
<form method="post" action="?" onsubmit="return check();" id="dform">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellspacing="1" cellpadding="6" class="tb">
<tr>
<td class="tl">当前操作</td>
<td class="tr f_red f_b">延长买家确认时间</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>延长时间</td>
<td class="tr f_gray"><input type="text" size="10" name="add_time" id="add_time" value="72"/> 小时 （1天=24小时 只能为整数）&nbsp;<span id="dadd_time" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"> </td>
<td class="tr">
<input type="submit" name="submit" value=" 确 定 " class="btn_g"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
function check() {
return confirm('您确认延长'+Dd('add_time').value+'小时吗？');
}
</script>
<script type="text/javascript">s('trade');m('action');</script>
<?php } else if($step == 'remind') { ?>
<form action="message.php" method="post" id="remind">
<input type="hidden" name="action" value="send" />
<input type="hidden" name="forward" value="<?php echo $MOD['linkurl'];?>trade.php?action=order&itemid=<?php echo $itemid;?>" />
<input type="hidden" name="touser" value="<?php echo $td['seller'];?>" />
<input type="hidden" name="title" value="[发货提醒]订单(ID:<?php echo $itemid;?>)已经付款，请尽快发货" />
<textarea name="content" style="display:none;">
<?php echo $td['seller'];?>，您好：<br/>
订单 <a href="<?php echo $MOD['linkurl'];?>trade.php?action=update&step=detail&itemid=<?php echo $itemid;?>" target="_blank"><?php echo $td['title'];?> (ID:<?php echo $itemid;?>)</a> 已经付款。请尽快发货！
</textarea>
</form>
<script type="text/javascript">s('trade');m('action_order');Dd('remind').submit();</script>
<?php } else if($step == 'refund') { ?>
<form method="post" action="?" onsubmit="return check();" id="dform">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">当前操作</td>
<td class="tr f_red f_b">申请退款</td>
</tr>
<tr>
<td class="tl">商品名称</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank" class="t"><?php echo $td['title'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="$('#trade_detail').toggle('fast');" class="t">详情&raquo;</a></td>
</tr>
<tbody id="trade_detail" style="display:none;">
<tr>
<td class="tl">订单单号</td>
<td class="tr"><?php echo $td['itemid'];?><?php if($DT['trade']) { ?>&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $DT['trade_nm'];?>订单单号:<?php echo $td['trade_no'];?>)<?php } ?>
</td>
</tr>
<tr>
<td class="tl">商品图片</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank"><img src="<?php if($td['thumb']) { ?><?php echo $td['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>
" width="60" height="60"/></a></td>
</tr>
<?php if($td['par']) { ?>
<tr>
<td class="tl">规格参数</td>
<td class="tr"><?php echo $td['par'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">卖家</td>
<td class="tr"><?php if($DT['im_web']) { ?><?php echo im_web($td['seller']);?>&nbsp;<?php } ?>
<a href="<?php echo userurl($td['seller'], 'file=contact');?>" target="_blank" class="t"><?php echo $td['seller'];?></a></td>
</tr>
<tr>
<td class="tl">下单时间</td>
<td class="tr"><?php echo $td['adddate'];?></td>
</tr>
<tr>
<td class="tl">备注说明</td>
<td class="tr"><?php echo $td['note'];?></td>
</tr>
<tr>
<td class="tl">商品单价</td>
<td class="tr"><?php echo $DT['money_sign'];?><?php echo $td['price'];?></td>
</tr>
<tr>
<td class="tl">购买数量</td>
<td class="tr"><?php echo $td['number'];?></td>
</tr>
<?php if($td['fee_name'] && $td['fee']) { ?>
<tr>
<td class="tl"><?php echo $td['fee_name'];?></td>
<td class="tr"><?php echo $DT['money_sign'];?><?php echo $td['fee'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">订单总额</td>
<td class="tr f_red"><?php echo $DT['money_sign'];?><?php echo $money;?></td>
</tr>
</tbody>
<tr>
<td class="tl"><span class="f_red">*</span> 退款原因</td>
<td class="tr"><textarea name="content" id="content" class="dsn"></textarea>
<?php echo deditor($moduleid, 'content', 'Simple', '100%', 200);?><br/><span class="f_gray">请客观、如实填写，此申请一经提交，将不可再撤销</span><span id="dcontent" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 支付密码</td>
<td class="tr"><?php include template('password', 'chip');?>&nbsp;<span id="dpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"> </td>
<td class="tr">
<input type="submit" name="submit" value=" 确 定 " class="btn_g"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
function check() {
var len = FCKLen();
if(len < 10) {
Dmsg('退款原因不能少于10个字，当前已输入'+len+'个字', 'content');
return false;
}
if(Dd('password').value.length < 6) {
Dmsg('请填写支付密码', 'password');
return false;
}
return confirm('您确认您提供的退款原因无误，并申请退款吗？');
}
</script>
<script type="text/javascript">s('trade');m('action_order');</script>
<?php } else if($step == 'refund_agree') { ?>
<form method="post" action="?" onsubmit="return check();" id="dform">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">当前操作</td>
<td class="tr f_red f_b">同意退款</td>
</tr>
<tr>
<td class="tl">商品名称</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank" class="t"><?php echo $td['title'];?></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:;" onclick="$('#trade_detail').toggle('fast');" class="t">详情&raquo;</a></td>
</tr>
<tbody id="trade_detail" style="display:none;">
<tr>
<td class="tl">订单单号</td>
<td class="tr"><?php echo $td['itemid'];?><?php if($DT['trade']) { ?>&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $DT['trade_nm'];?>订单单号:<?php echo $td['trade_no'];?>)<?php } ?>
</td>
</tr>
<tr>
<td class="tl">商品图片</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank"><img src="<?php if($td['thumb']) { ?><?php echo $td['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>
" width="60" height="60"/></a></td>
</tr>
<?php if($td['par']) { ?>
<tr>
<td class="tl">规格参数</td>
<td class="tr"><?php echo $td['par'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">卖家</td>
<td class="tr"><?php if($DT['im_web']) { ?><?php echo im_web($td['seller']);?>&nbsp;<?php } ?>
<a href="<?php echo userurl($td['seller'], 'file=contact');?>" target="_blank" class="t"><?php echo $td['seller'];?></a></td>
</tr>
<tr>
<td class="tl">下单时间</td>
<td class="tr"><?php echo $td['adddate'];?></td>
</tr>
<tr>
<td class="tl">备注说明</td>
<td class="tr"><?php echo $td['note'];?></td>
</tr>
<tr>
<td class="tl">商品单价</td>
<td class="tr"><?php echo $DT['money_sign'];?><?php echo $td['price'];?></td>
</tr>
<tr>
<td class="tl">购买数量</td>
<td class="tr"><?php echo $td['number'];?></td>
</tr>
<?php if($td['fee_name'] && $td['fee']) { ?>
<tr>
<td class="tl"><?php echo $td['fee_name'];?></td>
<td class="tr"><?php echo $DT['money_sign'];?><?php echo $td['fee'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">订单总额</td>
<td class="tr f_red"><?php echo $DT['money_sign'];?><?php echo $money;?></td>
</tr>
</tbody>
<tr>
<td class="tl">退款原因</td>
<td class="tr"><?php echo $td['buyer_reason'];?></td>
</tr>
<tr>
<td class="tl">同意原因</td>
<td class="tr"><textarea name="content" id="content" class="dsn"></textarea>
<?php echo deditor($moduleid, 'content', 'Simple', '100%', 200);?><br/></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 支付密码</td>
<td class="tr"><?php include template('password', 'chip');?>&nbsp;<span id="dpassword" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"> </td>
<td class="tr">
<input type="submit" name="submit" value=" 确 定 " class="btn_g"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
function check() {
if(Dd('password').value.length < 6) {
Dmsg('请填写支付密码', 'password');
return false;
}
return confirm('您确认同意退款此订单吗？此操作将不可撤销');
}
</script>
<script type="text/javascript">s('trade');m('action_order');</script>
<?php } else if($step == 'comment') { ?>
<form method="post" action="?" onsubmit="return check();" id="dform">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellspacing="1" cellpadding="6" class="tb">
<tr>
<td class="tl">当前操作</td>
<td class="tr f_red f_b">交易评价</td>
</tr>
<tr>
<td class="tl">交易打分</td>
<td class="tr">
<input type="radio" name="star" value="3" id="star_3" checked/><label for="star_3"> 好评 <img src="<?php echo DT_STATIC;?>file/image/star3.gif" width="36" height="12" alt="" align="absmiddle"/></label>
<input type="radio" name="star" value="2" id="star_2"/><label for="star_2"> 中评 <img src="<?php echo DT_STATIC;?>file/image/star2.gif" width="36" height="12" alt="" align="absmiddle"/></label>
<input type="radio" name="star" value="1" id="star_1"/><label for="star_1"> 差评 <img src="<?php echo DT_STATIC;?>file/image/star1.gif" width="36" height="12" alt="" align="absmiddle"/></label>
</td>
</tr>
<tr>
<td class="tl">详细评论</td>
<td class="tr f_gray">
<textarea onkeyup="S();" name="content" id="content" style="width:300px;height:60px;margin:0 0 6px 0;"></textarea><br/>
请您对此次交易做出客观、公正的评论<br/>
(内容限0至500字) 当前已经输入 <span style="color:red;" id="chars">0</span> 字
</td>
</tr>
<tr>
<td class="tl"> </td>
<td class="tr">
<input type="submit" name="submit" value=" 确 定 " class="btn_g"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
function check() {
if(Dd('content').value.length > 500) {
alert('评论内容不能超过500字');
return false;
}
return confirm('您确认提交此评论吗？提交后评论分数和内容将不可更改');
}
function S() {
Inner('chars', Dd('content').value.length);
}
</script>
<script type="text/javascript">s('trade');m('<?php echo $nav;?>');</script>
<?php } else if($step == 'comment_detail') { ?>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl">当前操作</td>
<td class="tr f_red f_b">评价详情</td>
</tr>
</table>
<div class="t2">买家评价<?php if($_username==$td['buyer']) { ?>(我的)<?php } ?>
</div>
<table cellspacing="1" cellpadding="8" class="tb">
<?php if($cm['seller_star']) { ?>
<tr>
<td class="tl">买家评分</td>
<td class="tr"><img src="<?php echo DT_STATIC;?>file/image/star<?php echo $cm['seller_star'];?>.gif" width="36" height="12" alt="" align="absmiddle"/> <?php echo $STARS[$cm['seller_star']];?>
<?php if($_username == $td['seller'] && !$cm['buyer_reply']) { ?>
&nbsp;&nbsp;<a href="#exp" onclick="Ds('explain');" class="t">[解释]</a>
<?php } ?>
</td>
</tr>
<tr>
<td class="tl">买家评论</td>
<td class="tr"><?php echo nl2br($cm['seller_comment']);?></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td class="tr px11"><?php echo timetodate($cm['seller_ctime'], 6);?></td>
</tr>
<?php if($cm['buyer_reply']) { ?>
<tr>
<td class="tl">卖家解释</td>
<td class="tr" style="color:#D9251D;"><?php echo nl2br($cm['buyer_reply']);?></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td class="tr px11"><?php echo timetodate($cm['buyer_rtime'], 6);?></td>
</tr>
<?php } ?>
<?php } else { ?>
<tr>
<td class="tl">买家评论</td>
<td class="tr">暂未评论</td>
</tr>
<?php } ?>
</table>
<div class="t2">卖家评价<?php if($_username==$td['seller']) { ?>(我的)<?php } ?>
</div>
<table cellspacing="1" cellpadding="8" class="tb">
<?php if($cm['buyer_star']) { ?>
<tr>
<td class="tl">卖家评分</td>
<td class="tr"><img src="<?php echo DT_STATIC;?>file/image/star<?php echo $cm['buyer_star'];?>.gif" width="36" height="12" alt="" align="absmiddle"/> <?php echo $STARS[$cm['buyer_star']];?>
<?php if($_username == $td['buyer'] && !$cm['seller_reply']) { ?>
&nbsp;&nbsp;<a href="#exp" onclick="Ds('explain');" class="t">[解释]</a>
<?php } ?>
</td>
</tr>
<tr>
<td class="tl">卖家评论</td>
<td class="tr"><?php echo nl2br($cm['buyer_comment']);?></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td class="tr px11"><?php echo timetodate($cm['buyer_ctime'], 6);?></td>
</tr>
<?php if($cm['seller_reply']) { ?>
<tr>
<td class="tl">买家解释</td>
<td class="tr" style="color:#D9251D;"><?php echo nl2br($cm['seller_reply']);?></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td class="tr px11"><?php echo timetodate($cm['seller_rtime'], 6);?></td>
</tr>
<?php } ?>
<?php } else { ?>
<tr>
<td class="tl">卖家评论</td>
<td class="tr">暂未评论</td>
</tr>
<?php } ?>
</table>
<div style="display:none;" id="explain">
<div class="t2">我的解释</div>
<form method="post" action="?" onsubmit="return check();" id="dform">
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="step" value="<?php echo $step;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellspacing="1" cellpadding="8" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span>我的解释</td>
<td class="tr f_gray">
<textarea onkeyup="S();" name="content" id="content" style="width:300px;height:60px;margin:0 0 6px 0;"></textarea><br/>
请您对此次评价做出客观、合理的解释<br/>
(内容限2至500字) 当前已经输入 <span style="color:red;" id="chars">0</span> 字
</td>
</tr>
<tr>
<td class="tl"> </td>
<td class="tr">
<input type="submit" name="submit" value=" 确 定 " class="btn_g"/>&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/>
</td>
</tr>
</table>
</form>
</div>
<a name="exp"></a>
<script type="text/javascript">
function check() {
if(Dd('content').value.length < 2) {
alert('解释内容不能少于2字');
return false;
}
if(Dd('content').value.length > 500) {
alert('解释内容不能超过500字');
return false;
}
return confirm('您确认提交此解释吗？提交后解释内容将不可更改');
}
function S() {
Inner('chars', Dd('content').value.length);
}
</script>
<script type="text/javascript">s('trade');m('<?php echo $nav;?>');</script>
<?php } ?>
<?php } else if($action == 'muti') { ?>
<form method="post" action="?" onsubmit="return check();" id="dform">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<div class="ls">
<table cellpadding="0" cellspacing="0" class="tb">
<tr>
<th width="20"><input type="checkbox" onclick="checkall(this.form);calculate();"/></th>
<th width="100">图片</th>
<th>商品</th>
<th width="150">下单时间</th>
<th width="100">数量</th>
<th width="150">订单金额</th>
<th width="40">订单</th>
</tr>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>" checked id="check_<?php echo $v['itemid'];?>" onclick="calculate(<?php echo $v['itemid'];?>)"/></td>
<td><a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="<?php if($v['thumb']) { ?><?php echo $v['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>
" width="60" height="60" onerror="this.src=errimg;" style="margin:10px;"/></a></td>
<td align="left"><a href="<?php echo $v['linkurl'];?>" target="_blank" class="t"><?php echo $v['title'];?></a>
<input type="hidden" id="money_<?php echo $v['itemid'];?>" value="<?php echo $v['money'];?>"/>
</td>
<td><?php echo $v['addtime'];?></td>
<td><?php echo $v['number'];?></td>
<td class="f_red"><?php echo $DT['money_sign'];?><?php echo $v['money'];?></td>
<td><a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=detail" target="_blank" class="t">详情</a>
</tr>
<?php } } ?>
</table>
</div>
<br/>
<table cellspacing="1" cellpadding="6" class="tb">
<tr>
<td class="tl">商品数量</td>
<td class="tr"><span id="total_good"></span></td>
</tr>
<tr>
<td class="tl">应付金额</td>
<td class="tr"><span class="f_red" id="total_amount"></span> <?php echo $DT['money_unit'];?></td>
</tr>
<tr>
<td class="tl">账户余额</td>
<td class="tr"><span class="f_blue"><?php echo $_money;?></span> <?php echo $DT['money_unit'];?></td>
</tr>
<tr id="payword" style="display:none;">
<td class="tl"><span class="f_red">*</span> 支付密码</td>
<td class="tr"><?php include template('password', 'chip');?>&nbsp;<span id="dpassword" class="f_red"></span></td>
</tr>
<?php if($DT['sms']) { ?>
<tr>
<td class="tl"></td>
<td class="tr"><input type="checkbox" name="sendsms" value="1"/> 短信通知卖家发货 (<a href="sms.php" target="_blank" class="t">我的可用短信 <strong class="f_blue"><?php echo $_sms;?></strong> 条</a>)</td>
</tr>
<?php } ?>
<tr>
<td class="tl">&nbsp;</td>
<td class="tr" height="50"><input type="submit" name="submit" value=" 立即支付 " class="btn_g"/></td>
</tr>
</table>
</form>
<script type="text/javascript">
var total = 0;
var itemids = [<?php if(is_array($lists)) { foreach($lists as $i => $t) { ?><?php if($i) { ?>,<?php } ?>
'<?php echo $t['itemid'];?>'<?php } } ?>];
function calculate(id) {
var _good = _amount = 0;
for(var i = 0; i < itemids.length; i++) {
var itemid = itemids[i];
if(Dd('check_'+itemid).checked) {
_good++;
_amount += parseFloat(Dd('money_'+itemid).value);
}
}
if(_good < 1) {
alert('至少需要选择一个订单');
Dd('check_'+(id ? id : itemid)).checked = true;
setTimeout('calculate()', 1000);
}
total = _amount;
Dd('total_good').innerHTML = _good;
Dd('total_amount').innerHTML = _amount.toFixed(2);
}
calculate();
function check() {
if(total > <?php echo $_money;?>) {
var k = '';
for(var i = 0; i < itemids.length; i++) {
var itemid = itemids[i];
if(Dd('check_'+itemid).checked) {
k += k ? ','+itemid : itemid;
}
}
Go('charge.php?action=pay&reason=trades|'+k+'&amount='+(total - <?php echo $_money;?>));
return false;
}
var f,l;
f = 'password';
l = Dd(f).value.length;
if(l < 6) {
Dmsg('请填写支付密码', f);
return false;
}
return true;
}
window.setInterval(
function() {
total > <?php echo $_money;?> ? Dh('payword') : Ds('payword');
},
500);
</script>
<script type="text/javascript">s('trade');m('action_order');</script>
<?php } else if($action == 'express') { ?>
<div class="tt">
<form action="?">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<?php echo $fields_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<select name="type">
<option value="0"<?php if($type==0) { ?> selected<?php } ?>
>交易类型</option>
<option value="1"<?php if($type==1) { ?> selected<?php } ?>
>发货（我是卖家）</option>
<option value="2"<?php if($type==2) { ?> selected<?php } ?>
>收货（我是买家）</option>
</select>&nbsp;
<?php echo $status_select;?>&nbsp;
<input type="submit" value=" 搜 索 " class="btn"/>&nbsp;
<input type="button" value=" 重 置 " class="btn" onclick="Go('?action=<?php echo $action;?>');"/><br/>
</div>
</form>
<div class="bd">
<table cellpadding="10" cellspacing="0" class="tb">
<tr bgcolor="#F2F2F2" align="center">
<td width="110">类型</td>
<td>快递公司</td>
<td>快递单号</td>
<td width="100">快递状态</td>
<td width="150">下单时间</td>
<td width="150">更新时间</td>
<td width="40">订单</td>
</tr>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<tr align="center">
<td><?php if($v['seller'] == $_username) { ?>发货（我是卖家）<?php } else { ?>收货（我是买家）<?php } ?>
</td>
<td><?php echo $v['send_type'];?></td>
<td title="快递追踪"><a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=express" class="t"><?php echo $v['send_no'];?></a></td>
<td><?php echo $v['dstatus'];?></td>
<td><?php echo $v['addtime'];?></td>
<td><?php echo $v['updatetime'];?></td>
<td><a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=detail" class="t">查看</a></td>
</tr>
<?php } } ?>
</table>
</div>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">s('trade');m('action_express');</script>
<?php } else if($action == 'order') { ?>
<div class="tt">
<form action="?">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<?php echo $fields_select;?>&nbsp;
<input type="text" size="10" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $status_select;?>&nbsp;
<?php echo dcalendar('fromtime', $fromtime);?> 至 <?php echo dcalendar('totime', $totime);?>&nbsp;
<input type="submit" value=" 搜 索 " class="btn"/>&nbsp;
<input type="button" value=" 重 置 " class="btn" onclick="Go('?action=<?php echo $action;?>');"/><br/>
<div class="b10"></div>
<div>
<?php if(!$DT['trade']) { ?>
<span class="f_r"><input type="button" value=" 批量付款 " title="点击选择待付款订单，批量支付" class="btn_g" onclick="Go('?action=muti');"/></span>
<?php } ?>
单号：<input type="text" size="10" name="itemid" value="<?php echo $itemid;?>"/>&nbsp;
商品ID：<input type="text" size="10" name="mallid" value="<?php echo $mallid;?>"/>&nbsp;
卖家：<input type="text" size="20" name="seller" value="<?php echo $seller;?>"/>&nbsp;
<input type="checkbox" name="cod" value="1"<?php if($cod) { ?> checked<?php } ?>
/>货到付款&nbsp;
</div>
</div>
</form>
<div class="nav">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="<?php if(!in_array($nav, array(0,1,2,3,4,5,6))) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>">全部订单</a></td>
<td class="<?php if($nav==0) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=0">待确认 <span>(<?php echo $db->count($table, "buyer='$_username' AND status=0");?>)</span></a></td>
<td class="<?php if($nav==1) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=1">待付款 <span>(<?php echo $db->count($table, "buyer='$_username' AND status=1");?>)</span></a></td>
<td class="<?php if($nav==2) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=2">待发货 <span>(<?php echo $db->count($table, "buyer='$_username' AND status=2");?>)</span></a></td>
<td class="<?php if($nav==3) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=3">待收货 <span>(<?php echo $db->count($table, "buyer='$_username' AND status=3");?>)</span></a></td>
<td class="<?php if($nav==5) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=5">待退款 <span>(<?php echo $db->count($table, "buyer='$_username' AND status=5");?>)</span></a></td>
<td class="<?php if($nav==6) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=6">已退款 <span>(<?php echo $db->count($table, "buyer='$_username' AND status=6");?>)</span></a></td>
<td class="<?php if($nav==4) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=4">待评价 <span>(<?php echo $db->count($table, "buyer='$_username' AND status=4 AND seller_star=0");?>)</span></a></td>
<td>&nbsp;</td>
</tr>
</table>
</div>
<div class="bd">
<table cellpadding="6" cellspacing="0" class="tb">
<tr bgcolor="#F2F2F2" align="center">
<td height="22">商品信息</td>
<td width="60">数量</td>
<td width="120">订单金额</td>
<td width="100">下单时间</td>
<td width="100">商家</td>
<td width="120">订单状态</td>
</tr>
</table>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<table cellpadding="6" cellspacing="0" class="tb">
<tr bgcolor="#F5F5F5">
<td height="22" colspan="7" class="f_gray">
<span class="f_r">
<?php if($v['status'] == 0) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=close" onclick="return confirm('确实要关闭此交易吗？此操作将不可撤销');">关闭交易</a> |
<?php } else if($v['status'] == 1) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=pay">立即付款</a> |
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=close" onclick="return confirm('确实要关闭此交易吗？此操作将不可撤销');">关闭交易</a> |
<?php } else if($v['status'] == 2) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=remind">提醒发货</a> |
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=refund">申请退款</a> |
<?php } else if($v['status'] == 3) { ?>
<?php if($v['lefttime']) { ?>
<span class="f_blue" title="如果逾期未处理，系统将自动付款给卖家"><img src="<?php echo DT_STATIC;?>file/image/clock.gif" width="12" height="12"/> 距处理此订单还剩<?php echo $v['lefttime'];?></span>&nbsp;
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=receive_goods" onclick="return confirm('确认已收到货且质量与数量无误吗？\n\n请注意:确认后您的钱将直接支付给卖家');">确认到货</a> |
<?php if($v['send_type'] && $v['send_no']) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=express">快递追踪</a> |
<?php } ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=refund">申请退款</a> |
<?php } else { ?>
<span class="f_red">订单处理已超时，等待卖家收款</span>&nbsp;
<?php } ?>
<?php } else if($v['status'] == 4) { ?>
<?php if($v['mid'] == 16) { ?>
<?php if($v['seller_star']) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=comment_detail">评价详情</a> |
<?php } else { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=comment">评价</a> |
<?php } ?>
<?php } ?>
<?php } else if($v['status'] == 9) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=close" onclick="return confirm('确实要删除此交易吗？此操作将不可撤销');">删除订单</a> |
<?php } ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=detail">订单详情</a>&nbsp;
</span>
&nbsp;订单号：<?php echo $v['itemid'];?>
</td>
</tr>
<tr align="center">
<td width="70"><a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="<?php if($v['thumb']) { ?><?php echo $v['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>
" width="60" height="60" onerror="this.src=errimg;"/></a></td>
<td align="left" valign="top" class="f_gray lh18"><a href="<?php echo $v['linkurl'];?>" target="_blank" class="t"><?php echo $v['title'];?></a><br/><?php echo $v['par'];?></td>
<td width="60"><?php echo $v['number'];?></td>
<td width="120"><?php echo $DT['money_sign'];?><?php echo $v['money'];?></td>
<td width="100"><?php echo $v['addtime'];?></td>
<td width="100"><div style="margin-bottom:15px;"><a href="<?php echo userurl($v['seller'], 'file=contact');?>" target="_blank"><?php echo $v['seller'];?></a></div><?php if($DT['im_web']) { ?><?php echo im_web($v['seller'].'&mid=16&itemid='.$v['mallid']);?> <?php } ?>
<a href="message.php?action=send&touser=<?php echo $v['seller'];?>"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/ico_message.gif" title="发送站内信" align="absmiddle"/></a></td>
<td width="120">
<?php echo $v['dstatus'];?>
<?php if($v['status'] == 1) { ?>
<?php if($DT['trade']) { ?>
<div style="margin-top:10px;"><a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=pay" target="_blank"><img src="<?php echo DT_PATH;?>api/trade/<?php echo $DT['trade'];?>/pay.gif" align="absmiddle" title="<?php echo $DT['trade_nm'];?>付款"/></a></div>
<?php } else { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=pay"><span class="trade_step">付款</span></a>
<?php } ?>
<?php } else if($v['status'] == 3) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=receive_goods" onclick="return confirm('确认已收到货且质量与数量无误吗？\n\n请注意:确认后您的钱将直接支付给卖家');"><span class="trade_step">收货</span></a>
<?php } else if($v['status'] == 4) { ?>
<?php if($v['mid'] == 16 && !$v['seller_star']) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=comment"><span class="trade_step">评价</span></a>
<?php } ?>
<?php } ?>
</td>
</tr>
</table>
<br/>
<?php } } ?>
</div>
<div class="pages"><?php echo $pages;?></div>
<script type="text/javascript">s('trade');m('action_order');</script>
<?php } else { ?>
<?php if($MG['trade_sell']) { ?>
<div class="tt">
<form action="?">
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<?php echo $fields_select;?>&nbsp;
<input type="text" size="10" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $status_select;?>&nbsp;
<?php echo dcalendar('fromtime', $fromtime);?> 至 <?php echo dcalendar('totime', $totime);?>&nbsp;
<input type="submit" value=" 搜 索 " class="btn"/>&nbsp;
<input type="button" value=" 重 置 " class="btn" onclick="Go('?action=<?php echo $action;?>');"/><br/>
<div class="b10"></div>
单号：<input type="text" size="10" name="itemid" value="<?php echo $itemid;?>"/>&nbsp;
商品ID：<input type="text" size="10" name="mallid" value="<?php echo $mallid;?>"/>&nbsp;
买家：<input type="text" size="20" name="buyer" value="<?php echo $buyer;?>"/>&nbsp;
<input type="checkbox" name="cod" value="1"<?php if($cod) { ?> checked<?php } ?>
/>货到付款&nbsp;
</form>
</div>
<div class="nav">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="<?php if(!in_array($nav, array(0,1,2,3,4,5,6))) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>">全部订单</a></td>
<td class="<?php if($nav==0) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=0">待确认 <span>(<?php echo $db->count($table, "seller='$_username' AND status=0");?>)</span></a></td>
<td class="<?php if($nav==1) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=1">待付款 <span>(<?php echo $db->count($table, "seller='$_username' AND status=1");?>)</span></a></td>
<td class="<?php if($nav==2) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=2">待发货 <span>(<?php echo $db->count($table, "seller='$_username' AND status=2");?>)</span></a></td>
<td class="<?php if($nav==3) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=3">待收货 <span>(<?php echo $db->count($table, "seller='$_username' AND status=3");?>)</span></a></td>
<td class="<?php if($nav==5) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=5">待退款 <span>(<?php echo $db->count($table, "seller='$_username' AND status=5");?>)</span></a></td>
<td class="<?php if($nav==6) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=6">已退款 <span>(<?php echo $db->count($table, "seller='$_username' AND status=6");?>)</span></a></td>
<td class="<?php if($nav==4) { ?>nav_2<?php } else { ?>nav_1<?php } ?>
"><a href="?action=<?php echo $action;?>&nav=4">待评价 <span>(<?php echo $db->count($table, "seller='$_username' AND status=4 AND buyer_star=0");?>)</span></a></td>
</tr>
</table>
</div>
<div class="bd">
<table cellpadding="6" cellspacing="0" class="tb">
<tr bgcolor="#F2F2F2" align="center">
<td height="22">商品信息</td>
<td width="60">数量</td>
<td width="120">订单金额</td>
<td width="100">下单时间</td>
<td width="100">买家</td>
<td width="120">订单状态</td>
</tr>
</table>
<?php if(is_array($lists)) { foreach($lists as $k => $v) { ?>
<table cellpadding="6" cellspacing="0" class="tb">
<tr bgcolor="#F5F5F5">
<td height="22" colspan="7" class="f_gray">
<span class="f_r">
<?php if($v['status'] == 0) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=edit_price&confirm=1">确认订单</a> |
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=edit_price">修改订单</a> |
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=close" onclick="return confirm('确实要关闭此交易吗？此操作将不可撤销');">关闭交易</a> |
<?php } else if($v['status'] == 1) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=edit_price">修改订单</a> |
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=close" onclick="return confirm('确实要关闭此交易吗？此操作将不可撤销');">关闭交易</a> |
<?php } else if($v['status'] == 2) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=send_goods">确认发货</a> |
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=print" target="_blank">打印订单</a> |
<?php } else if($v['status'] == 3) { ?>
<?php if($v['lefttime']) { ?>
<span class="f_blue"><img src="<?php echo DT_STATIC;?>file/image/clock.gif" width="12" height="12"/> 距买家处理订单还剩<?php echo $v['lefttime'];?></span>&nbsp;
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=add_time">延长时间</a> |
<?php } else { ?>
<span class="f_blue">买家处理订单超时</span>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=get_pay">直接收款</a> |
<?php } ?>
<?php if($v['send_type'] && $v['send_no']) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=express">快递追踪</a> |
<?php } ?>
<?php } else if($v['status'] == 4) { ?>
<?php if($v['mid'] == 16) { ?>
<?php if($v['buyer_star']) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=comment_detail">评价详情</a> |
<?php } else { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=comment">评价</a> |
<?php } ?>
<?php } ?>
<?php } else if($v['status'] == 5) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=refund_agree">同意退款</a> |
<?php } else if($v['status'] == 7) { ?>
<?php if($v['send_time']) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=cod_success" onclick="return confirm('您确定已经收到货款，交易完成吗？此操作将不可撤销');">确认完成</a> |
<?php } else { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=send_goods">确认发货</a> |
<?php } ?>
<?php } else if($v['status'] == 8) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=close" onclick="return confirm('确实要删除此订单吗？此操作将不可撤销');">删除订单</a> |
<?php } ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=detail">订单详情</a>&nbsp;
</span>
&nbsp;订单号：<?php echo $v['itemid'];?>
</td>
</tr>
<tr align="center">
<td width="70"><a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="<?php if($v['thumb']) { ?><?php echo $v['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>
" width="60" height="60" onerror="this.src=errimg;"/></a></td>
<td align="left" valign="top" class="f_gray lh18"><a href="<?php echo $v['linkurl'];?>" target="_blank" class="t"><?php echo $v['title'];?></a><br/><?php echo $v['par'];?></td>
<td width="60"><?php echo $v['number'];?></td>
<td width="120"><?php echo $DT['money_sign'];?><?php echo $v['money'];?></td>
<td width="100"><?php echo $v['addtime'];?></td>
<td width="100"><div style="margin-bottom:15px;"><a href="<?php echo userurl($v['buyer'], 'file=contact');?>" target="_blank"><?php echo $v['buyer'];?></a></div><?php if($DT['im_web']) { ?><?php echo im_web($v['buyer'].'&mid=16&itemid='.$v['mallid']);?> <?php } ?>
<a href="message.php?action=send&touser=<?php echo $v['buyer'];?>"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/ico_message.gif" title="发送站内信" align="absmiddle"/></a></td>
<td width="120">
<?php echo $v['dstatus'];?>
<?php if($v['status'] == 0) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=edit_price&confirm=1"><span class="trade_step">确认</span></a>
<?php } else if($v['status'] == 2) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=send_goods"><span class="trade_step">发货</span></a>
<?php } else if($v['status'] == 4) { ?>
<?php if($v['mid'] == 16 && !$v['buyer_star']) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=comment"><span class="trade_step">评价</span></a>
<?php } ?>
<?php } else if($v['status'] == 5) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=refund_agree"><span class="trade_step">退款</span></a>
<?php } else if($v['status'] == 10) { ?>
<?php if($v['send_time']) { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=cod_success" onclick="return confirm('您确定已经收到货款，交易完成吗？此操作将不可撤销');"><span class="trade_step">完成</span></a>
<?php } else { ?>
<a href="?itemid=<?php echo $v['itemid'];?>&action=update&step=send_goods"><span class="trade_step">发货</span></a>
<?php } ?>
<?php } ?>
</td>
</tr>
</table>
<br/>
<?php } } ?>
</div>
<div class="pages"><?php echo $pages;?></div>
<?php } else { ?>
<br/><br/><br/><br/><br/>
<center class="px14">当前共收到 <span class="f_red"><?php echo $orders;?></span> 个订单，请<a href="grade.php" class="t">升级您的会员级别</a>获取查看权限</center>
<?php } ?>
<script type="text/javascript">s('trade');m('action');</script>
<?php } ?>
<?php include template('footer', $module);?>
<tr>
<td class="tl"><span class="f_red">*</span>注册号</td>
<td class="tr"><input type="text" size="30" name="post[register]" id="register" value="<?php echo $register;?>" maxlength="250"/><?php if(in_array('register', $_E)) { ?>&nbsp;<?php if(isset($_U['register'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dregister" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>注册地址</td>
<td class="tr"><input type="text" size="80" name="post[readdress]" id="readdress" value="<?php echo $readdress;?>" maxlength="250"/><?php if(in_array('readdress', $_E)) { ?>&nbsp;<?php if(isset($_U['readdress'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dreaddress" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>公司成立年份</td>
<td class="tr"><input type="text" size="15" name="post[regyear]" id="regyear" value="<?php echo $regyear;?>" maxlength="4"/><?php if(in_array('regyear', $_E)) { ?>&nbsp;<?php if(isset($_U['regyear'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dregyear" class="f_red"></span> <span class="f_gray">(年份，如：2004)</span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>注册日期</td>
<td class="tr"><?php echo dcalendar('retime', '');?><?php if(in_array('retime', $_E)) { ?>&nbsp;<?php if(isset($_U['retime'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dretime" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>营业期限</td>
<td class="tr"><?php echo dcalendar('starttime', '');?> 至 <?php echo dcalendar('endtime', '');?>&nbsp;</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>法定代表人</td>
<td class="tr"><input type="text" size="80" name="post[legalPerson]" id="legalPerson" value="<?php echo $legalPerson;?>" maxlength="250"/><?php if(in_array('legalPerson', $_E)) { ?>&nbsp;<?php if(isset($_U['legalPerson'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dlegalPerson" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span>公司成立年份</td>
<td class="tr"><input type="text" size="15" name="post[regyear]" id="regyear" value="<?php echo $regyear;?>" maxlength="4"/><?php if(in_array('regyear', $_E)) { ?>&nbsp;<?php if(isset($_U['regyear'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
&nbsp;<span id="dregyear" class="f_red"></span> <span class="f_gray">(年份，如：2004)</span></td>
</tr>
<tr>
<td class="tl">经营模式</td>
<td class="tr">
<span id="com_mode"><?php echo $mode_check;?></span> <span class="f_gray">(最多可选<?php echo $MOD['mode_max'];?>种)</span></td>
</tr>
<tr>
<td class="tl">公司规模</td>
<td class="tr"><?php echo dselect($COM_SIZE, 'post[size]', '请选择规模', $size, '', 0);?></td>
</tr>
<tr>
<td class="tl">注册资本</td>
<td class="tr"><?php echo dselect($MONEY_UNIT, 'post[regunit]', '', $regunit, '', 0);?> <input type="text" size="6" name="post[capital]" id="capital" value="<?php echo $capital;?>"/> 万<?php if(in_array('capital', $_E)) { ?>&nbsp;<?php if(isset($_U['capital'])) { ?><span class="f_red">审核中</span><?php } else { ?><span class="f_gray">需审核</span><?php } ?>
<?php } ?>
</td>
</tr>
