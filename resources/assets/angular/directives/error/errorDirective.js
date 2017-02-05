'use strict';

angular.module('itracker')
    .directive('genericError', ['dataService', 'apiService', function(dataService, apiService){
        return {
            restrict: 'C',
            scope: {
                error: '@',
                message: '@'
            },
            controller: ['$scope', function($scope){
                $scope.data = dataService.main;
            }],
            templateUrl: apiService.root+'/angular/error.generic'
        };
    }]);