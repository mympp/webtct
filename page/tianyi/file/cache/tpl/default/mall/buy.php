<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header');?>
<?php if($action == 'show') { ?>
<div class="m">
<div class="left_box">
<div class="m_toppos border_ff9c33">
<li class="buy_top_li"><span>核对订单信息</span></li>
</div>
<div style="padding:80px;" class="t_c px14 f_b"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/ok.gif" alt="" align="absmiddle"/>  订单提交成功！
&nbsp;&nbsp;&nbsp;<a href="<?php echo $MOD['linkurl'];?>" class="b">继续购物</a>&nbsp;&nbsp;&nbsp;<a href="<?php echo $forward;?>" class="b">支付订单</a></div>
<meta http-equiv="refresh" content="5;URL=<?php echo $forward;?>"/>
</div>
</div>
<?php } else { ?>
<script type="text/javascript">var errimg = '<?php echo DT_SKIN;?>image/nopic50.gif';</script>
<div class="m">
<div class="buy_box">
<?php if($lists) { ?>
<form method="post" action="<?php echo $MOD['linkurl'];?>buy.php" onsubmit="return check();">
<input type="hidden" name="submit" value="1"/>
<!--<div>-->
<!--<div class="f_r" style="padding:10px 50px 0 0;"><a href="<?php echo $MOD['linkurl'];?>cart.php" class="b">返回购物车重新挑选</a></div>-->
<!--&nbsp;&nbsp;<img src="<?php echo DT_SKIN;?>image/buy_1.gif" width="160" height="30" alt=""/>-->
<!--</div>-->
<div class="m_toppos border_ff9c33">
<li class="buy_top_li"><span>核对订单信息</span></li>
</div>
<div class="buy_div">
<div class="buy_title">
收货信息
</div>
<div class="buy_content">
<li class="default">
<div class="buy_c_title">
<div class="f_l">张三（广东省 广州市）</div>
<div class="f_r"><a href="#">编辑</a>　<a href="#">删除</a></div>
<div class="c_b"></div>
</div>
<div class="buy_c_content">
萝岗区高新技术产业开发区开源大道11号科技企
业加速器B8栋3楼　136****4776
</div>
<div class="is_default">
<span><a href="">默认</a></span>
</div>
</li>
<li>
<div class="buy_c_title">
<div class="f_l">张三（广东省 广州市）</div>
<div class="f_r"><a href="#">编辑</a>　<a href="#">删除</a></div>
<div class="c_b"></div>
</div>
<div class="buy_c_content">
萝岗区高新技术产业开发区开源大道11号科技企
业加速器B8栋3楼　136****4776
</div>
<div class="is_default">
<span><a href="">设为默认</a></span>
</div>
</li>
<li>
<div class="buy_c_title">
<div class="f_l">张三（广东省 广州市）</div>
<div class="f_r"><a href="#">编辑</a>　<a href="#">删除</a></div>
<div class="c_b"></div>
</div>
<div class="buy_c_content">
萝岗区高新技术产业开发区开源大道11号科技企
业加速器B8栋3楼　136****4776
</div>
<div class="is_default">
<span><a href="">设为默认</a></span>
</div>
</li>
<li class="notmargin add_address">
<div style="font-size: 30px;color: #dddddd;">+</div>
<div>添加新地址</div>
</li>
<div class="c_b"></div>
</div>
</div>
<div class="buy_div">
<div class="buy_title">
发票信息
</div>
<div class="buy_p_content">
<div class="invoice_type">
<ul>
<li>不开发票</li>
<li class="cursor">普通发票</li>
<li>增值税发票</li>
<li>电子发票</li>
<div class="c_b"></div>
</ul>
</div>
<div class="invoice_content">
<div class="invoice_common">
<ul>
<li><span>收票人：</span><input type="text" placeholder="请填写收票人姓名"></li>
<li><span>手机号：</span><input type="text" placeholder="请填写收票人手机号码"></li>
<li><span>发票抬头：</span><input type="text" placeholder="请填写发票抬头"></li>
<li>
<span>发票内容：</span>
<ul>
<li class="cursor">明细</li>
<li>办公用品</li>
<li>电脑配件</li>
<li>耗材</li>
<li>数码</li>
<li>电器</li>
</ul>
</li>
<div class="c_b"></div>
</ul>
</div>
<div class="invoice_tax" style="display: none">
<ul>
<li><span class="big_span">公司名称：</span></li>
<li><span>公司名称：</span><input type="text" placeholder="请输入公司名称"></li>
<li><span>纳税人识别号：</span><input type="text" placeholder="请输入纳税人识别号"></li>
<li><span>注册地址：</span><input type="text" placeholder="请输入注册地址"></li>
<li><span>注册电话：</span><input type="text" placeholder="请输入注册电话"></li>
<div class="c_b"></div>
</ul>
</div>
</div>
</div>
</div>
<div  class="buy_div">
<div class="buy_title">
确认商品
</div>
<div class="product_list">
<div class="p_title">
<ul>
<li class="width550">商品信息</li>
<li>单价(元)</li>
<li>数量</li>
<li>总金额</li>
<li>操作</li>
</ul>
</div>
<div class="p_content">
<?php $sum=$p_sum=$count=0?>
<?php if(is_array($lists)) { foreach($lists as $i => $t) { ?>
<?php $p_sum=$t['price']*$t['a'];$sum+=$p_sum;$count+=$t['a'];?>
<ul>
<li class="width550">
<a href="<?php echo $t['linkurl'];?>" target="_blank"><img src="<?php echo $t['thumb'];?>" alt="<?php echo $t['alt'];?>"  onerror="this.src=errimg;"/>
<?php echo $t['title'];?>
</a>
</li>
<li><?php echo $t['price'];?></li>
<li><?php echo $t['a'];?></li>
<li><span class="f_price"><?php echo $p_sum;?></span></li>
<li><a href="">删除</a></li>
</ul>
<?php } } ?>
</div>
</div>
</div>
<div class="not_bg_title">
订单备注：
</div>
<div class="confirm">
<div class="left margin_bottom20 f_l">
<textarea maxlength="200" placeholder="请输入您的特殊要求，限200字">
</textarea>
</div>
<div class="right margin_bottom20 f_r">
商品种类：<span><?php echo $i+1;?></span> 种　　数量：<span><?php echo $count;?></span> 件　　总金额： <span>￥<?php echo $sum;?></span><br>
优惠：　 　0.00<br>
运费： 　　0.00<br>
</div>
<div class="c_b"></div>
<div class="confirm_address">
寄送到：广东广州黄埔区高新技术产业开发区开源大道11号科技企业加速器B8栋3楼　　收货人：张三 136****4776<br>
<span class="color333">应付金额：</span>　 <span class="money">￥450.00</span>
</div>
<div style="text-align: right;padding: 10px 20px;">
<input class="button_sure" type="submit" value="确认提交"/>
</div>
</div>
<!--<div class="cart_foot" style="text-align:left;"><span class="f_r">共选中 <span class="f_red f_b px16" id="total_good"><?php echo $i+1;?></span> 种商品&nbsp;&nbsp;&nbsp;&nbsp; 总价：<span class="f_red f_b px16" id="total_amount"></span> <?php echo $DT['money_unit'];?></span>-->
<!--&nbsp;&nbsp;提示：实际的运费可能因为收货地址的不同而有差异，具体以提交之后系统计算或与卖家协商为准-->
<!--</div>-->
<!--<div class="">-->
<!--<table cellpadding="10" cellspacing="0" width="100%">-->
<!--<tr>-->
<!--<td><span class="f_red">*</span> 收货地址：</td>-->
<!--<td><?php echo ajax_area_select('add[areaid]', '请选择', $user['areaid']);?> <input type="text" size="60" name="add[address]" id="address" value="<?php echo $user['address'];?>"/> <span id="dareaid" class="f_red"></span><span id="daddress" class="f_red"></span></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td><span class="f_red">*</span> 邮政编码：</td>-->
<!--<td><input type="text" size="10" name="add[postcode]" id="postcode" value="<?php echo $user['postcode'];?>"/> <span id="dpostcode" class="f_red"></span></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td><span class="f_red">*</span> 真实姓名：</td>-->
<!--<td><input type="text" size="10" name="add[truename]" id="truename" value="<?php echo $user['truename'];?>"/> <span id="dtruename" class="f_red"></span></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td><span class="f_red">*</span> 手机号码：</td>-->
<!--<td><input type="text" size="20" name="add[mobile]" id="mobile" value="<?php echo $user['mobile'];?>"/> <span id="dmobile" class="f_red"></span></td>-->
<!--</tr>-->
<!--<tr>-->
<!--<td><span class="f_red">&nbsp;</span> 电话号码：</td>-->
<!--<td><input type="text" size="20" name="add[telephone]" id="telephone" value="<?php echo $user['telephone'];?>"/> <span id="dtelephone" class="f_red"></span></td>-->
<!--</tr>-->
<!--</table>-->
<!--</div>-->
<!--<div style="margin:10px 40px 10px 40px;" class="c_b">-->
<!--<div class="b10">&nbsp;</div>-->
<!--<div class="cart_foot" style="text-align:left;"><span class="f_r">共选中 <span class="f_red f_b px16" id="total_good"><?php echo $i+1;?></span> 种商品&nbsp;&nbsp;&nbsp;&nbsp; 总价：<span class="f_red f_b px16" id="total_amount"></span> <?php echo $DT['money_unit'];?></span>-->
<!--&nbsp;&nbsp;提示：实际的运费可能因为收货地址的不同而有差异，具体以提交之后系统计算或与卖家协商为准-->
<!--</div>-->
<!--</div>-->
<!--<div class="b10">&nbsp;</div>-->
<!--<div>&nbsp;&nbsp;<img src="<?php echo DT_SKIN;?>image/buy_2.gif" width="160" height="30" alt=""/></div>-->
<!--<div style="padding:20px;margin:10px 40px 20px 40px;background:#F4F4F4;" class="c_b px13">-->
<!--</div>-->
<!--<table cellpadding="0" cellspacing="0" width="100%">-->
<!--<tr align="center">-->
<!--<td width="480"><input type="image" src="<?php echo DT_SKIN;?>image/btn_buynow.gif" title="提交订单"/></td>-->
<!--<td width="480"><a href="<?php echo $MOD['linkurl'];?>" onclick="return confirm('订单尚未完成，确定要离开此页面吗？');"><img src="<?php echo DT_SKIN;?>image/btn_browse.gif" width="106" height="33" alt="继续购物"/></a></td>-->
<!--<td >&nbsp;</td>-->
<!--</tr>-->
<!--<tr align="center">-->
<!--<td class="f_gray">提交订单待卖家确认后，支付费用</td>-->
<!--<td class="f_gray">您也可以返回到<?php echo $MOD['name'];?>首页，继续挑选商品</td>-->
<!--<td height="50">&nbsp;</td>-->
<!--</tr>-->
<!--</table>-->
</form>
<?php } else { ?>
<div style="padding:80px;" class="t_c px14 f_b">您还没有挑选商品，赶快行动吧！马上去 <a href="<?php echo $MOD['linkurl'];?>" class="b">挑选商品</a></div>
<?php } ?>
</div>
</div>
<?php echo load('guest.js');?>
<script type="text/javascript">
function check() {
if(Dd('total_amount').innerHTML == '0.00') {
alert('订单总额为0.00，请检查商品数量');
window.scroll(0, 0);
return false;
}
var l;
var f;
f = 'areaid_1';
if(Dd(f).value == 0) {
Dmsg('请选择所在地区', 'areaid', 1);
return false;
}
f = 'address';
l = Dd(f).value.length;
if(l < 5) {
Dmsg('请填写街道地址', f);
return false;
}
f = 'postcode';
l = Dd(f).value.length;
if(l < 6) {
Dmsg('请填写邮政编码', f);
return false;
}
f = 'truename';
l = Dd(f).value.length;
if(l < 2) {
Dmsg('请填写真实姓名', f);
return false;
}
f = 'mobile';
l = Dd(f).value.length;
if(l < 11) {
Dmsg('请填写手机号码', f);
return false;
}
return true;
}
function Adr(s) {
var t = s.split('|');
try {
Dd('address').value = t[1];
Dd('postcode').value = t[2];
Dd('truename').value = t[3];
Dd('mobile').value = t[4];
Dd('telephone').value = t[5];
load_area(t[0], 1);
}
catch (e) {}
}
<?php if($address) { ?>Adr(Dd('addr_0').value);<?php } ?>
function alter(i, t) {
if(t == '+') {
var maxa = parseFloat(Dd('amount_'+i).value);
if(maxa && Dd('number_'+i).value >= maxa) return;
Dd('number_'+i).value =  parseInt(Dd('number_'+i).value) + 1;
} else {
var mina = parseFloat(Dd('a1_'+i).value);
if(Dd('number_'+i).value <= mina) return;
Dd('number_'+i).value = parseInt(Dd('number_'+i).value) - 1;
}
calculate();
}
function get_price(i) {
if(Dd('a2_'+i).value > 0) {
if(Dd('a3_'+i).value > 1 && parseInt(Dd('number_'+i).value) > parseInt(Dd('a3_'+i).value)) return Dd('p3_'+i).value;
if(Dd('a2_'+i).value > 1 && parseInt(Dd('number_'+i).value) > parseInt(Dd('a2_'+i).value)) return Dd('p2_'+i).value;
}
return Dd('p1_'+i).value
}
function calculate() {
var itemids = [<?php if(is_array($lists)) { foreach($lists as $i => $t) { ?><?php if($i) { ?>,<?php } ?>
'<?php echo $t['key'];?>'<?php } } ?>];
var _good = itemid = 0;
for(var i = 0; i < itemids.length; i++) {
itemid = itemids[i];
var num, good, maxa, mina, price;
num = parseInt(Dd('number_'+itemid).value);
maxa = parseInt(Dd('amount_'+itemid).value);
mina = parseInt(Dd('a1_'+itemid).value);
if(num < mina) Dd('number_'+itemid).value = num = mina;
if(num > maxa) Dd('number_'+itemid).value = num = maxa;
if(isNaN(num) || num < 0) Dd('number_'+itemid).value = num = mina;
price = parseFloat(get_price(itemid));
good = price*num;
var es = $('#express_'+itemid).html();
if(es.indexOf('data--1') != -1) {
if(good >= parseFloat(Dd('fee_start_'+itemid+'_1').value)) {
$('#express_'+itemid).val('-1');
} else {
if(es.indexOf('data-0') != -1) {
$('#express_'+itemid).val('0');
} else if(es.indexOf('data-2') != -1) {
$('#express_'+itemid).val('2');
} else if(es.indexOf('data-3') != -1) {
$('#express_'+itemid).val('3');
}
}
}
if(Dd('express_'+itemid).value > 0) {
var fee = parseFloat(Dd('fee_start_'+itemid+'_'+Dd('express_'+itemid).value).value) + parseFloat(Dd('fee_step_'+itemid+'_'+Dd('express_'+itemid).value).value)*(num-1);
Dd('fee_'+itemid).innerHTML = fee.toFixed(2);
Dd('total_'+itemid).innerHTML = (good+fee).toFixed(2);
_good += fee;
} else {
Dd('fee_'+itemid).innerHTML = '0.00';
Dd('total_'+itemid).innerHTML = good.toFixed(2);
}
Dd('price_'+itemid).innerHTML = price.toFixed(2);
_good += good;
}
Dd('total_amount').innerHTML = _good.toFixed(2);
}
<?php if($lists) { ?>calculate();<?php } ?>
</script>
<?php } ?>
<?php include template('footer');?>