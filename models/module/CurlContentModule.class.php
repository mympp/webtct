<?php
namespace models\module;

use models\helpers\widget\curl;

class CurlContentModule extends baseModule
{
    public function __construct()
    {
        $this->moduleid = 0;
        $this->modulename = 'curlContent';
    }

    /**
     * 获取首页维修数据
     */
    public function getIndexRepairData()
    {
        $apiUrl = 'http://api.tecenet.com/index.php';
        $apiParams = [
            'r' => 'repair/tc/index-list'
        ];

        $curl = new curl();
        $repair_datas = $curl->curl_https($apiUrl, $apiParams);

        $result = json_decode($repair_datas, true);
        if (is_array($result)) {
            return $result;
        }

        return [];
    }
}
