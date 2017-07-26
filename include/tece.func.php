<?php
/*
date:2015-9-1
who:chentao
what:添加判断定制用户和权限
行405到421
relation:
*/
function xname($truename= '',$baomi=0,$typez=0,$len=1,$replacecount=0) {
	$cd=mb_strlen($truename,'utf8');
	if($cd>0)$cd=$cd-1;
	if ($baomi==0){return $truename;}
	else{
		if ($typez==1){$typez='<font>(保密)</font>';}elseif($typez==0){$typez='(保密)';}else{$typez='';}
		if($replacecount){$typez=str_replace(mb_substr($truename,0,$len+$replacecount,'utf-8'),'',$truename).$typez;$cd=$replacecount;}
		return mb_substr($truename,0,$len,'utf-8').str_repeat("*",$cd).$typez;
	}
}
function xcontent($content,$rep,$arrays,$stype=0,$url='') {
global $DT,$MODULE;
$id= array();
$id= explode(",",$arrays);
$arrayc=count($id);
for($i=0;$i<=$arrayc;$i++)	
   {$content=str_replace($id[$i],$rep,$content);}
    if($stype==0){
    $content='<div class="pd5 tc f12 bcolor">以下部分内容对游客保密，要阅读全部详细内容请先 <a href="'.$MODULE[2][linkurl].$DT['file_register'].'"><u class="f14 ocolor">注册</u></a> 或 <a href="'.$MODULE[2][linkurl].$DT['file_login'].'"><u class="f14 ocolor">登录</u></a> !</div>'.$content;}
	return $content;
}
function getsqldata($fields,$table,$where,$num,$debug=0)
{global $db;
if($num){$num=" limit 0,".$num;}else{$num='';}
	  $sqls="select ".$fields." from ".$table." where ".$where.$num;
	  if($debug>0){echo $sqls;}
	  $k = array();
	  $result = $db->query($sqls, 0);
	  while($r = $db->fetch_array($result))
	  { $k[] = $r;}
	  return $k;
}
function get_areaarrchildid($areaid, $AREA) {
		$arrchildid = '';
		foreach($AREA as $area) {
			if(strpos(','.$area['arrparentid'].',', ','.$areaid.',') !== false) $arrchildid .= ','.$area['areaid'];
		}
		return $arrchildid ? $areaid.$arrchildid : $areaid;
	}
function get_catarrchildid($catid, $CATEGORY) {
		$arrchildid = '';
		foreach($CATEGORY as $category) {
			if(strpos(','.$category['arrparentid'].',', ','.$catid.',') !== false) $arrchildid .= ','.$category['catid'];
		}
		return $arrchildid ? $catid.$arrchildid : $catid;
	}
function getcatsname($catids, $fh) {
	$cates=$fh;
	$arr = explode($fh, $catids);
     foreach($arr as $v) 
		 {
		 if($v){$cates=$cates.strip_tags(cat_pos(get_cat($v))).$fh;}
	     }
		 return $cates;
	}
function qq_status($qq){
$url = 'http://wpa.qq.com/pa?p=2:'.$qq.':52';
$Headers = get_headers($url, 1);
 if ($Headers['Location']=='http://pub.idqqimg.com/qconn/wpa/button/button_121.gif'){
 $Status = 1;
 }elseif ($Headers['Location']=='http://pub.idqqimg.com/qconn/wpa/button/button_120.gif'){
 $Status = 2;
 }else {
 $Status = 0;
 }
 Return $Status;}

