<?php
namespace models\helpers\query;

class MallArticleCategoryQuery extends BaseQuery
{
    const TABLE_NAME = 'mall_article_category';

    public function getCategory($parentid = 0 , $pagesize = 0){
        $categoryDb =  $this->getDb(self::TABLE_NAME);
        $categoryDb->where(['parentid' => $parentid]);
        if(!empty($pageszie)){
            $categoryDb->limit(0, $pagesize);
        }
        return $categoryDb->select();
    }

    public function getTopCategory($pagesize = 0){
        $categoryDb = $this->getDb(self::TABLE_NAME);
        $categoryDb->where(['parentid' => 0] ,'<>');
        if(!empty($pagesize)){
            $categoryDb->limit(0,$pagesize);
            return $categoryDb->order('level desc,catid desc')->select();
        }else{
            return $categoryDb->order('level desc,catid desc')->all();
        }
    }

    public function getChildCategory($parentid = 0){
        return $this->getDb(self::TABLE_NAME)->where(['parentid' => $parentid])->all();
    }

    public function getOne($catid){
        return $this->getDb(self::TABLE_NAME)->where(['catid' => $catid])->one();
    }
}
?>