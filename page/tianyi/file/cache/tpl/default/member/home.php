<?php defined('IN_DESTOON') or exit('Access Denied');?><?php include template('header', 'member');?>
<script type="text/javascript">c(3);</script>
<div class="menu">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="tab" id="Tab0"><a href="javascript:Tab(0);"><span>常用设置</span></a></td>
<td class="tab" id="Tab1"><a href="javascript:Tab(1);"><span>导航菜单</span></a></td>
<!--<td class="tab" id="Tab2"><a href="javascript:Tab(2);"><span>侧边栏</span></a></td>-->
<!--<td class="tab" id="Tab3"><a href="javascript:Tab(3);"><span>首页设置</span></a></td>-->
<td class="tab" id="Tab4"><a href="javascript:Tab(4);"><span>其他设置</span></a></td>
</tr>
</table>
</div>
<form method="post" action="?" id="dform">
<input type="hidden" name="tab" id="tab" value="<?php echo $tab;?>"/>
<div id="Tabs0" style="display:;">
<table cellspacing="1" cellpadding="6" class="tb">
<tr>
<td class="tl">自定义背景色</td>
<td class="tr f_gray"><input name="setting[bgcolor]" type="text" size="10" id="bgcolor" value="<?php echo $bgcolor;?>"/>&nbsp; 例如红色为 red 或者 #FF0000</td>
</tr>
<tr>
<td class="tl">自定义背景图</td>
<td class="tr"><input name="setting[background]" type="text" size="60" id="background" value="<?php echo $background;?>" readonly/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('background').value, true, 'background');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('background').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('background').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl">自定义LOGO</td>
<td class="tr"><input name="setting[logo]" type="text" size="60" id="logo" value="<?php echo $logo;?>" readonly/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('logo').value, true, 'logo');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('logo').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('logo').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl">自定义CSS</td>
<td class="tr"><textarea name="setting[css]" id="css" style="width:500px;height:60px;overflow:visible;font-family:Fixedsys"><?php echo $css;?></textarea></td>
</tr>
<tr>
<td class="tl">横幅宽度</td>
<td class="tr">
<input type="text" size="5" name="setting[bannerw]" value="<?php echo $bannerw;?>" id="bannerw"/> px
&nbsp;&nbsp;&nbsp;&nbsp;高度
<input type="text" size="5" name="setting[bannerh]" value="<?php echo $bannerh;?>" id="bannerh"/> px
</td>
</tr>
<tr>
<td class="tl">横幅显示方式</td>
<td class="tr">
<input name="setting[bannert]" type="radio" id="bannert_0" value="0"<?php if($bannert==0) { ?> checked<?php } ?>
 onclick="Ds('bt_0');Dh('bt_1');Dh('bt_2');"/> <label for="bannert_0">图片</label>&nbsp;&nbsp;
<input name="setting[bannert]" type="radio" id="bannert_1" value="1"<?php if($bannert==1) { ?> checked<?php } ?>
 onclick="Dh('bt_0');Ds('bt_1');Dh('bt_2');"/> <label for="bannert_1">Flash</label>&nbsp;&nbsp;
<input name="setting[bannert]" type="radio" id="bannert_2" value="2"<?php if($bannert==2) { ?> checked<?php } ?>
 onclick="Dh('bt_0');Dh('bt_1');Ds('bt_2');"/> <label for="bannert_2">幻灯片</label>&nbsp;&nbsp;
