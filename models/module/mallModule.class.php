<?php
namespace models\module;

use models\helpers\adt\cartesianProduct;
use models\helpers\data\category;
use models\helpers\query\AreaQuery;
use models\helpers\query\CategoryQuery;
use models\helpers\query\MallQuery;
use models\helpers\query\MemberQuery;
use models\helpers\widget\sitemap\siteMap;

//企业模块模型类，封装业务逻辑操作
class mallModule extends baseModule
{

    function __construct()
    {
        global $MODULE;
        $this->moduleid = 16;
        $this->modulename = $MODULE[$this->moduleid]['name'];
        $this->linkurl = $MODULE[$this->moduleid]['linkurl'];
    }

    //搭建数据的点击地址
    private function buildShowLinkurl($malls)
    {
        $result = [];
        foreach ($malls as $key => $mall) {
            if (isset($mall['linkurl'])) {
                $mall['linkurl'] = $this->linkurl . $mall['linkurl'];
            } elseif (isset($mall['itemid'])) {
                $mall['linkurl'] = $this->linkurl . $this->showLinkurl($mall['itemid']);
            }
            $result[] = $mall;
        }
        return $result;
    }

    //产品模块伪静态地址重写
    public function searchRewrite($selector)
    {
        //存在以下参数的地址使用动态地址
        if (isset($selector['kw'])) {
            return 'search.php?' . http_build_query($selector);
        } else {
            //伪静态地址处理 so-catid-stype-areaid-validated-page.html
            $catid = isset($selector['catid']) ? '-' . $selector['catid'] : '-0';
            $stype = isset($selector['stype']) ? '-' . $selector['stype'] : '-0';
            $areaid = isset($selector['areaid']) ? '-' . $selector['areaid'] : '-0';
            $validated = isset($selector['validated']) ? '-' . $selector['validated'] : '-0';
            $page = isset($selector['page']) ? '-' . $selector['page'] : '';
            return 'so' . $catid . $stype . $areaid . $validated . $page . '.html';
        }
    }

    //产品内容页为静态地址重写
    public function showLinkurl($itemid)
    {
        return 'show-' . $itemid . '.html';
    }

    //产品分类伪静态地址重写
    public function mallCateRewrite($selector)
    {
        if (count($selector) == 1 && !empty($selector['catid'])) {
            $categoryModel = new category();
            $cateData = $categoryModel->getCate($selector['catid']);
            return $cateData['catdir'] . '/';
        } else {
            return $this->searchRewrite($selector);
        }
    }

    //热门产品
    public function getHotMalls($pagesize = 10, $catid = 0, $dayLimit = 14)
    {
        $malls = (new MallQuery())->getRecommendMalls($pagesize, $catid, $dayLimit, 'itemid,title,thumb,hits,linkurl');
        return $this->buildShowLinkurl($malls);
    }

    //根据id获取内容
    public function getListsById(array $itemid, $field = '*')
    {
        $malls = (new MallQuery())->getListsById($itemid, $field);
        return $this->buildShowLinkurl($malls);
    }

    //随机获取vip用户的产品信息
    public function getVipMalls($pagesize = 10)
    {
        $vipMember = (new MemberQuery())->getVipMember('username');
        $usernameCondition = [];
        foreach ($vipMember as $member) {
            $usernameCondition[] = $member['username'];
        }
        $mallQuery = new MallQuery();
        $mallDb = $mallQuery->getDb(MallQuery::TABLE_NAME);
        $vipMallCount = $mallDb->where(['username' => "'" . implode("','", $usernameCondition) . "'"], 'in')
            ->where(['status' => MallQuery::CHECKED_STATUS])->count('c');
        if (!$vipMallCount) {
            return [];
        }
        $start = 0;
        $limit = (int)($vipMallCount['c']) - (int)$pagesize;
        if ($limit > 0) {
            $start = rand(0, $limit);
        }
        $mallDb->restart();
        $vipMalls = $mallDb->where(['username' => "'" . implode("','", $usernameCondition) . "'"], 'in')
            ->field('title,itemid,thumb')
            ->where(['status' => MallQuery::CHECKED_STATUS])
            ->limit($start, $pagesize)
            ->order('itemid asc')
            ->select();
        return $this->buildShowLinkurl($vipMalls);
    }


    public function buildSiteMap()
    {
        $size = siteMap::MAX_URL_NUM;
        $query = new MallQuery();
        $siteMap = new siteMap();
        $count = $query->getCount(['status' => MallQuery::CHECKED_STATUS], 'itemid');
        for ($i = 0; ($i * $size) < $count['itemid']; $i++) {  //生成产品知识库详情sitemap
            $params = [
                'status' => MallQuery::CHECKED_STATUS,
                'page' => ($i + 1),
                'pageSize' => $size,
                'field' => 'itemid'
            ];
            $res = $query->mallRes($params);
            $url = [];
            if (!empty($res)) {
                foreach ($res as $id) {
                    $url[] = $this->linkurl . $this->showLinkurl($id['itemid']);
                }
//                $siteMap->buildSiteMap($url,'mall','item',$i+1,'Daily');  //生成每天的
            }
        }
        //时间过长
//        echo 1;exit;
    }

    public function buildCateSiteMap($refresh= 0)
    {
        echo '<pre>';
        $property = [0, 1, 2, 3];  //这是属性
        $cateQuery = new CategoryQuery();
        $cateRes = $cateQuery->getMouleCate($this->moduleid);  //所有商品分类
        $siteMap = new siteMap();
        $catIds = [0];  //全部筛选则为零
        foreach ($cateRes as $cat) {
            $catIds[] = $cat['catid'];
        }
        unset($cateRes);
        $areaRes = (new AreaQuery)->getAllArea();
        $areaIds = [0];  //全部则为零
        foreach ($areaRes as $area) {
            $areaIds[] = $area['areaid'];
        }
        unset($areaRes);
        $cartesian = new cartesianProduct();
        $count = count($catIds);
        $num = 30;
        for ($i = 0; $i < $count; $i = $i + $num) {
            $catValue = array_slice($catIds, $i, $num);
            $buildRes = $cartesian->build([$catValue, $property, $areaIds, [0, 1]]);
            foreach ($buildRes as $build) {
                $url[] = $this->linkurl . 'so-' . implode('-', $build) . '.html';
            }
            $siteMap->buildSiteMap($url, 'mall', 'cate', 1, 'Daily');  //生成分类sitemap
        }

    }

}

?>