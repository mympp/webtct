<?php
$down="no";
require 'config.inc.php';
require '../common.inc.php';
$itemid=intval($_REQUEST["itemid"]);

if ($_username!=""){//先判断有没有登录，有就读取这个会员的信息
$sql="SELECT * FROM {$DT_PRE}member WHERE username='".$_username."' ORDER BY userid ASC LIMIT 0,1";
$B = $db->query($sql);$B=mysql_fetch_array($B);
}
else{
echo "<script>alert('请先登陆')</script>";exit;
}


if ($itemid>0){//再读取下载文件的ITEMID的详细内容
$sql="SELECT * FROM {$DT_PRE}down_15 WHERE itemid=".$itemid." ORDER BY itemid ASC LIMIT 0,1";
$A = $db->query($sql);$A=mysql_fetch_array($A);
$title=$A['title'];
if($A['downtype']==1){$credit=$A["djifen"];
		if($B['credit']>=$credit){$down="yes";$downtype=$A['downtype'];$needs=$credit;$adduser=$A['username'];}}
if($A['downtype']==2){$money=$A["dprice"];
		if($B['money']>=$money){$down="yes";$downtype=$A['downtype'];$needs=$money;$adduser=$A['username'];}}
}
else{
echo "<script>alert('传递ID错误')</script>";exit;
}



if($down=="yes"){//有足够的余额 的话，开始进行流水消费记录添加！
$C = $db->get_one("SELECT * FROM {$DT_PRE}finance_pay WHERE moduleid=15 and username='$_username'  and  itemid=".$itemid);//判断是否已经支付了
if (!$C){
$S = $db->get_one("SELECT * FROM {$DT_PRE}member WHERE username='".$adduser."'");
				if ($downtype==1){
				$db->query("UPDATE {$DT_PRE}member SET credit=credit+".$needs." WHERE username='".$adduser."'");
				$k=$S['credit']+$needs;
				$db->query("INSERT INTO {$DT_PRE}finance_credit (username,amount,balance,addtime,reason,note,editor) VALUES ('".$adduser."',".$needs.",".$k.",".$DT_TIME.",'下载积分鼓励','".$_username."下载您的文件:".$title."','system')");
				$db->query("INSERT INTO {$DT_PRE}finance_pay (username,fee,currency,paytime,title,ip,moduleid,itemid) VALUES ('".$adduser."',".$needs.",'credit',".$DT_TIME.",'".$title."','".$DT_IP."',15,".$itemid.")");
				$db->query("UPDATE {$DT_PRE}member SET credit=credit-".$needs." WHERE username='".$_username."'");
				$k=$_credit-$needs;
				$db->query("INSERT INTO {$DT_PRE}finance_credit (username,amount,balance,addtime,reason,note,editor) VALUES ('".$_username."',-".$needs.",".$k.",".$DT_TIME.",'下载积分兑换','您下载了".$adduser."的文件:".$title."','system')");
				}
				if ($downtype==2){
				$db->query("UPDATE {$DT_PRE}member SET money=money+".$needs." WHERE username='".$adduser."'");
				$k=$S['money']+$needs;
				$db->query("INSERT INTO {$DT_PRE}finance_record (username,bank,amount,balance,addtime,reason,note,editor) VALUES ('".$adduser."','站内',".$needs.",".$k.",".$DT_TIME.",'下载金币鼓励','".$_username."下载您的文件:".$title."','system')");
				$db->query("INSERT INTO {$DT_PRE}finance_pay (username,fee,currency,paytime,title,ip,moduleid,itemid) VALUES ('".$adduser."',".$needs.",'money',".$DT_TIME.",'".$title."','".$DT_IP."',15,".$itemid.")");
				$db->query("UPDATE {$DT_PRE}member SET money=money-".$needs." WHERE username='".$_username."'");
				$k=$_money-$needs;
				$db->query("INSERT INTO {$DT_PRE}finance_record (username,bank,amount,balance,addtime,reason,note,editor) VALUES ('".$_username."','站内',-".$needs.",".$k.",".$DT_TIME.",'下载金币兑换','您下载了".$adduser."的文件:".$title."','system')");
				};
	}
echo "<script>alert('兑换成功！\\n现刷新页面请自行点击下载地址！');window.parent.location.reload(); </script>";exit;
}
else
{
	if ($downtype==1){
	echo "<script>alert('你的账号中积分不足下载此文件')</script>";
	}
	else{
	echo "<script>alert('你的账号中金额不足下载此文件')</script>";
	}
	
	exit;}
?>
