<?php
/*
	[Destoon B2B System] Copyright (c) 2008-2015 www.destoon.com
	This is NOT a freeware, use is subject to license.txt

*V5.0 升级 V6.0补充说明
*keyword表添加‘parent_catid’字段，第90行代码添加了‘parent_catid’
*

who:chentao
what:添加批量导入关键词功能
where:见--2016/2/2/chentao--标签
*/
defined('DT_ADMIN') or exit('Access Denied');
$menus = array (
    array('已启用', '?file='.$file),
    array('待审核', '?file='.$file.'&status=2'),
	array('批量添加','?file='.$file.'&action=upload'),               //--2016/2/2/chentao
);
$MODULE[-7]['moduleid'] = -7;
$MODULE[-7]['name'] = '报价';
$MODULE[-7]['linkurl'] = $MODULE[5]['linkurl'];
$MODULE[-9]['moduleid'] = -9;
$MODULE[-9]['name'] = '简历';
$MODULE[-9]['linkurl'] = $MODULE[9]['linkurl'];
$status = isset($status) ? intval($status) : 3;
$do = new keyword;
$do_link=new keyword_link;//2016-4-15关键词友情链接
switch($action) {
	//增加关键词对应的友情链接 2016-4-15 cjZhou
	case 'link_list':
		$key_id=isset($_GET['key_id'])?$_GET['key_id']:'';
		$condition="keyword_id=$key_id";
		$lists = $do_link->get_list($condition);
		//获取关键词描述
		$content = $db->get_one("select content from {$db->pre}keyword_data where itemid = $key_id");
		$keyword_content = $content['content'];
		include tpl('keyword_link');
	break;
	//结束
	case 'letter':
		if(!$word) exit('');
		if(DT_CHARSET != 'UTF-8') $word = convert($word, 'UTF-8', DT_CHARSET);
		exit(gb2py($word));
	break;
	case 'upload':            //--2016/2/2/chentao--start    //批量处理
		if($submit){
			if(!$moduleid_key){
				msg('未选择添加模块','?file='.$file.'&action=upload');
			}
			if(empty($_FILES['csvfile']['tmp_name'])){
				msg('未上传文件','?file='.$file.'&action=upload');
			}else{
				$lastdot=strrpos($_FILES['csvfile']['name'],".");//找到区分文件名与扩展名的标记符“.”最后出现的位置
				$extended=substr($_FILES['csvfile']['name'],$lastdot+1);//取出扩展名
				if($extended!='csv'){msg('只能上传csv文件','?file='.$file.'&action=upload');}
			}
			require DT_ROOT.'/include/csv.class.php';
			$csv_cla=new csv();
			$csv_data=$csv_cla->input_csv($_FILES['csvfile']['tmp_name']);        //csv内容导出为数组
			$num=count($csv_data);          //统计多维数组元素个数          
			if($num<2){
				msg('csv文件内容为空','?file='.$file.'&action=upload');
			}else if($num>1000){
				msg('csv文件不可超过1000条数据','?file='.$file.'&action=upload');
			}
			$sql_insert_value='';                       //用于存放插入数据数值字符串
			$select_moduleid=$moduleid_key;     		//用户选择的添加模块id
			for($i=1;$i<=$num;$i++){
				$keyword_arr=$csv_data[$i];
				$moduleid_key=$select_moduleid;			//重新设置批对模块id数组
				if($keyword_arr[0]==''){continue;}        //关键词为空，跳过该词条
				$keyword_cla=new keyword();
				$keyword_list=$keyword_cla->get_list("keyword = '".$keyword_arr[0]."'",'itemid');
				if($keyword_list){
					foreach($moduleid_key as $k=>$v ){
						foreach($keyword_list as $kk=>$kv){
							if($kv['moduleid']==$v){
								unset($moduleid_key[$k]);                //如果关键词在数据库中已有该moduleid的数据，则去掉添加数组中的该moduleid
								unset($keyword_list[$kv]);               //去掉该数据结果中的该moduleid的数据，下次循环时不用再比较
							}
						}
					}
				}
				if(count($moduleid_key)==0){
					continue;                 //添加模块id被全部过滤掉，该关键词不需添加，跳出该词
				}
				if($keyword_arr[1]==''){$keyword_arr[1]=$keyword_arr[0];}            //相关词为空，相关词为关键词
				if($keyword_arr[2]==''){
					$word='';
					if(DT_CHARSET != 'UTF-8') {
						$word = convert($keyword_arr[0], 'UTF-8', DT_CHARSET);
					}else{
						$word=$keyword_arr[0];
					}
					$keyword_arr[2]=gb2py($word);                               //拼音不填写即自动生成
				}
				if($keyword_arr[2]==''){
					continue;                          //无法生成该词拼音，跳过该词
				}
				if($keyword_arr[3]=='')$keyword_arr[3]=0;               //总搜搜
				if($keyword_arr[4]=='')$keyword_arr[4]=0;				//月搜搜
				if($keyword_arr[5]=='')$keyword_arr[5]=0;				//周搜索
				if($keyword_arr[6]=='')$keyword_arr[6]=0;				//日搜索
				foreach($moduleid_key as $k=>$v){
					$sql_insert_value.='('.$v.",'".$keyword_arr[0]."','".$keyword_arr[1]."','".$keyword_arr[2]."',".$keyword_arr[3].','.$keyword_arr[4].','.$keyword_arr[5].','.$keyword_arr[6].','.$parent_catid.','.time().',0,3),';
				}
				if($i%30==0){            //每30个关键词整合进行一次数据库插入操作
					$sql_insert_value=substr($sql_insert_value,0,-1);      //去掉最后的逗号
					$sql_insert_str="insert into {$db->pre}keyword (moduleid,keyword,word,letter,total_search,month_search,week_search,today_search,parent_catid,updatetime,items,status) values ".$sql_insert_value;
					$db->query($sql_insert_str);
					$sql_insert_value='';
				}
			}
			//剩余关键词进行最后一次插入数据库 
			if($sql_insert_value==''){              //关键词重复，没有要插入的数据
				dmsg('批量导入关键词完成','?file='.$file);
			}
			$sql_insert_value=substr($sql_insert_value,0,-1);       //去掉最后的逗号
			$sql_insert_str="insert into {$db->pre}keyword (moduleid,keyword,word,letter,total_search,month_search,week_search,today_search,parent_catid,updatetime,items,status) values ".$sql_insert_value;
			$db->query($sql_insert_str);
			dmsg('批量导入关键词完成','?file='.$file);
		}else{
			include tpl('keyword_upload');
		}
	break;                        
	case 'download':
		$file_name=DT_ROOT.'/file/keyword/keyword.csv';
		if(is_file($file_name)){
			ob_end_clean();                                      
			header("Content-Type: application/force-download;");  
			header("Content-Type: text/csv");                    
   			header("Content-Disposition: attachment; filename=".basename($file_name));
   			readfile($file_name);
   			exit;
		}else {
			msg('文件不存在');
		}
	break;                    //--2016/2/2/chentao--end
	case 'mall':			//产品推荐关键词
		$menus = array (
    		array('已启用', '?file='.$file.'&action=mall'),
    		array('查找关键词', '?file='.$file.'&action=mall_search'),              
		);
		if($submit){
			
		}else{
			$lists = $do->get_list("status = 3 and moduleid = 16 and parent_catid in (1,2,3,4,5,6)",'itemid desc');
			include tpl('mall_keyword');
		}
	break;
	case 'mall_search':
		$menus = array (
    		array('已启用', '?file='.$file.'&action=mall'),
    		array('查找关键词', '?file='.$file.'&action=mall_search'),              
		);
		if($kw){
			$lists = $do->get_list("status = 3 and moduleid = 16 and keyword like '%$kw%'",'itemid desc');
		}
		include tpl('mall_keyword');
	break;
	case 'content':
		global $db;
		switch($move){
			case 'add':
				if(!empty($content)){
					require_once DT_ROOT.'/include/tcdb.class.php';
					$keyword_db = new tcdb('keyword');
					$kw = $keyword_db->field('word')->where(['itemid'=>$itemid])->one();
					//添加数据
					$data['word'] = empty($kw) ? '' : $kw['word'];
					$data['itemid'] = $itemid;
					$data['content'] = $content;
					$keyword_data_db = new tcdb('keyword_data');
					$keyword_data_db->add($data);
				}
			break;
			case 'update':
				$db->query("update {$db->pre}keyword_data set content = '$content' where itemid = $itemid");
			break;
		}
		dmsg('更新成功','?file='.$file.'&action=link_list&key_id='.$itemid);
	break;
	default:
		if($submit) {
			switch($move){             //--2016/2/2/chentao--start
				case 'delete':
					foreach($post as $k=>$v){
						if(isset($v['update'])){
							$do->delete($k);                  //删除选择的关键字
						}
					}
				break;
				case 'update':
					$do->update($post);                 //修改关键字的信息	
				break;
				case 'change_status':                 //修改选择的关键词状态
					$edit_arr=array();
					foreach($post as $k=>$v){
						if(isset($v['update'])){
							$v['status']=$update_status_value;
							$edit_arr[$k]=$v;
						}
					}
					$do->edit($edit_arr);
				break;
				case 'change_parent_catid':
					$edit_arr = array();
					$parent_catid = isset($parent_catid)? $parent_catid:0;
					foreach($post as $k => $v){
						if($v['update'] == 1){
							$edit_arr[$k] = $v;
							$edit_arr[$k]['parent_catid'] = $parent_catid;
						}
					}
					$do->edit($edit_arr);
					dmsg('更新成功', '?file='.$file.'&action=mall_search');
				break;
				//2016-4-15 关键词友情链接 cjZhou
				case 'delete_link':
					foreach($post as $k=>$v){
						if(isset($v['update'])){
							$do_link->delete($k);                  //删除选择的关键字
						}
					}
					dmsg('更新成功','?file='.$file.'&action=link_list&key_id='.$post[0]['keyword_id']);
				break;
				case 'update_link':
					//判断网址格式是否正确(是否含http://)
					foreach($post as $k=>$v){
						if(!preg_match("/^[hH][tT][tT][pP]([sS]?):\/\/(\S+\.)+/",$v['link_url'])){
							dmsg('请输入网址','?file='.$file.'&action=link_list&key_id='.$post[0]['keyword_id']);
						}
					}
					$do_link->update($post);//2016-4-15修改友情链接
					dmsg('更新成功','?file='.$file.'&action=link_list&key_id='.$post[0]['keyword_id']);
				break;
				//结束
			}
			//$do->update($post);
			if($update_mall_keyword == '1') dmsg('更新成功', '?file='.$file.'&action=mall');
			dmsg('更新成功', '?file='.$file.'&status='.$status);
			//--2016/2/2/chentao--end
		} else {
			$sfields = array('按条件', '关键词', '相关词', '拼音');
			$dfields = array('word', 'word', 'keyword', 'letter');
			isset($fields) && isset($dfields[$fields]) or $fields = 0;
			$fields_select = dselect($sfields, 'fields', '', $fields);
			$sorder  = array('结果排序方式', '总搜索量降序', '总搜索量升序', '本月搜索降序', '本月搜索升序', '本周搜索降序', '本周搜索升序', '今日搜索降序', '今日搜索升序', '信息数量降序', '信息数量升序', '更新时间降序', '更新时间升序');
			$dorder  = array('itemid DESC', 'total_search DESC', 'total_search ASC', 'month_search DESC', 'month_search ASC', 'week_search DESC', 'week_search ASC', 'today_search DESC', 'today_search ASC', 'items DESC', 'items ASC', 'updatetime DESC', 'updatetime ASC');
			isset($order) && isset($dorder[$order]) or $order = 0;
			$order_select  = dselect($sorder, 'order', '', $order);
			$condition = "status=$status";
			if($keyword) $condition .= " AND $dfields[$fields] LIKE '%$keyword%'";
			if($mid) $condition .= " AND moduleid=$mid";
			$lists = $do->get_list($condition, $dorder[$order]);
			include tpl('keyword');
		}
	break;
}

