'use strict';

var app = angular.module('app', [
    'ngRoute',
    'ngDialog',
    'mgcrea.ngStrap', //bs-navbar, data-match-route directives
    'pascalprecht.translate',
    'angular-carousel-3d',
    'flow'
]).controller('CommonCtrl', function ($translate, $rootScope) {
    $rootScope.changeLanguage = function (langKey) {
        $translate.use(langKey);
    };
    $rootScope.isEnglish = function () {
        console.log($translate.use());
        return $translate.use() === 'en';
    };
}).controller('PortfolioCtrl', function ($scope) {
    var $ctrl = this;

    $ctrl.activeTag = false;
    $ctrl.tracks = {};
    $ctrl.tags = [];
    $ctrl.getTracks = getTracks;
    $ctrl.getTags = getTags;
    $ctrl.prepareTags = prepareTags;
    $ctrl.showTracks = showTracks;

    SC.initialize({
        client_id: 'f7844a0d2655ff6424cda2891baa462d'
    });
    SC.get('/tracks', {
        user_id: 108057656,
        limit: 200
    }).then(function (tracks) {
        $ctrl.tracks = tracks;
        $ctrl.prepareTags(tracks);
        $scope.$apply();
    });

    function getTracks() {
        return $ctrl.tracks;
    }

    function getTags() {
        return $ctrl.tags;
    }

    function prepareTags(tracks) {
        var readyTags = [];
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
                        $ctrl.tags.push({
                            id: tagId,
                            name: tagName
                        });
                    }
                }
            });
        });
        if ($ctrl.tags[0]) {
            $ctrl.showTracks($ctrl.tags[0]);
        }
    }

    function showTracks(tag) {
        $ctrl.activeTag = tag.id;
        $ctrl.tracks.forEach(function (track) {
            track.show = ~track.tags.indexOf(tag.id);
        });
    }
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
    $scope.connectNetwork = function (network) {

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
app.directive('ngPlayer', function () {
    return {
        restrict: 'E',
        controller: function ($scope) {
            this.activeTrack = false;
            this.pausePlaying = function (active) {
                if (this.activeTrack !== active) {
                    this.activeTrack = active;
                    $scope.$broadcast('pause');
                }
            }
        }
    }
});
app.directive('ngTrack', function ($http) {
    return {
        restrict: 'E',
        require: '^ngPlayer',
        scope: {
            track: '=track'
        },
        templateUrl: '/partials/portfolio-track.html',
        link: function (scope, element, attrs, playerCtrl) {
            var clientid = 'f7844a0d2655ff6424cda2891baa462d';
            $http({
                method: 'GET',
                url: 'https://api.soundcloud.com/tracks/' + scope.track + '.json?client_id=' + clientid
            }).success(function (data) {
                scope.author = data.user.username;
                scope.title = data.title;
                scope.albumArt = data.artwork_url;
                scope.stream = data.stream_url + '?client_id=' + clientid;
                scope.song = new Audio();
                scope.song.volume = 0.5;
                scope.song.ontimeupdate = function () {
                    var elapsedTime = scope.song.currentTime;
                    var duration = scope.song.duration;
                    var progress = (elapsedTime / duration);
                    scope.$apply(function () {
                        scope.progress = progress;
                    });
                };
            });
            scope.playing = false;
            scope.play = function () {
                playerCtrl.pausePlaying(scope.$id);
                scope.playing = !scope.playing;
                if (!scope.playing) {
                    scope.song.pause();
                }
                else {
                    if (scope.song.src === '') {
                        scope.song.src = scope.stream;
                    }
                    scope.song.play();
                }
            };
            scope.seek = function (e) {
                if (!scope.playing) {
                    return false;
                }
                var percent = e.offsetX / e.target.offsetWidth || (e.layerX - e.target.offsetLeft) / e.target.offsetWidth;
                scope.song.currentTime = percent * scope.song.duration || 0;
            };
            scope.setVolume = function (e) {
                if (!scope.playing) {
                    return false;
                }
                var percent = e.offsetX / e.target.offsetWidth || (e.layerX - e.target.offsetLeft) / e.target.offsetWidth;
                scope.song.volume = percent;
            };
            scope.$on('pause', function () {
                scope.playing = false;
                scope.song.pause();
            });
        }
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
    $translateProvider.preferredLanguage(lang || 'en');
}]);

app.run(function run($http) {
    $http.defaults.headers.post['X-CSRF-Token'] = $('meta[name="csrf-token"]').attr("content");
});
