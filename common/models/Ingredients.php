<?php

namespace common\models;

use common\models\IngredientsQuery;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ingredients".
 *
 * @property integer $id
 * @property string $title
 * @property integer $active
 *
 * @property FoodsIngredients[] $foodsIngredients
 */
class Ingredients extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['active'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'title' => 'Ingredient nomi',
            'active' => 'Aktiv',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFoodsIngredients()
    {
        return $this->hasMany(FoodsIngredients::className(), ['ingredient_id' => 'id']);
    }

    public function getFoods()
    {
        return $this->hasMany(Foods::className(), ['id' => 'food_id'])->viaTable('foods_ingredients', ['ingredient_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    /*
     * SELECT foods_ingredients.food_id,count(ingredients.id) as count_math FROM ingredients
        left JOIN foods_ingredients on ingredients.id = foods_ingredients.ingredient_id
        Where ingredient_id in (1,5,6)
        GROUP BY foods_ingredients.food_id
        HAVING count(ingredient_id)>=2
        order by count_math DESC
     * */


    /**
     * @inheritdoc
     * @return IngredientsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new IngredientsQuery(get_called_class());
    }
}
