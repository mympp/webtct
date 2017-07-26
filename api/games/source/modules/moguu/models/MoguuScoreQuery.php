<?php

namespace app\modules\moguu\models;

/**
 * This is the ActiveQuery class for [[MoguuScore]].
 *
 * @see MoguuScore
 */
class MoguuScoreQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return MoguuScore[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return MoguuScore|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
