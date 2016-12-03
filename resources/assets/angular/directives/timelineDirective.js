'use strict';

angular.module('itracker')
    .directive('iTrakertimeline', [function(){
        return {
            restrict: 'C',
            scope: {
                timeline: '=',
            },
            controller: ['$scope', function($scope){
                $scope.limit = 10;

                $scope.increaseLimit = () => $scope.limit += 5;
            }],
            templateUrl: '/angular/timeline'
        };
    }]);
