<?php

/*
变量：str,要处理的字符串；charset，编码格式
返回：数组格式
说明：对字符串进行分词，以数组格式返回内容；其中避免分词中出现单个字为一个分词，会影响搜索的准确性，对单字分词采用向后拼接的方式返回。
	例子：‘你我他’返回array('你我他')，‘你的东西’返回array('你的'，‘东西’),
*/
function getSegmentation($str,$charset='utf8'){
	
	$seg = getSCWS($str,$charset);
	if($seg === false) return false;
	
	$seg_str = cutWord($seg);
	$seg_crf = exec("/usr/bin/python /usr/local/CRF/python/seg.py '$seg_str' 2>&1",$error,$status);
	
	if($status == '0'){
		$seg1 = explode(' ',$seg_crf);
		$seg = array_merge($seg1,$seg);
		$seg = array_unique($seg);
	}

	$arr = array();
	$count = count($seg);
	$k = 0;
	$re = 0;
    foreach($seg as $v){
			$length = mb_strlen($v,$charset);
			
			if($length < 2 && ($k+1) == $count){ $arr[$k] = $arr[($k-1)].$v;unset($arr[($k-1)]);break;}
			if($re == 1){ 
				$arr[$k] = $arr[($k-1)].$v;unset($arr[($k-1)]);$re = 0;$k++;continue;
			}else{
				$arr[$k] = $v;
			}			
			if($length <2 && $re == 0) $re = 1;
			$k++;
    }
	return $arr;         //返回分词数组
}

function getSCWS($str,$charset='utf8'){
	if(!function_exists('scws_new'))	return false;  //scws扩展未开启
	$so = scws_new();
	$so->set_charset($charset);
	$so->send_text($str);
	$arr = array();
	while($temp = $so->get_result()){
		$count = count($temp);
		foreach($temp as $k => $v){
			$length = mb_strlen($v['word'],$charset);
			//if($length < 2) continue;
			$arr[] = $v['word'];
		}
	}
	$so->close();
	if(empty($arr)) $arr[] = $str;
	return $arr;
}

function so_pages($total,$page,$pagesize,$kw,$type){
	$pages='';
	$start=1;
	$end=10;
	$slast='';
	$snext='';
	$all_page=intval(ceil($total/$pagesize));
	if($total<10){
		$start=1;$end=$all_page;
	}elseif($page<=5){
		$start=1;
		$end=10;
		$slast='';
		if($all_page < $end){
			$end = $all_page;
		}else{
			$snext='<a id="snext" href="search.php?keyword='.$kw.'&type='.$type.'&page='.($page+1).'">下一页></a>';
		}
	}elseif($page+5>$all_page){
		$start=$page-5;
		$end=$all_page;
		$slast='<a id="snext" href="search.php?keyword='.$kw.'&type='.$type.'&page='.($page-1).'"><上一页</a>';
		$snext='';
	}else{
		$start=$page-5;
		$end=$page+5;
		$slast='<a id="snext" href="search.php?keyword='.$kw.'&type='.$type.'&page='.($page-1).'"><上一页</a>';
		if($all_page < $end){
			$end = $all_page;
		}else{
			$snext='<a id="snext" href="search.php?keyword='.$kw.'&type='.$type.'&page='.($page+1).'">下一页></a>';
		}
	}
	
	for($start;$start<=$end;$start++){
		$pageclass=$start==$page?'pagey':'pagen';
		$pages.='<a href="search.php?keyword='.$kw.'&type='.$type.'&page='.$start.'" class="'.$pageclass.'">'.$start.'</a>';	
	}
	$pages=$slast.$pages;
	$pages=$pages.$snext;
	return $pages;

}

