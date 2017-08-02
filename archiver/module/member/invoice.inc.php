<?php
defined('IN_DESTOON') or exit('Access Denied');
login();
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/module/'.$module.'/invoice.class.php';
$do=new invoice();
if($submit){
	$result=$do->add($post);
	if($result){
		$invocie_item=$db->get_one("select itemid from {$db->pre}invoice where orderid =".$post[orderid]);
		$db->query("update {$db->pre}mall_order set invoice=1,invoiceid=".$invocie_item[itemid]." where itemid=".$post[orderid]);
		//dmsg('填写发票成功','invoice.php?action=success');
		echo '<script>window.location.href="invoice.php?action=success";</script>';
	}else{
		dmsg($do->errmsg);
	}

}else{
	$invoice=array();
	if($action=='show'){
		$do->itemid=$invoiceid;
		$invoice=$do->get_one();
	}
	include template('invoice',$module);
}
?>