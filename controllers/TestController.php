<?php

namespace app\controllers;

use app\models\MyModel;
use Yii;
use yii\base\BaseObject;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class TestController extends Controller
{
    public function actionIndex()
    {
        $model = new MyModel();
        $model->getIndex();
        return $this->render('test',[
            'model'=>$model
        ]);
    }


}
