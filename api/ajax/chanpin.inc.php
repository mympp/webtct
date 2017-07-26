<?php
/*
what:根据产品的id返回产品的json格式数据
*/
defined('IN_DESTOON') or exit('Access Denied');
if(!isset($mallid)||$mallid==''){
	echo '{"wrong":"mallid不可为空"}';
}else{
	$result=$db->get_one("select * from {$db->pre}mall where itemid='$mallid'");
	if(!$result){
		echo '{"wrong":"没有该商品"}';
	}else{
		$str_back='{';
		foreach($result as $k=>$v){
			if($k=='step'){                //6.0升级，未处理step数据
				continue;
			}
			$str_back.='"'.$k.'":"'.$v.'",';
			
		}
		//$back=substr($str_back,0,strlen($str_back)-1); //截取最后的，号
		$str_back.='"buyurl":"'.$CFG['url'].'chanpin/'.rewrite('buy.php?itemid='.$result['itemid']).'"';         //立即购买地址
		$str_back.=',"inquiry":"'.$CFG['url'].'chanpin/'.rewrite('inquiry.php?itemid='.$result['itemid']).'"';
	
		if($result['n1']!=''&&$result['v1']!=''){           //属性1处理
			$str_back.=',"shuxing1_name":"'.$result['n1'].'"';
			$v1_arr=explode('|',$result['v1']);
			foreach($v1_arr as $k=>$v){
				$str_n1.='"'.$v.'",';
			}
			$str_n=substr($str_n1,0,strlen($str_n1)-1);
			$str_back.=',"shuxing_v1":['.$str_n.']';
		}
		
		if($result['n2']!=''&&$result['v2']!=''){          //属性2处理
			$str_back.=',"shuxing2_name":"'.$result['n2'].'"';
			$v2_arr=explode('|',$result['v2']);
			foreach($v2_arr as $k=>$v){
				$str_n2.='"'.$v.'",';
			}
			$str_n=substr($str_n2,0,strlen($str_n2)-1);
			$str_back.=',"shuxing_v2":['.$str_n.']';
		}
		
		if($result['n3']!=''&&$result['v3']!=''){              //属性3处理
			$str_back.=',"shuxing3_name":"'.$result['n3'].'"';
			$v3_arr=explode('|',$result['v3']);
			foreach($v3_arr as $k=>$v){
				$str_n3.='"'.$v.'",';
			}
			$str_n=substr($str_n3,0,strlen($str_n3)-1);
			$str_back.=',"shuxing_v3":['.$str_n.']';
		}
		
		$str_back.='}';
		echo $str_back;
	}
}
?>