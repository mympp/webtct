<?php
defined('IN_DESTOON') or exit('Access Denied');
/*
	[Destoon B2B System] Copyright (c) 2008-2013 Destoon.COM
	This is NOT a freeware, use is subject to license.txt
*/
# http://help.destoon.com/faq/config.php shows detail

$CFG['database'] = 'mysqli';
$CFG['pconnect'] = '0';
//$CFG['db_host'] = '188.188.1.218:53306';
//$CFG['db_name'] = 'tctedata2';
//$CFG['db_user'] = 'root';
//$CFG['db_pass'] = 'tece218';
$CFG['db_host'] = 'localhost';
$CFG['db_ori_host'] = 'localhost';
$CFG['db_port'] = '3306';
$CFG['db_name'] = 'tianchengdata';
$CFG['db_user'] = 'root';
$CFG['db_pass'] = '';
$CFG['db_charset'] = 'utf8';
$CFG['db_expires'] = '600';
$CFG['tb_pre'] = 'tc_';
$CFG['charset'] = 'utf-8';
$CFG['url'] = 'http://www.ltecenet.com/';
$CFG['com_domain'] = '.ltecenet.com';
$CFG['com_dir'] = '1';
$CFG['com_rewrite'] = '0';
$CFG['com_vip'] = 'VIP';
$CFG['file_mod'] = 0777;
$CFG['cache'] = 'file';
$CFG['cache_pre'] = 'b2b_';
$CFG['cache_dir'] = '';
$CFG['tag_expires'] = '600';
$CFG['template_refresh'] = '0';
$CFG['template_trim'] = '0';
$CFG['cookie_domain'] = '.ltecenet.com';
$CFG['cookie_path'] = '/';
$CFG['cookie_pre'] = 'Dy1_';
$CFG['session'] = 'file';
$CFG['editor'] = 'kindeditor';
$CFG['timezone'] = 'Etc/GMT-8';
$CFG['timediff'] = '0';
$CFG['skin'] = 'teceskin';
$CFG['template'] = 'tc';
$CFG['language'] = 'zh-cn';
$CFG['authadmin'] = 'session';
$CFG['authkey'] = 'R7CV9u58xqe95csRnh';
$CFG['static'] = '';
$CFG['edittpl'] = '1';
$CFG['executesql'] = '1';
$CFG['founderid'] = '1';
?>