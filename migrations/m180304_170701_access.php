<?php

use yii\db\Migration;

/**
 * Class m180304_170701_access
 */
class m180304_170701_access extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('access', [
            'id' => $this->primaryKey(),
            'note_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull()
        ]);
        echo "Миграция m180304_170701_access прошла успешно.\n";
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('access');
        echo "Откатили m180304_170701_access.\n";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180304_170701_access cannot be reverted.\n";

        return false;
    }
    */
}
