<?php

namespace frontend\controllers;

use common\controllers\AuthController;
use Yii;
use common\models\Friends;
use common\models\FriendsSearch;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * FriendController implements the CRUD actions for Friends model.
 */
class FriendController extends AuthController
{

    public function actionConfirm($id = '')
    {
        $UserInfo = Yii::$app->user->identity;
        $id = (int)$id;
        if (!$id) {
            return $this->redirect(Url::to(['/user/profile']));
        }
        $model = Friends::find()
            ->where(['user_id' => $id, 'friend_id' => $UserInfo->id, 'confirmed' => 0])
            ->orWhere(['user_id' => $UserInfo->id, 'friend_id' => $id, 'confirmed' => 0])
            ->all();
        if (!$model || !count(model)) {
            return $this->redirect(Url::to(['/user/profile']));
        }
        foreach($model as $m) {
            $m->confirmed = 1;
            $m->date_confirmed = date('Y-m-d H:i:s',time());
            $m->save();
        }
        return $this->redirect(Url::to(['/user/profile']));
    }

    /**
     * remove friend
     */
    public function actionRemove($id = '', $my = '')
    {
        if ($my == 1) {
            $ret = $this->redirect(Url::to('/user/profile'));
        } else {
            $ret = $this->redirect(Url::home());
        }
        $UserInfo = Yii::$app->user->identity;
        $id = (int)$id;
        if (!$id) {
            return $ret;
        }
        if ($my == 1) {
            $model = Friends::find()
                ->where(['user_id' => $id, 'friend_id' => $UserInfo->id, 'confirmed' => 1])
                ->orWhere(['user_id' => $UserInfo->id, 'friend_id' => $id, 'confirmed' => 1])
                ->all();
        } else {
            $model = Friends::find()
                ->where(['user_id' => $UserInfo->id, 'friend_id' => $id, 'confirmed' => 1])
                ->orWhere(['user_id' => $id, 'friend_id' => $UserInfo->id, 'confirmed' => 1])
                ->all();
        }
        if (!$model || !count(model)) {
            return $ret;
        }
        foreach ($model as $m) {
            $m->delete();
        }
        return $ret;
    }

    /**
     * remove request for friend
     */
    public function actionRemoverequest($id = '', $my = '')
    {
        if ($my == 1) {
            $ret = $this->redirect(Url::to('/user/profile'));
        } else {
            $ret = $this->redirect(Url::home());
        }
        $UserInfo = Yii::$app->user->identity;
        $id = (int)$id;
        if (!$id) {
            return $ret;
        }
        if ($my == 1) {
            $model = Friends::find()
                ->where(['user_id' => $id, 'friend_id' => $UserInfo->id, 'confirmed' => 0])
                ->one();
        } else {
            $model = Friends::find()
                ->where(['user_id' => $UserInfo->id, 'friend_id' => $id, 'confirmed' => 0])
                ->one();
        }
        if (!$model || !count(model)) {
            return $ret;
        }

        $model->delete();

        return $ret;

    }

    /**
     * add to friend.
     * @return mixed
     */
    public function actionAdd($id = '', $my = '')
    {
        if ($my == 1) {
            $ret = $this->redirect(Url::to('/user/profile'));
        } else {
            $ret = $this->redirect(Url::home());
        }
        $id = (int)$id;
        if (!$id) {
            return $ret;
        }
        $UserInfo = Yii::$app->user->identity;
        if ($my == 1) {
            $model = Friends::find()
                ->where(['friend_id' => $UserInfo['id']])
                ->andWhere(['user_id' => $id])
                ->all();
        } else {
            $model = Friends::find()
                ->where(['friend_id' => $id])
                ->andWhere(['user_id' => $UserInfo['id']])
                ->all();
        }
        if ($model || count($model)) {
            return $ret;
        }
        $model = new Friends();
        $model->user_id = $UserInfo->id;
        $model->friend_id = $id;
        $model->confirmed = 0;
        $model->date_add = date('Y-m-d H:i:s', time());
        $model->date_confirmed = date('Y-m-d H:i:s', 0);
        $model->save();
        return $ret;
    }


    /**
     * Displays a single Friends model.
     * @param integer $id
     * @return mixed
     */
    public
    function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Friends model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public
    function actionCreate()
    {
//        $model = new Friends();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Updates an existing Friends model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public
    function actionUpdate($id)
    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('update', [
//                'model' => $model,
//            ]);
//        }
    }

    /**
     * Deletes an existing Friends model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public
    function actionDelete($id)
    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
    }

    /**
     * Finds the Friends model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Friends the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected
    function findModel($id)
    {
        if (($model = Friends::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
