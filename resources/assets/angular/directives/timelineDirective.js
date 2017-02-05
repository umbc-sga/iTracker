'use strict';

angular.module('itracker')
    .directive('iTrakertimeline', ['apiService', function(apiService){
        return {
            restrict: 'C',
            scope: {
                timeline: '=',
            },
            controller: ['$scope', function($scope){
                $scope.limit = 5;

                $scope.increaseLimit = () => $scope.limit += 5;
            }],
            templateUrl: apiService.root+'/angular/timeline'
        };
    }]);
