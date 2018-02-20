<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class MyModel extends Model
{
    public $caption;
    public $date;
    public $time;
    public $url;

    public function getIndex()
    {
        $this->date=date('d.m.Y');
        $this->time=date('H:m');
        $this->caption='Проверка своего контроллера';
        $this->url='yii.local';
    }



}
