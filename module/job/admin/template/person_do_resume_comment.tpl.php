<?php 

?>
<?php
defined('IN_DESTOON') or exit('Access Denied');
include tpl('header');
?>

<table cellpadding="2" cellspacing="1" class="tb">
  <tr>
  	<th colspan="4"></th>
  </tr>
  <tr>
    <td width="70" align="right" scope="row"><strong>姓名</strong></td>
    <td>&nbsp;&nbsp;<?php echo $truename;?></td>
    <td align="center" width="50"><strong>会员名</strong></td>
    <td>&nbsp;&nbsp;<?php echo $username;?></td>
  </tr>
  <tr>
    <td align="right" scope="row"><strong>自我推荐</strong></td>
    <td colspan="3">&nbsp;&nbsp;<?php echo $introduce;?></td>
  </tr>
<form action="?" name="myform" method="post">
<input type="hidden" name="post[itemid]" value="<?php echo $itemid;?>" />
  <tr>
    <td rowspan="3" align="right" scope="row"><strong>评分选择</strong></td>
    <td colspan="3">&nbsp;&nbsp;<strong>服务态度:</strong>&nbsp;&nbsp;
		<select name="post[star_attitude]">
			<option value="0">--请选择服务态度分数--</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>分
	</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;&nbsp;<strong>响应时间:</strong>&nbsp;&nbsp;
		<select name="post[star_time]">
			<option value="0">--请选择响应时间分数--</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>分
	</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;&nbsp;<strong>技术能力:</strong>&nbsp;&nbsp;
		<select name="post[star_quality]">
			<option value="0">--请选择技术能力分数--</option>
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>分
	</td>
  </tr>
  <tr>
    <td align="right" scope="row">&nbsp;&nbsp;<strong>点评</strong></td>
	<td colspan="2">
		<b>请选择会员</b>（此会员组只能是天成成员或管理员）
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
		<input type="hidden" name="post[seled_members]" id="seled_members" />
	</td>
    <td>
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
		<input type="hidden" name="post[seled_comments]" id="seled_comments" />
	</td>
  </tr>
  <tr>
    <td align="right" scope="row">&nbsp;</td>
    <td colspan="3">&nbsp;&nbsp;
		<input type="submit" name="submit" value=" 确定评价 " onclick="this.form.action='?moduleid=9&file=person_do_job&action=person_do_resume_commented';" />
		<input type="submit" name="submit" value=" 关闭窗口 " onclick="window.parent.location.reload(window.close());" />
	</td>
  </tr>
</table>
</form>
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