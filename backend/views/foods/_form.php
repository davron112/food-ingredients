<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Foods */
/* @var $form yii\widgets\ActiveForm */
/* @var $data common\models\Ingredients[] */
?>

<div class="foods-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'active')->checkbox(); ?>
    <?= $form->field($model, 'img')->fileInput(); ?>

	
	<?
    $items = \yii\helpers\ArrayHelper::map(\common\models\Ingredients::find()->all(), 'id', 'title');
    $params = [
        'prompt' => 'Ingredient tanlang',
        'multiple'=>'multiple',
    ];
    echo $form->field($model, 'ingredientsArray')->dropDownList($items,$params);
    ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Qo`shish' : 'Saqlash', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
