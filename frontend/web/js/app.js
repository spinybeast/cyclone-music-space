'use strict';

var app = angular.module('app', [
    'ngRoute', //$routeProvider
    'mgcrea.ngStrap', //bs-navbar, data-match-route directives
    'pascalprecht.translate'
]).controller('CommonCtrl', function ($translate, $rootScope) {
    $rootScope.changeLanguage = function (langKey) {
        $translate.use(langKey);
    };
}).controller('ReviewsCtrl', function ($scope, $http) {
    $scope.reviews = [];
    $http.get('reviews/list').success(function ($data) {
        $scope.reviews = $data;
    });
});

app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/', {
            templateUrl: 'partials/index.html'
        }).when('/portfolio', {
            templateUrl: 'partials/portfolio.html'
        }).when('/reviews', {
            templateUrl: 'partials/reviews.html'
        }).when('/contact', {
            templateUrl: 'partials/contact.html'
        }).when('/faq', {
            templateUrl: 'partials/faq.html'
        }).otherwise({
            redirectTo: '/'
        });
    }
]);

app.config(['$translateProvider', function ($translateProvider) {
    $translateProvider.useStaticFilesLoader({
        prefix: '/lang/',
        suffix: '.json'
    });
    $translateProvider.preferredLanguage(lang || 'ru');
}]);

