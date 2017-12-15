<?php
namespace models\helpers\query;

class MallTagsQuery extends BaseQuery
{
    const TABLE_NAME = 'mall_tags';

    public function getMallIdsByTag($tagid){
        $malls = $this->getDb(self::TABLE_NAME)
            ->field(['mallid'])
            ->where(['tagsid' => $tagid])->all();
        $result = [];
        foreach($malls as $mall){
            $result[] = $mall['mallid'];
        }
        return $result;
    }
}
?>