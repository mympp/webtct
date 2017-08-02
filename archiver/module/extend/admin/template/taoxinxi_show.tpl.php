<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">Q群信息内容</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
	<th>信息类型</th>
	<td><?php echo $type[$data['typeid']]; ?></td>
</tr>
<tr>
	<th>发布者</th>
	<td><?php echo empty($data['username']) ? '游客' : $data['username']; ?></td>
</tr>
<tr>
	<th>真实姓名</th>
	<td><?php echo empty($data['truename']) ? '游客' : $data['truename']; ?></td>
</tr>
<tr>
	<th>内容</th>
	<td><?php echo $data['content']; ?></td>
</tr>
<tr>
	<th>ip</th>
	<td><?php echo $data['ip']; ?></td>
</tr>
<tr>
	<th>点击次数</th>
	<td><?php echo $data['hits']; ?></td>
</tr>
<tr>
	<th>回复数</th>
	<td>
		<?php $count = $taoxinxi->field('count(*) as c')->where(['allowitemid'=>$data['itemid']])->one();
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
</tr>
<tr>
	<th>发布日期</th>
	<td><?php echo date('Y-m-d H:i:s',$data['addtime']); ?></td>
</tr>
</table>
<?php if(!empty($lists)){  ?>
<div class="tt">回复信息列表</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<th width="25"><input type="checkbox" onclick="checkall(this.form);"/></th>
<th>分类</th>
<th width="500">内容</th>
<th>发布者</th>
<th>浏览</th>
<th>回应数</th>
<th>添加时间</th>
</tr>
<?php foreach($lists as $k=>$v) {?>
<tr onmouseover="this.className='on';" onmouseout="this.className='';" align="center" title="编辑:<?php echo $v['editor'];?>&#10;更新时间:<?php echo $v['editdate'];?>">
<td><input type="checkbox" name="itemid[]" value="<?php echo $v['itemid'];?>"/></td>
<td><?php echo $type[$v['typeid']]; ?></td>
<td><a href="javascript:Dwidget('?file=<?php echo $file; ?>&itemid=<?php echo $v[itemid]; ?>&action=show','查看Q群信息');"><?php echo $v['content']; ?></a></td>
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

</tr>
<?php }?>
</table>

<div class="pages"><?php echo $pages;?></div>
<?php } ?>
<br/>
<script type="text/javascript">Menuon(<?php echo $menu; ?>);</script>
<?php include tpl('footer');?>