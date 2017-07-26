<?php
defined('IN_DESTOON') or exit('Access Denied');
$TYPE = get_type('taoxinxi', 1);
require MD_ROOT.'/taoxinxi.class.php';
//require MD_ROOT.'/announce.class.php';

require DT_ROOT.'/include/tcdb.class.php';
$do = new taoxinxi();
$taoxinxi = new tcdb('taoxinxi');
$menus = array (
    //array('添加Q群信息', '?moduleid='.$moduleid.'&file='.$file.'&action=add'),
    array('Q群信息列表', '?moduleid='.$moduleid.'&file='.$file),
    array('Q群信息审核', '?moduleid='.$moduleid.'&file='.$file.'&action=check'),
    array('Q群信息分类', 'javascript:Dwidget(\'?file=type&item='.$file.'\', \'Q群信息分类\');'),
    array('模块设置', '?moduleid='.$moduleid.'&file=setting#'.$file),
);

if($_catids || $_areaids) require DT_ROOT.'/admin/admin_check.inc.php';

switch($action) {
	case 'add':
		if($submit) {
			if($do->pass($post)) {
				$do->add($post);
				dmsg('添加成功', '?moduleid='.$moduleid.'&file='.$file.'&action='.$action.'&typeid='.$post['typeid']);
			} else {
				msg($do->errmsg);
			}
			if($post["daoru"] == "daoru"){
				dmsg('daoru');
			}
		} else {
			foreach($do->fields as $v) {
				isset($$v) or $$v = '';
			}
			$addtime = timetodate($DT_TIME);
			$menuid = 0;
			include tpl('taoxinxi_edit', $module);
		}
	break;
	case 'edit':
		$itemid or msg();
		$do->itemid = $itemid;
		if($submit) {
			if($do->pass($post)) {
				$do->edit($post);
				dmsg('修改成功', $forward);
			} else {
				msg($do->errmsg);
			}
		} else {
			extract($do->get_one());
			$addtime = timetodate($addtime);
			$fromtime = $fromtime ? timetodate($fromtime, 3) : '';
			$totime = $totime ? timetodate($totime, 3) : '';
			$menuid = 1;
			include tpl('taoxinxi_edit', $module);
		}
	break;
	case 'show':
		$itemid or msg('请选择信息');
		$data = $taoxinxi->where(['itemid'=>$itemid])->one();
		$lists = $taoxinxi->where(['allowitemid'=>$itemid])->all();
		$type_db = new tcdb('type');
		$taoxinxi_type = $type_db->field('typeid,typename')->where(['item'=>'taoxinxi'])->all();
		$type = [];
		foreach($taoxinxi_type as $k=>$v){
			$type[$v['typeid']] = $v['typename'];
		}
		include tpl('taoxinxi_show',$module);
	break;
	case 'delete':
		$itemid or msg('请选择信息');
		if(is_array($itemid)){
			$itemid_str = implode(' , ',$itemid);
			$condition_str = "itemid in ('".$itemid_str."') ";
		}else{
			$condition_str = 'itemid = '.$itemid;
		}
		if($taoxinxi->delete($condition_str)){
			dmsg('删除成功',"?moduleid=$moduleid&file=$file");
		}else{
			msg('删除失败');
		}
	break;
	case 'examine':		//审核信息
		$itemid or msg('请选择信息');
		$itemid_str = implode(' , ',$itemid);
		$condition_str = "itemid in ('".$itemid_str."') ";
		if($taoxinxi->edit(['status'=>3],$condition_str)){
			dmsg('审核成功',"?moduleid=$moduleid&file=$file");
		}else{
			msg('审核失败');
		}
	break;
	default:
		global $pagesize;
		if(isset($typeid) && $typeid != 0) $condition['typeid'] = $typeid;
		if($action == 'check'){
			$status = 1;
			$menu = 1;
		}else{
			$status = 3;
			$menu = 0;
		}
		$condition['status'] = $status;
		if(isset($keyword)) $search['content'] = $keyword;
		$page or $page = 1;
		$start = ($page - 1)*$pagesize;
		
		$type_select = type_select('taoxinxi', 1, 'typeid', '请选择分类', $typeid);
		
		$type_db = new tcdb('type');
		$taoxinxi_type = $type_db->field('typeid,typename')->where(['item'=>'taoxinxi'])->all();
		$type = [];
		foreach($taoxinxi_type as $k=>$v){
			$type[$v['typeid']] = $v['typename'];
		}
				
		$items = $taoxinxi->field('count(*) as c')->where($condition)->likeWhere($search,true,'all')->one();
		$lists = $taoxinxi->where($condition)->likeWhere($search,true,'all')->limit($start,$pagesize)->order('itemid desc')->select();
		$pages = pages($items['c'],$page,$pagesize);
		
		include tpl('taoxinxi', $module);
	break;
}
?>