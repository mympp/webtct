<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">服务需求升人气版信息列表页</div>
<table cellpadding="2" cellspacing="1" class="tb">
  <tr>
    <td colspan="7">
<form action="?">
	<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
	<input type="hidden" name="file" value="<?php echo $file;?>"/>
	<input type="hidden" name="action" value="sel_job"/>
	<select name="fields">
		<option value="title">信息标题</option>
		<option value="username">发布者</option>
	</select>&nbsp;
	<input type="text" size="25" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
	<select name="validated">
		<option value="">验证</option>
		<option value="1">已验证</option>
		<option value="0">未验证</option>
	</select>&nbsp;
	<input type="submit" value="搜 索" class="btn"/>
</form>
	</td>
  </tr>
  <tr>
    <th scope="col">信息标题</th>
    <th scope="col" width="11%">更新时间</th>
	<th scope="col">升人气</th>
    <th width="73" scope="col">是否验证</th>
    <th width="281" scope="col">跟进</th>
    <th scope="col">发布会员</th>
	<th scope="col">跟进会员</th>
  </tr>
<?php foreach($job_lists as $k=>$v){ ?>
  <tr onmouseover="this.className='on';" onmouseout="this.className='';">
    <td>&nbsp;<a href="/job/<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['title'];?></a></td>
    <td align="center"><?php if($v['new_comment_time'] == 0){echo "从未升过人气";}else{echo timetodate($v['new_comment_time'],5);}?></td>
	<td align="center"><a href="javascript:void(0)" onclick="Dwindow('?moduleid=9&file=person_do_job&action=sel_com_mem&title=<?php echo $v['title'];?>&jobid=<?php echo $v['itemid'];?>&username=<?php echo $v['username'];?>&linkurl=<?php echo $v['linkurl'];?>&itemid=<?php echo $v['itemid'];?>','服务需求加人气',1000,550)">升人气</a></td>
    <td align="center"><?php if($v['validated']) { ?>已验证<?php } else { ?>--<?php } ?></td>
    <td align="center" class="px11"><?php echo $v['step']+1;?>.<?php echo $step[$v['step']];?></td>
    <td align="center"><?php echo $v['username'];?></td>
    <td align="center"><?php echo $v['tobe'];?></td>
  </tr>
<?php }?>
  <tr>
    <td colspan="7" align="center" valign="middle"><div class="pages"><?php echo $pages;?></div></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
	<td>&nbsp;</td>
  </tr>
</table>
<?php include tpl('footer');?>