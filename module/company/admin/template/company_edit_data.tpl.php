<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
?>
<div class="tt">基础设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php if($edit_data['background'] && $edit_data['background']!= ''){ ?>
<tr>
<td class="tl">自定义背景图</td>
<td class="tr"><img src="<?php echo $edit_data['background']; ?>" width="180" height="90" /></td>
</tr>
<?php } ?>
<?php if($edit_data['bgcolor'] && $edit_data['bgcolor']!= ''){ ?>
<tr>
<td class="tl">自定义背景色</td>
<td class="tr"><script type="text/javascript" src="<?php echo DT_PATH; ?>file/script/jscolor.js"></script>
<input name="edit_data[bgcolor]" type="text" size="10" id="bgcolor" class="color {hash:true,required:false}" value="<?php echo $edit_data['bgcolor'] ?>"  readonly="readonly"/></td>
</tr>
<?php } ?>
<?php if($edit_data['logo'] && $edit_data['logo']!= ''){ ?>
<tr>
<td class="tl">自定义LOGO</td>
<td class="tr"><img src="<?php echo $edit_data['logo']; ?>" width="180" height="90" /></td>
</tr>
<?php } ?>
<?php if($edit_data['bannert'] && $edit_data['bannert']!= ''){ ?>
<tr>
<td class="tl">横幅显示方式</td>
<td class="tr"><?php if($edit_data['bannert'] == 0){ echo '图片';}elseif($edit_data['bannert'] == 1){ echo 'Flash'; }else{echo '幻灯片';} ?></td>
</tr>
<?php } ?>
<?php if($edit_data['banner'] && $edit_data['banner']!= ''){ ?>
<tr>
<td class="tl">横幅图片</td>
<td class="tr"><img src="<?php echo $edit_data['banner']; ?>" width="180" height="90"></td>
</tr>
<?php } ?>
<?php if($edit_data['bannerw'] && $edit_data['bannerw']!= ''){ ?>
<tr>
<td class="tl">横幅宽度</td>
<td class="tr"><?php echo $edit_data['bannerw']; ?></td>
</tr>
<?php } ?>
<?php if($edit_data['bannerh'] && $edit_data['bannerh']!= ''){ ?>
<tr>
<td class="tl">横幅高度</td>
<td class="tr"><?php echo $edit_data['bannerh']; ?></td>
</tr>
<?php } ?>
<?php if($edit_data['bannerf'] && $edit_data['bannerf']!= ''){ ?>
<tr>
<td class="tl">横幅Falsh</td>
<td class="tr"><a href="<?php echo $edit_data['bannerf']; ?>" target="_blank" style="color:red;">打开查看</a></td>
</tr>
<?php } ?>
<?php if($edit_data['banner1'] && $edit_data['banner1']!= ''){ ?>
<tr>
<td class="tl">横幅图片地址1</td>
<td class="tr"><img src="<?php echo $edit_data['banner1']; ?>" width="180" height="90" /></td>
</tr>
<?php } ?>
<?php if($edit_data['banner2'] && $edit_data['banner2']!= ''){ ?>
<tr>
<td class="tl">横幅图片地址2</td>
<td class="tr"><img src="<?php echo $edit_data['banner2']; ?>" width="180" height="90" /></td>
</tr>
<?php } ?>
<?php if($edit_data['banner3'] && $edit_data['banner3']!= ''){ ?>
<tr>
<td class="tl">横幅图片地址3</td>
<td class="tr"><img src="<?php echo $edit_data['banner3']; ?>" width="180" height="90" /></td>
</tr>
<?php } ?>
<?php if($edit_data['banner4'] && $edit_data['banner4']!= ''){ ?>
<tr>
<td class="tl">横幅图片地址4</td>
<td class="tr"><img src="<?php echo $edit_data['banner4']; ?>" width="180" height="90" /></td>
</tr>
<?php } ?>
<?php if($edit_data['banner5'] && $edit_data['banner5']!= ''){ ?>
<tr>
<td class="tl">横幅图片地址5</td>
<td class="tr"><img src="<?php echo $edit_data['banner5']; ?>" width="180" height="90" /></td>
</tr>
<?php } ?>
<?php if($edit_data['video'] && $edit_data['video']!= ''){ ?>
<tr>
<td class="tl">形象视频地址</td>
<td class="tr"><a href="<?php echo $edit_data['video']; ?>" target="_blank" /></td>
</tr>
<?php } ?>
<?php if($edit_data['announce'] && $edit_data['announce']!= ''){ ?>
<tr>
<td class="tl">网站公告</td>
<td class="tr"><?php echo $edit_data['announce']; ?></td>
</tr>
<?php } ?>
<?php if($edit_data['show_stats'] && $edit_data['show_stats']!= ''){ ?>
<tr>
<td class="tl">访问次数显示</td>
<td class="tr"><?php if($edit_data['show_stats'] == 0){ echo '不显示';}else{ echo '显示'; } ?></td>
</tr>
<?php } ?>
</table>