function fieldstitle($itemid,$fh='*',$value='',$nums=0,$type=0)
{
	$html='';
	global $db;
	$fname=getsqldata("option_value",$db->pre."fields","itemid=".$itemid,1);
					$rows = explode($fh, $fname[0]['option_value']);
					$rowc=count($rows);
                    for($i=0;$i<=$rowc;$i++){
						$row=$rows[$i];
						if($row) {
							if($nums){
							if($i<$nums){
							$cols = explode("|", trim($row));
							if($value!=''){if($cols[0]==$value)$html= $cols[1];}
							else{$html .= '<li id=options'.$itemid.'-'.$cols[0].'>'.$cols[1].'</li>';}
							}
							}
							else
							{
							$cols = explode("|", trim($row));
							if($value!=''){if($cols[0]==$value)$html= $cols[1];}
							else{$html .= '<li id=options'.$itemid.'-'.$cols[0].'>'.$cols[1].'</li>';}
							}
						}
					}
	 Return $html;

}
function fieldsvalue($itemid,$fh='*',$value='',$nums=0)
{$html='';global $db;
	$fname=getsqldata("option_value",$db->pre."fields","itemid=".$itemid,1);
					$rows = explode($fh, $fname[0]['option_value']);
                    for($i=0;$i<=$rowc;$i++){
						
						$row=$rows[$i];
						if($row) {
							if($nums){
							if($i<$nums){
							$cols = explode("|", trim($row));
							if($value!=''){if($cols[0]==$value)$html= $cols[0];}
							else{$html .= '<li id=option'.$itemid.'-'.$cols[0].'>'.$cols[0].'</li>';}
							}
							}
							else
							{$cols = explode("|", trim($row));
							if($value!=''){if($cols[0]==$value)$html= $cols[0];}
							else{$html .= '<li id=option'.$itemid.'-'.$cols[0].'>'.$cols[0].'</li>';}
							}
						}
					}
	 Return $html;

}


function fieldsarray($itemid,$fh='*',$nums=0)
{$html='';global $db;
$farray=array();
	$fname=getsqldata("option_value",$db->pre."fields","itemid=".$itemid,1,0);
					$rows = explode($fh, $fname[0]['option_value']);
                    $rowc=count($rows);
                    for($i=0;$i<=$rowc;$i++){
						$cols = explode("|", trim($rows[$i]));
                            $farray[]=$cols[1];
							
					}
	 Return $farray;
}

function randip(){
            $ip_long = array(
            array('607649792', '608174079'), //36.56.0.0-36.63.255.255
            array('1038614528', '1039007743'), //61.232.0.0-61.237.255.255
            array('1783627776', '1784676351'), //106.80.0.0-106.95.255.255
            array('2035023872', '2035154943'), //121.76.0.0-121.77.255.255
            array('2078801920', '2079064063'), //123.232.0.0-123.235.255.255
            array('-1950089216', '-1948778497'), //139.196.0.0-139.215.255.255
            array('-1425539072', '-1425014785'), //171.8.0.0-171.15.255.255
            array('-1236271104', '-1235419137'), //182.80.0.0-182.92.255.255
            array('-770113536', '-768606209'), //210.25.0.0-210.47.255.255
            array('-569376768', '-564133889'), //222.16.0.0-222.95.255.255
             );
        $rand_key = mt_rand(0, 9);
        $ip= long2ip(mt_rand($ip_long[$rand_key][0], $ip_long[$rand_key][1]));
    	Return $ip;
}
//测试TC邮局配置的SMTP服务器发件是否成功
function send_test_tc_mail($mail_to, $mail_subject, $mail_body, $mail_from, $mail_pass, $smtp, $ssl, $port){
	require_once DT_ROOT.'/include/tc_mail.class.php';
	$TCmail = new TcMail();
	if($ssl == 1){
		$TCmail->setServer($smtp,$mail_from,$mail_pass,$port,true); //设置smtp服务器，普通连接方式
	}else{
		$TCmail->setServer($smtp,$mail_from,$mail_pass,465,false); //设置smtp服务器，普通连接方式
	}
	//$mail->setServer("smtp.gmail.com", "XXXXX@gmail.com", "XXXXX", 465, true); //设置smtp服务器，到服务器的SSL连接
	$TCmail->setFrom($mail_from); //设置发件人
	$TCmail->setReceiver($mail_to); //设置收件人，多个收件人，调用多次
	$TCmail->setMail($mail_subject, $mail_body); //设置邮件主题、内容
	$TCmail->sendMail(); //发送
	return true;
}


