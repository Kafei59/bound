/* 
* @Author: gicque_p
* @Date:   2015-10-12 13:32:03
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-16 13:59:14
*/

app.controller('MainController', ['$scope', 'httpResponse', function($scope) {

    httpResponse.get('api/user/get').success(function(data) {
        $scope.users = data;
    })

    $scope.isShow = true;

    $scope.toggle = function () {
        $scope.isShow = !$scope.isShow;
    }
}]);
