<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Friends */

$this->title = Yii::t('app', 'Create Friends');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Friends'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="friends-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
