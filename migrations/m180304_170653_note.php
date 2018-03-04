<?php

use yii\db\Migration;

/**
 * Class m180304_170653_note
 */
class m180304_170653_note extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('note',[
            'id'=>$this->primaryKey(),
            'text'=>$this->text()->notNull(),
            'created_at'=>$this->integer()->notNull(),
            'updated_at'=>$this->integer()
        ]);
        echo "Миграция m180304_170653_note прошла успешно.\n";
    }
    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('note');
        echo "Откатили m180304_170653_note.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180304_170653_note cannot be reverted.\n";

        return false;
    }
    */
}
