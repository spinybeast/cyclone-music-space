<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';

    public $css = [
        'angular-carousel-3d/dist/carousel-3d.min.css',
    ];

    public $js = [
        'angular/angular.js',
        'angular-route/angular-route.js',
        'angular-strap/dist/angular-strap.js',
        'angular-translate/angular-translate.js',
        'angular-translate-loader-static-files/angular-translate-loader-static-files.js',
        'angular-carousel-3d/dist/carousel-3d.min.js',
        'angular-swipe/dist/angular-swipe.min.js'
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}