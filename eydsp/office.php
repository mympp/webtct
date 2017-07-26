<?php
	define('DT_NONUSER', true);
	require '../common.inc.php';
	if($DT_BOT) dhttp(403);
	if(!empty($_POST)) {
		//收件人
		$touser = 'youki2012';
		//活动名称
		$type = '五周年活动';
		//$typeid 设置为7
		$typeid = 7;

		//统计文件count
		$file = 'count.json';
		$lockFile = 'lock.txt';
		
        if (!file_exists($file)) {
        	$data = array();
			$data['c1'] = 1;
			$data['c2'] = 1;
			$data['c3'] = 1;
			$data['c4'] = 1;
			$data['c5'] = 1;
			$data['c6'] = 1;
			$data['c7'] = 1;
			$data['c8'] = 1;
			$data['c9'] = 1;
			$data['c10'] = 1;
			$data['c11'] = 1;
			$data['c12'] = 1;
			// 把PHP数组转成JSON字符串
			$content = json_encode($data);
			file_put_contents($file, $content);
        }else{
        	$fo = fopen($lockFile, 'r');
        	$locked = flock($fo, LOCK_EX);
        	if (!$locked) {
        		return false;
        	}else{
        		$json_string = file_get_contents($file);
        		// 把JSON字符串转成PHP数组
            	$data = json_decode($json_string, true);

				$aboutTitle = intval($_POST['abouttitle']);
				switch ($aboutTitle)
				{
				case 1:
					$aboutTitle = "产品服务";
					$data['c1']++;
					break;
				case 2:
					$aboutTitle = "金融服务";
					$data['c2']++;
					break;
				case 3:
					$aboutTitle = "技术服务";
					$data['c3']++;
					break;
				case 4:
					$aboutTitle = "产品资质服务";
					$data['c4']++;
					break;
				case 5:
					$aboutTitle = "业务推广服务";
					$data['c5']++;
					break;
				case 6:
					$aboutTitle = "VIP会员服务";
					$data['c6']++;
					break;
				case 7:
					$aboutTitle = "医疗技术服务";
					$data['c7']++;
					break;
				case 8:
					$aboutTitle = "医疗科研服务";
					$data['c8']++;
					break;
				case 9:
					$aboutTitle = "物流与进口服务";
					$data['c9']++;
					break;
				case 10:
					$aboutTitle = "人力资源服务";
					$data['c10']++;
					break;
				case 11:
					$aboutTitle = "医学工程服务";
					$data['c11']++;
					break;
				case 12:
					$aboutTitle = "健康管理服务";
					$data['c12']++;
					break;
				default:
					dalert("请选择服务", 'goback');
					exit();
					break;
				}

				$content = json_encode($data);
				file_put_contents($file, $content);
				//解锁文件
		        flock($fo, LOCK_UN);
		    	fclose($fo);
			}
		}

		$title = dhtmlspecialchars(trim($aboutTitle));
		if(!$title) message($L['msg_type_title']);
		$content = dhtmlspecialchars(trim($_POST['content']));
		if(!$content) message($L['msg_type_content']);
		$truename = dhtmlspecialchars(trim($_POST['truename']));
		if(!$truename) message($L['msg_type_truename']);
		$telephone = dhtmlspecialchars(trim($_POST['phone']));
		if(!$telephone) message($L['msg_type_telephone']);
		$company = dhtmlspecialchars(trim($_POST['company']));
		$qq = dhtmlspecialchars(trim($_POST['qq']));
		$content = nl2br($content);
		if (!$_POST['province']) {
			if (!$_POST['city']) {
				$address = $_POST['province'] .'/'. $_POST['city'];
			}else{
				$address = $_POST['province'];
			}
		}
		$address = $_POST['province'] .'/'. $_POST['city'];
		if($title) $title = $truename.' 咨询：“ '.$aboutTitle.' ” — '.$type;
		if($type) $content = $type.'<br/>'.$content;
		if($company) $content .= '<br/><br/><br/>公 司：'.$L['content_company'].$company;
		if($truename) $content .= '<br/>联系人：'.$L['content_truename'].$truename;
		if($telephone) $content .= '<br/>电 话：'.$L['content_telephone'].$telephone;
		if(is_numeric($qq)) $content .= '<br/>QQ/Email:'.$L['content_qq'].' '.im_qq($qq).' '.$qq;
		if($address) $content .= '<br/>地 区：'.$address;
		
		if ($_userid !== 0) {
			$fromuser = $_username;
		}else{
			$fromuser = '';
		}		
		//send sms
		if(send_message($touser, $title, $content, $typeid, $fromuser,$fromurl='')){
			dalert("登记成功", 'goback');
			exit();
		};
	} else {
		dhttp(403);
	}


