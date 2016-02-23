/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:44:37
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-23 12:09:53
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
        REGISTER: serverPath + '/register',
        RESETTING: serverPath + '/resetting',
        TOKEN: serverPath + '/token',
        ACHIVEMENTS_GET: serverPath + '/achievements',
        ACHIVEMENT_ADD: serverPath + '/achievements',
        ACHIVEMENT_EDIT: serverPath + '/achievements',
        ACHIVEMENT_DELETE: serverPath + '/achievements',
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
        USERS_DELETE: serverPath + '/users'
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

    function logout() {
        $cookieService.removeToken();
    }

    var service = {
        login: login,
        logout: logout
    };

    return service;
}]);
