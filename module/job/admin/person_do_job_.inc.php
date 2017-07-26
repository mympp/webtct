<?php
defined('IN_DESTOON') or exit('Access Denied');
require MD_ROOT.'/person_do_job.class.php';
$do = new person_do_job($moduleid);

if(in_array($action, array('', 'sel_job'))) {
	$condition = '';
	if($validated) $condition .= " AND validated=$validated";
	if($kw) $condition .= " AND $fields LIKE '%$kw%'";
}
if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';
if(in_array($action, array('', 'person_do_product'))) {

	$sfields = array('模糊',  '商品名称', '商品品牌',  '简介', '公司名', '联系人', '联系电话', '联系地址', '电子邮件', '联系MSN', '联系QQ', '会员名', 'IP');
	$dfields = array('keyword', 'title', 'brand', 'introduce', 'company', 'truename', 'telephone', 'address', 'email', 'msn', 'qq','username', 'ip');


	isset($fields) && isset($dfields[$fields]) or $fields = 0;

	$fields_select = dselect($sfields, 'fields', '', $fields);

	$condition = '';
	if($_childs) $condition .= " AND catid IN (".$_childs.")";//CATE
	if($_areaids) $condition .= " AND areaid IN (".$_areaids.")";//CITY
	if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
	if($catid) $condition .= ($CAT['child']) ? " AND catid IN (".$CAT['arrchildid'].")" : " AND catid=$catid";
	if($areaid) $condition .= ($ARE['child']) ? " AND areaid IN (".$ARE['arrchildid'].")" : " AND areaid=$areaid";

}

switch($action){
	case 'selected':
		$userid or msg('请选择会员');
		if($do->pass($userid)){
			$result = $do->member_selected($userid);
		}
		dmsg('选择名义会员成功！',$forward);
		//include tpl('person_do_job',$module);
	break;
	case 'delete':
		$do->delete_seled_member();
		dmsg('清空已选名义会员成功！',$forward);
	break;
	case 'delete_pingjia':
		$do->delete_pingjia($itemid,$mallid);
		dmsg('删除成功！',$forward);
	break;
	case 'sel_com_mem':
		$members = $do->members();
		$comments = $do->job_comments();
		include tpl('person_do_job_comment',$module);
	break;
	case 'apply':
		if($do->pass($txt)){
			$do->apply($txt);
			dmsg('人气报名成功',$forward);
		}else{
			msg(' 请选择“名义会员”后再点击确定报名！ ');
		}
	break;
	case 'commented'://普通点评
		if($do->check_empty($post["seled_members"])){
			if($do->check_empty($post["seled_comments"])){
				$do->commented($post);
				dmsg('人气点评成功',$forward);
			}else{
				msg('请选择评语！');
			}
		}else{
			msg('请选择会员！');
		}
	break;
	case 'pingjia_commented'://评价
		if($do->check_empty($post["seled_members"])){
			if($do->check_empty($post["seled_comments"])){
				$do->pingjia_commented($post);
				dmsg('人气评价成功',$forward);
			}else{
				msg('请选择评价评语！');
			}
		}else{
			msg('请拟写评价会员名称！');
		}
	break;
	case 'pingjia_caozuo':
		$sel_pingjia = $do->sel_pingjia($post);
		$comments = $do->product_comments_pingjia();
		include tpl('person_do_product_comment_pingjia',$module);
	break;
	case 'sel_job':
		$job_lists = $do->get_job_list('itemid!=0'.$condition);
		include tpl('person_do_job',$module);
	break;
	case 'person_do_product':
		$product_lists = $do->get_product_list('status=3'.$condition);
		include tpl('person_do_product',$module);
	break;
	case 'product_comment':
		$members = $do->members();
		$comments = $do->product_comments();
		include tpl('person_do_product_comment',$module);
	break;
	case 'product_comment_pingjia':
		$comments = $do->product_comments_pingjia();
		include tpl('person_do_product_comment_pingjia',$module);
	break;
	default:
		$job_lists = $do->get_job_list('itemid!=0'.$condition);
		include tpl('person_do_job',$module);
	break;
}

?>