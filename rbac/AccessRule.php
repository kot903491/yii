<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 15.03.18
 * Time: 20:43
 */

namespace app\rbac;

use yii\rbac\Item;
use yii\rbac\Rule;


class AccessRule extends Rule
{
    public $name='isUserAccess';

    public function execute($user, $item, $params)
    {
        return isset($params['id']) ? $params['id']==$user : false;
    }

}