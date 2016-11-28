'use strict';

angular.module('itracker')
    .directive('personView', ['$routeParams', '$log', 'basecampService',
        function($routeParams, $log, basecampService){
            return {
                restrict: 'C',
                scope: {
                    person: '='
                },
                controller: ['$scope', ($scope) => {

                }],
                templateUrl: '/angular/personView'
            };
        }]);
