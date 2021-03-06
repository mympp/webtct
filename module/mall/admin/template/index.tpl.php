<?php

defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">商品搜索</div>
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
<input type="checkbox" name="nocatid" value="1"<?php echo $nocatid ? ' checked' : '';?>/>无分类&nbsp;
进出口分类：<input type="radio" name="expcate" value="0" <?php if($expcate ==0) echo ' checked';?> />默认&nbsp;
<input type="radio" name="expcate" value="1" <?php if($expcate ==1) echo ' checked';?> />国产产品&nbsp;
<input type="radio" name="expcate" value="2" <?php if($expcate ==2) echo ' checked';?>/>进口产品&nbsp;&nbsp;
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
<?php echo category_select('catid', '所属分类', $catid, $moduleid);?>&nbsp;
<?php echo ajax_area_select('areaid', '所在地区', $areaid);?>&nbsp;
ID：<input type="text" size="4" name="itemid" value="<?php echo $itemid;?>"/>&nbsp;
<input type="checkbox" name="elite" value="1"<?php echo $elite ? ' checked' : '';?>/>橱窗&nbsp;

是否有分科室：<input type="radio" name="keshi" <?php if($keshi ==0) echo ' checked';?> value="0" />默认&nbsp;<input type="radio" name="keshi" value="1" <?php if($keshi ==1) echo ' checked';?> />有科室&nbsp;<input type="radio" name="keshi" value="2" <?php if($keshi ==2) echo ' checked';?>/>无科室&nbsp;&nbsp;
<input type="checkbox" name="cod" value="1"<?php echo $cod ? ' checked' : '';?>/>货到付款&nbsp;
<input type="checkbox" name="mp" value="1"<?php echo $mp ? ' checked' : '';?>/>阶梯价格&nbsp;
<input type="checkbox" name="rl" value="1"<?php echo $rl ? ' checked' : '';?>/>关联商品&nbsp;
</td>
</tr>
<tr>
<td>
&nbsp;单价：<input type="text" size="3" name="minprice" value="<?php echo $minprice;?>"/> ~ <input type="text" size="3" name="maxprice" value="<?php echo $maxprice;?>"/>&nbsp;
订单：<input type="text" size="3" name="minorders" value="<?php echo $minorders;?>"/> ~ <input type="text" size="3" name="maxorders" value="<?php echo $maxorders;?>"/>&nbsp;
销量：<input type="text" size="3" name="minsales" value="<?php echo $minsales;?>"/> ~ <input type="text" size="3" name="maxsales" value="<?php echo $maxsales;?>"/>&nbsp;
库存：<input type="text" size="3" name="minamount" value="<?php echo $minamount;?>"/> ~ <input type="text" size="3" name="maxamount" value="<?php echo $maxamount;?>"/>&nbsp;
评论：<input type="text" size="3" name="mincomments" value="<?php echo $mincomments;?>"/> ~ <input type="text" size="3" name="maxcomments" value="<?php echo $maxcomments;?>"/>&nbsp;
<?php echo VIP;?>：<input type="text" size="3" name="minvip" value="<?php echo $minvip;?>"/> ~ <input type="text" size="3" name="maxvip" value="<?php echo $maxvip;?>"/>&nbsp;
按科室：<?php echo category_select('kcatids', '所属科室', $catid, 12);?>&nbsp;
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt"><?php echo $menus[$menuid][0];?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>分类</th>
<th width="14"> </th>
<th width="70">图片</th>
<th>商品</th>
<th>厂家名称</th>
<th>批准文号</th>
<th>会员</th>
<th>价格</th>
<th>订单</th>
<th>证书</th>
<th width="70">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><a href="<?php echo $v['caturl'];?>" target="_blank"><?php echo $v['catname'];?></a></td>
<td><?php if($v['level']) {?><a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=<?php echo $action;?>&level=<?php echo $v['level'];?>"><img src="admin/image/level_<?php echo $v['level'];?>.gif" title="<?php echo $v['level'];?>级" alt=""/></a><?php } ?></td>
<td><a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="<?php echo $v['thumb'] ? $v['thumb'] : DT_SKIN.'image/nopic60.gif';?>" width="60" style="padding:5px;"/></a></td>
<td align="left">&nbsp;<a href="<?php echo $v['linkurl'];?>" target="_blank" class="t f_b"><?php echo $v['title'];?></a><?php if($v['vip']) {?> <img src="<?php echo DT_SKIN;?>image/vip_<?php echo $v['vip'];?>.gif" title="<?php echo VIP;?>:<?php echo $v['vip'];?>" align="absmiddle"/><?php } ?><br/>
<span class="f_gray">
&nbsp;更新:<span class="px11"><?php echo timetodate($v['edittime'], 6);?></span><br/>
&nbsp;添加:<span class="px11"><?php echo timetodate($v['addtime'], 6);?></span>
</span>
</td>
<td>
<?php echo $v['manufacturer']; ?>&nbsp;
	<a href="javascript:void();" onclick="Dwidget('http://www.tecenet.com/file/game/bis/product-search.html?ID=<?php echo $v['manufacturer']; ?>&from=domestic', '搜索BIS库内容')">[bis]</a>
</td>
<td>
	<?php echo $v['batchnum']; ?><br/>
	<?php
	 $batchnum = str_replace('（','(',$v['batchnum']);
	 $batchnum = str_replace('）',')',$batchnum);
	?>
	<a href="javascript:void();" onclick="Dwidget('http://www.tecenet.com/file/game/bis/product-search.html?ID=<?php echo $batchnum; ?>&from=domestic', '搜索BIS库内容')">[bis]</a>
	&nbsp;
	<a href="https://db.yaozh.com/Search?typeid=8455&content=<?php echo $batchnum; ?>" target="_blank">[药智]</a>
	</td>
<td>
<?php if($v['username']) { ?>
<a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a>
<?php } else { ?>
	<a href="javascript:_ip('<?php echo $v['ip'];?>');" title="游客"><?php echo $v['ip'];?></a>
<?php } ?>
</td>
<td class="f_price"><?php echo $v['price'];?></td>
<td class="px11"><a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=order&mallid=<?php echo $v['itemid'];?>', '[<?php echo $v['alt'];?>] 订单列表');"><?php echo $v['orders'];?></a></td>
<td class="px11">
	<a href="javascript:Dwidget('?<?php
            echo http_build_query(['moduleid'=>$moduleid,'file'=>'validate','mallid'=>$v['itemid']]);
        ?>','产品证书')">
	[<?php echo $mallValidate->getCountByMall($v['itemid']); ?>]
    </a>
<td>
<a href="javascript:Dwidget('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=relate&itemid=<?php echo $v['itemid'];?>', '[<?php echo $v['alt'];?>] 关联商品');"><img src="admin/image/child.png" width="16" height="16" title="关联商品" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php } ?>
</table>

