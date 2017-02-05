'use strict';

angular.module('itracker')
    .directive('basecampEvent', ['apiService', function(apiService){
            return {
                restrict: 'C',
                scope: {
                    event: '=',
                },
                templateUrl: apiService.root+'/angular/proj.basecampEvent'
            };
        }]);