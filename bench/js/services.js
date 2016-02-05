/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:44:37
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-04 17:34:59
*/

app.factory('httpResponse', ['$http', function($http) {

    httpResponse = {};

    httpResponse.get = function(url) {
        return $http.get(url);
    };

    httpResponse.post = function(url, data) {
        return $http.post(url, data);
    };

    httpResponse.put = function(url, data) {
        return $http.put(url, data);
    };

    httpResponse.delete = function(url) {
        return $http.delete(url);
    };

    return httpResponse;
}]);
