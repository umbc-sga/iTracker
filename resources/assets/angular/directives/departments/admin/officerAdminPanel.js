'use strict';

angular.module('itracker')
    .directive('officerAdmin', ['$routeParams', '$log', 'basecampService', 'dataService',
        function($routeParams, $log, basecampService, dataService){
            return {
                restrict: 'C',
                scope: {
                    'permissions': '='
                },
                controller: ['$scope', ($scope) => {

                }],
                templateUrl: '/angular/dept.admin.officerAdmin'
            };
        }]);
