'use strict';

angular.module('itracker')
    .directive('genericError', ['dataService', function(dataService){
        return {
            restrict: 'C',
            scope: {
                error: '@',
                message: '@'
            },
            controller: ['$scope', function($scope){
                $scope.data = dataService.main;

                //$scope.message
                //$scope.error
            }],
            templateUrl: '/angular/error.generic'
        };
    }]);