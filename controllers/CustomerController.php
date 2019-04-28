<?php

namespace app\controllers;

use Yii;
use yii\rest\ActiveController;
use yii\filters\auth\HttpBearerAuth;
use app\models\Customer;
use yii\web\UploadedFile;

class CustomerController extends ActiveController {
    
    public $modelClass="app\models\Customer";
    
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
        
        $model = new Customer();
        // cargamos los valores que recibimos por post
        $model->load(Yii::$app->request->post(),'');
        
        // rellenamos valores automaticos
        $model->created=time();
        $model->updated=time();
        $model->id_created=Yii::$app->user->identity->id;
        $model->id_updated=Yii::$app->user->identity->id;

        // cogemos el fichero
        $archivo = UploadedFile::getInstanceByName('file'); 
        \yii::$app->request->enableCsrfValidation = false;
        // si existe archivo los creamos estructura de directiorio y lo subimos
        if ($archivo) {
            $ruta=substr(Yii::getAlias('@app'),0).'/web/';
            // in order to have a clean directory structure web create a folder acording to the date
            if (!file_exists ( $ruta.'upload/' ))
            {mkdir($ruta.'upload/', 0777);}
            if (!file_exists ( $ruta.'upload/'.Date('Y') ))
            {mkdir($ruta.'upload/'.Date('Y'), 0777);}
            if (!file_exists ( $ruta.'upload/'.Date('Y').'/'.Date('m') ))
            {mkdir($ruta.'upload/'.Date('Y').'/'.Date('m'), 0777);}
            if (!file_exists ( $ruta.'upload/'.Date('Y').'/'.Date('m').'/'.Date('d') ))
            {mkdir($ruta.'upload/'.Date('Y').'/'.Date('m').'/'.Date('d'), 0777);}
            
            $filename='upload/'.Date('Y').'/'.Date('m').'/'.Date('d').'/user_'.$model->created.'.'.$archivo->extension;
            // the file is saved first in order to be resized
            $archivo->saveAs($ruta.$filename);
            $model->photo=$filename;                        
        }
        else {
            $model->photo="nofoto.jpg";
        }
        
        if ($model->save()) {
            $model->photo="http://apimonkeys.savocan.com/web/".$model->photo;
            return $model;
        }
        else return "Data could not be saved";
        
        
    }
    
    public function actionUpdate($id){
              
        $model = Customer::findOne(['id_customer'=>$id]);
        // cargamos los valores que recibimos por post hay que usar un modo distinto a cuando es POST
        $receivedata = Yii::$app->request->getBodyParams();
        $model->name=$receivedata["name"];
        $model->surname=$receivedata["surname"];
        // cogemos el fichero
        $archivo = UploadedFile::getInstanceByName('file');
        //actualizamos valores automáticos
        $model->updated=time();
        $model->id_updated=Yii::$app->user->identity->id;
        
        
        \yii::$app->request->enableCsrfValidation = false;
        // si existe archivo los creamos estructura de directiorio y lo subimos
        if ($archivo) {
            $ruta=substr(Yii::getAlias('@app'),0).'/web/';
            //borramos la foto antigua
            if (file_exists($ruta.$model->photo)) unlink($ruta.$model->photo);
            // in order to have a clean directory structure web create a folder acording to the date
            if (!file_exists ( $ruta.'upload/' ))
            {mkdir($ruta.'upload/', 0777);}
            if (!file_exists ( $ruta.'upload/'.Date('Y') ))
            {mkdir($ruta.'upload/'.Date('Y'), 0777);}
            if (!file_exists ( $ruta.'upload/'.Date('Y').'/'.Date('m') ))
            {mkdir($ruta.'upload/'.Date('Y').'/'.Date('m'), 0777);}
            if (!file_exists ( $ruta.'upload/'.Date('Y').'/'.Date('m').'/'.Date('d') ))
            {mkdir($ruta.'upload/'.Date('Y').'/'.Date('m').'/'.Date('d'), 0777);}
            
            $filename='upload/'.Date('Y').'/'.Date('m').'/'.Date('d').'/user_'.$model->created.'.'.$archivo->extension;
            // en update tambien hay que hacerlo diferente a create 
            copy($archivo->tempName, $ruta.$filename);
            $model->photo=$filename;
        }        
        
        if ($model->save()) {
            $model->photo="http://apimonkeys.savocan.com/web/".$model->photo;
            return $model;
        }
        else return "Data could not be saved";
        
        return $model;
    }
     
    
    public function actionDelete($id){
        
        // buscamos el usuario y lo borramos
        $model = Customer::findOne(['id_customer'=>$id]);
        
        if ($model) {
            // check if the file exist to delete
            $ruta=substr(Yii::getAlias('@app'),0).'/web/';
            if (file_exists($ruta.$model->photo)) unlink($ruta.$model->photo);
            
            $model->delete();
            return "The Customer id: ".$id.", has been deleted";
        }
        else return "Customer id: ".$id.", could not be found.";
    }
    
}