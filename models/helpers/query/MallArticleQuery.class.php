<?php
namespace models\helpers\query;

class MallArticleQuery extends BaseQuery
{
    const TABLE_NAME = 'mall_article';
    const CHECKED_STATUS = 3;

    private function buildListDb($pagesize = 5, $withImage = false, $field, $catid = 0, $page = 1)
    {
        $articleDb = $this->getDb(self::TABLE_NAME);
        $articleDb->where(['status' => self::CHECKED_STATUS]);
        if ($withImage) {
            $articleDb->where(['thumb' => ''], '<>');
        }
        if (!empty($catid)) {
            if (is_array($catid)) {
                $articleDb->where(['catid' => implode(',', $catid)], 'in');
            } else {
                $articleDb->where(['catid' => $catid]);
            }
        }
        $start = 0;
        if (is_int($page) && $page > 0) {
            $start = ($page - 1) * $pagesize;
        }
        return $articleDb->field($field)->limit($start, $pagesize);
    }

    //获取推荐文章
    public function getTopArticles($pagesize = 5, $withImage = false,
                                   $field = 'itemid,title,thumb', $catid = 0)
    {
        return $this->buildListDb($pagesize, $withImage, $field, $catid)->order('level desc,itemid desc')->select();
    }

    //获取热点文章
    public function getHotArticles($pagesize = 10, $withImage = false,
                                   $dayLimit = 0, $field = 'itemid,title,thumb', $catid = 0)
    {
        $dayCondition = [];
        if (!empty($dayLimit) && is_int($dayLimit)) {
            $dayCondition['addtime'] = time() - (3600 * 24 * $dayLimit);
        }
        return $this->buildListDb($pagesize, $withImage, $field, $catid)
            ->where($dayCondition, '>')->order('hits desc')->select();
    }

    //获取最新文章
    public function getNewArticles($pagesize = 10, $withImage = false, $field = 'itemid,title,thumb', $catid = 0, $page = 1)
    {
        $db = $this->buildListDb($pagesize, $withImage, $field, $catid, $page);
        return $db->order('itemid desc')->select();
    }

    //根据条件获取统计
    public function getCount(array $condition, $field = 'count')
    {
        return $this->getDb(self::TABLE_NAME)->where($condition)->count($field);
    }

    //获取搜索列表页数据
    public function getLists($pagesize = 10, $field = 'itemid,title,thumb', $catid = 0, $page = 1)
    {
        $list = $this->getNewArticles($pagesize, false, $field, $catid, $page);
        $count = $this->buildListDb($pagesize, false, '*', $catid, 0)->count('c');
        $result['list'] = $list;
        $result['count'] = isset($count['c']) ? $count['c'] : 0;
        return $result;
    }

    //获取文章内容
    public function getOne($itemid)
    {
        return $this->getDb(self::TABLE_NAME)
            ->where(['status' => self::CHECKED_STATUS, 'itemid' => $itemid])->one();
    }

    //修改点击次数
    public function updateHits($itemid, $hits)
    {
        return $this->getDb(self::TABLE_NAME)->where(['itemid' => $itemid])->edit(['hits' => $hits]);
    }

    //根据id获取文章
    public function getListsById(array $itemid, $field = '*')
    {
        return $this->getDb(self::TABLE_NAME)
            ->field($field)
            ->where(['itemid' => implode(',', $itemid)], 'in')
            ->all();
    }

    /**
     * 获取各种条件的特定字段
     * @param $params
     * @return mixed
     *
     *
     */
    public function mallArticleIds($params)
    {
        $where = [];
        if (!empty($params['status'])) $where['status'] = $params['status'];
        if (!empty($params['catid'])) $where['catid'] = $params['catid'];
        $articleDb = $this->getDb(self::TABLE_NAME);
        $articleDb->where($where);
        if(!empty($params['field'])) $articleDb->field($params['field']);
        if((!empty($params['pageSize'])) && (!empty($params['page']))) $articleDb->limit(($params['page'] - 1) * $params['pageSize'],$params['pageSize']);
        return $articleDb->select();
    }
}

?>