/* 
* @Author: gicque_p
* @Date:   2015-10-12 13:32:03
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-13 16:57:22
*/

app.controller('MainController', ['$scope', 'showNews', function($scope) {

    showNews.get()
    .success(function(data) {
        $scope.news = data;
    })
    .error(function(err) {
        $scope.status = 'Unable to load news data: ' + err.message;
    });

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
