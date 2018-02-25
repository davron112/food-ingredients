<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "foods_ingredients".
 *
 * @property integer $id
 * @property integer $food_id
 * @property integer $ingredient_id
 *
 * @property Foods $dish
 * @property Ingredients $ingredient
 */
class FoodsIngredients extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'foods_ingredients';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['food_id', 'ingredient_id'], 'integer'],
            [['food_id'], 'exist', 'skipOnError' => true, 'targetClass' => Foods::className(), 'targetAttribute' => ['food_id' => 'id']],
            [['ingredient_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ingredients::className(), 'targetAttribute' => ['ingredient_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '№',
            'food_id' => 'Ovqat kodi',
            'ingredient_id' => 'Ingredient kodi',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDish()
    {
        return $this->hasOne(Foods::className(), ['id' => 'food_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIngredient()
    {
        return $this->hasOne(Ingredients::className(), ['id' => 'ingredient_id']);
    }


}
