<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt
*/
defined('DT_ADMIN') or exit('Access Denied');
function edition($k = -1) {
	$E = array();
	$D = DT_DOMAIN ? DT_DOMAIN : str_replace('www.', '', $_SERVER['HTTP_HOST']);
	$F = DT_ROOT.'/'.base64_decode('bGljZW5zZS5waHA=');
	if(is_file($F)) {
		$local = (strpos($D, '127.0.') !== false || strpos($D, 'localhost') !== false || strpos($D, '192.168.') !== false);
		$L = file_get($F);
		$L = substr($L, 13, strpos($L, '.Destoon B2B') - 13);
		$L = decrypt($L, $D);
		$E = explode('|', $L);
		if($E[0] == $D || $local || strpos($_SERVER['HTTP_HOST'], '.'.$E[0]) !== false) {
			$E[1] = base64_decode($local ? 'JiMzNTc5NzsmIzI5OTkyOyYjMjkyNTY7' : $E[1]);
		} else {
			$E[0] = $D;
			$E[1] = base64_decode('JiMyMDAxMDsmIzIwMTU0OyYjMjkyNTY7');
		}
	} else {
		$E[0] = $D;
		$E[1] = base64_decode('JiMyMDAxMDsmIzIwMTU0OyYjMjkyNTY7');
	}
	return $k >= 0 ? $E[$k] : $E;
}
?>