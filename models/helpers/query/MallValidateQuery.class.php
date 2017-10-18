<?php
namespace models\helpers\query;

//处理产品证书流程
class MallValidateQuery extends BaseQuery
{
    const CHECKED_STATUS = 3;       //已通过状态
    const WAIT_STATUS = 2;  //等待审核状态
    const FORBID_STATUS = 4;    //拒绝状态
    const NEED_STATUS = 1;  //必填证件状态
    const UNNEED_STATUS = 0;    //非必填状态
    const NEED_TITLE = '注册证';  //必须上传的证件

    /**
     * 添加产品关联证书
     * @param $cert 证件数据
     * @param $mallid 产品id
     * @param $userid 用户id
     */
    public function add($cert, $mallid, $userid)
    {
        if (empty($cert) || !is_array($cert)) {
            return false;
        }

        $mallValidateDb = $this->getDb(mall_validate);
        foreach ($cert as $key => $item) {
            if (empty($item['document'])) {
                continue;
            }

            $data = [];
            if (!empty($item['isMust'])) {
                $data['title'] = self::NEED_TITLE;
                $data['isMust'] = self::NEED_STATUS;
            } else {
                $data['title'] = $item['certName'];
                $data['isMust'] = self::UNNEED_STATUS;
            }
            $data['userid'] = $userid;
            $data['mallid'] = $mallid;
            $data['thumb'] = $item['document'];
            $data['addtime'] = time();
            $data['edittime'] = time();
            $data['expiretime'] = strtotime($item['validDate']);
            $data['status'] = self::WAIT_STATUS;
            $mallValidateDb->add($data);
        }
        return true;
    }


    /**
     * 修改产品证书
     * @param $cert 证件数据
     * @param $mallid 产品id
     * @param $userid 用户id
     */
    public function update($cert, $mallid, $userid)
    {
        if (empty($cert) || !is_array($cert)) {
            return false;
        }

        $addCert = [];  //保存需要新增的证书
        $mallValidateDb = $this->getDb(mall_validate);
        foreach ($cert as $key => $item) {
            if (empty($item['document'])) continue;

            if (empty($item['itemid'])) {
                array_push($addCert, $item);     //没有itemid的数据，处理为添加新证书
                continue;
            }

            $data = [];
            if (empty($item['isMust'])) {
                $data['title'] = $item['certName'];
            } else {
                $data['title'] = self::NEED_TITLE;
            }

            $data['userid'] = $userid;
            $data['mallid'] = $mallid;
            $data['thumb'] = $item['document'];
            $data['addtime'] = time();
            $data['edittime'] = time();
            $data['expiretime'] = strtotime($item['validDate']);
            $data['status'] = self::WAIT_STATUS;

            $mallValidateDb->where(['itemid' => $item['itemid']])->edit($data);
        }

        $this->add($addCert, $mallid, $userid);
        return true;
    }

    /**
     * 删除证书信息
     * @param int or array $itemid 证书id
     * @return bool
     */
    public function delete($itemid)
    {
        $idStr = '';
        if (is_array($itemid)) {
            $idStr = implode(',', $itemid);
        } else {
            $idStr = $itemid;
        }
        return $this->getDb('mall_validate')
            ->where(['itemid' => $idStr], 'in')->delete();
    }

    /**
     * 获取产品列表
     * @param $mallid 产品id
     * @return array
     */
    public function getListByMall($mallid)
    {
        return $this->getDb('mall_validate')
            ->field('itemid,title,thumb,addtime,edittime,expiretime,isMust')
            ->where(['mallid' => $mallid])->all();
    }

    /**
     * 获取证书统计
     * @param $mallid 产品id
     */
    public function getCountByMall($mallid)
    {
        $count = $this->getDb('mall_validate')->where(['mallid' => $mallid])->count('c');
        if ($count) {
            return $count['c'];
        } else {
            return 0;
        }
    }

    /**
     * 根据证书id修改证书状态
     * @param $itemid
     * @param $status
     */
    public function changeStatus($itemid,$status){
        $idStr = is_array($itemid) ? implode(',',$itemid) : $itemid;
        return $this->getDb('mall_validate')->where(['itemid'=>$idStr],'in')->edit(['status'=>$status]);
    }

    /**
     * 根据产品id修改证书状态
     * @param $mallid
     * @param $status
     */
    public function changeStatusByMall($mallid,$status){
        $idStr = is_array($mallid) ? implode(',',$mallid) : $mallid;
        return $this->getDb('mall_validate')->where(['mallid'=>$idStr],'in')->edit(['status'=>$status]);
    }


}

?>