function send_mail($mail_to, $mail_subject, $mail_body, $mail_from = '', $mail_sign = true, $TC_mail = '') {
	global $DT, $db,$DT_TIME;
	#2014-04-14
	#tc_Dahe
	#关联文件&代码块：
	#		/include/tece.func.php -> function send_test_tc_mail
	#		/include/tc_mail.class.php
	#		/file/tc_email/emailSmtps.php
	#		/file/tc_email/testEmail.txt
	#		/admin/setting.inc.php -> 29行到99行 $action == 'tc_mail'
	#		/admin/template/setting.tpl.php -> 928行到936行
	#		/admin/template/tc_mail.tpl.php
	#数据库：
	#	mail_log
	#		1.添加字段istcmail：0为DT邮局发送，1为TC邮局发送
	#		2.添加字段tcmail_from：记录使用TC邮局发送的发件箱
	#此函数改动后需开启邮件发送记录，才起作用
	#代码块作用说明：读取mail_log，计算DT邮局发送邮件次数与admin/template/setting.tpl.php下的全局变量$DT['sendMailCount']即setting[sendMailCount]做比较。
	$sendNum = 0;
	$getSendNum = $db->get_one("select count(*) as num from {$db->pre}mail_log where DATE_FORMAT(FROM_UNIXTIME(addtime),'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d') and istcmail = '0'");
	$sendNum = $getSendNum['num'];
	//echo "<script>alert('".$sendNum."')</script>";
	if($sendNum <= $DT['sendMailCount'] || $TC_mail == 0){//$TC_mail 测试时用的
		if($DT['smtp_port']==25||$DT['smtp_port']=='25'){
		/*-------DT原有--------*/
			require_once DT_ROOT.'/include/mail.func.php';
			$result = dmail(trim($mail_to), $mail_subject, $mail_body, $mail_from, $mail_sign);
			$success = $result == 'SUCCESS' ? 1 : 0;
						if($DT['mail_log']) {		
							$status = $success ? 3 : 2;
							$note = $success ? '' : addslashes($result);
							$mail_subject = stripslashes($mail_subject);
							$mail_body = stripslashes($mail_body);
							$mail_subject = addslashes($mail_subject);
							$mail_body = addslashes($mail_body);
							$db->query("INSERT INTO {$db->pre}mail_log (email,title,content,addtime,status,note) VALUES ('$mail_to','$mail_subject','$mail_body','$DT_TIME','$status','$note')");
							}
			}
	else
		{
		$mail_from = $DT['smtp_user'];$email_pass =$DT['smtp_pass'];$smtp= $DT['smtp_host'];
		require_once DT_ROOT.'/include/tc_mail.class.php';
		$TCmail = new TcMail();
		$TCmail->setServer($smtp,$mail_from,$email_pass,465,true); //设置smtp服务器，普通连接方式
		$TCmail->setFrom($mail_from); //设置发件人
		$TCmail->setReceiver($mail_to); //设置收件人，多个收件人，调用多次
		$TCmail->setMail($mail_subject, $mail_body); //设置邮件主题、内容
		$send_result = $TCmail->sendMail(); //发送
		$status = '';
		if($send_result){
			$status = '3';
		}else{
			$status = '2';
		}
		//echo "<script>alert('".$mail_from.$email_pass.$smtp.$mail_to.$mail_subject.$mail_body."')</script>";exit;
		$note = '';
		$db->query("INSERT INTO {$db->pre}mail_log (email,title,content,addtime,status,note,istcmail,tcmail_from) VALUES ('$mail_to','$mail_subject','$mail_body','$DT_TIME','$status','$note','0','$mail_from')");
		return true;
		}
		return $success;
/*-------DT原有--------*/

	}else{
		global $DT_TIME;
		$lines=file(DT_ROOT."/file/tc_email/emailSmtps.php");
		unset($lines[0]);//去除文件开头<?php defined('IN_DESTOON') or exit('Access Denied');

		foreach($lines as $k=>$v){
			$line = explode("|",$v);
			$line[0] =str_replace("#","",$line[0]);
			$_SESSION[$line[0]]=$line;
		}

		foreach($_SESSION as $k => $v){
			$mailDate = date("Ymd",$DT_TIME);
			$r = $db->get_one("select count(*) as sendNum from {$db->pre}mail_log where tcmail_from = '$k' and DATE_FORMAT(FROM_UNIXTIME(addtime),'%Y%m%d') = DATE_FORMAT(NOW(),'%Y%m%d')");
			if($r['sendNum'] >= $DT['sendMailCount']){
				unset($_SESSION[$k]);
			}
		}

		$randMail	= array_rand($_SESSION);
		$selMail	= $_SESSION["$randMail"];
		$mail_from	= $selMail[0];
		$email_pass = $selMail[1];
		$smtp		= $selMail[2];
		$ssl		= $selMail[3];
		$port		= $selMail[4];
		require_once DT_ROOT.'/include/tc_mail.class.php';
		$TCmail = new TcMail();
		if($ssl == 1){
			$TCmail->setServer($smtp,$mail_from,$email_pass,$port,true); //设置smtp服务器，普通连接方式
		}else{
			$TCmail->setServer($smtp,$mail_from,$email_pass,$port,false); //设置smtp服务器，普通连接方式
		}
		$TCmail->setFrom($mail_from); //设置发件人
		$TCmail->setReceiver($mail_to); //设置收件人，多个收件人，调用多次
		$TCmail->setMail($mail_subject, $mail_body); //设置邮件主题、内容
		$send_result = $TCmail->sendMail(); //发送
		$status = '';
		if($send_result){
			$status = '3';
		}else{
			$status = '2';
		}
		$note = '';
		$db->query("INSERT INTO {$db->pre}mail_log (email,title,content,addtime,status,note,istcmail,tcmail_from) VALUES ('$mail_to','$mail_subject','$mail_body','$DT_TIME','$status','$note','1','$mail_from')");
		return true;
	}
}

