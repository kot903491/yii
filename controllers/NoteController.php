<?php

namespace app\controllers;

use Yii;
use app\models\Note;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * NoteController implements the CRUD actions for Note model.
 */
class NoteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Note models.
     * @return mixed
     */
    /*public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Note::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }*/

    public function actionMy()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Note::find()->byCreator(app()->user->id),
        ]);

        return $this->render('my', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Note model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Note model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (app()->user->can('createNote')) {
            $note = new Note();

            if ($note->load(Yii::$app->request->post()) && $note->save()) {
                app()->session->setFlash('success','Создана заметка '.$note->id);
                return $this->redirect(['my']);
            }

            return $this->render('create', [
                'model' => $note,
            ]);
        }
        return $this->redirect(['site/index']);
    }

    /**
     * Updates an existing Note model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $note = $this->findModel($id);

        if (app()->user->can('updateNote',['post'=>$note])) {
            if ($note->load(Yii::$app->request->post()) && $note->save()) {
                return $this->redirect(['view', 'id' => $note->id]);
            }
        }
        else{
            throw new ForbiddenHttpException('У вас нее прав редактировать данную запись');
        }


        return $this->render('update', [
            'model' => $note,
        ]);
    }

    /**
     * Deletes an existing Note model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $note=$this->findModel($id);
        if(app()->user->can('updateNote',['post'=>$note])) {
            $note->delete();
        }
        else{
            throw new ForbiddenHttpException('У вас нее прав удалять данную запись');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Note model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Note the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Note::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
