/* 
* @Author: gicque_p
* @Date:   2015-10-23 15:18:42
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-24 18:41:29
*/

app.controller('MainController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {
    $scope.isShow = true;

    $scope.toggleSidebar = function () {
        $scope.isShow = !$scope.isShow;
    }

    $scope.showSidebar = function () {
        $scope.isShow = true;
    }

    $scope.animateElementIn = function($el) {
        $el.removeClass('hidden');
        $el.addClass('animated fadeIn');
    };
 
    $scope.animateElementOut = function($el) {
        $el.addClass('hidden');
        $el.removeClass('animated fadeIn');
    };
}]);

app.controller('AllAchievementController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {
    httpResponse.get('api/achievement/all').success(function(data) {
        $scope.achievements = data;
    })
}]);

app.controller('GetAchievementController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {
    httpResponse.get('api/achievement/get/' + $routeParams.salt).success(function(data) {
        $scope.achievement = data;
    })
}]);

app.controller('AllCrewController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {
    httpResponse.get('api/crew/all').success(function(data) {
        $scope.crews = data;
    })
}]);

app.controller('GetCrewController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {
    httpResponse.get('api/crew/get/' + $routeParams.salt).success(function(data) {
        $scope.crew = data;
    })
}]);

app.controller('AllUserController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {
    httpResponse.get('api/user/all').success(function(data) {
        $scope.users = data;
    })
}]);

app.controller('GetUserController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {
    httpResponse.get('api/user/get/' + $routeParams.username).success(function(data) {
        $scope.user = data;
    })
}]);

app.controller('FriendsUserController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {
    httpResponse.get('api/user/friends/' + $routeParams.username).success(function(data) {
        $scope.friends = data;
    })
}]);
