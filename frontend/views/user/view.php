<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php //echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php //echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
        //            'class' => 'btn btn-danger',
        //            'data' => [
        //                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
        //                'method' => 'post',
        //            ],
        //        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'username',
            'email:email',

        ],
    ]) ?>


    <?php
    if(isset($_GET['my'])&&$_GET['my']=='1'){
        $res = \common\models\Friends::isFriendMy(Yii::$app->user->identity->getId(), $model->id);
        if ($res === 1) {
            echo Html::a('remove friend', ['friend/remove', 'id' => $model->id, 'my'=>1], ['style'=>'color:red']);
        } elseif ($res === 0) {
            echo Html::a('remove request for friend', ['friend/removerequest', 'id' => $model->id, 'my'=>1]);
        } else {
            echo Html::a('add to friends', ['friend/add', 'id' => $model->id, 'my'=>1], ['style'=>'color:green']);
        }
    }else {
        $res = \common\models\Friends::isFriend(Yii::$app->user->identity->getId(), $model->id);
        if ($res === 1) {
            echo Html::a('remove friend', ['friend/remove', 'id' => $model->id], ['style'=>'color:green']);
        } elseif ($res === 0) {
            echo Html::a('remove request for friend', ['friend/removerequest', 'id' => $model->id]);
        } else {
            echo Html::a('add to friends', ['friend/add', 'id' => $model->id], ['style'=>'color:green']);
        }
    }


    ?>
</div>
