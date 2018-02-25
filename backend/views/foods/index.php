<?php

use common\models\Foods;
use common\models\Ingredients;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ovqatlar';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Ovqat qo`shish', ['create'], ['class' => 'btn btn-success']) ?>
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
                'attribute' => 'ingredients',
                'value' => function ($model) {
                    /* @var $model Foods */
                    return implode(', ', ArrayHelper::map($model->ingredients, 'id', 'title'));
                },
                'filter' => Ingredients::find()->select(['title', 'id'])->indexBy('id')->column(),
            ],
            [
                'format' => 'html',
                'attribute' => 'active',
                'filter'  => ["0" => "Aktiv emas", "1" => "Aktiv"],
                'value' => function ($model) {
                    /* @var $model Foods */
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
