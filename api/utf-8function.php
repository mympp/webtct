<?php
defined('IN_DESTOON') or exit('Access Denied');
/**
 * 以下内容请勿修改
 */
$class = DT_ROOT . '/module/' . $module . '/' . $module . '.class.php';
Write_Error("开始处理数据,入库模型ID{$moduleid}");
if($MODULE[$moduleid]){
	$CATEGORY = cache_read('category-'.($moduleid == 2 ? 4 : $moduleid).'.php');
     if($action == 'cat'){ // 获取栏目ID
		echo '<select name="catid">';
		foreach($CATEGORY as $k => $v){
			echo '<option value="' . $v['catid'] . '">' . $v['catname'] . '</option>';
		}
		echo '</select>';
	}else{
		if(@$_POST['auth']!=$auth&&@$_GET['auth']!=$auth&&$verify)exit('没有通过身份验证');
		$post = array();
		get_magic_quotes_gpc() or $_POST = array_map('stripslashes', $_POST);
		if($_POST){
			$post = $_POST;
		}elseif($_GET){
			$post = $_GET;
		}else{
			exit('未接收到数据');
		}
		//数据格式化开始
		if($moduleid=='5'){
			$post['thumb']=r68e49e61f3158ab306e54312a04fa8cd($post['thumb'],'thumb');
		}else{
			$post['thumb']=r68e49e61f3158ab306e54312a04fa8cd($post['thumb']);
		}
		
		if($moduleid=='4'){
			$post['ismember']='0';
		}
		
		
		if($moduleid=='6'){
			$post['tag']=$post['producttag'];
			$post['username']='';
		}
		if($moduleid=='7'){
			$post['tag']=$post['producttag'];
		}
		if($moduleid=='17'){
			$post['minamount']=$post['groupminamount'];
			$post['amount']=$post['groupamount'];
			$post['areaid']='';;
		}
		$post['addtime']=str_replace('年','-',str_replace('月','-',str_replace('日',' ',$post['addtime'])));
		if(!is_numeric($post['typeid'])||$post['typeid']>5)$post['typeid']="0";
		if(!empty($post['areaid'])) $post['areaid']=getareaid($post['areaid']);
		if($post['gender']=='先生') $post['gender']='1';
		if($post['gender']=='女士') $post['gender']='2';
		
		if(empty($post['email'])) $post['email'] = $post['username'].'@'.$emaildomain;
		if(isset($post['username'])) $post['username']=$prefix.trim($post['username']).$suffix;
		if(isset($post['username'])) $_username = $post['username'];
		 
		if(in_array($module, array('article', 'info', 'sell'))){
			$table = $DT_PRE . $module . '_' . $moduleid;
			$table_data = $DT_PRE . $module . '_data_' . $moduleid;
			$table_search = $DT_PRE . $module . '_search_' . $moduleid;
		}else{
			$table = $DT_PRE . $module;
			$table_data = $DT_PRE . $module . '_data';
		}

  
		if($moduleid==4||$moduleid==2){
			if(db0803fe14dd93ad5f91ac38b25d1895c($post)){
				exit('发布成功');
			}else{
				exit('注册会员失败');
			}
		}elseif(is_file($class)){

			
				include_once DT_ROOT . '/include/post.func.php';
				$cominc =DT_ROOT . '/module/' . $module . '/common.inc.php';
				if(is_file($cominc)) include_once $cominc;
				include_once $class;
				$do = new $module($moduleid);
				@$do -> table_search = $table_search;
				if(isset($post['islink'])) unset($post['islink']);
				if($spider_status) $post['status'] = $spider_status;
				if($module == 'article') $post['save_remotepic'] = $MOD['save_remotepic'];
		    
				if($do -> pass($post)){
							if($moduleid==5){
								Write_Error('开始匹配会员:'.$post['username']);
								db0803fe14dd93ad5f91ac38b25d1895c($post);
							}
					Write_Error("数据通过验证");
					if($id=$do -> add($post)){
							Write_Error('发布成功,ID:'.$id);
							if($moduleid=='5'){
								Write_Error('开始匹配会员:'.$post['username']);
								db0803fe14dd93ad5f91ac38b25d1895c($post);
							}elseif($moduleid=='10'){
								Write_Error('开始发布回答');
								$table_answer = $DT_PRE.'know_answer';
								$addtime1=strtotime($post['addtime1']);
								$addtime2=strtotime($post['addtime2']);
								
								$nowtime = time();
								$answer_time1 = rand($nowtime-96*3600,$nowtime-24*3600);
								$answer_time2 = rand($nowtime-96*3600,$nowtime-24*3600);
								$addtime1 = $answer_time1;
								$addtime2 = $answer_time2;
								
								
								if(!$db->query("INSERT INTO {$table_answer} (qid,linkurl,content,username,expert,addtime,ip,status,hidden) VALUES ('$id','','$post[content1]','$post[username1]','0','$addtime1','$DT_IP','3','$post[hidden1]')")){
									Write_Error($db->error());
								}
								if(!$db->query("INSERT INTO {$table_answer} (qid,linkurl,content,username,expert,addtime,ip,status,hidden) VALUES ('$id','','$post[content2]','$post[username2]','0','$addtime2','$DT_IP','3','0')")){
									Write_Error($db->error());
								}
								
								$rand_updatetime = rand($nowtime-24*3600,$nowtime);
								$rand_addtime = rand($nowtime-240*3600,$nowtime-96*3600);
								$rand_edittime = rand($rand_addtime,$nowtime-96*3600);
								
								$aid=$db->insert_id();
								if(!$db->query("UPDATE {$table} SET process='3',updatetime='$rand_updatetime',addtime='$rand_addtime',edittime='$rand_edittime',aid='$aid',editor='$post[username1]',status=3 WHERE itemid='$id'")){
									Write_Error($db->error());
								}
								
							}
							exit('发布成功');
					}else{
							echo $do -> errmsg;
							Write_Error('发布失败:'.$do -> errmsg);
							exit('发布失败');
						}
				}else{
					Write_Error('发布失败:'.$do -> errmsg);
					exit('数据验证不通过');
				}
		}else{
			Write_Error('发布失败:模型不支持入库');
			exit('模型不支持入库');
		}
	}
}else{
	 Write_Error('发布失败:模型不存在');
     exit('模型不存在');
}

