<?php 
	//文件说明
	//2013-07-11
	//$member 的查询 由person_do_job.class.php 的 function comments()函数提供；
	//$title、$moduleid、$linkurl、$itemid、$username、$jobid 由person_do_job.tpl.php 的“升人气”超链接传递过来；
?>
<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>
<table cellpadding="2" cellspacing="1" class="tb">
  <tr>
    <td colspan="2" width="40%"><h2>&nbsp;&nbsp;<?php echo $title;?></h2></td>
    <td colspan="2"><font style="color:red">发布者：<?php echo $username;?></font></td>
  </tr>
<!---->
<form action="?" name="myform" method="post">
	<input type="hidden" name="post[item_mid]" value="16" />
	<input type="hidden" name="post[item_id]" value="<?php echo $itemid?>" />
	<input type="hidden" name="post[item_title]" value="<?php echo $title;?>" />
	<input type="hidden" name="post[item_linkurl]" value="show.php?itemid=<?php echo $itemid;?>" />
	<input type="hidden" name="post[item_username]" value="<?php echo $username;?>" />
  <tr>
    <td><strong>人气点评：</strong></td>
	<td  valign="top">
<b>请拟写评价会员名称</b><br/>
<textarea cols="45" rows="5" name="post[seled_members]" id="seled_members"></textarea>
<br/>
<b><font style="color:red;">用“|”分割，并以“|”结束</font></b>
	</td>
    <td colspan="2"  valign="top">
<b>请选择评语</b>
<table border="0" width="100%"> 
<tr> 
<td width="45%"> 
<select style="width:100%" multiple name="sel_comment" size="12" ondblclick="moveOption(document.myform.sel_comment, document.myform.seled_comment)">
			  <?php foreach($comments as $k=>$v){?>
				<option value="<?php echo $v['content'];?>"><?php echo $v['title'];?></option> 
			  <?php }?>
</select> 
</td> 
<td width="10%" align="center"> 
<input type="button" value="添加>" onClick="moveOption(document.myform.sel_comment, document.myform.seled_comment)"><br/><br/> 
<input type="button" value="<删除" onClick="moveOption(document.myform.seled_comment, document.myform.sel_comment)"> 
</td> 
<td width="45%"> 
<select style="width:100%" multiple name="seled_comment" size="12" ondblclick="moveOption(document.myform.seled_comment, document.myform.sel_comment)"> 
</select> 
</td> 
</tr> 
</table> 
<input type="hidden" name="post[seled_comments]" id="seled_comments"> 

	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3">
		<input type="submit" name="submit" value=" 确定评价 " onclick="this.form.action='?moduleid=9&file=person_do_job&action=pingjia_commented';" />
		<input type="submit" name="submit" value=" 操作已有评价 " onclick="this.form.action='?moduleid=9&file=person_do_job&action=pingjia_caozuo&title=<?php echo $title;?>&username=<?php echo $username;?>&linkurl=show.php?itemid=<?php echo $itemid;?>&itemid=<?php echo $itemid;?>';"/>
		<input type="submit" name="submit" value=" 关闭窗口 " onclick="window.parent.location.reload(window.close());" />
	</td>
  </tr>
</form>
<!---->
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" style="color:red">点评规则：<br/>一个会员对一条评语：该会员用该评语进行点评<br/>多个会员对多条评语（会员数须跟评语数相等）：每个会员按顺序选择一条评语进行点评</td>
  </tr>
  <tr>
    <th>点评者</th>
    <th colspan="3">评价与操作</th>
  </tr>
  <?php foreach($sel_pingjia as $k=>$v){?>
  <tr>
    <td><?php echo $v["buyer"];?></td>
    <td colspan="3">
		<?php echo $v["seller_comment"];?>
		<a href="?moduleid=9&file=person_do_job&action=delete_pingjia&itemid=<?php echo $v['itemid'];?>&mallid=<?php echo $v['mallid'];?>" onclick="return _delete();"><img src="admin/image/delete.png" width="16" height="16" title="删除" alt=""/></a>
	</td>
  </tr>
  <?php }?>
</table>
<script language="JavaScript"> 
<!-- 
function moveOption(e1, e2){ 
	try{ 
		for(var i=0;i<e1.options.length;i++){ 
			if(e1.options[i].selected){ 
				var e = e1.options[i]; 
				e2.options.add(new Option(e.text, e.value)); 
				//e2.value += e.value+",";
				e1.remove(i); 
				ii=i-1 
			} 
		} 
		//document.getElementById("seled_members").value=getvalue(document.myform.seled_member); 
		document.getElementById("seled_comments").value=getvalue(document.myform.seled_comment); 
	}catch(e){} 
} 
function getvalue(geto){ 
	var allvalue = ""; 
	for(var i=0;i<geto.options.length;i++){ 
		allvalue +=geto.options[i].value + "|"; 
	} 
	return allvalue; 
} 
//--> 
</script> 
<?php include tpl('footer');?>