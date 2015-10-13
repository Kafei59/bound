/* 
* @Author: gicque_p
* @Date:   2015-10-13 16:33:50
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-13 16:58:22
*/

app.factory('showNews', ['$http', function($http) {

    showNews = {};
    showNews.get = function() {
        return $http.get('api/show/toto/tutu/titi');
    };

    return showNews;
}]);
