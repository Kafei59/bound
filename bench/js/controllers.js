/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:42:51
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-23 12:14:56
*/

app.controller('MainController', ['$rootScope', 'cookieService', function($rootScope, $cookieService) {
    $rootScope.token = $cookieService.getToken();
    $rootScope.date = new Date();
}]);

app.controller('HomeController', ['$rootScope', '$scope', 'cookieService', 'apiService', '$http', function($rootScope, $scope, $cookieService, $apiService, $http) {
    $rootScope.token = $cookieService.getToken();

    $url = $apiService.NOTIFICATIONS_GET + '?token=' + $rootScope.token;
    $http.get($url).success(function(data) {
        $scope.notifications = data.notifications;
    });
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
});

app.controller('DashboardController', ['$rootScope', 'cookieService', function($rootScope, $cookieService) {
    $rootScope.token = $cookieService.getToken();
}]);

app.controller('MailController', ['$rootScope', 'cookieService', function($rootScope, $cookieService) {
    $rootScope.token = $cookieService.getToken();
}]);

app.controller('AchievementsController', ['$rootScope', 'cookieService', function($rootScope, $cookieService) {
    $rootScope.token = $cookieService.getToken();
}]);

app.controller('FriendsController', ['$rootScope', 'cookieService', function($rootScope, $cookieService) {
    $rootScope.token = $cookieService.getToken();
}]);

app.controller('CrewController', ['$rootScope', 'cookieService', function($rootScope, $cookieService) {
    $rootScope.token = $cookieService.getToken();
}]);
