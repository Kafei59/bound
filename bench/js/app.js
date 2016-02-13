/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:23:24
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-13 17:33:30
*/

var app = angular.module('BoundApp', [
    'ngAnimate', 
    'ngRoute', 
    'ngCookies', 
    'angularRipple', 
    'angular-scroll-animate', 
    'chieffancypants.loadingBar'
]);

app.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
}]);

app.config(function($routeProvider) {
    $routeProvider
        .when('/', {
            controller: 'MainController',
            templateUrl: 'views/visitor.html',
            tab: 'index'
        })

        .when('/home', {
            controller: 'HomeController',
            templateUrl: 'views/home.html',
            tab: 'home'
        })

        .when('/login', {
            controller: 'LoginController',
            templateUrl: 'views/login.html',
            tab: 'login'
        })

        .when('/logout', {
            controller: 'LogoutController',
            template: '',
            tab: 'logout'
        })

        .when('/register', {
            controller: 'RegisterController',
            templateUrl: 'views/register.html',
            tab: 'register'
        })
    ;
});

app.run(['$rootScope', function($rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.tab = current.$$route.tab;
    });
}]);
