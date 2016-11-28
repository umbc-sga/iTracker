'use strict';

angular.module('itracker')
    .directive('departmentView', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                scope: {
                    department: '='
                },
                controller: ['$scope', ($scope) => {

                }],
                templateUrl: '/angular/departmentView'
            };
        }]);
