'use strict';

var app = angular.module('app', [
    'ngRoute',
    'ngDialog',
    'mgcrea.ngStrap', //bs-navbar, data-match-route directives
    'pascalprecht.translate',
    'angular-carousel-3d',
    'plangular',
    'flow'
]).config(function (plangularConfigProvider) {
    plangularConfigProvider.clientId = 'f7844a0d2655ff6424cda2891baa462d';
}).controller('CommonCtrl', function ($translate, $rootScope) {
    $rootScope.changeLanguage = function (langKey) {
        $translate.use(langKey);
    };
}).controller('PortfolioCtrl', function ($scope, plangularConfig) {
    var readyTags = [];
    $scope.tags = [];
    $scope.activeTag = false;
    $scope.empty = true;
    $scope.$watch('tracks', function(tracks) {
        $scope.empty = false;
        tracks.forEach(function (track) {
            track.tags = [];
            var tags = track.tag_list.split(' ');
            tags.push(track.genre);
            tags.forEach(function (tag) {
                var tagName = tag;
                var tagId = tag.toLowerCase().replace(/\s/g, '').replace(/\//g, '_');
                if (tagId.length && tagId != 'soundtrack') {
                    track.tags.push(tagId);
                    if (readyTags.indexOf(tagId) === -1) {
                        readyTags.push(tagId);
                        $scope.tags.push({
                            id: tagId,
                            name: tagName
                        });
                    }
                }
            });
        });
        if ($scope.tags[0]) {
            $scope.showTracks($scope.tags[0]);
        }
    });
    $scope.showTracks = function (tag) {
        $scope.activeTag = tag.id;
        $scope.tracks.forEach(function (track) {
            track.show = ~track.tags.indexOf(tag.id);
        });
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
        ngDialog.open({
            template: '/partials/review-popup.html',
            controller: 'ReviewMessageCtrl',
            className: 'ngdialog-theme-default'
        });
    }

}).controller('ReviewMessageCtrl', function ($scope, $http) {
    $scope.formData = {Reviews: {}};
    $scope.message = $scope.errors = false;
    $scope.uploader = {
        setPhoto: function ($file, $message) {
            $scope.formData.Reviews.photo = $file.file.name;
        },
        setNoPhoto: function () {
            $scope.formData.Reviews.photo = null;
        }
    };
    $scope.connectNetwork = function(network) {

    };
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
                $scope.uploader.flow.upload();
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
    $translateProvider.preferredLanguage(lang || 'ru');
}]);

app.run(function run($http) {
    $http.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");
});
