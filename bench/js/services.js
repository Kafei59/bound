/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:44:37
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-26 00:57:44
*/

app.factory('apiService', function() {
    var defaultIP = window.location.hostname;
    if (defaultIP != 'localhost' && defaultIP != '127.0.0.1') {
        var serverIP = 'api.bound-app.com';
    } else {
        var serverIP = defaultIP + '/~gicque_p/bound/desk/web/app_dev.php';
    }

    var serverPath = location.protocol + '//' + serverIP;
    var service = {
        serverPath: serverPath,
        LOGIN: serverPath + '/login',
        LOGIN_FACEBOOK: serverPath + '/oauth/v2.0/login/facebook/login',
        REGISTER_FACEBOOK: serverPath + '/oauth/v2.0/login/facebook/register',
        ASSOCIATE_FACEBOOK: serverPath + '/oauth/v2.0/login/facebook/associate',
        REGISTER: serverPath + '/register',
        RESETTING: serverPath + '/resetting',
        TOKEN: serverPath + '/token',
        ACHIEVEMENTS_GET: serverPath + '/achievements',
        ACHIEVEMENT_ADD: serverPath + '/achievements',
        ACHIEVEMENT_EDIT: serverPath + '/achievements',
        ACHIEVEMENT_DELETE: serverPath + '/achievements',
        ACHIEVEMENT_LOAD: serverPath + '/achievements/load',
        CREWS_GET: serverPath + '/crews',
        CREWS_ADD: serverPath + '/crews',
        CREWS_EDIT: serverPath + '/crews',
        CREWS_DELETE: serverPath + '/crews',
        NOTIFICATIONS_GET: serverPath + '/notifications',
        NOTIFICATION_ADD: serverPath + '/notifications',
        NOTIFICATION_EDIT: serverPath + '/notifications',
        NOTIFICATION_DELETE: serverPath + '/notifications',
        USERS_GET: serverPath + '/users',
        USERS_ADD: serverPath + '/users',
        USERS_EDIT: serverPath + '/users',
        USERS_DELETE: serverPath + '/users',
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
        return $http.post($apiService.LOGIN, $data);
    }

    function register($data) {
        return $http.post($apiService.REGISTER, $data);
    }

    function logout() {
        $cookieService.removeToken();
    }

    function getUser($token) {
        $data = {
            token: $token
        };

        return $http.post($apiService.TOKEN, $data);
    }

    var service = {
        login: login,
        register: register,
        logout: logout,
        getUser: getUser
    };

    return service;
}]);
