<?php
defined('IN_DESTOON') or exit('Access Denied');
$ip = $_SERVER['REMOTE_ADDR'];
$username = isset($_GET['username']) ? $_GET['username'] : '';
$title = isset($_GET['title']) ? $_GET['title'] : '';
$telephone = isset($_GET['telephone']) ? $_GET['telephone'] : '';
$from = isset($_GET['from']) ? $_GET['from'] : '';
$addtime = time();

global $db;
$db->query("insert into {$db->pre}tel_record (title,telephone,ip,username,addtime,fromurl) values ('$title','$telephone','$ip','$username',$addtime,'$from')");

?>