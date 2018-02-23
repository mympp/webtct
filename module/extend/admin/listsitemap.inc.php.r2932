<?php
use models\helpers\data\tcdb;
use models\helpers\adt\cartesianProduct;

defined('DT_ADMIN') or exit('Access Denied');
require_once DT_ROOT.'/models/autoload.php';

$category = new tcdb('category');
$area = new tcdb('area');
$areaid = $area->field('areaid')->all();
$cart = new cartesianProduct();
$AREA = [];
foreach($areaid as $k=>$v){
    array_push($AREA,$v['areaid']);
}
array_unshift($AREA,'0');		//所有地区id

switch($m){
    case 'company':
        //企业模块配置信息
        $company = [];
        $mode = [0,1,2,3,4];		//运作模式：不限 生产商 贸易商 服务商 其他机构
        $type = [0,1,2,3];			//运作性质：不限 企业单位 事业单位或社会团体 个体经营
        //$page = [1];				//分页数字为1
        //企业模块列表的地址拼接方式为 catid-areaid-mode-type-page.HTML
        $company[0] = getCategoryId(4);
        $company[1] = $AREA;
        $company[2] = $mode;
        $company[3] = $type;
        //$company[4] = $page;

        buildSoSitemap($cart->build($company),$MODULE[4]['linkurl'],'Company');
        break;
    case 'mall':
        //产品模块配置信息
        //产品分类页

        $CAT = getCategoryId(16);
        //产品模块分类列表的地址拼接方式为 catid-stype-areaid.HTML
        $stype = [0,1,2,3];		//运作形式
        $vip = [0];	//vip只取0值
        $i = 1;
        while(count($CAT) > 50){
            $mCAT = array_slice($CAT,0,50);
            array_splice($CAT,0,50);
            $mall[0] = $mCAT;
            $mall[1] = $stype;
            $mall[2] = $AREA;
            $mall[3] = $vip;

            buildSoSitemap($cart->build($mall),$MODULE[16]['linkurl'],'Mall'.$i);
            $i++;
        }
        $mall[0] = $CAT;
        $mall[1] = $stype;
        $mall[2] = $AREA;

        buildSoSitemap($cart->build($mall),$MODULE[16]['linkurl'],'Mall'.$i);
        break;
    case 'mall_keshi':
        $CAT = getCategoryId(12);
        $stype = [0,1,2,3];
        $vip = [0];	//vip只取0值
        $i = 1;
        while(count($CAT) > 50){
            $mCAT = array_slice($CAT,0,50);
            array_splice($CAT,0,50);
            $mall[0] = $mCAT;
            $mall[1] = $stype;
            $mall[2] = $AREA;
            $mall[3] = $vip;

            buildSoSitemap($cart->build($mall),$MODULE[16]['linkurl'],'MallKeshi'.$i,'ks');
            $i++;
        }
        $mall[0] = $CAT;
        $mall[1] = $stype;
        $mall[2] = $AREA;

        buildSoSitemap($cart->build($mall),$MODULE[16]['linkurl'],'MallKeshi'.$i,'ks');
        break;
    case 'sell':
        $CAT = getCategoryId(5);
        $typeid = [0,1,2];		//0供应，1需求，2其他
        $vip = [0];	//vip只取0值
        $sell[0] = $CAT;
        $sell[1] = $typeid;
        $sell[2] = $AREA;
        $sell[3] = $vip;

        buildSoSitemap($cart->build($sell),$MODULE[5]['linkurl'],'Sell');
        break;
    case 'mall_keyword':
        //产品关键词
        $keyword_data = new tcdb('keyword_data');
        $keyword_id = $keyword_data->field('itemid')->all();

        $keyword = [];
        $keyword[0] = [];
        foreach($keyword_id as $v){
            array_push($keyword[0],$v['itemid']);
        }

        $keyword[1] = $AREA;

        buildSoSitemap($cart->build($keyword),$MODULE[16]['linkurl'],'keyword','kw');
        break;
    case 'buy':
        $buy[0] = getCategoryId(6);
        $buy[1] = $AREA;

        buildSoSitemap($cart->build($buy),$MODULE[6]['linkurl'],'buy');
        break;
    case 'hot':
        $keyword_db = new tcdb('keyword');
        $itemid = $keyword_db->field('itemid')->where(['status'=>3])->all();
        buildSoSitemap($itemid,DT_PATH.'hot/','Hot','show');
        break;
}

msg('SiteMaps 更新成功', '?moduleid='.$moduleid.'&file=setting#sitemaps');

function getCategoryId($moduleid){
    global $category;

    $catid = $category->field('catid')->where(['moduleid'=>$moduleid])->all();
    $CAT = [];
    foreach($catid as $k=>$v){
        array_push($CAT,$v['catid']);
    }
    array_unshift($CAT,'0');
    return $CAT;
}

/**
 * sitemap文件生成
 * @param array $arr,参数组合
 * @param string $url,地址前缀
 * @return bool
 */
function buildSoSitemap($arr,$url,$modulename,$linkname = 'so'){
    $start = '<?xml version="1.0" encoding="UTF-8"?>';
    $start .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    $end = "</urlset>";
    $data = '';
    $p = 0;
    $data = $start;
    $today = date('Y-m-d',time());
    foreach($arr as $k => $v){
        if(($k != 0) && ($k % 9999 == 0)){
            $data .= $end;
            $data = convert($data, DT_CHARSET, 'UTF-8');
            $page = empty($p) ? '' : $p;
            @file_put(DT_ROOT.'/sitemap/list/sitemap'.$modulename.'List'.$page.'.xml',$data);
            $p++;
            $data = $start;
        }
        $sourl = implode('-',$v);
        $data .= '<url>';
        $data .= "<loc>$url"."$linkname-$sourl.html</loc>";
        $data .= '<lastmod>'.$today.'</lastmod>';
        $data .= '<changefreq>Daily</changefreq>';
        $data .= '<priority>0.8</priority>';
        $data .= '</url>';
    }
    if(strlen($data) != 0){
        $data .= $end;
        $data = convert($data, DT_CHARSET, 'UTF-8');
        $page = empty($p) ? '' : $p;
        file_put(DT_ROOT.'/sitemap/list/sitemap'.$modulename.'List'.$page.'.xml',$data);
    }
}


?>