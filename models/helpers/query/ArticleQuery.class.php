<?php
namespace models\helpers\query;

class ArticleQuery extends BaseQuery
{
    const TABLE_NAME = 'article_21';
    const CHECKED_STATUS = 3;

    private function buildListDb($pagesize = 5, $withImage = false ,$field , $catid = 0,$page = 1){
        $articleDb = $this->getDb(self::TABLE_NAME);
        $articleDb->where(['status' => self::CHECKED_STATUS]);
        if($withImage){
            $articleDb->where(['thumb' => ''],'<>');
        }
        if(!empty($catid)){
            if(is_array($catid)){
                $articleDb->where(['catid' => implode(',',$catid)],'in');
            }else{
                $articleDb->where(['catid' => $catid]);
            }
        }
        $start = 0;
        if(is_int($page) && $page > 0){
            $start = ($page - 1)*$pagesize;
        }
        return $articleDb->field($field)->limit($start,$pagesize);
    }

    //获取热点文章
    public function getHotArticles($pagesize = 10,$withImage = false,
                                   $dayLimit = 0 ,$field = 'itemid,title,thumb',$catid = 0)
    {
        $dayCondition = [];
        if(!empty($dayLimit) && is_int($dayLimit)){
            $dayCondition['addtime'] = time() - (3600 * 24 * $dayLimit);
        }
        return $this->buildListDb($pagesize,$withImage,$field,$catid)
            ->where($dayCondition, '>')->order('hits desc')->select();
    }
}

?>