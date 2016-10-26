<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
       Those requests were sent by other users for ME  <?php // echo Html::a(Yii::t('app', 'Create User'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
//            'auth_key',
//            'password_hash',
//            'password_reset_token',
            'email:email',
            // 'status',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {friend}',
                'buttons' => [
                    'view'=> function ($url, $model, $key) {
                        return Html::a('view | ', ['user/view', 'id' => $model->id, 'my'=>1]);
                    },
                    'friend' => function ($url, $model, $key) {
                        $res = \common\models\Friends::isFriendMy(Yii::$app->user->identity->getId(), $model->id);
                        if ($res === 1) {
                            return Html::a('remove friend', ['friend/remove', 'id' => $model->id, 'my'=>1],['style'=>'color:red']) ;
                        }
                        if ($res === 0) {
                            return Html::a('remove request for friend', ['friend/removerequest', 'id' => $model->id, 'my'=>1]) . ' | ' . Html::a('confirm', ['friend/confirm', 'id' => $model->id]);
                        }
                        return Html::a('add to friends', ['friend/add', 'id' => $model->id, 'my'=>1], ['style'=>'color:green']);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
