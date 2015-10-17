/* 
* @Author: gicque_p
* @Date:   2015-10-12 13:24:59
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-17 13:46:51
*/

var origin = document.location.origin;
var folder = document.location.pathname.split('/')[1] + '/' + document.location.pathname.split('/')[2];
var path = origin + '/' + folder + '/web/bundles/boundfront/views/';

var app = angular.module('BoundApp', ['ngAnimate', 'ngRoute', 'angularRipple']);

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
            controller: 'MainController',
            templateUrl: path + 'dashboard.html'
        })

        .otherwise({
            controller: 'MainController',
            templateUrl: path + 'index.html'
        });
});
