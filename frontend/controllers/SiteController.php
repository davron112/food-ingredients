<?php

namespace frontend\controllers;

use common\models\FoodsIngredients;
use common\models\Ingredients;
use common\models\LoginForm;
use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function beforeAction($action)
    {
        if ($action->id == 'search') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */

    public function actionIndex()
    {
        $ingredients = Ingredients::find()->select(['title', 'id'])->indexBy('id')->active()->column();
        return $this->render('index', [
            'ingredients' => $ingredients,
        ]);
    }

    /**
     * @return array in json
     */
    public function actionSearch()
    {
        if (!Yii::$app->request->isAjax) {
            die("Can't touch this ;)");
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        $selected = \Yii::$app->request->post('selected');

        $matches = FoodsIngredients::find()
            ->select(['foods.title', 'foods.img', 'foods_ingredients.food_id', 'COUNT(ingredients.id) as MatchCount'])
            ->leftJoin('ingredients', 'ingredients.id = foods_ingredients.ingredient_id')
            ->leftJoin('foods', 'foods.id = foods_ingredients.food_id')
            ->andWhere(['in', 'ingredient_id', $selected])
            ->andWhere('foods.active = 1')
            ->groupBy('foods_ingredients.food_id')
            ->having('COUNT(ingredient_id)>=2')
            ->orderBy('MatchCount DESC')
            ->asArray()
            ->all();

        if (empty($selected)) {
            return [
                'status' => 1,
                'img' => 'serebro.jpg',
                'result' => '<span class="text-warning">Biror narsa tanlang</span>'
            ];
        }
        if (sizeof($selected) < 2) {
            return [
                'status' => 1,
                'result' => '<span class="text-warning">Yana masalliq tanlang</span>'
            ];
        }

        if (empty($matches)) {
            return [
                'status' => 1,
                'img' => 'serebro.jpg',
                'result' => '<span class="text-warning">Hech narsa topilmadi</span>'
            ];
        }

        $someMatches = [];
        $exactMatch = [];

        foreach ($matches as $matchElement) {
            $ingredientsArray = [];
            $dishQuery = Ingredients::find()->joinWith('foodsIngredients')->where(['food_id' => $matchElement['food_id']]);
            $dish = $dishQuery->all();
            $count = $dishQuery->count();

            /**@var $dish Ingredients[] */

            foreach ($dish as $item) {
                if (!$item->active) {
                    continue 2;
                }

                $ingredientsArray[] = in_array($item->id, $selected) ?
                    Html::tag('span', $item->title, ['class' => 'text-success'])
                    :
                    $item->title;
            }

            $ingredients = implode(', ', $ingredientsArray);
            $title = $matchElement['title'] . ' <br>Mos ingredientlar soni: ' . $matchElement['MatchCount'] . '';

            $someMatches[$title] = $ingredients;
            if ($matchElement['MatchCount'] == $count && $count == sizeof($selected)) {
                $exactMatch[$title] = $ingredients;
            }
        }

        return [
            'result' => $this->renderAjax('_item', [
                'foods' => (!empty($exactMatch)) ? $exactMatch : $someMatches,
            ]),
            'status' => 1,
            'img' => $matchElement['img']
        ];
    }

    public function actionFoods(){

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = Ingredients::find()->all();
        foreach ($model as $item){
            $items['img'] = $item->img;
            $items['id'] = $item->id;
            $items['title'] = $item->title;
            $result[] = $items;
        }
        $result2['items'] = $result;
        return $result2;
    }
}
