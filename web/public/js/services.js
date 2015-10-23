/* 
* @Author: gicque_p
* @Date:   2015-10-23 15:18:47
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-23 15:27:25
*/

app.factory('httpResponse', ['$http', function($http) {

    httpResponse = {};

    httpResponse.get = function(url) {
        return $http.get(url);
    };

    return httpResponse;
}]);
