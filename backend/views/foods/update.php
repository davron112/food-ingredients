<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Foods */
/* @var $data common\models\Ingredients[] */

$this->title = 'Ovqatni o`zgartirish kiritish: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Ovqat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'O`zgartirish';
?>
<div class="foods-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data
    ]) ?>

</div>
