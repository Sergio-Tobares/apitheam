<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use app\models\Customer;

class CustomerController extends ActiveController {
    
    public $modelClass="app\models\Customer";
    
    public function actions() {
        
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        return $actions;
        
    }
    
      
    public function behaviors(){
    
    $beahaviors = parent::behaviors();
    $beahaviors['authenticator']=[
    'class'=>HttpBearerAuth::className(),
    ];
    
    return $beahaviors;
    }
    
    
    
    public function actionCreate(){
        
        $model = new Customer();
        // cargamos los valores que recibimos por post
        $model->load(Yii::$app->request->post(),'');
        
        $model->created=time();
        $model->updated=time();
        $model->id_created=Yii::$app->user->identity->id;
        $model->id_updated=Yii::$app->user->identity->id;
        
        $model->save();
        
        return $model;
    }
    
    public function actionUpdate($id){
        
        $model = Customer::findOne(['id_customer'=>$id]);
        // cargamos los valores que recibimos por post
        $model->load(Yii::$app->request->post(),'');
        
        
        $model->updated=time();
        $model->id_updated=Yii::$app->user->identity->id;
        
        $model->save();
        
        return $model;
    }
     
    
}