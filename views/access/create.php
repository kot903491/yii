<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Access */

$this->title = 'Create Access';
$this->params['breadcrumbs'][] = ['label' => 'Accesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="access-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <h4>Расшарить заметку</h4>

    <p>"
        <?= $note; ?>"
    </p>

    <h4>пользователю:</h4>

    <?= $this->render('_form', [
        'model' => $model,
        'users'=>$users,
    ]) ?>

</div>
