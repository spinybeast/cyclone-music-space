<?php

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $js = [
        'angular/angular.js',
        'angular-route/angular-route.js',
        'angular-strap/dist/angular-strap.js',
        'angular-translate/angular-translate.js',
        'angular-translate-loader-static-files/angular-translate-loader-static-files.js',
    ];
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}