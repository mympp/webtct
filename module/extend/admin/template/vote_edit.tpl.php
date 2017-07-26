<?php
defined('DT_ADMIN') or exit('Access Denied');
include tpl('header');
show_menu($menus);
?>
<form method="post" action="?" id="dform" onsubmit="return check();">
<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
<input type="hidden" name="file" value="<?php echo $file;?>"/>
<input type="hidden" name="action" value="<?php echo $action;?>"/>
<input type="hidden" name="forward" value="<?php echo $forward;?>"/>
<input type="hidden" name="itemid" value="<?php echo $itemid;?>"/>
<input type="hidden" name="post[vv]" value="<?php echo $vv;?>"/>
<input type="hidden" name="post[s_num]" value="<?php echo $s_num;?>" id="s_num"/>
<div class="tt"><?php echo $action == 'add' ? '添加' : '修改';?>投票</div>
<table cellpadding="2" cellspacing="1" class="tb">
<tr>
<td class="tl"><span class="f_red">*</span> 投票分类</td>
<td><span id="type_box"><?php echo type_select('vote', 1, 'post[typeid]', '请选择分类', $typeid, 'id="typeid"');?></span> <a href="javascript:var type_item='vote',type_name='post[typeid]',type_default='请选择分类',type_id=<?php echo $typeid;?>,type_interval=setInterval('type_reload()',500);Dwidget('?file=type&item=<?php echo $file;?>', '投票分类');"><img src="<?php echo $MODULE[2]['linkurl'];?>image/img_add.gif" width="12" height="12" title="管理分类"/></a> <span id="dtypeid" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 投票标题</td>
<td><input name="post[title]" type="text" id="title" size="50" value="<?php echo $title;?>"/> <?php echo dstyle('post[style]', $style);?>&nbsp; <?php echo level_select('post[level]', '级别', $level);?> <span id="dtitle" class="f_red"></span></td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 主题图</td>
<td ><input name="post[thumb]" id="thumb" type="text" size="50" value="<?php echo $thumb;?>" readonly/>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('thumb').value);" class="t">[上传]</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="_preview(Dd('thumb').value);" class="t">[预览]</a>&nbsp;&nbsp;<a href="javascript:void(0);" onclick="Dd('thumb').value='';" class="t">[删除]</a></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 投票有效期</td>
<td><?php echo dcalendar('post[fromtime]', $fromtime);?> 至 <?php echo dcalendar('post[totime]', $totime);?> <?php echo tips('不填表示不限时间');?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 链接至</td>
<td><input name="post[linkto]" type="text" id="linkto" size="50" value="<?php echo $linkto;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 投票说明</td>
<td><textarea name="post[content]" id="content" class="dsn"><?php echo $content;?></textarea>
<?php echo deditor($moduleid, 'content', 'Destoon', '100%', 350);?><br/><span id="dcontent" class="f_red"></span>
</td>
</tr>
<tr>
<td class="tl"><span class="f_red">*</span> 投票类别</td>
<td>
<input type="radio" name="post[choose]" value="0" id="choose_0"<?php if(!$choose) echo ' checked';?> onclick="Dh('vote_num');"/><label for="choose_0"> 单选</label>
<input type="radio" name="post[choose]" value="1" id="choose_1"<?php if($choose) echo ' checked';?> onclick="Ds('vote_num');"/><label for="choose_1"> 多选</label>
</td>
</tr>

