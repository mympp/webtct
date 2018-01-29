<?php
namespace models\helpers\query;

class CompanyDataQuery extends BaseQuery
{
    const TABLE_NAME = 'company_data';

    public function getContent($userid){
        $result = $this->getDb(self::TABLE_NAME)
            ->field('content')
            ->where(['userid' => $userid])
            ->one();
        if($result){
            return $result['content'];
        }else{
            return '';
        }
    }
}

?>