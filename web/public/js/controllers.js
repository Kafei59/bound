/* 
* @Author: gicque_p
* @Date:   2015-10-23 15:18:42
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-23 15:21:47
*/

app.controller('MainController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {

    httpResponse.get('api/user/all').success(function(data) {
        $scope.users = data;
    })

    httpResponse.get('api/achievement/all').success(function(data) {
        $scope.achievements = data;
    })

    httpResponse.get('api/crew/all').success(function(data) {
        $scope.crews = data;
    })

    httpResponse.get('api/achievement/get/' + $routeParams.salt).success(function(data) {
        $scope.achievement = data;
    })

    $scope.isShow = true;

    $scope.toggleSidebar = function () {
        $scope.isShow = !$scope.isShow;
    }

    $scope.showSidebar = function () {
        $scope.isShow = true;
    }
}]);