function db0803fe14dd93ad5f91ac38b25d1895c($post){
 
		global $db, $DT_PRE, $DT_TIME,$emaildomain,$randskin;
		$table_member = $DT_PRE.'member';
		$table_company = $DT_PRE.'company';
		$table_company_data = $DT_PRE.'company_data';
		$username=$post['username'];
		$getone=$db->get_one("SELECT userid FROM {$table_company} WHERE username='$username'");
		if(empty($getone)){
		// 判断公司是否存在
		$company = $post ['company']; 
		$username = $db->get_one ( "SELECT username FROM {$table_company} WHERE company='$company'" );
		if ($username) {
			return $post['username'];
		}

		Write_Error('会员不存在，开始注册:'.$post['username']);

		$post['regid']='6';
		$post['groupid'] =  '6';
		$post['password'] = 'cjcj'.rand(123456,999999);
		$post['password'] = md5(md5($post['password']));
		$post['cpassword'] = $post['password'];
		$post['type'] = '企业单位';
		$post['catid']=','.$post['comcatid'].',';
		$post['sound'] = '0';
		$post['edittime'] = '1';
		$post['passport']=$post['username'];
		$post['linkurl'] = userurl($post['username']);
		
		if($post['catid']) {
			$catids = explode(',', substr($post['catid'], 1, -1));
			$cids = '';
			foreach($catids as $catid) {
				$C = get_cat($catid);
				if($C) {
					$catid = $C['parentid'] ? $C['arrparentid'].','.$catid : $catid;
					$cids .= $catid.',';
				}
			}
			$cids = array_unique(explode(',', substr(str_replace(',0,', ',', ','.$cids), 1, -1)));
			$post['catids'] = ','.implode(',', $cids).',';
		}
		

		
		$post['thumb']=r68e49e61f3158ab306e54312a04fa8cd($post['comthumb']);
		Write_Error("公司图片".$post['comthumb'].'本地化'.$post['thumb']);

		if(!isset($post['telephone'])){$post['telephone']='131'.rand('00000000','99999999');}
		if(!isset($post['regunit'])){$post['regunit']='人民币';}
		if($randskin){
			$skintable=$DT_PRE.'style';
			$s=$db->get_one("SELECT skin FROM `$skintable` ORDER BY rand()");
			$post['skin']=$s['skin'];
			$post['template']='homepage';
		}
		
			$mfs = readcache($table_member);
			$cfs = readcache($table_company);
			$sqlk = $sqlv = '';
			foreach($post as $k=>$v) {
				if(!in_array($k, $mfs)) continue;
					$sqlk .= ','.$k; $sqlv .= ",'$v'";
			}
			
			if(!$sqlk){
				Write_Error('无效数据:'.$do -> errmsg);
				exit('无效数据');
			} 
				$sqlk = substr($sqlk, 1);
				$sqlv = substr($sqlv, 1);
				$db->query("INSERT INTO {$table_member} ($sqlk) VALUES ($sqlv)");
				$userid = $db->insert_id();
				$post['userid'] = $userid;
				$sqlk = $sqlv = '';
				if(!isset($post['regyear'])) $post['regyear'] = "200*";
				
				$post['regtime'] = $DT_TIME;
				foreach($post as $k=>$v) {
					if(!in_array($k, $cfs)) continue;
					$sqlk .= ','.$k; $sqlv .= ",'$v'";
				}
				$sqlk = substr($sqlk, 1);
				$sqlv = substr($sqlv, 1);
				$db->query("INSERT INTO {$table_company} ($sqlk) VALUES ($sqlv)");
				$content = $post['introduce'];
				$content_table = content_table(4, $userid, is_file(DT_CACHE.'/4.part'), $table_company_data);
				$db->query("INSERT INTO {$content_table} (userid,content)  VALUES ('$userid', '$content')");
		}else{
				Write_Error('会员:'.$post['username']."存在，直接返回");
		}
		return $post['username'];
}

