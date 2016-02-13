/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:44:37
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-13 17:30:49
*/

app.factory('apiService', function() {
    var defaultIP = window.location.hostname;
    if (defaultIP != 'localhost' && defaultIP != '127.0.0.1') {
        var serverIP = defaultIP + '/~gicque_p/bound/desk/web';
    } else {
        var serverIP = defaultIP + '/~gicque_p/bound/desk/web/app_dev.php';        
    }

    var serverPath = location.protocol + '//' + serverIP + '/api';
    var service = {
        serverPath: serverPath,
        LOGIN: serverPath + '/login',
        REGISTER: serverPath + '/register',
        RESETTING: serverPath + '/resetting',
        TOKEN: serverPath + '/token',
        ACHIVEMENTS_GET: serverPath + '/achievements',
        ACHIVEMENTS_ADD: serverPath + '/achievements',
        ACHIVEMENTS_EDIT: serverPath + '/achievements',
        ACHIVEMENTS_DELETE: serverPath + '/achievements',
        CREWS_GET: serverPath + '/crews',
        CREWS_ADD: serverPath + '/crews',
        CREWS_EDIT: serverPath + '/crews',
        CREWS_DELETE: serverPath + '/crews',
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
