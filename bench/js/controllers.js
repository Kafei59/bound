/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:42:51
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-11 17:53:03
*/

app.controller('MainController', ['$scope', '$routeParams', '$cookies', '$window', '$http', 'promiseResponse', function($scope, $routeParams, $cookies, $http, promiseResponse) {
}]);

app.controller('HomeController', ['$scope', '$routeParams', '$cookies', '$window', '$http', 'promiseResponse', function($scope, $routeParams, $cookies, $http, promiseResponse) {
}]);

app.controller('LoginController', ['$scope', '$routeParams', '$cookies', '$window', 'httpResponse', function($scope, $routeParams, $cookies, $window, $cfpLoadingBar) {
    $scope.login = function() {
        if ($scope.username && $scope.password) {
            $value = {'username': $scope.username, 'password': $scope.password};

            httpResponse.post('http://127.0.0.1/~gicque_p/bound/desk/web/app_dev.php/api/login', $value)
            .success(function(data, status) {
                $cookies.put('token', data.token.data);
                location.reload();
                $window.location.href = '#/home';
            })
            .error(function(data, status) {
                alert('Auth failed.');
            });
        }
    };
}]);

app.controller('LogoutController', ['$scope', '$routeParams', '$cookies', '$window', 'httpResponse', function($scope, $routeParams, $cookies, $window, $cfpLoadingBar) {
    $cookies.remove('token');
    location.reload();
    $window.location.href = '#/';
}]);

app.controller('RegisterController', ['$scope', '$routeParams', '$cookies', 'httpResponse', function($scope, $routeParams, $cookies, $cfpLoadingBar) {
    $scope.display = true;
}]);
