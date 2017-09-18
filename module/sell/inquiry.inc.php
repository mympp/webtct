<?php 
//2017.8.7，流程修改：每次提交询价单，只对一个供求信息，不再是同时多个,暂时停止发送短信

use models\helpers\data\dataFilter;
use models\helpers\data\tcdb;

defined('IN_DESTOON') or exit('Access Denied');
require_once DT_ROOT.'/models/autoload.php';

if($DT_BOT) dhttp(403);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
$MG['inquiry_limit'] > -1 or dalert(lang('message->without_permission'), 'goback');

include load('misc.lang');
$limit_used = $limit_free = 0;

//验证用户询价限制
if($MG['inquiry_limit']) {
	if(is_array($itemid) && count($itemid) > $MG['inquiry_limit']) dalert(lang($L['inquiry_limit'], array($MG['inquiry_limit'])), 'goback');
	$today = $today_endtime - 86400;
	$sql = $_userid ? "fromuser='$_username'" : "ip='$DT_IP'";
	$r = $db->get_one("SELECT COUNT(*) AS num FROM {$DT_PRE}message WHERE $sql AND addtime>$today AND typeid=1 AND status=3");
	$limit_used = $r['num'];
	$limit_used < $MG['inquiry_limit'] or dalert(lang($L['message_limit'], array($MG['inquiry_limit'], $limit_used)), 'goback');
	$limit_free = $MG['inquiry_limit'] > $limit_used ? $MG['inquiry_limit'] - $limit_used : 0;
}

require DT_ROOT.'/include/post.func.php';
$need_captcha = $MOD['captcha_inquiry'] == 2 ? $MG['captcha'] : $MOD['captcha_inquiry'];
$need_question = $MOD['question_inquiry'] == 2 ? $MG['question'] : $MOD['question_inquiry'];

$sell_db = new tcdb('sell_5');
$sell_result = $sell_db->where(['status'=>3,'itemid'=>$itemid])->one();
$linkurl = $MOD['linkurl'].$sell_result['linkurl'];

if($submit) {
	$dataFilter = new dataFilter();
	$post = $dataFilter->getFilterHtml($_POST);
	
	if(empty($post['itemid'])) dalert($L['inquiry_itemid'], 'goback');
	

	if(empty($sell_result)) dalert($L['inquiry_itemid'], 'goback');
	
	if(empty($post['title'])) message($L['msg_type_title']);
	if(empty($post['content'])) message($L['msg_type_content']);
	if(empty($post['truename'])) message($L['msg_type_truename']);
	if(empty($post['telephone'])) message($L['msg_type_telephone']);

	captcha($captcha, $need_captcha);
	question($answer, $need_question);
	
	$type = dhtmlspecialchars(implode(',', $post['type']));
	$content = nl2br($post['content']);
	if($type) $content = $L['content_type'].$type.'<br/>'.$content;
	if($post['company']) $content .= '<br/>'.$L['content_company'].$post['company'];
	if($post['truename']) $content .= '<br/>'.$L['content_truename'].$post['truename'];
	if($post['telephone']) $content .= '<br/>'.$L['content_telephone'].$post['telephone'];
	if(is_email($post['email'])) $content .= '<br/>'.$L['content_email'].$post['email'];
	if(is_numeric($post['qq'])) $content .= '<br/>'.$L['content_qq'].' '.im_qq($post['qq']).' '.$post['qq'];
	if($post['ali']) $content .= '<br/>'.$L['content_ali'].' '.im_ali($post['ali']).' '.$post['ali'];
	if(is_email($post['msn'])) $content .= '<br/>'.$L['content_msn'].' '.im_msn($post['msn']).' '.$post['msn'];
	if($post['skype']) $content .= '<br/>'.$L['content_skype'].' '.im_skype($post['skype']).' '.$post['skype'];
	if(is_date($post['date'])) $content .= '<hr size="1"/>'.lang($L['content_date'], array($post['date']));	
	
	$post['type'] = $type;
	$post['content'] = $content;
	
	if($_username && $_username == $sell_result['username']) message('不能对自己发送询价');
	$message = $L['content_product'].'<a href="'.$linkurl.'"><strong>'.$sell_result['title'].'</strong></a><br/>'.$content;
	$result = send_message($sell_result['username'], $title, $message, 1, $_username,$linkurl);
	if($urls){$forward = $urls;}
	dalert('发送完成', $forward);
} else {
$user = array();
if($_userid) {
	$user = userinfo($_username);
	$company = $user['company'];
	$truename = $user['truename'];
	$telephone = $user['telephone'] ? $user['telephone'] : $user['mobile'];
	$email = $user['mail'] ? $user['mail'] : $user['email'];
	$qq = $user['qq'];
	$msn = $user['msn'];
}
	$itemid or dalert($L['inquiry_itemid'], 'goback');
	$itemids = is_array($itemid) ? implode(',', $itemid) : $itemid;
	$list = array();
	$result = $db->query("SELECT * FROM {$table} WHERE itemid IN ($itemids) AND status=3 LIMIT 30");
	while($r = $db->fetch_array($result)) {
		if(!$r['username']) continue;
		if($r['username'] == $_username) $selfs=1;
		$list[] = $r;
	}
	$total = count($list);
	if($total < 1) dalert($L['inquiry_no_info'], 'goback');
	$itype = explode('|', trim($MOD['inquiry_type']));
	$iask = explode('|', trim($MOD['inquiry_ask']));
	$date = timetodate($DT_TIME + 5*86400, 3);
	$title = $total == 1 ? lang($L['inquiry_message_title'], array($list[0]['title'])) : lang($L['inquiry_message_title_multi'], array($DT['sitename']));
	$head_title = ($total == 1 ? $L['inquiry_head_title'].$DT['seo_delimiter'].$list[0]['title'] : $L['inquiry_head_title_multi']).$DT['seo_delimiter'].$MOD['name'];
	include template($MOD['template_inquiry'] ? $MOD['template_inquiry'] : 'inquiry', $module);
}
?>
