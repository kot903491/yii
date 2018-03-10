<?php

namespace app\controllers;

use app\components\TestService;
use app\models\MyModel;
use app\models\Note;
use Yii;
use yii\base\BaseObject;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

/**
 * Class TestController
 * @package app\controllers
 */
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

    public function actionSecond()
    {
        return $this->render('test',[
            'model'=>Yii::$app->service,
        ]);
    }


    public function actionFourth()
    {
        //$this->insertUser();
        //$this->insertNote();
        $result['id=1']=\yii\helpers\VarDumper::dumpAsString(
            (new Query())->from('user')->where(['id'=>1])->all(),10,true);
        $result['id>1']=\yii\helpers\VarDumper::dumpAsString(
            (new Query())->from('user')->where('id>1')->all(),10,true);
        $result['count']=\yii\helpers\VarDumper::dumpAsString(
            (new Query())->from('user')->count(),10,true);
        $result['note']=\yii\helpers\VarDumper::dumpAsString((new Query())->select(
            [
                'note'=>'text',
                'user'=>'name'
            ]
        )->from('note')->innerJoin('user','user.id=creator_id')
            ->all(),10,true);
        return $this->render('test1',[
            'model'=>$result,
        ]);
    }


    private function insertUser()
    {
        app()->db->createCommand()->insert('user',[
            'username'=>'user1',
            'name'=>'user1',
            'password_hash'=>'drgdgef565bfgn'
        ])->execute();
        app()->db->createCommand()->insert('user',[
            'username'=>'user2',
            'name'=>'user2',
            'password_hash'=>'dfjgn56iu6ofasdronrgo'
        ])->execute();
        app()->db->createCommand()->insert('user',[
            'username'=>'user3',
            'name'=>'user3',
            'password_hash'=>'hmhfogmgienin5'
        ])->execute();
    }
    private function insertNote()
    {
        app()->db->createCommand()->batchInsert('note',['text','creator_id'],
            [['text1',1],['text2',2],['text3',3]])->execute();
    }
}
