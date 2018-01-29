<?php
namespace models\helpers\query;

class CompanySettingQuery extends BaseQuery
{
    const TABLE_NAME = 'company_setting';

    /**
     * 获取用户设置的banner图片地址
     * @param $userid
     * @return array
     */
    public function getCompanyBanner($userid){
        //用户bannner图片地址保存在company_setting 表中 item_key 为 banner+数字 的数据中
        $bannerCondition = ['banner','banner1','banner2','banner3','banner4','banner5'];
        $result = $this->getDb(self::TABLE_NAME)
            ->field('item_value')
            ->where(['userid' => $userid])
            ->inWhere('item_key',$bannerCondition)
            ->all();
        if($result){
            $back = [];
            foreach($result as $key => $value){
                $back[] = $value['item_value'];
            }
            return $back;
        }else{
            return [];
        }
    }

    /**
     * 获取用户设置的公告内容
     * @param $userid
     * @return string
     */
    public function getCompanyAnnounce($userid){
        $result = $this->getDb(self::TABLE_NAME)
            ->field('item_value')
            ->where(['userid' => $userid , 'item_key' => 'announce'])->one();
        if($result){
            return $result['item_value'];
        }else{
            return '';
        }
    }

    public function getLogo($userid){
        $result = $this->getDb(self::TABLE_NAME)
            ->field('item_value')
            ->where(['userid' => $userid , 'item_key' => 'logo'])->one();
        if($result){
            return $result['item_value'];
        }else{
            return '';
        }
    }
}
?>