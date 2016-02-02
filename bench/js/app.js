/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:23:24
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-02 13:41:59
*/

var app = angular.module('BoundApp', ['ngAnimate', 'ngRoute', 'angularRipple', 'angular-scroll-animate']);

app.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            controller: 'MainController',
            templateUrl: 'views/index.html'
        })
    ;
});
