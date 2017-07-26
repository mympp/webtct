<?php
/**
 * Created by PhpStorm.
 * User: Tecenet
 * Date: 0027 5/27
 * Time: 13:38:45
 */

namespace app\modules\moguu\services;

use yii\base\Component;
use app\modules\moguu\models\MoguuScore;

class ScoreService extends Component
{
    /**
     * 保存游戏结果
     *
     * @param string $phone
     * @param string $username
     * @param string $score
     *
     * @return array
     */
    public function saveMaxScore( $phone, $username, $score )
    {
        $maxScoreModel = MoguuScore::find()->where(['phone' => $phone])->one();
        if (empty($maxScoreModel)) {
            $maxScoreModel = new MoguuScore([
                'phone'      => $phone,
                'username'   => $username,
                'max_score'  => $score,
                'created_at' => time(),
                'updated_at' => 0,
            ]);
        } else {
            if ($maxScoreModel->username != $username || $maxScoreModel->max_score < $score) {
                $maxScoreModel->setAttributes([
                    'username'   => $username,
                    'max_score'  => max($score, $maxScoreModel->max_score),
                    'updated_at' => time(),
                ]);
            } else {
                return [];
            }
        }

        if (!$maxScoreModel->save()) {
            return $maxScoreModel->errors;
        }

        return [];
    }

    /**
     * 保存游戏结果
     *
     * @param string $phone
     * @param string $username
     * @param string $score
     *
     * @return array
     */
    public function getRankList()
    {
        $rankList = MoguuScore::find()
            ->select('phone, username, max_score')
            ->orderBy('max_score DESC, updated_at ASC, id ASC')
            ->limit(100)
            ->asArray()
            ->all();

        if ($rankList) {
            foreach ($rankList as $key => $rankItem) {
                $rankList[$key]['phone'] = substr_replace($rankItem['phone'], '****', 3, 4);

                $first = mb_substr($rankItem['username'], 0, 1);
                $from = mb_substr($rankItem['username'], 1);
                $len = mb_strlen($from);
                $rankList[$key]['username'] = $first . str_repeat('*', $len);
            }
        }

        return $rankList;
    }

    public function getPersonRank( $phone )
    {
        $personMaxScore = MoguuScore::find()->where(['phone' => $phone])->one();
        if (empty($personMaxScore)) {
            return 0;
        }

        $topRankCount = MoguuScore::find()
            ->select('phone, username, max_score')
            ->where('`max_score` > :max_score', [
                ':max_score' => $personMaxScore->max_score,
            ])->count();

        $sameScoreRanks = MoguuScore::find()
            ->select('id, phone, username, max_score')
            ->where('`max_score` = :max_score AND `updated_at` <= :updated_at', [
                ':max_score' => $personMaxScore->max_score,
                ':updated_at' => $personMaxScore->updated_at,
            ])
            ->orderBy('max_score DESC, updated_at ASC, id ASC')->all();

        if (empty($sameScoreRanks)) {
            return $topRankCount + 1;
        }

        $personRank = $topRankCount;
        foreach ($sameScoreRanks as $sameScore) {
            $personRank++;
            if ($sameScore->id == $personMaxScore->id) {
                break;
            }
        }

        return $personRank;
    }
}
