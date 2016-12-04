'use strict';

angular.module('itracker')
    .directive('departmentAdmin', ['$routeParams', '$log', 'basecampService', 'dataService',
        function($routeParams, $log, basecampService, dataService){
            return {
                restrict: 'C',
                scope: {
                    'user': '=',
                    'permissions': '='
                },
                controller: ['$scope', ($scope) => {

                }],
                templateUrl: '/angular/dept.admin.departmentAdmin'
            };
        }]);
