<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Ingredients */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ingredient', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ingredients-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Orqaga', 'index', ['class' => 'btn btn-default']) ?>
        <?= Html::a('O`zgartirish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ingredientni o`chirish "' . mb_strtolower($model->title, 'UTF-8') . '"?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            [
                'format' => 'html',
                'attribute' => 'active',
                'value' => call_user_func(function ($model) {
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
                }, $model)
            ],
        ],
    ]) ?>

</div>