function getbetween($content,$start,$end){//获得字符串之间的数据
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]);
        return $r[0];
    }
    return '';
}

function array_remove($arr, $offset) { //移除数组中某个元素后自动重排，offset是去掉的数组位置
array_splice($arr, $offset, 1); 
} 


function strencode($string) {//PHP简单加密,JS解密
    return base64_encode($string);
    }

function CLTSEL($str){
global $CFG;
if(empty($_COOKIE['clt'])){setcookie('clt','',time()+3600*24,$CFG['cookie_path'],$CFG['cookie_domain']);}
				if($_GET['clt']=='touch'){
					$_COOKIE['clt']='touch';
					setcookie('clt',$_COOKIE['clt'],time()+3600*24,$CFG['cookie_path'],$CFG['cookie_domain']);
				}
				if($_GET['clt']=='pc'){
					$_COOKIE['clt']='pc';
						setcookie('clt',$_COOKIE['clt'],time()+3600*24,$CFG['cookie_path'],$CFG['cookie_domain']);
				}
		if($_COOKIE['clt']=='touch'){
			$str=1;
		}
		if($_COOKIE['clt']=='pc'){
			$str=0;
		}
return $str;
}
function memberpath($str){// 会员中心面板选择器
global $CFG;
	if(empty($_COOKIE['memberpath'])){setcookie('memberpath','',time()+3600*24,$CFG['cookie_path'],$CFG['cookie_domain']);}
					if($str){
						$_COOKIE['memberpath']=$str;
						setcookie('memberpath',$str,time()+3600*24,$CFG['cookie_path'],$CFG['cookie_domain']);
						$_SESSION['memberpath']=$str;
					}
}
//chentao 地区下拉框统计开始
function get_area_count($title = '', $areaid = 0, $extend = '', $deep = 0, $id = 1) {
	global $db;
	$areacount=$db->query("select count(*) as c ,areaid from {$db->pre}company group by areaid");  //统计地区
	$count=array();
	while($a =$db->fetch_array($areacount)){
		$count[$a['areaid']]=$a['c'];
	}
	$db->free_result($areacount);
	$area=$db->query("select areaid from {$db->pre}area where parentid=0");
	$parentid = array();
	while($a =$db->fetch_array($area)){
		$parentid[$a['areaid']]=true;
	}
	$db->free_result($area);
	if($areaid) {
		$r = $db->get_one("SELECT child,arrparentid FROM {$db->pre}area WHERE areaid=$areaid");
		$parents = explode(',', $r['arrparentid']);
		if($r['child']) $parents[] = $areaid;
	} else {
		$parents[] = 0;
	}
	$select = '';
	foreach($parents as $k=>$v) {
		if($deep && $deep <= $k) break;
		$v = intval($v);
		$select .= '<select onchange="load_area_count(this.value, '.$id.');" '.$extend.'>';
		if($title) $select .= '<option value="0">'.$title.'</option>';
		$result = $db->query("SELECT areaid,areaname FROM {$db->pre}area WHERE parentid=$v ORDER BY listorder,areaid ASC");
		//return count($db->fetch_array($result));
		while($a = $db->fetch_array($result)) {
			$selectid = isset($parents[$k+1]) ? $parents[$k+1] : $areaid;
			$selected = $a['areaid'] == $selectid ? ' selected' : '';
			$id=$a['areaid'];
			if(!$count[$id]){
				$companycount=0;
			}else{
				$companycount=$count[$id];
			}
			if($parentid[$id]){
				$select .= '<option value="'.$a['areaid'].'"'.$selected.'>'.$a['areaname'].'</option>';  //省级不显示统计
			}else{
				$select .= '<option value="'.$a['areaid'].'"'.$selected.'>'.$a['areaname'].' ['.$companycount.']'.'</option>';  //市级显示统计
			}
			
		}
		$select .= '</select> ';
	}
	return $select;
}

