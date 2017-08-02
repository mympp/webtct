<?php 
defined('IN_DESTOON') or exit('Access Denied');
login();
isset($MODULE[16]) or dheader($MODULE[2]['linkurl']);
require DT_ROOT.'/module/'.$module.'/common.inc.php';
require DT_ROOT.'/include/post.func.php';
require DT_ROOT.'/include/csv.class.php';
$_status = $L['trade_status'];
$dstatus = $L['trade_dstatus'];
$step = isset($step) ? trim($step) : '';
$timenow = timetodate($DT_TIME, 3);
$memberurl = $MOD['linkurl'];
$myurl = userurl($_username);
$table = $DT_PRE.'mall_order';
$STARS = $L['star_type'];
if($type=='trade'){                       //导出订单
	$csv=new csv();
	//$member='gztc';                     //测试账号
	$totime=$output_totime!=''?strtotime($output_totime):time();
	$sql_field='itemid,buyer,title,price,number,amount,addtime';     //基本搜索内容
	$title="单号,买家,产品名,单价,数目,总价,下单日期";         //基本输出内容
	if($field){          //指定搜索内容
		if(in_array('order',$field)){        //订单详细
			$sql_field.=',mallid,fee,fee_name';
			$title.=",商品链接,附加收费,附加收费项";
		}
		if(in_array('buyer',$field)){
			$sql_field.=',buyer_name,buyer_address,buyer_postcode,buyer_phone,buyer_mobile';
			$title.=",买家真实姓名,买家地址,买家邮编,买家电话,买家手机";
		}
		if(in_array('send',$field)){
			$sql_field.=',buyer_receive,send_type,send_no,send_time';
			$title.=",期望物流,发送物流,物流单号,发送时间";
		}
		if(in_array('trade',$field)){
			$sql_field.=',trade_no,payment,invoice,invoiceid';
			$title.=",支付宝交易编号,支付凭证,是否开据发票,发票抬头";
		}
	}
	
	$sql_str="select $sql_field from $table where seller='$member' and updatetime<=$totime";

	if($output_fromtime){    
		$fromtime=strtotime($output_fromtime);
		$sql_str.=" and updatetime>=$fromtime";           //时间段
	}
	if($friend_type){             //选择买家类型
		$friend_result=$db->query("select username from friend where typeid='$type'"); //该类型商家
		if($firend_result){
			$friend_arr=array();          //商家用户名
		while($v=mysql_fetch_array($friend_result)){            
			array_push($friend_str,$v['username']);
		}
		$friend_str=implode(',',$friend_arr);
		$sql_str.=" and username in ( $friend_str)";             //搜索类型
		}
	}
	
	if($_childusername!=''){               //子账号存在,判断子账号的地区权限
		$partid=$db->get_one("select partid from {$db->pre}member_child where username='$_childusername'");      //子账号地区权限
		if($partid['partid']!='0'){          //非全国地区，判断所在区域
			$part_childid=$db->get_one("select arrchildid from {$db->pre}area_partition where partid=".$partid['partid']);  //区域的所有城市id
			$part_arr=explode(',',$part_childid['arrchildid']);        //区域地区id数组
			$buyer_areaid_data=$db->query("select {$db->pre}member.username,{$db->pre}member.areaid from {$db->pre}member join {$db->pre}mall_order on {$db->pre}member.username={$db->pre}mall_order.buyer where {$db->pre}mall_order.seller='$_username'");
			$buyer_areaid=array();           //所有买家的用户名和对应地区id
			while($data=$db->fetch_array($buyer_areaid_data)){
				array_push($buyer_areaid,$data);
			}
			$buyer_arr=array();   //地区买家数组

			foreach($buyer_areaid as $v){
				if(in_array($v['areaid'],$part_arr)){
					array_push($buyer_arr,"'".$v['username']."'");
				}
			}
			if(count($buyer_arr)==0){
				$sql_str.=" and buyer=''";                  //没有该区域的买家，不搜索出订单
			}else{
				$sql_str.=' and buyer in ('.implode(',',$buyer_arr).')';         //搜索该地区的买家
			}
		}
	}
	//var_dump($sql_str);
	$result=$db->query($sql_str);                 //查询数据
	                                //表标题
	$filename=$filename==''?'trade':$filename;
	$sqlresult=array();
	while($v=mysql_fetch_array($result)){              //处理搜索数据
		$middle_arr=array();
			$sstr='';
			$i=0;
			foreach($v as $key=>$value){
				if(($i++)%2!=0){            //只取用带字段名下标的数组数据
					switch($key){
						case 'mallid':$middle_arr[$key]=$CFG['url'].'chanpin/show.php?itemid='.$value; break;
						case 'itemid':$middle_arr[$key]='T'.$value;break;
						case 'invoice':$value=='1'?$middle_arr[$key]='是':$middle_arr[$key]='否';break;
						case 'invoiceid':$invoice_title=$db->get_one("select title as t from {$db->pre}invoice where itemid =".$value);$middle_arr[$key]=$invoice_title['t'];break;
						case 'addtime':$middle_arr[$key]=date('Y-m-d',$value);break;
						default:$middle_arr[$key]=$value;
					}
				}
			}
			array_push($sqlresult,$middle_arr);
	}
	//var_dump($sqlresult);
	$csv->output_csv(explode(',',$title),$sqlresult,$filename);
}
?>