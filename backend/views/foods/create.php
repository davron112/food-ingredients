<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Foods */
/* @var $data common\models\Ingredients[] */

$this->title = 'Ovqat qo`shish';
$this->params['breadcrumbs'][] = ['label' => 'Ovqat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="foods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data
    ]) ?>

</div>
