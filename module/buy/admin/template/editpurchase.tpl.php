<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<form method="post">
<input type="hidden" name="itemid" value="<?php echo $v[itemid];?>"/>
<input type="hidden" name="buyitemid" value="<?php echo $v[buyitemid];?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl">信息标题</td>
<td><input name="title" type="text" id="title" size="60" value="<?php echo $v[title];?>"/> </td>
</tr>
<tr>
<td class="tl">详细内容</td>
<td><textarea name="content" id="content" class="dsn"><?php echo $v[content]; ?></textarea>
<?php echo deditor($moduleid,'content', $MOD['editor'], '100%', 550);?><span id="dcontent" class="f_red"></span>
</td>
</tr>
</table>
<div class="tt">供应方信息</div>
<table>
<tr>
<td class="tl">供应方</td>
<td><input name="touser" type="text"  size="20" value="<?php echo $v[touser];?>" id="touser"/> <a href="javascript:_user('<?php echo $v['touser'];?>')" class="t">[资料]</a> <span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">供应方公司名</td>
<td><input name="company" type="text"  size="20" value="<?php echo $v[company];?>" id="company"/> <span id="dusername" class="f_red"></span></td>
</tr>
</table>
<div class="tt">采购方信息</div>
<table>
<tr>
<td class="tl">采购方</td>
<td><input name="username" type="text"  size="20" value="<?php echo $v[username];?>" id="username"/> <a href="javascript:_user('<?php echo $v['username'];?>')" class="t">[资料]</a> <span id="dusername" class="f_red"></span></td>
</tr>
<tr>
<td class="tl">收货人</td>
<td>
<input name="buyer_name" type="text"  size="20" value="<?php echo $v[buyer_name];?>" id="buyer_name"/> 
</td>
</tr>
<tr>
<td class="tl">收货地址</td>
<td>
<input name="buyer_address" type="text"  size="20" value="<?php echo $v[buyer_address];?>" id="buyer_address"/> 
</td>
</tr>
<tr>
<td class="tl">邮编</td>
<td>
<input name="buyer_postcode" type="text"  size="20" value="<?php echo $v[buyer_postcode];?>" id="buyer_postcode"/> 
</td>
</tr>
<tr>
<td class="tl">手机</td>
<td>
<input name="buyer_mobile" type="text"  size="20" value="<?php echo $v[buyer_mobile];?>" id="buyer_mobile"/> 
</td>
</tr>
<tr>
<tr>
<td class="tl">电话</td>
<td>
<input name="buyer_phone" type="text"  size="20" value="<?php echo $v[buyer_phone];?>" id="buyer_moblie"/> 
</td>
</tr>
<tr>
<td class="tl">期望物流</td>
<td>
<input name="buyer_receive" type="text"  size="20" value="<?php echo $v[buyer_receive];?>" id="buyer_receive"/> 
</td>
</tr>
<tr>
<td class="tl">买家备注</td>
<td>
<input name="note" type="text"  size="20" value="<?php echo $v[note];?>" id="note"/> 
</td>
</tr>

<tr>
<td class="tl">采购状态</td>
<td>
<input type="radio" name="status" value="1" <?php if($v[status] == 1) echo 'checked';?>/> 发起人采购
<input type="radio" name="status" value="2" <?php if($v[status] == 2) echo 'checked';?>/> 中标方已读
<input type="radio" name="status" value="3" <?php if($v[status] == 3) echo 'checked';?>/> 中标方已发货
<input type="radio" name="status" value="4" <?php if($v[status] == 4) echo 'checked';?>/> 采购完毕
<input type="radio" name="status" value="-1" <?php if($v[status] == -1) echo 'checked';?>/> 中标方退回
</td>
</tr>
<tr>
<td class="tl">添加时间</td>
<td><input type="text" size="22" name="addtime" value="<?php echo timetodate($v[addtime], 5);?>"/></td>
</tr>
</table>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>