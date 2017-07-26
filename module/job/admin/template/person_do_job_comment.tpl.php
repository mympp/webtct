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
    <td colspan="2" width="35%"><h2>&nbsp;&nbsp;<?php echo $title;?></h2></td>
    <td colspan="2"><font style="color:red">发布者：<?php echo $username;?></font></td>
  </tr>
<form action="?" method="post">
  <tr>
    <td width="15%"><strong>人气报名：</strong></td>
    <td colspan="3">
		<input type="hidden" name="moduleid" value="<?php echo $moduleid;?>"/>
		<input type="hidden" name="file" value="<?php echo $file;?>" />
		<input type="hidden" name="action" value="apply" />
		<?php foreach($members as $k=>$v){?>
			<?php if($v['username']!=$username && $v['num'] != 0){?>
				<input type="checkbox" name="txt[]" value="<?php echo $jobid;?>,<?php echo $title;?>,<?php echo $v['resumeid'];?>,<?php echo $username;?>,<?php echo $v['username']?>"/>
			<?php }else{echo "&nbsp;";}  echo $v['username']."&nbsp;&nbsp;|&nbsp;";?>
		<?php }?>
	</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="3"><input type="submit" name="submit" value=" 确定报名 " />&nbsp;&nbsp;<font style="color:red">发布者、没有技术供应者不得报名</font></td>
  </tr>
</form>
<!---->
<form action="?" name="myform" method="post">
	<input type="hidden" name="post[item_mid]" value="<?php echo $moduleid;?>" />
	<input type="hidden" name="post[item_id]" value="<?php echo $itemid?>" />
	<input type="hidden" name="post[item_title]" value="<?php echo $title;?>" />
	<input type="hidden" name="post[item_linkurl]" value="show.php?itemid=<?php echo $itemid;?>" />
	<input type="hidden" name="post[item_username]" value="<?php echo $username;?>" />
  <tr>
    <td><strong>人气点评：</strong></td>
	<td  valign="top">
<b>请选择会员</b>
<table border="0" width="300"> 
<tr> 
<td width="40%"> 
<select style="width:100%" multiple name="sel_member" size="12" ondblclick="moveOption(document.myform.sel_member, document.myform.seled_member)">
			  <?php foreach($members as $k=>$v){?>
				<option value="<?php echo $v['username'];?>"><?php echo $v['username'];?></option> 
			  <?php }?>
</select> 
</td> 
<td width="20%" align="center"> 
<input type="button" value="添加>" onClick="moveOption(document.myform.sel_member, document.myform.seled_member)"><br/><br/> 
<input type="button" value="<删除" onClick="moveOption(document.myform.seled_member, document.myform.sel_member)"> 
</td> 
<td width="40%"> 
<select style="width:100%" multiple name="seled_member" size="12" ondblclick="moveOption(document.myform.seled_member, document.myform.sel_member)"> 
</select>
</td> 
</tr> 
</table> 
<input type="hidden" name="post[seled_members]" id="seled_members">

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
		<input type="submit" name="submit" value=" 确定点评 " onclick="this.form.action='?moduleid=9&file=person_do_job&action=commented';" />
	</td>
  </tr>
</form>
<!---->
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" style="color:red">点评规则：<br/>一个会员对一条评语：该会员用该评语进行点评<br/>多个会员对一条评语：每个会员都用这条评语进行点评<br/>一个会员对多条评语：随机选择一条评语进行点评<br/>多个会员对多条评语：每个会员随机选择一条评语进行点评</td>
  </tr>
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
		document.getElementById("seled_members").value=getvalue(document.myform.seled_member); 
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