function get_wildcard($str,$replace,$length = 9999){		//	通配符置换
	if(!strlen($str)) return $str;
	$replace = '<em>'.$replace.'</em>';             //添加<em>标签，用于描红
	$start = strpos($str,'{');
	while($start !== false){					//文字中可存在多个通配符
		$before_str = '';	//找到的{前的符号默认为‘’			
		if($start != 0){
			$before = $start-1;
        		$before_str=substr($str,$before,1);		//获取前一个字符
		}
        	if($before_str != ':'){               //   :{ 为用户希望保留{
			$end = strpos($str,'}',$start+1); 
			if($end === false) break;			//没有找到}符号，不构成完整的通配符
			$end_before = substr($str,$end-1,1);
			while($end_before == ':'){		//	:} 为用户希望保留}
				$end = strpos($str,'}',$end+1);
				if($end === false )break;
			}
			if($end === false) break;
			$before_replace = substr($str,$start,($end - $start +1));		//替换通配符为搜索内容
			$str = str_replace($before_replace,$replace,$str);
		}
		$start = strpos($str,'{',$start+1);  		//查找下一个｛
	}
	$str = str_replace(':{','{',$str);
	$str = str_replace(':}','}',$str);	
	if(strlen($str)>$length){
		return false;	
	}else{
		return $str;
	}
}

function get_cache($name){
	global $dc;
	$cache = $dc->get($name);
	if(!$cache) { set_cache($name); }else{ return $cache; }
	return $dc->get($name);
}

function set_cache($name,$string){
	global $db,$dc;
	$one_day_seconds = 86400;
	switch($name){
		case 'info_type':
			$info_type = new info_type();
			$lists = $info_type -> get_list();

			$write = array();
			foreach($lists as $k=>$v){
				$write[$v['catid']] = $v;
			}
			return $dc->set('info_type',$write,$one_day_seconds);
		break;
		case 'hot_news':
			$hot_news_data = $db->query("select *,itemid as infoid from {$db->pre}sogex_info_news where status = 3 and hits > 5 order by itemid desc limit 0,20");
			$write = array();
			while($r = $db->fetch_array($hot_news_data)){
				$write[] = $r;
			}
			return $dc->set('hot_news',$write,$one_day_seconds);;
		break;
		case 'recom_malls':
			$malls = $db->query("select itemid,linkurl,thumb,title from {$db->pre}mall where status = 3 and thumb <> '' order by itemid desc limit 0,10");
			$write = [];
			while($r = $db->fetch_array($malls)){
				$write[] = $r;
			}
			return $dc->set('recom_malls',$write,$one_day_seconds);
		break;
		default:
			return false;
	}
	
}

function get_ip(){
	$ip = '';
	if ($HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]) { 
		$ip = $HTTP_SERVER_VARS["HTTP_X_FORWARDED_FOR"]; 
	} elseif ($HTTP_SERVER_VARS["HTTP_CLIENT_IP"]) { 
		$ip = $HTTP_SERVER_VARS["HTTP_CLIENT_IP"]; 
	} elseif ($HTTP_SERVER_VARS["REMOTE_ADDR"]) { 
		$ip = $HTTP_SERVER_VARS["REMOTE_ADDR"]; 
	} elseif (getenv("HTTP_X_FORWARDED_FOR")) { 
		$ip = getenv("HTTP_X_FORWARDED_FOR"); 
	} elseif (getenv("HTTP_CLIENT_IP")) { 
		$ip = getenv("HTTP_CLIENT_IP"); 
	} elseif (getenv("REMOTE_ADDR")){ 
		$ip = getenv("REMOTE_ADDR"); 
	}	
	return $ip; 
}

/*
利用curl对https地址的接口发送请求，使用前确定环境已启动curl和openssl
@params : $url请求地址，$data需发送的数据参数，$header信息头，$timeout请求时间,$type发送类型post或get
@return : bool 或 string
*/
function curl_https($url, $data=array(), $header=array(),$timeout=30,$type = 'get'){  
  
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查  
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);  // 从证书中检查SSL加密算法是否存在 
    $params = http_build_query($data);				//将数据数组拼接为地址参数格式，并进行urlencode转码
    
    if($type == 'get'){
		$url .= '?'.$params; 			//get的发送方式，将参数接到地址后
		curl_setopt($ch, CURLOPT_POST, false);  
	}else{
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);  //post发送方式，数据参数作为配置参数
		curl_setopt($ch, CURLOPT_POST, true);  
	}
     
    curl_setopt($ch, CURLOPT_URL, $url);  	//配置请求地址
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);  //配置信息头
    
    //curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
   
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);   //如果成功只将结果返回，不自动输出任何内容
    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);  //请求等待时间

    $response = curl_exec($ch);  
  
    if($error=curl_error($ch)){  
       	return false;
    }  
  
    curl_close($ch);  
  
    return $response;  
  
}

