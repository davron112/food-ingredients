<?php

use common\models\Foods;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Foods */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Foods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foods-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Orqaga', 'index', ['class' => 'btn btn-default']) ?>
        <?= Html::a('O`zgartirish kiritish', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('O`chirish', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Ovqatni o`chirish "' . mb_strtolower($model->title, 'UTF-8') . '"?',
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
            [
                'attribute' => 'ingredients',
                'value' => function ($model) {
                    /* @var $model Foods */
                    return implode(', ', ArrayHelper::map($model->ingredients, 'id', 'title'));
                },
            ],
        ],
    ]) ?>

</div>
