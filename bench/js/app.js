/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:23:24
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-20 12:23:03
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
            pageTitle: 'Accueil',
            tab: 'index'
        })

        .when('/login', {
            controller: 'LoginController',
            templateUrl: 'views/login.html',
            pageTitle: 'Connexion',
            tab: 'login'
        })

        .when('/logout', {
            controller: 'LogoutController',
            template: '',
            pageTitle: 'Déconnexion',
            tab: 'logout'
        })

        .when('/register', {
            controller: 'RegisterController',
            templateUrl: 'views/register.html',
            pageTitle: 'Inscription',
            tab: 'register'
        })

        .when('/home', {
            controller: 'HomeController',
            templateUrl: 'views/home.html',
            pageTitle: 'Accueil',
            pageSubtitle: 'Bienvenue à toi, jeune star',
            tab: 'home'
        })

        .when('/dashboard', {
            controller: 'DashboardController',
            templateUrl: 'views/dashboard.html',
            pageTitle: 'Dashboard',
            pageSubtitle: 'Toutes les informations du compte au même endroit',
            tab: 'dashboard'
        })

        .when('/mail', {
            controller: 'MailController',
            templateUrl: 'views/mail.html',
            pageTitle: 'Messagerie',
            pageSubtitle: 'Une lettre d\'amour attend peut-être',
            tab: 'mail'
        })

        .when('/achievements', {
            controller: 'AchievementsController',
            templateUrl: 'views/achievements.html',
            pageTitle: 'Haut-faits',
            pageSubtitle: 'Qui est la nouvelle star des réseaux sociaux ?',
            tab: 'achievements'
        })

        .when('/friends', {
            controller: 'FriendsController',
            templateUrl: 'views/friends.html',
            pageTitle: 'Amis',
            pageSubtitle: 'Avoir des relations c\'est important',
            tab: 'friends'
        })

        .when('/crew', {
            controller: 'CrewController',
            templateUrl: 'views/crew.html',
            pageTitle: 'Crew',
            pageSubtitle: 'On s\'amouse toujours mieux à plusieurs',
            tab: 'crew'
        })

        .otherwise({
            redirectTo: '/'
        })
    ;
});

app.run(['$rootScope', function($rootScope) {
    $rootScope.$on('$routeChangeSuccess', function (event, current, previous) {
        $rootScope.pageTitle = current.$$route.pageTitle;
        $rootScope.pageSubtitle = current.$$route.pageSubtitle;
        $rootScope.tab = current.$$route.tab;
    });
}]);