/*
获取拓词
return array,array['str']拓展出的未处理字符串，array['search']拓展出的用于搜索分词的字符串
*/
function get_expand($word,$sword){
	
	$url = 'https://sp0.baidu.com/5a1Fazu8AA54nxGko9WTAnF6hhy/su';
	$data = array('wd'=>$word);
	$headers = array("Content-type: application/json;charset=UTF-8","Accept: application/json","Cache-Control: no-cache", "Pragma: no-cache",);
	$response = curl_https($url, $data, $headers, 3);
	
	if($response == '' || strpos($response,',p:true,')){    //接口没有获得结果
                global $db;
                $back = array();                //返回数组
                foreach($sword as $v){
                        $expand_word = $db->get_one("select word from {$db->pre}keyword where word like '%$v%' and word <> '$v' order by month_search desc limit 0,1");
                        $back['str'] .= $expand_word['word'].',';
                        $expand .= str_replace($v,'',$expand_word['word']);
                }
                if($expand != ''){
                        $expand_arr = getSegmentation($expand);
                        $back['str'] = substr($back['str'],0,-1);
                        $back['search'] = '"'.implode('"|"',$expand_arr).'"';
                        return $back;
                }
        }
                $r = str_replace('window.baidu.sug({q:"'.strtolower($word).'",p:false,s:[','',iconv('gbk','utf-8',$response));
                $r = str_replace(']});','',$r);
                //$r = str_replace(strtolower($word),'',$r);
                $temp = explode(',',$r);
                $r = '';
                $k = 0;
                foreach($temp as $v){
                        if(mb_strlen($v) < 3 || mb_strlen($v) > 6) continue;
                        $back['str'] .= $v.',';
                        $v = str_replace(strtolower($word),'',$v);
                        $r .=$v.'|';
                        $k++;
                        if($k > 1) break;
                }
                if(!empty($r)){
                        $back['str'] = substr($back['str'],0,-1);
                        $back['search'] = substr($r,0,-1);
                        return $back;
                }
        return false;
}

/* 将汉字词语拆分为单个字 
@word_arr  ，词语数组
return string
*/
function cutWord($word_arr){
        $word_str = '';
        foreach($word_arr as $v){
                if (preg_match("/[\x7f-\xff]/", $v)){
                        $strlen = mb_strlen($v);
                        $string = $v;
                        while($strlen){
                                $word_str .= mb_substr($string,0,1,"utf8").' ';
                                $string = mb_substr($string,1,$strlen,"utf8");
                                $strlen = mb_strlen($string);
                        }
                }else{
                        $word_str .= $v.' ';
                }
        }
        return substr($word_str,0,-1);
}

/**
* 屏蔽字符串中的长数字
* @$str,待处理的字符串
* @$length,超过该长度的数字字符串将被替换为*
* 
* @return string
*/
function screenNumber($str,$length = 4){
	if(!isset($str) || empty($str)) return '';
	$seg = getSCWS($str);	
	$result = array();
	foreach($seg as $v){
		$strlen = strlen($v);
		$result[] = (is_numeric($v) && $strlen > $length) ? str_repeat('*',$strlen) : $v;
	}
	return implode('',$result);
}

/**
* 获取自定义规则对搜索的影响
* @word 处理搜索词
* @return
*/
function getRuleWeight($word){
	global $db;
	//查找规则
	$rule3_data=$db->query("select * from {$db->pre}sogex_rule where type = 3"); //针对所有类型所有词到规则
	$weight_str = '';
	while($r=$db->fetch_array($rule3_data)){
		$weight_str .="+IF(website_url='$r[web_url]',$r[score],0)";
	}

	//针对所有分类单一词
	$rule2_data=$db->query("select * from {$db->pre}sogex_rule where type = 2 and keyword in ('$word')");

	while($r=$db->fetch_array($rule2_data)){
		$weight_str="+IF(website_url='$r[web_url]',$r[score],0)";
	}

	//针对单一分类所有词
	if($type){
		$rule1_data=$db->query("select * from {$db->pre}sogex_rule where type =1 and infotype = $type");
		while($r=$db->fetch_array($rule1_data)){
			$weight_str="+IF(website_url='$r[web_url]',$r[score],0)";
		}
	}

	//针对单一分类和单一词
	if($type){
		$rule0_data=$db->query("select * from {$db->pre}sogex_rule where type = 0 and infotype = $type and keyword in ('$word')");
		while($r=$db->fetch_array($rule0_data)){
			$weight_str="+IF(website_url='$r[web_url]',$r[score],0)";
		}
	}
	
	return $weight_str;
}