function readcache($table){
     global $db;
     $cfs = cache_read($table . '.php');
     if(!$cfs){
         $cfs = array();
         $result = $db -> query("SHOW COLUMNS FROM `$table`");
         while($r = $db -> fetch_array($result)){
             $cfs[] = $r['Field'];
             }
         cache_write($table . '.php', $cfs);
         }
     return $cfs;
}

function r68e49e61f3158ab306e54312a04fa8cd($remote,$thumbdo=''){
include_once DT_ROOT.'/include/remote.class.php';
include_once DT_ROOT.'/include/image.class.php';

	$newfile='';
	if(!empty($remote)){
	global $DT,$DT_TIME,$width,$height;
	$uploaddir = 'file/upload/'.timetodate($DT_TIME, $DT['uploaddir']).'/';
	$doremote = new remote($remote, $uploaddir);
	if($doremote->save()){
		$saveto = $doremote->saveto;
		$image = new image(DT_ROOT.'/'.$saveto);
		if($DT['water_type'] == 2) {
			$image->waterimage();
		} else if($DT['water_type'] == 1) {
			$image->watertext();
		}
		$info = getimagesize(DT_ROOT.'/'.$doremote->saveto);
		$img_w = $info[0];
		$img_h = $info[1];
		if($img_w > $DT['max_image']) {
			$img_h = intval($DT['max_image']*$img_h/$img_w);
			$img_w = $DT['max_image'];
			$image->thumb($img_w, $img_h);
		}
		if($thumbdo=='thumb'){
			if(!isset($width))$width='80';
			if(!isset($height))$height='80';

			$thumb = $saveto.'.thumb.'.$doremote->ext;
			file_copy(DT_ROOT.'/'.$saveto, DT_ROOT.'/'.$thumb);
			$image = new image(DT_ROOT.'/'.$thumb);
			$image->thumb($width, $height, $DT['thumb_album']);


			$middle = $saveto.'.middle.'.$doremote->ext;
			file_copy(DT_ROOT.'/'.$saveto, DT_ROOT.'/'.$middle);
			$image = new image(DT_ROOT.'/'.$middle);
			$image->thumb($DT['middle_w'], $DT['middle_h'], $DT['thumb_album']);
			$newfile= DT_PATH.$thumb;
		}else{
			$newfile= DT_PATH.$saveto;
		}
		Write_Error("远程图片".$remote."本地化成功". DT_PATH.$saveto);
		unset($doremote);
		unset($image);
		return $newfile;
		
	}else{
		Write_Error("远程图片本地化失败");
		return $remote;
	}
	}else{
		return '';
	}
}

function getareaid($areaname){
	if($areaname!=''&&$areaname!='[db:地区]'){
		$area = cache_read('area.php');
		$areaid='0';
		foreach($area as $value){
			if(array_search($areaname,$value)){
				$areaid= $value['areaid'];
				break;
			}
		}
		Write_Error($areaname.'匹配areaid：'.$areaid);
		return $areaid;
	}else{
		return '0';
	}
}

function Write_Error($msg)
{
	global $logfile,$debug;
	if($debug){
		$msg=str_replace("\n","",$msg);
	    $Err=$msg.Chr(10);
	    @Error_log($Err,3,DT_ROOT.'/'.$logfile);
    }
}
@ob_flush();
@flush;
?>