<tr id="vote_num" style="display:<?php echo $choose ? '' : 'none';?>">
<td class="tl"><span class="f_red">*</span> 必选数量</td>
<td>
<input name="post[vote_min]" type="text" id="vote_min" size="5" value="<?php echo $vote_min;?>"/>
至
<input name="post[vote_max]" type="text" id="vote_max" size="5" value="<?php echo $vote_max;?>"/>
</td>
</tr>
<tr title="请保持时间格式">
<td class="tl"><span class="f_hid">*</span> 添加时间</td>
<td><input type="text" size="22" name="post[addtime]" value="<?php echo $addtime;?>"/></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 限制会员</td>
<td><?php echo group_checkbox('post[groupid][]', $groupid);?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 验证方式</td>
<td>
<select name="post[verify]">
<option value="0"<?php if($verify == 0) echo ' selected';?>>不验证</option>
<option value="1"<?php if($verify == 1) echo ' selected';?>>验证码</option> 
<option value="2"<?php if($verify == 2) echo ' selected';?>>验证问题</option> 
</select>
</td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 投票模板</td>
<td><?php echo tpl_select('vote', 'chip', 'post[template_vote]', '默认模板', $template_vote);?></td>
</tr>
<tr>
<td class="tl"><span class="f_hid">*</span> 结果模板</td>
<td><?php echo tpl_select('vote', $module, 'post[template]', '默认模板', $template);?></td>
</tr>
<?php if($DT['city']) { ?>
<tr>
<td class="tl"><span class="f_hid">*</span> 地区(分站)</td>
<td><?php echo ajax_area_select('post[areaid]', '请选择', $areaid);?></td>
</tr>
<?php } ?>
<tr>
	<td class="tl"><span class="f_red">*</span> 显示投票结果</td>
	<td>
	<input type="radio" name="post[v_show]" value="1" id="v_show_1"<?php if($v_show) echo ' checked';?> /><label for="v_show_1"> 是</label>
	<input type="radio" name="post[v_show]" value="0" id="v_show_0"<?php if(!$v_show) echo ' checked';?> /><label for="v_show_0"> 否</label>			
	</td>
</tr>
<tr>
	<td class="tl"><span class="f_red">*</span> 投票调查状态</td>
	<td>
	<input type="radio" name="post[status]" value="3" id="v_status_3"<?php if($status==3) echo ' checked';?> /><label for="v_status_3"> 通过</label>
	<input type="radio" name="post[status]" value="2" id="v_status_2"<?php if($status==2) echo ' checked';?> /><label for="v_status_2"> 待审</label>			
	<input type="radio" name="post[status]" value="1" id="v_status_1"<?php if($status==1) echo ' checked';?> /><label for="v_status_1"> 拒绝</label>			
	</td>
</tr>
<tr>
	<td class="tl"> 奖项设置</td>
	<td>
		<?php for ($i=1; $i <= 3; $i++) { ?>
			<input type="text" placeholder="如：<?php echo $i;?> 等奖" name="post[j<?php echo $i;?>]" value="<?php echo $j_arr[$i-1];?>"/>
			<input type="text" placeholder="如：Apple iPhone 6s plus" name="post[x<?php echo $i;?>]" value="<?php echo $x_arr[$i-1];?>" size="30"/></br>
		<?php } ?>
	</td>
</tr>
<tr>
	<td class="tl"> 奖项说明</td>
	<td>
		<input type="text" name="post[j_explain]" value="<?php echo $j_explain;?>" placeholder="如：该活动解释权归本公司所有" size="100"/>
	</td>
