<?php

use yii\db\Migration;

class m160701_093117_create_reviews_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%reviews}}', [
            'id' => $this->primaryKey(),
            'author' => $this->string()->notNull(),
            'text' => $this->text()->notNull(),
            'social_link' => $this->string(),
            'photo' => $this->string(),
            'published' => $this->boolean(),
            'created_at' => $this->dateTime()->notNull(),
            'updated_at' => $this->dateTime()->notNull(),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%reviews}}');
    }
}
