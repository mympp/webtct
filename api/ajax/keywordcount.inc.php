<?php
defined('IN_DESTOON') or exit('Access Denied');

if(!isset($action)) exit('-1');
if(!isset($keywords)) exit('-1');
if(!isset($callbackparam)) exit('-1');

require DT_ROOT.'/include/tcdb.class.php';
$data = [];
$mall = new tcdb('mall');
$mall_count = $mall->field('count(*) as c')->where(['status'=>3])->likeWhere(['title'=>$keywords])->one();
$data['mall'] = empty($mall_count['c']) ? 0 : $mall_count['c'];
$company = new tcdb('company');
$company_count = $company->field('count(*) as c')->where('groupid > 5')->likeWhere(['company'=>$keywords])->one();
$data['company'] = empty($company_count['c']) ? 0 : $company_count['c'];
$sell = new tcdb('sell_5');
$gongying = $sell->field('count(*) as c')->where(['status'=>3,'typeid'=>0])->likeWhere(['title'=>$keywords])->one();
$data['gongying'] = empty($gongying['c']) ? 0 : $gongying['c'];
$xuqiu = $sell->field('count(*) as c')->where(['status'=>3,'typeid'=>1])->likeWhere(['title'=>$keywords])->one();
$data['xuqiu'] = empty($xuqiu['c']) ? 0 : $xuqiu['c'];
$brand = new tcdb('brand_13');
$brand_count = $brand->field('count(*) as c')->where(['status'=>3])->likeWhere(['title'=>$keywords])->one();
$data['brand'] = empty($brand_count['c']) ? 0 : $brand_count['c'];

echo $callbackparam.'('.json_encode($data).')';
?>
