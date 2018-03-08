<?php

namespace app\controllers;

use app\components\TestService;
use app\models\MyModel;
use app\models\Note;
use app\models\User;
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

class UserController extends \yii\web\Controller
{
    public function actionTest()
    {
        /*for ($i=1;$i<=3;$i++){
            $text='Эта заметка создана юзером '.$i;
            $this->addNote($i,$text);
        }*/

        /*$model=User::findOne(2);
        _end($model->getAcessedNotes()->all());*/


        $models=Note::find()->with(Note::RELATION_CREATOR)->all();
        $models_j=Note::find()->joinWith(Note::RELATION_CREATOR)->all();

        return $this->render('test',[
            'models'=>$models,
            'models_j'=>$models_j
        ]);
    }

    private function addNote($idUser,$text)
    {
        $user=User::findOne($idUser);
        $note=new Note();
        $note->text=$text;
        $note->created_at=time();
        $note->save();
        $note->link(Note::RELATION_CREATOR,$user);
        $user->link(User::RELATION_ACCESEDNOTES,$note);

    }

    private function addUser($userName,$name,$pass)
    {
        $user=new User();
        $user->username=$userName;
        $user->name=$name;
        $user->password_hash=password_hash($pass,1);
        $user->created_at=time();
        $user->save();
    }

}
