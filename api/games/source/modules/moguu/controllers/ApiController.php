<?php

namespace app\modules\moguu\controllers;

use Yii;
use yii\web\Controller;
use \Firebase\JWT\JWT;
use app\modules\moguu\services\ScoreService;

class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionSaveScore()
    {
        header('Access-Control-Allow-Origin: http://tc08.tecenet.com');

        $phone = Yii::$app->request->post('phone');
        $username = Yii::$app->request->post('username');
        $score = Yii::$app->request->post('score');
        $timestamp = Yii::$app->request->post('t');
        $token = Yii::$app->request->post('token');

        $currentTime = time();
        $endTime = strtotime('2017-06-02 23:59:59');

        switch (true) {
            case $currentTime > $endTime:
                return $this->responseError(10, '活动已结束');

            case !preg_match('/^1(3|4|5|7|8)\d{9}$/', $phone):
                return $this->responseError(20, '无效的电话号码');

            case is_null($username):
                return $this->responseError(20, '无效的名称');

            case !is_numeric($score):
                return $this->responseError(20, '无效的分数');

            case !$token:
                return $this->responseError(20, '缺少token');

            case $timestamp <= 0:
                return $this->responseError(20, '无效的提交时间');

            case abs($timestamp - $currentTime) > 7200:
                return $this->responseError(30, '过期的的提交时间');
        }

        $postData = [
            'phone'    => $phone,
            'score'    => $score,
            't'        => $timestamp,
            'username' => $username,
        ];

        if (!$this->isValidToken($token, $postData, $timestamp)) {
            return $this->responseError(99, '数据验证失败');
        }

        $scoreService = new ScoreService();
        $saveErrors = $scoreService->saveMaxScore($phone, $username, $score);
        if (!empty($saveErrors)) {
            $firstErrors = reset($saveErrors);

            return $this->responseError(40, reset($firstErrors));
        }

        return $this->responseSuccess();
    }

    public function actionRank()
    {
        header('Access-Control-Allow-Origin: http://tc08.tecenet.com');

        $timestamp = Yii::$app->request->post('t');
        $token = Yii::$app->request->post('token');

        switch (true) {
            case !$token:
                return $this->responseError(20, '缺少token');

            case $timestamp <= 0:
                return $this->responseError(20, '无效的提交时间');

            case abs($timestamp - time()) > 7200:
                return $this->responseError(30, '过期的的提交时间');
        }

        $postData = [
            't' => $timestamp,
        ];

        if (!$this->isValidToken($token, $postData, $timestamp)) {
            return $this->responseError(99, '数据验证失败');
        }

        $scoreService = new ScoreService();

        return $this->responseSuccess($scoreService->getRankList());
    }

    public function actionPersonRank()
    {
        header('Access-Control-Allow-Origin: http://tc08.tecenet.com');

        $phone = Yii::$app->request->post('phone');
        $timestamp = Yii::$app->request->post('t');
        $token = Yii::$app->request->post('token');

        switch (true) {
            case !preg_match('/^1(3|4|5|7|8)\d{9}$/', $phone):
                return $this->responseError(20, '无效的电话号码');

            case !$token:
                return $this->responseError(20, '缺少token');

            case $timestamp <= 0:
                return $this->responseError(20, '无效的提交时间');

            case abs($timestamp - time()) > 7200:
                return $this->responseError(30, '过期的的提交时间');
        }

        $scoreService = new ScoreService();
        $personRank = $scoreService->getPersonRank($phone);

        return $this->responseSuccess(['rank' => $personRank]);
    }

    protected function responseError( $errorCode, $errorMessage, $data = [] )
    {
        return $this->response($errorCode, $errorMessage, $data);
    }

    protected function responseSuccess( $data = [] )
    {
        return $this->response(0, '', $data);
    }

    protected function response( $errorCode, $errorMessage, $data = [] )
    {
        $response = Yii::$app->response;
        $response->format = $response::FORMAT_JSON;

        return $apiResult = [
            'error_code'    => $errorCode,
            'error_message' => $errorMessage,
            'data'          => $data,
        ];
    }

    /**
     * 根据时间戳取得token加密密钥
     *
     * @return string
     */
    protected function getTokenKey( $timestamp )
    {
        return '5928d87ee2b4e' . $timestamp;
    }

    /**
     * 根据数据、时间戳参数取得token
     *
     * @param array   $data
     * @param integer $timestamp
     *
     * @return string
     */
    protected function getToken( $data, $timestamp, $header = ['alg' => 'HS256', 'typ' => 'JWT'] )
    {
        ksort($data);
        $tokenKey = $this->getTokenKey($timestamp);
        $token = JWT::encode($data, $tokenKey, 'HS256', null, $header);

        return $token;
    }

    protected function isValidToken( $token, $validData, $timestamp )
    {
        ksort($validData);

        $decodedData = JWT::decode($token, $this->getTokenKey($timestamp), ['HS256']);
        $decodedData = $decodedData ? (array)$decodedData : [];

        return $decodedData == $validData;
    }
}
