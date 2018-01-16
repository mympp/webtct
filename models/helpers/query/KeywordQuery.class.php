<?php
namespace models\helpers\query;

//关键词相关处理类
class KeywordQuery extends BaseQuery
{
    const DATA_TABLE_NAME = 'keyword_data';
    const TABLE_NAME = 'keyword';
    const CHECKED_STTAUS = 3;

    //获取关键词解析
    public function getWordAnalysis($itemid)
    {
        if(empty($itemid)) return '';
        $condition = ['itemid'=>$itemid];
        $keyword = $this->getDb('keyword')->where($condition)->one();
        if(empty($keyword)) return '';      //没找到指定关键词

        $keywordContent = $this->getDb('keyword_data')->where($condition)->one();
        //tc_keyword_data中已保存词语的解析
        if(!empty($keywordContent['content'])) return $keywordContent['content'];

        return '';

    }

    //推荐关键词
    public function getRecommendWord($pagesize = 10,$itemid = 0 , $withData = true){
        if($withData){
            $tableName = self::DATA_TABLE_NAME;
        }else{
            $tableName = self::TABLE_NAME;
        }

        //指定关键词id，获取id后的关键词
        if(!empty($itemid)){
            return $this->getDb($tableName)->where(['itemid'=>$itemid],'>')->field('itemid,keyword,word')
                ->where(['status' => self::CHECKED_STTAUS])
                ->order('itemid asc')->limit(0,$pagesize)->select();
        }else{      //不指定关键词，从前100多随机提取关键词
            $random = rand(0,90);
            return $this->getDb($tableName)->field('itemid,keyword,word')
                ->where(['status' => self::CHECKED_STTAUS])
                ->order('itemid desc')->limit($random,$pagesize)->select();
        }
    }

    /**
     * 获取最新关键词
     * @param int $pagesize
     * @return mixed
     */
    public function getNewWord($pagesize = 10){
        return $this->getDb(self::TABLE_NAME)->field('itemid,keyword,word')
            ->where(['status' => self::CHECKED_STTAUS])
            ->order('itemid desc')->limit(0,$pagesize)->select();
    }


    /**
     * 获取列表内容
     * @param array $condition
     * @param $page
     * @param $pagesize
     * @param $field
     * @return mixed
     */
    public function getList(array $condition , $page ,$pagesize ,$field){
        $start = ($page - 1)*$pagesize;
        $lists = $this->getDb(self::TABLE_NAME)
            ->field($field)->where($condition)->order('itemid desc')->limit($start , $pagesize)->select();
        $count = $this->getDb(self::TABLE_NAME)->where($condition)->count('c');
        $result['lists'] = $lists;
        $result['count'] = $count['c'];
        return $result;
    }
}

?>