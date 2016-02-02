/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:42:51
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-02 15:18:33
*/

app.controller('MainController', ['$scope', '$routeParams', 'httpResponse', function($scope, $routeParams) {

    var datas = {'username': "Kafei", 'password': "toto"};

    $scope.token = {};
    httpResponse.post('http://127.0.0.1/~gicque_p/bound/desk/web/app_dev.php/api/login', datas).success(function(data, status) {
        $scope.token = data;
    })

    $scope.achievements = {};
    httpResponse.get('http://127.0.0.1/~gicque_p/bound/desk/web/app_dev.php/api/achievements?token=-IqzP-9yp0p2i6mVDuOwut8ZNVqqeBr33OAMbNk8-nY').success(function(data, status) {
        $scope.achievements = data;
    })

}]);
