/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:23:24
* @Last Modified by:   Kafei59
* @Last Modified time: 2016-03-09 15:27:11
*/

var app = angular.module('BoundApp', [
    'ngAnimate', 
    'ngRoute', 
    'ngCookies', 
    'angularRipple', 
    'angular-scroll-animate', 
    'angularMoment',
    'chieffancypants.loadingBar'
]);

app.config(['cfpLoadingBarProvider', function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = false;
}]);

app.run(function(amMoment) {
    amMoment.changeLocale('fr');
});

app.config(['$httpProvider', function($httpProvider) {
    $httpProvider.defaults.useXDomain = true
    delete $httpProvider.defaults.headers.common['X-Requested-With']
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
            pageSubtitle: 'On s\'amuse toujours plus à plusieurs',
            tab: 'crew'
        })

        .when('/cgu', {
            controller: 'CguController',
            templateUrl: 'views/cgu.html',
            pageTitle: 'CGU',
            pageSubtitle: 'Parce qu\'il faut bien être sérieux à un moment',
            tab: 'cgu'
        })

        .when('/privacy', {
            controller: 'PrivacyController',
            templateUrl: 'views/privacy.html',
            pageTitle: 'Polique de confidentialité',
            pageSubtitle: 'Parce que l\'on ne fait pas n\'importe quoi avec les données',
            tab: 'privacy'
        })

        .otherwise({
            redirectTo: '/home'
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
