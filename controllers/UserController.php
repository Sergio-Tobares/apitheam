<?php

namespace app\controllers;

// definimos el recurso active controller que nos da las acciones basicas de REST API
use Yii;
use yii\rest\ActiveController;
use app\models\User;
use yii\filters\auth\HttpBearerAuth;

class UserController extends ActiveController{
    
    public $modelClass="app\models\User";
    
    public function actions() {
        
        $actions = parent::actions();
        unset($actions['create']);
        unset($actions['update']);
        unset($actions['delete']);
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
        
        if (Yii::$app->user->identity->rol!='Admin') return "Only Admins can create new users";
        
        $model = new User();
        // cargamos los valores que recibimos por post
        $model->load(Yii::$app->request->post(),'');
        
        $model->created_at=time();
        $model->updated_at=time();
        $model->save();
        
        return $model;
    }
    
    public function actionUpdate($id){
        
        if (Yii::$app->user->identity->rol!='Admin') return "Only Admins can create new users";
        
        $model = User::findOne(['id'=>$id]);
        // cargamos los valores que recibimos por post
        $model->load(Yii::$app->request->post(),'');
        
        $values=['Admin','User'];
        if (!in_array($model->rol,$values)) return "The only values acepted for rol are: Admin and User";
        
        $model->updated_at=time();
        $model->save();
        
        return $model;
    }
    
    
    public function actionDelete($id){
        
        if (Yii::$app->user->identity->rol!='Admin') return "Only Admins can create new users";
        
        // buscamos el usuario y lo borramos
        $model = User::findOne(['id'=>$id]);
        if ($model) {
            $model->delete();
            return "The user id: ".$id.", has been deleted";
        }
        else return "User id: ".$id.", could not be found.";
    }
    
}