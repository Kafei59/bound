/* 
* @Author: gicque_p
* @Date:   2015-10-12 13:24:59
* @Last Modified by:   gicque_p
* @Last Modified time: 2015-10-12 13:49:50
*/

var app = angular.module('BoundApp', []).config(function($interpolateProvider) {
    $interpolateProvider.startSymbol('[[').endSymbol(']]');
});
