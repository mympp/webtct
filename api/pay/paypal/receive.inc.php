<?php
defined('IN_DESTOON') or exit('Access Denied');
if($PAY[$bank]['keycode'] && isset($_GET['tx'])) {//PDT
	$tx_token = $_GET['tx'];
	$auth_token = $PAY[$bank]['keycode'];
	//�γ���֤�ַ���
	$req = "cmd=_notify-synch&tx=$tx_token&at=$auth_token";
	//��������ˮ�ż���ݱ�Ƿ��� PayPal ��֤
	$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
	$fp = fsockopen('www.paypal.com', 80, $errno, $errstr, 30);
	#$fp = fsockopen('ssl://www.paypal.com', 443, $errno, $errstr, 30);
	if(!$fp) {
		//HTTP ERROR
		$charge_status = 2;
		$charge_errcode = 'PayPal HTTP ERROR';
	} else {
		fputs($fp, $header.$req);
		//��ȡ��������
		$res = '';
		$headerdone = false;
		while(!feof($fp)) {
			$line = fgets($fp, 1024);
			if(strcmp($line, "\r\n") == 0) {
				//��ȡͷ
				$headerdone = true;
			} else if($headerdone){
				//��ȡ��������
				$res .= $line;
			}
		}
		//������ȡ����
		$lines = explode("\n", $res);
		$keyarray = array();
		if(strcmp($lines[0], "SUCCESS") == 0) {
			for($i = 1; $i < count($lines); $i++) {
				list($key, $val) = explode("=", $lines[$i]);
				$keyarray[urldecode($key)] = urldecode($val);
			}
			//��齻�׸���״̬ payment_status �Ƿ�Ϊ Completed
			//��齻����ˮ�� txn_id �Ƿ��Ѿ��������
			//������ EMAIL receiver_email �Ƿ�Ϊ���� PayPal ���Ѿ�ע��� EMAIL
			//����� mc_gross �Ƿ���ȷ
			//����
			//����˴θ�����ϸ
			//�ø�����ϸ���б����ɲο���
			//https://www.paypal.com/IntegrationCenter/ic_ipn-pdt-variable-reference.html
			$item_number = intval($keyarray['item_number']);
			$r = $db->get_one("SELECT * FROM {$DT_PRE}finance_charge WHERE itemid='$item_number' AND status=0");
			if($charge_orderid == $item_number) {
				$payment_status = $keyarray['payment_status'];
				$payment_amount = $keyarray['mc_gross'];
				$payment_currency = $keyarray['mc_currency'];
				$receiver_email = $keyarray['receiver_email'];
				if($payment_amount != $charge_money) {
					$charge_status = 2;
					$charge_errcode = '��ֵ��ƥ��';
				} else if($payment_currency != $PAY[$bank]['currency']) {
					$charge_status = 2;
					$charge_errcode = '��ֵ���ֲ�ƥ��';
				} else if($receiver_email != $PAY[$bank]['partnerid']) {
					$charge_status = 2;
					$charge_errcode = '�տ��ʺŲ�ƥ��';
				} else if($payment_status == 'Completed') {
					$charge_status = 1;
				}
			}

		} else if(strcmp($lines[0], "FAIL") == 0) {
			//��ȡ������ϸʧ�ܣ���¼�����		
			$charge_status = 2;
			$charge_errcode = '֧��ʧ��';
		}
	}
	fclose($fp);
} else {
	dheader('?action=record');
}
?>