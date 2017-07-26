<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
if(!$id) show_menu($menus);
?>
<div class="tt">商品信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">订单单号</td>
<td><?php echo $td['itemid'];?> <?php if($DT['trade']) { ?>(<?php echo $DT['trade_nm'];?>订单单号:<a href="https://lab.alipay.com/consume/queryTradeDetail.htm?tradeNo=<?php echo $td['trade_no'];?>" target="_blank" class="t"><?php echo $td['trade_no'];?></a>)<?php } ?></td>
</tr>
<tr>
<td class="tl">商品名称</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank" class="t"><?php echo $td['title'];?></a></td>
</tr>
<tr>
<td class="tl">商品图片</td>
<td class="tr"><a href="<?php echo $td['linkurl'];?>" target="_blank"><img src="<?php if($td['thumb']) { ?><?php echo $td['thumb'];?><?php } else { ?><?php echo DT_SKIN;?>image/nopic60.gif<?php } ?>" width="60" height="60"/></a></td>
</tr>
<?php if($td['par']) { ?>
<tr>
<td class="tl">规格参数</td>
<td><?php echo $td['par'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">卖家</td>
<td><?php if($DT['im_web']) { ?><?php echo im_web($td['seller']);?>&nbsp;<?php } ?><a href="javascript:_user('<?php echo $td['seller'];?>');" class="t"><?php echo $td['seller'];?></a></td>
</tr>
<tr>
<td class="tl">买家</td>
<td><?php if($DT['im_web']) { ?><?php echo im_web($td['buyer']);?>&nbsp;<?php } ?><a href="javascript:_user('<?php echo $td['buyer'];?>');" class="t"><?php echo $td['buyer'];?></a></td>
</tr>
</table>
<div class="tt">快递信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">邮编</td>
<td><?php echo $td['buyer_postcode'];?></td>
</tr>
<tr>
<td class="tl">地址</td>
<td><?php echo $td['buyer_address'];?></td>
</tr>
<tr>
<td class="tl">姓名</td>
<td><?php echo $td['buyer_name'];?></td>
</tr>
<tr>
<td class="tl">电话</td>
<td><?php echo $td['buyer_phone'];?></td>
</tr>
<tr>
<td class="tl">手机</td>
<td><?php echo $td['buyer_mobile'];?></td>
</tr>
<?php if($td['send_time'] > 0) { ?>
<tr>
<td class="tl">快递类型</td>
<td><a href="<?php echo DT_PATH;?>api/express/home.php?e=<?php echo urlencode($td['send_type']);?>&n=<?php echo $td['send_no'];?>" target="_blank"><?php echo $td['send_type'];?></a></td>
</tr>
<tr>
<td class="tl">快递单号</td>
<td><a href="<?php echo DT_PATH;?>api/express.php?e=<?php echo urlencode($td['send_type']);?>&n=<?php echo $td['send_no'];?>" target="_blank"><?php echo $td['send_no'];?></a></td>
</tr>
<?php if($td['send_type'] && $td['send_no']) { ?>
<tr>
<td class="tl">追踪结果</td>
<td style="line-height:200%;"><div id="express"><img src="<?php echo DT_SKIN;?>image/loading.gif" align="absmiddle"/> 正在查询...</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#express').load(AJPath+'?action=express&moduleid=2&auth=<?php echo encrypt('mall|'.$td['send_type'].'|'.$td['send_no'].'|'.$td['send_status'].'|'.$td['itemid'], DT_KEY.'EXPRESS');?>');
});
</script>
</td>
</tr>
<?php } ?>
<?php } ?>
<tr>
<td class="tl">买家留言</td>
<td><?php echo $td['note'];?></td>
</tr>
</table>
<div class="tt">价格信息</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">单价</td>
<td><?php echo $DT['money_sign'];?><?php echo $td['price'];?></td>
</tr>
<tr>
<td class="tl">数量</td>
<td><?php echo $td['number'];?></td>
</tr>
<?php if($td['fee']>0) { ?>
<tr>
<td class="tl"><?php echo $td['fee_name'];?></td>
<td><?php echo $DT['money_sign'];?><?php echo $td['fee'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">总额</td>
<td class="f_red"><?php echo $DT['money_sign'];?><?php echo $td['money'];?></td>
</tr>
</table>
<div class="tt">订单操作记录</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">修改价格记录者</td>
<td class="f_red"><?php echo $td['eprice_chil'];?></td>
<td class="tl">修改价格发货记录时间</td>
<td><?php echo $td['eprice_time'];?></td>
</tr>
<tr>
<td class="tl">确认订单记录</td>
<td class="f_red"><?php echo $td['confirm_chil'];?></td>
<td class="tl">确认记录订单时间</td>
<td><?php echo $td['confirm_time'];?></td>
</tr>
<tr>
<td class="tl">确认发货记录</td>
<td class="f_red"><?php echo $td['send_chil'];?></td>
<td class="tl">确认发货记录时间</td>
<td><?php echo $td['send_time'];?></td>
</tr>
</table>
<div class="tt">订单状态</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">下单时间</td>
<td><?php echo $td['adddate'];?></td>
</tr>
<tr>
<td class="tl">更新时间</td>
<td><?php echo $td['updatedate'];?></td>
</tr>
<tr>
<td class="tl">备注说明</td>
<td><?php echo $item['note'];?></td>
</tr>
<tr>
<td class="tl">金额</td>
<td class="f_red"><?php echo $item['amount'];?></td>
</tr>
<?php if($item['send_time']>0) { ?>
<tr>
<td class="tl"><?php echo $item['fee_name'];?></td>
<td class="f_blue"><?php echo $item['fee'];?></td>
</tr>
<?php } ?>
<tr>
<td class="tl">数量</td>
<td><?php echo $item['number'];?></td>
</tr>
<tr>
<td class="tl">总额</td>
<td class="f_red f_b"><?php echo $item['money'];?></td>
</tr>
<tr>
<td class="tl">物流类型</td>
<td><?php echo $item['send_type'];?></td>
</tr>
<tr>
<td class="tl">物流号码</td>
<td><?php echo $item['send_no'];?></td>
</tr>
<tr>
<td class="tl">发货时间</td>
<td><?php echo $item['send_time'];?></td>
</tr>
<tr>
<td class="tl">结算方式</td>
<td><?php if($item[paystep]=='0'||$item[paystep]==''){?>买家结算,卖家发货<?php } elseif ($item[paystep]=='1'){?>天成官方财务结算流程<?php }else{?>天成官方结算并加入CRM<?php } ?></td>
</tr>
<?php if($item['p_content']!=''){ ?>
<tr>
<td class="tl">业务部<br>费用支配信息</td>
<td>
<?php echo $item['p_content']; ?>
</td>
</tr>
<?php } ?>
<?php if($item[paystep]>0){?><tr>
<td class="tl">已回款金额</td>
<td><?php echo $item['f_send']?>&nbsp;</td>
</tr>
<?php if($item[status]<4){?>
<tr>
<td class="tl">财务反馈<br>回款信息</td>
<td>
<form method="post" action="?" >
<input type="hidden" name="action" value="upf"/>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="status" value="<?php echo $item['status'];?>"/>
<input type="hidden" name="touser" value="<?php echo $item['seller'];?>"/>
<input type="hidden" name="buyer" value="<?php echo $item['buyer'];?>"/>
<input type="hidden" name="itemid" value='<?php echo $item['itemid']?>'>
输入买家<a href="javascript:_user('<?php echo $item['buyer'];?>');" class="t"><?php echo $item['buyer'];?></a>的回款<input type="text" size="6" name="payto" value="0" onblur='if(parseFloat(this.value)+parseFloat(<?php echo $item['f_send']?>)><?php echo $item['money'];?>){alert("你的回款金额"+this.value+"+历史回款<?php echo $item['f_send']?>>订单的金额<?php echo $item['money'];?>，请修改回款金额!");this.value=0}'>&nbsp;元！<br>
<textarea name="f_content" rows="5" cols="65"><?php if($item['f_content']){echo $item['f_content'];}else{echo "备注本次订单的回款内容";}?></textarea><br>
<input type="submit" value='确认提交信息'>
</form>
</td>
</tr>
<?php }else{?>
<tr>
<td class="tl">确认支配单内容</td>
<td>
<?php if($item[f_pay]<1){?>
<form method="post" action="?" >
<input type="hidden" name="action" value="upt"/>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="status" value="<?php echo $item['status'];?>"/>
<input type="hidden" name="touser" value="<?php echo $item['seller'];?>"/>
<input type="hidden" name="buyer" value="<?php echo $item['buyer'];?>"/>
<input type="hidden" name="itemid" value='<?php echo $item['itemid']?>'>
<input type="checkbox" name="f_pay" value='1'> 确认已经将支配单进行处理！
<input type="submit" value='确认'>
</form>
<?php }else{?>已经进行支配单操作
<?php }?>
</td>
</tr>
<?php }

}?>
<?php if($item[f_pay]<1){?>
<tr>
<td class="tl">支配单操作</td>
<td>
<a href="javascript:void(0)" onclick="Dwindow('?moduleid=2&file=record&action=add','金币操作',700,400)"><b class='f_red'>金币操作</b></a>
</td>
</tr>
<?php } ?>
<tr>
<td class="tl">交易状态</td>
<td><?php echo $_status[$td['status']];?></td>
</tr>
<?php if($td['buyer_reason']) { ?>
<tr>
<td class="tl">退款原因</td>
<td><?php echo $td['buyer_reason'];?></td>
</tr>
<?php } ?>
<?php if($td['refund_reason']) { ?>
<tr>
<td class="tl">操作原因</td>
<td><?php echo $td['refund_reason'];?></td>
</tr>
<tr>
<td class="tl">操作人</td>
<td><?php echo $td['editor'];?></td>
</tr>
<tr>
<td class="tl">操作时间</td>
<td><?php echo $td['updatetime'];?></td>
</tr>
<?php } ?>
</table>

<div class="tt">买家评价<a name="comment1"></a></div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php if($cm['seller_star']) { ?>
<tr>
<td class="tl">买家评分</td>
<td>
<span class="f_r"><a href="#comment" onclick="Ds('c_edit');" class="t">[修改]</a></span>
<img src="<?php echo DT_PATH;?>file/image/star<?php echo $cm['seller_star'];?>.gif" width="36" height="12" alt="" align="absmiddle"/> <?php echo $STARS[$cm['seller_star']];?>
</td>
</tr>
<tr>
<td class="tl">买家评论</td>
<td><?php echo nl2br($cm['seller_comment']);?></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td class="px11"><?php echo timetodate($cm['seller_ctime'], 6);?></td>
</tr>
<?php if($cm['buyer_reply']) { ?>
<tr>
<td class="tl">卖家解释</td>
<td style="color:#D9251D;"><?php echo nl2br($cm['buyer_reply']);?></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td class="px11"><?php echo timetodate($cm['buyer_rtime'], 6);?></td>
</tr>
<?php } ?>
<?php } else { ?>
<tr>
<td class="tl">买家评论</td>
<td>暂未评论</td>
</tr>
<?php } ?>
</table>

<div class="tt">卖家评价<a name="comment2"></a></div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php if($cm['buyer_star']) { ?>
<tr>
<td class="tl">卖家评分</td>
<td>
<span class="f_r"><a href="#comment" onclick="Ds('c_edit');" class="t">[修改]</a></span>
<img src="<?php echo DT_PATH;?>file/image/star<?php echo $cm['buyer_star'];?>.gif" width="36" height="12" alt="" align="absmiddle"/> <?php echo $STARS[$cm['buyer_star']];?>
</td>
</tr>
<tr>
<td class="tl">卖家评论</td>
<td><?php echo nl2br($cm['buyer_comment']);?></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td class="px11"><?php echo timetodate($cm['buyer_ctime'], 6);?></td>
</tr>
<?php if($cm['seller_reply']) { ?>
<tr>
<td class="tl">买家解释</td>
<td style="color:#D9251D;"><?php echo nl2br($cm['seller_reply']);?></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td class="px11"><?php echo timetodate($cm['seller_rtime'], 6);?></td>
</tr>
<?php } ?>
<?php } else { ?>
<tr>
<td class="tl">卖家评论</td>
<td>暂未评论</td>
</tr>
<?php } ?>
</table>

<div id="c_edit" style="display:none;">
<div class="tt">修改评价<a name="comment"></a></div>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="comment"/>
<input type="hidden" name="mallid" value="<?php echo $mallid;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">买家评分</td>
<td>
<input type="radio" name="post[seller_star]" value="3"<?php echo $cm['seller_star'] == 3 ? ' checked' : '';?>/> 好评 
<input type="radio" name="post[seller_star]" value="2"<?php echo $cm['seller_star'] == 2 ? ' checked' : '';?>/> 中评 
<input type="radio" name="post[seller_star]" value="1"<?php echo $cm['seller_star'] == 1 ? ' checked' : '';?>/> 差评 
<input type="radio" name="post[seller_star]" value="0"<?php echo $cm['seller_star'] == 0 ? ' checked' : '';?>/> 待评
</td>
</tr>
<tr>
<td class="tl">买家评论</td>
<td><textarea name="post[seller_comment]" style="width:300px;height:60px;"><?php echo $cm['seller_comment'];?></textarea></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td><input type="text" style="width:150px;" name="post[seller_ctime]" value="<?php echo $cm['seller_ctime'] ? timetodate($cm['seller_ctime'], 6) : '';?>"/></td>
</tr>
<tr>
<td class="tl">卖家解释</td>
<td><textarea name="post[buyer_reply]" style="width:300px;height:60px;"><?php echo $cm['buyer_reply'];?></textarea></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td><input type="text" style="width:150px;" name="post[buyer_rtime]" value="<?php echo $cm['buyer_rtime'] ? timetodate($cm['buyer_rtime'], 6) : '';?>"/></td>
</tr>

<tr>
<td class="tl">卖家评分</td>
<td>
<input type="radio" name="post[buyer_star]" value="3"<?php echo $cm['buyer_star'] == 3 ? ' checked' : '';?>/> 好评 
<input type="radio" name="post[buyer_star]" value="2"<?php echo $cm['buyer_star'] == 2 ? ' checked' : '';?>/> 中评 
<input type="radio" name="post[buyer_star]" value="1"<?php echo $cm['buyer_star'] == 1 ? ' checked' : '';?>/> 差评 
<input type="radio" name="post[buyer_star]" value="0"<?php echo $cm['buyer_star'] == 0 ? ' checked' : '';?>/> 待评
</td>
</tr>
<tr>
<td class="tl">卖家评论</td>
<td><textarea name="post[buyer_comment]" style="width:300px;height:60px;"><?php echo $cm['buyer_comment'];?></textarea></td>
</tr>
<tr>
<td class="tl">评论时间</td>
<td><input type="text" style="width:150px;" name="post[buyer_ctime]" value="<?php echo $cm['buyer_ctime'] ? timetodate($cm['buyer_ctime'], 6) : '';?>"/></td>
</tr>
<tr>
<td class="tl">买家解释</td>
<td><textarea name="post[seller_reply]" style="width:300px;height:60px;"><?php echo $cm['seller_reply'];?></textarea></td>
</tr>
<tr>
<td class="tl">解释时间</td>
<td><input type="text" style="width:150px;" name="post[seller_rtime]" value="<?php echo $cm['seller_rtime'] ? timetodate($cm['seller_rtime'], 6) : '';?>"/></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value=" 返 回 " class="btn" onclick="history.back(-1);"/></div>
</form>
</div>
<div class="tt">客服跟进<a name="comment"></a></div>
<form action="?" method="post">
<input type="hidden" name="file" value="<?php echo $file; ?>" />
<input type="hidden" name="moduleid" value="<?php echo $moduleid; ?>" />
<input type="hidden" name="action" value="edit" />
<input type="hidden" name="itemid" value="<?php echo $itemid; ?>" />
<input type="hidden" name="submit" value="1" />
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">订单状态</td>
<td>
	<?php foreach($dstatus as $k=>$v){ ?>
		<input type="radio" value="<?php echo $k; ?>" name="edit[status]" <?php if($k == $td['status']) echo 'checked'; ?> /><?php echo $v; ?>&nbsp;&nbsp;
	<?php } ?>
</td>
</tr>
<tr>
<td class="tl">客服状态</td>
<td>
	<input type="radio" value="0" name="edit[kefu_status]" <?php if($td['kefu_status'] == '0') echo 'checked=""'; ?> />未介入&nbsp;&nbsp;
	<input type="radio" value="1" name="edit[kefu_status]" <?php if($td['kefu_status'] == '1') echo 'checked=""'; ?> />处理中&nbsp;&nbsp;
	<input type="radio" value="2" name="edit[kefu_status]" <?php if($ke['fu_status'] == '2') echo 'checked=""'; ?> />已结束&nbsp;&nbsp;
</td>
</tr>
<tr>
<td class="tl">客服备注</td>
<td>
	<textarea name="edit[kefu_remark]" style="width:240px;height:120px"><?php echo $td['kefu_remark']; ?></textarea>
</td>
</tr>
<tr>
<td class="tl">最终结果</td>
<td>
	<textarea name="edit[kefu_result]" style="width:240px;height:120px"><?php echo $td['kefu_result']; ?></textarea>
</td>
</tr>
<tr>
	<td class="tl"></td>
	<td><input type="submit" name="" value=" 修 改 " class="btn" /></td>
</tr>
</table>
</form>
<script type="text/javascript">
function check() {
	return confirm('确定要修改该订单的评论吗？');
}
</script>
<script type="text/javascript">Menuon(1);</script>
<?php include tpl('footer');?>