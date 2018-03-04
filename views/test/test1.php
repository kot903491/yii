<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 05.03.18
 * Time: 0:20
 */?>
<?= \yii\widgets\DetailView::widget(['model'=>$model,
    'attributes' => [
        'count:raw',
        'id>1:raw',
        'id=1:raw',
        'note:raw'
    ]]);?>