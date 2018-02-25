<?php

use yii\db\Migration;

class m180220_055101_foods_ingredients_table extends Migration
{

    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%foods_ingredients}}', [
            'id' => $this->primaryKey(),
            'food_id' => $this->integer(),
            'ingredient_id' => $this->integer(),
        ], $tableOptions);

        $this->addForeignKey('fk_to_foods', 'foods_ingredients', 'food_id', 'foods', 'id');
        $this->addForeignKey('fk_to_ingredients', 'foods_ingredients', 'ingredient_id', 'ingredients', 'id');

    }

    public function SafeDown()
    {
        $this->dropForeignKey('fk_to_foods', 'foods_ingredients');
        $this->dropForeignKey('fk_to_ingredients', 'foods_ingredients');
        $this->dropTable('foods_ingredients');
    }

}
