<?php

namespace common\models;

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

    public static function isFriend($id_user, $id_friend)
    {
        $model = self::find()
            ->where(['user_id' => $id_user, 'friend_id' => $id_friend])
            ->orWhere(['user_id' => $id_friend, 'friend_id' => $id_user])
            ->all();
        if ($model && count($model)) {
            $conf = 0;
            foreach($model as $m) {
                if ($m->confirmed) {
                    $conf = 1;
                } else {
                    $conf = 0;
                }
            }
            if($conf === 1){
                return 1;
            }
            if($conf === 0){
                $model = self::find()
                    ->where(['user_id' => $id_user, 'friend_id' => $id_friend])
                    ->one();
                if(!model){
                    return 0;
                }
                if($model->confirmed){
                    return 1;
                }else{
                    return 0;
                }
            }
        }
        return 2;
    }

    public static function isFriendMy($id_user, $id_friend)
    {
        $model = self::find()
            ->where(['user_id' => $id_friend, 'friend_id' => $id_user])
            ->orWhere(['user_id' => $id_user, 'friend_id' => $id_friend])
            ->all();
        if ($model && count($model)) {
            $conf = 0;
            foreach($model as $m) {
                if ($m->confirmed) {
                    $conf = 1;
                } else {
                    $conf = 0;
                }
            }
            if($conf === 1){
                return 1;
            }
            if($conf === 0){
                $model = self::find()
                    ->where(['user_id' => $id_friend, 'friend_id' => $id_user])
                    ->one();
                if(!model){
                    return 0;
                }
                if($model->confirmed){
                    return 1;
                }else{
                    return 0;
                }
            }
        }
        return 2;
    }
}
