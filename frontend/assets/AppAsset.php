<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/bootstrap.min.css',
        'css/site.css',
        'css/owl.carousel.css'
    ];
    public $js = [
        'js/jquery.min.js',
        'js/bootstrap.min.js',
        'js/owl.carousel.min.js',
        'js/main.js',
    ];
    public $depends = [
    ];
}
