
<?php
function gethttpcode($url){// 获取微信URL网址的源代码
	global $db, $table, $table_data, $MOD, $DT_PRE,$moduleid,$module,$array;
	$table = $DT_PRE.'news';
	$table_data = $DT_PRE.'news_data';
	$d=array();
	$array=array();
		$j = $db->get_one("SELECT * FROM $table WHERE fromurl='$url'");
	    if(!$j){//没有采集过的数据

	     	$host = getbetween($url,"://","/");
	     	$curlopt_useragent = '';
	     	if ($host == "info.3g.qq.com") {
	     		//$curlopt_useragent = 'Mozilla/5.0 (Linux; U; Android 4.4.4; zh-cn; HM NOTE 1S Build/KTU84P) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/39.0.0.0 Mobile Safari/537.36 XiaoMi/MiuiBrowser/2.1.1';
	     		$curlopt_useragent = 'Mozilla/5.0 (iPad; CPU OS 8_3 like Mac OS X) AppleWebKit/600.1.4 (KHTML, like Gecko) Version/8.0 Mobile/12F69 Safari/600.1.4';
	     	}else{
				$curlopt_useragent = 'Mozilla/5.0 (Windows; U; Windows NT 5.2) AppleWebKit/525.13 (KHTML, like Gecko) Chrome/0.2.149.27 Safari/525.13';
			}

			$title = "";
			$content = "";
			if(iframe($url)){
				$title='请输入标题';
				$content='iframe';
			} else {
				$ch = curl_init();

				$curl_opt = array(
					CURLOPT_FOLLOWLOCATION => 0,
					CURLOPT_HEADER => 0,
					CURLOPT_RETURNTRANSFER => 1,
					CURLOPT_USERAGENT => $curlopt_useragent,
					CURLOPT_URL => $url,
					CURLOPT_TIMEOUT => 60,
					CURLOPT_REFERER => 'http://' . $_SERVER['HTTP_HOST'],
				);

				curl_setopt_array($ch, $curl_opt);
				$content = curl_exec($ch);

				// var_dump($content);

				if ($host == "www.huxiu.com") {$array= huxiu($content);}
				if ($host == "mp.weixin.qq.com") {$array = weixin($content);}
				if ($host == "news.ifeng.com") {$array = ifeng($content);}
				if ($host == "i.ifeng.com") {$array = m_ifeng($content);}
				if ($host == "info.3g.qq.com") {
					$array = tengxun($content);
					$d['isQQ'] = 1;
				}
				if ($host == "view.inews.qq.com") {
					$array = inews($content);
					$d['isQQ'] = 1;
				}
				if ($host == "toutiao.com") {$array = toutiao($content);}
				if ($host == "www.toutiao.com") {$array = toutiao($content);}
				if ($host == "xw.qq.com") {$array = tencent($content);}

				$title = $array[0];
				$content = $array[1];
			}
			$d['title']=$title;
			$d['url']=$url;
			$d['content']=$content;
			return $d;//返回数据
		 }
		 else{//采集过的数据
			echo msg($j['title'],'数据已经存在',$j['itemid']);exit;
		 }
}

function infoadd($module,$moduleid,$title,$catid,$content,$username,$status=2,$thumb='',$fromurl,$itemid='',$author=''){//添加数据
	global $db, $table, $table_data, $MOD, $DT_PRE,$DT_TIME,$DT_IP,$moduleid,$module;
		$table = $DT_PRE.'news';
		$table_data = $DT_PRE.'news_data';
		$content=str_replace('width="320" widthd=','width=',$content);
		$content=str_replace('width:_','width:',$content);
		$content=str_replace(' height="auto" heightd=','height=',$content);
		$introduce = trim(strip_tags($content));
		$introduce=addslashes(dsubstr($introduce, 125));
		if(strpos($introduce,'qy_name')){$introduce=$title;}
		if ($itemid) {
			$db->query("UPDATE $table SET title='".$title."',thumb='".$thumb."',catid=".$catid.",status=".$status." WHERE itemid=".$itemid);
			$db->query("UPDATE $table_data SET content='".$content."' WHERE itemid=".$itemid);
			$overs='信息修改成功！';
			echo msg($overs,$title,$itemid);
		}else{
			$j = $db->get_one("SELECT * FROM $table WHERE title='$title'");
			 if(!$j){
				$db->query("INSERT INTO $table (title,thumb,catid,username,editor,addtime,edittime,ip,fromurl,introduce,keyword,status,author) VALUES('$title','$thumb',$catid,'$username','$username','$DT_TIME','$DT_TIME','$DT_IP','$fromurl','$introduce','$title',$status,'$author')");
				$itemid=$db->insert_id();
				$db->query("INSERT INTO $table_data (itemid,content) VALUES($itemid,'$content')");
				$db->query("UPDATE $table SET linkurl='show.php?itemid=".$itemid."' WHERE itemid=".$itemid);
				$overs='信息添加成功，正在后台审核！';
				echo msg($overs,$title,$itemid);
			 }else{
				$itemid=$j['itemid'];
				$overs='数据已经存在！';
				echo msg($overs,$title,$itemid);
			}
		}
}

function infoedit($module,$moduleid,$itemid){//修改数据
	global $db, $table, $table_data, $MOD, $DT_PRE,$moduleid,$module;
	$table = $DT_PRE.'news';
	$table_data = $DT_PRE.'news_data';
		if($itemid){
			$j = $db->get_one("SELECT * FROM $table a join $table_data b  WHERE a.itemid=b.itemid and a.itemid=$itemid");
		}
		else{
			$j['title']='请填写标题';
			$j['content']='请填写内容';
		}
	return $j;
}



function delinfo($module,$moduleid,$itemid){//删除数据
	global $db, $table, $table_data, $MOD, $DT_PRE,$moduleid,$module;
	$table = $DT_PRE.'news';
	$table_data = $DT_PRE.'news_data';
			$db->query("delete  from  $table  where itemid=".$itemid);
			$db->query("delete  from  $table_data where itemid=".$itemid);
		    return "<script>alert('删除成功，重新发布');location.href='index.php'</script>";
}


function msg($msg,$title,$itemid,$moduleid=29){
	return "<div style='text-align:center;padding:10px'><h2>".$msg."</h2>点击以下地址打开或者直接扫描一下二维码！<br><a href='http://wap2.tecenet.com/index.php?moduleid=29&itemid=".$itemid."' ><u style='color:red;font-size:18px;'>".$title."-</u></a><br><br><br><br><input type=\"button\" onclick=\"location.href='index.php?action=addnew&itemid=".$itemid."'\" value='修改'>&nbsp;&nbsp;&nbsp;<input type=\"button\" onclick=\"location.href='index.php?action=del&itemid=".$itemid."'\" value='删除'><br><img src='../ewm.php?size=6&dz=".urlencode('http://wap2.tecenet.com/index.php?moduleid='.$moduleid.'&itemid='.$itemid)."'><br><br><input type='button' value=' 继续发布 ' class=\"sub\"  onclick=\"location.href='index.php'\">";
}


?>