function getSeo($keyword,$type = 0,$total = 0){
	$seo_message = [
		0 => '产品详情/厂家/联系方式等信息',
		1 => '产品/详情/图片/厂家等信息',
		2 => '厂家/联系方式/公司介绍等信息',
		3 => '新闻/资讯/行业信息',
		4 => '维修/服务/工程师等信息',
		5 => '维修工程师/售后工程师/医疗器械维修等信息',
		6 => '供应/求购/需求_供求等信息',
		7 => '项目申报/科研项目转化/资质注册等信息'
	];
	$back['title'] = '收录'.$total.'条关于“'.$keyword.'”'.$seo_message[$type].'-天成医搜。';
	
	$seo_desc = [
		0 => "天成医搜收录 $total 条 $keyword 的相关医疗产品/厂家/服务工程师/资讯等信息，点击查看更多 $keyword 医疗器械相关信息。",
		1 => "天成医搜收录 $total 条 $keyword 的相关产品信息/产品详情/产品图片/产品厂家等信息，点击查看更多 $keyword 医疗器械相关信息。",
		2 => "天成医搜收录 $total 条 $keyword 的相关厂家信息公司介绍/联系方式/公司介绍等信息，点击查看更多 $keyword 医疗器械相关信息。",
		3 => "天成医搜收录 $total 条 $keyword 的相关资讯/新闻/行业信息等，点击查看更多 $keyword 医疗器械相关信息。",
		4 => "天成医搜收录 $total 条 $keyword 的相关维修/服务/工程师等信息，点击查看更多 $keyword 医疗器械相关信息。",
		5 => "天成医搜收录 $total 条 $keyword 的相关维修工程师/售后工程师/医疗器械维修等信息，点击查看更多 $keyword 医疗器械相关信息。",
		6 => "天成医搜收录 $total 条 $keyword 的相关供应/求购/需求/供求信息等，点击查看更多 $keyword 医疗器械相关信息。",
		7 => "天成医搜收录 $total 条 $keyword 的相关项目申报/科研项目转化/资质注册等信息，点击更多 $keyword 医疗器械相关信息。",
	];
	$back['description'] = $seo_desc[$type];

	$seo_key = [
		0 => $keyword.'产品,'.$keyword.'厂家,'.$keyword.'搜索结果',
		1 => $keyword.'产品,'.$keyword.'详情,'.$keyword.'图片',
		2 => $keyword.'公司,'.$keyword.'厂家,'.$keyword.'生产厂家',
		3 => $keyword.'资讯,'.$keyword.'新闻,'.$keyword.'行业信息',
		4 => $keyword.'维修,'.$keyword.'服务',
		5 => $keyword.'工程师,'.$keyword.'售后工程师,'.$keyword.'维修工程师',
		6 => $keyword.'供应,'.$keyword.'求购,'.$keyword.'供求信息',
		7 => $keyword.'项目申报,'.$keyword.'项目转化,'.$keyword.'资质注册',
	];
	$back['keyword'] = $seo_key[$type];
	
	return $back;
}


