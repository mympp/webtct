<?php
namespace models\helpers\query;

//关键词相关处理类
class KeywordQuery extends BaseQuery
{
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
    public function getRecommendWord($pagesize = 10,$itemid = 0){
        //指定关键词id，获取id后的关键词
        if(empty($itemid)){
            return $this->getDb('keyword_data')->where(['itemid'=>$itemid],'>')->field('itemid,word')
                ->order('itemid asc')->limit(0,$pagesize)->select();
        }else{      //不指定关键词，从前100多随机提取关键词
            $random = rand(0,90);
            return $this->getDb('keyword_data')->field('itemid,word')
                ->order('itemid asc')->limit($random,$pagesize)->select();
        }
    }
}

?>