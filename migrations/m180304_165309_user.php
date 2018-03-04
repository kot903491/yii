<?php

use yii\db\Migration;

/**
 * Class m180304_165309_user
 */
class m180304_165309_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('user',[
            'id'=>$this->primaryKey(),
            'username'=>$this->string()->notNull(),
            'name'=>$this->string()->notNull(),
            'surname'=>$this->string()->notNull(),
            'password_hash'=>$this->string()->notNull(),
            'access_token'=>$this->string()->null()->defaultValue('NULL'),
            'auth_key'=>$this->string()->defaultValue('NULL')->null(),
            'created_at'=>$this->integer(),
            'updated_at'=>$this->integer()
        ]);
        echo "Миграция m180304_165309_user прошла успешно.\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('user');
        echo "Откатили m180304_165309_user.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180304_165309_user cannot be reverted.\n";

        return false;
    }
    */
}