<?php if($edit_data['main_show'] && $edit_data['main_show'] != '') { ?>
<div class="tt">首页模块设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php 
	$main_show = explode(',',$edit_data['main_show']);
	$main_name = explode(',',$edit_data['main_name']);
	$main_order = explode(',',$edit_data['main_order']);
	$main_num = explode(',',$edit_data['main_num']);
?>
<tr>
	<th>显示</th>
	<th>名称</th>
	<th>排序</th>
	<th>数量</th>
</tr>
	<?php foreach($main_show as $k =>$v){ ?>
		<tr align="center">
		<td><?php if($v == '1'){echo '显示';}else{echo '不显示';} ?></td>
		<td><?php echo $main_name[$k]; ?></td>
		<td><?php echo $main_order[$k]; ?></td>
		<td><?php echo $main_num[$k]; ?></td>
		</tr>
	<?php } ?>
</table>
<?php } ?>

<?php if($edit_data['menu_show'] && $edit_data['menu_show'] != '') { ?>
<div class="tt">网站导航菜单</div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php 
	$menu_show = explode(',',$edit_data['menu_show']);
	$menu_name = explode(',',$edit_data['menu_name']);
	$menu_order = explode(',',$edit_data['menu_order']);
	$menu_num = explode(',',$edit_data['menu_num']);
?>
<tr>
	<th>显示</th>
	<th>名称</th>
	<th>排序</th>
	<th>分页</th>
</tr>
	<?php foreach($menu_show as $k =>$v){ ?>
		<tr align="center">
		<td><?php if($v == '1'){echo '显示';}else{echo '不显示';} ?></td>
		<td><?php echo $menu_name[$k]; ?></td>
		<td><?php echo $menu_order[$k]; ?></td>
		<td><?php echo $menu_num[$k]; ?></td>
		</tr>
	<?php } ?>
</table>
<?php } ?>

<?php if($edit_data['side_show'] && $edit_data['side_show'] != '') { ?>
<div class="tt">侧栏模块设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php 
	$side_show = explode(',',$edit_data['side_show']);
	$side_name = explode(',',$edit_data['side_name']);
	$side_order = explode(',',$edit_data['side_order']);
	$side_num = explode(',',$edit_data['side_num']);
?>
<tr>
	<th>显示</th>
	<th>名称</th>
	<th>排序</th>
	<th>分页</th>
</tr>
	<?php foreach($side_show as $k =>$v){ ?>
		<tr align="center">
		<td><?php if($v == '1'){echo '显示';}else{echo '不显示';} ?></td>
		<td><?php echo $side_name[$k]; ?></td>
		<td><?php echo $side_order[$k]; ?></td>
		<td><?php echo $side_num[$k]; ?></td>
		</tr>
	<?php } ?>
</table>
<?php } ?>
<table cellpadding="2" cellspacing="1" class="tb">
<?php if($edit_data['side_width'] && $edit_data['side_width'] != ''){ ?>
<tr align="center">
	<td>侧栏宽度</td>
	<td><?php echo $edit_data['side_width']; ?></td>
</tr>
<?php } ?>
<?php if($edit_data['side_pos'] && $edit_data['side_pos'] != ''){ ?>
<tr align="center">
	<td>侧栏位置</td>
	<td><?php if($edit_data['side_pos'] == '0'){echo '左侧';}else{echo '右侧';} ?></td>
</tr>
<?php } ?>
</table>

<div class="tt">高级设置</div>
<table cellpadding="2" cellspacing="1" class="tb">
<?php if($edit_data['intro_length'] && $edit_data['intro_length'] != ''){ ?>
<tr>
<td class="tl">公司简介字符数</td>
<td class="tr"><?php echo $edit_data['intro_length']; ?></td>
</tr>
<?php } ?>
<?php if($edit_data['css'] && $edit_data['css'] != ''){ ?>
<tr>
<td class="tl">css样式</td>
<td class="tr"><?php echo $edit_data['css']; ?></td>
</tr>
<?php } ?>
<?php if( $edit_data['seo_title'] && $edit_data['seo_title'] != ''){ ?>
<tr>
<td class="tl">seo标题</td>
<td class="tr"><?php echo $edit_data['seo_title']; ?></td>
</tr>
<?php } ?>
<?php if( $edit_data['seo_keywords'] && $edit_data['seo_keywords'] != ''){ ?>
<tr>
<td class="tl">seo关键词</td>
<td class="tr"><?php echo $edit_data['seo_keywords']; ?></td>
</tr>
<?php } ?>
<?php if( $edit_data['seo_description'] && $edit_data['seo_description'] != ''){ ?>
<tr>
<td class="tl">seo描述</td>
<td class="tr"><?php echo $edit_data['seo_description']; ?></td>
</tr>
<?php } ?>
<?php if( $edit_data['kf'] && $edit_data['kf'] != ''){ ?>
<tr>
<td class="tl">客服</td>
<td class="tr"><?php echo $edit_data['kf']; ?></td>
</tr>
<?php } ?>
<?php if( $edit_data['map'] && $edit_data['map'] != ''){ ?>
<tr>
<td class="tl">公司地图标注</td>
<td class="tr"><?php echo $edit_data['map']; ?></td>
</tr>
<?php } ?>
</table>


<?php include tpl('footer');?>