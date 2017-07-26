<?php
	defined('IN_DESTOON') or exit('Access Denied');
	#2014-04-14
	#tc_Dahe
	#关联文件&代码块：
	#		/include/tece.func.php -> function send_test_tc_mail
	#		/include/tc_mail.class.php
	#		/include/global.func.php -> function send_mail()
	#		/file/tc_email/emailSmtps.php
	#		/file/tc_email/testEmail.txt
	#		/admin/setting.inc.php -> 29行到99行 $action == 'tc_mail'
	#		/admin/template/setting.tpl.php -> 928行到936行
	#		/admin/template/tc_mail.tpl.php
	#数据库：
	#	mail_log
	#		1.添加字段istcmail：0为DT邮局发送，1为TC邮局发送
	#		2.添加字段tcmail_from：记录使用TC邮局发送的发件箱
	include tpl('header');
	$testEmail=file(DT_ROOT."/file/tc_email/testEmail.txt");
?>
<table cellpadding="2" cellspacing="1" class="tb">
	<tr>
	<form action="?" method="post">
		<input type="hidden" name="file" value="setting" />
		<input type="hidden" name="action" value="tc_mail" />
		<input type="hidden" name="post[act]" value="addTest" />
		<tb>测试收件邮箱：<input type="text" name="post[csmail]" value="<?php echo $testEmail[0];?>">
		<input type="submit" value='确定'></tb>
	</form>
	</tr>
	<tr>
		<tbody>
			<tr align="center">
				<td class="tl">邮箱名</td>
				<td class="tl">邮箱密码</td>
				<td class="tl">SMTP</td>
				<td width="5" style="background:#F0F2F7;color:#006699;">SSL</td>
				<td width="5" style="background:#F0F2F7;color:#006699;">端口</td>
				<td class="tl">操作</td>
			</tr>
			<form action="?" method="post">
			<input type="hidden" name="file" value="setting" />
			<input type="hidden" name="action" value="tc_mail" />
			<input type="hidden" name="post[act]" value="add" />
			<tr>
				<td><input type="text" name="post[user]" size="40" /></td>
				<td><input type="text" name="post[pass]" size="40" /></td>
				<td><input type="text" name="post[smtp]" size="25" /></td>
				<td><input type="text" name="post[ssl]" size="4" value='0' /></td>
				<td><input type="text" name="post[dk]" size="4" value='25'/></td>
				<td><input type="submit" name="submit" value="添加" /><font color="red">  添加后在最下面</font></td>
			</tr>
			</form>

<?php
$filename='?file=setting&action=tc_mail';  
/*读取*/
$lines=file(DT_ROOT."/file/tc_email/emailSmtps.php");
$i=0;
unset($lines[0]);
foreach ($lines as $value) {
	$line=explode("|",$value);
	$line[0] = str_replace("#","",$line[0]);
	echo "
<form id='form".$i."' action=''>
	<input type=hidden name=file value='setting' />
	<input type=hidden name=action value='tc_mail' />
	<input type=hidden name=post[act] id='act".$i."' value='' />
	<tr>
		<td><input type=text name=post[user] value='".$line[0]."' size=40 /></td>
		<td><input type=text name=post[pass] value='".$line[1]."' size=40 /></td>
		<td><input type=text name=post[smtp] value='".$line[2]."' size=25 /></td>
		<td><input type=text name=post[ssl] value='".$line[3]."' size=4/></td>
		<td><input type=text name=post[dk] value='".$line[4]."'size=4 /></td>
		<td>
			<input type=hidden name='post[time]' value=".$line[5].">
			<input type='submit' value='修改' onclick='upd(".$i.")'/>
			<input type='submit' value='删除' onclick='del(".$i.")'/>
			<input value='I am Dahe doing Test' name='post[mailtitle]' type='hidden'>
			<input value='I am Dahe doing Test' name='post[mailcontent]' type='hidden'>
			<input type=hidden name=post[tomail] value='".$testEmail[0]."' />
			<input type=hidden name=post[emailpass] value='".$line[1]."' />
			<input type='submit' value='测试' onclick='test(".$i.")'/>
		</td>
	</tr>
</form>";
	$i++;
}
//require(DT_ROOT."/include/session.class.php");
//$session = new dsession();
//$_SESSION['hekw'] = 'hekw';
print_r($_SESSION);
echo "&nbsp;&nbsp;有<font color=red>".count($lines)."</font>个发件箱，可以发送<font color=red>".count($lines)*$DT['sendMailCount']."</font>封邮件";
?> 
</tbody>
	</tr>
</table>
<script type="text/javascript">
var form1;
function upd(i){
	form1 = document.getElementById("form"+i);
	document.getElementById("act"+i).value='update';
	form1.method='post';
}
function del(i){
	form1 = document.getElementById("form"+i);
	document.getElementById("act"+i).value='delete';
	form1.method='post';
}
function test(i){
	form1 = document.getElementById("form"+i);
	document.getElementById("act"+i).value='sendTest';
	form1.method='post';
}
</script>
<?php
	include tpl('footer');
?>