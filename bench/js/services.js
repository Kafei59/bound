/* 
* @Author: gicque_p
* @Date:   2016-02-02 13:44:37
* @Last Modified by:   gicque_p
* @Last Modified time: 2016-02-11 17:20:52
*/

app.factory('promiseResponse', function($q) {
    return {
        getPromiseHttpResult: function (httpPromise) {
            var deferred = $q.defer();
            httpPromise.success(function (data) {
                deferred.resolve(data);
            }).error(function () {
                deferred.reject(arguments);
            });

            return deferred.promise;
        }
    }
});

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
