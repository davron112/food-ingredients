<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Foods;

/**
 * FoodsSearch represents the model behind the search form about `common\models\Foods`.
 */
class FoodsSearch extends Foods
{
    public $ingredients;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active'], 'integer'],
            [['title', 'ingredients'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Foods::find()->with('ingredients')->groupBy('title')->joinWith('ingredients');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->validate() && $this->load($params))) {
            return $dataProvider;
        }

        $dataProvider->setSort([
            'attributes' => [
                'id',
                'title',
                'active',
                'ingredients' => [
                    'asc' => ['foods_ingredients.food_id' => SORT_ASC],
                    'desc' => ['foods_ingredients.food_id' => SORT_DESC],
                    'default' => SORT_ASC
                ],
            ]]);


        // grid filtering conditions
        $query->andFilterWhere([
            self::tableName() . '.id' => $this->id,
            self::tableName() . '.active' => $this->active,
            'foods_ingredients.ingredient_id' => $this->ingredients,

        ]);

        $query->andFilterWhere(['like', self::tableName() . '.title', $this->title]);

        return $dataProvider;
    }
}
