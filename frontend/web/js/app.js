'use strict';

var app = angular.module('app', [
    'ngRoute',
    'ngDialog',
    'mgcrea.ngStrap', //bs-navbar, data-match-route directives
    'pascalprecht.translate',
    'angular-carousel-3d'
]).controller('CommonCtrl', function ($translate, $rootScope) {
    $rootScope.changeLanguage = function (langKey) {
        $translate.use(langKey);
    };
}).controller('ReviewsCtrl', function ($scope, $http, ngDialog) {
    var carousel = this;
    carousel.slides = [];
    carousel.currentIndex = 0;
    $http.get('reviews/list').success(function ($data) {
        carousel.slides = $data;
    });

    carousel.slideChanged = function slideChanged(index) {
        carousel.currentIndex = index;
    };

    $scope.openForm = function () {
        ngDialog.open({ template: '/partials/review-popup.html', controller: 'ReviewMessageCtrl', className: 'ngdialog-theme-default' });
    }

}).controller('ReviewMessageCtrl', function ($scope, $http) {
    $scope.formData = {};
    $scope.message = $scope.errors = false;
    $scope.sendReview = function () {
        $http({
            method: 'POST',
            url: 'reviews/create',
            data: $.param($scope.formData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (data) {
            if (!data.success) {
                $scope.errors = data.errors;
            } else {
                $scope.message = data.message;
            }
        });
    };
}).controller('ContactCtrl', function ($scope, $http) {
    $scope.formData = {};
    $scope.message = $scope.errors = false;
    $scope.sendMessage = function () {
        $http({
            method: 'POST',
            url: 'site/contact',
            data: $.param($scope.formData),
            headers: {'Content-Type': 'application/x-www-form-urlencoded'}
        }).success(function (data) {
            if (!data.success) {
                $scope.errors = data.errors;
            } else {
                $scope.message = data.message;
            }
        });
    };
});

app.config(['$routeProvider',
    function ($routeProvider) {
        $routeProvider.when('/', {
            templateUrl: '/partials/index.html'
        }).when('/portfolio', {
            templateUrl: '/partials/portfolio.html'
        }).when('/reviews', {
            templateUrl: '/partials/reviews.html'
        }).when('/contact', {
            templateUrl: '/partials/contact.html'
        }).when('/faq', {
            templateUrl: '/partials/faq.html'
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
    console.log(lang);
    $translateProvider.preferredLanguage(lang || 'ru');
}]);

app.run(function run($http) {
    $http.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");
});
