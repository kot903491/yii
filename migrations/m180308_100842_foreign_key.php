<?php

use yii\db\Migration;

/**
 * Class m180308_100842_foreign_key
 */
class m180308_100842_foreign_key extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        \Yii::$app->db->createCommand()->addForeignKey('fx_access_user', 'access', ['user_id'], 'user', ['id'])->execute();
        \Yii::$app->db->createCommand()->addForeignKey('fx_access_note', 'access', ['note_id'], 'note', ['id'])->execute();
        \Yii::$app->db->createCommand()->addForeignKey('fx_note_user', 'note', ['creator_id'], 'user', ['id'])->execute();
        echo 'Внешние ключи созданы';
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        \Yii::$app->db->createCommand()->dropForeignKey('fx_access_user', 'access')->execute();
        \Yii::$app->db->createCommand()->dropForeignKey('fx_access_note', 'access')->execute();
        \Yii::$app->db->createCommand()->dropForeignKey('fx_note_user', 'note')->execute();
        echo "Внешние ключи удалены";

        return true;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180308_100842_foreign_key cannot be reverted.\n";

        return false;
    }
    */
}
