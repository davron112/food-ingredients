<?php

use yii\db\Migration;

class m180220_050342_ingredients_table extends Migration
{
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%ingredients}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'active' => $this->integer()->defaultValue('1'),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('ingredients');
        return false;
    }
}
