<?php
/**
 * Created by PhpStorm.
 * user: timurka
 * Date: 25.02.18
 * Time: 16:27
 */

namespace app\components;


class TestService extends \yii\base\Component
{
    public $var='Значение по умолчанию';

    public function Run()
    {
        return $this->var;
    }

}