<script>
	var selectOption = [
    	'请选择理由',
		'您好，请按照产品信息发布原则发布信息，如：商品详情处请勿填写公司地址、网址、联系方式等。请不要上传附有网址，联系方式等的产品图片，感谢您对天成医疗网的关注与支持。',
		'您好，同样产品信息发布一次即可，重复发布同样的产品信息全部都会拒绝审核，需要重新修改资料再提交。感谢您对天成医疗网的关注与支持。',
		'你好，这是产品发布模块，请在商品名称处填写正确的名称（不要带上厂家名字以及其他宣传字眼），生产厂家处填写完整的厂家名字，不能简写。批准文号上面填写相关部门的准字号。如该准字号在药监局是查不到相关信息的，请上传相关证件。如是代理的产品请发布相关的授权委托书，感谢您对天成医疗网的关注与支持。',
		'你好，这是产品发布模块，请在商品名称处填写正确的名称（不要带上厂家名字以及其他宣传字眼），生产厂家处填写完整的厂家名字，不能简写。批准文号上面填写相关部门的准字号。如没有相关批准文号的产品请填写：000000，但在商品介绍处需第一行要标注：1)本产品仅能用于科研；2)本产品未通过直接用于活体动物和人的审核；3)本产品未通过用于活体诊断的审核。感谢您对天成医疗网的关注与支持。',
		'你好。你发布的产品信息里填写的厂家名字、产品名称、批准文号在国家食品药品监督管理局查到的不一致（或者没有相关资料），请核实信息是否已经正确填写。如是代理的产品请发布相关的授权委托书，感谢您对天成医疗网的关注与支持。如有疑问可以在上班时间咨询在线客服。',
		'您好，这边是产品信息发布平台，您可以发布医疗产品信息。感谢您对天成医疗网的关注与支持。'
	];
