/* 
* @Author: gicque_p
* @Date:   2016-02-05 15:38:58
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-05 17:42:13
*/

app.directive('sidebar', ['$cookies', 'httpResponse', function($cookies) {
    return {
        link: function(scope, elem, attrs) {
            $token = $cookies.get('token');

            scope.url = 'views/sidebar-visitor.html'
            scope.user = {};
            if ($token != null) {
                $datas = {'token': $token};

                httpResponse.post('http://127.0.0.1/~gicque_p/bound/desk/web/app_dev.php/api/token', $datas)
                .success(function(data, status) {
                    scope.url = 'views/sidebar-user.html';
                    scope.user = data;
                })
                .error(function(data, status) {
                    scope.url = 'views/sidebar-visitor.html'
                });
            }
        },

        template: '<div ng-include="url"></div>'
    };
}]);
