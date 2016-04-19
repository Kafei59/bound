/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:44:37
* @Last Modified by:   Kafei59
* @Last Modified time: 2016-03-29 16:50:14
*/

app.factory('apiService', function() {
    var defaultIP = window.location.hostname;
    if (defaultIP != 'localhost' && defaultIP != '127.0.0.1') {
        var serverIP = 'api.bound-app.com';
    } else {
        var serverIP = defaultIP + '/~gicque_p/bound/desk/web/app_dev.php/api';
    }

    var serverPath = location.protocol + '//' + serverIP;
    var service = {
        serverPath: serverPath,

        LOGIN: serverPath + '/login',
        REGISTER: serverPath + '/register',
        RESETTING: serverPath + '/resetting',
        TOKEN: serverPath + '/token',

        LOGIN_FACEBOOK: serverPath + '/oauth/v2.0/facebook/login',
        REGISTER_FACEBOOK: serverPath + '/oauth/v2.0/facebook/register',
        ASSOCIATE_FACEBOOK: serverPath + '/oauth/v2.0/facebook/associate',

        ASSOCIATE_TWITTER: serverPath + '/oauth/v2.0/twitter/associate',
        ASSOCIATE_INSTAGRAM: serverPath + '/oauth/v2.0/instagram/associate',
        ASSOCIATE_LINKEDIN: serverPath + '/oauth/v2.0/linkedin/associate',
        ASSOCIATE_STRAVA: serverPath + '/oauth/v2.0/strava/associate',
        ASSOCIATE_DEEZER: serverPath + '/oauth/v2.0/deezer/associate',

        ACHIEVEMENTS_GET: serverPath + '/achievements',
        ACHIEVEMENT_LOAD: serverPath + '/achievements/load',
        CREWS_GET: serverPath + '/crews',
        NOTIFICATIONS_GET: serverPath + '/notifications',
        FRIENDS_GET: serverPath + '/friends',
        USERS_GET: serverPath + '/users'
    };

    return service;
});

app.factory('cookieService', ['$cookies', function($cookies) {

    function addToken($token) {
        $cookies.put('token', $token);
    }

    function removeToken() {
        $cookies.remove('token');
    }

    function getToken() {
        return $cookies.get('token');
    }

    function isLogged() {
        $token = $cookies.get('token');
        if ($token != null) {
            return true;
        } else {
            return false;
        }
    }

    var service = {
        addToken: addToken,
        removeToken: removeToken,
        getToken: getToken,
        isLogged: isLogged
    };

    return service;
}]);

app.factory('userService', ['$http', 'apiService', 'cookieService', function($http, $apiService, $cookieService) {

    function login($data) {
        return $http.post($apiService.LOGIN, $data, {
            headers: { 'Content-Type': 'application/json' }
        });
    }

    function register($data) {
        return $http.post($apiService.REGISTER, $data, {
            headers: { 'Content-Type': 'application/json' }
        });
    }

    function logout() {
        $cookieService.removeToken();
    }

    function getUser($token) {
        $data = {
            token: $token
        };

        return $http.post($apiService.TOKEN, $data, {
            headers: { 'Content-Type': 'application/json' }
        });
    }

    var service = {
        login: login,
        register: register,
        logout: logout,
        getUser: getUser
    };

    return service;
}]);
