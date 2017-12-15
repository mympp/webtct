<?php
namespace models\module;

use models\helpers\data\category;
use models\helpers\query\MallQuery;

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
    private function buildShowLinkurl($malls){
        $result = [];
        foreach($malls as $key => $mall){
            if(isset($mall['linkurl'])){
                $mall['linkurl'] = $this->linkurl . $mall['linkurl'];
            }elseif(isset($mall['itemid'])){
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
    public function showLinkurl($itemid){
        return 'show-'.$itemid.'.html';
    }

    //产品分类伪静态地址重写
    public function mallCateRewrite($selector){
        if(count($selector) == 1 && !empty($selector['catid'])){
            $categoryModel = new category();
            $cateData = $categoryModel->getCate($selector['catid']);
            return $cateData['catdir'].'/';
        }else{
            return $this->searchRewrite($selector);
        }
    }

    //热门产品
    public function getHotMalls($pagesize = 10 , $catid = 0 ,  $dayLimit = 14){
        $malls = (new MallQuery())->getRecommendMalls($pagesize,$catid,$dayLimit,'itemid,title,thumb,hits,linkurl');
        return $this->buildShowLinkurl($malls);
    }

    //根据id获取内容
    public function getListsById(array $itemid , $field = '*'){
        $malls = (new MallQuery())->getListsById($itemid,$field);
        return $this->buildShowLinkurl($malls);
    }
}

?>