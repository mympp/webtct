<?php
namespace models\helpers\query;

class MallArticleCategoryQuery extends BaseQuery
{
    public function getCategory($parentid = 0 , $pagesize = 0){
        $categoryDb =  $this->getDb('mall_article_category');
        $categoryDb->where(['parentid' => $parentid]);
        if(!empty($pageszie)){
            $categoryDb->limit(0, $pagesize);
        }
        return $categoryDb->select();
    }

    public function getTopCategory($pagesize = 0){
        $categoryDb = $this->getDb('mall_article_category');
        $categoryDb->where(['parentid' => 0] ,'<>');
        if(!empty($pagesize)){
            $categoryDb->limit(0,$pagesize);
            return $categoryDb->order('level desc,catid desc')->select();
        }else{
            return $categoryDb->order('level desc,catid desc')->all();
        }
    }
}
?>