<?php
/* @var $this yii\web\View */
?>
<h1>user/test</h1>
<?php if(isset($models)):?>
<p>
<h2>без Join</h2>
</p>

<?php foreach ($models as $model):?>
<?=\yii\widgets\DetailView::widget(['model' => $model]);?>
<?php endforeach;?>
<?php endif;?>
<?php if(isset($models_j)):?>
<p>
<h2>c Join</h2>
</p>

<?php foreach ($models_j as $model){
    echo \yii\widgets\DetailView::widget(['model' => $model]);
};?>
<?php endif;?>