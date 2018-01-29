<?php
namespace models\helpers\query;

class AreaQuery extends BaseQuery
{
    const TABLE_NAME = 'area';

    /**
     * 获取地区名称
     * @param $areaid
     * @return string
     */
    public function getName($areaid){
        $area = $this->getDb(self::TABLE_NAME)->field('areaname')->where(['areaid' => $areaid])->one();
        if($area){
            return $area['areaname'];
        }else{
            return '';
        }
    }

    /**
     * 获取地区名称包括上级名称
     * @param $areaid
     * @return string
     */
    public function getNameWithParent($areaid){
        $area = $this->getDb(self::TABLE_NAME)->field('areaname,parentid')->where(['areaid' => $areaid])->one();
        $result = '';
        if($area){
            $result = $area['areaname'];
        }
        if(!empty($area['parentid'])){
            $parentName = $this->getName($area['parentid']);
            $result = $parentName . '/' .$result;
        }
        return $result;
    }

    /**
     * 获取所有省市地区
     */
    public function getAllArea(){
        return $this->getDb(self::TABLE_NAME)->field('areaid')->all();
    }

}
?>