</td>
</tr>
<tr id="bt_0" style="display:<?php if($bannert!=0) { ?>none<?php } ?>
;">
<td class="tl">横幅图片地址</td>
<td class="tr"><input name="setting[banner]" type="text" size="60" id="banner" value="<?php echo $banner;?>" readonly/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('banner').value, true, 'banner');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('banner').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('banner').value='';" class="jt">[删除]</span></td>
</tr>
<tr id="bt_1" style="display:<?php if($bannert!=1) { ?>none<?php } ?>
;">
<td class="tl">横幅Flash地址</td>
<td class="tr"><input name="setting[bannerf]" type="text" size="60" id="bannerf" value="<?php echo $bannerf;?>" readonly/>&nbsp;&nbsp;<span onclick="Dfile(<?php echo $moduleid;?>, Dd('bannerf').value, 'bannerf', 'swf');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="if(Dd('bannerf').value) window.open(Dd('bannerf').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('bannerf').value='';" class="jt">[删除]</span> <span id="dflash" class="f_red"></span></td>
</tr>
<tbody id="bt_2" style="display:<?php if($bannert!=2) { ?>none<?php } ?>
;">
<tr>
<td class="tl f_red">系统提示</td>
<td class="tr f_gray">&nbsp;仅支持jpg格式图片，且最少上传2张</td>
</tr>
<tr>
<td class="tl">横幅图片地址1</td>
<td class="tr"><input name="setting[banner1]" type="text" size="60" id="banner1" value="<?php echo $banner1;?>" readonly/>&nbsp;&nbsp;<span onclick="Dthumb(<?php echo $moduleid;?>,Dd('bannerw').value,Dd('bannerh').value, Dd('banner1').value, true, 'banner1', 'jpg');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('banner1').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('banner1').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl">横幅图片地址2</td>
<td class="tr"><input name="setting[banner2]" type="text" size="60" id="banner2" value="<?php echo $banner2;?>" readonly/>&nbsp;&nbsp;<span onclick="if(Dd('banner1').value==''){alert('请先上传横幅图片地址1');return false;}Dthumb(<?php echo $moduleid;?>,Dd('bannerw').value,Dd('bannerh').value, Dd('banner2').value, true, 'banner2');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('banner2').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('banner2').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl">横幅图片地址3</td>
<td class="tr"><input name="setting[banner3]" type="text" size="60" id="banner3" value="<?php echo $banner3;?>" readonly/>&nbsp;&nbsp;<span onclick="if(Dd('banner2').value==''){alert('请先上传横幅图片地址2');return false;}Dthumb(<?php echo $moduleid;?>,Dd('bannerw').value,Dd('bannerh').value, Dd('banner3').value, true, 'banner3');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('banner3').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('banner3').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl">横幅图片地址4</td>
<td class="tr"><input name="setting[banner4]" type="text" size="60" id="banner4" value="<?php echo $banner4;?>" readonly/>&nbsp;&nbsp;<span onclick="if(Dd('banner3').value==''){alert('请先上传横幅图片地址3');return false;}Dthumb(<?php echo $moduleid;?>,Dd('bannerw').value,Dd('bannerh').value, Dd('banner4').value, true, 'banner4');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('banner4').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('banner4').value='';" class="jt">[删除]</span></td>
</tr>
<tr>
<td class="tl">横幅图片地址5</td>
<td class="tr"><input name="setting[banner5]" type="text" size="60" id="banner5" value="<?php echo $banner5;?>" readonly/>&nbsp;&nbsp;<span onclick="if(Dd('banner4').value==''){alert('请先上传横幅图片地址4');return false;}Dthumb(<?php echo $moduleid;?>,Dd('bannerw').value,Dd('bannerh').value, Dd('banner5').value, true, 'banner5');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="_preview(Dd('banner5').value);" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('banner5').value='';" class="jt">[删除]</span></td>
</tr>
</tbody>
<tr>
<td class="tl">形象视频地址</td>
<td class="tr"><input name="setting[video]" type="text" size="60" id="video" value="<?php echo $video;?>" onblur="UpdateURL();"/>&nbsp;&nbsp;<span onclick="Dfile(<?php echo $moduleid;?>, Dd('video').value, 'video', 'mp4|flv|wma|wav');" class="jt">[上传]</span>&nbsp;&nbsp;<span onclick="vs();" class="jt">[预览]</span>&nbsp;&nbsp;<span onclick="Dd('video').value='';" class="jt">[删除]</span>
<div id="v_player"></div>
<?php echo load('player.js');?>
<?php echo load('url2video.js');?>
<script type="text/javascript">
function vs() {
UpdateURL();
if(Dd('video').value.length > 5) {
Ds('v_player');
Inner('v_player', player(Dd('video').value,480,400,'',1)+'<br/><a href="javascript:" onclick="vh();" class="t">[关闭预览]</a>');
} else {
vh();
}
}
function vh() {Inner('v_player', '');Dh('v_player');}
function UpdateURL() {
var str = url2video(Dd('video').value);
if(str) Dd('video').value = str;
}
</script>
</td>
</tr>
<tr>
<td class="tl">网站公告</td>
<td class="tr f_gray"><textarea name="setting[announce]" id="announce" style="width:500px;height:60px;"><?php echo $announce;?></textarea><br/>支持HTML语法</td>
</tr>
<tr>
<td class="tl">访问次数</td>
<td class="tr">
<input type="radio" name="setting[show_stats]" value="1" id="s_s_1"<?php if($show_stats==1) { ?> checked<?php } ?>
/><label for="s_s_1"> 显示</label>&nbsp;&nbsp;&nbsp;&nbsp;
<input type="radio" name="setting[show_stats]" value="0" id="s_s_0"<?php if($show_stats==0) { ?> checked<?php } ?>
/><label for="s_s_0"> 不显示</label>
</td>
</tr>
</table>
</div>
<div id="Tabs1" style="display:none;">
<table cellspacing="1" cellpadding="6" class="tb">
<tr style="display:<?php if($MG['home_menu']) { ?><?php } else { ?>none<?php } ?>
;">
<td class="tl">菜单设置<br/><br/><br/><a href="?action=reset&item=menu" class="t" onclick="return confirm('确定要恢复菜单设置为默认吗？');">恢复默认</a></td>
<td class="tr">
<table cellpadding="3" cellspacing="3">
<tr align="center">
<td width="50">显示</td>
<td width="50">排序</td>
<td width="100">名称</td>
<td width="50">分页</td>
</tr>
<?php if(is_array($HMENU)) { foreach($HMENU as $k => $v) { ?>
<?php if(strpos($menu_f, ','.$menu_file[$k].',') !== false) { ?>
<tr align="center">
<td>
<input type="checkbox" name="menu_show_tmp" value="<?php echo $k;?>"<?php if($menu_show[$k]) { ?> checked<?php } ?>
 onclick="Dd('menu_show_<?php echo $k;?>').value=this.checked ? 1 : 0;"/><input type="hidden" name="setting[menu_show][<?php echo $k;?>]" value="<?php echo $menu_show[$k];?>" id="menu_show_<?php echo $k;?>"/>
</td>
<td><input type="text" name="setting[menu_order][<?php echo $k;?>]" size="3" value="<?php echo $menu_order[$k];?>"/></td>
<td><input type="text" name="setting[menu_name][<?php echo $k;?>]" size="20" value="<?php echo $menu_name[$k];?>"/></td>
<td><input type="text" name="setting[menu_num][<?php echo $k;?>]" size="3" value="<?php echo $menu_num[$k];?>"/>
<input type="hidden" name="setting[menu_file][<?php echo $k;?>]" value="<?php echo $menu_file[$k];?>"/></td>
</tr>
<?php } else { ?>
<tr style="display:none;">
<td>
<input type="checkbox" name="menu_show_tmp" value="<?php echo $k;?>"/><input type="hidden" name="setting[menu_show][<?php echo $k;?>]" value="0" id="menu_show_<?php echo $k;?>"/>
</td>
<td><input type="text" name="setting[menu_order][<?php echo $k;?>]" size="3" value="<?php echo $menu_order[$k];?>"/></td>
<td><input type="text" name="setting[menu_name][<?php echo $k;?>]" size="20" value="<?php echo $menu_name[$k];?>"/></td>
<td><input type="text" name="setting[menu_num][<?php echo $k;?>]" size="3" value="<?php echo $menu_num[$k];?>"/>
<input type="hidden" name="setting[menu_file][<?php echo $k;?>]" value="<?php echo $menu_file[$k];?>"/></td>
</tr>
<?php } ?>
<?php } } ?>
</table>
</td>
</tr>
</table>
</div>
<div id="Tabs2" style="display:none;">
<table cellspacing="1" cellpadding="6" class="tb">
<tr>
<td class="tl">侧栏宽度</td>
<td class="tr"><input type="text" size="5" name="setting[side_width]" value="<?php echo $side_width;?>"/> px</td>
</tr>
<tr>
<td class="tl">侧栏位置</td>
<td class="tr">
<table>
<tr align="center">
<td width="100"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/side_l.gif" title="侧栏在左" onclick="Dd('s_p_0').checked=true;"/></td>
<td width="100"><img src="<?php echo DT_STATIC;?><?php echo $MODULE['2']['moduledir'];?>/image/side_r.gif" title="侧栏在右" onclick="Dd('s_p_1').checked=true;"/></td>
</tr>
<tr align="center">
<td><input type="radio" name="setting[side_pos]" value="0" id="s_p_0"<?php if($side_pos==0) { ?> checked<?php } ?>
/><label for="s_p_0">侧栏在左</label></td>
<td><input type="radio" name="setting[side_pos]" value="1" id="s_p_1"<?php if($side_pos==1) { ?> checked<?php } ?>
/><label for="s_p_1">侧栏在右</label></td>
</tr>
</table>
</td>
</tr>
<tr style="display:<?php if($MG['home_side']) { ?><?php } else { ?>none<?php } ?>
;">
<td class="tl">侧栏设置<br/><br/><br/><a href="?action=reset&item=side" class="t" onclick="return confirm('确定要恢复侧栏位置为默认吗？');">恢复默认</a></td>
<td class="tr">
<table cellpadding="3" cellspacing="3">
<tr align="center">
<td width="50">显示</td>
<td width="50">排序</td>
<td width="100">名称</td>
<td width="50">数量</td>
</tr>
<?php if(is_array($HSIDE)) { foreach($HSIDE as $k => $v) { ?>
<?php if(strpos($side_f, ','.$side_file[$k].',') !== false) { ?>
<tr align="center">
<td>
<input type="checkbox" name="side_show_tmp" value="<?php echo $k;?>"<?php if($side_show[$k]) { ?> checked<?php } ?>
 onclick="Dd('side_show_<?php echo $k;?>').value=this.checked ? 1 : 0;"/><input type="hidden" name="setting[side_show][<?php echo $k;?>]" value="<?php echo $side_show[$k];?>" id="side_show_<?php echo $k;?>"/></td>
<td><input type="text" name="setting[side_order][<?php echo $k;?>]" size="3" value="<?php echo $side_order[$k];?>"/></td>
<td><input type="text" name="setting[side_name][<?php echo $k;?>]" size="20" value="<?php echo $side_name[$k];?>"/></td>
<td><input type="text" name="setting[side_num][<?php echo $k;?>]" size="3" value="<?php echo $side_num[$k];?>"/>
<input type="hidden" name="setting[side_file][<?php echo $k;?>]" size="3" value="<?php echo $side_file[$k];?>"/></td>
</tr>
<?php } else { ?>
<tr style="display:none;">
<td>
<input type="checkbox" name="side_show_tmp" value="<?php echo $k;?>"/><input type="hidden" name="setting[side_show][<?php echo $k;?>]" value="0" id="side_show_<?php echo $k;?>"/></td>
<td><input type="text" name="setting[side_order][<?php echo $k;?>]" size="3" value="<?php echo $side_order[$k];?>"/></td>
<td><input type="text" name="setting[side_name][<?php echo $k;?>]" size="20" value="<?php echo $side_name[$k];?>"/></td>
<td><input type="text" name="setting[side_num][<?php echo $k;?>]" size="3" value="<?php echo $side_num[$k];?>"/>
<input type="hidden" name="setting[side_file][<?php echo $k;?>]" size="3" value="<?php echo $side_file[$k];?>"/></td>
</tr>
<?php } ?>
<?php } } ?>
</table>
</td>
</tr>
</table>
</div>
<div id="Tabs3" style="display:none;">
<table cellspacing="1" cellpadding="6" class="tb"><tr style="display:<?php if($MG['home_main']) { ?><?php } else { ?>none<?php } ?>
;">
<td class="tl">首页主栏设置<br/><br/><br/><a href="?action=reset&item=main" class="t" onclick="return confirm('确定要恢复首页主栏为默认吗？');">恢复默认</a></td>
<td class="tr">
<table cellpadding="3" cellspacing="3">
<tr align="center">
<td width="50">显示</td>
<td width="50">排序</td>
<td width="100">名称</td>
<td width="50">数量</td>
</tr>
<?php if(is_array($HMAIN)) { foreach($HMAIN as $k => $v) { ?>
<?php if(strpos($main_f, ','.$main_file[$k].',') !== false) { ?>
<tr align="center">
<td>
<input type="checkbox" name="main_show_tmp" value="<?php echo $k;?>"<?php if($main_show[$k]) { ?> checked<?php } ?>
 onclick="Dd('main_show_<?php echo $k;?>').value=this.checked ? 1 : 0;"/><input type="hidden" name="setting[main_show][<?php echo $k;?>]" value="<?php echo $main_show[$k];?>" id="main_show_<?php echo $k;?>"/></td>
<td><input type="text" name="setting[main_order][<?php echo $k;?>]" size="3" value="<?php echo $main_order[$k];?>"/></td>
<td><input type="text" name="setting[main_name][<?php echo $k;?>]" size="20" value="<?php echo $main_name[$k];?>"/></td>
<td><input type="text" name="setting[main_num][<?php echo $k;?>]" size="3" value="<?php echo $main_num[$k];?>"/>
<input type="hidden" name="setting[main_file][<?php echo $k;?>]" size="3" value="<?php echo $main_file[$k];?>"/></td>
</tr>
<?php } else { ?>
<tr style="display:none;">
<td>
<input type="checkbox" name="main_show_tmp" value="<?php echo $k;?>"/><input type="hidden" name="setting[main_show][<?php echo $k;?>]" value="0" id="main_show_<?php echo $k;?>"/></td>
<td><input type="text" name="setting[main_order][<?php echo $k;?>]" size="3" value="<?php echo $main_order[$k];?>"/></td>
<td><input type="text" name="setting[main_name][<?php echo $k;?>]" size="20" value="<?php echo $main_name[$k];?>"/></td>
<td><input type="text" name="setting[main_num][<?php echo $k;?>]" size="3" value="<?php echo $main_num[$k];?>"/>
<input type="hidden" name="setting[main_file][<?php echo $k;?>]" size="3" value="<?php echo $main_file[$k];?>"/></td>
</tr>
<?php } ?>
<?php } } ?>
</table>
</td>
</tr>
<tr>
<td class="tl">公司简介显示</td>
<td class="tr"><input type="text" size="5" name="setting[intro_length]" value="<?php echo $intro_length;?>"/> 字符</td>
</tr>
</table>
</div>
<div id="Tabs4" style="display:none;">
<table cellspacing="1" cellpadding="6" class="tb">
<tr>
<td class="tl">首页SEO标题</td>
<td class="tr f_gray"><input type="text" size="60" name="setting[seo_title]" value="<?php echo $seo_title;?>"/>&nbsp; 留空则显示公司名称</td>
</tr>
<tr>
<td class="tl">网站关键词</td>
<td class="tr"><input type="text" size="80" name="setting[seo_keywords]" value="<?php echo $seo_keywords;?>"/></td>
</tr>
<tr>
<td class="tl">网站描述</td>
<td class="tr"><input type="text" size="80" name="setting[seo_description]" value="<?php echo $seo_description;?>"/></td>
</tr>
<?php if($api_map && $MG['map']) { ?>
<?php include DT_ROOT.'/api/map/'.$api_map.'/post.inc.php';?>
<?php } ?>
<?php if($api_stats && $MG['stats']) { ?>
<?php include DT_ROOT.'/api/stats/these.name.php';?>
<tr>
<td class="tl">统计类型</td>
<td class="tr">
<select name="setting[stats_type]" id="stats_type_s" onchange="stats_type(this.value)">
<?php if(is_array($api_stats)) { foreach($api_stats as $v) { ?>
<option value="<?php echo $v;?>"><?php echo $names[$v];?></option>
<?php } } ?>
</select>
</td>
</tr>
<?php if(is_array($api_stats)) { foreach($api_stats as $v) { ?>
<?php include DT_ROOT.'/api/stats/'.$v.'/post.inc.php';?>
<?php } } ?>
<?php } ?>
<?php if($api_kf && $MG['kf']) { ?>
<?php include DT_ROOT.'/api/kf/these.name.php';?>
<tr>
<td class="tl">客服类型</td>
<td class="tr">
<select name="setting[kf_type]" id="kf_type_s" onchange="kf_type(this.value)">
<?php if(is_array($api_kf)) { foreach($api_kf as $v) { ?>
<option value="<?php echo $v;?>"><?php echo $names[$v];?></option>
<?php } } ?>
</select>
</td>
</tr>
<?php if(is_array($api_kf)) { foreach($api_kf as $v) { ?>
<?php include DT_ROOT.'/api/kf/'.$v.'/post.inc.php';?>
<?php } } ?>
<?php } ?>
</table>
</div>
<table cellspacing="1" cellpadding="6" class="tb">
<tr>
<td class="tl">&nbsp;</td>
<td class="tr" height="30"><input type="submit" name="submit" value=" 保存设置 " class="btn_g"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="submit" value=" 清空设置 " class="btn" onclick="if(confirm('确定要清空设置吗？商铺所有设置将被清空')){this.form.action='?reset=1';}else{return false;}"/></td>
</tr>
</table>
</form>
<?php echo load('clear.js');?>
<script type="text/javascript">
s('homepage');
<?php if($tab) { ?>
Tab(<?php echo $tab;?>);
<?php } else { ?>
m('Tab0');
<?php } ?>
<?php if($api_stats && $MG['stats']) { ?>
function stats_type(type) {
var stats_types = [<?php if(is_array($api_stats)) { foreach($api_stats as $k => $v) { ?><?php if($k) { ?>,<?php } ?>
'<?php echo $v;?>'<?php } } ?>];
var stats_pass = 0;
for(var i = 0; i < stats_types.length; i++) {
if(type == stats_types[i]) {
stats_pass = 1;
break;
}
}
if(stats_pass == 0) type = stats_types[0];
for(var i = 0; i < stats_types.length; i++) {
if(type == stats_types[i]) {
Ds('stats_post_'+stats_types[i]);
} else {
Dh('stats_post_'+stats_types[i]);
}
}
$('#stats_type_s').val(type);
}
stats_type('<?php echo $stats_type;?>');
<?php } ?>
<?php if($api_kf && $MG['kf']) { ?>
function kf_type(type) {
var kf_types = [<?php if(is_array($api_kf)) { foreach($api_kf as $k => $v) { ?><?php if($k) { ?>,<?php } ?>
'<?php echo $v;?>'<?php } } ?>];
var kf_pass = 0;
for(var i = 0; i < kf_types.length; i++) {
if(type == kf_types[i]) {
kf_pass = 1;
break;
}
}
if(kf_pass == 0) type = kf_types[0];
for(var i = 0; i < kf_types.length; i++) {
if(type == kf_types[i]) {
Ds('kf_post_'+kf_types[i]);
} else {
Dh('kf_post_'+kf_types[i]);
}
$('#kf_type_s').val(type);
}
}
kf_type('<?php echo $kf_type;?>');
<?php } ?>
</script>
<?php include template('footer', 'member');?>