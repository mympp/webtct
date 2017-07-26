<?php

namespace app\modules\moguu\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "{{%moguu_score}}".
 *
 * @property string $id
 * @property string $phone
 * @property string $username
 * @property integer $max_score
 * @property string $created_at
 * @property string $updated_at
 */
class MoguuScore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%moguu_score}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['phone', 'username', 'max_score', 'created_at'], 'required'],
            [['phone', 'max_score', 'created_at', 'updated_at'], 'integer'],
            [['username'], 'string', 'max' => 100],
            [['phone'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'phone' => '电话号码',
            'username' => '名称',
            'max_score' => '最大分数',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    /**
     * @inheritdoc
     * @return MoguuScoreQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MoguuScoreQuery(get_called_class());
    }
}