class keyword {
	var $db;
	var $table;

	function keyword() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'keyword';
		$this->db = &$db;
	}

	function get_list($condition, $order) {
		global $pages, $page, $pagesize, $offset, $pagesize;
		$pages = pages($this->db->count($this->table, $condition), $page, $pagesize);
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition ORDER BY $order LIMIT $offset,$pagesize");
		while($r = $this->db->fetch_array($result)) {
			$lists[] = $r;
		}
		return $lists;
	}

	function update($post) {
		$this->add($post[0]);
		unset($post[0]);
		foreach($post as $k=>$v) {
			if(isset($v['delete'])) {
				$this->delete($k);
				unset($post[$k]);
			}
		}
		$this->edit($post);
	}

	function add($post) {
		global $DT_TIME;
		if(!$post['word']) return false;
		$post['status'] = $post['status'] == 3 ? 3 : 2;
		$this->db->query("INSERT INTO {$this->table} (moduleid,word,keyword,letter,items,total_search,month_search,week_search,today_search,updatetime,status,parent_catid) VALUES('$post[moduleid]','$post[word]','$post[keyword]','$post[letter]','$post[items]','$post[total_search]','$post[month_search]','$post[week_search]','$post[today_search]','$DT_TIME', '$post[status]', '$post[parent_catid]')");
	}

	function edit($post) {
		foreach($post as $k=>$v) {
			if(!$v['word']) continue;
			$v['status'] = $v['status'] == 3 ? 3 : 2;
			$v['parent_catid'] = isset($v['parent_catid'])? $v['parent_catid'] : 0;
			$this->db->query("UPDATE {$this->table} SET word='$v[word]',keyword='$v[keyword]',letter='$v[letter]',total_search='$v[total_search]',month_search='$v[month_search]',week_search='$v[week_search]',today_search='$v[today_search]',status='$v[status]',parent_catid=$v[parent_catid] WHERE itemid='$k'");
		}
	}

	function delete($itemid) {
		$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
	}
}
	//2016-4-15 友情链接类 cjZhou
	class keyword_link {
	var $db;
	var $table;

	function keyword_link() {
		global $db, $DT_PRE;
		$this->table = $DT_PRE.'keyword_link';
		$this->db = &$db;
	}

	function get_list($condition) {
		global $pages, $page, $pagesize, $offset, $pagesize;
		//$pages = pages($this->db->count($this->table, $condition), $page, $pagesize);
		$lists = array();
		$result = $this->db->query("SELECT * FROM {$this->table} WHERE $condition");
		while($r = $this->db->fetch_array($result)) {
			$lists[] = $r;
		}
		return $lists;
	}

	function update($post) {
		$this->add($post[0]);
		unset($post[0]);
		foreach($post as $k=>$v) {
			if(isset($v['delete'])) {
				$this->delete($k);
				unset($post[$k]);
			}
		}
		$this->edit($post);
	}

	function add($post) {
		if(!$post['link_name']) return false;
		$this->db->query("INSERT INTO {$this->table} (keyword_id,link_name,link_url,contact) VALUES('$post[keyword_id]','$post[link_name]','$post[link_url]','$post[contact]')");
	}

	function edit($post) {
		foreach($post as $k=>$v) {
			if(!$v['link_name']) continue;
			$v['status'] = $v['status'] == 3 ? 3 : 2;
			$this->db->query("UPDATE {$this->table} SET link_name='$v[link_name]',link_url='$v[link_url]',contact='$v[contact]' WHERE itemid='$k'");
		}
	}

	function delete($itemid) {
		$this->db->query("DELETE FROM {$this->table} WHERE itemid=$itemid");
	}
	//结束
}
?>