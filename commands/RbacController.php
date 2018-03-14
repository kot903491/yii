<?php
/**
 * Created by PhpStorm.
 * User: timurka
 * Date: 13.03.18
 * Time: 20:39
 */

namespace app\commands;

use Yii;
use yii\console\Controller;

/**
 * Инициализатор RBAC выполняется в консоли php yii rbac/init
 */

class RbacController extends Controller
{
    public function actionInit()
    {
        $auth=Yii::$app->authManager;
        $auth->removeAll();

        //Создание ролей
        $admin=$auth->createRole('admin');
        $admin->description='Администратор';
        $user=$auth->createRole('user');
        $user->description='Пользователь';

        //Запись в БД
        $auth->add($admin);
        $auth->add($user);

        // Создаем разрешения. Например, создание записи createNote
        // и редактирование записи updateNote
        $createNote=$auth->createPermission('createNote');
        $createNote->description='Создание записи';

        $updateNote=$auth->createPermission('updateNote');
        $updateNote->description='Редактирование записи';

        //Запись в БД
        $auth->add($createNote);
        $auth->add($updateNote);

        // Теперь добавим наследования. Для роли autor мы добавим
        // разрешение createNote,а для админа добавим наследование от роли autor
        //и еще добавим собственное разрешение updateNote
        // Роли «Редактор записей» присваиваем разрешение «Редактирование записи»

        $auth->addChild($user,$createNote);
        $auth->addChild($admin,$user);
        $auth->addChild($admin,$updateNote);


        $rule = new \app\rbac\AuthorRule;
        $auth->add($rule);

        // добавляем разрешение "updateOwnNote" и привязываем к нему правило.
        $updateOwnNote = $auth->createPermission('updateOwnPost');
        $updateOwnNote->description = 'Редактирование своей записи';
        $updateOwnNote->ruleName = $rule->name;
        $auth->add($updateOwnNote);

        // "updateOwnNote" будет использоваться из "updateNote"
        $auth->addChild($updateOwnNote, $updateNote);

        // разрешаем "автору" обновлять его посты
        $auth->addChild($user, $updateOwnNote);


        $updateAllProfiles=$auth->createPermission('updateAllProfiles');
        $updateAllProfiles->description='Редактирование профилей пользователей';
        $auth->add($updateAllProfiles);
        $auth->addChild($admin,$updateAllProfiles);

        $rule=new \app\rbac\UserRule;
        $auth->add($rule);
        $updateOwnProfile=$auth->createPermission('updateOwnProfile');
        $updateOwnProfile->description='Редактирование своего профиля пользователя';
        $updateOwnProfile->ruleName=$rule->name;
        $auth->add($updateOwnProfile);

        $auth->addChild($updateOwnProfile,$updateAllProfiles);
        $auth->addChild($user,$updateOwnProfile);




        $auth->assign($admin,1);
        $auth->assign($user,2);
        $auth->assign($user,3);
    }
}