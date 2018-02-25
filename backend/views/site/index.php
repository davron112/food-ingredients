<?php

/* @var $this yii\web\View */
use yii\helpers\Url;
$this->title = 'Restoran admin';
?>
<div class="site-index">

    <div class="jumbotron">
        <h2>Admin panel</h2>

        <span>Salom, siz ingredientlarni qo'shishingiz va yangi taom qilish uchun ularni birlashtirasiz zarur!</span>
<br>
        <div class="row">

            <a class="bg-success" href="/ingredients/index">
                <img src="<?= Url::to('@web/images/ingredents.png')?>" />Show me ingredients</a>
            <a class="bg-success" href="/foods/index">
                <img src="<?= Url::to('@web/images/foods.png')?>" />
                Show me foods</a>
        </div>

    </div>

</div>
