'use strict';

angular.module('itracker')
    .directive('numberBox', ['apiService', function(apiService){
        return {
            restrict: 'C',
            scope: {
                title: '@',
                color: '@',
                url: '@',
                icon: '@',
                str: '@',
                description: '@'
            },
            templateUrl: apiService.root+'/angular/numberBox'
        };
    }]);
