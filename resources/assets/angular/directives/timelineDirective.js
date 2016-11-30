'use strict';

angular.module('itracker')
    .directive('iTrakertimeline', [function(){
        return {
            restrict: 'C',
            scope: {
                timeline: '=',
            },
            templateUrl: '/angular/timeline'
        };
    }]);
