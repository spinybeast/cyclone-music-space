<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';

    public $css = [
        'angular-carousel-3d/dist/carousel-3d.min.css',
        'ng-dialog/css/ngDialog.min.css',
        'ng-dialog/css/ngDialog-theme-default.css'
    ];

    public $js = [
        'angular/angular.js',
        'angular-route/angular-route.js',
        'angular-strap/dist/angular-strap.js',
        'angular-translate/angular-translate.js',
        'angular-translate-loader-static-files/angular-translate-loader-static-files.js',
        'angular-carousel-3d/dist/carousel-3d.min.js',
        'angular-swipe/dist/angular-swipe.min.js',
        'ng-dialog/js/ngDialog.min.js',
        'plangular/dist/plangular.min.js',
        'ng-flow/dist/ng-flow-standalone.min.js'
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}