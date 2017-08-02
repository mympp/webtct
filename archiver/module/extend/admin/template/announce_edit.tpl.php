<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<div class="tt"><?php echo $action == 'add' ? '添加' : '修改';?>公告</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 数据操作</td>
<td><input type="radio" name="chk" value=0 onclick="Dd('daoru').style.display='none';Dd('shoudong').style.display='block';Dd('actions').value='add';" checked="checked">手动单个录入&nbsp;&nbsp;<input type="radio" name="chk" value=1 onclick="Dd('daoru').style.display='block';Dd('shoudong').style.display='none';Dd('actions').value='check_daoru';">批量处理</td>
</tr>
</table>

<table cellpadding="2" cellspacing="1" class="tb" id="daoru" style="display:none">
<form method="post" action="?" id="dform"">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" id="actions" value="<?php echo $action;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<tr>
<td class="tl"><span class="f_red">*</span> 批量处理</td>
<td>
<textarea name="post[content]" id="dsn" rows="30" cols="120"></textarea><br/>
</td>
</tr>
<tr>
<td class="tl">对话字数：</td>
<td><input name="post[content_len]" value="8" />(限制对话字数，小于等于该值的对话全部PASS掉！)</td>
</tr>
<tr>
<td></td>
<td>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</td>
</tr>
</form>
</table>

<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" id="actions" value="<?php echo $action;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<div class="tt"><?php echo $action == 'add' ? '添加' : '修改';?>公告</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 公告分类</td>
<td><span id="type_box"><?php echo type_select('announce', 1, 'post[typeid]', '请选择分类', $typeid, 'id="typeid"');?></span> <a href="javascript:var type_item='announce',type_name='post[typeid]',type_default='请选择分类',type_id=<?php echo $typeid;?>,type_interval=setInterval('type_reload()',500);Dwidget('?file=type&item=<?php echo $file;?>', '公告分类');"><img src="<?php echo $MODULE[2]['linkurl'];?>image/img_add.gif" width="12" height="12" title="管理分类"/></a> <span id="dtypeid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 公告标题</td>
<td><input name="post[title]" type="text" id="title" size="50" value="<?php echo $title;?>"/> <?php echo dstyle('post[style]', $style);?>&nbsp; <?php echo level_select('post[level]', '级别', $level);?> &nbsp;<input type="checkbox" name="post[islink]" value="1" id="islink" onclick="_islink();"  <?php if($islink) echo 'checked';?>/> 外部链接 <br/><span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 公告有效期</td>
<td><?php echo dcalendar('post[fromtime]', $fromtime);?> 至 <?php echo dcalendar('post[totime]', $totime);?></td>
</tr>
<tr id="link" style="display:<?php echo $islink ? '' : 'none';?>;">
<td class="tl"><span class="f_red">*</span> 链接地址</td>
<td><input name="post[linkurl]" type="text" id="linkurl" size="50" value="<?php echo $linkurl;?>"/> <span id="dlinkurl" class="f_red"></span></td>
</tr>
<tbody id="basic" style="display:<?php echo $islink ? 'none' : '';?>;">
<tr>
<td class="tl"><span class="f_red">*</span> 公告内容<div id="basic"></div></td>
<td>
<div id="zhqun" style="display:block">
<textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', 'Destoon', '98%', 350);?><span id="dcontent" class="f_red"></span>
</div>
</td>
</tr>
<tr>
<td class="tl" height="30"><span class="f_hid">*</span> 内容选项</td>
<td><input type="checkbox" name="post[save_remotepic]" value="1"/> 下载内容远程图片
<input type="checkbox" name="post[clear_link]" value="1"/> 清除内容链接
</td>
</tr>
<?php if($DT['city']) { ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 地区(分站)</td>
<td><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?></td>
</tr>
<?php } ?>
<tr title="请保持时间格式">
<td class="tl"><span class="f_hid">*</span> 添加时间</td>
<td><input type="text" size="22" name="post[addtime]" value="<?php echo $addtime;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 内容模板</td>
<td><?php echo tpl_select('announce', $module, 'post[template]', '默认模板', $template);?></td>
</tr>
<tr>
<td></td>
<td>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</td>
</tr>
</table>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
String.prototype.replaceAll = function(s1,s2) { 
return this.replace(new RegExp(s1,"gm"),s2); 
} 

function zhqun(){
 var reg = /\([^\)]+\)/g;
 var str1;
 var str3;
                var str = Dd('quntext').value;
				var strz=str;
                var tmp = str.match(reg);
                if (tmp) {
                    for (var i = 0; i<tmp.length; i++) {
                        str1=tmp[i].replace("(","");
						str1=str1.replace(")","");    
						str3=tmp[i].replace("(","(点击联系QQ:");
						strz=strz.replace(tmp[i]+"\r\n","<a href='http://wpa.qq.com/msgrd?v=3&uin="+str1+"&site=天成医疗网&menu=yes'>"+str3+"</a><span>");		
                    }
					strz="<li>"+strz;
					strz=strz.replace(/\n/g, "<br>");
                    for (var i = 0; i<300; i++) {
                       	strz=strz.replace("\n2011-","\n<li>"+"2011-");
						strz=strz.replace("\n2012-","\n<li>"+"2012-");
						strz=strz.replace("\n2013-","\n<li>"+"2013-");
						strz=strz.replace("\n2014-","\n<li>"+"2014-");
						strz=strz.replace("\n2015-","\n<li>"+"2015-");	
						strz=strz.replace("<br>2011-","\n<li>"+"2011-");
						strz=strz.replace("<br>2012-","\n<li>"+"2012-");
						strz=strz.replace("<br>2013-","\n<li>"+"2013-");
						strz=strz.replace("<br>2014-","\n<li>"+"2014-");
						strz=strz.replace("<br>2015-","\n<li>"+"2015-");
                    }
				}
				    var oEditor = FCKeditorAPI.GetInstance('content');   
                    oEditor.SetHTML(strz);	
}
function htmls(){var oEditor = FCKeditorAPI.GetInstance('content');   
				strz=oEditor.GetXHTML(true);
				strz=strz.replaceAll("</li>","</div><form target='_blank' action='my.php'><input type=submit value='完善并推广' onmouseover='this.nextSibling.value=this.previousSibling.value'><input style='display:none' name='qtitle'></form></lI>");
				var oEditor = FCKeditorAPI.GetInstance('content');   
                    oEditor.SetHTML(strz);	
				}
function check() {
	var l;
	var f;
	f = 'typeid';
	l = Dd(f).value;
	if(l == 0) {
		Dmsg('请选择公告分类', f);
		return false;
	}
	f = 'title';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('标题最少2字，当前已输入'+l+'字', f);
		return false;
	}
	if(Dd('islink').checked) {
		f = 'linkurl';
		l = Dd(f).value.length;
		if(l < 12) {
			Dmsg('请输入正确的链接地址', f);
			return false;
		}
	} else {
		f = 'content';
		l = FCKLen();
		if(l < 5) {
			Dmsg('内容最少5字，当前已输入'+l+'字', f);
			return false;
		}
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>