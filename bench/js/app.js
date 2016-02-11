/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:23:24
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-11 17:53:45
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
            
            title: 'Accueil',
            subtitle: 'Bienvenue à toi, jeune star',
            tab: 'index'
        })

        .when('/home', {
            controller: 'HomeController',
            templateUrl: 'views/home.html',
            
            title: 'Accueil',
            subtitle: 'Bienvenue à toi, jeune star',
            tab: 'home'
        })

        .when('/login', {
            controller: 'LoginController',
            templateUrl: 'views/login.html',

            title: 'Connexion',
            subtitle: 'C\'est toujours un plaisir de revoir des vieilles têtes',
            tab: 'login'
        })

        .when('/logout', {
            controller: 'LogoutController',
            template: '',

            title: 'Déconnexion',
            subtitle: 'Adieu mon jeune ami',
            tab: 'logout'
        })

        .when('/register', {
            controller: 'RegisterController',
            templateUrl: 'views/register.html',

            title: 'Inscription',
            subtitle: 'Quelle belle idée de venir nous rejoindre',
            tab: 'register'
        })
    ;
});

app.run(['$rootScope', function($rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.title = current.$$route.title;
        $rootScope.subtitle = current.$$route.subtitle;
        $rootScope.tab = current.$$route.tab;
    });
}]);