function ajax_area_count($name = 'areaid', $title = '', $areaid = 0, $extend = '', $deep = 0) {
	global $area_id;
	if($area_id) {
		$area_id++;
	} else {
		$area_id = 1;
	}
	$areaid = intval($areaid);
	$deep = intval($deep);
	$select = '';
	$select .= '<input name="'.$name.'" id="areaid_'.$area_id.'" type="hidden" value="'.$areaid.'"/>';
	$select .= '<span id="load_area_'.$area_id.'">'.get_area_count($title, $areaid, $extend, $deep, $area_id).'</span>';
	$select .= '<script type="text/javascript">';
	if($area_id == 1) $select .= 'var area_title = new Array;';
	$select .= 'area_title['.$area_id.']=\''.$title.'\';';
	if($area_id == 1) $select .= 'var area_extend = new Array;';
	$select .= 'area_extend['.$area_id.']=\''.$extend.'\';';
	if($area_id == 1) $select .= 'var area_areaid = new Array;';
	$select .= 'area_areaid['.$area_id.']=\''.$areaid.'\';';
	if($area_id == 1) $select .= 'var area_deep = new Array;';
	$select .= 'area_deep['.$area_id.']=\''.$deep.'\';';
	$select .= '</script>';
	if($area_id == 1) $select .= '<script type="text/javascript" src="'.DT_STATIC.'file/script/area.js"></script>';
	return $select;
}
//地区下拉框统计结束

function check_dingzhi_member($username,$action=''){     //判断是否定制用户,$username为用户名，$action为定制功能权限名
	global $db;
	$result=$db->get_one("select * from {$db->pre}member_dingzhi where username='$username'");
	if($result===false){
		return false;              //查无该定制用户返回false
	}else{
		if($action==''){
			return true;             //不限制权限
		}else{
			if(strpos($result['action'],'|'.$action.'|')===false){
				return false;         //定制用户没有该功能权限
			}else{
				return true;            //定制用户具有权限
			}
		}
	}
}

