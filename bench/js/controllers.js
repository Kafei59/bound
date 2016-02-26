/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:42:51
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-26 10:04:16
*/

app.controller('MainController', ['$rootScope', 'cookieService', '$location', 'userService', '$http', function($rootScope, $cookieService, $location, $userService, $http) {
    $rootScope.token = $cookieService.getToken();
    $rootScope.date = new Date();

    // $req = {    
    //     method: 'POST',
    //     url: 'http://bound-app.com/token',
    //     headers: {
    //         'Content-Type': undefined
    //     },

    //     data: { token: 'test' }
    // };

    // $form = { token: 'toto' };

    // $http.post('http://127.0.0.1/~gicque_p/bound/desk/web/', $form, {
    // })
    // .then(function() {
    //     alert('OUI !');
    // });

    $userService.getUser($rootScope.token).success(function(data) {
        $location.path('/home');
        $location.replace();
    });
}]);

app.controller('LoginController', ['$rootScope', '$scope', '$location', 'apiService', 'userService', 'cookieService', function($rootScope, $scope, $location, $apiService, $userService, $cookieService) {
    $rootScope.token = $cookieService.getToken();
    $rootScope.date = new Date();
    $userService.getUser($rootScope.token).success(function(data) {
        $location.path('/home');
        $location.replace();
    });

    $scope.error = $location.search().error;
    $scope.redirect = $location.search().redirect;
    $scope.facebookLink = $apiService.LOGIN_FACEBOOK;

    $scope.check = function() {
        $userService.getUser($scope.token)
            .success(function(data) {
                function callback() {
                    $location.path('/home');
                    $location.replace();
                    $location.search('');
                }

                $cookieService.addToken($scope.token);
                $rootScope.token = $cookieService.getToken();
                callback();
            })
            .error(function(data) {
                alert('Auth Failed');
            })
        ;
    };

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

    $scope.token = $location.search().token;
    if ($scope.token != null) {
        $scope.check();
    }
}]);

app.controller('RegisterController', ['$rootScope', '$scope', '$location', 'apiService', 'userService', 'cookieService', function($rootScope, $scope, $location, $apiService, $userService, $cookieService) {
    $rootScope.token = $cookieService.getToken();
    $rootScope.date = new Date();
    $userService.getUser($rootScope.token).success(function(data) {
        $location.path('/home');
        $location.replace();
    });

    $scope.error = $location.search().error;
    $scope.facebookLink = $apiService.REGISTER_FACEBOOK;

    $scope.register = function() {
        var form = {
            username: $scope.username,
            email: $scope.email,
            password: $scope.password
        };

        $userService.register(form)
            .success(function(data) {
                function callback() {
                    $location.path('/login');
                    $location.replace();
                }

                callback();
            })
            .error(function(data) {
                alert('Register Failed');
            })
        ;
    };
}]);

app.controller('LogoutController', ['$location', 'userService', function($location, $userService) {
    $userService.logout();
    $location.path('/');
    $location.replace();
}]);

app.controller('HomeController', ['$rootScope', '$scope', 'cookieService', 'apiService', 'userService', '$http', '$location', function($rootScope, $scope, $cookieService, $apiService, $userService, $http, $location) {
    $rootScope.token = $cookieService.getToken();
    $userService.getUser($rootScope.token)
    .success(function(data) {
        $rootScope.user = data;
    })
    .error(function(err) {
        function callback() {        
            $location.path('/');
            $location.replace();
        }
    });

    $url = $apiService.NOTIFICATIONS_GET + '?token=' + $rootScope.token;
    $http.get($url).success(function(data) {
        $scope.notifications = data.notifications;
    });
}]);

app.controller('DashboardController', ['$rootScope', '$scope', 'cookieService', 'apiService', 'userService', '$location', '$http', function($rootScope, $scope, $cookieService, $apiService, $userService, $location, $http) {
    $rootScope.token = $cookieService.getToken();
    $userService.getUser($rootScope.token)
    .success(function(data) {
        $rootScope.user = data;
    })
    .error(function(err) {
        $location.path('/');
        $location.replace();
    });

    $scope.error = $location.search().error;
    $scope.redirect = $location.search().redirect;

    $rootScope.facebookLogin = $apiService.ASSOCIATE_FACEBOOK + '/' + $rootScope.token;

    $scope.refresh = function() {
        $http.get($apiService.ACHIEVEMENT_LOAD + '?token=' + $rootScope.token);
    };
}]);

app.controller('MailController', ['$rootScope', 'cookieService', 'userService', '$location', function($rootScope, $cookieService, $userService, $location) {
    $rootScope.token = $cookieService.getToken();
    $userService.getUser($rootScope.token)
    .success(function(data) {
        $rootScope.user = data;
    })
    .error(function(err) {
        $location.path('/');
        $location.replace();
    });
}]);

app.controller('AchievementsController', ['$rootScope', '$scope', 'cookieService', 'apiService', 'userService', '$http', '$location', function($rootScope, $scope, $cookieService, $apiService, $userService, $http, $location) {
    $rootScope.token = $cookieService.getToken();
    $userService.getUser($rootScope.token)
    .success(function(data) {
        $rootScope.user = data;
    })
    .error(function(err) {
        $location.path('/');
        $location.replace();
    });

    $url = $apiService.ACHIEVEMENTS_GET + '?token=' + $rootScope.token;
    $http.get($url).success(function(data) {
        $scope.achievements = data.achievements;
    });
}]);

app.controller('FriendsController', ['$rootScope', 'cookieService', 'userService', '$location', function($rootScope, $cookieService, $userService, $location) {
    $rootScope.token = $cookieService.getToken();
    $userService.getUser($rootScope.token)
    .success(function(data) {
        $rootScope.user = data;
    })
    .error(function(err) {
        $location.path('/');
        $location.replace();
    });
}]);
    
app.controller('CrewController', ['$rootScope', 'cookieService', 'userService', '$location', function($rootScope, $cookieService, $userService, $location) {
    $rootScope.token = $cookieService.getToken();
    $userService.getUser($rootScope.token)
    .success(function(data) {
        $rootScope.user = data;
    })
    .error(function(err) {
        $location.path('/');
        $location.replace();
    });
}]);
