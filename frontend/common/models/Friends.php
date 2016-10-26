<?php

namespace app\common\models;

use Yii;

/**
 * This is the model class for table "friends".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $friend_id
 * @property integer $confirmed
 * @property string $date_add
 * @property string $date_confirmed
 */
class Friends extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'friends';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'friend_id', 'confirmed'], 'integer'],
            [['date_add'], 'required'],
            [['date_add', 'date_confirmed'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'friend_id' => Yii::t('app', 'Friend ID'),
            'confirmed' => Yii::t('app', 'Confirmed'),
            'date_add' => Yii::t('app', 'Date Add'),
            'date_confirmed' => Yii::t('app', 'Date Confirmed'),
        ];
    }

    /**
     * @inheritdoc
     * @return FriendsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FriendsQuery(get_called_class());
    }
}
