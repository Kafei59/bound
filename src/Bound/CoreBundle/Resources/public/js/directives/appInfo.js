/* 
* @Author: gicque_p
* @Date:   2015-10-12 13:29:59
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-12 13:54:23
*/

app.directive('appInfo', function() {
    return {
        restrict: 'E',
        scope: {
            info: '='
        },
        templateUrl: 'views/appInfo.html.twig'
    };
});
