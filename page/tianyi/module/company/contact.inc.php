<?php 
defined('IN_DESTOON') or exit('Access Denied');
$table = $DT_PRE.'company';
$could_contact or dalert($L['msg_contact_deny'], 'goback');
$could_message = check_group($_groupid, $MOD['group_message']);
if($username == $_username || $domain) $could_message = true;
if($EXT['mobile_enable']) $head_mobile = $EXT['mobile_url'].'index.php?moduleid=4&username='.$username.'&action='.$file;
$condition="userid=".$userid;
$contact = $db->get_one("SELECT `company`,`telephone`,`mobilePhone`,`address`,`postcode`,`fax` FROM {$table} WHERE $condition");
$CS = cache_read('module-4.php');
$api_map = $CS['map'];
include template('contact', $template);
?>