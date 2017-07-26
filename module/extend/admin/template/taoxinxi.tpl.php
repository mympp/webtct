<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form action="?">
<div class="tt">Q群信息搜索</div>
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td>
&nbsp;<?php echo $type_select;?>&nbsp;
<input type="text" size="30" name="kw" value="<?php echo $kw;?>" title="关键词"/>&nbsp;
<?php echo $DT['city'] ? ajax_area_select('areaid', '地区(分站)', $areaid).'&nbsp;' : '';?>
&nbsp;
<input type="text" name="psize" value="<?php echo $pagesize;?>" size="2" class="t_c" title="条/页"/>
<input type="submit" value="搜 索" class="btn"/>&nbsp;
<input type="button" value="重 置" class="btn" onclick="Go('?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>');"/>
</td>
</tr>
</table>
</form>
<form method="post">
<div class="tt"><?php if($action == 'check'){ ?> 审核Q群信息<?php }else{ ?>管理Q群信息 <?php } ?></div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>分类</th>
<th width="500">内容</th>
<th>发布者</th>
<th>浏览</th>
<th>回应数</th>
<th>添加时间</th>
<th width="50">操作</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center" title="编辑:<?php echo $v['editor'];?>&#10;更新时间:<?php echo $v['editdate'];?>">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><?php echo $type[$v['typeid']]; ?></td>
<td><a href="javascript:Dwidget('?moduleid=<?php echo $moduleid; ?>&file=<?php echo $file; ?>&itemid=<?php echo $v[itemid]; ?>&action=show','查看Q群信息');"><?php echo $v['content']; ?></a></td>
<td><a href="javascript:_user('<?php echo $v[username]; ?>');" ><?php echo $v['username']; ?></a></td>
<td><?php echo $v['hits']; ?></td>
<td>
	<?php $count = $taoxinxi->field('count(*) as c')->where(['allowitemid'=>$v['itemid']])->one();
	echo $count['c'];
	if($count['c'] != '0'){
		$username = $taoxinxi->field('username')->where(['allowitemid'=>$v['itemid']])->all();
		$check_str = '';
		foreach($username as $u){
			$check_str .= $u['username'].',';
		}
		if(strpos($check_str,$_username) !== false) echo '&nbsp;&nbsp;[我已跟进]';
	}
	?>
</td>
<td><?php echo date('Y-m-d H:i:s',$v['addtime']); ?></td>
<td>
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=edit&itemid=<?php echo $v['itemid'];?>"><img src="admin/image/edit.png" width="16" height="16" title="修改" alt=""/></a>&nbsp;
<a href="?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete&itemid=<?php echo $v['itemid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
</td>
</tr>
<?php }?>
</table>
<div class="btns">
<input type="submit" value=" 删 除 " class="btn" onclick="if(confirm('确定要删除选中信息吗？此操作将不可撤销')){this.form.action='?moduleid=<?php echo $moduleid;?>&file=<?php echo $file;?>&action=delete'}else{return false;}"/>&nbsp;
<?php if($action == 'check'){ ?>
<input type="submit" value=" 通 过 " class="btn" onclick="if(confirm('确定要通过选中的信息?')){this.form.action='?moduleid=<?php echo $moduleid; ?>&file=<?php echo $file; ?>&action=examine'}else{return false;}" />&nbsp;
<?php }  ?>
</div>
</form>
<div class="pages"><?php echo $pages;?></div>
<br/>
<script type="text/javascript">Menuon(<?php echo $menu; ?>);</script>
<?php include tpl('footer');?>