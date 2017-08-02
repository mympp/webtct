<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">第三方搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>&nbsp;
<?php echo $fields_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $order_select;?>

&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn" onclick="Dd('export').value=0;"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>');"/>
</td>
</tr>
</table>
</form>
<div class="tt">帐号绑定</div>
<form method="post">
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>网站名称</th>
<th>网址</th>
<th>权限范围</th>
<th>clientId</th>
<th>clientSecret</th>
<th>回调地址</th>
<th>添加时间</th>
<th>操作</th>
</tr>
<?php foreach($members as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center">
<td><input type="checkbox" name="clientid[]" value="<?php echo $v['client_id'];?>"/></td>
<td class="px11"><?php echo $v['client_name'];?></td>
<td class="px11"><a href="<?php echo $v['client_url'];?>" target="_blank"><?php echo $v['client_url'];?></a></td>
<td class="px11" align="left">
    1、获取用户头像、昵称<br/>
    <?php
        if(strpos($v['scope'],'validate') !== false){
            echo '2、获取用户认证状态';
        }
    ?>
</td>
<td class="px11"><?php echo $v['client_id'];?></td>
<td class="px11"><?php echo $v['client_secret'];?></td>
<td class="px11"><?php echo $v['redirect_uri'];?></td>
<td class="px11"><?php echo date('Y-m-d',strtotime($v['add_time']));?></td>
<td>
    <a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&clientid=<?php echo $v['client_id'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
    <a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&clientid=<?php echo $v['client_id'];?>" onclick="if(!confirm('确定要解除第三方吗？此操作将不可撤销')) return false;"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
    <a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=resetsec&clientid=<?php echo $v['client_id'];?>" onclick="return confirm('重置secret会导致该用户不能应用第三方登录，是否继续？')"><img src="admin/image/set.png" width="16" height="16" title="重置secret" alt=""/></a>&nbsp;
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" value=" 删除 " class="btn" onclick="if(confirm('确定要解除第三方吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<script type="text/javascript">Menuon(0);</script>
<?php include tpl('footer');?>