<?php
defined('IN_DESTOON') or exit('Access Denied');

//isset($keyword) or exit;
//isset($type) or exit;
$keyword = $_GET['keyword'];
$type = $_GET['type'];
if(empty($type)) $type = 0;
global $db;

function getSegmentation($str,$charset='utf8'){
	if(!function_exists('scws_new')){
		return false;      //scws拓展未启动
	}
	$so=scws_new();
        $so->set_charset($charset);
        $so->send_text($str);
        $arr=array();
        while($temp=$so->get_result()){
                foreach($temp as $v){
                        array_push($arr,$v['word']);
                }
        }
        $so->close();
	return $arr;         //返回分词数组
}

$arr=getSegmentation($keyword);
$condition='';
$scws_num=count($arr);
if($scws_num>3){ //如果分出来的词组超过3个，则取后三个分词作为关联词对象
$condition="word like '%".$arr[($scws_num-1)]."%' or word like '%".$arr[($scws_num-2)]."%' or word like '%".$arr[($scws_num-3)]."%' ";
}else{
	foreach($arr as $k=>$v){
		if($k==0){
			$condition.="word like '%".$v."%' ";
		}else{
			$condition.="or word like '%".$v."%' ";
		}
	}
}

$keyword_relevant=$db->query("select * from {$db->pre}keyword where status=3 and keyword <> '$keyword' and $condition group by keyword order by updatetime desc limit 0,15");

if(empty($keyword_relevant)) exit;

$back = '';
while($v=$db->fetch_array($keyword_relevant)){
	$back .= $v['keyword'].'|';
	//if($key == 0) $back .= '<th rowspan="3" class="tt">相关搜索</th>';
	//$back .='<th><a href="search.php?keyword='.$v['keyword'].'&type='.$type.'" data-type="0">'.$v['keyword'].'</a></th><td></td>';
	//if($key == 5 || $key == 10) $back .= '</tr><tr>';
	//$key++;
}

echo substr($back,0,-1);
?>