/**
* 新版分页按钮
* @param int $page 当前分页页数
* @param int $items 所有信息总数
* @param int $pagesize 每页信息条数
* $param str $linkurl 按钮跳转地址
* @param arr $params 跳转地址附带参数
* @param str $linkfunction 可调用的自定义地址处理方法
* @return str html格式字符串
*/
function pagination($page,$items,$pagesize,$linkurl,$params = [],$linkfunction = '',$moduleurl = ''){
	$user_func = false;		//默认不使用自定义地址处理方法
	if(isset($linkfunction) && function_exists($linkfunction)) $user_func = true;		//当填写自定义方法名，且该方法存在时使用自定义方法
	if($items < $pagesize) return '';
	$maxPage = ($items%$pagesize) > 0 ? ((int)($items/$pagesize) + 1) : ((int)($items/$pagesize));	//最大分页页数
	
	$back = '<div class="pagination">';
	$back .= "<form action=\"$linkurl\" method=\"get\">";
	$back .= '<ul>';
	
	//上一页按钮
	if($page != 1){
		$params['page'] = $page-1;
		$link = $user_func ? $moduleurl.call_user_func($linkfunction,$params) : $linkurl.'?'.http_build_query($params);
		$back .= "<li class=\"prev\"><a href=\"$link\">上一页</a></li>";
	}
	//中间段按钮
	$count = 0;
	$start = $page - 5;
	$font_key = false;	//前省略号标志
	$back_key = false;	//后省略号标志
	if($page > 6 ){
		$params['page'] = 1;
		$link = $user_func ? $moduleurl.call_user_func($linkfunction,$params) : $linkurl.'?'.http_build_query($params);
		$back .= "<li><a href=\"$link\">1</a></li>";
		$count++;
	}
	for($start;$start <= $maxPage;$start++){
		if($start < 1) continue;
		$on = $page == $start ? 'class="on"' : '';
		$params['page'] = $start;
		$link = $user_func ? $moduleurl.call_user_func($linkfunction,$params) :  $linkurl.'?'.http_build_query($params);
		if(($start + 2) < $page && $start != 1){
			if($font_key) continue;
			$back .= "<li class=\"pt\">...</li>";
			$font_key = true;
		}elseif($start == $maxPage){
			$back .= "<li><a href=\"$link\" $on>$start</a></li>";
		}elseif(($start-3)>$page && $count>5){
			$params['page'] = $maxPage;
			$link = $user_func ? $moduleurl.call_user_func($linkfunction,$params) :  $linkurl.'?'.http_build_query($params);
			$back .= "<li><a href=\"$link\" $on>$maxPage</a></li>";
		}elseif(($start-2)>$page && $count>4){
			if($back_key) continue;
			$back .= '<li class="pt">...</li>';
			$back_key = true;
		}else{
			$back .= "<li><a href=\"$link\" $on>$start</a></li>";
		}
		$count++;
		$limit = $page>4 ? 8:6;
		if($count > $limit) break;
	}
	
	//下一页按钮
	if($page < $maxPage){
		$params['page'] = $page+1;
		$link = $user_func ? $moduleurl.call_user_func($linkfunction,$params) : $linkurl.'?'.http_build_query($params);
		$back .= "<li class=\"next\"><a href=\"$link\">下一页</a></li>";
	}
	$back .= '</ul>';
	
	//跳转按钮
	$back .= '<ul>';
	unset($params['page']);
	foreach($params as $k=>$v){
		$back .= "<input type=\"hidden\" name=\"$k\" value=\"$v\" />";
	}
	$back .= '<li>转到</li>';
	$back .= '<li><input type="text" name="page" /></li>';
	$back .= '<li>页</li>';
	$back .= '<li><input type="submit" value="确定"></li>';
	$back .= '</ul>';
	$back .= '</form>';
	
	$back .= '</div>';
	return $back;
}

/**
* 新版企业模块搜索伪静态地址规则
* @param array selector 搜索条件，可带参数catid,areaid,type,mode,vip,kw,page
* @return string
*/
function com_rewrite($selector){
	//存在这两个参数的地址使用动态地址
	if(isset($selector['kw']) || isset($selector['vip'])){
		return 'search.php?'.http_build_query($selector);
	}else{
	//伪静态地址处理 so-catid-areaid-mode-type-page.html
		$catid = isset($selector['catid']) ? '-'.$selector['catid'] : '-0' ;
		$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0' ;
		$mode = isset($selector['mode']) ? '-'.$selector['mode'] : '-0' ;
		$type = isset($selector['type']) ? '-'.$selector['type'] : '-0' ;
		$page = isset($selector['page']) ? '-'.$selector['page'] : '' ;
		return 'so'.$catid.$areaid.$mode.$type.$page.'.html';
	}
}

