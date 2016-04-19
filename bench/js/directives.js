/* 
* @Author: gicque_p
* @Date:   2016-02-05 15:38:58
* @Last Modified by:   Kafei59
* @Last Modified time: 2016-03-29 16:31:21
*/

app.directive('sidebar', function() {
    return {
        templateUrl: 'views/partials/sidebar.html'
    };
});

app.directive('background', function() {
    return {
        templateUrl: 'views/partials/background.html'
    };
});

app.directive('achievement', function() {
    return {
        templateUrl: 'views/partials/achievement.html'
    };
});