function getSpread($keyword,$type = 0){
	//查找推广
	//查找信息推广类型，0表示全网搜索可以显示，99表示可放置在首页和全网搜索
	global $db;
	$spread_type = '';
	if(!empty($type)){
		$spread_type = " and s.mid in (0,99,$type)";
	}else{
		$spread_type = " and s.mid in (0,99)";
	}
	//包月类型推广
	$spread_arr = array();		//推广数据
	$spread_data_1 = $db->query("select i.ideaid as ideaid,s.itemid as itemid,i.name as title,i.url as url,i.description as description,i.addtime as addtime,i.thumb as thumb,i.default_name as default_name,i.default_description as default_description , s.tid as tid from {$db->pre}spread as s join {$db->pre}sogex_ideas as i on s.tid = i.ideaid where s.word = '$keyword' and i.status = 3 and s.status = 3 and s.stype = 1 and s.fromtime <= ".time()." and s.totime >= ".time()." $spread_type group by s.tid order by s.total desc ");
	$select_tid = array();	//存放已经搜索出的创意id
	while($v = $db->fetch_array($spread_data_1)){
		array_push($select_tid,$v['tid']);
		array_push($spread_arr,$v);	
	}

	$count1 = count($spread_arr);	//统计已获得推广数目
	$limit = 12 - $count1;

	//单条类型推广 
	$select_tid_str = implode(',',$select_tid);	//已搜索创意id到字符串
	//搜索条件：符合搜索词（word=$keyword），通过审核(status=3),用户启动(spread_status=3)，单条类型(stype=2)，剩余比话费多(least>spend)，创意没有在包月类型已使用(tid not in ),搜索类型符合(spread_type)
	$spread_data_2 = $db->query("select i.ideaid as ideaid,s.itemid as itemid ,i.name as title,i.url as url,i.description as description,i.addtime as addtime,i.thumb as thumb,i.default_name as default_name,i.default_description as default_description from {$db->pre}spread as s join {$db->pre}sogex_ideas as i on s.tid = i.ideaid  where s.word = '$keyword' and i.status = 3 and s.status = 3 and s.spread_status = 3 and stype = 2 and s.least > s.spend and s.tid not in ($select_tid_str) $spread_type group by s.tid order by s.spend desc LIMIT 0,$limit");

	while($v = $db->fetch_array($spread_data_2)){
		array_push($spread_arr,$v);
	}
	return $spread_arr;
}

function setSearchRecord($keyword,$_username = '',$total = 0,$type = 0){
	global $db;
	$uip = get_ip();
	$addtime = time();
	$db->query("insert into {$db->pre}sogex_record (word,username,total,ip,type,addtime) values ('$keyword','$username','".$total."','$uip',$type,'$addtime')");
}

/**
* 医搜系统，伪静态地址重写
* @param string $url
* 
* @return
*/
function so_rewrite($url){
	//if(!SO_REWRITE) return $url;
	if(empty($url)) return false;
	if(!is_array($url)) return $url;
	return http_build_query($url);
	
	/*
	$url_arr = explode('?',$url);
	$head = explode('/',$url_arr[0]);		//将域名和文件名切分
	$filename = $head[(count($head)-1)];	//程序文件名
	if(strpos($filename,'.php') === false) return $url;		//非php动态地址不处理
	$filename = str_replace('.php','',$filename);
	if(empty($url_arr[1])) return $filename.'.html';
	$param = explode('&',$url_arr[1]);		//参数数组
	if($filename == 'search' || $filename == 'msearch'){
			$par = array();
			foreach($param as $v){
				$p = explode('=',$v);
				$par[$p[0]] = $p[1];
			}
			if(!isset($par['keyword'])) return $url;		//搜索地址缺少keyword，错误地址，原样返回
			$type = isset($par['type'])?'?type='.$par['type']:'';
			$page_pre = $type == ''? '?':'&';
			$page = isset($par['page'])?$page_pre.'page='.$par['page']:'';
			return $filename.'-'.$par['keyword'].'.html'.$type.$page;
	}else if($filename == 'mdetail' || $filename == 'detail'){
			$par = array();
				foreach($param as $v){
					$p = explode('=',$v);
					$par[$p[0]] = $p[1];
				}
				if(!isset($par['itemid']) || !isset($par['infotype'])) return $url;
				$type = isset($par['type'])?'?type='.$par['type']:'';
				$keyword_pre = $type == ''? '?':'&';
				$keyword = isset($par['keyword'])?$keyword_pre.'keyword='.$par['keyword']:'';
				return $filename.'-'.$par['infotype'].'-'.$par['itemid'].'.html'.$type.$keyword;
	}else{
				$back = $filename.'-';
				foreach($param as $v){
					$p = explode('=',$v);
					$back .= $p[0].'-'.$p[1];
				}
				return $back .'.html';
	}
	*/	//暂时屏蔽伪静态重写功能
}

class info_type{
	var $db;
	var $table;
	
	function info_type(){
		global $db;
		$this->db=$db;
		$this->table=$db->pre.'sogex_info_type';
	}
	
	function get_list(){
		$result=$this->db->query("select * from {$this->table}");
		$lists=array();
		while($r=$this->db->fetch_array($result)){
			$lists[]=$r;
		}
		return $lists;
	}
}

?>
