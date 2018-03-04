<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 04.03.18
 * Time: 20:06
 */
function _log($data){

    \Yii::info(\yii\helpers\VarDumper::dumpAsString($data, 5), '_');
}

function _end($data){
    echo \yii\helpers\VarDumper::dumpAsString($data, 5, true);
    exit();
}

/**
 * @return \yii\console\Application|\yii\web\Application|app\components\Application
 */
function app(){
    return \Yii::$app;
}