<?php
namespace models\helpers\query;

use models\helpers\data\category;

class MallQuery extends BaseQuery
{
    const CHECKED_STATUS = 3;       //已通过状态
    const TABLE_NAME = 'mall';

    //获取推荐产品
    /**
     * @param int $pagesize 获取推荐产品数目
     * @param int $catid 分类下的推荐产品
     * @param int $dayLimit 添加时间限制，天数
     * @param string $field 返回字段
     * @return array
     */
    public function getRecommendMalls($pagesize = 10, $catid = 0, $dayLimit = 0, $field = '')
    {
        //指定分类
        $inCondition = [];
        if (!empty($catid)) {
            $inCondition['catid'] = $this->buildCateCondition($catid);
        }
        //添加时间限制
        $dayCondition = [];
        if (is_int($dayLimit) && !empty($dayLimit)) {
            $dayCondition['addtime'] = time() - (3600 * 24 * $dayLimit);
        }

        //推荐产品
        if (empty($field)) $field = 'itemid,thumb,title,kcatids,linkurl,company,username';
        return $this->getDb(self::TABLE_NAME)->field($field)
            ->where(['status' => self::CHECKED_STATUS])->where($inCondition, 'in')
            ->where($dayCondition, '>')->order('hits desc')->limit(0, $pagesize)->select();
    }

    //获取最新产品
    /**
     * @param int $pagesize 获取产品数目
     * @param int $catid 指定分类
     * @param string $field 指定返回字段
     * @return array
     */
    public function getNewMalls($pagesize = 10,$catid = 0,$field = '',$username = '',$page = 1)
    {
        //指定分类
        $inCondition = [];
        if (!empty($catid)) {
            $inCondition['catid'] = $this->buildCateCondition($catid);
        }

        if (empty($field)) $field = 'thumb,title,linkurl,company,username';

        $dbModel = $this->getDb(self::TABLE_NAME)->field($field)->where(['status' => self::CHECKED_STATUS])
            ->where($inCondition, 'in');
        if(!empty($username)){
            $dbModel->where(['username' => $username]);
        }
        $start = ($page - 1)*$pagesize;
        return $dbModel->order('itemid desc')->limit($start, $pagesize)->select();
    }

    //根据id获取产品
    public function getListsById(array $itemid, $field = '*'){
        return $this->getDb(self::TABLE_NAME)
            ->field($field)
            ->where(['itemid' => implode(',',$itemid)],'in')->all();
    }


    //根据条件获取统计
    public function getCount(array $condition, $field = 'count')
    {
        return $this->getDb(self::TABLE_NAME)->where($condition)->count($field);
    }

    //构建分类搜索条件
    /**
     * @param $catid 分类id
     * @return string
     */
    private function buildCateCondition($catid)
    {
        $categoryModel = new category();
        $childCate = $categoryModel->getChildCate($catid);
        $childIds = [];
        foreach ($childCate as $cate) {
            $childIds[] = $cate['catid'];
        }
        return implode(',', $childIds);
    }

    /**
     * 获取各种条件的特定字段
     * @param $params
     * @return mixed
     *
     *
     */
    public function mallRes($params)
    {
        $where = [];
        if (!empty($params['status'])) $where['status'] = $params['status'];
        if (!empty($params['catid'])) $where['catid'] = $params['catid'];
        $mallDb = $this->getDb(self::TABLE_NAME);
        $mallDb->where($where);
        if(!empty($params['field'])) $mallDb->field($params['field']);
        if((!empty($params['pageSize'])) && (!empty($params['page']))) $mallDb->limit(($params['page'] - 1) * $params['pageSize'],$params['pageSize']);
        return $mallDb->select();
    }
}

?>