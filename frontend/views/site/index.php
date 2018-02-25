<?php

/* @var $this yii\web\View */
/* @var $ingredients \common\models\Ingredients[] */
/* @var $searchModel common\models\FoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii\helpers\Html;
use yii\helpers\Url;


$this->title = 'Ovqat tanlash';
?>
<div class="site-foods">
    <div class="row">
        <div class="col-md-12 text-center" style="height: 250px">
            <div id="food-image" class="col-md-7"><img src="<?= Url::to('@web/images/serebro.jpg')?>" width="250" /></div>
            <div id="search-result" class="col-md-4" style="overflow-y: auto; height:250px;">
                <span class="label-info">Xohlagan ovqatingizga mos ingredientlarni tanlang.</span>
            </div>
        </div>
        <div class="col-md-12">
<!--            <button class="select"> </button>-->
            <div class="clearfix">

                <button class="send " data-counter="0">✔</button>
            </div>
            <ul id="ingridents-owl" class="owl-crousel">
                <div class="text-center"><img src="<?= Url::to('@web/images/loading.gif')?>" /></div>
            </ul>
        </div>
    </div>

</div>