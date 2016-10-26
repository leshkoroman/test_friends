<?php
/**
 * Created by PhpStorm.
 * User: roman
 * Date: 26.10.2016
 * Time: 1:48
 */

namespace common\controllers;

use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;

class AuthController extends Controller{

    public function behaviors(){

        $behaviors = [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view','add','removerequest', 'remove' ,'profile', 'confirm'],
                        'allow' => true,
                        'roles' => ['@']
                    ]
                ]
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];


        return $behaviors;

    }


}