<?php
	define('DT_NONUSER', true);
	require '../common.inc.php';
	if($DT_BOT) dhttp(403);

	//Ajax请求API
	if( $_GET['action'] == "ajaxGetOld" ){
		header("Access-Control-Allow-Origin:*");
		header("Access-Control-Allow-Methods:POST,GET");
		//获取更多旧的信息
		$lastItemId = $_GET['lastItemId'];
		$res = $db->query("SELECT `itemid`, `content`, `addtime`, `truename` FROM tc_taoxinxi WHERE itemid < " .$lastItemId. " ORDER BY itemid DESC LIMIT 10");

		$newMsgs = array();
		while ( $row =  mysql_fetch_array( $res)) {
			$newMsgs[] = $row;
		}
		//格式化时间
		foreach ($newMsgs as &$arr){
		    $arr['addtime'] = date('Y-m-d H:i:s', $arr['addtime']);
		}
		
		foreach ( $newMsgs as $key => $value ) {
		    $newData [$key] ['itemid'] = urlencode ( $value ['itemid'] );
		    $newData [$key] ['content'] = urlencode ( $value ['content'] );
		    $newData [$key] ['addtime'] = urlencode ( $value ['addtime'] );
		    $newData [$key] ['truename'] = urlencode ( $value ['truename'] );
		}
		echo urldecode ( json_encode ( $newMsgs ) );
		//输出JSON  PHP5.4以上
		//echo json_encode($newMsgs, JSON_UNESCAPED_UNICODE);

	} elseif ( $_GET['action'] == "ajaxGetNew" ) {
		header("Access-Control-Allow-Origin:*");
		header("Access-Control-Allow-Methods:POST,GET");
		//获取更多新信息
		$firstItemId = $_GET['firstItemId'];
		$firstItemIdTo = $_GET['firstItemId']+ 11;
		$res = $db->query("SELECT `itemid`, `content`, `addtime`, `truename` FROM tc_taoxinxi WHERE itemid < " .$firstItemId. " ANDitemid > " .$firstItemId. " ORDER BY itemid DESC LIMIT 10");

		$newMsgs = array();
		while ( $row =  mysql_fetch_array( $res)) {
			$newMsgs[] = $row;
		}

		//数组倒序
		$newMsgs = array_reverse($newMsgs);
		//格式化时间
		foreach ($newMsgs as &$arr){
		    $arr['addtime'] = date('Y-m-d H:i:s', $arr['addtime']);
		}

		foreach ( $newMsgs as $key => $value ) {
		    $newData [$key] ['itemid'] = urlencode ( $value ['itemid'] );
		    $newData [$key] ['content'] = urlencode ( $value ['content'] );
		    $newData [$key] ['addtime'] = urlencode ( $value ['addtime'] );
		    $newData [$key] ['truename'] = urlencode ( $value ['truename'] );
		}
		echo urldecode ( json_encode ( $newMsgs ) );
		//输出JSON  PHP5.4以上
		//echo json_encode($newMsgs, JSON_UNESCAPED_UNICODE);

	} elseif ( $_GET['action'] == "ajaxGetSearch" ) {
		header("Access-Control-Allow-Origin:*");
		header("Access-Control-Allow-Methods:POST,GET");
		//搜索信息
		$keyword = lib_replace_end_tag( $_GET['keyword'] );
		$areaid = $_GET['areaid'];
		$day = $_GET['day'];
		//搜索条件
		$condition = ' status>0 '; 
		if($day) $condition .= " AND typeid=$typeid";
		if($keyword) $condition .= " AND ( content LIKE '%$keyword%' )";
		
		$res = $db->query("SELECT `itemid`, `content`, `addtime`, `truename` FROM tc_taoxinxi WHERE " .$condition. " ORDER BY itemid DESC LIMIT 50");

		$newMsgs = array();
		while ( $row =  mysql_fetch_array( $res)) {
			$newMsgs[] = $row;
		}
		//格式化时间
		foreach ($newMsgs as &$arr){
		    $arr['addtime'] = date('Y-m-d H:i:s', $arr['addtime']);
		}

		foreach ( $newMsgs as $key => $value ) {
		    $newData [$key] ['itemid'] = urlencode ( $value ['itemid'] );
		    $newData [$key] ['content'] = urlencode ( $value ['content'] );
		    $newData [$key] ['addtime'] = urlencode ( $value ['addtime'] );
		    $newData [$key] ['truename'] = urlencode ( $value ['truename'] );
		}
		echo urldecode ( json_encode ( $newMsgs ) );
		//输出JSON  PHP5.4以上
		//echo json_encode($newMsgs, JSON_UNESCAPED_UNICODE);

	} elseif ( $_GET['action'] == "ajaxAdd" ){
		header("Access-Control-Allow-Origin:*");
		header("Access-Control-Allow-Methods:POST,GET");
		//添加新数据
		if ( !empty($_POST['content']) && !empty($_POST['truename']) ) {
			$iipp = getIP();
			$addtime = time();
			$ipTime = $db->query("SELECT `itemid`, `content`, `addtime`, `truename` FROM tc_taoxinxi WHERE ip = '" .$iipp. "' ORDER BY addtime DESC LIMIT 1");
			$ipTimerow =  mysql_fetch_array( $ipTime);
			//计算两次发布时间间隔，分钟
			$timediff = $addtime - $ipTimerow['addtime'];
			$mins =floor($timediff/60);
			if ($mins > 0) {
				$content = lib_replace_end_tag( $_POST['content'] );
				if ( isValidData($content) ) {
					$truename = $_POST['truename'];
					$qq = $_POST['qq'];
					$iipp = getIP();
					$mphone = $_POST['mphone'];
					if ($qq) $content .= "<br />QQ:" .$qq. ";";
					if ($mphone) $content .= "<br />联系电话:" .$mphone. "。";
					$addtime = time();
					$res = $db->query("INSERT INTO tc_taoxinxi ( content, ip, addtime, truename) VALUES ( '$content', '$iipp', '$addtime', '$truename' )");
					if ($res) {
						$resMsg = "发布成功";
					}
				} else {
					$resMsg = "发布内容待审核";
				}
				
			} else {
				$resMsg = "发布太频繁，请稍后再试";
			}
			
		}
		$addtime = date('Y-m-d H:i:s', $addtime);
		include template('taoxinxi2_fabu', 'touch');

	} elseif ( $_GET['action'] == "getXml" ){
		//php输出XML页面头部代码  
 		header("Content-Type: text/xml; charset=utf-8");
		//搜索信息
		$kw = lib_replace_end_tag( $_GET['kw'] );
		//搜索条件
		$condition = ' status>0 '; 
		if($kw) $condition .= " AND ( content LIKE '%$kw%' )";

		//输出分页控制 单页数量limit  页数page
		$limitInt = $_GET['limit'];
		if (is_numeric($limitInt)) {
			if ($limitInt <= 100 || $limitInt >= 0) {
				$limit = floor($_GET['limit']);
			}
		} else {
			$limit = 20;
		}
		$resNum = $db->query("SELECT `itemid`, `content`, `addtime`, `truename` FROM tc_taoxinxi WHERE " .$condition. " ORDER BY itemid DESC");
		//结果总数
		$total = mysql_num_rows($resNum);
		//计算总页数
		$pagenum = ceil($total/$limit);
		//获取当前页 Page 
		if( !isset($_GET['page']) || !intval($_GET['page']) ){
			if ( $_GET['page'] > $pagenum ) {
				echo "Error : The page " .$total. "per page" .$limit;
				exit;
			}
			$page = 1;
		} else {    
		    $page = $_GET['page'];
		}   

		$startnum = ($page-1)*$limit;
		$res = $db->query("SELECT `itemid`, `content`, `addtime`, `truename` FROM tc_taoxinxi WHERE " .$condition. " ORDER BY itemid DESC LIMIT $startnum, $limit ");

		//循环查询结果
		while ( $row =  mysql_fetch_array( $res)) {
			$data[] = $row;
		}

	    //构造xml数据格式
	    $xmlInfo = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
	    $xmlInfo .= "<data>\n";
	    //页数信息
	    $xmlInfo .= "<Page>\n";
	    if($kw) $xmlInfo .= "<KeyWords><![CDATA[" . lib_replace_end_tag($kw) . "]]></KeyWords>\n";
        $xmlInfo .= "<TotalNum><![CDATA[" . $total . "]]></TotalNum>\n";
        $xmlInfo .= "<PageNum><![CDATA[" . $pagenum . "]]></PageNum>\n";
        $xmlInfo .= "<PerPageNum><![CDATA[" . $limit . "]]></PerPageNum>\n";
        $xmlInfo .= "<OnPage><![CDATA[" . $page . "]]></OnPage>\n";
        $xmlInfo .= "</Page>\n";
	    foreach ($data as $itm) {
	        //循环构造xml单项
	        //<![CDATA[内容]
	        $item = "<Item>\n";
	        $item .= "<Itemid><![CDATA[" . $itm['itemid'] . "]]></Itemid>\n";
	        $item .= "<Content><![CDATA[" . $itm['content'] . "]]></Content>\n";
	        $item .= " <Truename><![CDATA[" . $itm['truename'] . "]]></Truename>\n";
	        $item .= " <Addtime><![CDATA[" . $itm['addtime'] . "]]></Addtime>\n";
	        $item .= " <AddtimeTo><![CDATA[" .date('Y-m-d H:i:s', $itm['addtime']). "]]></AddtimeTo>\n";
	        $item .= "</Item>\n";
	        $xmlInfo .=$item;
	    }
	     
	    $xmlInfo .= "</data>\n";
	    //输出xml数据
	    echo $xmlInfo;


	} elseif ( $_GET['action'] == "getShow" ){
		header("Access-Control-Allow-Origin:*");
		header("Access-Control-Allow-Methods:POST,GET");
		//默认情况直接获取最新数据
		$res = $db->query("SELECT `itemid`, `content`, `addtime`, `truename` FROM tc_taoxinxi ORDER BY itemid DESC LIMIT 20");

		$newMsgs = array();
		while ( $row =  mysql_fetch_array( $res)) {
			$newMsgs[] = $row;
		}
		//数组倒序
		//$newMsgs = array_reverse($newMsgs);
		//格式化时间
		foreach ($newMsgs as &$arr){
		    $arr['addtime'] = date('Y-m-d H:i:s', $arr['addtime']);
		}

		foreach ( $newMsgs as $key => $value ) {
		    $newData [$key] ['itemid'] = urlencode ( $value ['itemid'] );
		    $newData [$key] ['content'] = urlencode ( $value ['content'] );
		    $newData [$key] ['addtime'] = urlencode ( $value ['addtime'] );
		    $newData [$key] ['truename'] = urlencode ( $value ['truename'] );
		}
		echo urldecode ( json_encode ( $newMsgs ) );
		//此方法需要PHP5.4以上
		//echo json_encode($newMsgs2, JSON_UNESCAPED_UNICODE);
	} else {
		dhttp(403);
	}


	//过滤方法
	function lib_replace_end_tag($str)
	{
	 if (empty($str)) return false;
	 $str = htmlspecialchars($str);
	 $str = preg_replace("#<(/?a.*?)>#si",'',$str);
	 $str = str_replace( '/', "", $str);
	 $str = str_replace("\\", "", $str);
	 $str = str_replace(">", "", $str);
	 $str = str_replace("<", "", $str);
	 $str = str_replace("<SCRIPT>", "", $str);
	 $str = str_replace("</SCRIPT>", "", $str);
	 $str = str_replace("<script>", "", $str);
	 $str = str_replace("</script>", "", $str);
	 $str = str_replace("select","select",$str);
	 $str = str_replace("join","join",$str);
	 $str = str_replace("union","union",$str);
	 $str = str_replace("where","where",$str);
	 $str = str_replace("insert","insert",$str);
	 $str = str_replace("delete","delete",$str);
	 $str = str_replace("update","update",$str);
	 $str = str_replace("like","like",$str);
	 $str = str_replace("drop","drop",$str);
	 $str = str_replace("create","create",$str);
	 $str = str_replace("modify","modify",$str);
	 $str = str_replace("rename","rename",$str);
	 $str = str_replace("alter","alter",$str);
	 $str = str_replace("cas","cast",$str);
	 $str = str_replace("&","&",$str);
	 $str = str_replace(">",">",$str);
	 $str = str_replace("<","<",$str);
	 $str = str_replace(" ",chr(32),$str);
	 $str = str_replace(" ",chr(9),$str);
	 $str = str_replace("    ",chr(9),$str);
	 $str = str_replace("&",chr(34),$str);
	 $str = str_replace("'",chr(39),$str);
	 $str = str_replace("<br />",chr(13),$str);
	 $str = str_replace("''","'",$str);
	 $str = str_replace("css","'",$str);
	 $str = str_replace("CSS","'",$str); 
	 return $str;  
	}

	//格式化Json
	function jsons_encode($array){
		//遍历已有数组，将每个值 urlencode 一下
		foreach($array as $key=>$value){
			$array[$key]=urlencode($value);
		 }
		//用urldecode将值反解
		return $array;
	}
	/**注意：中间省略了数组获取的代码，
	使用Foreach遍历数组 同时使用urlencode处理 含有中文的字段
	foreach ( $newMsgs2 as $key => $value ) {
	    $newData [$key] ['itemid'] = urlencode ( $value ['itemid'] );
	    $newData [$key] ['content'] = urlencode ( $value ['content'] );
	    $newData [$key] ['addtime'] = urlencode ( $value ['addtime'] );
	    $newData [$key] ['truename'] = urlencode ( $value ['truename'] );
	}
	你可以使用上面的jsons_encode函数对你的数组进行转换  最后需要urldecode(json_encode($array))
	*/

	//获取IP
	function getIP() { 
	if (getenv('HTTP_CLIENT_IP')) { 
	$ip = getenv('HTTP_CLIENT_IP'); 
	} 
	elseif (getenv('HTTP_X_FORWARDED_FOR')) { 
	$ip = getenv('HTTP_X_FORWARDED_FOR'); 
	} 
	elseif (getenv('HTTP_X_FORWARDED')) { 
	$ip = getenv('HTTP_X_FORWARDED'); 
	} 
	elseif (getenv('HTTP_FORWARDED_FOR')) { 
	$ip = getenv('HTTP_FORWARDED_FOR'); 

	} 
	elseif (getenv('HTTP_FORWARDED')) { 
	$ip = getenv('HTTP_FORWARDED'); 
	} 
	else { 
	$ip = $_SERVER['REMOTE_ADDR']; 
	} 
	return $ip; 
	} 

	//检测内容
	function isValidData($s){ 
    if(preg_match("/([\x{4e00}-\x{9fa5}]|.+)\\1{4,}/u",$s)){ 
        return false;//同字重复５次以上 
    }elseif(preg_match("/^[0-9a-zA-Z]*$/",$s)){ 
        return false;//全数字，全英文或全数字英文混合的 
    }elseif(strlen($s)<10){ 
        return false;//输入字符长度过短 
    } 
    return true; 
} 