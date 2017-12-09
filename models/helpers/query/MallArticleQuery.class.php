<?php
namespace models\helpers\query;

class MallArticleQuery extends BaseQuery
{
    const CHECKED_STATUS = 3;

    private function buildListDb($pagesize = 5, $withImage = false ,$field){
        $articleDb = $this->getDb('mall_article');
        $articleDb->where(['status' => self::CHECKED_STATUS]);
        if($withImage){
            $articleDb->where(['thumb' => ''],'<>');
        }
        return $articleDb->field($field)->limit(0,$pagesize);
    }

    //获取推荐文章
    public function getTopArticles($pagesize = 5, $withImage = false , $field = 'itemid,title,thumb')
    {
        return $this->buildListDb($pagesize,$withImage,$field)->order('level desc,itemid desc')->select();
    }

    //获取热点文章
    public function getHotArticles($pagesize = 10,$withImage = false,
                                   $dayLimit = 0 ,$field = 'itemid,title,thumb')
    {
        $dayCondition = [];
        if(!empty($dayLimit) && is_int($dayLimit)){
            $dayCondition['addtime'] = time() - (3600 * 24 * $dayLimit);
        }
        return $this->buildListDb($pagesize,$withImage,$field)
            ->where($dayCondition, '>')->order('hits desc')->select();
    }

    //获取最新文章
    public function getNewArticles($pagesize = 10, $withImage = false,$field = 'itemid,title,thumb'){
        return $this->buildListDb($pagesize,$withImage,$field)->order('itemid desc')->select();
    }
}
?>