<?php
defined('IN_DESTOON') or exit('Access Denied');

global $db;

$table = array('mall'=>'mall','company'=>'company','article'=>'article_21','job'=>'job','resume'=>'resume','sell'=>'sell_5','tech'=>'quote');
$mid = array('mall'=>16,'company'=>4,'article'=>21,'job'=>9,'resume'=>28,'sell'=>5,'tech'=>7);
if(!isset($table[$_REQUEST['module']])){
	$result = array('status'=>'-1','error'=>'module参数错误');
	exit(json_encode($result,JSON_UNESCAPED_UNICODE));
}

switch($_REQUEST['move']){
	case 'recommend':
		require_once DT_ROOT.'/module/search/sphinxSearch.class.php';
		$sphinx = new sphinxSearch();
		$sphinx->indexex = 'data';
		$sphinx->setCondition(array('status'=>3,'moduleid'=>$mid[$_REQUEST['module']]));
		$pagesize = isset($_REQUEST['pagesize']) ? $_REQUEST['pagesize']:10;
		$sphinx->setLimits(0,$pagesize,$pagesize);
		$result = $sphinx->query($_REQUEST['keyword'],$sphinx->indexex);
		
		$data = array();
		foreach( $result['matches'] as $k=>$v){
			$d = $v['attrs'];
			$data[$k]['title'] = $d['title'];
			$data[$k]['introduce'] = $d['introduce'];
			$data[$k]['thumb'] = $d['thumb'];
			if($_REQUEST['module'] == 'company'){
				$data[$k]['linkulr'] = $d['linkurl'];
			}else{
				$data[$k]['linkurl'] = $MODULE[$mid[$_REQUEST['module']]]['linkurl'].$d['linkurl'];
			}
		}
		exit(json_encode($data,JSON_UNESCAPED_UNICODE));
	break;
	default:
		$result = array('status'=>'6','error'=>'move参数错误');
		exit(json_encode($result,JSON_UNESCAPED_UNICODE));
}


function checkEmpty(){
	$args = func_get_args();
	foreach($args as $v){
		if(!isset($v) || empty($v)) return false;
	}
	return true;
}

?>