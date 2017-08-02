<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<script type="text/javascript" src="/file/script/jquery.js"></script>
<script type="text/javascript" src="/file/script/lhgdialog.js?skin=idialog"></script>
<script type="text/javascript" src="/file/script/jsfunction.js"></script>
<form action="?">
<div class="tt">报名信息搜索</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
<input type="hidden" name="file" value="apply">
<input type="hidden" name="type" value="<?php echo $type;?>">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>">
发布人账号：<input type="text" name="job_username" value="<?php echo $job_username;?>">-
报名者账号：<input type="text" name="apply_username" value="<?php echo $apply_username;?>">
<select name="status">
	<option value="0" <?php if(!$status) echo 'selected';?>>状态
	<option value="1" <?php if($status == '1') echo 'selected';?>>未查看
	<option value="2" <?php if($status == '2') echo 'selected';?>>查看
	<option value="3" <?php if($status == '3') echo 'selected';?>>选定
</select>
<input type="submit">
</td>
</tr>
</table>
</form>
<div class="tt"><?php echo $menus[$menuid][0];?></div>
<iframe name="caozuo" id="caozuo" src="" style="display:none"></iframe>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th>服务需求信息标题</th>
<th>发布人</th>
<th>报名信息</th>
<th>报名人</th>
<th>状态</th>
<th>管理员处理</th>
<th width="80">操作</th>
</tr>
<style type="text/css">
	.f_blue a{color:blue}
</style>
<?php foreach($lists as $k=>$v) {?>
<form method="post" action="" target="caozuo">
<tr align="center"  <?php if($v[status]==3){?> class="on f_blue f_b"<?php }else{?>onmouseover="this.className='on';"onmouseout="this.className='';"<?php }?>>
<td><a href="<?php echo $MOD['linkurl'].$v[linkurl];?>" target="_blank"><?php echo $v[title];?>/<?php echo $v[apply];?></td>
<td><a href="javascript:_user('<?php echo $v['job_username'];?>');"><?php echo $v['job_username'];?></a></td>
<td><a href="<?php echo $MOD['linkurl']."resume.php?itemid=".$v[resumeid];?>" target="_blank"><?php echo $v['title1'];?></a></td>
<td><a href="javascript:_user('<?php echo $v['apply_username'];?>');"><?php echo $v['apply_username'];?></a></td>
<td><?php if($v[status]==1){?>未查看<?php }elseif($v[status]==3){?><font >选定</font><?php }else{?>已查看<?php }?></td>
<td><?php if($v[admin]==1){?><?php if($v[updatetime]=='10'){?>后台协调配合<?php }else{?>
<script type="text/javascript">var s<?php echo $v['applyid'];?>="<?php echo $v['title1'];?>的管理员跟进备注：<?php echo $v['adminnote'];?>";</script>
<span onclick="Dconfirm(s<?php echo $v['applyid'];?>, '', 450);" ><?php echo timetodate($v['updatetime'], 'm/d H:i');?>手动处理</span><img src="admin/image/help.png" class="c_p" onclick="Dconfirm(s<?php echo $v['applyid'];?>, '跟进信息', 450);" />
<?php }?><?php }else{?><font class="f_red">未处理</font><?php }?>
<div style="display:none" id="apply<?php echo $v['applyid'];?>">
<input type="hidden" name="action" value="update">
<input type="hidden" name="applyid" value="<?php echo $v['applyid'];?>">
<input type="hidden" name="jobid" value="<?php echo $v['jobid'];?>">
<textarea name="adminnote" rows="4" cols="25"><?php echo $v['adminnote'];?></textarea><br>选定<select name="status">
	<option value="1" <?php if($v[status]==1){?>selected<?php }?>>取消
	<option value="3" <?php if($v[status]==3){?>selected<?php }?>>确定
</select><input type="submit" value="提交">
</div>
</td>
<td width="50">
<a href="?action=delete&applyid=<?php echo $v['applyid'];?>">删除</a>&nbsp;<a href="javascript:void(0);" onclick="Dd('apply<?php echo $v['applyid'];?>').style.display='block';">跟进</a>
</td>
</tr>
</form>
<?php }?>
</table>
<div class="pages"><?php echo $pages;?></div>
<br/>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>