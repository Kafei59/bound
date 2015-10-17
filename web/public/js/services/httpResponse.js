/* 
* @Author: gicque_p
* @Date:   2015-10-13 16:33:50
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-13 18:18:09
*/

app.factory('httpResponse', ['$http', function($http) {

    httpResponse = {};

    httpResponse.get = function(url) {
        return $http.get(url);
    };

    return httpResponse;
}]);
