<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">技术供应升人气版信息列表页</div>
<table cellpadding="2" cellspacing="1" class="tb">
  <tr>
    <th scope="col">姓名</th>
    <th scope="col" width="30%">自我推荐</th>
    <th scope="col">工作经验</th>
    <th scope="col">会员名</th>
    <th scope="col">浏览</th>
    <th scope="col">更新时间</th>
    <th scope="col">升人气</th>
  </tr>
<?php foreach($resume as $k=>$v){?>
  <tr>
    <td>&nbsp;&nbsp;<a href="job/<?php echo $v['linkurl'];?>" target="_blank"><?php echo $v['truename'];?>(<?php echo $v['gender'] == 1 ? '男' : '女';?>)</a></td>
    <td>&nbsp;&nbsp;<?php echo $v['introduce'];?></td>
    <td align="center"><?php echo $v['experience'];?></td>
    <td align="center"><a href="javascript:_user('<?php echo $v['username'];?>');"><?php echo $v['username'];?></a></td>
    <td align="center"><?php echo $v['hits'];?></td>
    <td align="center"><?php if($v['new_comment_time'] == 0){echo "从未升过评语";}else{echo "上次升评语时间：<br/>".timetodate($v['new_comment_time'],5);}?></td>
    <td align="center"><a href="javascript:void(0)" onclick="Dwindow('?moduleid=9&file=person_do_job&action=person_do_resume_comment&itemid=<?php echo $v['itemid'];?>&truename=<?php echo $v['truename'];?>&username=<?php echo $v['username'];?>&introduce=<?php echo $v['introduce'];?>','技术供应 - <?php echo $v['truename'];?> - 升评价',1000,450)">升人气</a></td>
  </tr>
<?php }?>
  <tr>
    <td colspan="7" align="center" valign="middle"><div class="pages"><?php echo $pages;?></div></td>
  </tr>
</table>
<?php include tpl('footer');?>