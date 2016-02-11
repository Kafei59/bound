/* 
* @Author: gicque_p
* @Date:   2016-02-05 15:38:58
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-11 17:57:04
*/

app.directive('sidebar', ['$cookies', '$http', 'promiseResponse', function($cookies, $http, promiseResponse) {
    return {
        link: function(scope, elem, attrs) {
            $token = $cookies.get('token');
            $datas = {'token': $token};
                
            promiseResponse.getPromiseHttpResult($http.post('http://127.0.0.1/~gicque_p/bound/desk/web/app_dev.php/api/token', $datas)).then(
                function(result) {
                    scope.url = 'views/sidebar-user.html'
                }, function(error) {
                    scope.url = 'views/sidebar-visitor.html'
                }
            );
        },

        template: '<div ng-include="url"></div>'
    };
}]);

app.directive('background', ['$cookies', '$location', '$http', 'promiseResponse', function($cookies, $location, $http, promiseResponse) {
    return {
        link: function(scope, elem, attrs) {
            $token = $cookies.get('token');
            $datas = {'token': $token};
                
            promiseResponse.getPromiseHttpResult($http.post('http://127.0.0.1/~gicque_p/bound/desk/web/app_dev.php/api/token', $datas)).then(
                function(result) {
                    scope.url2 = '';
                }, function(error) {
                    scope.url2 = 'views/video.html'
                }
            );
        },

        template: '<div ng-include="url2"></div>'
    };
}]);
