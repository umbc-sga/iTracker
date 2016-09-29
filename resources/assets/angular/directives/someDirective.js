'use strict';

angular.module('itracker')
    .directive('someDirective', [()=>{
        return {
            restrict: 'C',
            controller: ['$scope', ($scope) => {
                $scope.now = (new Date()).toUTCString();
            }],
            templateUrl: '/angular/template'
        };
    }]);