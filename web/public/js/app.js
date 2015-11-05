/* 
* @Author: gicque_p
* @Date:   2015-10-12 13:24:59
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-28 12:41:02
*/

if (window.location.href.indexOf('app_dev') > -1) {
    var path = '../public/views/';
} else {
    var path = 'public/views/';
}

var app = angular.module('BoundApp', ['ngAnimate', 'ngRoute', 'angularRipple', 'angular-scroll-animate']);

app.config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});

app.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            controller: 'MainController',
            templateUrl: path + 'index.html'
        })

        .when('/dashboard', {
            controller: 'AllUserController',
            templateUrl: path + 'dashboard.html'
        })

        .when('/user/:username', {
            controller: 'GetUserController',
            templateUrl: path + 'user.html'
        })

        .when('/achievement', {
            controller: 'AllAchievementController',
            templateUrl: path + 'achievement.html'
        })

        .when('/achievement/:salt', {
            controller: 'GetAchievementController',
            templateUrl: path + 'achievementTest.html'
        })

        .when('/crew', {
            controller: 'AllCrewController',
            templateUrl: path + 'crew.html'
        })

        .when('/crew/:salt', {
            controller: 'GetCrewController',
            templateUrl: path + 'crewTest.html'
        })

        .when('/friends/:username', {
            controller: 'FriendsUserController',
            templateUrl: path + 'friends.html'
        })

        .otherwise({
            controller: 'MainController',
            templateUrl: path + 'index.html'
        })
    ;
});