</script>

<?php include tpl('notice_chip');?>
<div class="btns">

<?php if($action == 'check') { ?>

<input type="submit" value=" 通过审核 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=check';"/>&nbsp;
<input type="submit" value=" 拒 绝 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=reject';"/>&nbsp;
<input type="submit" value=" 移动分类 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中商品吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'expire') { ?>

<input type="submit" value=" 上 架 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=onsale';"/>&nbsp;
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中商品吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'reject') { ?>

<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中商品吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;

<?php } else if($action == 'recycle') { ?>

<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中商品吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 还 原 " class="btn" onclick="if(confirm('确定要还原选中商品吗？状态将被设置为已通过')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=restore'}else{return false;}"/>&nbsp;
<input type="submit" value=" 清 空 " class="btn" onclick="if(confirm('确定要清空回收站吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=clear';}else{return false;}"/>

<?php } else { ?>

<input type="submit" value="刷新信息" class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=refresh';" title="刷新时间为最新"/>&nbsp;
<input type="submit" value=" 更新信息 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=update';"/>&nbsp;
<?php if($MOD['show_html']) { ?><input type="submit" value=" 生成网页 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=tohtml';"/>&nbsp;<?php } ?>
<input type="submit" value=" 回收站 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&recycle=1';"/>&nbsp;
<input type="submit" value=" 彻底删除 " class="btn" onclick="if(confirm('确定要删除选中商品吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<input type="submit" value=" 移动分类 " class="btn" onclick="this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=move';"/>&nbsp;
<input type="submit" value=" 批量下架 " class="btn" onclick="if(confirm('确定要批量下架选中商品吗？')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=unsale'}else{return false;}"/>&nbsp;
<?php echo level_select('level', '设置级别为</option><option value="0">取消', 0, 'onchange="this.form.action=\'?moduleid='.$moduleid.'&file='.$file.'&action=level\';this.form.submit();"');?>&nbsp;
<?php } ?>
<br/><br/>
将选择的产品更改到会员:
<input type="text" name="to_member[]" size="10" value="" />
<input type="submit" value=" 并确认 " class="btn" onclick="if(confirm('确定要更改选中商品的会员吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=change_member'}else{return false;}"/>&nbsp;
<span class="f_red">(注：此操作一去不复返！点击有风险，操作需谨慎！PS:此功能要先搜索‘单一’会员名，不能多个会员名更改，即不能按产品名搜索更改！)</span>
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<?php if($action==''){  ?>
	
<!-- 批量上传配件商品 -->
<div>
<div class="tt">批量上传配件商品</div>
<form action="?" method="post" style="float: left;" >
<input type="hidden" value="<?php echo $moduleid; ?>" name="moduleid" />
<input type="hidden" value="download" name="action" />
<input type="hidden" value="product" name="file_name" />
<input type="submit" value="下载模板" name="download" id="download" class="btn" onclick=""  style="margin-left:15px;margin-top:5px;" />
</form>
<form action="?" method="post" style="float:left;" >
<input type="hidden" value="<?php echo $moduleid; ?>" name="moduleid" />
<input type="hidden" value="download" name="action" />
<input type="hidden" value="product-example" name="file_name"/>
<input type="submit" value="下载事例" name="download" id="download-example" class="btn" onclick=""  style="margin-left:15px;margin-top:5px;" />
</form>
<form action="?" method="post" style="float:left;" >
<input type="hidden" value="<?php echo $moduleid; ?>" name="moduleid" />
<input type="hidden" value="download" name="action" />
<input type="hidden" value="product-sort" name="file_name" />
<input type="submit" value="下载分类" name="download" style="margin-top:5px;margin-left:15px;" class="btn" />
</form>
<div style="clear: both;"></div>
<form action="<?php echo "?moduleid=$moduleid&file=upload"; ?>" method="post" enctype="multipart/form-data"  style="margin-left:15px;margin-top:5px;">
<input type="hidden" name="upload_type" value="product" />
<input type="file" name="upload_csv"  />&nbsp;&nbsp;&nbsp;<input type="submit" name="send" id="send" value="上传" class="btn"/>
</form>
</div>
<?php } ?>
<br/>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>