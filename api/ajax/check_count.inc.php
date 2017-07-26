<?php
defined('IN_DESTOON') or exit('Access Denied');

require DT_ROOT.'/include/tcdb.class.php';
$data = [];
global $db;

//待处理客服中心
$data['ask'] = $db->count($DT_PRE.'ask', "status=0", 360);	

//待处理订单
$setting_db = new tcdb('setting');
$check_limit = $setting_db->where(['item_key'=>'order_wait_check'])->all();
$finish_limit = $setting_db->where(['item_key'=>'order_wait_finish'])->all();
$mall_order_db = new tcdb('mall_order');
$condition['mid'] = 16;
$condition['status'] = 0;
$condition['kefu_status'] = 0;
$nowtime = time();
$check_condition["( $nowtime - addtime)"] =  $check_limit['item_value'] * 3600;
$count = $mall_order_db->field('count(*) as c')->where($condition)->where($check_condition,'>')->one();
$data['order_over_check'] = $count['c'];		//逾期确认订单
$check_condition["( $nowtime - addtime)"] = $check_limit['item_value'] * 3600;
$count = $mall_order_db->field('count(*) as c')->where($condition)->where($check_condition,'>')->one();
$data['order_over_finish'] = $count['c'];		//逾期完成订单
//$count = $mall_order_db->where(['status'=>0])->count('c');
//$data['order_over_finish'] = $count['c'];

//待回复网站留言
$data['guestbook'] = $db->count($DT_PRE.'guestbook', "edittime=0", 360);

//待审核友情链接
$data['link'] = $db->count($DT_PRE.'link', "status=2 AND username=''", 360);

//待审核公司新闻
$data['news'] = $db->count($DT_PRE.'news', "status=2", 360);

//待审核公司链接
$data['comlink'] = $num = $db->count($DT_PRE.'link', "status=2 AND username<>''", 360);

//待审核会员资料修改
$data['edit_check'] = $num = $db->count($DT_PRE.'member_check', "status=1");

//待审核广告购买
$data['ad'] = $db->count($DT_PRE.'ad', "status=2", 360);

//待审核搜索推广
$data['spread'] = $db->count($DT_PRE.'spread', "status=2", 360);

//待审核注册会员
$data['member_check'] = $db->count($DT_PRE.'member', "groupid=4", 360);

//待审核产品信息
$data['mall'] = $db->count($DT_PRE.'mall','status=2',360);

//待审核服务需求信息
$data['job'] = $db->count($DT_PRE.'sell','status=2',360);

//待审核供应行情
$data['sell'] = $db->count($DT_PRE.'sell_5','status=2',360);

//待审核招标采购
$data['buy'] = $db->count($DT_PRE.'buy_6','status=2',360);

//待审核品牌信息
$data['brand'] = $db->count($DT_PRE.'brand_13','status=2',360);

//待审核咨询信息
$data['article'] = $db->count($DT_PRE.'article_21','status=2',360);

//待审核科技信息
$data['quote'] = $db->count($DT_PRE.'quote','status=2',360);

//待审核问答信息
$data['know'] = $db->count($DT_PRE.'know','status=2',360);

//待审核资料共享
$data['down'] = $db->count($DT_PRE.'down','status=2',360);

//待审核评论
$data['comment'] = $db->count($DT_PRE.'comment','status=2',360);

//待审核会员验证
$data['member_validated'] = $db->count($DT_PRE.'member_check','',360);

//待审核会员升级
$data['member_upgrade'] = $db->count($DT_PRE.'upgreade','status=2',360);

$callbackparam = isset($callbackparam) ? $callbackparam : 'callback';

echo $callbackparam.'('.json_encode($data,JSON_UNESCAPED_UNICODE).')';

?>