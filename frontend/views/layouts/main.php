<?php
use frontend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html ng-app="app">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?= Yii::$app->name ?></title>
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody();
//    if ($this->beginCache('mainCache', ['duration' => 5 * 60])) { ?>
        <div class="wrap" ng-controller="CommonCtrl">
            <nav class="navbar-inverse navbar-fixed-top navbar" role="navigation" bs-navbar>
                <div class="container">
                    <div class="navbar-header">
                        <button ng-init="navCollapsed = true" ng-click="navCollapsed = !navCollapsed" type="button"
                                class="navbar-toggle">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span></button>
                        <a class="navbar-brand" href="#/"><span class="blue">Cyclone</span> music space</a>
                        <?php /*<div class="lang">
                        <a ng-click="changeLanguage('ru')" class="ru"></a>
                        <a ng-click="changeLanguage('en')" class="en"></a>
                    </div> */ ?>
                    </div>
                    <div ng-class="!navCollapsed && 'in'" ng-click="navCollapsed=true" class="collapse navbar-collapse">
                        <ul class="navbar-nav navbar-right nav">
                            <li data-match-route="/$">
                                <a href="#/" translate="Home"></a>
                            </li>
                            <li data-match-route="/portfolio">
                                <a href="#/portfolio" translate="Portfolio"></a>
                            </li>
                            <li data-match-route="/reviews">
                                <a href="#/reviews" translate="Reviews"></a>
                            </li>
                            <li data-match-route="/contact">
                                <a href="#/contact" translate="Contact"></a>
                            </li>
                            <li data-match-route="/faq">
                                <a href="#/faq" translate="FAQ"></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

            <div ng-view autoscroll="true">
            </div>

        </div>

        <footer class="footer">
            <div class="container">
                <div class="pull-left"><?= date('Y') ?> &copy; <?= Yii::$app->name ?>. All rights reserved. </div>
                <div class="pull-right">
                    <a class="btn btn-social-icon btn-vk" target="_blank" title="Мы ВКонтакте"
                       href="https://vk.com/cyclone_music_space">
                        <i class="fa fa-vk"></i>
                    </a>
                    <a class="btn btn-social-icon btn-facebook" target="_blank" title="Мы на Facebook"
                       href="https://www.facebook.com/anton.brezhnev.58">
                        <i class="fa fa-facebook"></i>
                    </a>
                    <a class="btn btn-social-icon btn-soundcloud" target="_blank" title="Мы на Soundcloud"
                       href="https://soundcloud.com/tony-cyclonez">
                        <i class="fa fa-soundcloud"></i>
                    </a>
                </div>
            </div>
        </footer>
        <script>
            var lang = '<?= Yii::$app->request->pathInfo ?: 'ru'?>';
            (function (i, s, o, g, r, a, m) {
             i['GoogleAnalyticsObject'] = r;
             i[r] = i[r] || function () {
             (i[r].q = i[r].q || []).push(arguments)
             }, i[r].l = 1 * new Date();
             a = s.createElement(o),
             m = s.getElementsByTagName(o)[0];
             a.async = 1;
             a.src = g;
             m.parentNode.insertBefore(a, m)
             })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
             ga('create', 'UA-54909644-1', 'auto');
             ga('send', 'pageview');
        </script>
        <?php //$this->endCache();
    //}
    $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>