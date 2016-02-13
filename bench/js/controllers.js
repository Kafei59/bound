/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:42:51
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-13 17:37:57
*/

app.controller('MainController', ['$rootScope', 'cookieService', function($rootScope, $cookieService) {
    $rootScope.token = $cookieService.getToken();
    $rootScope.date = new Date();
}]);

app.controller('HomeController', ['$rootScope', '$scope', 'cookieService', function($rootScope, $scope, $cookieService) {
    $rootScope.token = $cookieService.getToken();
}]);

app.controller('LoginController', ['$rootScope', '$scope', '$location', 'userService', 'cookieService', function($rootScope, $scope, $location, $userService, $cookieService) {
    $scope.login = function() {
        var form = {
            username: $scope.username,
            password: $scope.password
        };

        $userService.login(form)
            .success(function(data) {
                function callback() {
                    $location.path('/home');
                    $location.replace();
                }

                $cookieService.addToken(data.token.data);
                $rootScope.token = $cookieService.getToken();
                callback();
            })
            .error(function(data) {
                alert('Auth Failed');
            })
        ;
    };
}]);

app.controller('LogoutController', ['$location', 'userService', function($location, $userService) {
    $userService.logout();
    $location.path('/');
    $location.replace();
}]);

app.controller('RegisterController', function() {
}]);
