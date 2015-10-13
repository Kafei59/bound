/* 
* @Author: gicque_p
* @Date:   2015-10-12 13:32:03
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-13 18:29:24
*/

app.controller('MainController', ['$scope', 'httpResponse', function($scope) {

    httpResponse.get('api/user/get').success(function(data) {
        $scope.users = data;
    })

    $scope.apps = [
        {
          icon: 'img/move.jpg',
          title: 'MOVE',
          developer: 'MOVE, Inc.',
          price: 0.99
        },
        {
          icon: 'img/shutterbugg.jpg',
          title: 'Shutterbugg',
          developer: 'Chico Dusty',
          price: 2.99
        },
        {
          icon: 'img/gameboard.jpg',
          title: 'Gameboard',
          developer: 'Armando P.',
          price: 1.99
        },
        {
          icon: 'img/forecast.jpg',
          title: 'Forecast',
          developer: 'Forecast',
          price: 1.99

        }
    ];
}]);
