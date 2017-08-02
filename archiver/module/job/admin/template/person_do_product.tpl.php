<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>

<div class="tt">产品中心升人气版信息列表页</div>
<form action="?">
	<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
	<input type="hidden" name="file" value="<?php echo $file;?>"/>
	<input type="hidden" name="action" value="<?php echo $action;?>"/>
	&nbsp;<?php echo $fields_select;?>&nbsp;
	<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
	<input type="submit" name="submit" value=" 搜 索 " class="btn" />
</form>
<table cellpadding="2" cellspacing="1" class="tb">
  <tr>
    <th width="11%" scope="col">分类</th>
    <th width="11%" scope="col">图片</th>
    <th width="22%" scope="col">商品</th>
    <th width="10%" scope="col">会员</th>
    <th width="7%" scope="col">评价</th>
    <th width="7%" scope="col">点击数</th>
    <th width="19%" scope="col">更新时间</th>
    <th width="8%" scope="col">升评语</th>
	<th width="8%" scope="col">升评价</th>
  </tr>
<?php foreach($product_lists as $k=>$v){?>
  <tr onmouseover="this.className='on';" onmouseout="this.className='';">
    <td align="center"><?php echo $v['catname'];?></td>
    <td align="center"><a href="javascript:_preview('<?php echo $v['thumb'];?>');"><img src="<?php echo $v['thumb'] ? $v['thumb'] : DT_SKIN.'image/nopic60.gif';?>" width="60" style="padding:5px;"/></a></td>
    <td>
&nbsp;<a href="<?php echo $v['linkurl'];?>" target="_blank" class="t f_b"><?php echo $v['title'];?></a><?php if($v['vip']) {?> <img src="<?php echo DT_SKIN;?>image/vip.gif" title="<?php echo VIP;?>:<?php echo $v['vip'];?>"/><?php } ?><br/>
<span class="f_gray">
&nbsp;更新:<span class="px11"><?php echo timetodate($v['edittime'], 6);?></span><br/>
&nbsp;添加:<span class="px11"><?php echo timetodate($v['addtime'], 6);?></span>
</span>
	</td>
    <td align="center"><?php echo $v['username'];?></td>
    <td align="center"><?php echo $v['comments'];?></td>
    <td align="center"><?php echo $v['hits'];?></td>
    <td align="center"><?php if($v['new_comment_time'] == 0){echo "从未升过评语";}else{echo "上次升评语时间：<br/>".timetodate($v['new_comment_time'],5);}?></td>
    <td align="center"><a href="javascript:void(0)" onclick="Dwindow('?moduleid=9&file=person_do_job&action=product_comment&title=<?php echo $v['title'];?>&jobid=<?php echo $v['itemid'];?>&username=<?php echo $v['username'];?>&linkurl=<?php echo $v['linkurl'];?>&itemid=<?php echo $v['itemid'];?>','产品 - <?php echo $v[title];?> - 升评语',1000,550)">升评语</a></td>
	<td align="center"><a href="javascript:void(0)" onclick="Dwindow('?moduleid=9&file=person_do_job&action=product_comment_pingjia&title=<?php echo $v['title'];?>&jobid=<?php echo $v['itemid'];?>&username=<?php echo $v['username'];?>&linkurl=<?php echo $v['linkurl'];?>&itemid=<?php echo $v['itemid'];?>','产品 - <?php echo $v[title];?> - 升评价',1000,450)">升评价</a></td>
  </tr>
<?php }?>
  <tr>
    <td colspan="9"><div class="pages"><?php echo $pages;?></div></td>
  </tr>
</table>
<?php include tpl('footer');?>