/**
* 新版供需模块搜索伪静态地址规则
* @param array selector 搜索条件，可带参数catid,areaid,type,mode,vip,kw,page
* @return string
*/
function sell_rewrite($selector){
	//存在以下参数的地址使用动态地址
	if(isset($selector['kw']) || isset($selector['day']) || isset($selector['order'])){
		return 'search.php?'.http_build_query($selector);
	}else{
	//伪静态地址处理 so-catid-typeid-areaid-validated-page.html
		$catid = isset($selector['catid']) ? '-'.$selector['catid'] : '-0' ;
		$typeid = isset($selector['typeid']) ? '-'.$selector['typeid'] : '-0';
		$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0' ;
		$validated = isset($selector['validated']) ? '-'.$selector['validated'] : '-0' ;
		$page = isset($selector['page']) ? '-'.$selector['page'] : '' ;
		return 'so'.$catid.$typeid.$areaid.$validated.$page.'.html';
	}
}
/**
* 新版产品模块搜索伪静态地址规则
* @param array selector 搜索条件，可带参数catid,areaid,stype,validated,kw,page
* @return string
*/
function mall_rewrite($selector){
	//存在以下参数的地址使用动态地址
	if(isset($selector['kw'])){
		return 'search.php?'.http_build_query($selector);
	}else{
	//伪静态地址处理 so-catid-stype-areaid-validated-page.html
		$catid = isset($selector['catid']) ? '-'.$selector['catid'] : '-0' ;
		$stype = isset($selector['stype']) ? '-'.$selector['stype'] : '-0';
		$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0' ;
		$validated = isset($selector['validated']) ? '-'.$selector['validated'] : '-0' ;
		$page = isset($selector['page']) ? '-'.$selector['page'] : '' ;
		return 'so'.$catid.$stype.$areaid.$validated.$page.'.html';
	}
}
/**
* 新版产品模块科室伪静态地址规则
* @param array selector 搜索条件，可带参数catid,areaid,stype,validated,kw,page
* @return string
*/
function keshi_rewrite($selector){
	//存在以下参数的地址使用动态地址
	if(isset($selector['kw'])){
		return 'keshi.php?'.http_build_query($selector);
	}else{
	//伪静态地址处理 so-catid-stype-areaid-validated-page.html
		$kcatid = isset($selector['kcatid']) ? '-'.$selector['kcatid'] : '-0' ;
		$stype = isset($selector['stype']) ? '-'.$selector['stype'] : '-0';
		$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0' ;
		$validated = isset($selector['validated']) ? '-'.$selector['validated'] : '-0' ;
		$page = isset($selector['page']) ? '-'.$selector['page'] : '' ;
		return 'ks'.$kcatid.$stype.$areaid.$validated.$page.'.html';
	}
}
/**
* 新版产品模块关键词伪静态地址规则
* @param array selector 搜索条件，可带参数catid,areaid,stype,validated,kw,page
* @return string
*/
function keyword_rewrite($selector){
	//伪静态地址处理 so-catid-typeid-areaid-validated-page.html
		$kwid = isset($selector['kwid']) ? '-'.$selector['kwid'] : '-0' ;
		$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0' ;
		$page = isset($selector['page']) ? '-'.$selector['page'] : '' ;
		return 'kw'.$kwid.$areaid.$page.'.html';
}

/**
* 新版资讯模块列表地址伪静态规则地址
*/
function article_rewrite($selector){
	if(isset($selector['kw'])){
		return 'search.php?'.http_build_query($selector);
	}else{
		global $dc;
		$article_cat = $dc->get('article_all_cat');
		if(empty($article_cat)){
			require_once DT_ROOT.'/include/tcdb.class.php';
			$category = new tcdb('category');
			$cat = $category->field('catid,catname,catdir,parentid')->where(['moduleid'=>21])->all();
			foreach($cat as $k=>$v){
				$article_cat[$v['catid']] = $v;
			}
			$dc->set('article_all_cat',$article_cat,(3600*24*7));
		}	
		$catdir = $article_cat[$selector['catid']]['catdir'];
		$page = isset($selector['page']) ? $selector['page'].'.html' : '';
		return $catdir.'/'.$page;
	}
	
}

/**
* 新版招标模块改版伪静态地址
*/
function buy_rewrite($selector){
	if(isset($selector['kw']) || isset($selector['order']) || isset($selector['typeid']))	return 'search.php?'.http_build_query($selector);
	$catid = isset($selector['catid']) ? '-'.$selector['catid'] : '-0';
	$areaid = isset($selector['areaid']) ? '-'.$selector['areaid'] : '-0';
	$page = isset($selector['page']) ? '-'.$selector['page'] : '';
	return 'so'.$catid.$areaid.$typeid.$page.'.html';
}
?>