</tr>
<table class="tb" id="tab">
<?php for($i=1;$i<=$s_num;$i++) { $s = 's'.$i; $p = 'p'.$i; ?>
	<tr>
		<td class="tl" style="width:10%;"> 投票主题<?php echo $i;?></td>
		<td style="width:70%;">
			<input name="post[s<?php echo $i;?>]" type="text" id="s<?php echo $i;?>" size="50" value="<?php echo $s_arr[$i-1];?>"/>&nbsp;&nbsp;
			<span class="tl">选项图<?php echo $i;?></span><input name="post[p<?php echo $i;?>]" id="thumb<?php echo $i;?>" type="text" size="40" value="<?php echo $p_arr[$i-1];?>"/>&nbsp;&nbsp;
			<span onclick="Dthumb(<?php echo $moduleid;?>,0,0, Dd('thumb<?php echo $i;?>').value, true, 'thumb<?php echo $i;?>');" class="jt">[上传]</span>&nbsp;&nbsp;
			<span onclick="_preview(Dd('thumb<?php echo $i;?>').value);" class="jt">[预览]</span>&nbsp;&nbsp;
			<span onclick="Dd('thumb<?php echo $i;?>').value='';" class="jt">[删除]</span>	
		</td>						
	</tr>
	<tr class="trl">
		<td class="tl">说明</td>				
		<td><textarea placeholder="限80字以内" style="height:35px;width:70%;" name="post[e<?php echo $i;?>]" type="text" id="e<?php echo $i;?>"><?php echo $e_arr[$i-1];?></textarea></td>
	</tr>
<?php } ?>
</table>
</table>
<div class="sbt"><input type="button" id="but" value="增加选项" class="btn2"/></div>
<div class="sbt"><input type="submit" name="submit" value=" 确 定 " class="btn"/>&nbsp;&nbsp;&nbsp;&nbsp;<input type="reset" name="reset" value=" 重 置 " class="btn"/></div>
</form>
<?php load('clear.js'); ?>
<script type="text/javascript">
$(document).ready(function(){       
        //增加
        $("#but").click(function(){
            var _len = $("#tab tr").length/2+1; 
            $("#s_num").val(_len);
            $("#tab").append("<tr id="+_len+">"
                                +"<td class='tl'> 投票主题"+_len+"</td>"
                                +"<td><input name='post[s"+_len+"]' type='text' class='inputtext' id='s"+_len+"' size='50' value=''/>&nbsp;&nbsp;<span class='tl'>选项图"+_len+"</span><input name='post[p"+_len+"]' id='thumb"+_len+"' type='text' class='inputtext' size='40' value=''/>&nbsp;&nbsp;<span onclick=\"Dthumb(<?php echo $moduleid;?>,0,0, Dd('thumb"+_len+"').value,true,'thumb"+_len+"');\" class='jt'>[上传]</span>&nbsp;&nbsp;<span onclick=\"_preview(Dd('thumb"+_len+"').value);\" class='jt'>[预览]</span>&nbsp;&nbsp;<span onclick=\"Dd('thumb"+_len+"').value='';\" class='jt'>[删除]</span></td>"                                
                            +"</tr>"
                            +"<tr id='sm"+_len+"' class='trl'>"
								+"<td class='tl'>说明</td>"
								+"<td><textarea style='height:35px;width:70%;margin-right:50px;' name='post[e"+_len+"]' type='text' id='e"+_len+"'></textarea>"
								+"<a href='javascript:void(0);' onclick=\'deltr("+_len+")\'><img src='admin/image/delete.png' width='16' height='16' title='删除' ></a></td>"
							+"</tr>");            
        })    
    })
	var deltr =function(index) {
       	var _len = $("#tab tr").length/2+1; 
       	$("#s_num").val(_len);
        $("tr[id='"+index+"']").remove();//删除当前行
        $("tr[id='sm"+index+"']").remove();
        for(var i=index+1,j=_len;i<j;i++) {
            
            var s_nextTxtVal = $("#s"+i).val();
            var p_nextTxtVal = $("#thumb"+i).val();
            var e_nextTxtVal = $("#e"+i).val();
            $("tr[id=\'"+i+"\']").replaceWith("<tr id="+(i-1)+">"
                                +"<td class='tl'> 投票主题"+(i-1)+"</td>"
                                +"<td><input name='post[s"+(i-1)+"]' type='text' class='inputtext' id='s"+(i-1)+"' size='50' value='"+s_nextTxtVal+"'/>&nbsp;&nbsp;<span class='tl'>选项图"+(i-1)+"</span><input name='post[p"+(i-1)+"]' id='thumb"+(i-1)+"' type='text' class='inputtext' size='40' value='"+p_nextTxtVal+"'/>&nbsp;&nbsp;<span onclick=\"Dthumb(<?php echo $moduleid;?>,0,0, Dd('thumb"+(i-1)+"').value,true,'thumb"+(i-1)+"');\" class='jt'>[上传]</span>&nbsp;&nbsp;<span onclick=\"_preview(Dd('thumb"+(i-1)+"').value);\" class='jt'>[预览]</span>&nbsp;&nbsp;<span onclick=\"Dd('thumb"+(i-1)+"').value='';\" class='jt'>[删除]</span></td>"                                
                            +"</tr>"); 
			$("tr[id=\'sm"+i+"\']").replaceWith("<tr id=sm"+(i-1)+" class='trl'>"
													+"<td class='tl'>说明</td>"
													+"<td><textarea style='height:35px;width:70%;margin-right:50px;' name='post[e"+(i-1)+"]' type='text' id='e"+(i-1)+"'>"+e_nextTxtVal+"</textarea>"
													+"<a href='javascript:void(0);' onclick=\'deltr("+(i-1)+")\'><img src='admin/image/delete.png' width='16' height='16' title='删除' ></a></td>"
												+"</tr>");
        }    
        
    }
function check() {
	var l;
	var f;
	f = 'typeid';
	l = Dd(f).value;
	if(l == 0) {
		Dmsg('请选择投票分类', f);
		return false;
	}
	f = 'title';
	l = Dd(f).value.length;
	if(l < 2) {
		Dmsg('标题最少2字，当前已输入'+l+'字', f);
		return false;
	}
	return true;
}
</script>
<script type="text/javascript">Menuon(<?php echo $menuid;?>);</script>
<?php include tpl('footer');?>