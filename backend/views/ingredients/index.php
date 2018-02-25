<?php

use common\models\Ingredients;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\IngredientsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ingredient';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredients-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Ingredient qo`shish', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'img',
                'format' => 'html',
                'label' => 'img',
                'value' => function ($model) {
                    return Html::img('http://casting.dev/images/'.$model->img,
                        ['width' => '100px']);
                },
            ],
            'title',
            [
                'format' => 'html',
                'attribute' => 'active',
                'filter' => ["0" => "Aktiv emas", "1" => "Aktiv"],
                'value' => function ($model) {
                    /* @var $model Ingredients */
                    switch ($model->active) {
                        case 0:
                            return \yii\helpers\Html::tag('span', 'Aktiv emas',
                                [
                                    'class' => 'label label-' . ('danger')
                                ]);
                            break;
                        case 1:
                            return \yii\helpers\Html::tag('span', 'Aktiv',
                                [
                                    'class' => 'label label-' . ('success')
                                ]);
                            break;
                    }
                }
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
