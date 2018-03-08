<?php
/* @var $this yii\web\View */
?>
<h1>user/test</h1>

<p>
<h2>без Join</h2>
</p>

<?php foreach ($models as $model){
echo \yii\widgets\DetailView::widget(['model' => $model]);
};?>

<p>
<h2>c Join</h2>
</p>

<?php foreach ($models_j as $model){
    echo \yii\widgets\DetailView::widget(['model' => $model]);
};?>
